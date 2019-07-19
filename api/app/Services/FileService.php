<?php

namespace App\Services;

use App\Constants\ConstFileType;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class FileService extends Service {

    public function __construct()
    {
    }

    /**
     * @param $file UploadedFile
     * @param $path
     * @param int $idFileType
     */
    public function salvar($file, $path, $idFileType=null)
    {
        $nomeImg = md5(date("YmDHisu") . uniqid()) . "." . $file->getClientOriginalExtension();
        if(substr($path, -1) !== '/')
            $path = $path.'/';

        if(!$idFileType)
            $idFileType = ConstFileType::IMAGE;

        $fileObj = new File();
        $fileObj->name = $file->getClientOriginalName();
        $fileObj->unique_name = $nomeImg;
        $fileObj->path = $path.$nomeImg;
        $fileObj->bucket_amazon = env('AWS_BUCKET');
        $fileObj->user_id = auth()->user()->id;
        $fileObj->file_type_id = $idFileType;
        $fileObj->save();

        return $fileObj;
    }


    public function retornarUrlFile($file)
    {
        try {
            if (!$file)
                throw new \Exception("Arquivo não informado");
            return $this->gerarUrlPublica($file->path);
        } catch (\Exception $e) {
            return null;
        }

    }

    public function retornarUrlThumbFile($file)
    {
        try {
            if (!$file)
                throw new \Exception("Arquivo não informado");

            return $this->gerarUrlPublica(dirname($file->path) . "/thumb/" . basename($file->path));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function gerarUrlPublica($path, $lifeTime='1440')
    {
        //Cache::forget($path);
        $pathCach = Cache::get($path);

        if(!$pathCach){
            $s3 = Storage::disk('s3');
            $client = $s3->getDriver()->getAdapter()->getAdapter()->getClient();

            $command = $client->getCommand('GetObject', [
                'Bucket' => env('AWS_BUCKET'),
                'Key' => $path
            ]);

            $request = $client->createPresignedRequest($command, "+{$lifeTime} minutes");

            Cache::put($path, (string)$request->getUri(), $lifeTime);
            $pathCach = Cache::get($path);
        }

        return $pathCach;
    }

    /**
     * @param $file UploadedFile
     * @param $arquivo File
     */
    public function uploadImageByBinary($file, $arquivo)
    {
        try {
            $file->storeAs(dirname($arquivo->path), basename($arquivo->path), 's3');

            $this->gerarThumb($file, $arquivo);

            return $arquivo;

        } catch (\Exception $e) {
            dd($e->getMessage());
            throw $e;
        }
    }

    public function gerarThumb($pathOrBinary, $arquivo)
    {
        try {
            $manager = new ImageManager();
            $path = storage_path('app/public').'/'.basename($arquivo->path);
            $img = $manager->make($pathOrBinary)
                ->fit(200, 200)
                ->save($path, 90);
            $key = dirname($arquivo->path) . "/thumb/" . basename($arquivo->path);

            Storage::disk('s3')->put($key, file_get_contents($path));

            if (file_exists($path))
                unlink($path);

            return $arquivo;

        } catch (\Exception $e) {
            throw $e;
        }

    }



}