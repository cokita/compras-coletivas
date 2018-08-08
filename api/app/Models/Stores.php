<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $table = 'stores';
    protected $fillable = [
        'id', 'name', 'active', 'user_id'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\Users');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\Users', 'stores_users',
            'store_id', 'user_id')->withTimestamps();
    }
}
