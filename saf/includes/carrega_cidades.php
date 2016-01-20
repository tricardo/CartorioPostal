<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	require( "../includes/classQuery.php" );
	require( "../includes/global.inc.php" );
	pt_register('GET','id_cidade');
	pt_register('GET','estado');
	// Pesquisa ID localidade-----------------------------------
		$sql 	= "SELECT * FROM vsites_cidades as c WHERE id_cidade = '".$id_cidade."'";
		$query 	= $objQuery->SQLQuery($sql);
		$res 	= mysql_fetch_array($query);
		$valor .= '<option value="'.$res['id_cidade'].'">'.$res['cidade'].'</option>';
	// Pesquisa ID localidade-----------------------------------		
		$sql 	= "SELECT cidade, id_cidade FROM vsites_cidades as c where estado='".$estado."' order by cidade ASC";
		$query 	= $objQuery->SQLQuery($sql);
		while($res = mysql_fetch_array($query)){
				$valor .= '<option value="'.$res['id_cidade'].'">'.$res['cidade'].'</option>';
		}
		echo $valor;
?>

		