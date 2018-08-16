<?php

namespace App\Http\Controllers;

use App\Models\Stores;
use App\Models\StoresUsers;
use App\Models\User;
use Illuminate\Http\Request;

class StoreUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = request()->all();
        $storeUser = null;
        if(!empty($data['id'])){
            $storeUser = StoresUsers::query();
            $storeUser->where('id', '=', $data['id']);
        }else{
            if(!empty($data['user_id'])){
                $storeUser = User::find($data['user_id'])->stores()->orderBy('name');

            }else if(!empty($data['store_id'])){
                $storeUser = Stores::find($data['store_id'])->users()->orderBy('name');
            }
        }
         if($storeUser){
            $storeUser = $storeUser->paginate();
         }

        return response([
            'status' => 'success',
            'data' => $storeUser
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            if(empty($data['users'])){
                throw new \Exception("Favor informar quais usuários integrarão o grupo.", 412);
            }

            if(empty($data['store_id'])){
                throw new \Exception("Favor informar um grupo para adicionar usuários.", 412);
            }

            $store = Stores::find($data['store_id']);

            if(!$store || $store->active != 1){
                throw new \Exception("Grupo não encontrado!", 412);
            }

            if(is_array($data['users']) && $data['users']){
                $users = User::query()->whereIn('id', $data['users'])->where('active', '=',1)->get();
                if($users){
                    foreach ($users as $user){
                        $storeUserDb = StoresUsers::query()->where('user_id','=', $user->id)->where('store_id','=', $store->id)->first();
                        if(!$storeUserDb) {
                            $storeUser = new StoresUsers();
                            $storeUser->user_id = $user->id;
                            $storeUser->store_id = $store->id;
                            $storeUser->save();
                        }
                    }
                }
            }

            return response([
                'status' => 'success',
                'data' => array()
            ]);

        }catch (\Exception $e){
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
        try {
            $data = $request->all();
            if(empty($data['users_add']) && empty($data['users_rm'])){
                throw new \Exception("Favor informar quais usuários deseja adicionar ou remover do grupo.", 412);
            }

            if(!empty($data['store_id'])){
                throw new \Exception("Favor informar um grupo para adicionar usuários.", 412);
            }

            $store = Stores::find($data['store_id']);

            if(!$store || $store->active != 1){
                throw new \Exception("Grupo não encontrado!", 412);
            }

            if(is_array($data['users_add']) && $data['users_add']){
                $users = User::query()->whereIn('id', implode(',', $data['users_add']))->where('active', '=',1)->get();
                if($users){
                    foreach ($users as $user){
                        $storeUser = StoresUsers::query()
                            ->where('user_id','=', $user->id)
                            ->where('store_id', '=',$store->id)
                            ->first();

                        if(!$storeUser) {
                            $storeUser = new StoresUsers();
                            $storeUser->user_id = $user->id;
                            $storeUser->store_id = $store->id;
                            $storeUser->save();
                        }
                    }
                }
            }

            if(is_array($data['users_rm']) && $data['users_rm']){
                foreach ($data['users_rm'] as $userRm){
                    $storeUser = StoresUsers::query()
                        ->where('user_id','=', $userRm)
                        ->where('store_id', '=',$store->id)
                        ->first();

                    if($storeUser) {
                        $storeUser->delete();
                    }
                }
            }

            return response([
                'status' => 'success',
                'data' => array()
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
    public function destroy($user_id, $store_id)
    {
        try {
            $store = Stores::find($store_id);

            if(!$store || $store->active != 1){
                throw new \Exception("Grupo não encontrado!", 412);
            }

            $user = User::find($user_id);

            if(!$user || $user->active != 1){
                throw new \Exception("Usuário não encontrado!", 412);
            }

            $storeUser = StoresUsers::query()
                ->where('user_id', '=', $user->id)
                ->where('store_id', '=', $store->id)
                ->first();

            if($storeUser){
                $storeUser->delete();
            }

            return response([
                'status' => 'success',
                'data' => array()
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode() ? $e->getCode() : 400);
        }
    }
}
