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

class MessageEdit {
	
    private $id;
    private $message;
    private $type;
    private $page;
    private $db;
	
	public function __construct() {
        $this->id = Functions::Security($_POST['id']);
		$this->message = Functions::Security($_POST['message']);
        $this->type = Functions::Security($_POST['type']);
        $this->page = Functions::Security($_POST['page']);
        $this->db = Database::PDO();
        
		$this->Edit();
	}
	
	private function Edit() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_messages') == 'access') {
                
               if(!empty($this->id) && !empty($this->message) && !empty($this->type) && !empty($this->page)) {
                   $IdCheck = $this->db->prepare('SELECT * FROM messages WHERE id = ?');
                   $IdCheck->execute(array($this->id));
                   
                   $rowId = $IdCheck->rowCount();
                   
                   if($rowId > 0) {
                       
                       if($this->page == 'fullpage') {
                           $Update = $this->db->prepare('UPDATE messages SET message = ?, type = ?, fullpage = ? WHERE id = ?');
                           $Update->execute(array($this->message, $this->type, '1', $this->id));
                       
                           $response = 'Votre message a bien été modifié';
                           $status = 'success';
                           
                       } else {
                           $Update = $this->db->prepare('UPDATE messages SET message = ?, type = ?, page_id = ?, fullpage = ? WHERE id = ?');
                           $Update->execute(array($this->message, $this->type, $this->page, '0', $this->id));
                       
                           $response = 'Votre message a bien été modifié';
                           $status = 'success';
                       }
                       
                   } else {
                       $response = 'Veuillez entrer un ID correct';
                       $status = 'error';
                   }
                   
               } else {
                   $response = 'Veuillez remplir tous les champs';
                   $status = 'error';
               }
            
            } else {
                return false;
            }
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
	}
	
}