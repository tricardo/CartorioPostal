<?
require( "../includes/verifica_logado_safpostal.inc.php" );
require( '../includes/classQuery_sistecart.php' );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

?>
<?= '<?xml version="1.0" encoding="iso-8859-1"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<head>

<link href="../css/paginas.css" rel="stylesheet" type="text/css" />
<link href="../css/estilo.css" rel="stylesheet" type="text/css" />
<script src="../js/js.js" type="text/javascript"></script>

<title>.:Saf Postal:.</title>
</head>

<body>


<?
pt_register('GET','id');
$sql = $objQuery->SQLQuery("SELECT *,m.id_maladireta, m.assunto, m.texto, date_format(m.data, '%d/%m/%y %h:%m:%s') as data
										FROM saf_maladireta as m WHERE m.id_maladireta='" .$id. "'");

$res = mysql_fetch_array($sql);
$id_maladireta	= $res['id_maladireta'];
$assunto		= $res['assunto'];
$texto			= $res['texto'];
$data			= $res['data'];
?>


		<table border="0" width="70%" align="center" cellpadding="4" cellspacing="1" class="tabela3">
		<tr>
		<td align="center" colspan="2" height="100"><img src="../images/logo1.png"></td>
		</tr>
		<tr>
		<td height="20" colspan="2" align="left" valign="top" bgcolor="#EBEFF1"><strong>COMUNICADOS</strong></td>
		</tr>
		<tr>
		<td width="515" height="20" align="left" valign="top"><strong>COMUNICAO <?echo $id_maladireta ?></strong>: <?echo $assunto ?></td>
		<td width="221" height="20" align="left" valign="top"><strong>DATA:</strong> <?echo $data ?></td>
		</tr>
		<tr>
		<td colspan="2" align="left" valign="top"><strong>TEXTO:</strong></td>
		</tr>
		<tr>
		<td colspan="2" align="left" valign="middle"><?echo $texto ?></td>
		</tr>
		</table>
</body>
</html>