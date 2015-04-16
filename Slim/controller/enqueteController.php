<?php

require_once(join(DIRECTORY_SEPARATOR, array(dirname(__DIR__), 'model',strstr(basename(__FILE__), 'Controller', true).'Model.php')));

class EnqueteController extends BaseController {
    public function __construct() {
        $this->MODEL = new EnqueteModel();
    }
    //RETORNAR =================================================================
    
    /**
     * RETORNA DADOS DA ENQUETE POR ID
     * @param int $id
     * @return $dados
     */
    public function retornar($id) {
        $dados = $this->MODEL->retornar($id);
        return $this->criarObjetoDAO($dados);
    }
    
    /**
     * RETORNA A ENQUETE INTEIRA POR ID (Com perguntas e opções)
     * @param int $id
     * @return $dados
     */
    public function retornarTudoId($id) {
        $dados = $this->MODEL->retornarTudoId($id);
        return $this->criarObjetoDAO($dados);
    }
    
    /**
     * RETORNA TODAS AS ENQUETES
     * @return $dados
     */
    public function retornarTudo() {
        $dados = $this->MODEL->retornarTudo();
        return $this->criarArrayObjetoDAO($dados);
    }
    
    /**
     * RETORNA TODAS AS PERGUNTAS POR ID DA ENQUETE
     * @param int $id
     * @return $dados
     */
    public function retornarPerguntasPorEnqueteID($id) {
        $dados = $this->MODEL->retornarPerguntasPorEnqueteID($id);
        return $this->criarArrayObjetoDAO($dados);
    }
    
    /**
     * RETORNA TODAS AS OPÇÕES POR ID DA PERGUNTA
     * @param int $id
     * @return $dados
     */
    public function retornarOpcoesPorPerguntaID($id) {
        $dados = $this->MODEL->retornarOpcoesPorPerguntaID($id);
        return $this->criarArrayObjetoDAO($dados);
    }
    
    /**
     * RETORNA TODAS AS OPÇÕES E RESPOSTAS POR ID DA PERGUNTA
     * @param int $id
     * @return $dados
     */
    public function retornarOpcoesRespostasPorPerguntaID($id) {
        $dados = $this->MODEL->retornarOpcoesRespostasPorPerguntaID($id);
        return $this->criarArrayObjetoDAO($dados);
    }
    
 
    //SALVAR ===================================================================
    /**
     * SALVAR A ENQUETE
     * @param string $nome
     * @param string $descricao
     * @return $dados
     */
    public function salvarEnquete($nome, $descricao) {
        $dados = $this->MODEL->salvarEnquete($nome, $descricao);
        return $dados;
    }
    
    /**
     * SALVAR A PERGUNTA
     * @param int $idEnquete
     * @param string $ordem
     * @param string $titulo
     * @return $dados
     */
    public function salvarPergunta($idEnquete, $ordem, $titulo) {
        $dados = $this->MODEL->salvarPergunta($idEnquete, $ordem, $titulo);
        return $dados;
    }
    
    /**
     * SALVAR A OPÇÃO
     * @param int $idPergunta
     * @param string $titulo
     * @return $dados
     */
    public function salvarOpcao($idPergunta, $titulo) {
        $dados = $this->MODEL->salvarOpcao($idPergunta, $titulo);
        return $dados;
    }
    
    /**
     * SALVAR A RESPOSTA
     * @param int $idOpcao
     * @return $dados
     */
    public function salvarResposta($idOpcao) {
        $dados = $this->MODEL->salvarResposta($idOpcao);
        return $dados;
    }
    
    //EDITAR ===================================================================
    /**
     * EDITAR A ENQUETE POR ID
     * @param int $id
     * @param string $nome
     * @param string $descricao
     * @return $dados
     */
    public function editarEnquete($id, $nome, $descricao) {
        $dados = $this->MODEL->editarEnquete($id, $nome, $descricao);
        return $dados;
    }
    
    /**
     * EDITAR A PERGUNTA POR ID
     * @param int $id
     * @param string $titulo
     * @return $dados
     */
    public function editarPergunta($id, $titulo) {
        $dados = $this->MODEL->editarPergunta($id, $titulo);
        return $dados;
    }
    
    /**
     * EDITAR A OPÇÃO POR ID
     * @param int $id
     * @param string $titulo
     * @return $dados
     */
    public function editarOpcao($id, $titulo) {
        $dados = $this->MODEL->editarOpcao($id, $titulo);
        return $dados;
    }
    
    //REMOVER ==================================================================
    /**
     * REMOVER A ENQUETE POR ID
     * @param int $id
     * @return $dados
     */
    public function remover($id) {
        $dados = $this->MODEL->remover($id);
        return $dados;
    }
}