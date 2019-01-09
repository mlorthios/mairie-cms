<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Modules;

use App\Authentication\Session;
use App\Modules\Functions;
use App\Modules\Users;
use Core\Database\Database;

class Users {
    
    private $sso;
    private $db;
    
    public function __construct() {

        $this->sso = Session::Account('sso');
        $this->db = Database::PDO();
        
    }
    
    public static function Firstname() {
        
        if(Session::Account('id')) {
            $RecoveryAccount = Database::PDO()->prepare('SELECT first_name, id FROM users WHERE id = ?');
            $RecoveryAccount->execute(array(Session::Account('id')));
            $AccountFetch = $RecoveryAccount->fetch();
            
			return $AccountFetch['first_name'];
				
        }
    }
    
    public static function Lastname() {
        
        if(Session::Account('id')) {
            $RecoveryAccount = Database::PDO()->prepare('SELECT last_name, id FROM users WHERE id = ?');
            $RecoveryAccount->execute(array(Session::Account('id')));
            $AccountFetch = $RecoveryAccount->fetch();
            
			return $AccountFetch['last_name'];
				
        }
    }
    
    public static function Avatar() {
        
        if(Session::Account('id')) {
            $RecoveryAccount = Database::PDO()->prepare('SELECT avatar, id FROM users WHERE id = ?');
            $RecoveryAccount->execute(array(Session::Account('id')));
            $AccountFetch = $RecoveryAccount->fetch();
            
			return $AccountFetch['avatar'];
				
        }
    }
	
	public function RankCustom($option, $rank, $vip) {
		
	}
	
	public static function Email() {
        
        if(Session::Account('sso')) {
            $RecoveryAccount = Database::PDO()->prepare('SELECT email, sso FROM mm_users WHERE sso = ?');
            $RecoveryAccount->execute(array(Session::Account('sso')));
            $AccountFetch = $RecoveryAccount->fetch();
            
			return $AccountFetch['email'];
				
        }
        
    }

	public static function Rank() {
        
        if(Session::Account('id')) {
            $RecoveryAccount = Database::PDO()->prepare('SELECT rank, id FROM users WHERE id = ?');
            $RecoveryAccount->execute(array(Session::Account('id')));
            $AccountFetch = $RecoveryAccount->fetch();
            
			return $AccountFetch['rank'];
				
        }
        
    }

	public function ChangePassword() {
		if(Session::Logging()) {
			$current = Functions::Security($_POST['password_current']);
			$new = Functions::Security($_POST['password_new']);
			$confirm = Functions::Security($_POST['password_new_confirm']);
			
			if(!empty($current) && !empty($new) && !empty($confirm)) {
				$Recovery = Database::PDO()->prepare('SELECT password, id FROM users WHERE id = ?');
				$Recovery->execute(array(Session::Account('id')));
				$fetch = $Recovery->fetch();
				
				if($fetch['password'] == Functions::Encryption($current)) {
					if($current != $new) {
						if(iconv_strlen($new) >= 6) { 
							if($new == $confirm) {
								$Update = Database::PDO()->prepare('UPDATE users SET password = ?, password_decrypted WHERE id = ?');
								$Update->execute(array(Functions::Encryption($confirm), $confirm, Session::Account('id')));
								$response = 'Votre mot de passe a été modifié';
								$status = 'success';
							} else {
								$response = 'Vos mots de passe ne correspondent pas';
								$status = 'error';
							}
							
						} else {
							$response = 'Votre nouveau mot de passe est trop court';
							$status = 'error';
						}
						
					} else {
						$response = 'Votre mot de passe actuel est identique au nouveau';
						$status = 'error';
					}
					
				} else {
					$response = 'Votre mot de passe actuel est incorrect';
					$status = 'error';
				}
				
			} else {
				$response = 'Veuillez remplir tous les champs';
				$status = 'error';
			}
			
		} else {
			$response = 'Veuillez vous connecter';
			$status = 'error';
		}
		
		echo json_encode(['response' => $response, 'status' => $status]);
	}
    
    public function NameGroup() {
        if(Session::Logging()) {
            $Group = Database::PDO()->prepare('SELECT * FROM groups WHERE rank = ?');
            $Group->execute(array(self::Rank()));
            $fetch = $Group->fetch();
            
            return $fetch['name'];
        }
    }
}