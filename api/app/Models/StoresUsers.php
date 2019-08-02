<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoresUsers extends Model
{
    protected $table = 'stores_users';
    protected $fillable = [
        'id', 'user_id', 'store_id', 'active'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function stores()
    {
        return $this->hasMany(Stores::class, 'id', 'store_id');
    }
}
