<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
include_once('../includes/classQuery.php');
$id_cidade 	= $_GET['id_cidade'];
$estado 		= $_GET['estado'];
// Pesquisa ID localidade-----------------------------------
$sql 	= "SELECT distinct cidade FROM vsites_localidades WHERE id_cidade = '".$id_cidade."'";
$query 	= $objQuery->SQLQuery($sql);
$res 	= mysql_fetch_array($query);
echo '<option value="'.$res['id_cidade'].'">'.$res['cidade'].'</option>';
// Pesquisa ID localidade-----------------------------------
$sql 	= "SELECT cidade, id_cidade FROM vsites_localidades where estado='$estado' order by cidade ASC";
$query 	= $objQuery->SQLQuery($sql);
while($res = mysql_fetch_array($query)){
	$valor .= '<option value="'.$res['id_cidade'].'">'.$res['cidade'].'</option>';
}
echo $valor;
?>

