<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id_servico_var');
	pt_register('GET','valor');
	pt_register('GET','dias');
	$erro="";

	if($valor=='') $valor = 0;
	if($dias=='') $dias = 0;	
	$valor = number_format($valor ,2,".","");
	$sql = $objQuery->SQLQuery("update vsites_servico_var set valor_".$controle_id_empresa."='".$valor."', dias_".$controle_id_empresa."='".$dias."' where id_servico_var='" . $id_servico_var . "'");
?>
<script type="javascript">
	alert('Registro atualizado com sucesso');
</script>