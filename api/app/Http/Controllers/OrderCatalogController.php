<?php

namespace App\Http\Controllers;

use App\Models\OrderCatalog;
use App\Models\Orders;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class OrderCatalogController extends Controller
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

        $orderCatalog = OrderCatalog::query();

        if(!empty($data['with'])){
            $orderCatalog->with($data['with']);
        }
        if(!empty($data['id'])){
            $orderCatalog->where('id', '=', $data['id']);
        }

        if(!empty($data['active'])){
            $orderCatalog->where('active','=', $data['active']);
        }

        if(!empty($data['order_id'])){
            $orderCatalog->where('order_id','=', $data['order_id']);
        }

        if(!empty($data['user_id'])){
            $orderCatalog->where('user_id','=', $data['user_id']);
        }

        if(!empty($data['quantity'])){
            $orderCatalog->where('quantity','=', $data['quantity']);
        }

        if(!empty($data['model'])){
            $orderCatalog->where('model','LIKE',"%{$data['model']}%");
        }

        if(!empty($data['size'])){
            $orderCatalog->where('size','LIKE',"%{$data['size']}%");
        }


        if(!empty($data['order_by'])){
            $direction = 'asc';
            if(!empty($data['order_by_direction'])){
                $direction = $data['order_by_direction'];
            }
            $orderCatalog->orderBy($data['orderBy'], $direction);
        }

        $orderCatalog = $orderCatalog->paginate($this->perPage, ['*'], 'page', $this->page);
        return response([
            'status' => 'success',
            'data' => $orderCatalog
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
                'order_id' => 'required',
                'model' => 'required',
                'size' => 'required',
                'quantity' => 'required|integer',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag(), 412);
            }

            $user = Auth::user();

            $order = Orders::find($request->get('order_id'));

            if(!$order || $order->active != 1)
                throw new \Exception("Pedido não encontrado!", 412);

            $orderCatalog = new OrderCatalog();
            $orderCatalog->fill($request->all());
            $orderCatalog->order_id = $order->id;
            $orderCatalog->user_id = $user->id;
            $orderCatalog->save();

            return response([
                'status' => 'success',
                'data' => $orderCatalog
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
        $orderCatalog = OrderCatalog::find($id);
        return response([
            'status' => 'success',
            'data' => $orderCatalog
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
            $orderCatalog = OrderCatalog::find($id);

            if(!$orderCatalog || $orderCatalog->active != 1)
                throw new \Exception("Item do pedido não encontrado!", 412);

            $orderCatalog->fill($request->all());
            $orderCatalog->save();

            return response([
                'status' => 'success',
                'data' => $orderCatalog
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
            $orderCatalog = OrderCatalog::find($id);

            if(!$orderCatalog || $orderCatalog->active != 1)
                throw new \Exception("Item do pedido não encontrado!", 412);

            $orderCatalog->active = 0;
            $orderCatalog->save();

            return response([
                'status' => 'success',
                'data' => $orderCatalog
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'error',
                'data' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
