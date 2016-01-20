<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id_servico');
	$p_valor='<table width="340" cellpadding="4" cellspacing="1" class="result_tabela">';
		$sql 	= "SELECT variacao, valor_".$controle_id_empresa.", dias_".$controle_id_empresa." FROM vsites_servico_var as sv WHERE id_servico = '".$id_servico."' order by variacao";
		$query 	= $objQuery->SQLQuery($sql);
		while($res 	= mysql_fetch_array($query)){
		$p_valor .= '<tr><td width="250" class="result_celula" >'.$res['variacao'].' </td><td width="50" class="result_celula" > R$ '.$res['valor_'.$controle_id_empresa].' </td><td width="40" class="result_celula" > Prazo: '.$res['dias_'.$controle_id_empresa].'</td><tr>';
		}
		$p_valor .='</table>';
		echo $p_valor;

?>
