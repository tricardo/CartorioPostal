<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
include_once( "../includes/verifica_logado_conveniado.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$erro      = 0;
$msg_error = '';

foreach($_GET as $cp => $valor){
	pt_register('GET', (string) $cp);
}

if(strlen($nova_senha) == 0 || strlen($repetir_senha) == 0){
	$erro 	   = 1;
	$msg_error = 'Você deve digitar as duas senhas!';
}

if(strlen($nova_senha) < 5 || strlen($repetir_senha) < 5){
	$erro 	   = 1;
	$msg_error = 'Você deve digitar uma senha de pelo menos 5 caracteres!';
}

if($nova_senha != $repetir_senha && $erro == 0){
	$erro 	   = 1;
	$msg_error = 'As senhas digitadas são diferentes!';
}


if($erro == 0){
	$nova_senha = $conveniado_login.$nova_senha;
	$nova_senha = md5($nova_senha);
	$ConveniadoDAO = new ConveniadoDAO();				
	$conveniado= $ConveniadoDAO->atualizarSenhaConveniado($nova_senha, $conveniado_id_conveniado);
	echo '<img src="../images/null.gif" onload="RetornaErro(\''.$form.'\', \''.$msg_error.'\', 0);" />' . " \n";
	echo 'Senha alterada com sucesso!';
} else {
	echo '<img src="../images/null.gif" onload="RetornaErro(\''.$form.'\', \''.$msg_error.'\', 1);" />' . " \n";
}
?>