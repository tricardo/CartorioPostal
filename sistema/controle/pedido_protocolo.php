<?php
require('../includes/verifica_logado_ajax.inc.php');
require('../includes/funcoes.php');
require('../includes/global.inc.php');

//aqui fazemos a inclusão da biblioteca FPDF
require('../includes/fpdf/fpdf.php');

ini_set('memory_limit', '50M');

pt_register('GET','id_pedido');
pt_register('GET','ordem');

$pedidoDAO  = new PedidoDAO();
$empresaDAO = new EmpresaDAO();
$pedido     = $pedidoDAO->buscaPedidoComItens($id_pedido,$controle_id_empresa);
$item       = array();
$i          = 0;
foreach($pedido->itens as $ordem){
	$item[$i] = array(
		id_pedido=>$pedido->id_pedido,
		ordem=>$ordem->ordem,
		servico=>$ordem->servico,
		departamento=>$ordem->departamento,
		valor=>$ordem->valor,
		dias=>$ordem->dias
	);
	$i++;
	$id_empresa = $ordem->id_empresa_atend;
}

$empresa    = $empresaDAO->selectPorId($controle_id_empresa);
#31/01/2013
#Sao Bernardo Solicitou alteração
switch($empresa->id_empresa){
	case 239: $empresa->email = 'contato.saobernardodocampo@cartoriopostal.com.br'; break;
	default: $empresa->email = $empresa->email;
}
$linha1 	= $empresa->endereco.', '.$empresa->numero.' - '.$empresa->cidade.' / '.$empresa->estado.' - CEP: '.$empresa->cep;
$linha2		= 'Tel/Fax: '.$empresa->tel.' / '.$empresa->fax.' - E-mail:'.$empresa->email;
define('Linha1',$linha1);
define('Linha2',$linha2);
#-----------------------------------------------------------------------------
class PDF extends FPDF {
	function Header(){
		$this->Image('../images/logo_sistecart.jpg',7,0.8,7);
		$this->Ln(2.5);
	}
	function Footer(){
		$this->SetY(-2);
		$this->SetFont('Arial','',8);
		$this->SetTextColor(22, 32, 108);
		$this->Cell(0,0.4,Linha1,0,1,'C');
		$this->Cell(0,0.4,Linha2,0,1,'C');
		$this->Cell(0,0.4,'http://www.cartoriopostal.com.br',0,1,'C');
	}
}

$pdf = new PDF('P','cm','A4');
$pdf->SetDisplayMode(100, 'continuous');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 'cm', 12); 
$pdf->Cell(19.2,0.4,'Protocolo de Atendimento nº '.$pedido->id_pedido,'',1,'C');

$pdf->Ln(1);
$pdf->SetFont('Arial','', 10);
$pdf->Cell(19.2,0.4,invert($pedido->data,'/','PHP'),'',1,'R');
$pdf->Cell(19.2,0.6,'Cliente: '.$pedido->nome,'LRT',1);
$pdf->Cell(19.2,0.6,'CPF: '.$pedido->cpf,'RL',1);
$pdf->Cell(19.2,0.6,'Endereço: '.$pedido->cidade.'/'.$pedido->estado.' - ','RL',1);
$pdf->Cell(19.2,0.6,'Atendente: '.$pedido->contato,'LR',1);
$pdf->Cell(19.2,0.6,'Telefone: '.$pedido->tel,'LR',1);
$pdf->Cell(9.2,0.6,'Origem: '.$pedido->origem,'LB',0);
$pdf->setX(10.2);
$pdf->Cell(10,0.6,'Forma Pagamento: '.$pedido->forma_pagamento,'RB',1,'R');

$pdf->Ln();
$dias  = -1;
$valor = 0;
for($i = 0; $i < count($item); $i++){

	$texto = 'O.S.: #'.$item[$i]['id_pedido'].'/'.$item[$i]['ordem'].' - Serviço: '.$item[$i]['servico'].'   ' . '('.$item[$i]['departamento'].')';
	
	$pdf->Cell(16.2,0.75,$texto,1,0);
	$pdf->Cell(3,0.75,'R$ '.$item[$i]['valor'],1,1,'R');
	
	$valor +=$item[$i]['valor'];
	if($dias<$item[$i]['dias']) $dias = $item[$i]['dias'];
}

$prazo = somar_dias_uteis($pedido->data,$dias);

$financeiroDAO = new FinanceiroDAO();
$recebimentos = $financeiroDAO->listarRecebimentos($id_pedido);
$sinal=0;
foreach($recebimentos as $r){
	$sinal=(float)$sinal+(float)$r->financeiro_valor;
}
$saldo = $valor - $sinal;

if($pdf->GetY() >= 20){
	$pdf->AddPage();
}

$pdf->setY(21);
$pdf->Cell(5,0.7,'Prazo de Entrega '.invert($prazo,'/','PHP').' ','',0);

$pdf->setY(22);
$pdf->setX(12.65);
$pdf->Cell(5,0.7,'Total: R$','',0,'R');
$pdf->Cell(2.5,0.5,($valor!=0)?number_format($valor,2):'','B',1,'R');

$pdf->setX(12.65);
$pdf->Cell(5,0.7,'Sinal: R$','',0,'R');
$pdf->Cell(2.5,0.5,($sinal!=0)?number_format($sinal,2):'','B',1,'R');

$pdf->setX(12.65);
$pdf->Cell(5,0.7,'Saldo: R$','',0,'R');
$pdf->Cell(2.5,0.5,($saldo!=0 && $sinal!=0)?number_format($saldo,2):'','B',1,'R');

$pdf->Cell(10,0.5,'Assinatura do cliente','T',1);
$pdf->SetY(25.5);
$pdf->Cell(0,0.5,$responsavel_empresa,0,1,'C');

ob_start ();
$pdf->Output();
?>