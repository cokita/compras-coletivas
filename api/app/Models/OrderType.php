<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    protected $table = 'order_type';
    protected $fillable = [
        'id', 'name', 'description', 'active'
    ];
}
