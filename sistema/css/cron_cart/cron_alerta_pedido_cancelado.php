<?php
require( "../includes/verifica_logado_ajax.inc.php");
require("../includes/maladireta/config.inc.php");
require("../includes/maladireta/class.Email.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$pedidoDAO = new PedidoDAO();
$empresaDAO = new EmpresaDAO();
$usuarioDAO = new UsuarioDAO();
$pedidoAlertaDAO = new PedidoAlertaDAO(); 

$empresas = $empresaDAO->listarTodas();
echo '<pre>';
foreach($empresas as $i=>$e){
	echo "\n".$e->id_empresa." => ".$e->fantasia." \t::\t ";
	$pedidos = $pedidoDAO->listarConfirmacao($e->id_empresa);
	$funcionarios = $usuarioDAO->listarPorDepartamentoEmpresa($e->id_empresa,2,true);
	if(count($pedidos)>0){
		$to2='';
		$subject='pedidos em confirmação em '.date("d/m/Y");
		$body = '<h3>'.$subject.'</h3>';
		$body.='<ul>';
		foreach($pedidos as $pedido){
			$body.='<li>'.$pedido->id_pedido.' / '.$pedido->ordem.'</li>';
			$p->status='confirmação';
			$pedidoAlertaDAO->inserir($p);
		}
		$body.='</ul>';
		echo count($pedidos);
		foreach($funcionarios as $i=>$f)
			$to2.=($i!=0)?','.$f->email:$f->email;
		$from=$to='caio.nardi@cartoriopostal.com.br';
		$message = new Email($to, $from, $subject,'');
		$message->SetHtmlContent($body);
		if($message->Send()){
			echo ' email enviado!';
		}else
			echo ' erro ao enviar o email !';
	}
}
echo '</pre>';
?>