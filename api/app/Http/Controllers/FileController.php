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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(){
        DB::beginTransaction();
        try {
            dd(File::find(21)->toArray());
            $data = collect(request()->all());

            validate($data->toArray(), [
                'file' => 'required',
                'path' => 'required',
            ],[
                'file' => 'Favor informar o arquivo.',
                'path' => 'Favor informar o path do arquivo.'
            ]);

            $fileService = new FileService();
            $file = $fileService->salvar($data->get('file'), $data->get('path'), $data->get('file_type_id'));

            $fileService->uploadImageByBinary($data->get('file'), $file);

            DB::commit();
            return response([
                'status' => 'success',
                'data' => $file
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
