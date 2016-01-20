<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','comissionado');
	$departamento = '13';
	$sql = $objQuery->SQLQuery("SELECT * from vsites_user_usuario as uu where status='Ativo' and (departamento_p like '%$departamento%') order by nome");
	while($res = mysql_fetch_array($sql)){
		echo '<option value="'.$res['id_usuario'].'" ';
		if($comissionado==$res['id_usuario']) echo ' selected="selected"'; 
		echo '>'.$res['id_usuario'].' - ' .$res['nome'].'</option>';
	}

?>

		