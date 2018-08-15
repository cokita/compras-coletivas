<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'id', 'name', 'description', 'active', 'store_id', 'order_type_id', 'order_history_id'
    ];

    public function store()
    {
        return $this->hasOne('App\Models\Stores');
    }

    public function orderType()
    {
        return $this->hasOne('App\Models\OrderType');
    }

    public function orderHistory()
    {
        return $this->hasOne('App\Models\OrderHistory', 'id', 'order_history_id');
    }

    public function histories()
    {
        return $this->hasMany('App\Models\OrderHistory', 'order_id', 'id');
    }

    public function ordersCatalog()
    {
        return $this->hasMany(OrderCatalog::class, 'order_id', 'id');
    }

}

