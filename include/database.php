<?php 

class database{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'library_db';
    
    protected $connection_var;

    function connection() {
        $this->connection_var = new PDO("mysql:host=$this->host; dbname=$this->dbname", $this->username, $this->password);
        return $this->connection_var;
    }
}   