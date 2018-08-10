<?php

namespace App\Constants;

class ConstProfile {

    CONST ADMIN = 1;
    CONST VENDEDOR = 2;
    CONST USUARIO = 3;

    CONST ARR_ALL_PROFILES = [self::ADMIN,self::VENDEDOR, self::USUARIO];
}