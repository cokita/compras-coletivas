<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilesActions extends Model
{
    protected $table = 'profiles_actions';
    protected $fillable = [
        'id', 'action_id', 'profile_id', 'active'
    ];

    public function actions()
    {
        return $this->hasMany(Action::class, 'id', 'action_id');
    }

    public function profiles()
    {
        return $this->hasMany(Profiles::class, 'id', 'profile_id');
    }

}
