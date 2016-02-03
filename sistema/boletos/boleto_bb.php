<?php
if($controle_id_empresa==''){
    require( "../includes/verifica_logado_ajax.inc.php");
    require( "../includes/funcoes.php" );
    require( "../includes/global.inc.php" );
}

$contaDAO = new ContaDAO();
$controle_id_empresa = 1;
if($id=='') pt_register('GET','id');

// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+
// +--------------------------------------------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>              		             				|
// | Desenvolvimento Boleto Banco do Brasil: Daniel William Schultz / Leandro Maniezo / Rogério Dias Pereira|
// +--------------------------------------------------------------------------------------------------------+
// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//
// DADOS DO BOLETO PARA O SEU CLIENTE

// DADOS DO BOLETO PARA O SEU CLIENTE
if($b->id_conta_fatura=='') {
    $b = $contaDAO->selectBoletosBrasilPorId($id,$controle_id_empresa);
}
if($b->id_conta_fatura=='') {
    echo '<br><h1>Boleto não encontrado!</h1>';
    exit;
}

$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0;

$data_venc = invert($b->vencimento,'/', 'php');;  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $b->valor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $b->id_conta_fatura;
$dadosboleto["numero_documento"] = $b->numero_beneficiario;	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = invert($b->emissao,'/', 'PHP'); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = invert($b->emissao,'/', 'PHP'); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $b->sacado;
$dadosboleto["endereco1"] = $b->endereco;
$dadosboleto["endereco2"] = "CEP: ".$b->cep;

if($b->tipo==1) $dadosboleto["tipo"] = 'CPF';
else $dadosboleto["tipo"] = 'CNPJ';

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "MULTA DE ".str_replace(".", ",",$b->valor_multa)."% A PARTIR DE ".date("d/m/Y",strtotime($b->data_multa));
$dadosboleto["demonstrativo2"] = "PROCEDA OS AJUSTES DE VALORES PERTINENTES.";
$dadosboleto["demonstrativo3"] = $b->mensagem1;
$juros_mora = (float)($b->valor)/100*(float)($b->juros_mora)/30;
$juros_mora = number_format($juros_mora, 2, ',', '');

$multa = (float)($b->valor)/100*(float)(2);
$multa = number_format($multa, 2, ',', '');

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = $b->mensagem2;

$dadosboleto["instrucoes2"] = "PROTESTO:".SomarData($data_venc, $b->dias_protesto, 0, 0).".A PARTIR DESSA, CONSULTE BB P/ PAGTO";

$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = $b->aceite;
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = $b->sigla;

// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
// DADOS DA SUA CONTA - BANCO DO BRASIL
$agencia = explode('-',$b->agencia);
$conta = explode('-',$b->conta);
$dadosboleto["agencia"] = $agencia[0]; // Num da agencia, sem digito
$dadosboleto["conta"] = $conta[0]; 	// Num da conta, sem digito
// DADOS PERSONALIZADOS - BANCO DO BRASIL
$dadosboleto["convenio"] = "2775140";  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
$dadosboleto["contrato"] = ""; // Num do seu contrato
$dadosboleto["carteira"] = "17";
$dadosboleto["variacao_carteira"] = "-019";  // Variação da Carteira, com traço (opcional)
// TIPO DO BOLETO
$dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ Convênio c/ 8 dígitos, 7 p/ Convênio c/ 7 dígitos, ou 6 se Convênio c/ 6 dígitos
$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Convênio c/ 6 dígitos: informe 1 se for NossoNúmero de até 5 dígitos ou 2 para opção de até 17 dígitos
/*
#################################################
DESENVOLVIDO PARA CARTEIRA 18
- Carteira 18 com Convenio de 8 digitos
  Nosso número: pode ser até 9 dígitos
- Carteira 18 com Convenio de 7 digitos
  Nosso número: pode ser até 10 dígitos
- Carteira 18 com Convenio de 6 digitos
  Nosso número:
  de 1 a 99999 para opção de até 5 dígitos
  de 1 a 99999999999999999 para opção de até 17 dígitos
#################################################
*/
// SEUS DADOS
$dadosboleto["identificacao"] = "SISTECART CONSULTORIA DE NEGOC ";
$dadosboleto["cpf_cnpj"] = "10.914.772/0001-92";
$dadosboleto["endereco"] = "R DR TEODORO BAIMA 82 AP 12 REPUBLICA SAO PAULO - 1220040";
$dadosboleto["cidade_uf"] = "SAO PAULO - SP";
$dadosboleto["cedente"] = $b->favorecido;

$dadosboleto["sacador_avalista"] = $b->nome_sacador." - ".$b->cpnj_sacador;

// NÃO ALTERAR!
include("includes/funcoes_bb.php");
include("includes/layout_bb.php");
?>