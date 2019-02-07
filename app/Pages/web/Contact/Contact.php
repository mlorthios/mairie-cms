<?php

/**
 * Ville Audruicq
 * Version 2.0
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Pages\web\Contact;

use Core\Database\Database;
use App\Modules\Functions;
use App\Modules\Cookies;
use App\Controller\Protections;
use App\Authentication\Session;

class Contact {

    public function __construct() {

        $this->fullname = Functions::Security($_POST['fullname']);
        $this->email = Functions::Security($_POST['email']);
        $this->subject = Functions::Security($_POST['subject']);
        $this->message = Functions::Security($_POST['message']);
        $this->url = Functions::Security($_POST['url']);

        $this->Cont();

    }

    private function Cont() {

        if(!empty($this->fullname) && !empty($this->email) && !empty($this->subject) && !empty($this->message)) {
            if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                if(iconv_strlen($this->subject) >= 10) {
                    if(iconv_strlen($this->message) >= 50) {
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

                            $d = Database::PDO()->prepare('INSERT INTO contact_messages(fullname, email, subject, message, ip, date) VALUES(?, ?, ?, ?, ?, ?)');
                            $d->execute(array($this->fullname, $this->email, $this->subject, $this->message, Functions::AddressIP(), date('Y-m-d H:i:s')));

                            $header="MIME-Version: 1.0\r\n";
                            $header.='From:"'.$this->fullname.'"<'.$this->email.'>'."\n";
                            $header.='Content-Type:text/html; charset="uft-8"'."\n";
                            $header.='Content-Transfer-Encoding: 8bit';

                            $message = '<html>
	                                        <body>
	                                        	<div align="center">
		                                        	Prise de contact de <strong>'.$this->fullname.' ('.$this->email.')</strong> le '.date('d/m/Y à H:i').'.<br>
		                                        	Message: '.$this->message.'
	                                        	</div>
	                                        </body>
                                        </html>';

                            mail("contact@ville-audruicq.fr", "[CONTACT SITE] " . $this->subject, $message, $header);

                            $response = 'Nous avons bien pris en compte votre demande, nous vous répondrons le plus rapidement possible';
                            $status = 'success';
                        } else {
                            $response = 'Notre protection vous a détecté comme ROBOT';
                            $status = 'error';
                        }

                    } else {
                        $response = 'Votre message doit comporter 50 caractères au minimum';
                        $status = 'error';
                    }

                } else {
                    $response = 'Votre sujet doit comporter 10 caractères au minimum';
                    $status = 'error';
                }

            } else {
                $response = 'Votre adresse email est invalide';
                $status = 'error';
            }

        } else {
            $response = 'Veuillez remplir tous les champs';
            $status = 'error';
        }

        echo json_encode(['response' => $response, 'status' => $status]);

    }

}