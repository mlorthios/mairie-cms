<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace App\Modules;

use Core\Database\Database;

class Functions {
	
	public static function Security($variable) {
		$security = htmlspecialchars(trim(stripslashes(nl2br($variable))));
		return $security;
	}
	
	public static function Encryption($variable)
	{
		$encryption = hash('sha512', $variable);
		return $encryption;
	}
	
	public static function AddressIP() {
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
		}
	}
	
	public static function Chaine($nb_car, $chaine = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN123456789') {
		$nb_lettres = strlen($chaine) - 1;
		$generation = '';
		for ($i = 0; $i < $nb_car; $i++) {
			$pos = mt_rand(0, $nb_lettres);
			$car = $chaine[$pos];
			$generation.= $car;
		}

		return $generation;
	}
	
	public static function ConvertTime($temps)
	{
		$temps = strtotime($temps);
		$diff_temps = time() - $temps;
		if ($diff_temps < 1) {
			return 'À l\'instant';
		}

		$sec = array(
			12 * 30 * 24 * 60 * 60 => 'an',
			30 * 24 * 60 * 60 => 'mois',
			24 * 60 * 60 => 'jour',
			60 * 60 => 'heure',
			60 => 'minute',
			1 => 'seconde'
		);
		foreach($sec as $sec => $value) {
			$div = $diff_temps / $sec;
			if ($div >= 1) {
				$temps_conv = round($div);
				$temps_type = $value;
				if ($temps_conv > 1 && $temps_type != "mois") {
					$temps_type.= "s";
				}

				return '' . $temps_conv . ' ' . $temps_type;
			}
		}
	}
    
    public static function Many($data) {
        
        if($data >= 2) {
            return 's';
        }
        
    }
    
    public function DateConvert($date) {
        
        $datee = date_create($date);
        
        $mois = array(1=>'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        
        $jours = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
        
        return ''.$jours[date_format($datee, 'w')].' '.date_format($datee, 'j').' '.$mois[date_format($datee, 'n')].' '.date_format($datee, 'Y');
    }
    
    public function MessagesAlert($pageid) {
        $Message = Database::PDO()->prepare('SELECT * FROM messages WHERE page_id = ?');
        $Message->execute(array($pageid));
        $b = $Message->rowCount();
            
        if($b > 0) {
            while($a = $Message->fetch()) {
                if($a['type'] == 'info') {
                    echo '<div class="row"><div class="col-md-12"><div class="alert alert-info"><i  class="fa fa-exclamation-circle"></i> '.$a['message'].'</div></div></div>';
                } elseif($a['type'] == 'warning') {
                    echo '<div class="row"><div class="col-md-12"><div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> '.$a['message'].'</div></div></div>';
                } else {
                    echo '<div class="barre-pub"><div class="align"><div class="marquee">'.$a['message'].'</div></div></div>';
                }
            }
        }
            
        $AllMessages = Database::PDO()->prepare('SELECT * FROM messages WHERE fullpage = ?');
        $AllMessages->execute(array('1'));
        $d = $AllMessages->rowCount();
            
        if($d > 0) {
            while($e = $AllMessages->fetch()) {
                if($e['page_id'] != $pageid) {
                    if($e['type'] == 'info') {
                        echo '<div class="row"><div class="col-md-12"><div class="alert alert-info"><i  class="fa fa-exclamation-circle"></i> '.$e['message'].'</div></div></div>';
                    } elseif($e['type'] == 'warning') {
                        echo '<div class="row"><div class="col-md-12"><div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> '.$e['message'].'</div></div></div>';
                    } else {
                        echo '<div class="barre-pub"><div class="align"><div class="marquee">'.$e['message'].'</div></div></div>';
                    }
                }
            }
        }
    }
    
    public function ListEvents() {
        $Events = Database::PDO()->prepare('SELECT * FROM events WHERE date_event > ? ORDER BY date_event DESC LIMIT 3');
        $Events->execute(array(date('Y-m-d')));
        
        while($e = $Events->fetch()) {
            echo '<div class="media">
                    <div class="media-left">
                        <a href="/events/'.$e['url'].'">
                            <img style="height: 60px; width: 60px" class="media-object" src="'.$e['image'].'">
                        </a>
                    </div>
                    <div class="media-body">
                        <a href="/events/'.$e['url'].'"><h4 class="media-heading">'.$e['title'].'</h4></a>
                        <small>'.$this->DateConvert($e['date_event']).'</small><br>
                        <span>'.$e['description'].'</span>
                    </div>
                </div>';
        }
    }
    
    public function BannerLeft() {
        $BannerLeft = Database::PDO()->prepare('SELECT * FROM banners WHERE placement = ?');
        $BannerLeft->execute(array('left'));
        $rowCount = $BannerLeft->rowCount();
        $fetch = $BannerLeft->fetch();
            
        if($rowCount > 0) {
            if($fetch['active'] == '1') {
                echo '<div class="bannerleft">
                <img src="'.$fetch['image'].'">
                </div>';
            }
        }
    }
    
    public function BannerRight() {
        $BannerRight = Database::PDO()->prepare('SELECT * FROM banners WHERE placement = ?');
        $BannerRight->execute(array('right'));
        $rowCount = $BannerRight->rowCount();
        $fetch = $BannerRight->fetch();
            
        if($rowCount > 0) {
            if($fetch['active'] == '1') {
                echo '<div class="bannerright">
                <img src="'.$fetch['image'].'">
                </div>';
            }
        }
    }
    
    public function Visitors() {
        $Visitors = Database::PDO()->prepare('SELECT * FROM visitors WHERE ip = ? AND date = ?');
        $Visitors->execute(array(self::AddressIP(), date('Y-m-d')));
        
        $rowCount = $Visitors->rowCount();
        
        if($rowCount == 0) {
            $AddVisit = Database::PDO()->prepare('INSERT INTO visitors(ip, date) VALUES(?, ?)');
            $AddVisit->execute(array(self::AddressIP(), date('Y-m-d')));
        }
    }
    
    public function SousMenu() {
        
        
        $Navigator = Database::PDO()->query('SELECT * FROM navigator ORDER BY number');
                        
        while($a = $Navigator->fetch()) {
            $Pages = Database::PDO()->prepare('SELECT *, COUNT(*) AS nb FROM pages WHERE navigator_id = ?');
            $Pages->execute(array($a['id']));
            $fetch = $Pages->fetch();
            if($fetch['nb'] == 1) {
                echo '<a href="/pages/'.$fetch['url'].'"><li><i class="'.$a['icon'].'"></i> '.$fetch['name'].'</li></a>';
            }
        }
    }
    
    public function RightMenu() {
        
        $NewsLetter = Database::PDO()->query('SELECT * FROM newsletter');
        $FetchNewsLetter = $NewsLetter->fetch();
        
        echo '<a href="https://facebook.com/VilleAudruicq/" target="_blank" class="btn btn-facebook btn-block" style="margin-bottom: 17px"><i class="fab fa-facebook-f"></i> Suivez-nous sur Facebook</a>';
        
        if($FetchNewsLetter['active'] == '1') {
            echo '<div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="far fa-envelope"></i> Newsletter
                    </div>
                    <div class="panel-body">
                        <p style="text-align: center; font-size: 13px">Recevez l\'actualités de la ville d\'Audruicq par e-mail !</p>
                        <div id="__message-alert"></div>
                        <div class="form-group">
                            <input class="form-control" name="newsletter_email" placeholder="Adresse e-mail">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" name="newsletter">S\'inscrire</button>
                    </div>
                </div>';
        }
        
    }

    public function ListEventsAll() {
	    $r = Database::PDO()->prepare('SELECT DISTINCT date_event FROM events WHERE date_event > ?');
	    $r->execute(array(date('Y-m-d')));

	    $limit = 1;

	    $month_letter = array("Janvier","Février","Mars","Avril","Mai","Juin", "Juillet","Août","Septembre","Octobre","Novembre","Décembre");
	    $day_letter = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");

	    while($f = $r->fetch()) {
            $month = date("n", strtotime($f['date_event']));
            $day = date("N", strtotime($f['date_event']));
	        echo '<div class="events_list">
                        <div class="date">'.$day_letter[$day-1].' '.date("j", strtotime($f['date_event'])).' '.mb_strtolower($month_letter[$month-1]).' '.date("Y", strtotime($f['date_event'])).'</div>
                        <div class="body">';

	            $List = Database::PDO()->prepare('SELECT * FROM events WHERE date_event = ?');
	            $List->execute(array(date("Y-m-d", strtotime($f['date_event']))));

	            while($m = $List->fetch()) {
	                echo '<div><a href="/events/'.$m['url'].'"><i class="fa fa-angle-double-right"></i> '.$m['title'].'</a></div>';
                }

                echo '</div>
                    </div>';
        }
	}

    public static function CreateSlug($str, $delimiter = '-'){

        $unwanted_array = ['ś'=>'s', 'ą' => 'a', 'ć' => 'c', 'ç' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ź' => 'z', 'ż' => 'z',
            'Ś'=>'s', 'Ą' => 'a', 'Ć' => 'c', 'Ç' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n', 'Ó' => 'o', 'Ź' => 'z', 'Ż' => 'z'];
        $str = strtr( $str, $unwanted_array );

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));

        return $slug;
    }
	
}