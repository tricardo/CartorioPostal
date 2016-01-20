<?php
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	require("../includes/verifica_logado_ajax.inc.php");
	require("../includes/funcoes.php");
	require("../includes/global.inc.php");
    pt_register('GET','valor');
	pt_register('GET','form');
	pt_register('GET','campo');
	pt_register('GET','qtdd');

	$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido_item'].'##'));	
	$cont=0;
	foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
		$valida = valida_numero($id_pedido_item);
		if($valida!='TRUE'){
			echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido.';
			exit;
		}
		$p_valor .= "document.".$form.".".$campo.$id_pedido_item.".value='".$valor."';
		";
		$cont++;
	}
?>
<script type="text/javascript">
	 <?= $p_valor ?>
</script>