<?php

/**
 * Ville Audruicq
 * Version 2.0
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\web\News;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;

class AddComment {

    private $first_name;
    private $message;

    public function __construct() {

        $this->first_name = Functions::Security($_POST['first_name']);
        $this->message = Functions::Security($_POST['message']);
        $this->token = Functions::Security($_POST['token']);
        $this->url = Functions::Security($_POST['url']);

        $this->Add();

    }

    private function Add() {

        if(!empty($this->first_name) && !empty($this->message)) {
            $getdata = http_build_query(
                array(
                    'secret' => '6Le46YkUAAAAAJh0dU8HhvGMU2M0aNMID2AX_boF',
                    'response' => $this->token,
                )
            );
            $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?'.$getdata);

            $responseData = json_decode($recaptcha);
            $responseData->success = true;

            if($responseData->success) {
               $r = Database::PDO()->prepare('SELECT * FROM news_comments WHERE ip = ? AND news_url = ?');
               $r->execute(array(Functions::AddressIP(), $this->url));

               $row = $r->rowCount();

               if($row == 0) {
                   $check = Database::PDO()->prepare('SELECT * FROM news WHERE url = ?');
                   $check->execute(array($this->url));

                   $row = $check->rowCount();

                   if($row > 0) {
                       if(iconv_strlen($this->first_name) >= 3) {
                           if(iconv_strlen($this->message) >= 30) {
                               $date = date('Y-m-d H:i:s');
                               $insert = Database::PDO()->prepare('INSERT INTO news_comments(news_url, first_name, content, date, ip) VALUES(?, ?, ?, ?, ?)');
                               $insert->execute(array($this->url, $this->first_name, $this->message, $date, Functions::AddressIP()));
                               $months = array("Janvier","Février","Mars","Avril","Mai","Juin", "Juillet","Août","Septembre","Octobre","Novembre","Décembre");
                               $month = date("n", strtotime($date));
                               $date_conv = date("j", strtotime($date)).' '.mb_strtolower($months[$month-1]).' '.date("Y", strtotime($date)).' à '.date("H:i", strtotime($date));

                               $response = array($this->first_name, $this->message, $date_conv);
                               $status = 'success';
                           } else {
                               $response = 'Votre commentaire doit comporter 30 caractères minimum';
                               $status = 'error';
                           }

                       } else {
                           $response = 'Votre prénom doit comporter 3 caractères minimum';
                           $status = 'error';
                       }

                   } else {
                       $response = 'Une erreur est survenue';
                       $status = 'error';
                   }

               } else {
                   $response = 'Vous avez déjà posté un commentaire';
                   $status = 'error';
               }

            } else {
                $response = 'robot';
            }
        } else {
            $response = 'Veuillez remplir tous les champs';
            $status = 'error';
        }

        echo json_encode(['response' => $response, 'status' => $status]);

    }

}