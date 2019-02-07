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

class MessageAdd {
	
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
        
		$this->Add();
	}
	
	private function Add() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_messages') == 'access') {
                
               if(!empty($this->message) && !empty($this->type) && !empty($this->page) OR $this->page == 0) {
                   
                   if($this->page == 'fullpage') {
                       $Add = $this->db->prepare('INSERT INTO messages(message, type, date, fullpage) VALUES(?, ?, ?, ?)');
                       $Add->execute(array($this->message, $this->type, date('Y-m-d H:i:s'), '1'));
                       
                       $response = 'Votre message a bien été publié';
                       $status = 'success';
                   } elseif($this->page == 0) {
                       
                       $Add = $this->db->prepare('INSERT INTO messages(message, type, page_id, date, fullpage) VALUES(?, ?, ?, ?, ?)');
                       $Add->execute(array($this->message, $this->type, 0, date('Y-m-d H:i:s'), '0'));
                       
                       $response = 'Votre message a bien été publié';
                       $status = 'success';
                       
                   } else {
                       $Add = $this->db->prepare('INSERT INTO messages(message, type, page_id, date, fullpage) VALUES(?, ?, ?, ?, ?)');
                       $Add->execute(array($this->message, $this->type, $this->page, date('Y-m-d H:i:s'), '0'));
                       
                       $response = 'Votre message a bien été publié';
                       $status = 'success';
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