<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profiles()
    {
        return $this->belongsToMany(Profiles::class, 'users_profiles',
            'user_id', 'profile_id')->withTimestamps();
    }

    public function stores()
    {
        return $this->belongsToMany(Stores::class, 'stores_users',
            'user_id', 'store_id')->withTimestamps();
    }

    public function store()
    {
        return $this->hasOne(Stores::class, 'user_id','id');
    }

    public function ordersCatalog()
    {
        return $this->hasMany(OrderCatalog::class, 'user_id', 'id');
    }

    public function usersProfiles()
    {
        return $this->hasMany(UsersProfiles::class, 'user_id', 'id');
    }

    public function findForPassport($username)
    {
        return $this->where(function($q) use ($username) {
            $q->where('cpf', $username);
            $q->orWhere('cellphone', $username);
            $q->orWhere('email', $username);
        })->where('active', 1)->first();

    }

    /**
     * Retorna se o usuario está em um perfil ou array de perfis
     *
     * @return bool
     */
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

    /**
     * Passe um profile (name) e ele retornará se EXISTE APENAS esse profile passado.
     * @param $profile
     * @return bool
     */
    public function isOnlyProfile($profile){
        $retorno = false;
        $profiles = $this->profiles();

        if ($profiles) {
            foreach($profiles->get() as $prof){
                if(strtolower($prof->name) == strtolower($profile)) {
                    $retorno = true;
                    break;
                }
            }
        }
        $result = false;
        if($retorno && $profiles->count() == 1){
            $result = true;
        }

        return $result;
    }
}
