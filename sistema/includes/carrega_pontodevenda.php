<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id_ponto');
	$departamento = '43';
	$sql = $objQuery->SQLQuery("SELECT pv.* from vsites_pontosdevendas as pv, vsites_user_usuario as uu where pv.status='Ativo' and pv.id_usuario=uu.id_usuario and uu.id_empresa='$controle_id_empresa' order by pv.nome");
	echo '<option value=""></option>';
	while($res = mysql_fetch_array($sql)){
		echo '<option value="'.$res['id_ponto'].'" ';
		if($id_ponto==$res['id_ponto']) echo ' selected="selected"';
		echo '>'.$res['id_ponto'].' - ' .$res['nome'].'</option>';
	}

?>

		
