<?
	
$pdf->SetFont('','B',14);
$pdf->Cell('',1,'Declara��o de Busca','',1,'C');

$pdf->SetFont('','',12);
$pdf->ln();
$pdf->MultiCell(0,0.5,$topo,0,'J');
$pdf->ln();
$pdf->Ln();

$larg1 = 2.2;
$larg2 = 13;
$larg3 = 3;
	
$pdf->SetFont('','B',10);
$pdf->Cell($larg1,0.5,'CART�RIO','1L',0);
$pdf->Cell($larg2,0.5,'RESULTADO','1L',0);
$pdf->Cell($larg3,0.5,'PROTOCOLO','1L',1);
$linha_ln='';

$pdf->SetFont('','',10);
if($cart1<>''){
	$pdf->Cell($larg1,0.5,"1�",'1L',0);
	$pdf->Cell($larg2,0.5,$cart1,'1L',0);
	$pdf->Cell($larg3,0.5,$prot1,'1L',1);
} else {
	$linha_ln++;
}
	
if($cart2<>''){
	$pdf->Cell($larg1,0.5,'2�','1L',0);
	$pdf->Cell($larg2,0.5,$cart2,'1L',0);
	$pdf->Cell($larg3,0.5,$prot2,'1L',1);
} else {
	$linha_ln++;
}
	
if($cart3<>''){
	$pdf->Cell($larg1,0.5,'3�','1L',0);
	$pdf->Cell($larg2,0.5,$cart3,'1L',0);
	$pdf->Cell($larg3,0.5,$prot3,'1L',1);
} else {
	$linha_ln++;
}
if($cart4<>''){
	$pdf->Cell($larg1,0.5,'4�','1L',0);
	$pdf->Cell($larg2,0.5,$cart4,'1L',0);
	$pdf->Cell($larg3,0.5,$prot4,'1L',1);
} else {
	$linha_ln++;
}
if($cart5<>''){
	$pdf->Cell($larg1,0.5,'5�','1L',0);
	$pdf->Cell($larg2,0.5,$cart5,'1L',0);
	$pdf->Cell($larg3,0.5,$prot5,'1L',1);
} else {
	$linha_ln++;
}
if($cart6<>''){
	$pdf->Cell($larg1,0.5,'6�','1L',0);
	$pdf->Cell($larg2,0.5,$cart6,'1L',0);
	$pdf->Cell($larg3,0.5,$prot6,'1L',1);
} else {
	$linha_ln++;
}
if($cart7<>''){
	$pdf->Cell($larg1,0.5,'7�','1L',0);
	$pdf->Cell($larg2,0.5,$cart7,'1L',0);
	$pdf->Cell($larg3,0.5,$prot7,'1L',1);
} else {
	$linha_ln++;
}
if($cart8<>''){
	$pdf->Cell($larg1,0.5,'8�','1L',0);
	$pdf->Cell($larg2,0.5,$cart8,'1L',0);
	$pdf->Cell($larg3,0.5,$prot8,'1L',1);
} else {
	$linha_ln++;
}
if($cart9<>''){
	$pdf->Cell($larg1,0.5,'9�','1L',0);
	$pdf->Cell($larg2,0.5,$cart9,'1L',0);
	$pdf->Cell($larg3,0.5,$prot9,'1L',1);
} else {
	$linha_ln++;
}
if($cart10<>''){
	$pdf->Cell($larg1,0.5,'10�','1L',0);
	$pdf->Cell($larg2,0.5,$cart10,'1L',0);
	$pdf->Cell($larg3,0.5,$prot10,'1L',1);
} else {
	$linha_ln++;
}
if($cart11<>''){
	$pdf->Cell($larg1,0.5,'11�','1L',0);
	$pdf->Cell($larg2,0.5,$cart11,'1L',0);
	$pdf->Cell($larg3,0.5,$prot11,'1L',1);
} else {
	$linha_ln++;
}
if($cart12<>''){
	$pdf->Cell($larg1,0.5,'12�','1L',0);
	$pdf->Cell($larg2,0.5,$cart12,'1L',0);
	$pdf->Cell($larg3,0.5,$prot12,'1L',1);
} else {
	$linha_ln++;
}
if($cart13<>''){
	$pdf->Cell($larg1,0.5,'13�','1L',0);
	$pdf->Cell($larg2,0.5,$cart13,'1L',0);
	$pdf->Cell($larg3,0.5,$prot13,'1L',1);
} else {
	$linha_ln++;
}
if($cart14<>''){
	$pdf->Cell($larg1,0.5,'14�','1L',0);
	$pdf->Cell($larg2,0.5,$cart14,'1L',0);
	$pdf->Cell($larg3,0.5,$prot14,'1L',1);
} else {
	$linha_ln++;
}
if($cart15<>''){
	$pdf->Cell($larg1,0.5,'15�','1L',0);
	$pdf->Cell($larg2,0.5,$cart15,'1L',0);
	$pdf->Cell($larg3,0.5,$prot15,'1L',1);
} else {
	$linha_ln++;
}

if($cart16<>''){
	$pdf->Cell($larg1,0.5,'16�','1L',0);
	$pdf->Cell($larg2,0.5,$cart16,'1L',0);
	$pdf->Cell($larg3,0.5,$prot16,'1L',1);
} else {
	$linha_ln++;
}
if($cart17<>''){
	$pdf->Cell($larg1,0.5,'17�','1L',0);
	$pdf->Cell($larg2,0.5,$cart17,'1L',0);
	$pdf->Cell($larg3,0.5,$prot17,'1L',1);
} else {
	$linha_ln++;
}
if($cart18<>''){
	$pdf->Cell($larg1,0.5,'18�','1L',0);
	$pdf->Cell($larg2,0.5,$cart18,'1L',0);
	$pdf->Cell($larg3,0.5,$prot18,'1L',1);
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
	$pdf->Ln();
?>