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
	pt_register('GET','id_sessao');
	$sql = $objQuery->SQLQuery("SELECT cse.id_sessao, uu.nome, ue.fantasia FROM saf_chat_sessao as cse, vsites_user_usuario as uu, vsites_user_empresa as ue WHERE cse.id_moderador='$safpostal_id_usuario' and cse.id_sessao='".$id_sessao."' and cse.id_usuario=uu.id_usuario and ue.id_empresa=uu.id_empresa order by cse.data limit 1");
	$res = mysql_fetch_array($sql);
	$id_sessao = $res['id_sessao'];
	$nome = $res['nome'];
	$fantasia = $res['fantasia'];
	?>

        <strong>Franquia/Funcionário: </strong><br><? echo $fantasia.' - '.$nome ?><br />
        <div id="linha_h3"></div>
</div>
</body>
</html>