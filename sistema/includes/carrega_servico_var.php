<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id_servico');
	pt_register('GET','id_servico_var');

		$sql 	= "SELECT * FROM vsites_servico_var WHERE id_servico_var = '".$id_servico_var."'";
		$query 	= $objQuery->SQLQuery($sql);
		$res 	= mysql_fetch_array($query);
			$variacao			= $res['variacao'];
			$id_servico_var		= $res['id_servico_var'];
			echo '<option value="'.$id_servico_var.'">'.$variacao.'</option>';
	// Pesquisa ID localidade-----------------------------------
		$sql 	= "SELECT * FROM vsites_servico_var WHERE id_servico = '".$id_servico."' order by variacao";
		$query 	= $objQuery->SQLQuery($sql);
		while($res 	= mysql_fetch_array($query)){
			$variacao			= $res['variacao'];
			$id_servico_var		= $res['id_servico_var'];
			echo '<option value="'.$id_servico_var.'">'.$variacao.'</option>';
		}

?>
