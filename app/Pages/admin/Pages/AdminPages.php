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

class AdminPages {
    
    public function ListMenusPages() {
        if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
                $Navigator = Database::PDO()->query('SELECT * FROM navigator ORDER BY number');
                
                while($n = $Navigator->fetch()) {
                    echo '<div class="card">
                                <div class="card-header bg-black text-white pointer-cursor collapsed" data-toggle="collapse" data-target="#collapse'.$n['id'].'" aria-expanded="false">
                                    <i class="'.$n['icon'].'"></i> '.$n['name'].'
                                    <a href="/admin/pages/navigator/edit/'.$n['id'].'" class="pull-right"><span class="badge badge-default">Éditer</span></a>
                                </div>
                                <div id="collapse'.$n['id'].'" class="collapse" data-parent="#accordion" style="">';
                                    $Pages = Database::PDO()->prepare('SELECT * FROM pages WHERE navigator_id = ?');
                                    $Pages->execute(array($n['id']));
                    
                                    while($p = $Pages->fetch()) {
                                        echo '<a href="/admin/pages/edit/'.$p['id'].'" class="widget-list-item">
                                        <div class="widget-list-content">
                                            <h4 class="widget-list-title">'.$p['name'].'</h4>
                                        </div>
                                        <div class="widget-list-action text-nowrap text-grey-darker">
                                            Éditer
                                            <i class="fa fa-angle-right fa-lg m-l-5 text-muted t-plus-1"></i>
                                        </div>
                                    </a>';
                                    }
                                echo '</div>
                            </div>';
                }
                
                $PagesVide = Database::PDO()->prepare('SELECT * FROM pages WHERE navigator_id = ?');
                $PagesVide->execute(array(0));
                $rowCount = $PagesVide->rowCount();
                if($rowCount > 0) {
                    echo '<div class="card">
                                <div class="card-header bg-black text-white pointer-cursor collapsed" data-toggle="collapse" data-target="#collapse00" aria-expanded="false">
                                    <i class="fa fa-file"></i> Pages sans parents
                                </div>
                                <div id="collapse00" class="collapse" data-parent="#accordion" style="">';
                    while($v = $PagesVide->fetch()) {
                        echo '<a href="/admin/pages/edit/'.$v['id'].'" class="widget-list-item">
                                        <div class="widget-list-content">
                                            <h4 class="widget-list-title">'.$v['name'].'</h4>
                                        </div>
                                        <div class="widget-list-action text-nowrap text-grey-darker">
                                            Éditer
                                            <i class="fa fa-angle-right fa-lg m-l-5 text-muted t-plus-1"></i>
                                        </div>
                                    </a>';
                    }
                    
                    echo '</div></div>';
                }
                
            } else {
                return false;
            }
        }
    }
    
}