<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Users;

use Core\Database\Database;
use App\Authentication\Session;
use App\Controller\Protections;
use App\Modules\Functions;

class Users {
    
    public function Delete() {
        $id = Functions::Security($_POST['id']);
        
        if(!empty($id)) {
            $checkid = Database::PDO()->prepare('SELECT * FROM users WHERE id = ?');
            $checkid->execute(array($id));
            
            $row = $checkid->rowCount();
            
            if($row > 0) {
                $delete = Database::PDO()->prepare('DELETE FROM users WHERE id = ?');
                $delete->execute(array($id));
                
                $response = 'L\'utilisateur a bien été supprimé';
                $status = 'success';
            } else {
                $response = 'Cet ID n\'existe pas';
                $status = 'error';
            }
            
        } else {
            $response = 'Veuillez entrer un ID';
            $status = 'error';
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
    }
    
    public function Create() {
        
        $first_name = Functions::Security($_POST['first_name']);
        $last_name = Functions::Security($_POST['last_name']);
        $email = Functions::Security($_POST['email']);
        $rank = Functions::Security($_POST['rank']);
        $password = Functions::Security($_POST['password']);
        
        if(!empty($first_name) && !empty($last_name) && !empty($email) && !empty($rank) && !empty($password)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                
                $re = Database::PDO()->prepare('SELECT * FROM users WHERE email = ?');
                $re->execute(array($email));
                
                $ret = $re->rowCount();
                
                if($ret == 0) {
                    
                    $de = Database::PDO();
                    
                    $insert = $de->prepare('INSERT INTO users(first_name, last_name, email, rank, registration_date, disabled, password) VALUES(?, ?, ?, ?, ?, ?, ?)');
                    $insert->execute(array($first_name, $last_name, $email, $rank, date('Y-m-d H:i:s'), '0', Functions::Encryption($password)));
                    
                    $id = $de->lastInsertId();
                    $response = 'Le compte a bien été créé';
                    $status = 'success';
                    
                } else {
                    $response = 'Cette adresse e-mail est déjà utilisé';
                    $status = 'error';
                }
                
            } else {
                $response = 'Cette adresse e-mail est invalide';
                $status = 'error';
            }
            
        } else {
            $response = 'Veuillez remplir tous les champs';
            $status = 'error';
        }
        
        echo json_encode(['response' => $response, 'status' => $status, 'id' => $id]);
        
    }
    
    public function Edit() {
        $first_name = Functions::Security($_POST['first_name']);
        $last_name = Functions::Security($_POST['last_name']);
        $email = Functions::Security($_POST['email']);
        $rank = Functions::Security($_POST['rank']);
        $id = (int) $_POST['id'];
        
        if(!empty($first_name) && !empty($last_name) && !empty($email) && !empty($rank)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                
                $re = Database::PDO()->prepare('SELECT * FROM users WHERE email = ?');
                $re->execute(array($email));
                
                $ret = $re->rowCount();
                $fet = $re->fetch();
                
                if($ret == 0 OR $fet['email'] == $email) {
                    
                    $Update = Database::PDO()->prepare('UPDATE users SET first_name = ?, last_name = ?, email = ?, rank = ? WHERE id = ?');
                    $Update->execute(array($first_name, $last_name, $email, $rank, $id));
                    
                    $response = 'L\'utilisateur a bien été modifié';
                    $status = 'success';
                    
                } else {
                    $response = 'Cette adresse e-mail est déjà utilisé';
                    $status = 'error';
                }
            } else {
                $response = 'Veuillez entrer une adresse e-mail valide';
                $status = 'error';
            }
        } else {
            $response = 'Veuillez remplir tous les champs';
            $status = 'error';
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
    }
    
}