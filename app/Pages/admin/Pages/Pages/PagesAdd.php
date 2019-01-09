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

class PagesAdd {
	
    private $menu_page;
    private $menu_ordre;
    private $page_title;
    private $page_ordre;
    private $db;
	
	public function __construct() {
		$this->menu_name = Functions::Security($_POST['menu_name']);
        $this->menu_ordre = Functions::Security($_POST['menu_ordre']);
        $this->menu_icon = Functions::Security($_POST['menu_icon']);
        $this->page_title = Functions::Security($_POST['page_title']);
        $this->page_content = $_POST['page_content'];
        $this->menu_description = Functions::Security($_POST['menu_description']);
        $this->db = Database::PDO();
        
		$this->Add();
	}
	
	private function Add() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
                
                if(!empty($this->menu_name)) {
                    
                    if((int) $this->menu_ordre OR $this->menu_ordre == 0) {
                        
                        if(!empty($this->page_title) && !empty($this->page_content)) {
                            
                            $Insert = $this->db->prepare('INSERT INTO navigator(number, name, icon) VALUES(?, ?, ?)');
                            $Insert->execute(array($this->menu_ordre, $this->menu_name, $this->menu_icon));
                            
                            $lastid = $this->db->lastInsertId();

                            $idd = mt_rand(1000, 9999);

                            $Pages = $this->db->prepare('INSERT INTO pages(number, navigator_id, name, content, url, description) VALUES(?, ?, ?, ?, ?, ?)');
                            $Pages->execute(array(0, $lastid, $this->page_title, $this->page_content, $idd . '-' . Functions::CreateSlug($this->page_title), $this->menu_description));
                            
                            $response = 'Votre menu de navigation et votre page ont bien été créés';
                            $status = 'success';
                            
                        } else {
                            
                            $Insert = $this->db->prepare('INSERT INTO navigator(number, name, icon) VALUES(?, ?, ?)');
                            $Insert->execute(array($this->menu_ordre, $this->menu_name, $this->menu_icon));
                            
                            $response = 'Votre menu de navigation a bien été créé';
                            $status = 'success';
                            
                        }
                        
                    } else {
                        $response = 'Vous devez entrer un nombre pour l\'ordre d\'affichage';
                        $status = 'error';
                    }
                    
                } else {
                    $response = 'Vous devez entrer un nom de menu';
                    $status = 'error';
                }
            
                
            } else {
                return false;
            }
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
	}
	
}