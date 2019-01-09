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

class PagesEdit {
	
	private $content;
    private $title;
    private $parente;
    private $ordre;
    private $description;
    private $id;
    private $db;
	
	public function __construct() {
		$this->content = $_POST['content'];
        $this->title = Functions::Security($_POST['title']);
		$this->id = Functions::Security($_POST['id']);
        $this->ordre = Functions::Security($_POST['ordre']);
        $this->parente = Functions::Security($_POST['parent']);
        $this->description = Functions::Security($_POST['description']);
        $this->db = Database::PDO();
        
		$this->Edit();
	}
	
	private function Edit() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
                
                if(!empty($this->content) && !empty($this->title) && !empty($this->description)) {
                    
                    $Insert = $this->db->prepare('UPDATE pages SET name = ?, content = ?, navigator_id = ?, number = ?, description = ? WHERE id = ?');
                    $Insert->execute(array($this->title, $this->content, $this->parente, $this->ordre, $this->description, $this->id));
                    
                    $response = 'Votre page a bien été publié';
                    $status = 'success';
                    
                } else {
                    $response = 'Veuillez remplir tous les champs';
                    $status = 'error';
                }
                
                echo json_encode(['response' => $response, 'status' => $status]);
                
            } else {
                return false;
            }
        }
	}
	
}