<?
	
$pdf->SetFont('','B',14);
$pdf->ln();
$pdf->Cell('',1,'Declaração de Busca','',1,'C');

$pdf->SetFont('','',12);
$pdf->ln();
$pdf->ln();
$pdf->MultiCell(0,0.5,$topo,0,'J');
$pdf->ln();
$pdf->ln();

$larg2 = 6;
$larg3 = 6;
	
//$pdf->Cell(19,0.5,'','1L',0,'L');

$pdf->SetFont('','B',10);
$pdf->Cell(3.5,0.5,'','',0,'L');
$pdf->Cell($larg2,0.5,'RESULTADO','1L',0,'L');
$pdf->Cell($larg3,0.5,'PROTOCOLO','1L',0,'L');
$pdf->Cell(3.5,0.5,'','',0,'L');
$linha_ln=10;

$pdf->SetFont('','',10);
if($cart1<>''){
	$pdf->Ln();
	$pdf->Cell(3.5,0.5,'','',0,'L');
	$pdf->Cell($larg2,0.5,$cart1,'1L',0,'L');
	$pdf->Cell($larg3,0.5,$prot1,'1L',0,'L');
	$pdf->Cell(3.5,0.5,'','',0,'L');
} else {
	$linha_ln++;
}

$pdf->SetFont('','',12);
if($obs!=''){
	$pdf->Ln();
	$pdf->Write(0.5,'OBS.:'.$obs,'');
	$linha_ln++;
}

$i=0;
while($i<$linha_ln){
	$pdf->Ln();
	$i++;
}
?>