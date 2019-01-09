<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Modules;

use App\Authentication\Session;
use Core\Database\Database;

class Cookies {
    
    public static function Set($name, $value, $time) {
        setcookie($name, $value, time()+$time);
    }
    
    public static function Get($name) {
        return $_COOKIE[$name];
    }
    
    public static function Update($name, $value) {
        setcookie($name, $value);
    }
    
    public static function Delete($name) {
        setcookie($name,self::Get($name),time()-1);
    }
    
}