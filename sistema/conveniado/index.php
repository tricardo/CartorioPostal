<?
require_once( "../includes/verifica_logado_conv.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$_SESSION['backGroundColor1'] = '#202A72';
$_SESSION['backGroundColor2'] = '#E2A800';
$_SESSION['backGroundImage']  = 'cartorio_postal.png';
$_SESSION['color']            = '#202A72';
$_SESSION['borderColor']      = '#E2A800';

$arquivo = 'perfil/'.$conveniado_id_cliente.'.txt';
if(file_exists($arquivo)) {
	$fd = fopen($arquivo, "r");
	while(!feof($fd)){
		$bff = fgets($fd, 4096);
		$linhas[] = $bff;
	}
	fclose($fd);
	$_SESSION['backGroundColor1'] = $linhas[0];
	$_SESSION['backGroundColor2'] = $linhas[1];
	$_SESSION['backGroundImage']  = $linhas[2];
	$_SESSION['color']            = $linhas[3];
	$_SESSION['borderColor']      = $linhas[4];
}

$pagina = 'ordem.php';
if($_SESSION['pagina']){
	if(strlen($_SESSION['pagina']) >= 9){
		$pagina = $_SESSION['pagina'];
	}
}
require "includes/header.php";
require "includes/topo.php";
echo '<div id="calendario"></div>' . " \n";
echo '<div id="navegacao"></div>' . " \n";
require "includes/footer.php"; ?>