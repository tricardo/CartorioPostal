<?php
require("../model/Database.php");
require("../includes/classQuery.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
require("../classes/spreadsheet_excel_writer/Writer.php");
//require_once("../includes/maladireta/class.Email.php");

require("../../includes/maladireta/class.PHPMailer.php");
$mailer = new SMTPMailer();
$AddBCC = 'ti@cartoriopostal.com.br';
$AddCC  = 'suporte@cartoriopostal.com.br';


$empresaDAO = new EmpresaDAO();

$empresas = $empresaDAO->listarRoyAtrasado();
$empresas_venc = array();
echo '<pre>';


switch (date('m')){
	case 1:
		$mes = "Janeiro";
		break;
	case 2:
		$mes = "Fevereiro";
		break;
	case 3:
		$mes = "Mar�o";
		break;
	case 4:
		$mes = "Abril";
		break;
	case 5:
		$mes = "Maio";
		break;
	case 6:
		$mes = "Junho";
		break;
	case 7:
		$mes = "Julho";
		break;
	case 8:
		$mes = "Agosto";
		break;
	case 9:
		$mes = "Setembro";
		break;
	case 10:
		$mes = "Outubro";
		break;
	case 11:
		$mes = "Novembro";
		break;
	case 12:
		$mes = "Dezembro";
		break;
}
foreach($empresas as $emp){
	$assunto = 'Royalties e FPP';
	$html = '<br><br>
Prezado(a) Franqueado(a),<br>

Na presente data informamos que o nosso departamento financeiro n�o acusou o pagamento do boleto relacionado aos Royalties, bem como o dep�sito do FPP relacionados ao m�s de '.$mes.'.<br>

Dessa forma a <b>FRANQUEADO(A)</b> encontra-se inadimplente em rela��o as suas obriga��es contratuais.<br>

Consoante ao exposto acima, no prazo m�ximo de 5 dias, contados do recebimento desta, solicitamos a regulariza��o os referidos d�bitos e obriga��es, sob pena de n�o o fazendo, estar automaticamente constitu�do em mora.<br>

Caso o(s) referido(s) d�bito(s) j� tenha(m) sido quitado(s) ao tempo do recebimento desta, favor desconsiderar essa notifica��o.<br>

Certos de que seremos prontamente atendidos nesse cordial pedido, desde j� agradecemos sua compreens�o.<br>

Para quaisquer esclarecimentos, por gentileza entrar em contato atrav�s do e-mail: financeiro@cartoriopostal.com.br<br>

Sendo o que nos cumpria para o momento.<br><br>

________________________________<br>
SISTEMA DE CART�RIO CERTID�ES LTDA<br>
Departamento de Cobran�a<br><br>';

	$AddAddress = $emp->email;		
	$mailer->SEND('financeiro@cartoriopostal.com.br', $AddAddress, $AddCC, $AddBCC, '', $assunto, $html);

	$empresaDAO->insertRoyAtrasado($emp->email,$html,$assunto);	
}
echo '</pre>';
?>