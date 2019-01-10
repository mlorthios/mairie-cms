<?php

/**
 * Ville Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Authentication;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;

class Authentication extends Session {
	
	private $email;
	private $password;
    private $db;
	
	public function __construct() {
		$this->email = Functions::Security($_POST['email']);
		$this->password = Functions::Security($_POST['password']);
		
        $this->db = Database::PDO();
        
		$this->Login();
	}
	
	private function Login() {
		
		if(!Session::Logging()) {
			if(!empty($this->email)) {
				if(!empty($this->password)) {
					if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
						$CheckAccount = $this->db->prepare('SELECT email, password, id FROM users WHERE email = ?');
                        $CheckAccount->execute(array($this->email));
                        $AccountRowCount = $CheckAccount->rowCount();
                        if($AccountRowCount != 0) {
                            $AccountFetch = $CheckAccount->fetch();
                            if(Functions::Encryption($this->password) == $AccountFetch['password']) {
    
                                Session::Set('id', $AccountFetch['id']);
                                    
                                $response = 'Vous êtes maintenant connecté';
                                $status = 'success';

								
							} else {
                                $response = 'Votre mot de passe est incorrect';
                                $status = 'error';
							}
							
						} else {
							$response = 'Ce compte n\'existe pas';
							$status = 'error';
						}
						
					} else {
						$response = 'Veuillez entrer une adresse email valide';
						$status = 'error';
					}
					
				} else {
					$response = 'Veuillez entrer un mot de passe';
					$status = 'error';
				}
			} else {
				$response = 'Veuillez entrer une adresse email';
                $status = 'error';
			}
			
		} else {
			$response = 'Vous êtes déjà connecté';
			$status = 'error';
		}
		
		echo json_encode(['response' => $response, 'status' => $status]);
	}
	
}