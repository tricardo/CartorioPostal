<?
ob_start();
session_start();
$sessao = session_id();
$timestamp = time();
$timeout = time() - 300;
$ip = $_SERVER['REMOTE_ADDR'];
require_once('../includes/browser.php');
require_once('../includes/funcoes.php');
require_once('../includes/global.php');
require_once('../includes/classQuery.php');
if($logar=='Sim'){
	require_once('../includes/verifica-logado.php');
}

pt_register('GET','id');
$sql = $objQuery->SQLQuery("SELECT *, date_format(cr.data, '%d/%m/%Y') as data FROM cp_curriculo as cr WHERE cr.id_curriculo='" .$id. "'");
$res = mysql_fetch_array($sql);
$id_curriculo		= $res['id_curriculo'];
$area_pretendida	= $res['area_pretendida'];
$nome				= $res['nome'];
$email				= $res['email'];
$tel_cont			= $res['tel_cont'];
$tel_cel			= $res['tel_cel'];
$mensagem			= $res['mensagem'];
$data				= $res['data'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<? require_once('../includes/meta-tag.php'); ?>
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
<body>

<table width="100%" border="0" cellspacing="3" cellpadding="2" bgcolor="#CCCCCC" style="margin:0 auto;">
	<tr>
		<td colspan="5" align="center" valign="midlle=" bgcolor="#FFFFFF">
			<img src="../images/paginas/logo-canal-dos-profissionais.jpg" alt="logo-canal-dos-profissionais">
		</td>
	</tr>
	<tr>
		<td colspan="5" width="20%" align="left" valign="top" bgcolor="#FFFFFF">
		<h2 class="faixa_titulo" style="text-transform:uppercase;">CURRÍCULO ENVIAdO POR: <?= $nome?></h2>
		</td>
	</tr>
	<tr>
		<td width="20%" align="left" valign="top" bgcolor="#FFFFFF">
			<h2 class="faixa_titulo">Número do candidato</h2>
			<p><?= $id_curriculo?></p><br />
		</td>
		<td width="20%" align="left" valign="top" bgcolor="#FFFFFF">
			<h2 class="faixa_titulo">Nome contato</h2>
			<p><?= $nome?></p><br />
		</td>
		<td width="20%" align="left" valign="top" bgcolor="#FFFFFF">
			<h2 class="faixa_titulo">Email</h2>
			<p><?= $email?></p><br />
		</td>
		<td width="20%" align="left" valign="top" bgcolor="#FFFFFF">
			<h2 class="faixa_titulo">Telefone de contato</h2>
			<p><?= $tel_cont?></p><br />
		</td>
		<td width="20%" align="left" valign="top" bgcolor="#FFFFFF">
			<h2 class="faixa_titulo">Telefone de celular</h2>
			<p><?= $tel_cel?></p><br />
		</td>
	</tr>
	<tr>
		<td colspan="3" width="80%" align="left" valign="top" bgcolor="#FFFFFF">
			<h2 class="faixa_titulo">observação</h2>
			<p><?= $mensagem?></p><br />
		</td>
		<td width="10%" align="left" valign="top" bgcolor="#FFFFFF">
			<h2 class="faixa_titulo">Data do envio</h2>
			<p><?= $data?></p><br />
		</td>
		<td colspan="5" width="100%" align="left" valign="top" bgcolor="#FFFFFF">
			<h2 class="faixa_titulo">Imprimir</h2>
			<a href="javascript:self.print()" title="Clique para imprimir as informações"><img src="../images/paginas/bt-print.png" alt="bt-print"></a>
		</td>
	</tr>
</table>
</body>
</html>