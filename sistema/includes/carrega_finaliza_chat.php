<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
session_start();
include_once( '../includes/classQuery.php' );
$controle_id_chat 	= $_SESSION['controle_id_chat'];
if($controle_id_chat){
		$sql 	= "update vsites_chat_sessions set situacao='finalizado' where id_chat = '".$controle_id_chat."'";
		$query 	= $objQuery->SQLQuery($sql);
}
		echo $valor;
		$_SESSION['controle_id_chat']='';
?>

		