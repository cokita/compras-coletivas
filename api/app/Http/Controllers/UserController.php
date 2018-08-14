<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = request()->all();
        $user = User::query();

        if(isset($data['id'])){
            $user->where('id', '=', $data['id']);
        }

        if(isset($data['name'])){
            $user->where('name','LIKE',"%{$data['name']}%");
        }

        if(isset($data['email'])){
            $user->where('email','=', $data['email']);
        }

        if(isset($data['cpf'])){
            $user->where('cpf','=', $data['cpf']);
        }

        if(isset($data['gender'])){
            $user->where('gender','=', $data['gender']);
        }

        if(isset($data['active'])){
            $user->where('active','=', $data['active']);
        }

        if(isset($data['cellphone'])){
            $user->where('cellphone','=', $data['cellphone']);
        }

        $user = $user->paginate();
        return response([
            'status' => 'success',
            'data' => $user
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
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
        try {
            $user = User::find($id);
            if (!$user)
                throw new \Exception("Usuário não encontrado!", 412);

            $user->fill($request->all());
            $user->save();

            return response([
                'status' => 'success',
                'data' => $user
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (!$user)
                throw new \Exception("Usuário não encontrado!", 412);

            $user->active = 0;
            $user->save();

            return response([
                'status' => 'success',
                'data' => $user
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
