<?php
if ($_POST['submit']) {
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );

	if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE' and verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' or $controle_id_empresa!=1){
		echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
		exit;
	}
	
	$b = new stdClass();
	foreach($_POST as $cp => $valor){ $b->$cp = htmlentities($valor); }
	
	$rel = new RelatorioDAO();
	$dt = $rel->relatorioVendasPorAtendente($controle_id_empresa,$b->ano,$b->mes);
	$nomes = array();
	$variaveis = array('google','telefone','balcao','correios','outros');
	$lista = array(
					'Google/Site','Fechado','Orçamento/Aberto','Pago','Á Receber',
					'Telefone','Fechado','Orçamento/Aberto','Pago','Á Receber',
					'Balcão','Fechado','Orçamento/Aberto','Pago','Á Receber',
					'Correios','Fechado','Orçamento/Aberto','Pago','Á Receber',
					'Outros','Fechado','Orçamento/Aberto','Pago','Á Receber');
	$google = array(array()); $telefone = array(array()); $balcao = array(array()); $correios = array(array()); $outros = array(array());
	$user = 0;
	$cont = 0;
	foreach($dt as $res){
		if(!in_array($res->nome, $nomes)){  
			$user = count($nomes);
			$nomes[$user] = $res->nome;
		}
	
		switch ($res->origem){
			case 'Google': $variavel =  'google'; $ind = 0; break;
			case 'Site': $variavel = 'google'; $ind = 0; break;
			case 'Telefone': $variavel = 'telefone'; $ind = 1; break;
			case 'Balcão': $variavel = 'balcao'; $ind = 2; break;
			case 'Correios': $variavel = 'correios'; $ind = 3; break;
			default: $variavel = 'outros'; $ind = 4; break;					
		}
		
		${$variavel}[0][$user] = (float)(${$variavel}[0][$user]) + (float)($res->total);
		switch ($res->id_status){
			case '1': ${$variavel}[2][$user] = (float)(${$variavel}[2][$user]) + (float)($res->total); break;
			case '16': ${$variavel}[2][$user] = (float)(${$variavel}[2][$user]) + (float)($res->total); break;
			default:
				${$variavel}[1][$user] = (float)(${$variavel}[1][$user]) + (float)($res->total);
				${$variavel}[4][$user] = (float)(${$variavel}[4][$user]) + (float)($res->valor) - (float)($res->valor_rec);
		}
		${$variavel}[3][$user] = (float)(${$variavel}[3][$user]) + (float)($res->valor_rec);
		$cont++;
	}
	#exit();
	
	#inicia variaveis
	for($j = 0; $j < count($lista); $j++){
		for($k = 0; $k < count($nomes); $k++){
			${$variaveis[$i]}[$cont][$k] = (${$variaveis[$i]}[$cont][$k]) ? (float)${$variaveis[$i]}[$cont][$k] : 0;
		}
		$cont++;
		if($cont == 5){ $i++; $cont = 0; }
		$linha++;
	}

	#print_r($google);
	#exit;
	
	#adiciona classe para montar o excel
	require_once "../classes/spreadsheet_excel_writer/Writer.php";
	
	#monta o nome do arquivo 
	$arquivo = date('YmdHis').'.xls';
	
	$workbook =& new Spreadsheet_Excel_Writer();
	
	#seta o nome do arquivo e coloca send para ir para download
	$workbook->send($arquivo);
	
	#monta as abas da planilha	
	$worksheet =& $workbook->addWorksheet("RELATORIO");
	
	$estilo =  array(
		'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
		'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1
	);
	
	#0linha
	$worksheet->setMerge(0, 0, 0, count($nomes)+1);
	$worksheet->write(0, 0, 'Relatório de Sistecart - Sistema de Cartório Certidões S/C Ltda', $workbook->addFormat($estilo));
	
	#1linha
	$estilo['Size'] = 14;
	$worksheet->setMerge(1, 0, 1, count($nomes)+1);
	$worksheet->write(1, 0, 'Relatório de Comissão por Atendente - Ref. ' . $b->mes .' / '. $b->ano , $workbook->addFormat($estilo));
	
	
	#2linha
	$estilo['Size'] = 11;
	$estilo['Bold'] = 0;
	$estilo['Top'] = 1; 
	$estilo['Bottom'] = 1;
	$estilo['Left'] = 1; 
	$estilo['Right'] = 1;
	$estilo['BorderColor'] = 'black';
	for($i = 0; $i < count($nomes); $i++){
		if($i == 0){
			$estilo['Align'] = 'left';
			$worksheet->write(2, 0, 'Atendente', $workbook->addFormat($estilo));
		}
		$estilo['BgColor'] = 'silver';
		$estilo['Align'] = 'center';
		$worksheet->write(2, ($i+1), $nomes[$i], $workbook->addFormat($estilo));
	} $worksheet->write(2, ($i+1), 'Total', $workbook->addFormat($estilo));
	
	#3linha em diante
	$estilo['BgColor'] = 'white';
	$cont = 0;
	$i = 0;
	$linha = 3;
	$totais = array();
	for($j = 0; $j < count($lista); $j++){
		$estilo['NumFormat'] = '_*0';
		$estilo['Bottom'] = 1;
		if($cont == 3 || $cont == 4){
			$estilo['NumFormat'] = '_*R$ #,##0.00';
			if($cont == 4){ $estilo['Bottom'] = 2; }
		}
		$estilo['Align'] = 'left';
		$worksheet->write($linha, 0, $lista[$j], $workbook->addFormat($estilo));
		$total = 0;
		for($k = 0; $k < count($nomes); $k++){
			$estilo['Align'] = 'center';
			if(strlen(${$variaveis[$i]}[$cont][$k]) == 0){
				${$variaveis[$i]}[$cont][$k] = 0;
			}
			${'total_todos'}[$cont][$k] = ${'total_todos'}[$cont][$k] + ${$variaveis[$i]}[$cont][$k]; 
			$worksheet->write($linha, ($k+1), ${$variaveis[$i]}[$cont][$k], $workbook->addFormat($estilo));
			$total = $total + ${$variaveis[$i]}[$cont][$k];
		}
		$totais[$cont] = $totais[$cont] + $total;
		$worksheet->write($linha, ($k+1), $total, $workbook->addFormat($estilo));
		$cont++;
		if($cont == 5){ $i++; $cont = 0; }
		$linha++;
	}
	
	$linha++;
	$lista = array('Total','Total Fechado','Total Orçamento/Aberto','Total Pago','Total Á Receber');
	$estilo['Top'] = 1; 
	$estilo['Bottom'] = 1;
	$estilo['Left'] = 1; 
	$estilo['Right'] = 1;
	for($i = 0; $i < count($lista); $i++){
		$estilo['NumFormat'] = '_*0';
		$estilo['Bottom'] = 1;
		if($i == 3 || $i == 4){
			$estilo['NumFormat'] = '_*R$ #,##0.00';
		}
		$estilo['Align'] = 'left';
		$worksheet->write($linha, 0, $lista[$i], $workbook->addFormat($estilo));
		for($k = 0; $k < count($nomes); $k++){
			$estilo['Align'] = 'center';
			$worksheet->write($linha, ($k+1), $total_todos[$i][$k], $workbook->addFormat($estilo));
		}
		$worksheet->write($linha, ($k+1), $totais[$i], $workbook->addFormat($estilo));
		$linha++;
	}	
	$workbook->close();
} ?>