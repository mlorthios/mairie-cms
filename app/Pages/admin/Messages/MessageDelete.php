<?php

/**
 * Ville Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Messages;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;

class MessageDelete {
	
    private $id;
    private $message;
    private $type;
    private $page;
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
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_messages') == 'access') {
                
               if(!empty($this->id)) {
                   
                   $CheckID = $this->db->prepare('SELECT * FROM messages WHERE id = ?');
                   $CheckID->execute(array($this->id));
                   
                   $row = $CheckID->rowCount();
                   
                   if($row > 0) {
                       
                       $Delete = $this->db->prepare('DELETE FROM messages WHERE id = ?');
                       $Delete->execute(array($this->id));
                       
                       $response = 'Votre message a bien été supprimé';
                       $status = 'success';
                       
                   } else {
                       $response = 'Cet ID n\'existe pas';
                       $status = 'error';
                   }
                   
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