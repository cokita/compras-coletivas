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
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function profiles()
    {
        return $this->hasMany(Profiles::class, 'id', 'profile_id');
    }

}
