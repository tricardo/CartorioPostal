<?php
session_start();
require( '../includes/classQuery.php' );
require( '../includes/browser.php' );
require('../model/Database.php');
require('../includes/funcoes.php');

$_SESSION['conveniado_logado'] 	= '';
$_SESSION['conveniado_login'] 	= '';
$_SESSION['conveniado_senha'] 	= '';
$_SESSION['conveniado_id'] 		= '';
$_SESSION['conveniado_tabela'] 	= '';

$_SESSION['cliente_logado'] 	= '';
$_SESSION['cliente_login'] 		= '';
$_SESSION['cliente_senha'] 		= '';

$browser2 	= new MyBrowser();
$versao 	= $browser2 -> browser('version');
$browser 	= $browser2 -> browser('browser');
if($browser == 'MSIE' and $versao <= '6.0') {
	echo 'Seu internet explorer está desatualizado e está vulnerável a invasão.<br><br>
             Atualize seu internet explorer para a versão 7 ou instale o Firefox.';
	exit;
}
$login 	= str_replace("\'","",$_POST['login']);
$senha 	= str_replace("\'","",$_POST['senha']);

$login = str_replace('#','',$login);
$cliente = explode('/',$login);
if(is_numeric($login)!=1 and COUNT($cliente)==1){
	$senha  = $login.$senha;
	$senha  = md5($senha);
}
$ip	  = explode(',',$_SERVER["HTTP_X_FORWARDED_FOR"]);
$logar = '';

$usuarioDAO = new UsuarioDAO();

try{
	$usuario = $usuarioDAO->login($login,$senha,$ip[0]);
	$departamento_p = explode(',',$usuario->departamento_p);
	$logar = 'SIM';
	
	if($usuario->conveniado_id<>'' and $senha<>''){
			$_SESSION['conveniado_logado'] 	= 'ok';
			$_SESSION['conveniado_login'] 	= $login;
			$_SESSION['conveniado_senha'] 	= $senha;
			$_SESSION['conveniado_id'] 		= $usuario->conveniado_id;
			$_SESSION['conveniado_tabela'] 	= $usuario->conveniado_tabela; 
			echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=../conveniado/index.php">';
	} else {
		if($usuario->id_pedido<>'' and $senha<>''){
			$_SESSION['cliente_logado'] 	= 'ok';
			$_SESSION['cliente_login'] 	= $login;
			$_SESSION['cliente_senha'] 	= $senha;
			echo	'<meta HTTP-EQUIV="refresh" CONTENT="1; URL=../cliente/index.php">';
		} else {
			echo "Login ou Senha inválida<br><br>
			Seu IP é: ".$_SERVER["HTTP_X_FORWARDED_FOR"]." <br>";
			echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=/certidoes/">';
		}
	}
} catch(Exception $e){
	echo "Login ou Senha inválida.<br><br>
		Seu IP é: ".$_SERVER["HTTP_X_FORWARDED_FOR"]." <br>".$e->getMessage();
	echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=/certidoes/">';
}
?>