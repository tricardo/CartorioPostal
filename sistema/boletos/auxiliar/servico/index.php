<?php
	require_once('../base/header.php');

	require_once('Servico.class.php');
	require_once('ServicoDAO.php');
	require_once('ServicoControl.php');
	
	$acao = ($acao=="")?"index":$acao;
	
	$controler = new ServicoControl();
	try{
		$controler->$acao();
	}catch(ExceptionList $e){
		$includes = array();
		$erros = $e->getErros();
		require_once('../base/conteudo.php');
	}
?>