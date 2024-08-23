<?php 

class Database {
    private $host = "localhost";
    private $db_name = "library_db";
    private $username = "root";
    private $password = "";

    protected $connection;

    function connection() {
        $this->connection =  new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);

        return $this->connection;
    }
}    