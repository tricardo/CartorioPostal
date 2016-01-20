<?
session_start();
include_once( '../includes/classQuery.php' );
$notificante_login 	= $_SESSION['notificante_login'];
$notificante_senha 	= $_SESSION['notificante_senha'];
$notificante_id 		= $_SESSION['notificante_id'];
$notificante_tabela 	= $_SESSION['notificante_tabela'];
if($notificante_tabela){
	$sql = $objQuery->SQLQuery("SELECT * FROM ".$notificante_tabela." WHERE email = '".$notificante_login."' and senha='".$notificante_senha."' and status='Ativo'");
	$row = mysql_fetch_array($sql);
	$notificante_nome = $row['nome'];
	$notificante_tel = $row['tel'];
	$notificante_fax = $row['fax'];
	$notificante_id_notificante = $row['id_notificante'];
}
if ($_SESSION['notificante_logado'] != 'ok' or !$row){
	echo '
		<script type="text/javascript"> 
			document.location.replace("../login/"); 
		</script>';
	exit;
}
?>
