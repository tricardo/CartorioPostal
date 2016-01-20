<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require_once("../model/Database.php");	
	$pedidoDAO = new PedidoDAO();
	$servicoDAO = new ServicoDAO();
	
	$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido_item'].'##'));
	$p_id_pedido = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido'].'##'));
	$cont='';
	foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
		$valida = valida_numero($id_pedido_item);
		if($valida!='TRUE'){
			echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
			exit;
		}

		$cont++;

		$pedido = $pedidoDAO->buscaPorId($id_pedido_item,$controle_id_empresa);
		$campos = $servicoDAO->listaCampos($pedido->id_servico);

		$bloco .= " <br> Pedido: #".$pedido->id_pedido.'/'.$pedido->ordem;
		foreach($campos as $campo){
			$n_campo = $campo->campo;
			if($pedido->$n_campo<>'')
			$bloco .= " <br> ".$campo->nome.": ".$pedido->$n_campo;			
		}
		$bloco .= '<br><br>';	
    }
echo $bloco;

?>
<script language="javascript">
<!--
function fechar(){
window.opener = window
window.close("#")}
// -->
</script>
<input name="button" type="button" onClick="fechar()" value="Fechar">