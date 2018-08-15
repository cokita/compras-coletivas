<?php

namespace App\Http\Controllers;

use App\Constants\ConstStatus;
use App\Models\OrderHistory;
use App\Models\Orders;
use App\Models\Stores;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
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

        $orders = Orders::query();

        if(!empty($data['with'])){
            $orders->with($data['with']);
        }
        if(!empty($data['id'])){
            $orders->where('id', '=', $data['id']);
        }

        if(!empty($data['name'])){
            $orders->where('name','LIKE',"%{$data['name']}%");
        }

        if(!empty($data['active'])){
            $orders->where('active','=', $data['active']);
        }

        if(!empty($data['store_id'])){
            $orders->where('store_id','=', $data['store_id']);
        }

        if(!empty($data['order_type_id'])){
            $orders->where('order_type_id','=', $data['order_type_id']);
        }

        if(!empty($data['order_history_id'])){
            $orders->where('order_history_id','=', $data['order_history_id']);
        }

        if(!empty($data['description'])){
            $orders->where('description','LIKE',"%{$data['description']}%");
        }

        if(!empty($data['order_by'])){
            $direction = 'asc';
            if(!empty($data['order_by_direction'])){
                $direction = $data['order_by_direction'];
            }
            $orders->orderBy($data['orderBy'], $direction);
        }

        $orders = $orders->paginate($this->perPage, ['*'], 'page', $this->page);
        return response([
            'status' => 'success',
            'data' => $orders
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
                'order_type_id' => 'required',
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag(), 412);
            }

            $user = Auth::user();
            if(!$user->store)
                throw new \Exception("Nenhum grupo encontrada para esse usuário.");

            $store = Stores::find($user->store->id);

            if(!$store || $store->active != 1)
                throw new \Exception("Grupo vinculado ao vendedor não encontrado!", 412);

            $order = new Orders();
            $order->fill($request->all());
            $order->store_id = $store->id;
            $order->save();
            $orderHistory = new OrderHistory();
            $orderHistory->order_status_id = ConstStatus::EM_PREPARACAO;
            $orderHistory->observation = "Pedido em preparação.";
            $orderHistory->order()->associate($order)->save();

            $order->order_history_id = $orderHistory->id;
            $order->save();

            return response([
                'status' => 'success',
                'data' => $store
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
        $orders = Orders::find($id);
        return response([
            'status' => 'success',
            'data' => $orders
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

            $order = Orders::find($id);
            if($order){
                $order->active = 0;
                $order->save();
            }

            return response([
                'status' => 'success',
                'data' => $order
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
