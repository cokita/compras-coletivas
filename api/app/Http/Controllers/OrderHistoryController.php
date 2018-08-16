<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use App\Models\Orders;
use App\Services\UserService;
use Illuminate\Http\Request;
use Validator;

class OrderHistoryController extends Controller
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

        $orderHistory = OrderHistory::query();

        if(!empty($data['with'])){
            $orderHistory->with($data['with']);
        }
        if(!empty($data['id'])){
            $orderHistory->where('id', '=', $data['id']);
        }

        if(!empty($data['order_id'])){
            $orderHistory->where('order_id', '=', $data['order_id']);
        }

        if(!empty($data['order_status_id'])){
            $orderHistory->where('order_status_id', '=', $data['order_status_id']);
        }

        if(!empty($data['active'])){
            $orderHistory->where('active','=', $data['active']);
        }

        if(!empty($data['observation'])){
            $orderHistory->where('observation','LIKE',"%{$data['observation']}%");
        }

        if(!empty($data['status_limit_date'])){
            $orderHistory->where('status_limit_date','=', $data['status_limit_date']);
        }

        if(!empty($data['tracking_code'])){
            $orderHistory->where('tracking_code','=', $data['tracking_code']);
        }

        if(!empty($data['order_by'])){
            $direction = 'asc';
            if(!empty($data['order_by_direction'])){
                $direction = $data['order_by_direction'];
            }
            $orderHistory->orderBy($data['orderBy'], $direction);
        }

        $orderHistory = $orderHistory->paginate($this->perPage, ['*'], 'page', $this->page);
        return response([
            'status' => 'success',
            'data' => $orderHistory
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
            $user = Auth::user();
            $validator = Validator::make($request->all(), [
                'order_status_id' => 'required|int',
                'order_id' => 'required|int'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag(), 412);
            }

            $order = Orders::find($request->get('order_id'));

            if(!$order)
                throw new \Exception("Pedido não encontrado.", 412);

            if($order->store->user_id != $user->id || !$user->hasProfile('Administrador'))
                throw new \Exception("Apenas a dona do grupo pode alterar o status do pedido/compra.");


            $orderHistory = new OrderHistory();
            $orderHistory->fill($request->all());
            $orderHistory->save();

            $order->order_status_id = $orderHistory->id;
            $order->save();

            return response([
                'status' => 'success',
                'data' => $orderHistory
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
        $orders = OrderHistory::find($id);
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
        //
    }
}
