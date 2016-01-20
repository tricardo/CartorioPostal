<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id_departamento');
	pt_register('GET','id_servico');
		$sql 	= "SELECT * FROM vsites_servico WHERE id_servico = '".$id_servico."' and status='Ativo'";
		$query 	= $objQuery->SQLQuery($sql);
		$res 	= mysql_fetch_array($query);
		echo '<option value="'.$id_servico.'">'.$res['descricao'].'</option>';

		$sql 	= "SELECT * FROM vsites_servico WHERE id_departamento = '".$id_departamento."' and status='Ativo' order by descricao";
		$query 	= $objQuery->SQLQuery($sql);
		while($res 	= mysql_fetch_array($query)){
			$descricao			= $res['descricao'];
			$id_servico			= $res['id_servico'];
			echo '<option value="'.$id_servico.'">'.$descricao.'</option>';
		}

?>
