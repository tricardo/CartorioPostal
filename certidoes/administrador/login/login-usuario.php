<?
session_start();
require_once('../includes/classQuery.php');
require_once('../includes/browser.php');
require_once('../includes/global.php');
$_SESSION['controle_logado'] = '';
$_SESSION['controle_login'] = '';
$_SESSION['controle_senha'] = '';
$_SESSION['controle_id_usuario'] = '';
$browser2 = new MyBrowser();
$versao = $browser2 -> browser('version');
$browser = $browser2 -> browser('browser');
if($browser == 'MSIE' and $versao <= '6.0'){
	echo 'Seu Internet Explorer está desatualizado e está vulnerável a invasão.<br><br>
	Atualize seu Internet Explorer para a versão 7 ou instale o Mozila Firefox.';
	exit;
}
$login = str_replace("'","",$_POST['login']);
$senha = str_replace("'","",$_POST['senha']);
$ip = getenv("REMOTE_ADDR");
$logar = '';
$login = ValidarStr($login);
$senha = ValidarStr($senha);
$senha = $login.$senha;
$senha = md5($senha);
$sql = "SELECT us.id_usuario FROM cp_user as us WHERE us.email = '".$login."' AND us.senha = '".$senha."' and us.st_id='1'";
$query = $objQuery->SQLQuery($sql);
$row = mysql_num_rows($query);
$res = mysql_fetch_array($query);
$id_usuario = $res['id_usuario'];
if ($row<>''){
	$logar = 'SIM';
	$controle_id_usuario = 'id_usuario';
	$sql = "INSERT INTO cp_log_acesso SET data_login=NOW(), id_usuario = '".$id_usuario."', ip='".$ip."'";
	$query = $objQuery->SQLQuery($sql);
}
if ($logar=='' || $login == '' || $senha == ''){
	echo "Login ou Senha inválida. ou o seu ip não está cadastrado para acessar nosso sistema.<br><br>
	Seu IP é: ".$ip;
?>
<meta HTTP-EQUIV="refresh" CONTENT="1; URL=index.php">
<?
}else{
	$_SESSION['controle_logado'] = 'ok';
	$_SESSION['controle_login'] = $login;
	$_SESSION['controle_senha'] = $senha;
?>
<meta HTTP-EQUIV="refresh" CONTENT="1; URL=../controle/index.php">
<?
}
?>