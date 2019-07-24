<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $table = 'profiles';
    protected $fillable = [
        'id', 'name', 'active'
    ];

    public function profileUsers()
    {
        return $this->hasMany(UsersProfiles::class, 'profile_id', 'id');
    }

    public function profileActions()
    {
        return $this->hasMany(ProfilesActions::class, 'profile_id', 'id');
    }

    public function  profileUsersPivot()
    {
        return $this->belongsToMany(User::class, 'users_profiles',
            'profile_id', 'user_id')->withTimestamps();
    }

    public function profileActionsPivot()
    {
        return $this->belongsToMany(Profiles::class, 'profiles_actions',
            'profile_id', 'action_id')->withTimestamps();
    }
}
