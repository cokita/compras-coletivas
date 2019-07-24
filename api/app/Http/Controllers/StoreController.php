<?php

namespace App\Http\Controllers;

use App\Models\Stores;
use App\Models\StoresUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = request()->all();

        if(!empty($data['per_page'])){
            $this->perPage = $data['per_page'];
        }

        if(!empty($data['page'])){
            $this->page = $data['page'];
        }

        $stores = Stores::query();

        if(!empty($data['with'])){
            $stores->with($data['with']);
        }
        if(!empty($data['id'])){
            $stores->where('id', '=', $data['id']);
        }

        if(!empty($data['name'])){
            $stores->where('name','LIKE',"%{$data['name']}%");
        }

        if(!empty($data['active'])){
            $stores->where('active','=', $data['active']);
        }

        if(!empty($data['user_id'])){
            $stores->where('user_id','=', $data['user_id']);
        }

        if(!empty($data['description'])){
            $stores->where('description','LIKE',"%{$data['description']}%");
        }


        $stores = $stores->paginate($this->perPage, ['*'], 'page', $this->page);
        return response([
            'status' => 'success',
            'data' => $stores
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
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:stores',
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag(), 412);
            }

            $user_id = $request->get('user_id');
            $seller = User::find($user_id);

            if(!$seller || $seller->active != 1)
                throw new \Exception("Vendedor não encontrado!", 412);

            $isSeller = $seller->hasProfile('vendedor');

            if(!$isSeller)
                throw new \Exception("O usuário informado não é um VENDEDOR, os grupos podem ser vinculados apenas a vendedores!", 412);

            $store = new Stores();
            $store->fill($request->all());
            $store->save();

            return response([
                'status' => 'success',
                'data' => $store
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
        $store = Stores::find($id);
        return response([
            'status' => 'success',
            'data' => $store
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
            $user_id = $request->get('user_id');
            if($user_id){
                $user_id = $request->get('user_id');
                $seller = User::find($user_id);

                if(!$seller || $seller->active != 1)
                    throw new \Exception("Vendedor não encontrado!", 412);

                $isSeller = $seller->hasProfile('vendedor');

                if(!$isSeller)
                    throw new \Exception("O usuário informado não é um VENDEDOR, os grupos podem ser vinculados apenas a vendedores!", 412);
            }

            $store = Stores::find($id);
            if (!$store)
                throw new \Exception("Grupo não encontrado!", 412);

            $store->fill($request->all());
            $store->save();

            return response([
                'status' => 'success',
                'data' => $store
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
            $store = Stores::find($id);
            if (!$store)
                throw new \Exception("Grupo não encontrado!", 412);

            $store->active = 0;
            $store->save();

            return response([
                'status' => 'success',
                'data' => $store
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode() ? $e->getCode() : 400);
        }
    }

    public function myStores()
    {
        try {
            $user = Auth::user();
//            $groups = Stores::query()
//                ->select(['stores.name as group', 'stores.description as group_description',
//                    'files.path as image_url','files2.path as file_url',
//                    'own.name as owner', 'own.email as owners_email', 'own.cellphone as owners_cellphone'])
//                ->join('users as own', 'own.id', '=', 'stores.user_id')
//                ->join('stores_users', 'stores_users.store_id', '=', 'stores.id')
//                ->join('users', 'users.id', '=', 'stores_users.user_id')
//                ->leftJoin('files', 'files.id', '=', 'stores.image_id')
//                ->leftJoin('files as files2', 'files2.id', '=', 'stores.file_id')
//                ->where('stores.active', '=', 1)
//                ->where('users.id', '=', $user->id)
//                ->get();

            $userId = $user->id;
            $groups = Stores::query()->with(['user','image', 'users' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])->get();


            return response([
                'status' => 'success',
                'data' => $groups
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode() ? $e->getCode() : 400);
        }
    }
}
