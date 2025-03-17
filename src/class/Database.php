<?php

class Database
{

    private static $instance;
    private $conn;
    private function __construct() {
        
        try {
            $this->conn = new PDO('mysql:host=158.69.48.109; dbname = dbknapsak6; charset=utf8', 'joueur6', 'hx843s4s');

            // $this->conn = new PDO("mysql:host=" . CONFIGURATIONS["servername"] . ";dbname=" . CONFIGURATIONS["dbname"], CONFIGURATIONS["username"], CONFIGURATIONS["password"], DB_PARAMS);
          
        } catch(PDOException $e) {
            
            throw new PDOException($e->getMessage(), $e->getCode());

          }
      
    }

    public static function getInstance() : Database {

        if( is_null(self::$instance) ) {

            self::$instance = new Database();

        }

        return self::$instance;
    }

    public function getPDO() : PDO {

        return $this->conn;

    }

    public function closeConnection(): void
    {
        $this->conn = null;
        self::$instance = null;
    }


}