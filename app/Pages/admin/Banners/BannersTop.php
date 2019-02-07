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

class BannersTop {

    private $placement;

    private $db;

    public function __construct() {
        $this->db = Database::PDO();

        $this->Top();
    }

    private function Top() {

        if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_banners') == 'access') {

                if(isset($_FILES['file_top']) && !empty($_FILES['file_top']['name'])) {

                    $tailleMax = 2097152;
                    $extensionsValides = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JGEP', 'PNG', 'GIF');
                    if($_FILES['file_top']['size'] <= $tailleMax) {
                        $extensionUpload = strtolower(substr(strrchr($_FILES['file_top']['name'], '.'), 1));
                        if(in_array($extensionUpload, $extensionsValides)) {
                            $namee = md5(date('Y-m-d H:i:s') . $_FILES['file_top']['name']);
                            $chemin = "public/img/header/banner.png";
                            $resultat = move_uploaded_file($_FILES['file_top']['tmp_name'], $chemin);

                            if($resultat) {
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
                return false;
            }
        }

        echo json_encode(['response' => $response, 'status' => $status]);
    }

}