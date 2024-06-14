<?php

namespace WebDirectory\appli\app\utils;

class CsrfService{

    public static function generate(): string{
        $token = bin2hex(random_bytes(  32));
        $_SESSION['csrf'] = $token;
        return $token;
    }

    public static function check($token){

        if(!hash_equals($_SESSION['csrf'], $token)){
            unset($_SESSION['csrf']);
            return throw new CsrfException('csrf token error');
        }
        return true;
    }

}