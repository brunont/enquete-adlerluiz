<?php

session_start();

require '../Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
ini_set('display_errors', true);
require '/model/base.php';
require '/controller/baseController.php';

require '/controller/enqueteController.php';

$enqueteController = new EnqueteController();

$retorno = Array();
$retorno['executou'] = false;

function retornar($var) {
    global $retorno, $_SESSION;
    if ($var) {
        $retorno['executou'] = true;
        $retorno['resultado'] = $var;
    }
}

/* function logar($var) {
  global $retorno, $_SESSION;
  if($var) {
  $_SESSION['logado'] = true;
  $_SESSION['login'] = Array();
  $_SESSION['idPessoa'] = $var->int_id;
  $_SESSION['usuario'] = $var->login;
  $_SESSION['perfil'] = $var->perfil;  //18 = ADMIN | 19 - EXECUTOR DE TRABALHO

  $retorno['login'] = Array();
  $retorno['login']['idPessoa'] = $var->int_id;
  $retorno['login']['usuario'] = $var->login;
  $retorno['login']['perfil'] = $var->perfil; //18 = ADMIN | 19 - EXECUTOR DE TRABALHO
  $retorno['executou'] = true;
  $retorno['resultado'] = $var;
  }
  } */

$app = new \Slim\Slim();

$app->response()->header('Content-type', 'application/json;charser=utf-8');

//RECUPERAR TODAS AS ENQUETES
$app->get('/', function() {
    global $enqueteController;

    $r = $enqueteController->retornarTudo();
    retornar($r);
});

//RECUPERAR ENQUETE PELO ID
$app->get('/enquete/:id', function($id) {
    global $enqueteController;

    $r = Array();

    $r['enquete'] = $enqueteController->retornar($id);
    $r['pergunta'] = Array();
    $r['pergunta'] = $enqueteController->retornarPerguntasPorEnqueteID($id);

    //$opcao = Array();
    if ($r['pergunta']) {
        foreach ($r['pergunta'] as $i => $p) {
            $r['opcao'][$i] = $enqueteController->retornarOpcoesPorPerguntaID($p->int_idapergunta);
            //array_push( $opcao, $enqueteController->retornarOpcoesPorPerguntaID($p->int_idapergunta) );
        }
    }

    //$r = array_merge($r['pergunta'], $r['opcao']);

    retornar($r);
});

//RESPONDER ENQUETE
$app->post('/enquete/responder', function() {
    global $app, $enqueteController;

    $req = json_decode($app->request->getBody());
    $respostas = $req->respostas;
    //print_r($materiais);

    if (sizeof($respostas)) {
        foreach ($respostas as $resposta) {
            //$valorUnitario  = $material->valorUnitario;
            if ($enqueteController->salvarResposta($resposta)) {
                
            } else {
                exit;
            }
        }
        retornar(true);
    } else {
        retornar(false);
    }
});

//SALVAR ENQUETE
$app->post('/enquete/salvar', function() {
    global $app, $enqueteController;

    $req = json_decode($app->request->getBody());
    $titulo = $req->titulo;
    $descricao = $req->descricao;
    $pergunta = $req->pergunta;

    $idEnquete = $enqueteController->salvarEnquete($titulo, $descricao);

    if ($idEnquete) {
        foreach ($pergunta as $key => $p) {
            $idPergunta = $enqueteController->salvarPergunta($idEnquete, $key + 1, $p->titulo);

            foreach ($p->opcao as $o) {
                $enqueteController->salvarOpcao($idPergunta, $o);
            }
        }
        retornar(true);
    } else {
        retornar(false);
    }
});

//EDIÇÃO DA ENQUETE
$app->post('/enquete/editar', function() {
    global $app, $enqueteController;

    $req = json_decode($app->request->getBody());
    $objEnquete = $req->enquete;
    $objPergunta = $req->pergunta;
    $objOpcao = $req->opcao;
    //echo '<pre>';
    //var_dump($req);
    $enqueteController->editarEnquete($objEnquete->int_idaenquete, $objEnquete->vhr_nome, $objEnquete->vhr_descricao);

    foreach ($objPergunta as $key => $p) {
        $enqueteController->editarPergunta($p->int_idapergunta, $p->vhr_titulo);
        foreach ($objOpcao[$key] as $o) {
            $enqueteController->editarOpcao($o->int_idaopcao, $o->vhr_titulo);
        }
    }

    retornar(true);
});

//REMOÇÃO DA ENQUETE
$app->post('/enquete/remover', function() {
    global $app, $enqueteController;

    $req = json_decode($app->request->getBody());
    $id = $req->id;

    $r = $enqueteController->remover($id);

    retornar($r);
});

$app->get('/relatorio/enquete/:id', function($id) {
    global $enqueteController;

    $r = Array();

    $r['enquete'] = $enqueteController->retornar($id);
    $r['pergunta'] = $enqueteController->retornarPerguntasPorEnqueteID($id);

    if ($r['pergunta']) {
        foreach ($r['pergunta'] as $i => $p) {
            $r['opcao'][$i] = $enqueteController->retornarOpcoesRespostasPorPerguntaID($p->int_idapergunta);
        }
    }

    retornar($r);
});

$app->run();

echo json_encode($retorno);
