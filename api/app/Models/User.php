<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'cellphone', 'cpf', 'gender', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function profiles()
    {
        return $this->belongsToMany('App\Models\Profiles', 'users_profiles',
            'user_id', 'profile_id')->withTimestamps();
    }

    public function stores()
    {
        return $this->belongsToMany('App\Models\Stores', 'stores_users',
            'user_id', 'store_id')->withTimestamps();
    }

    public function hasProfile($roles)
    {
        $retorno = false;
        $profiles = $this->profiles();

        if ($profiles) {
            foreach($profiles->get() as $profile){
                if($profile->name == 'Administrador') {
                    $retorno = true;
                    break;
                }else{
                    if(is_array($roles)) {
                        foreach ($roles as $role) {
                            if (strtolower($profile->name) == strtolower($role)) {
                                $retorno = true;
                                break;
                            }
                        }
                    }else if(strtolower($profile->name) == strtolower($roles)) {
                        $retorno = true;
                        break;
                    }
                }
            }

        }

        return $retorno;
    }
}
