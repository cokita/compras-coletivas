<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Validator;

class OrderStatusController extends Controller
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

        $orderStatus = OrderStatus::query();

        if(!empty($data['with'])){
            $orderStatus->with($data['with']);
        }
        if(!empty($data['id'])){
            $orderStatus->where('id', '=', $data['id']);
        }

        if(!empty($data['name'])){
            $orderStatus->where('name','LIKE',"%{$data['name']}%");
        }

        if(!empty($data['active'])){
            $orderStatus->where('active','=', $data['active']);
        }

        if(!empty($data['description'])){
            $orderStatus->where('description','LIKE',"%{$data['description']}%");
        }

        if(!empty($data['order_by'])){
            $direction = 'asc';
            if(!empty($data['order_by_direction'])){
                $direction = $data['order_by_direction'];
            }
            $orderStatus->orderBy($data['orderBy'], $direction);
        }

        $orderStatus = $orderStatus->paginate($this->perPage, ['*'], 'page', $this->page);
        return response([
            'status' => 'success',
            'data' => $orderStatus
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

            $orderStatus = new OrderStatus();
            $orderStatus->fill($request->all());
            $orderStatus->save();

            return response([
                'status' => 'success',
                'data' => $orderStatus
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
        $orderStatus = OrderStatus::find($id);
        return response([
            'status' => 'success',
            'data' => $orderStatus
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
        try {
            $orderStatus = OrderStatus::query()->find($id);

            if(!$orderStatus)
                throw new \Exception("Nenhum status encontrado.", 412);

            $orderStatus->active = 0;
            $orderStatus->save();

            return response([
                'status' => 'success',
                'data' => $orderStatus
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode() ? $e->getCode() : 400);
        }
    }
}
