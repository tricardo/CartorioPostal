<?php
include_once( "../includes/verifica_logado_conveniado.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require_once "../classes/spreadsheet_excel_writer/Writer.php";

$ConveniadoDAO = new ConveniadoDAO();

$ano = date("y");
$mes = date('m');
$dia = date('d');
$hor = date('H');
$min = date('i');
$seg = date('s');

$arquivo = $ano.$mes.$dia.$hor.$min.$seg.'.xls';
$workbook  =& new Spreadsheet_Excel_Writer();
$workbook->send($arquivo);
$style1 =& $workbook->addFormat( array(
	'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
	'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1, 
	'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'BorderColor'=>'black'
));

$style2 =& $workbook->addFormat( array(
	'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
	'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1, 
	'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black'
));
$style3 =& $workbook->addFormat( array(
	'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
	'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
	'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'BorderColor'=>'black'
));

$style4 =& $workbook->addFormat( array(
	'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
	'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
	'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black'
));
$titulo = array (
			'#', 	
			'Abertura',	
			'Prazo',	
			'Data Status',	
			'Concluído Operacional',	
			'CPF',	
			'CNPJ',	
			'Documento de',	
			'Devedor',
			'Serviço',	
			'Estado',	
			'Cidade',	
			'Atividade',	
			'Status',	
			'Atendimento',	
			'Responsável',	
			'Resultado'
		);
$size = array (15,11,11,11,21,18,18,50,50,50,8,50,50,30,20,20,30);

$worksheet =& $workbook->addWorksheet('ordem');
for($j = 0; $j < count($titulo); $j++){
	$estilo = $style1;
	if($j == (count($titulo)-1)){ $estilo = $style2; }
	$worksheet->write(0, $j, $titulo[$j], $estilo);
	$worksheet->setColumn(1, $j, $size[$j]); 
}
$conveniado= $ConveniadoDAO->GeraExportaTodos();
$i = 0;
foreach($conveniado as $c => $conv){
	$i++;
	$cpf = ' ';
	$cnpj= ' ';
	if($conv->certidao_cnpj != ''){ $cnpj = formatarCPF_CNPJ($conv->certidao_cnpj, true); }
	if($conv->certidao_cpf != ''){ $cpf = formatarCPF_CNPJ($conv->certidao_cpf, true); }
	
	$texto = array(
		' #'. $conv->id_pedido . '/'. $conv->ordem,
		invert($conv->inicio,'/','PHP'),
		invert($conv->data_prazo,'/','PHP'),
		invert($conv->data_atividade,'/','PHP'),
		invert($conv->operacional,'/','PHP'),
		$cpf,
		$cnpj,
		ucwords(strtolower($conv->certidao_nome)),
		ucwords(strtolower($conv->certidao_devedor)),
		ucwords(strtolower($conv->servico)),
		strtoupper($conv->certidao_estado),
		ucwords(strtolower($conv->certidao_cidade)),
		ucwords(strtolower($conv->atividade)),
		ucwords(strtolower($conv->status)),
		ucwords(strtolower($conv->atendente)),
		ucwords(strtolower($conv->responsavel)),
		ucwords(strtolower($conv->certidao_resultado))
	);
	for($j = 0; $j < count($titulo); $j++){
		$estilo = $style3;
		if($j == (count($titulo)-1)){ $estilo = $style4; }
		$worksheet->write($i, $j, $texto[$j], $estilo);
	}
}


$workbook->close(); 
?>