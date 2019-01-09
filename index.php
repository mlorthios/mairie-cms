<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

date_default_timezone_set('Europe/Paris'); 
error_reporting(0);

$maintenance = '0';

use App\Controller\Router;
use App\Controller\Protections;
use App\Modules\Functions;
use App\Authentication\Session;
use Core\Database\Database;

include_once('vendor/autoload.php');

if($maintenance == '0') {

    require 'app/App.php';

    Session::Start('sessionid');

    Session::CSRFToken();

    Functions::Visitors();

    $router = new Router();

    $filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);

    if (php_sapi_name() === 'cli-server' && is_file($filename)) {
        return false;
    }

    $router->set404(function () {
	   header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    
        $function = new Functions;
        $db = Database::PDO();
    
        require 'errors/404.php';
    });

    /** Views **/

    include 'core/Routes/Get.php';

    /** API **/

    include 'core/Routes/Post.php';

    $router->run();
} else {
    include 'errors/maintenance.php';
}