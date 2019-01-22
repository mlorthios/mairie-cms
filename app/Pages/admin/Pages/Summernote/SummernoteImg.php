<?php

/**
 * Ville Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Pages\Summernote;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;

class SummernoteImg {
	
	private $image;
    private $db;
	
	public function __construct() {
		$this->image = $_FILES['file'];
        $this->db = Database::PDO();
        
		$this->Img();
	}
	
	private function Img() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
                
                if(isset($_FILES['file']) AND !empty($_FILES['file']['name'])) {
                    
                    $tailleMax = 20971520000;
                    $extensionsValides = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'PNG', 'GIF');
                    $pdf = array('pdf', 'PDF');
                    if($_FILES['file']['size'] <= $tailleMax) {
                        $extensionUpload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
                        if(in_array($extensionUpload, $extensionsValides)) {
                            $namee = md5(date('Y-m-d H:i:s') . $_FILES['file']['name']);
                            $chemin = "public/img/uploads/".$namee.".".$extensionUpload;
                            $resultat = move_uploaded_file($_FILES['file']['tmp_name'], $chemin);
                            if($resultat) {
                                $status = 'success';
                                $response = '/public/img/uploads/'.$namee.'.'.$extensionUpload;
                            } else {
                                $status = 'error';
                                $response = "Erreur durant l'importation de votre image";
                            }
                        } elseif(in_array($extensionUpload, $pdf)) {
                            
                            $namee = md5(date('Y-m-d H:i:s') . $_FILES['file']['name']);
                            $chemin = "public/img/uploads/".$namee.".".$extensionUpload;

                            $image = new \Imagick($_FILES['file']['tmp_name']);

                            $image->setImageFormat("jpg");

                            $result = $image->writeImage('public/img/uploads/'.$namee.'.jpg');

                            if($result) {
                                $status = 'success';
                                $response = '/public/img/uploads/'.$namee.'.jpg';
                            } else {
                                $status = 'error';
                                $response = 'Erreur durant l\'importation de votre PDF';
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
                    $response = 'Veuillez choisir une image ';
                    $status = 'error';
                }
                
                echo json_encode(['response' => $response, 'status' => $status]);
                
            } else {
                return false;
            }
        }
	}
	
}