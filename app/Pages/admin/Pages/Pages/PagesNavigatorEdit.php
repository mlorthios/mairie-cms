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

class PagesNavigatorEdit {
	
    private $menu_name;
    private $menu_icon;
    private $menu_ordre;
    private $id;
    private $db;
	
	public function __construct() {
		$this->menu_name = Functions::Security($_POST['menu_name']);
        $this->menu_icon = Functions::Security($_POST['menu_icon']);
        $this->menu_ordre = Functions::Security($_POST['menu_ordre']);
        $this->id = Functions::Security($_POST['id']);
        $this->db = Database::PDO();
        
		$this->Add();
	}
	
	private function Add() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
                
                if(!empty($this->menu_name)) {
                    if(!empty($this->menu_icon)) {
                        if((int) $this->menu_ordre OR $this->menu_ordre == 0) {
                            
                            $Update = $this->db->prepare('UPDATE navigator SET number = ?, name = ?, icon = ? WHERE id = ?');
                            $Update->execute(array($this->menu_ordre, $this->menu_name, $this->menu_icon, $this->id));
                            
                            $response = 'Votre menu de navigation a bien été modifié';
                            $status = 'success';
                            
                        } else {
                            $response = 'Vous devez choisir un numéro';
                            $status = 'error';
                        }
                        
                    } else {
                        $response= 'Vous devez choisir un icon';
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