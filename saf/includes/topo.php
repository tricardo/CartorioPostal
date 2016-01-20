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
<link href="../css/shadowbox.css" rel="stylesheet" type="text/css" />
<script src="../js/ajax.js" language="javascript" type="text/javascript"></script>
<script src="../js/jquery.js" language="javascript" type="text/javascript"></script>
<script src="../js/shadowbox/shadowbox.js" language="javascript" type="text/javascript"></script>
<script src="../js/js.js" type="text/javascript"></script>
<title>.:Saf Postal:.</title>
<script language="javascript" type="text/javascript">
Shadowbox.init({
    language: 'pt',
    continuous: true,
    counterType: "skip",
    gallery: "mustang",
    handleOversize: "drag",
    player: ['img', 'html', 'swf']
});
</script>
</head>
<body>
<div id="estrutura">
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><img src="../images/estrutura/topo/topo1.png" width="189" height="100" /><img src="../images/estrutura/topo/topo2.png" width="176" height="100" /><img src="../images/estrutura/topo/topo3.png" width="180" height="100" /><img src="../images/estrutura/topo/topo4.png" width="201" height="100" /><img src="../images/estrutura/topo/topo5.png" width="214" height="99" /></td>
  </tr>
</table>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td background="../images/estrutura/fundo/fundo1.png">
<!--estrutura-->
<div id="estrutura_saf">

<!--usuario-->
<div class="texto1" id="usuario_saf">
Seja Bem vindo <? echo $safpostal_nome ?> ao Serviço de Atendimento ao Franqueado!
<a href="sair.php" title="Clique aqui"><span style="color:#FFFFFF; font-weight: bold">SAIR</span></a></div>

<!--data-->
<div class="texto1" id="data_saf">
<span style="color:#FFFFFF"><script src="../js/data.js" type="text/javascript"></script></span>
</div>
</div>