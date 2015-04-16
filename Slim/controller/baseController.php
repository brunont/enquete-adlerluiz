<?php
class BaseController {
    public function debug($var) {
        echo "<pre>".var_dump($var)."</pre>";
    }

    public function displayErrors($flag = true) {
        ini_set('display_errors', ($flag) ? 'On' : 'Off');
    }
    
    function criarObjetoDAO($dados){        
        if($dados->num_rows){
            return $dados->fetch_object();
        }else{
            return NULL;
        }
    }
    
    function criarArrayObjetoDAO($dados){        
        if($dados->num_rows){
            while ($obj = $dados->fetch_object()) {
                $arrDados[] = $obj;
            }
            return $arrDados;
        }else{
            return NULL;
        }
    }
    
    public function error(){
        return $this->DAO->stmtError();
    }
}