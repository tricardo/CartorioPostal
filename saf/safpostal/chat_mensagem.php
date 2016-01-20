<?
require( "../includes/verifica_logado_safpostal.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
?>
<?= '<?xml version="1.0" encoding="iso-8859-1"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/paginas.css" rel="stylesheet" type="text/css" />
<head>
<title>.:Saf Postal:.</title>
</head>

<body>

<div id="mensagem_chat_mensagem">

        <?		
		pt_register('GET','id');
		$sql = $objQuery->SQLQuery("SELECT s.* FROM saf_chat_sessao as s WHERE id_sessao='".$id."'");
		$res = mysql_fetch_array($sql);
		$assunto = $res['assunto'];
		?>

        <strong>Você será atendido por: </strong><? echo $safpostal_nome ?><br />
		<? echo $assunto ?>
        <div id="linha_h3"></div>
           
	<script type="text/javascript">
	window.blur();
	window.focus();
	</script>		
</div>
</body>
</html>