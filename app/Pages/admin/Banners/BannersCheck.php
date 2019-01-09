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

class BannersCheck {
	
	public function Check($placement) {
        $d = Database::PDO()->prepare('SELECT * FROM banners WHERE placement = ?');
        $d->execute(array($placement));
        
        $ro = $d->rowCount();
        
        if($ro > 0) {
            
            $f = $d->fetch();
            
            return $f['active'];
            
        }
    }
    
    public function Active() {
        
        $p = Functions::Security($_POST['placement']);
        
        $t = Database::PDO()->prepare('UPDATE banners SET active = ? WHERE placement = ?');
        $t->execute(array('1', $p));
        
        $response = 'La bannière a bien été activé';
        $status = 'success';
        
        echo json_encode(['response' => $response, 'status' => $status]);
    }
    
    public function Disabled() {
        
        $p = Functions::Security($_POST['placement']);
        
        $t = Database::PDO()->prepare('UPDATE banners SET active = ? WHERE placement = ?');
        $t->execute(array('0', $p));
        
        $response = 'La bannière a bien été désactivé';
        $status = 'success';
        
        echo json_encode(['response' => $response, 'status' => $status]);
    }
    
    public function Banner($placement) {
        $r = Database::PDO()->prepare('SELECT * FROM banners WHERE placement = ?');
        $r->execute(array($placement));
        $m = $r->fetch();
        
        return $m['image'];
    }
	
}