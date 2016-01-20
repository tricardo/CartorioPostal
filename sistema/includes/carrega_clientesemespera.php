<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
session_start();
include_once( '../includes/classQuery.php' );
$controle_login 	= $_SESSION['controle_login'];
$controle_senha 	= $_SESSION['controle_senha'];
$controle_id 		= $_SESSION['controle_id'];
$controle_tabela 	= $_SESSION['controle_tabela'];
$sql = $objQuery->SQLQuery('SELECT * FROM vsites_user_administrador WHERE login = "'.$controle_login.'" and senha="'.$controle_senha.'"');
$row = mysql_fetch_array($sql);
$id_usuario = $row['id_usuario'];
if ($_SESSION['controle_logado'] <> 'ok' and !$row){
	echo '
		<script type="text/javascript"> 
			document.location.replace("login.php"); 
		</script>';
	exit;
}	
		$sql 	= "SELECT * FROM vsites_chat_sessions where situacao='aguardando' order by data ASC";
		$query 	= $objQuery->SQLQuery($sql);
		while($res = mysql_fetch_array($query)){
				$valor .= '<a href="javascript:void(chat_popup(\'chat_popup.php\',\'Atendimento\',300,350,\''.$res['id_chat'].'\' ));">[Atender]</a> <a href="mailto:'.$res['email'].'">[Enviar E-mail]</a> '.$res['nick'].'<br>';
		}
		echo $valor;
?>
<script type="text/javascript">
	setTimeout("carrega_clientesemespera();",10000);
</script>		