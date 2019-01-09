<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Authentication;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;

class Session {
	
	public static function Start($name) {
		
		$db = Database::PDO();
		
        session_name($name);
        //$life = 60 * 60 * 24 * 365;
        //session_set_cookie_params(600);
        
		session_start();
        
        //session_set_cookie_params('600'); // 10 minutes.
        //session_regenerate_id(true); 

		
		if(isset($_SESSION['id'])) {
			$Checkid = $db->prepare('SELECT id FROM users WHERE id = ?');
			$Checkid->execute(array($_SESSION['id']));
			$idRowCount = $Checkid->rowCount();
			
			if($idRowCount == 0) {
				$_SESSION['id'] = array();
				unset($_SESSION['id']);
				session_destroy();
				header('Location: /');
			}
		}
	}
    
    public static function CSRFToken() {
        Session::Set('csrf_token', md5(uniqid(rand(), TRUE)));
    }
    
    public static function Stop() {
        
        if(!empty(session_id())) {
            session_destroy();
        }
        
    }
    
    public static function ID() {
        
        return session_id();
        
    }
    
    public static function Set($key, $data) {
        
        if(!empty(self::ID())) {
            $_SESSION[$key] = $data;
        }
        
    }
    
    public static function Get($key) {
        
        if(!empty($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        
    }
    
    public static function Delete($key) {
         
         if(!empty(self::ID())) {
            unset($_SESSION[$key]);
         }
         
     }
	
	public static function Account($colonne) {
		
		$db = Database::PDO();
		
		if(isset($_SESSION['id'])) {
			$Checkid = $db->prepare('SELECT id, first_name, last_name, rank, email FROM users WHERE id = ?');
			$Checkid->execute(array($_SESSION['id']));
			$idRowCount = $Checkid->rowCount();
			$idFetch = $Checkid->fetch();
			
			if($idRowCount != 0) {
				return $idFetch[$colonne];
			}  
		}
	}
    
    public static function Logging() {
        if(self::Account('id')) {
            return 1;
        } else {
            return 0;
        }
    }
	
}