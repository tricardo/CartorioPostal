<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
session_start();
include_once( '../includes/classQuery.php' );
$controle_login 	= $_SESSION['controle_login'];
$controle_senha 	= $_SESSION['controle_senha'];
$controle_tabela 	= $_SESSION['controle_tabela'];
$controle_id_chat 	= $_SESSION['controle_id_chat'];
if($_SESSION['controle_login']<>'') {
	$sql = $objQuery->SQLQuery('SELECT * FROM vsites_user_administrador WHERE login = "'.$controle_login.'" and senha="'.$controle_senha.'"');
	$row = mysql_fetch_array($sql);
	if ($_SESSION['controle_logado'] <> 'ok' or !$row){
		echo '
			<script type="text/javascript"> 
				document.location.replace("login.php"); 
			</script>';
		exit;
	}
}else{
	$sql = $objQuery->SQLQuery("SELECT * FROM vsites_chat_sessions WHERE id_chat = '".$controle_id_chat."' and situacao!='finalizado'");
	$row = mysql_num_rows($sql);
	if (!$_SESSION['controle_id_chat'] or !$row){
		echo '
			<script type="text/javascript"> 
				document.location.replace("chat_popup_cliente.php"); 
			</script>';
		exit;
	}	
}
?>
<div style="width:340px;">
<?
		$sql 	= "SELECT vsites_chat_sessions.nick, vsites_chat.mensagem, vsites_chat_sessions.login, vsites_chat.guest, vsites_chat.operador FROM vsites_chat_sessions, vsites_chat where vsites_chat_sessions.id_chat = '".$controle_id_chat."' and vsites_chat.id_chat = vsites_chat_sessions.id_chat order by vsites_chat.data DESC";
		$query 	= $objQuery->SQLQuery($sql);

		while($res = mysql_fetch_array($query)){
			$mensagem		= $res['mensagem'];		
			$operador		= $res['operador'];	
			$guest			= $res['guest'];
			$nick			= $res['nick'];
			$login			= $res['login'];
			if($operador==1) $quem = $login;
			else $quem = $nick;
			$valor .= '--------------------------------------------<br><b>'.$quem.'</b> diz:<br>'.$mensagem.'<br>';
		}
		echo $valor;
?>
</div>
<script type="text/javascript">
	setTimeout("carrega_mensagem_chat('<?= $_SESSION['controle_id_chat'] ?>');",5000);
</script>	
		