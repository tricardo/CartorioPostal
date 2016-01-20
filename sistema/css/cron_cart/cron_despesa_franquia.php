<?php

$datai=date('01/m/Y 00:00:00');
$dataf=date('31/m/Y 23:59:59');

$datai_sql = invert($datai,'-','SQL').' '.substr($datai,11, 8);
$dataf_sql = invert($dataf,'-','SQL').' '.substr($dataf,11, 8);

$relatorioDAO = new RelatorioDAO();
$empresaDAO = new EmpresaDAO();

$empresas = $empresaDAO->listarTodas();
foreach($empresas as $emp){
	$id_empresa = $emp->id_empresa;
	$nomeArquivo = date("Ymd")."_".$id_empresa.".csv";
	$arquivoDiretorio = "../relatorios/despesa_franquia/".$nomeArquivo;

	echo "\nGerando \t".$nomeArquivo;
	
	$arquivoConteudo  = "Relatório de ;Desembolso por franquia ; Comissionamento;\n";	
	if($enviados<>'') $arquivoConteudo  .= 'Pedidos Enviados'; 
	else $arquivoConteudo  .= 'Pedidos Recebidos';
	
	$arquivoConteudo  .= "\nEntre ;".$datai.' ;e;'.$dataf.'; tirado em ;'.date('d/m/Y H:i:s')."\n";
	
	$banco='';
	$dados = $relatorioDAO->despesasFranquia($id_empresa,$datai_sql,$dataf_sql,$enviados);
	$num = count($dados);
	$subtotal = 0;
	$total = 0;
	foreach($dados as $res){

		$fantasia = $res->fantasia;
		$financeiro_valor = $res->total;
		$valor = $res->valor;
		$comissao = (float)($valor)/100*14;

		if($old_id_empresa!=$id_empresa and $cont_empresa<>'') {
			$arquivoConteudo  .= "Subtotal:;".number_format($subtotal_valor,2,",","").";".number_format($subtotal_comissao,2,",","").";\n";
			$total = (float)($total)+(float)($subtotal);
			$total_valor = (float)($total_valor)+(float)($subtotal_valor);
			$total_comissao = (float)($total_comissao)+(float)($subtotal_comissao);
			$subtotal=0;
			$subtotal_valor=0;
			$subtotal_comissao=0;
		}
		if($old_id_empresa!=$id_empresa)	{
			$arquivoConteudo  .=  $fantasia."Pedido;Valor Cobrado;Comissão;Data;Franquia;\n";
			$cont_empresa++;
		}
		$old_id_empresa = $id_empresa;
		$subtotal_valor = (float)($subtotal_valor)+(float)($valor);
		$subtotal_comissao = (float)($subtotal_comissao)+(float)($comissao);
		$arquivoConteudo  .= "#".$res->id_pedido.'/'.$res->ordem.';'.number_format($valor,2,",","").';'.number_format($comissao,2,",","").';'.$res->data.';'.$fantasia.";\n";
	}
		
	$arquivoConteudo  .= 'Subtotal:;'.number_format($subtotal_valor,2,",","").';'.number_format($subtotal_comissao,2,",","").";\n";
	$total = (float)($total)+(float)($subtotal);
	$total_valor = (float)($total_valor)+(float)($subtotal_valor);
	$total_comissao = (float)($total_comissao)+(float)($subtotal_comissao);
	$subtotal=0;
	$subtotal_valor=0;
	$subtotal_comissao=0;
	$arquivoConteudo  .= 'Total:;'.number_format($total,2,",","").';'.number_format($total_valor,2,",","").';'.number_format($total_comissao,2,",","").';';

	if(is_file($arquivoDiretorio)) {
		unlink($arquivoDiretorio);
	}

	if(fopen($arquivoDiretorio,"w+")) {
		if (!$handle = fopen($arquivoDiretorio, 'w+')) {
			echo "\nFALHA AO CRIAR O ARQUIVO: <b>".$nomeArquivo."";
			continue;
		}
		if(!fwrite($handle, $arquivoConteudo)) {
			echo"\nFALHA AO ESCREVER NO ARQUIVO: <b>".$nomeArquivo."";
			continue;
		}
	} else {
		echo"\nERRO AO CRIAR O ARQUIVO: ".$nomeArquivo."";
		continue;
	}
	$objQuery->SQLQuery("INSERT INTO vsites_relatorios VALUES (null, ".$id_empresa.", 'despesa entre franquias', '".$arquivoDiretorio."', '".date("Y-m-d")."') ");
}

echo '</pre>';
?>