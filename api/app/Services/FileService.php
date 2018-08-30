<?php

namespace App\Services;

use App\Services\Memcache\Memcache;
use App\Models\Images;
use App\Models\User;

class FileService extends Service {

    /**
     * @var User
     */
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    /**
     * Metodo que retorna a url do arquivo
     *
     * @author Ana Carvalho
     * @param Images $arquivo
     * @return String|null
     * @throws \Exception
     */
    public function retornarUrlFile($arquivo)
    {
        if (!$arquivo)
            throw new \Exception("Arquivo não informado");
        try {
            //Verifica se o registro tem um bucket, caso tenha busca o arquivo na amazon
            if (!$arquivo->BucketAmazon) {
                $arquivo->BucketAmazon = env('imagenspedidos');
            }

            $memcache = new Memcache();
            $urlApi = 'http://' . \Illuminate\Support\Facades\Request::getHttpHost();
            if (!$memcache->get($arquivo->Id)) {
                $amazonKey = preg_match("/({$arquivo->NomeArquivado})$/", $arquivo->Path) ? $arquivo->Path : $arquivo->Path . '/' . $arquivo->NomeArquivado;
                $imagem = $this->recuperarArquivoWS($amazonKey, $arquivo->BucketAmazon);
                $memcache->set($arquivo->Id, $imagem, MEMCACHE_COMPRESSED, $memcache->expiraCache());
            }

            return $urlApi . '/Livre/retornar-arquivo-memcache/' . $arquivo->Id;
        } catch (\Exception $e) {
            return null;
        }

    }

