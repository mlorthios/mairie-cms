<?php

/**
 * Ville Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Home\Todolist;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;

class TodolistAdd {
	
	private $content;
    private $db;
	
	public function __construct() {
		$this->content = Functions::Security($_POST['content']);
		
        $this->db = Database::PDO();
        
		$this->Add();
	}
	
	private function Add() {
		
		if(!Session::Logging()) {
            return false;
        } else {
            if(Protections::Permission('permission_admin_access') == 'access') {
                
                if(!empty($this->content)) {
                    
                    $Add = $this->db->prepare('INSERT INTO todo_list(user_id, content, date, done) VALUES(?, ?, ?, ?)');
                    $Add->execute(array(Session::Account('id'), $this->content, date('Y-m-d H:i:s'), '0'));
                    
                    $id = $this->db->lastInsertId();
                    
                    $response = 'Votre tâche a bien été ajouté';
                    $status = 'success';
                    $code = '<div class="widget-todolist-item" id="todolist'.$id.'">
                                    <div class="widget-todolist-input">
                                        <div class="checkbox checkbox-css">
                                            <input onclick="CheckTodolist('.$id.')" type="checkbox" id="widget_todolist_'.$id.'">
                                            <label for="widget_todolist_'.$id.'" class="p-l-15"></label>
                                        </div>
                                    </div>
                                    <div class="widget-todolist-content">
                                        <h4 class="widget-todolist-title">'.$this->content.'</h4>
                                        <p class="widget-todolist-desc">Ajouté le '.Functions::DateConvert(date('Y-m-d')).'</p>
                                    </div>
                                    <div class="widget-todolist-icon">
                                        <a onclick="DeleteTodolist('.$id.')" style="color: red" href="#"><i class="fa fa-times"></i></a>
								    </div>
                                </div>';
                    
                    
                } else {
                    $response = 'Veuillez entrer une tâche';
                    $status = 'error';
                }
                
                echo json_encode(['response' => $response, 'status' => $status, 'code' => $code]);
                
            } else {
                return false;
            }
        }
	}
	
}