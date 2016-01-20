<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
session_start();
include_once( '../includes/classQuery.php' );
$controle_login 	= $_SESSION['controle_login'];
$controle_senha 	= $_SESSION['controle_senha'];
$controle_id 		= $_SESSION['controle_id'];
$controle_tabela 	= $_SESSION['controle_tabela'];
$controle_id_chat 	= $_SESSION['controle_id_chat'];
if($controle_login<>'') {
	$operador = '1';
	$guest = '0';
	$sql = $objQuery->SQLQuery('SELECT * FROM vsites_user_administrador WHERE login = "'.$controle_login.'" and senha="'.$controle_senha.'"');
	$row = mysql_fetch_array($sql);
	$permissao = $row['permissao'];
	$id_usuario = $row['id_usuario'];
	if ($_SESSION['controle_logado'] <> 'ok' and !$row){
		echo '
			<script type="text/javascript"> 
				document.location.replace("login.php"); 
			</script>';
		exit;
	}
}else{
	$guest = '1';
	$operador = '0';
	$sql = $objQuery->SQLQuery("SELECT * FROM vsites_chat_sessions WHERE id_chat = '".$controle_id_chat."' and situacao!='finalizado'");
	$row = mysql_num_rows($sql);
	if (!$_SESSION['controle_id_chat'] and !$row){
		echo '
			<script type="text/javascript"> 
				document.location.replace("../../a_profissionais/atendimento.php"); 
			</script>';
		exit;
	}	
}
		$sql 	= "SELECT * FROM vsites_chat_sessions where id_chat = '".$controle_id_chat."' order by data ASC";
		$query 	= $objQuery->SQLQuery($sql);
		$res = mysql_fetch_array($query);
		$login			= $res['login'];		
		$mensagem_box 	= $_GET['mensagem_box'];
		$sql 			= "insert into vsites_chat(data, id_chat, login, mensagem, operador, guest) values(NOW(), '$controle_id_chat', '$login', '$mensagem_box', '$operador', '$guest')";
		$query 	= $objQuery->SQLQuery($sql);

		echo $valor;
?>

		