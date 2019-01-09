<?php

/**
 * Ville d'Audruicq
 * Version 2.0 
 * Développé par Mathis Lorthios
 * business@lorthios.email
 */

namespace Core\Database;

use \PDO;

class Database {
	
	public static function PDO() {
		try {
			$host = "127.0.0.1";
			$dbname = "mairie";
			$user = "root";
			$pass = "";
            
			$db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $user, $pass);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec("SET CHARACTER SET utf8mb4");
			return $db;
		}

		catch(PDOException $e) {
			die('La base de données est déconnecté');
		}
	}
	
}
