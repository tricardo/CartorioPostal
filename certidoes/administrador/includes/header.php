<?
ob_start();
session_start();
$sessao = session_id();
$timestamp = time();
$timeout = time() - 300;
$ip = $_SERVER['REMOTE_ADDR'];
require_once('browser.php');
require_once('funcoes.php');
require_once('global.php');
require_once('classQuery.php');
require_once('redimencionar.php');
if($logar=='Sim'){
	require_once('verifica-logado.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<? require_once('meta-tag.php'); ?>
	<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
	<link href="../controle/favicon.ico" rel="shortcut icon" />
	<script src="../js/jquery/jquery.js" language="javascript" type="text/javascript"></script>
	<script src="../js/jquery/jquery-1.3.2.min.js" language="javascript" type="text/javascript"></script>
	<script src="../js/jquery/jquery.cycle.all.min.js" language="javascript" type="text/javascript"></script>
	<script src="../js/jquery/jquery.cycle.js" language="javascript" type="text/javascript"></script>
	<script src="../js/jquery/jcarousellite_1.0.1.min.js" language="javascript" type="text/javascript"></script>
	<script src="../js/jquery/carrosel.js" language="javascript" type="text/javascript"></script>
	<script src="../js/shadowbox/shadowbox.js" language="javascript" type="text/javascript"></script>
	<script src="../js/maskedinput.js" language="javascript" type="text/javascript"></script>
	<script src="../js/mask_form.js" language="javascript" type="text/javascript"></script>
	<script src="../js/js.js" language="javascript" type="text/javascript"></script>
</head>
<body onload="Hours_Start()" class="body">
<div class="header">
		<a href="index.php" title="Página inicial"><img src="../images/paginas/logo-softfox.png" alt="logo-softfox" /></a>
	<div class="info_usuario">
		<?
		$sql = $objQuery->SQLQuery("SELECT us.id_usuario, us.usuario, l.id_usuario, date_format(l.data_login, '%d/%m/%Y &agrave;s %H:%i:%s') as data_login FROM cp_user as us, cp_log_acesso as l WHERE us.st_id='1' AND l.id_usuario=us.id_usuario AND l.id_usuario = '".$controle_id_usuario."' ORDER BY l.data_login DESC");
		$row = mysql_fetch_array($sql);
		$controle_id_usuario	= $row['id_usuario'];
		$data_login				= $row['data_login'];
		?>
		<strong>Usuário: <? echo $controle_usuario ?></strong><br /><br />
		<strong>Último login: <? echo $data_login ?></strong>
	</div>
	<div class="fundo_data_hora">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		<td align="center" valign="middle" height="20">
			<strong style="font-size:12px;font-weight:normal;color:#FFFFFF;"><?require_once('data.php');?></strong>
		</td>
		</tr>
		<tr>
		<td align="center" valign="middle">
			<span id="relogio" class="relogio"></span>
		</td>
		</tr>
		</table>
	</div>
	<div class="menu_principal">
		<?require_once('menu-principal.php');?>
	</div>
</div>