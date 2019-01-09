<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Home;

use Core\Database\Database;
use App\Authentication\Session;
use App\Controller\Protections;
use App\Modules\Functions;

class AdminHome {
    
    public function Todolist() {
        if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access') {
                $Todolist = Database::PDO()->prepare('SELECT * FROM todo_list WHERE user_id = ? AND done = ? ORDER BY date');
                $Todolist->execute(array(Session::Account('id'), '0'));
                $rowCount = $Todolist->rowCount();
                
                if($rowCount > 0) {
                    while($a = $Todolist->fetch()) {
                        echo '<div class="widget-todolist-item" id="todolist'.$a['id'].'">
                                    <div class="widget-todolist-input">
                                        <div class="checkbox checkbox-css">
                                            <input onclick="CheckTodolist('.$a['id'].')" type="checkbox" id="widget_todolist_'.$a['id'].'">
                                            <label for="widget_todolist_'.$a['id'].'" class="p-l-15"></label>
                                        </div>
                                    </div>
                                    <div class="widget-todolist-content">
                                        <h4 class="widget-todolist-title">'.$a['content'].'</h4>
                                        <p class="widget-todolist-desc">Ajouté le '.Functions::DateConvert($a['date']).'</p>
                                    </div>
                                    <div class="widget-todolist-icon">
                                        <a onclick="DeleteTodolist('.$a['id'].')" style="color: red" href="#"><i class="fa fa-times"></i></a>
								    </div>
                                </div>';
                    }
                } else {
                    echo '<span style="margin-left: 18px; margin-top: 10px; margin-bottom: 10px" id="notodolist">Vous n\'avez aucune liste de tâche</span>';
                }
                
            } else {
                return false;
            }
        }
    }
    
    public function TotalVisitors() {
        if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access') {
                $Visitors = Database::PDO()->query('SELECT COUNT(id) AS nb FROM visitors');
                $fetch = $Visitors->fetch();
                
                return $fetch['nb'];
            } else {
                return false;
            }
        }
    }
    
}