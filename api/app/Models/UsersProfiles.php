<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersProfiles extends Model
{
    protected $table = 'users_profiles';
    protected $fillable = [
        'id', 'user_id', 'profile_id', 'active'
    ];

    public function users()
    {
        return $this->hasMany('App\Models\Users');
    }

    public function profiles()
    {
        return $this->hasMany('App\Models\Profiles');
    }

}
