<?php
class Db{
    public $host;
    public $db_name;
    public $username;
    public $password;
    
    public function __construct()
    {
        $this->db_name = 'helix_db';
        $this->username = 'root';
        $this->password = '';
        $this->host = 'localhost';
    }

    public function connect(){
        $conn = new mysqli($this->host, $this->username, $this->password, $this->db_name) OR die("Connection failed: " . mysqli_connect_error());

        return $conn;
    }


}