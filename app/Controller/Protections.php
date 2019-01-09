<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Controller;

use App\Authentication\Session;
use Core\Database\Database;
use App\Modules\Users;

class Protections {
	
	public static function InjectionSQL() {
		$injection = 'INSERT|UNION|SELECT|NULL|COUNT|FROM|LIKE|DROP|TABLE|WHERE|COUNT|COLUMN|TABLES|INFORMATION_SCHEMA|OR|UPDATE';
		foreach($_GET as $getSearchs) {
			$getSearch = explode(" ", $getSearchs);
			foreach($getSearch as $k => $v) {
				if (in_array(strtoupper(trim($v)) , explode('|', $injection))) {
					require 'errors/403.php';
					exit;
				}
			}
		}
	}
	
	public static function Logging($data) {
        if($data == 1) {
            if(Session::Account('id')) {
                header('Location: /');
                exit;
            }
        } elseif($data == 0) {
            if(!Session::Account('id')) {
                header('Location: /');
                exit;
            }
        }
    }
    
    public static function Permission($p) {
        if(Session::Logging()) {
            $Groups = Database::PDO()->prepare('SELECT * FROM groups WHERE rank = ?');
            $Groups->execute(array(Users::Rank()));
            $fetchGroups = $Groups->fetch();
            $rowCountGroups = $Groups->rowCount();
            
            if($rowCountGroups > 0) {
                $Permissions = Database::PDO()->prepare('SELECT * FROM permissions WHERE group_id = ?');
                $Permissions->execute(array($fetchGroups['id']));   
                $fetchPermissions = $Permissions->fetch();
                $rowCountPermissions = $Permissions->rowCount();
                
                if($rowCountPermissions > 0) {
                    
                    if($fetchPermissions[$p] == '1') {
                        return 'access';
                    }
                    
                }
                
            }
            
        } 
    }
	
}