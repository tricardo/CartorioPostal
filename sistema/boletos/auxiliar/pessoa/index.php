<?php
require_once('../base/header.php');

require_once('Pessoa.class.php');
require_once('PessoaFisica.class.php');
require_once('PessoaJuridica.class.php');

require_once('Profissao.class.php');
require_once('ProfissaoDAO.php');

require_once('PessoaDAO.php');
require_once('PessoaFisicaDAO.php');
require_once('PessoaJuridicaDAO.php');


require_once('Telefone.class.php');
require_once('TelefoneDAO.php');
require_once('TelefoneControl.php');

require_once('Endereco.class.php');
require_once('EnderecoDAO.php');

require_once('PessoaControl.php');
$acao = ($acao=="")?"index":$acao;

$controler = new PessoaControl();
try{
	$controler->$acao();
}catch(ExceptionList $e){
	$includes = array();
	$erros = $e->getErros();
	require_once('../base/conteudo.php');
}
?>
