<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCatalog extends Model
{
    protected $table = 'order_catalog';
    protected $fillable = [
        'id', 'model', 'size', 'color', 'quantity'
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
