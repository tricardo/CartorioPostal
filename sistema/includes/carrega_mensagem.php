<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id_mensagem');

	// Pesquisa ID localidade-----------------------------------		
		$sql 	= "SELECT * FROM vsites_mensagem where id_mensagem='$id_mensagem'";
		$query 	= $objQuery->SQLQuery($sql);
		$res = mysql_fetch_array($query);
		$id_pedido_item = $res['id_pedido_item'];
		$para 			= $res['para'];
		echo $res['mensagem'];
		
	#ve se o usuário é responsável pelo pedido
	$sql = $objQuery->SQLQuery("SELECT id_atividade from vsites_pedido_status where id_pedido_item='$id_pedido_item' and id_usuario='$controle_id_usuario'");
	$num = mysql_num_rows($sql);
	
	#recupera o id do departamento	
	$sql = $objQuery->SQLQuery("SELECT id_departamento from vsites_departamento where departamento='$para'");
	$res = mysql_fetch_array($sql);
	$id_departamento = $res['id_departamento'];

	#verifica se o usuário que está vendo a mensagem é o destinatário
	$sql = $objQuery->SQLQuery("SELECT id_usuario from vsites_user_usuario where departamento_p like '%".$id_departamento.",%' and id_usuario='$controle_id_usuario'");
	$num_user = mysql_fetch_array($sql);
	
	if($num	<> 0 and $num_user<>0){
		$sql = "update vsites_mensagem set situacao='Sim' where id_mensagem='$id_mensagem'";
		$result = $objQuery->SQLQuery($sql);
		$done = 1;
	}
?>

		
