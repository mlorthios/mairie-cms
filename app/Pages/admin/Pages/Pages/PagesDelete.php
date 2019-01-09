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

class PagesDelete {
	
    private $id;
    private $db;
	
	public function __construct() {
		$this->id = Functions::Security($_POST['id']);
        $this->db = Database::PDO();
        
		$this->Delete();
	}
	
	private function Delete() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
                
                if(!empty($this->id)) {
                    
                    $Delete = $this->db->prepare('DELETE FROM pages WHERE id = ?');
                    $Delete->execute(array($this->id));
                    
                    $response = 'Votre page a bien été supprimé';
                    $status = 'success';
                    
                } else {
                    $response = 'Veuillez entrer un ID';
                    $status = 'error';
                }
            
                
            } else {
                return false;
            }
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
	}
	
}