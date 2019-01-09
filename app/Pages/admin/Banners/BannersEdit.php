<?php

/**
 * Ville Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Banners;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;

class BannersEdit {
	
    private $placement;

    private $db;
	
	public function __construct() {
        $this->placement = Functions::Security($_POST['placement']);
        $this->db = Database::PDO();
        
		$this->Edit();
	}
	
	private function Edit() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_banners') == 'access') {
                
                if(!empty($this->placement)) {
                
                    $IdCheck = $this->db->prepare('SELECT * FROM banners WHERE placement = ?');
                    $IdCheck->execute(array($this->placement));
                    
                    $IdRow = $IdCheck->rowCount();
                    
                    if($IdRow > 0) {
                        
                        if($this->placement == 'left') {
                            
                            if(isset($_FILES['file_left']) && !empty($_FILES['file_left']['name'])) {
                            
                                $tailleMax = 2097152;
                                $extensionsValides = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JGEP', 'PNG', 'GIF');
                                if($_FILES['file_left']['size'] <= $tailleMax) {
                                    $extensionUpload = strtolower(substr(strrchr($_FILES['file_left']['name'], '.'), 1));
                                    if(in_array($extensionUpload, $extensionsValides)) {
                                        $namee = md5(date('Y-m-d H:i:s') . $_FILES['file_left']['name']);
                                        $chemin = "public/img/uploads/".$namee.".".$extensionUpload;
                                        $resultat = move_uploaded_file($_FILES['file_left']['tmp_name'], $chemin);
                                
                                        if($resultat) {
                                            $Update = $this->db->prepare('UPDATE banners SET image = ? WHERE placement = ?');
                                            $Update->execute(array('/public/img/uploads/'.$namee.'.'.$extensionUpload, $this->placement));
                                            $status = 'success';
                                            $response = 'Votre bannière a bien été modifié';
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
                              
                        } elseif($this->placement == 'right') {
                            
                            if(isset($_FILES['file_right']) && !empty($_FILES['file_right']['name'])) {
                            
                                $tailleMax = 2097152;
                                $extensionsValides = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JGEP', 'PNG', 'GIF');
                                if($_FILES['file_right']['size'] <= $tailleMax) {
                                    $extensionUpload = strtolower(substr(strrchr($_FILES['file_right']['name'], '.'), 1));
                                    if(in_array($extensionUpload, $extensionsValides)) {
                                        $namee = md5(date('Y-m-d H:i:s') . $_FILES['file_right']['name']);
                                        $chemin = "public/img/uploads/".$namee.".".$extensionUpload;
                                        $resultat = move_uploaded_file($_FILES['file_right']['tmp_name'], $chemin);
                                
                                        if($resultat) {
                                            $Update = $this->db->prepare('UPDATE banners SET image = ? WHERE placement = ?');
                                            $Update->execute(array('/public/img/uploads/'.$namee.'.'.$extensionUpload, $this->placement));
                                            $status = 'success';
                                            $response = 'Votre bannière a bien été modifié';
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
                            $response = 'Une erreur est survenue';
                            $status = 'error';
                        }
                        
                    } else {
                        $response = 'Ce placement n\'existe pas';
                        $status = 'error';
                    }
                    
                } else {
                    $response = 'Veuillez entrer un placement';
                    $status = 'error';
                }
            
            } else {
                return false;
            }
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
	}
	
}