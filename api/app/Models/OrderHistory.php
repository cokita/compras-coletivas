<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'order_history';
    protected $fillable = [
        'id', 'observation', 'status_limit_date', 'active', 'tracking_code', 'order_id', 'orders_status_id'
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Orders', 'id', 'order_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OrderStatus');
    }
}
