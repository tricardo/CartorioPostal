<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once('../../includes/classQuery.php');
			
	// Pesquisa ID localidade-----------------------------------
	$id_categoria	 	= $_GET['id_categoria'];
	$id_subcategoria 		= $_GET['id_subcategoria'];
	// Pesquisa ID localidade-----------------------------------
		if($id_subcategoria){
			$sql 	= "SELECT * FROM vsites_subcategorias WHERE vsites_subcategorias.id_subcategoria = '".$id_subcategoria."'";
			$query 	= $objQuery->SQLQuery($sql);
			$res 	= mysql_fetch_array($query);
			$subcategoria 	= $res['subcategoria'];
			echo '<option value="'.$id_subcategoria.'">'.$subcategoria.'</option>';		
		} else {
		echo '<option value="">Selecione a Subcategoria</option>';		

		}
		
		$sql 	= "SELECT * FROM vsites_subcategorias WHERE id_categoria = '".$id_categoria."' order by subcategoria";
		$query 	= $objQuery->SQLQuery($sql);
		while($res = mysql_fetch_array($query)){
			echo '<option value="'.$res['id_subcategoria'].'">'.$res['subcategoria'].'</option>';
		}
?>

		