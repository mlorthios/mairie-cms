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

class TodolistCheck {
	
	private $content;
    private $db;
	
	public function __construct() {
		$this->id = Functions::Security($_POST['id']);
		
        $this->db = Database::PDO();
        
		$this->Check();
	}
	
	private function Check() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access') {
                
                $Check = $this->db->prepare('SELECT * FROM todo_list WHERE id = ? AND user_id = ?');
                $Check->execute(array($this->id, Session::Account('id')));
                $CheckRowCount = $Check->rowCount();
                $CheckFetch = $Check->fetch();
                
                if($CheckRowCount > 0) {
                    if($CheckFetch['done'] == '0') {
                        $Update = $this->db->prepare('UPDATE todo_list SET done = ?, done_date = ? WHERE id = ? AND user_id = ?');
                        $Update->execute(array('1', date('Y-m-d H:i:s'), $this->id, Session::Account('id')));
                        
                        $response = 'Votre tâche est terminé';
                        $status = 'success';
                        
                    } else {
                        $Update = $this->db->prepare('UPDATE todo_list SET done = ?, done_date = ? WHERE id = ? AND user_id = ?');
                        $Update->execute(array('0', date('Y-m-d H:i:s'), $this->id, Session::Account('id')));
                        
                        $response = 'Votre tâche a été mise en "non terminé"';
                        $status = 'finish';
                    }
                    
                    echo json_encode(['response' => $response, 'status' => $status]);
                }
                
            } else {
                return false;
            }
        }
	}
	
}