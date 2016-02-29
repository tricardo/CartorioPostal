$(document).ready(function(){
	$.noConflict();
	$("#tel_cont").mask("(99) 9999.9999");//Telefone de contato
	$("#tel_cel").mask("(99) 9999.9999");//Telefone celular
	$("#tel_res").mask("(99) 9999.9999");// Telefone residencial
	$("#tel_com").mask("(99) 9999.9999");//Telefone comercial

	$("#orgao_emissor").mask("SSP/aa");//Org�o emissor
	$("#rg").mask("99.999.999-99");//Registro geral
	$("#cpf").mask("999.999.999-99");//Cadastro de Pessoa F�sica
	$("#cnpj").mask("11.999.999/9999-99");//Cadastro Nacional de Pessoa Jur�dica
	$("#cnh").mask("11111111111");//Carteira Nacional de Habilita��o
	$("#ra").mask("999999999999");//Reservista
	$("#titulo_eleitor").mask("999999999999");//T�tulo Eleitor

	$("#cep").mask("99999-999");//C�digo de Endere�amento Postal
	$("#uf").mask("aa");//Unidade Federativa

	$("#data").mask("99/99/9999");//Data Abreviada
	$("#expirar").mask("99/99/9999");//Data Abreviada
	$("#busca_data").mask("99/99/9999");//Data Abreviada
	$("#nascimento").mask("99/99/9999");//Data de Nascimento
	$("#placa_auto").mask("aaa9999");//Placa de Autom�vel
	$("#placa_moto").mask("aaa9999");//Placa de Moto

	$("#validade").mask("99/99/9999");//Placa de Moto
});