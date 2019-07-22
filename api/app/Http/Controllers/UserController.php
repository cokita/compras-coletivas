<?php

namespace App\Http\Controllers;

use App\Constants\ConstProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


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
            ], $e->getCode() ? $e->getCode() : 400);
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
            ], $e->getCode() ? $e->getCode() : 400);
        }
    }

    /**
     * Object
     * {
     *      "email": "andrevini@gmail.com",
     *      "name" : "André Vinicius da Silva Caixeta",
     *      "password": "abcd1234",
     *      "cellphone": "61998280155",
     *      "cpf": "00713877146",
     *      "birthday": "1985-07-13"
     *   }
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            validate($request->all(), [
                'email' => 'required|unique:users',
                'name' => 'required',
                'password' => 'required',
                'cellphone' => 'required|unique:users',
                'cpf' => 'required|unique:users|cpf'
            ]);

            $user = new User;
            $user->email = $request->email;
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->cellphone = $request->cellphone;
            $user->cpf = $request->cpf;
            $user->birthday = $request->birthday;
            if ($request->gender) {
                $user->gender = $request->gender;
            }
            $user->save();
            $user->profiles()->attach(ConstProfile::USUARIO);

            DB::commit();
            return response([
                'status' => 'success',
                'data' => $user
            ], 200);
        }catch (\Exception $e){
            DB::rollBack();
            return response(['status' => 'error', 'message' => $e->getMessage(), 'code' => $e->getCode() ? $e->getCode() : 400], $e->getCode() ? $e->getCode() : 400);
        }
    }
}
