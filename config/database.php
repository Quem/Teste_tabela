<?php

class database {

    private $host = "localhost:3307";
    private $user = "root";
    private $pass = "usbw";
    private $dbname = "Artistas";
    private $conn;
    private $sql;

    public function __construct() {
        $this->conn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname.";charset=utf8";
        $opcoes = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");

        try {
            $this->conn = new PDO($this->conn, $this->user, $this->pass, $opcoes);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }
    
    public function execute() {
        $this->sql->execute();
    }
    
    public function query($sql) {
        $this->sql = $this->conn->prepare($sql);
    }
    
    public function getRow() {
        $this->sql->execute();
        return $this->sql->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $this->sql->execute();
        return $this->sql->fetchAll();
    }

    public function checkDados() {
        $result = $this->sql;
        $result->execute();
        return $result->rowCount();
    }

    public function bind($param, $value,$param) {
        $this->sql->bindValue($param, $value, $param);
    }
    
    public function disconnect() {
        $this->conn = null;
    }
    

}
