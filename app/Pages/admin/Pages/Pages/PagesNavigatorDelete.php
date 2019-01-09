<?php

/**
 * Ville Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Pages\Pages;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;

class PagesNavigatorDelete {
	
    private $id;
    private $db;
	
	public function __construct() {
        $this->id = Functions::Security($_POST['id']);
        $this->db = Database::PDO();
        
		$this->Add();
	}
	
	private function Add() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
                
                if($this->id) {
                    $Delete = $this->db->prepare('DELETE FROM navigator WHERE id = ?');
                    $Delete->execute(array($this->id));
                    
                    $response = 'Votre menu de navigation a bien été supprimé';
                    $status = 'success';
                }
                
            } else {
                return false;
            }
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
	}
	
}