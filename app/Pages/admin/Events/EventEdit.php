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

class EventEdit {
	
    private $id;
    private $title;
    private $content;
    private $description;
    private $db;
	
	public function __construct() {
        $this->id = Functions::Security($_POST['id']);
		$this->title = Functions::Security($_POST['title']);
        $this->description = Functions::Security($_POST['description']);
        $this->content = $_POST['content'];
        $this->datee = Functions::Security($_POST['date_event']);
        $this->db = Database::PDO();
        
		$this->Edit();
	}
	
	private function Edit() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_events') == 'access') {
                
                if(!empty($this->id) && !empty($this->title) && !empty($this->description) && !empty($this->content) && !empty($this->datee)) {
                
                    $IdCheck = $this->db->prepare('SELECT * FROM events WHERE id = ?');
                    $IdCheck->execute(array($this->id));
                    
                    $IdRow = $IdCheck->rowCount();
                    
                    if($IdRow > 0) {
                        
                        if(isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
                            
                            $tailleMax = 2097152;
                            $extensionsValides = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JGEP', 'PNG', 'GIF');
                            if($_FILES['file']['size'] <= $tailleMax) {
                                $extensionUpload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
                                if(in_array($extensionUpload, $extensionsValides)) {
                                    $namee = md5(date('Y-m-d H:i:s') . $_FILES['file']['name']);
                                    $chemin = "public/img/uploads/".$namee.".".$extensionUpload;
                                    $resultat = move_uploaded_file($_FILES['file']['tmp_name'], $chemin);
                                
                                    if($resultat) {
                                        $Update = $this->db->prepare('UPDATE events SET title = ?, description = ?, content = ?, image = ?, date_event = ? WHERE id = ?');
                                        $Update->execute(array($this->title, $this->description, $this->content, '/public/img/uploads/'.$namee.'.'.$extensionUpload, $this->datee, $this->id));
                                        $status = 'success';
                                        $response = 'Votre événement a bien été modifié';
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
                            
                            $Update = $this->db->prepare('UPDATE events SET title = ?, description = ?, content = ?, date_event = ? WHERE id = ?');
                            $Update->execute(array($this->title, $this->description, $this->content, $this->datee, $this->id));
                            
                            $response = 'Votre événement a bien été modifié';
                            $status = 'success';
                            
                        }
                        
                    } else {
                        $response = 'Cet ID n\'existe pas';
                        $status = 'error';
                    }
                    
                } else {
                    $response = 'Veuillez remplir tous les champs (image non obligatoire)';
                    $status = 'error';
                }
            
            } else {
                return false;
            }
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
	}
	
}