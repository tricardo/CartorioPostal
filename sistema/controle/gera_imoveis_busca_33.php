<?
$pdf->SetFont('','B',14);
$pdf->Cell('',1,'Declara��o de Busca','',1,'C');
$pdf->SetFont('','',12);
$pdf->ln();
$pdf->MultiCell(0,0.5,$topo,0,'J');
$pdf->ln();
$linha_ln=0;

$pdf->SetLeftMargin(3);
$pdf->SetFont('','B',10);
$pdf->Cell(2.5,0.5,'CARTORIO','1',0,'C');
$pdf->Cell(13,0.5,'RESULTADO','1',0,'C');
	
$pdf->SetFont('','',10);
	
if($prot1<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'1�','1',0,'C');
	$pdf->Cell(13,0.5,$prot1,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot2<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'2�','1',0,'C');
	$pdf->Cell(13,0.5,$prot2,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot3<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'3�','1',0,'C');
	$pdf->Cell(13,0.5,$prot3,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot4<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'4�','1',0,'C');
	$pdf->Cell(13,0.5,$prot4,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot5<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'5�','1',0,'C');
	$pdf->Cell(13,0.5,$prot5,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot6<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'6�','1',0,'C');
	$pdf->Cell(13,0.5,$prot6,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot7<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'7�','1',0,'C');
	$pdf->Cell(13,0.5,$prot7,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot8<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'8�','1',0,'C');
	$pdf->Cell(13,0.5,$prot8,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot9<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'9�','1',0,'C');
	$pdf->Cell(13,0.5,$prot9,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot10<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'10�','1',0,'C');
	$pdf->Cell(13,0.5,$prot10,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot11<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'11�','1',0,'C');
	$pdf->Cell(13,0.5,$prot11,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot12<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'12�','1',0,'C');
	$pdf->Cell(13,0.5,$prot12,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot13<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'13�','1',0,'C');
	$pdf->Cell(13,0.5,$prot13,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot14<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'14�','1',0,'C');
	$pdf->Cell(13,0.5,$prot14,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot15<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'15�','1',0,'C');
	$pdf->Cell(13,0.5,$prot15,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot16<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'16�','1',0,'C');
	$pdf->Cell(13,0.5,$prot16,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot17<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'17�','1',0,'C');
	$pdf->Cell(13,0.5,$prot17,'1',0,'C');
} else {
	$linha_ln++;
}
if($prot18<>''){
	$pdf->Ln();
	$pdf->Cell(2.5,0.5,'18�','1',0,'C');
	$pdf->Cell(13,0.5,$prot18,'1',0,'C');
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
$pdf->ln();
$pdf->ln();
$pdf->SetMargins(1, 2); //seta as margens do documento
?>