<?php

/**
 * Ville Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\News;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;

class NewsDelete {
	
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
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_events') == 'access') {
                
                if(!empty($this->id)) {
                    
                    $Delete = $this->db->prepare('DELETE FROM news WHERE id = ?');
                    $Delete->execute(array($this->id));
                    
                    $response = 'Votre actualité a bien été supprimé';
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