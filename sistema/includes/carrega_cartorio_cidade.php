<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','cartorio_estado');
	pt_register('GET','cartorio_atribuicao');
		if($cartorio_estado<>'') {
			$onde.=" and estado = '".$cartorio_estado."'";
			if($cartorio_atribuicao<>'') $onde.=" and atribuicao='".$cartorio_atribuicao."' and status='Ativo'";
			$sql 	= "SELECT distinct cidade FROM vsites_cartorio as c WHERE 1=1 ".$onde." order by cidade";
			$query 	= $objQuery->SQLQuery($sql);
			$valor .= '<option value=""></option>';
			while($res = mysql_fetch_array($query)){
					$valor .= '<option value="'.$res['cidade'].'">'.$res['cidade'].'</option>';
			}
		}
		echo $valor;
?>

		