    /**
     * Metodo que retorna a url do arquivo THUMB
     *
     * @author Ana Carvalho
     * @param Arquivos $arquivo
     * @return String|null
     * @throws \Exception
     */
    public function retornarUrlThumbFile($arquivo)
    {
        if (!$arquivo)
            throw new \Exception("Arquivo não informado");
        try {
            //Verifica se o registro tem um bucket, caso tenha busca o arquivo na amazon
            if (!$arquivo->BucketAmazon) {
                $arquivo->BucketAmazon = env('imagenspedidos');
            }

            $memcache = new Memcache();
            $urlApi = 'http://' . \Illuminate\Support\Facades\Request::getHttpHost();

            if (!$memcache->get('thumb_'.$arquivo->Id)) {
                $amazonKeyFile = preg_match("/({$arquivo->NomeArquivado})$/", $arquivo->Path) ? $arquivo->Path : $arquivo->Path . '/' . $arquivo->NomeArquivado;
                $nomePastaThumb = $arquivo->BucketAmazon == "imagensclientes" || $arquivo->BucketAmazon == "caixacrescertestes" ? "thumb/" : "Thumbnail/";
                $amazonKey = str_replace($arquivo->NomeArquivado, $nomePastaThumb . $arquivo->NomeArquivado, $amazonKeyFile);
                $imagem = $this->recuperarArquivoWS($amazonKey, $arquivo->BucketAmazon);
                if(!$imagem){
                    throw new \Exception("Imagem não encontrada");
                }
                $memcache->set('thumb_' . $arquivo['Id'], $imagem, MEMCACHE_COMPRESSED, $memcache->expiraCache());
            }

            return $urlApi . '/Livre/retornar-arquivo-memcache/thumb_' . $arquivo->Id;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Metodo que retorna a base64 do arquivo que esta no S3 da amazon
     *
     * @author Ana Carvalho
     * @param Arquivos $arquivo
     * @return String Base64|null
     */
    public function recuperarArquivoWS($key, $bucket)
    {
        try {
            $image = null;
            $s3 = \AWS::createClient('s3');
            $object = $s3->getObject(array(
                'Bucket' => $bucket,
                'Key' => $key
            ));

            $imagemContent = base64_encode((string)$object['Body']);

            if (mb_strlen($imagemContent) > 1024) {
                $manager = new \Intervention\Image\ImageManager();
                $img = $manager->make((string)$object['Body'])
                    ->widen(1024)
                    ->encode('data-url');
                $image = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $img));
            }

            return $image;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * SEMPRE CHAMAR ESSE METODO DENTRO DE UM TRY-CATCH e COM TRANSACTION
     * Salva o objeto na tabela de arquivos e salva na AMAZON. Retorna o objeto arquivo para vincular onde quiser.
     * @param $arquivo
     * @param null $alternativePath
     * @return Arquivos
     * @throws \Exception
     */
    public function salvar($arquivo, $alternativePath = null){
        try {
            $cliente = Clientes::find($arquivo['IdCliente']);

            if (!$cliente)
                throw new \Exception("Cliente não encontrado");

            $arquivoObj = new Arquivos();
            $arquivoObj->fill($arquivo);
            $arquivoObj->NomeArquivado = md5($arquivo['IdCliente'] . date("YmDHisu") . uniqid()) . ".jpg";
            $arquivoObj->Path = $alternativePath ? $alternativePath . "/" . $arquivoObj->NomeArquivado : $arquivoObj->IdCliente . "/" . $arquivoObj->NomeArquivado;
            $arquivoObj->save();
            $this->uploadArquivoBase64AWS($arquivoObj, $arquivo['Base64']);
            if(!empty($arquivo['Exif'])){
                $this->salvarExif($arquivoObj, $arquivo['Exif']);
            }

            return $arquivoObj;
        }catch (\Exception $e){

            throw $e;
        }
    }

    /**
     * @param array|Arquivos $arquivo
     * @param $base64
     * @return Arquivos
     * @throws \Exception
     * @internal param null $alternativePath
     */
    public function uploadArquivoBase64AWS(Arquivos $arquivo, $base64)
    {
        $filePath = storage_path('app/public') . "/" . $arquivo->NomeArquivado;
        try {
            $manager = new \Intervention\Image\ImageManager();
            $manager->make($base64)
                ->widen(1024)
                ->save($filePath, 80);

            $s3 = \AWS::createClient('s3');
            $amazonResult = $s3->putObject(array(
                'Bucket' => $arquivo->BucketAmazon,
                'Key' => $arquivo->Path,
                'SourceFile' => $filePath
            ));

            $this->gerarThumb($arquivo, $filePath);

            //verifica se o arquivos existe no local onde foi salvo e o remove da pasta
            if (file_exists($filePath))
                unlink($filePath);

            return $amazonResult;
        } catch (\Exception $e) {
            //verifica se o arquivos existe no local onde foi salvo e o remove da pasta
            if (file_exists($filePath))
                unlink($filePath);

            throw $e;
        }

    }

    /**
     * @param Arquivos $arquivo
     * @param $file (arquivo salvo localmente temporariamente)
     * @return mixed
     * @throws \Exception
     * @internal param null $alternativePath
     */
    public function gerarThumb(Arquivos $arquivo, $file)
    {
        try {
            $manager = new \Intervention\Image\ImageManager();
            $img = $manager->make($file)
                ->fit(200, 200)
                ->encode('data-url');

            $pathThumb = 'Thumbnail';
            if ($arquivo->BucketAmazon == "imagensclientes" || $arquivo->BucketAmazon == "caixacrescertestes") {
                $pathThumb = 'thumb';
            }

            $pathInfo = pathinfo($arquivo->Path);
            $s3 = \AWS::createClient('s3');
            $amazonResult = $s3->putObject(array(
                'Bucket' => $arquivo->BucketAmazon,
                'Key' => $pathInfo['dirname'] . "/".$pathThumb."/".$pathInfo['basename'],
                'Body' => base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $img))
            ));

            return $amazonResult;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $arquivo
     * @param $data
     * EX:  {
     * Marca: resultExif.Make ? resultExif.Make.replace(expression, '').trim() : null,
     * Modelo: resultExif.Model ? resultExif.Model.replace(expression, '').trim() : null,
     * Software: resultExif.Software ? resultExif.Software.replace(expression, '').trim() : null,
     * Altitude: resultExif.GPSAltitude ? resultExif.GPSAltitude.numerator : null,
     * Data: resultExif.DateTime ? resultExif.DateTime : null,
     * Dataoriginal: resultExif.DateTimeOriginal ? resultExif.DateTimeOriginal : null,
     * Longitude: ImagemService.exifGPSPositionDecimal(resultExif.GPSLongitude, resultExif.GPSLongitudeRef),
     * Latitude: ImagemService.exifGPSPositionDecimal(resultExif.GPSLatitude, resultExif.GPSLatitudeRef)
     * }
     * @return ArquivoExif
     * @throws \Exception
     */
    public function salvarExif($arquivo, $data)
    {
        try {
            $arquivoExif = new ArquivoExif();
            $arquivoExif->fill($data);
            $arquivoExif->IdArquivo = $arquivo->Id;
            $arquivoExif->save();

            return $arquivoExif;

        } catch (\Exception $e) {
            throw $e;
        }
    }

}