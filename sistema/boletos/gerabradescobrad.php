<?php
if($controle_id_empresa==''){
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );
}
$contaDAO = new ContaDAO();
require_once("includes/funcoes_bradesco.php");

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
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa			       	  |
// | 																	                                    |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares						            |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
if($b->id_conta_fatura=='') {
	$b = $contaDAO->selectBoletosBradPorId($id,$controle_id_empresa);
}
if($b->id_conta_fatura=='') {
	echo '<br><h1>Boleto não encontrado!</h1>';
	exit;
}

$data_venc 		= invert($b->vencimento,'/', 'php');  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado 	= $b->valor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_boleto  	= number_format($valor_cobrado, 2, ',', '');

$dadosboleto["nosso_numero"] = $b->id_conta_fatura;  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento = Nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = invert($b->emissao,'/', 'PHP'); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = invert($b->emissao,'/', 'PHP'); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $b->sacado;
$dadosboleto["cpf"] = $b->cpf;
$dadosboleto["endereco1"] = $b->endereco;
$dadosboleto["endereco2"] = "CEP: ".$b->cep;
if($b->tipo==1) $dadosboleto["tipo"] = 'CPF';
else $dadosboleto["tipo"] = 'CNPJ';

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = $b->mensagem1;
$dadosboleto["demonstrativo2"] = $b->mensagem2;
$dadosboleto["demonstrativo3"] = "";
$juros_mora = (float)($b->valor)/100*(float)($b->juros_mora)/30;
$juros_mora = number_format($juros_mora, 2, ',', '');

$multa = (float)($b->valor)/100*(float)(2);
$multa = number_format($multa, 2, ',', '');

if($b->juros_mora<>'0.00') $dadosboleto["instrucoes1"] = 'MORA DIA/COM. PERMANÊNCIA . . . . . . . . . . . . . . . . . . . . . . '.str_replace(".",",",$juros_mora); else $dadosboleto["instrucoes1"] = '';
if($b->instrucao1==6){
	$dadosboleto["instrucoes3"] = 'Protesto após '.$b->instrucao2.' dias em atraso';
}
$dadosboleto["instrucoes2"] = "APÓS ".$data_venc." MULTA . . . . . . . . . . . . . . . . . . . . . . . . . . . . ".$multa;

$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
if($b->aceite=='N') $dadosboleto["aceite"] = 'Sem'; else $dadosboleto["aceite"] = "Sim";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = $b->sigla;

// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //

// DADOS DA SUA CONTA - Bradesco
$agencia = explode('-',$b->agencia);
$conta = explode('-',$b->conta);
$dadosboleto["agencia"] = $agencia[0]; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = $agencia[1]; // Digito do Num da agencia
$dadosboleto["conta"] = $conta[0]; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = $conta[1]; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = $conta[0]; // ContaCedente do Cliente, sem digito (Somente Números)
$dadosboleto["conta_cedente_dv"] = $conta[1]; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = $b->carteira;  // Código da Carteira: pode ser 06 ou 03

// SEUS DADOS
$dadosboleto["identificacao"] = "Cobrança Sistecart";
$dadosboleto["cpf_cnpj"] = "07054210000101";
$dadosboleto["endereco"] = "Rua José Bonifácio, 278";
$dadosboleto["cidade_uf"] = "São paulo - SP";
$dadosboleto["cedente"] = $b->favorecido;

// NÃO ALTERAR!


$codigobanco = "237";
$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
$nummoeda = "9";
$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);

//valor tem 10 digitos, sem virgula
$valor = formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
//agencia é 4 digitos
$agencia = formata_numero($dadosboleto["agencia"],4,0);
//conta é 6 digitos
$conta = formata_numero($dadosboleto["conta"],6,0);
//dv da conta
$conta_dv = formata_numero($dadosboleto["conta_dv"],1,0);
//carteira é 2 caracteres
$carteira = $dadosboleto["carteira"];

//nosso número (sem dv) é 11 digitos
$nnum = formata_numero($dadosboleto["carteira"],2,0).formata_numero($dadosboleto["nosso_numero"],11,0);
//dv do nosso número
$dv_nosso_numero = digitoVerificador_nossonumero($nnum);

//conta cedente (sem dv) é 7 digitos
$conta_cedente = formata_numero($dadosboleto["conta_cedente"],7,0);
//dv da conta cedente
$conta_cedente_dv = formata_numero($dadosboleto["conta_cedente_dv"],1,0);

//$ag_contacedente = $agencia . $conta_cedente;

// 43 numeros para o calculo do digito verificador do codigo de barras
$dv = digitoVerificador_barra("$codigobanco$nummoeda$fator_vencimento$valor$agencia$nnum$conta_cedente".'0', 9, 0);
// Numero para o codigo de barras com 44 digitos
$linha = $codigobanco.$nummoeda.$dv.$fator_vencimento.$valor.$agencia.$nnum.$conta_cedente."0";

$nossonumero = substr($nnum,0,2).'/'.substr($nnum,2).'-'.$dv_nosso_numero;
$agencia_codigo = $agencia."-".$dadosboleto["agencia_dv"]." / ". $conta_cedente ."-". $conta_cedente_dv;

$dadosboleto["codigo_barras"] = $linha;

$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha);
$dadosboleto["agencia_codigo"] = $agencia_codigo;
$dadosboleto["nosso_numero"] = $nossonumero;
$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;

require("includes/layout_bradesco.php");
?>