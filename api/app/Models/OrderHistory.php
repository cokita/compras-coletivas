<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'order_history';
    protected $fillable = [
        'id', 'observation', 'status_limit_date', 'active', 'tracking_code', 'order_id', 'orders_status_id'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Orders');
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class, 'id');
    }
}
