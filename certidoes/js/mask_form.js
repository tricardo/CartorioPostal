$(document).ready(function(){
	$("#tel_res").mask("(99) 9999.9999");// Telefone residencial
	$("#tel_rec").mask("(99) 9999.9999");//Telefone comercial
	$("#tel_cel").mask("(99) 99999.9999");//Telefone celular

	$("#orgao_emissor").mask("SSP/aa");//Org�o emissor
	$("#rg").mask("99.999.999-9");//Registro geral
	$("#cpf").mask("999.999.999-99");//Cadastro de Pessoa F�sica
	$("#cnpj").mask("999.999.999/9999-99");//Cadastro Nacional de Pessoa Jur�dica
	$("#cnh").mask("11111111111");//Carteira Nacional de Habilita��o
	$("#ra").mask("999999999999");//Reservista
	$("#titulo_eleitor").mask("999999999999");//T�tulo Eleitor

	$("#cep").mask("99999-999");//C�digo de Endere�amento Postal
	$("#uf").mask("aa");//Unidade Federativa

	$("#modelo").mask("9999");//Data Abreviada
        $("#fabricacao").mask("9999");//Data Abreviada
        $("#data").mask("99/99/9999");//Data Abreviada
	$("#nascimento").mask("99/99/9999");//Data de Nascimento
        $("#data_evento").mask("99/99/9999");//Data do evento
	$("#busca_data").mask("99/99/9999");//Data de Nascimento
	$("#horario").mask("99:99:99");//Hor�rio de Nascimento
	$("#placa_auto").mask("aaa9999");//Placa de Autom�vel
	$("#placa_moto").mask("aaa9999");//Placa de Moto
});