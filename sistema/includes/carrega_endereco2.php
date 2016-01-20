<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
    pt_register('GET','cep');
	pt_register('GET','form');
	$cep = str_replace('-', '', $cep);
	$sql = $objQuery->SQLQuery("SELECT * from cep_logr where cep='" . $cep . "' limit 1");
	$res = mysql_fetch_array($sql);
	$endereco		= $res['endereco'];
	$bairro	        = $res['bairro'];
	$cidade			= $res['cidade'];
	$estado			= $res['estado'];
    if(mysql_num_rows($sql)){
?>
<script type="text/javascript">
	 document.<?= $form ?>.endereco_f.value='<?= $endereco ?>';
	 document.<?= $form ?>.bairro_f.value='<?= $bairro ?>';
	 document.<?= $form ?>.cidade_f.value='<?= $cidade ?>';
	 document.<?= $form ?>.estado_f.value='<?= $estado ?>';
</script>
<? } ?>