<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );
	pt_register('GET','id_pedido');

	$sql = $objQuery->SQLQuery("SELECT p.* from vsites_pedido as p, vsites_user_usuario as uu where p.id_pedido='" . $id_pedido . "' and p.id_usuario=uu.id_usuario and uu.id_empresa='".$controle_id_empresa."'");
	$res = mysql_fetch_array($sql);
	$p_valor = $res['nome'].'<br>'.
	$res['cpf'].'<br><br>
	<b>Endereço de Entrega:</b><br>'.
	$res['endereco'].','.$res['numero'].','.$res['complemento'].'<br>'.
	$res['cep'].'<br>'.
	$res['bairro'].'<br>'.
	$res['cidade'].'-'.$res['estado'].'<br><br>
	<b>Endereço de Faturamento:</b><br>'.
	$res['endereco_f'].','.$res['numero_f'].','.$res['complemento_f'].'<br>'.
	$res['cep_f'].'<br>'.
	$res['bairro_f'].'<br>'.
	$res['cidade_f'].'-'.$res['estado_f'].'<br>';
	echo $p_valor;
?>
</div>