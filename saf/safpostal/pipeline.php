<?
require( "../includes/verifica_logado_ajax.inc.php" );
require( '../includes/classQuery_sistecart.php' );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );


require("../includes/fpdf/fpdf.php");
$mesq = "10"; // Margem Esquerda (mm)
$msup = "10"; // Margem Superior (mm) margem mínima dois pois ficou cortando)

pt_register('GET','id');
$sql = $objQuery_sistecart->SQLQuery("SELECT COUNT(0) as total, id_status FROM site_ficha_cadastro as fc group by id_status");

$prospect 	 = 0;
$qualificado = 0;
$proposta   = 0;
$negociacao  = 0;
$fechamento   = 0;
$pagamento_efetivado = 0;
$cancelado   = 0;

while($res = mysql_fetch_array($sql)){
	switch($res['id_status']){
		case 1:
			$prospect+=$res['total'];
			break;
		case 17:
			$prospect+=$res['total'];
			break;
		case 19:
			$prospect+=$res['total'];
			break;
		case 4:
			$qualificado+=$res['total'];
			break;
		case 5:
			$qualificado+=$res['total'];
			break;
		case 7:
			$proposta+=$res['total'];
			break;
		case 10:
			$proposta+=$res['total'];
			break;
		case 11:
			$proposta+=$res['total'];
			break;
		case 8:
			$negociacao+=$res['total'];
			break;
		case 9:
			$negociacao+=$res['total'];
			break;
		case 12:
			$negociacao+=$res['total'];
			break;
		case 6:
			$fechamento+=$res['total'];
			break;
		case 13:
			$fechamento+=$res['total'];
			break;
		case 14:
			$pagamento_efetivado+=$res['total'];
			break;		
		case 2:
			$cancelado+=$res['total'];
			break;		
		case 3:
			$cancelado+=$res['total'];
			break;		
		case 16:
			$cancelado+=$res['total'];
			break;		
	}
}

	$pdf=new FPDF('L','cm', 'Letter'); //papel personalizado
	$pdf->Open();
	$pdf->SetMargins(2, 2); //seta as margens do documento
	$pdf->SetAuthor('Softfox');
	$pdf->SetFont('times','', 7);
	$pdf->SetDisplayMode(100, 'continuous'); //define o nivel de zoom do documento PDF

	$pdf->AddPage();	
	$pdf->Image('../images/pipeline.jpg','0','0','21','auto','JPG');
	$pdf->SetFont('times','',14.8);	

	$pdf->Cell(5.4,1.9,$prospect,0,1,'C');
	$pdf->Cell(5.4,1.6,$qualificado,0,1,'C');
	$pdf->Cell(5.4,1.8,$proposta,0,1,'C');
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(5.4,1.8,$negociacao,0,1,'C');
	$pdf->Cell(5.4,1.7,$fechamento,0,1,'C');
	$pdf->Cell(5.4,1.7,$pagamento_efetivado,0,1,'C');
	
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Cell(5.4,1.9,$cancelado.' Fichas Canceladas',0,1,'C');
	$pdf->Output(); //imprime a saida

?>