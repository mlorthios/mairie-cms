<?php

/**
 * Ville Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Events;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;

class EventAdd {
	
    private $title;
    private $content;
    private $description;
    private $db;
	
	public function __construct() {
		$this->title = Functions::Security($_POST['title']);
        $this->description = Functions::Security($_POST['description']);
        $this->content = $_POST['content'];
        $this->datee = Functions::Security($_POST['date_event']);
        $this->db = Database::PDO();
        
		$this->Add();
	}
	
	private function Add() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_events') == 'access') {
                
                if(!empty($this->title) && !empty($this->content) && !empty($this->description) && !empty($this->datee)) {
                    
                    if(isset($_FILES['file']) AND !empty($_FILES['file']['name'])) {
                    
                        $tailleMax = 2097152;
                        $extensionsValides = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JGEP', 'PNG', 'GIF');
                        if($_FILES['file']['size'] <= $tailleMax) {
                            $extensionUpload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
                            if(in_array($extensionUpload, $extensionsValides)) {
                                $namee = md5(date('Y-m-d H:i:s') . $_FILES['file']['name']);
                                $chemin = "public/img/uploads/".$namee.".".$extensionUpload;
                                $resultat = move_uploaded_file($_FILES['file']['tmp_name'], $chemin);
                                
                                if($resultat) {
                                    $idd = mt_rand(1000, 9999);
                                    $Insert = $this->db->prepare('INSERT INTO events(user_id, title, content, description, date, image, date_event, url) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
                                    $Insert->execute(array(Session::Account('id'), $this->title, $this->content, $this->description, date('Y-m-d H:i:s'), '/public/img/uploads/'.$namee.'.'.$extensionUpload, $this->datee, $idd . '-' . Functions::CreateSlug($this->title)));
                                    $status = 'success';
                                    $response = 'Votre événement a bien été publié';
                                } else {
                                    $status = 'error';
                                    $response = "Erreur durant l'importation de votre image";
                                }
                                
                            } else {
                                $status = 'error';
                                $response = "Votre image doit être au format jpg, jpeg, gif ou png";
                            }
                            
                        } else {
                            $status = 'error';
                            $response = "Votre image ne doit pas dépasser 2Mo";
                        }
                    
                    } else {
                        $response = 'Veuillez choisir une image';
                        $status = 'error';
                    }
                    
                } else {
                    $response = 'Vous devez remplir tous les champs';
                    $status = 'error';
                }
            
            } else {
                return false;
            }
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
	}
	
}