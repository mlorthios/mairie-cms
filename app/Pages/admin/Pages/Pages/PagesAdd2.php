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

class PagesAdd2 {
	
    private $menu_page;
    private $menu_ordre;
    private $page_title;
    private $page_ordre;
    private $db;
	
	public function __construct() {
		$this->parente = Functions::Security($_POST['parent']);
        $this->ordre = Functions::Security($_POST['ordre']);
        $this->title = Functions::Security($_POST['title']);
        $this->content = $_POST['content'];
        $this->description = Functions::Security($_POST['description']);
        $this->db = Database::PDO();
        
		$this->Add();
	}
	
	private function Add() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
                
                if(!empty($this->title)) {
                    if(!empty($this->content)) {
                        if((int) $this->ordre OR $this->ordre == 0) {

                            $idd = mt_rand(1000, 9999);

                            $Insert = $this->db->prepare('INSERT INTO pages(number, navigator_id, name, content, url, description) VALUES(?, ?, ?, ?, ?, ?)');
                            $Insert->execute(array($this->ordre, $this->parente, $this->title, $this->content, $idd . '-' . Functions::CreateSlug($this->title), $this->description));
                                
                            $response = 'Votre page a bien été créée';
                            $status = 'success';
                                
                        } else {
                            $response = 'Veuillez entrer un nombre correct';
                            $response = 'success';
                        }
                        
                    } else {
                        $response = 'Vous devez entrer du contenu dans la personnalisation de la page';
                        $status = 'error';
                    }
                    
                } else {
                    $response = 'Vous devez entrer un nom de page';
                    $status = 'error';
                }
            
                
            } else {
                return false;
            }
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
	}
	
}