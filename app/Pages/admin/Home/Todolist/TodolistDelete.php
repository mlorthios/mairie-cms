<?php

/**
 * Ville Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Home\Todolist;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;

class TodolistDelete {
	
	private $content;
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
            if(Protections::Permission('permission_admin_access') == 'access') {
                
                $Check = $this->db->prepare('SELECT * FROM todo_list WHERE id = ? AND user_id = ?');
                $Check->execute(array($this->id, Session::Account('id')));
                $CheckRowCount = $Check->rowCount();
                $CheckFetch = $Check->fetch();
                
                if($CheckRowCount > 0) {
                    
                    $Delete = $this->db->prepare('DELETE FROM todo_list WHERE id = ? AND user_id = ?');
                    $Delete->execute(array($this->id, Session::Account('id')));
                    
                    $response = 'Votre tâche a bien été supprimé';
                    $status = 'success';
                    
                    echo json_encode(['response' => $response, 'status' => $status]);
                }
                
            } else {
                return false;
            }
        }
	}
	
}