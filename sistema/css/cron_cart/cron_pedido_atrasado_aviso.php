<?php

require_once("../includes/maladireta/config.inc.php");
require_once("../includes/maladireta/class.Email.php");

$pedidoDAO = new PedidoDAO();
$pedidos = $pedidoDAO->listaAtrasados(date('Y-m-d'),date('Y-m-d'));
$pedidos_email=array();
foreach($pedidos as $p)	{
	$pedidos_email[$p->id_usuario][]=$p;
}

foreach($pedidos_email as $id_usuario=>$pedidos){

	$mensagem = '<h1>Atraso de pedidos</h1>';
	$mensagem .= '<ul>';
	foreach($pedidos as $p){
		$mensagem.='<li>'.$p->id_pedido."/".$p->ordem.'</li>';
	}
	$mensagem .= '</ul><br><br>Essa é uma mensagem automática e não precisa ser respondida';
	$message = new Email($p->email, "Cartório Postal <contato@cartoriopostal.com.br>","Atraso de Pedidos", '');
	$message->SetHtmlContent($mensagem);
	$pathToServerFile ="attachments/$at[1]/$at[2]";        //** attach this very PHP script.
	$message->Send();
}
echo '<br>Comunicados de atraso enviados com sucesso!<br>';
?>