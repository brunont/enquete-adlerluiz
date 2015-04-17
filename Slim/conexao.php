<?php

class conexaoClass {
    private $DB_HOST = 'localhost';
    private $DB_USER = 'root';
    private $DB_PASS = '';

    public $MYSQLI;
    public $STMT;

    public function __construct() {
        $this->MYSQLI = new mysqli($this->DB_HOST,  $this->DB_USER,  $this->DB_PASS);

        if($this->MYSQLI->connect_error){
            die('Erro de conexão ('.$this->MYSQLI->connect_error.') '.$this->MYSQLI->connect_errno);
        }

        $this->STMT = $this->MYSQLI->stmt_init();
        $this->STMT->prepare("SET SESSION time_zone = '-3:00'");
        $this->STMT->prepare("SET character_set_connection=utf8");
        $this->STMT->prepare("SET character_set_client=utf8");
        $this->STMT->prepare("SET character_set_results=utf8");
        $this->STMT->execute();
        $this->STMT->reset();

        return $this->STMT;
    }

    public function __destruct() {
        $this->STMT->close();
        $this->MYSQLI->close();
    }



}
//---------------------------------------------------
global $CONEXAO;
$CONEXAO = new conexaoClass();
//---------------------------------------------------
