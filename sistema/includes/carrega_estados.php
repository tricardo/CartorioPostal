<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once('../includes/classQuery.php');
	$estado = $_GET['estado'];
		echo '<option value="'.$estado.'">'.$estado.'</option>';
	// Pesquisa ID cidade-----------------------------------		
		$sql 	= "SELECT distinct estado FROM vsites_localidades order by estado ASC";
		$query 	= $objQuery->SQLQuery($sql);
		while($res = mysql_fetch_array($query)){
				$valor .= '<option value="'.$res['estado'].'">'.$res['estado'].'</option>';
		}
		echo $valor;
?>

		