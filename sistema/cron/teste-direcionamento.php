<?php
header("Content-Type: text/html; charset=utf-8",true);
include('funcoes.php');

if(isset($_GET['cep']) AND strlen(trim($_GET['cep'])) == 9){
	$teste = new TesteSisDAO();
	$teste->selectEmpresaCEP(trim($_GET['cep']));
} else {
	echo 'O formato do CEP é 99999-999.';
} ?>
