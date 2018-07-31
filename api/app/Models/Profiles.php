<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $table = 'profiles';
    protected $fillable = [
        'id', 'name', 'active'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\Users', 'users_profiles',
            'profile_id', 'user_id')->withTimestamps();
    }
}
