<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
        $acesso_conv='ok';
	require( "../includes/verifica_logado_ajax.inc.php");
        
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );
	pt_register('GET','id_servico_var');
	pt_register('GET','form');
		$sql 	= "SELECT valor_".$controle_id_empresa.", dias_".$controle_id_empresa." FROM vsites_servico_var WHERE id_servico_var = '".$id_servico_var."'";
		$query 	= $objQuery->SQLQuery($sql);
		$res 	= mysql_fetch_array($query);
		$valor	= $res['valor_'.$controle_id_empresa];
		$dias	= $res['dias_'.$controle_id_empresa];
?>
<script type="text/javascript">
	 document.<?= $form ?>.valor.value='<?= $valor ?>';
	 document.<?= $form ?>.dias.value='<?= $dias ?>';
</script>