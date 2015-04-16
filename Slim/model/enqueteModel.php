<?php

class EnqueteModel extends BaseModel {
    function __construct() {
        parent::__construct();
    }
    //RETORNAR =================================================================
    
    /**
     * RETORNA DADOS DA ENQUETE POR ID
     * @param int $id
     * @return $dados
     */
    function retornar($id) {
        $SQL = "SELECT
                    *
                FROM
                    tbl_enquete as e
                WHERE	
                    e.int_idaenquete = ?";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param('i', $id);
        return parent::SELECT();
    }
    
    /**
     * RETORNA A ENQUETE INTEIRA POR ID (Com perguntas e opções)
     * @param int $id
     * @return $dados
     */
    function retornarTudoId($id) {
        $SQL = "SELECT
                    *
                FROM
                    tbl_enquete as e
                INNER JOIN
                    tbl_pergunta as p
                ON
                    p.int_idfenquete = e.int_idaenquete
                INNER JOIN
                    tbl_opcao as o
                ON 
                    o.int_idfpergunta = p.int_idapergunta
                WHERE	
                    e.int_idaenquete = ?";
        parent::STMT()->prepare($SQL);
        return parent::SELECT();
    }
    
    /**
     * RETORNA TODAS AS ENQUETES
     * @return $dados
     */
    function retornarTudo() {
        $SQL = "SELECT
                    *
                FROM
                    tbl_enquete
                ORDER BY
                    dte_criacao
                DESC";
        parent::STMT()->prepare($SQL);
        return parent::SELECT();
    }
    
    /**
     * RETORNA TODAS AS PERGUNTAS POR ID DA ENQUETE
     * @param int $id
     * @return $dados
     */
    function retornarPerguntasPorEnqueteID($id) {
        $SQL = "SELECT
                    *
                FROM
                    tbl_pergunta
                WHERE
                    int_idfenquete = ?";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param('i', $id);
        return parent::SELECT();
    }
    
    /**
     * RETORNA TODAS AS OPÇÕES POR ID DA PERGUNTA
     * @param int $id
     * @return $dados
     */
    function retornarOpcoesPorPerguntaID($id) {
        $SQL = "SELECT
                    *
                FROM
                    tbl_opcao
                WHERE
                    int_idfpergunta = ?";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param('i', $id);
        return parent::SELECT();
    }
    
    /**
     * RETORNA TODAS AS OPÇÕES E RESPOSTAS POR ID DA PERGUNTA
     * @param int $id
     * @return $dados
     */
    function retornarOpcoesRespostasPorPerguntaID($id) {
        $SQL = "SELECT
                    *,
                    (select count(*) from tbl_voto where int_idfopcao = o.int_idaopcao) as qtde_voto
                FROM
                    tbl_opcao as o
                WHERE
                    o.int_idfpergunta = ?";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param('i', $id);
        return parent::SELECT();
    }
  
    //SALVAR ===================================================================
    /**
     * SALVAR A ENQUETE
     * @param string $nome
     * @param string $descricao
     * @return $dados
     */
    function salvarEnquete($nome, $descricao) {
        $SQL = "INSERT INTO
                    tbl_enquete
                (
                    vhr_nome,
                    vhr_descricao,
                    dte_criacao
                )
                VALUES 
                    (?,?,NOW())";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param("ss", $nome, $descricao);
        return parent::INSERT();
    }
    
    /**
     * SALVAR A PERGUNTA
     * @param int $idEnquete
     * @param string $ordem
     * @param string $titulo
     * @return $dados
     */
    function salvarPergunta($idEnquete, $ordem, $titulo) {
        $SQL = "INSERT INTO
                    tbl_pergunta
                (
                    int_idfenquete,
                    int_ordem,
                    vhr_titulo
                )
                VALUES 
                    (?,?,?)";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param("iis", $idEnquete, $ordem, $titulo);
        return parent::INSERT();
    }
    
    /**
     * SALVAR A OPÇÃO
     * @param int $idPergunta
     * @param string $titulo
     * @return $dados
     */
    function salvarOpcao($idPergunta, $titulo) {
        $SQL = "INSERT INTO
                    tbl_opcao
                (
                    int_idfpergunta,
                    vhr_titulo
                )
                VALUES 
                    (?,?)";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param("is", $idPergunta, $titulo);
        return parent::INSERT();
    }
    
    /**
     * SALVAR A RESPOSTA
     * @param int $idOpcao
     * @return $dados
     */
    function salvarResposta($idOpcao) {
        $SQL = "INSERT INTO
                    tbl_voto
                VALUES 
                    (null, ?)";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param("i", $idOpcao);
        return parent::INSERT();
    }
    
    //EDITAR ===================================================================
    /**
     * EDITAR A ENQUETE POR ID
     * @param int $id
     * @param string $nome
     * @param string $descricao
     * @return $dados
     */
    function editarEnquete($id, $nome, $descricao) {
        $SQL = "UPDATE
                    tbl_enquete
                SET
                    vhr_nome = ?,
                    vhr_descricao = ?
                WHERE
                    int_idaenquete = ?";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param("ssi",  $nome, $descricao, $id);
        return parent::UPDATE();
    }
    
    /**
     * EDITAR A PERGUNTA POR ID
     * @param int $id
     * @param string $titulo
     * @return $dados
     */
    function editarPergunta($id, $titulo) {
        $SQL = "UPDATE
                    tbl_pergunta
                SET
                    vhr_titulo = ?
                WHERE
                    int_idapergunta = ?";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param("si",  $titulo, $id);
        return parent::UPDATE();
    }
    
    /**
     * EDITAR A OPÇÃO POR ID
     * @param int $id
     * @param string $titulo
     * @return $dados
     */
    function editarOpcao($id, $titulo) {
        $SQL = "UPDATE
                    tbl_opcao
                SET
                    vhr_titulo = ?
                WHERE
                    int_idaopcao = ?";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param("si",  $titulo, $id);
        return parent::UPDATE();
    }
    
    //REMOVER ==================================================================
    /**
     * REMOVER A ENQUETE POR ID
     * @param int $id
     * @return $dados
     */
    function remover($id) {
        $SQL = "DELETE FROM
                    tbl_enquete
                WHERE
                    int_idaenquete = ?";
        parent::STMT()->prepare($SQL);
        parent::STMT()->bind_param('i', $id);
        return parent::DELETE();
    }
}