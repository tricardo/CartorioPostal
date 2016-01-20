<?php
include_once( "../includes/verifica_logado_ajax.inc.php");
include_once( "../includes/funcoes.php" );
include_once( "../includes/global.inc.php" );
include_once('../includes/browser.php');

$fornecedorDAO = new FornecedorDAO();
pt_register('GET','id');

$f = $fornecedorDAO->buscaPorId($id);

echo json_encode($f);
?>