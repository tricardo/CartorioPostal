<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','cartorio_estado');
	pt_register('GET','cartorio_cidade');
	pt_register('GET','cartorio_atribuicao');

	if($browser != 'MSIE') {
		$cartorio_cidade_2 = utf8_decode($cartorio_cidade);
	}	
	
		$sql 	= "SELECT nome, id_cartorio FROM vsites_cartorio WHERE estado = '".$cartorio_estado."' and  (cidade = '".$cartorio_cidade."' or cidade = '".$cartorio_cidade_2."') and status='Ativo' and atribuicao='$cartorio_atribuicao' order by nome";
		$query 	= $objQuery->SQLQuery($sql);
		while($res = mysql_fetch_array($query)){
				$valor .= '<option value="'.$res['id_cartorio'].'">'.$res['nome'].'</option>';
		}
		echo $valor;
?>

		
