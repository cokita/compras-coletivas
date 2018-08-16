<?php

namespace App\Services;

use App\Models\User;

class UserService extends Service {

    /**
     * @var User
     */
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function userInStore($store_id)
    {
        return $this->user->hasProfile('Administrador') ||
            $this->user->stores()->where('store_id', '=', $store_id)->get()->count();
    }
}