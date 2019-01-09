<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Pages;

use Core\Database\Database;
use App\Authentication\Session;
use App\Controller\Protections;
use App\Modules\Functions;

class AdminPagesEdit {
    
    public function CheckPagesExist($id) {
        $Check = Database::PDO()->prepare('SELECT id FROM pages WHERE id = ?');
        $Check->execute(array($id));
        
        $rowCount = $Check->rowCount();
        
        if($rowCount > 0) {
            return 'success';
        } else {
            return 'error';
        }
    }
    
    public function Data($id, $data) {
        $Select = Database::PDO()->prepare('SELECT * FROM pages WHERE id = ?');
        $Select->execute(array($id));
        
        $fetch = $Select->fetch();
        
        return $fetch[$data];
    }
    
}