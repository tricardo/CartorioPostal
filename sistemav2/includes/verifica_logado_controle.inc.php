<?php
ob_start();
session_start();
ini_set("session.cache_expire",3600);
define('AUTOLOAD_CLASS',1);


if(substr_count($_SERVER["HTTP_HOST"],"127.0.0.1") > 0){
    define('PRODUCAO',1);
} else {
    define('PRODUCAO',0);
}

require("funcoes.php");
require("global.inc.php");
require_once('includes/classQuery.php');
require_once('model/Database.php');


if((!isset($_SESSION['controle_logado']) OR $_SESSION['controle_logado'] != 'ok') OR $_SESSION['controle_teste'] == 'Sim'){
    header('location:sair.php');
    exit;
} 

$controle_login 	= $_SESSION['controle_login'];
$controle_senha 	= $_SESSION['controle_senha'];
$controle_atividade	= $_SESSION['controle_atividade'];

if($controle_login){
    $usuarioDAO = new UsuarioDAO();
    $controle_cp   = $usuarioDAO->verifica_logado($controle_login,$controle_senha); 
    $controle_nome = $controle_cp->nome;
    $controle_email = $controle_cp->email;
    $controle_sexo = (isset($controle_cp->sexo)) ? $controle_cp->sexo : '';
    $controle_tel  = $controle_cp->tel;
    $controle_fax  = (isset($controle_cp->fax)) ? $controle_cp->fax : '';
    $controle_id_empresa = $controle_cp->id_empresa;
    $controle_id_pais = $controle_cp->id_pais;
    $controle_id_usuario = $controle_cp->id_usuario;
    $controle_id_departamento_p = $controle_cp->departamento_p;
    $controle_id_departamento_s = $controle_cp->departamento_s;

    $departamento_s = strlen($controle_cp->departamento_s) > 0 ? explode(',',$controle_cp->departamento_s) : array();
    $departamento_p = strlen($controle_cp->departamento_p) > 0 ? explode(',',$controle_cp->departamento_p) : array();
    if(count($departamento_s)){ foreach($departamento_s as $l){	$controle_depto_s[$l]='1';	} }
    if(count($departamento_p)){ foreach($departamento_p as $l){	$controle_depto_p[$l]='1';	} }
    if($controle_id_departamento_p==''){
        echo 'Entre em contato com o Administrador do Cartório Postal!';
        exit;
    }
    $VARS = $controle_cp;
    $VARS->departamento_s = $departamento_s;
    $VARS->departamento_p = $departamento_p;
}

if((!isset($_SESSION['controle_logado']) OR $_SESSION['controle_logado'] != 'ok') OR $_SESSION['controle_teste'] == 'Sim' OR (!isset($controle_cp->id_empresa) OR $controle_cp->id_empresa == '')){
    header('location:sair.php');
    exit;
} 

$data_init_cp = '2015-06-04';
if($controle_id_empresa != 1){
    $data_init_cp = '2015-06-04';
}



if(PRODUCAO == 0){
    define('MyURL', 'http://www.cartoripostal.com.br/sistemav2/');
} else {
    define('MyURL', 'http://127.0.0.1/cartoriopostal.com.br/sistemav2/');
}
