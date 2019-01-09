<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

use \App\Controller\Protections;

define('ROOT', dirname(__DIR__));

require ROOT . '/app/Autoloader.php';
require ROOT . '/core/Autoloader.php';

\App\Autoloader::register();
\Core\Autoloader::register();

Protections::InjectionSQL();