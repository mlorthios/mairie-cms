<?php

/**
 * Ville Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\admin\Newsletter;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Newsletter {
	
    public function Data($m) {
        $t = Database::PDO()->query('SELECT * FROM newsletter');
        
        $f = $t->fetch();
        
        return $f[$m];
    }
    
    public function Status() {
        
        $actu = Database::PDO()->query('SELECT * FROM newsletter');
        $fd = $actu->fetch();
        
        $status = $fd['active'];
        
        if($status == '0') {
            $change = Database::PDO()->prepare('UPDATE newsletter SET active = ?');
            $change->execute(array('1'));
            
            $response = 'La newsletter a bien été activé';
            $status = 'success';
            $nb = '1';
            
        } elseif($status == '1') {
            $change = Database::PDO()->prepare('UPDATE newsletter SET active = ?');
            $change->execute(array('0'));
            
            $response = 'La newsletter a bien été désactivé';
            $status = 'success';
            $nb = '0';
        }
        
        echo json_encode(['response' => $response, 'status' => $status, 'nb' => $nb]);
    }
    
    public function CreateMessage() {
        $object = Functions::Security($_POST['object']);
        $message = $_POST['content'];
        
        if(!empty($object) && !empty($message)) {

            $mail = new PHPMailer(false);
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'localhost';
            $mail->SMTPAuth = false;
            $mail->Port = 2500;

            $account = Database::PDO()->prepare('SELECT email, id FROM users WHERE id = ?');
            $account->execute(array(Session::Get('id')));
            $account_fetch = $account->fetch();

            //Recipients
            $mail->setFrom($account_fetch['email'], 'Ville d\'Audruicq');

            $list = Database::PDO()->query('SELECT * FROM newsletter_registered');

            while($r = $list->fetch()) {
                $mail->addAddress($r['email']);
            }

            //Content
            $mail->isHTML(true);
            $mail->Subject = $object;
            $mail->Body    = $message;

            if($mail->send()) {
                $response = 'Votre message a bien été envoyé aux inscrits à la newsletter';
                $status = 'success';
            } else {
                $response = 'Une erreur est survenue';
                $status = 'error';
            }
            
        } else {
            $response = 'Veuillez remplir tous les champs';
            $status = 'error';
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
    }
    
    public function Delete() {
        $email = Functions::Security($_POST['email']);
        
        if(!empty($email)) {
            $d = Database::PDO()->prepare('DELETE FROM newsletter_registered WHERE id = ?');
            $d->execute(array($email));
            
            $response = 'L\'email a bien été supprimé';
            $status = 'success';
            
        } else {
            $response = 'Veuillez entrer une email';
            $status = 'error';
        }
        
        echo json_encode(['response' => $response, 'status' => $status]);
    }
    
    public function Register() {
        
        $email = Functions::Security($_POST['email']);
        
        $verif = Database::PDO()->query('SELECT * FROM newsletter');
        $fetchverif = $verif->fetch();
        
        if($fetchverif['active']) {
            if(!empty($email)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $verifemail = Database::PDO()->prepare('SELECT * FROM newsletter_registered WHERE email = ?');
                    $verifemail->execute(array($email));
                    
                    $rowcountemail = $verifemail->rowCount();
                    
                    if($rowcountemail == 0) {
                        
                        $ad = Database::PDO()->prepare('INSERT INTO newsletter_registered(email, ip, date) VALUES(?, ?, ?)');
                        $ad->execute(array($email, Functions::AddressIP(), date('Y-m-d H:i:s')));
                        
                        $mailin = new Mailin('business@lorthios.email', '1QgAr3HzEntYkNO2');
                        $mailin->
                            addTo('business@lorthios.email', 'Mathis Lorthios')->
                            setFrom('business@lorthios.email', 'Mathis Lorthios')->
                            setReplyTo('business@lorthios.email','Mathis Lorthios')->
                            setSubject($object)->
                            setHtml('Inscription à la newsletter ok');
                        $res = $mailin->send();
                        
                        $response = 'Vous êtes maintenant inscrit';
                        $status = 'success';
                        
                    } else {
                        $response = 'Cette adresse e-mail est déjà enregistré';
                        $status = 'error';
                    }
                    
                } else {
                    $response = 'Cette adresse e-mail est invalide';
                    $status = 'error';
                }
            
            } else {
                $response = 'Veuillez entrer une adresse e-mail';
                $status = 'error';
            }
            
        } else {
            $response = 'La newsletter est désactivé';
            $status = 'error';
        }
        
        
        echo json_encode(['response' => $response, 'status' => $status]);
    }
	
}