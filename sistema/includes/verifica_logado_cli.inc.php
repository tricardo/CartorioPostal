<?
session_start();
include_once( '../includes/classQuery.php' );
$cliente_login 	= $_SESSION['cliente_login'];
$cliente_senha 	= $_SESSION['cliente_senha'];

if($cliente_login<>''){
	$sql = $objQuery->SQLQuery("SELECT COUNT(0) as total FROM vsites_pedido as p WHERE p.id_pedido = '".$cliente_login."' and md5(CONCAT(p.id_pedido,p.data))='".$cliente_senha."'");
	$row = mysql_fetch_array($sql);
}
if ($_SESSION['cliente_logado'] != 'ok' or !$row){
	echo '
		<script type="text/javascript"> 
			document.location.replace("../login/"); 
		</script>';
	exit;
}
?>