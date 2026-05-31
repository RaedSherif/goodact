<?php

# Structural Design Pattern: Singleton
class DB {
    private static $instance = null;
    private PDO $conn;

    private function __construct() {
        $this->conn = new PDO("mysql:host=mysql-goodact67-goodact67.f.aivencloud.com;port=17526;dbname=defaultdb",
            "avnadmin",
            "AVNS_FOqmoKzOgcfh4zXwTXW"
        );
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
?>