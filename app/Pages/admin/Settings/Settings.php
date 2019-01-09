<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Settings;

use Core\Database\Database;
use App\Authentication\Session;
use App\Controller\Protections;
use App\Modules\Functions;

class Settings {
    
    public function Password() {
        $current = Functions::Security($_POST['current']);
        $new = Functions::Security($_POST['new']);
        $new2 = Functions::Security($_POST['new2']);
        
        if(!empty($current)){
            if(!empty($new)) {
                if(!empty($new2)) {
                    if(iconv_strlen($new) >= 6) {
                        if($new == $new2) {
                            
                            $Pass = Database::PDO()->prepare('SELECT password, id FROM users WHERE id = ?');
                            $Pass->execute(array(Session::Account('id')));
                            
                            $fe = $Pass->fetch();
                            
                            if(Functions::Encryption($current) == $fe['password']) {
                                
                                $edit = Database::PDO()->prepare('UPDATE users SET password = ? WHERE id = ?');
                                $edit->execute(array(Functions::Encryption($new), Session::Account('id')));
                                
                                $response = 'Votre mot de passe a bien été modifié';
                                $status = 'success';
                                $status = 'success';
                                
                            } else {
                                $response = 'Votre mot de passe actuel est incorrect';
                                $status = 'error';
                            }
                            
                        } else {
                            $response = 'Vos nouveaux mots de passe ne correspondent pas';
                            $status = 'error';
                        }
                        
                    }  else {
                        $response = 'Votre nouveau mot de passe doit contenir au minimum 6 caractères';
                        $status = 'error';
                    }
                    
                } else {
                    $response = 'Veuillez confirmer votre nouveau mot de passe';
                    $status = 'error';
                }
                
            } else {
                $response = 'Veuillez entrer votre nouveau mot de passe';
                $status = 'error';
            }
            
        } else {
            $response = 'Veuillez entrer votre mot de passe actuel';
            $status = 'error';
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
    }
    
}