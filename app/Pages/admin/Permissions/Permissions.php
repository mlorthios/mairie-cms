<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Permissions;

use Core\Database\Database;
use App\Authentication\Session;
use App\Controller\Protections;
use App\Modules\Functions;

class Permissions {
    
    public function Create() {
        $name = Functions::Security($_POST['name']);
        $admin_access = Functions::Security($_POST['admin_access']);
        $admin_pages = Functions::Security($_POST['admin_pages']);
        $admin_events = Functions::Security($_POST['admin_events']);
        $admin_news = Functions::Security($_POST['admin_news']);
        $admin_messages = Functions::Security($_POST['admin_messages']);
        $admin_banners = Functions::Security($_POST['admin_banners']);
        $admin_newsletter = Functions::Security($_POST['admin_newsletter']);
        $admin_users = Functions::Security($_POST['admin_users']);
        $admin_permissions = Functions::Security($_POST['admin_permissions']);
        $admin_maintenance = Functions::Security($_POST['admin_maintenance']);
        
        if(!empty($name)) {
            $checkname = Database::PDO()->prepare('SELECT * FROM groups WHERE name = ?');
            $checkname->execute(array($name));
            $rowname = $checkname->rowCount();
            
            if($rowname == 0) {
                
                $rank = strtotime(date('Y-m-d H:i:s'));
                
                $pdo = Database::PDO();
                $InsertG = $pdo->prepare('INSERT INTO groups(name, rank) VALUES(?, ?)');
                $InsertG->execute(array($name, $rank));
                $GID = $pdo->lastInsertId();
                
                $InsertP = Database::PDO()->prepare('INSERT INTO permissions(group_id, permission_admin_access, permission_admin_pages, permission_admin_events, permission_admin_news, permission_admin_messages, permission_admin_banners, permission_admin_newsletter, permission_admin_users, permission_admin_permissions, permission_admin_maintenance) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $InsertP->execute(array($GID, $admin_access, $admin_pages, $admin_events, $admin_news, $admin_messages, $admin_banners, $admin_newsletter, $admin_users, $admin_permissions, $admin_maintenance));
                
                $response = 'Votre groupe a bien été créé';
                $status = 'success';
                
            } else {
                $status = 'error';
                $response = 'Ce nom de groupe existe déjà';
            }
            
        } else {
            $status = 'error';
            $response = 'Veuillez entrer un nom de groupe';
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
    }
    
    public function Delete() {
        $id = (int) $_POST['id'];
        
        if(!empty($id)) {
            $delete = Database::PDO()->prepare('DELETE FROM groups WHERE id = ?');
            $delete->execute(array($id));
            
            $delete = Database::PDO()->prepare('DELETE FROM permissions WHERE group_id = ?');
            $delete->execute(array($id));
            
            $response = 'Le groupe vient d\'être supprimé';
            $status = 'success';
            
        } else {
            $response = 'Entrer un ID';
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
    }
    
}