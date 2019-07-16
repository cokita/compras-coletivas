<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Método para salvar o arquivo e enviar para AMAZON!
     * @param Request $request
     * {
    "base_64":"data:image/jpeg;base64,...",
    "BucketAmazon":"caixacrescertestes",
    "IdTipoArquivo":20,
    "MimeType":"image/jpeg",
    "NomeOriginal":"nutella.jpg",
    "HashBase64Length":63051
    }
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        DB::beginTransaction();
        try {
            //Verifica se o tamanho do hash base64 da imagem é do tamanho que foi postada
            if (strlen($request->get("Base64")) != $request->get("HashBase64Length")) {
                throw new \Exception("Erro ao verificar o hash base 64 da imagem, tamanho do hash não confere.");
            }

            $fileService = new FileService(Auth::user());
            $result = $fileService->salvar($request->all());

            DB::commit();
            return response([
                'status' => 'success',
                'data' => $result
            ]);

        }catch (\Exception $e){
            DB::rollBack();
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode() ? $e->getCode() : 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fileService = new FileService(Auth::user());
        $fileService->recuperarArquivoWS();

        $file = File::find($id);
        return response([
            'status' => 'success',
            'data' => $file
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
