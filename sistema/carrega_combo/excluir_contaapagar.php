<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
pt_register('GET','id_pagamento');
$pagamentoDAO = new PagamentoDAO();
$pagamento = $pagamentoDAO->deletaPagamento($id_pagamento,$controle_id_empresa);
if($pagamento<>0) echo 'Excluído';
?>