<?php

namespace App\Http\Controllers;

use App\Models\OrderType;
use Illuminate\Http\Request;
use Validator;

class OrderTypeController extends Controller
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

        $orderTypes = OrderType::query();

        if(!empty($data['with'])){
            $orderTypes->with($data['with']);
        }
        if(!empty($data['id'])){
            $orderTypes->where('id', '=', $data['id']);
        }

        if(!empty($data['name'])){
            $orderTypes->where('name','LIKE',"%{$data['name']}%");
        }

        if(!empty($data['active'])){
            $orderTypes->where('active','=', $data['active']);
        }

        if(!empty($data['description'])){
            $orderTypes->where('description','LIKE',"%{$data['description']}%");
        }

        if(!empty($data['order_by'])){
            $direction = 'asc';
            if(!empty($data['order_by_direction'])){
                $direction = $data['order_by_direction'];
            }
            $orderTypes->orderBy($data['orderBy'], $direction);
        }

        $orderTypes = $orderTypes->paginate($this->perPage, ['*'], 'page', $this->page);
        return response([
            'status' => 'success',
            'data' => $orderTypes
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
                'description' => 'required',
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag(), 412);
            }

            $orderType = new OrderType();
            $orderType->fill($request->all());
            $orderType->save();

            return response([
                'status' => 'success',
                'data' => $orderType
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode());
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
        $orderType = OrderType::find($id);
        return response([
            'status' => 'success',
            'data' => $orderType
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
            $orderType = OrderType::query()->find($id);

            if(!$orderType)
                throw new \Exception("Nenhum tipo de pedido encontrado.", 412);

            $validator = Validator::make($request->all(), [
                'description' => 'required',
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag(), 412);
            }

            $orderType->fill($request->all());
            $orderType->save();

            return response([
                'status' => 'success',
                'data' => $orderType
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
            $orderType = OrderType::query()->find($id);

            if(!$orderType)
                throw new \Exception("Nenhum tipo de pedido encontrado.", 412);

            $orderType->active = 0;
            $orderType->save();

            return response([
                'status' => 'success',
                'data' => $orderType
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
