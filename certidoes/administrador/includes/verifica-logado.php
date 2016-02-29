<?
ini_set("session.cache_expire",9600);
session_start();
$controle_login = $_SESSION['controle_login'];
$controle_senha = $_SESSION['controle_senha'];
if($controle_login){
	$sql = $objQuery->SQLQuery("SELECT us.id_usuario, us.email, us.usuario, us.permissao_p, us.permissao_s FROM cp_user as us WHERE us.email = '".$controle_login."' AND us.senha = '".$controle_senha."' and us.st_id='1'");
	$row = mysql_fetch_array($sql);
	$controle_usuario		= $row['usuario'];
	$controle_email			= $row['email'];
	$controle_id_usuario	= $row['id_usuario'];
	$controle_permissao_p	= $row['permissao_p'];
	$controle_permissao_s	= $row['permissao_s'];
	$excluir_permissao_s = explode(',',$controle_permissao_s);
}
if ($_SESSION['controle_logado'] != 'ok' or !$row){
	echo '
		<script type="text/javascript"> 
		document.location.replace("../login/index.php"); 
		</script>';
	exit;
}
?>