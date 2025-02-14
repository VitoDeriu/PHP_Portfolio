<?php

namespace  App\Config;

use PDO;
use PDOException;
use Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Database{
    private static ?PDO $pdo = null;   // le ? autorise la variable à etre null 

    private function __construct() {
        
    }

    /**
     * Fonction static qui renvoi la connexion a la base de donnée en singleton.
     *
     * @return PDO renvoie un objet de type PDO en singleton.
     */
    public static function getPDO(): ?PDO {
        if(self::$pdo !== null ){
            return self::$pdo;
        }

        $DB_HOST=$_ENV["DB_HOST"];
        $DB_NAME=$_ENV["DB_NAME"];
        $DB_USER=$_ENV["DB_USER"];
        $DB_PASS=$_ENV["DB_PASS"];
        $DB_PORT=$_ENV["DB_PORT"];

        try{

            $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;port=$DB_PORT";
            self::$pdo = new \PDO($dsn, $DB_USER, $DB_PASS);
        
        } catch(PDOException $e){
            echo $e->getMessage();
        }
        return self::$pdo;
    }

}
?>