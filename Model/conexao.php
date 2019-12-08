<?php 

class Conexao {

private $db_user = "";
private $db_password = "";
private static $db_name = "gamesearcher";
private static $instance = null;
private $manager;

    private function __construct() {
        $this->manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        //$this->manager = new MongoClient();
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getManager() {
        return $this->manager;
    }

    public static function getDbName() { return self::$db_name; }
    public static function setDbName($name) { self::$db_name = $name; }

}

?>