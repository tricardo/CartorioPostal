<?	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','tipo_impresso');
	$sql 	= "SELECT * FROM vsites_impresso WHERE tipo_impresso = '$tipo_impresso'";
	$query 	= $objQuery->SQLQuery($sql);
	$res = mysql_fetch_array($query);
	$valor = $res['texto'];
	echo $valor;
?>