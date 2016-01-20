<?
require( "../includes/funcoes.php" );
require( "../includes/verifica_logado_ajax.inc.php" );
require( "../includes/global.inc.php" );

$permissao = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

require("../includes/fpdf/fpdf.php");
$mesq = "10"; // Margem Esquerda (mm)
$msup = "10"; // Margem Superior (mm) margem mínima dois pois ficou cortando)

pt_register('GET','id');
$sql = $objQuery->SQLQuery("SELECT COUNT(0) as total, id_status FROM site_ficha_cadastro as fc group by id_status");

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
		case 19:
			$prospect+=$res['total'];
			break;
		case 4:
			$qualificado+=$res['total'];
			break;
		case 5:
			$qualificado+=$res['total'];
			break;
		case 17:
			$qualificado+=$res['total'];
			break;
		case 7:
			$proposta+=$res['total'];
			break;
		case 9:
			$negociacao+=$res['total'];
			break;
		case 10:
			$negociacao+=$res['total'];
			break;
		case 11:
			$negociacao+=$res['total'];
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
	$pdf->Image('../images/pipeline.jpg','2.5','1','23','auto','JPG');
	$pdf->SetFont('times','',14.8);	

	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(11.5,4.2,$prospect,0,1,'C');
	$pdf->Cell(11.5,-0.3,$qualificado,0,1,'C');
	$pdf->Cell(11.5,3.9,$proposta,0,1,'C');
	$pdf->Cell(11.5,0,$negociacao,0,1,'C');
	$pdf->Cell(11.5,3.3,$fechamento,0,1,'C');
	$pdf->Cell(11.5,0.3,$pagamento_efetivado,0,1,'C');
	
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Cell(11.5,2,$cancelado.' Fichas Canceladas',0,1,'C');
	$pdf->Output(); //imprime a saida

?>