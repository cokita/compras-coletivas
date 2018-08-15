<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $table = 'stores';
    protected $fillable = [
        'id', 'name', 'active', 'user_id', 'description'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Users', 'id', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\Users', 'stores_users',
            'store_id', 'user_id')->withTimestamps();
    }
}
