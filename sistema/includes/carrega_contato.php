<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
        $acesso_conv='ok';
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id_conveniado');
	pt_register('GET','id_cliente');

		$sql 	= "SELECT * FROM vsites_user_conveniado WHERE id_conveniado = '".$id_conveniado."'";
		$query 	= $objQuery->SQLQuery($sql);
		$res 	= mysql_fetch_array($query);
		$nome 				= $res['nome'];
		echo '<option value="'.$id_conveniado.'" selected="select">'.$nome.'</option>';
	// Pesquisa ID localidade-----------------------------------
		$sql 	= "SELECT * FROM vsites_user_conveniado WHERE id_cliente = '".$id_cliente."' and status='Ativo' and id_conveniado!='".$id_conveniado."' order by nome";
		$query 	= $objQuery->SQLQuery($sql);
		while($res 	= mysql_fetch_array($query)){
			$nome 				= $res['nome'];
			$id_conveniado		= $res['id_conveniado'];
			echo '<option value="'.$id_conveniado.'">'.$nome.'</option>';
		}

?>
