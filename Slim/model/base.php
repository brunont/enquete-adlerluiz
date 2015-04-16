<?php
require_once(join(DIRECTORY_SEPARATOR, array(dirname(dirname(__DIR__)), '/slim/conexao.php')));

class BaseModel {
    private $CONEXAO;
    
    public function __construct() {
        global $CONEXAO;
        $this->CONEXAO =& $CONEXAO;
        
        //SELECÃO DE BANCO DE DADOS PRINCIPAL
        $this->CONEXAO->MYSQLI->select_db('enquete');
    }

    public function STMT() {
        return $this->CONEXAO->STMT;
    }

    public function MYSQLI(){
        return $this->CONEXAO->MYSQLI;
    }
    
    //Statement para SELECT, retorna o resultado
    public function SELECT() {
        $this->STMT()->execute();
        $result = $this->STMT()->get_result();
        $this->STMT()->reset();
        return $result;
    }

    //Statement para INSERT, retorna o id do último ítem adicionado
    public function INSERT() {
        $this->STMT()->execute();
        $result = $this->STMT()->insert_id;
        $this->STMT()->reset();
        return $result;
    }

    //Statement para UPDATE, retorna a linha afetada.
    public function UPDATE() {
        $this->STMT()->execute();
        $result = $this->STMT()->affected_rows;
        $this->STMT()->reset();
        return $result;
    }

    //Statement para DELETE, retorna a linha afetada.
    public function DELETE() {
        $this->STMT()->execute();
        $result = $this->STMT()->affected_rows;
        $this->STMT()->reset();
        return $result;
    }
    
    public function mysqliError() {
        return 'Erro ('.$this->MYSQLI()->error.') '.$this->MYSQLI()->errno;    
    }

    public function stmtError() {
        return 'Erro ('.$this->STMT()->error.') '.$this->STMT()->errno;    
    }

    public function mysqliInsertId() {
        return $this->MYSQLI()->insert_id;
    }

    public function stmtInsertId() {
        return $this->STMT()->insert_id;
    }
}
