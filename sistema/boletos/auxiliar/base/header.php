<?php
session_start();
if($_SESSION['controle_login']!='admin' and $_SESSION['controle_login']!='thiago.menezes@cartoriopostal.com.br'){
	echo $_SESSION['controle_login'].'1';
	exit;
}

require_once ('../base/AcessoException.php');
require_once ('../base/ExceptionList.php');
require_once ('../base/IncludeView.php');
require_once ('../base/Entity.php');
require_once ('../base/Acesso.php');
require_once ('../base/Control.php');
require_once ('../base/PDOSingleton.php');
require_once ('../base/Database.php');

require_once ('../lib/validacoes.php');
require_once ('../lib/formatacoes.php');
require_once ('../lib/funcoes.php');

function __autoload($classe) {
    $dir = ereg('([a-z]+)Acesso', $classe, $result);
    if(is_file("../".$result[1]."/".$result[1]."Acesso.php")) {
        require_once("../".$result[1]."/".$result[1]."Acesso.php");
        return;
    }
    $dir = ereg('([A-Z][a-z]+)DAO', $classe, $result);
    if(is_file("../".strtolower($result[1])."/".$result[1]."DAO.php")) {
        require_once("../".strtolower($result[1])."/".$result[1]."DAO.php");
        return;
    }
    $dir = ereg('([A-Z][a-z]+)', $classe, $result);
    if(is_file("../".strtolower($result[1])."/".$result[1].".class.php")) {
        require_once("../".strtolower($result[1])."/".$result[1].".class.php");
        return;
    }
    $dir = eregi('([a-z]+)', $classe, $result);
    if(is_file("../lib/".$result[1].".php")) {
        require_once("../lib/".$result[1].".php");
        return;
    }
}

$urlBase = 'http://www.cartoriopostal.com.br/sistema/auxiliar/';

$acao = $_GET["acao"];
$valor = $_GET["valor"];
$requisicao = $_GET["requisicao"];
$ajax = ($_POST["ajax"]=="1" || $_GET["ajax"]=="1");
$includes = array();

$acao = (trim($acao)=="")?"index":$acao;

try {
    $acesso = $requisicao."Acesso";
    $acesso = new $acesso();
    $acesso->$acao();

}catch(AcessoException $erro ){
    $erros= array($erro);
    require_once('../base/conteudo.php');
    die();
}

?>