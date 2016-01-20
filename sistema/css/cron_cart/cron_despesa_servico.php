<?php

$mes = date('m');
$ano = date('Y');

$datai_sql = invert($datai,'-','SQL').' '.substr($datai,11, 8);
$dataf_sql = invert($dataf,'-','SQL').' '.substr($dataf,11, 8);

$relatorioDAO = new RelatorioDAO();
$empresaDAO = new EmpresaDAO();

$empresas = $empresaDAO->listarTodas();
foreach($empresas as $emp){
	$id_empresa = $emp->id_empresa;

	$nomeArquivo = date("YmdHms").$id_empresa.".csv";
	$arquivoDiretorio = "../relatorios/despesa_servico/".$nomeArquivo;
	
	$arquivoConteudo  = 'Pedidos Concluídos ';
	$arquivoConteudo .= ' em ';
	$arquivoConteudo .=': '.$mes.'/'.$ano."\n";
	$arquivoConteudo .="Pedido ;Serviço;Descrição;Variação ;Desembolso; Sedex;Rateio;Valor Cobrado;Valor da Tabela\n";
	
	$dados = $relatorioDAO->despesasServico($id_empresa,$mes,$ano);
	foreach($dados as $res){
		$arquivoConteudo  .= $res->id_pedido.';'.$res->ordem.';'.$res->descricao.';'.$res->variacao.';';
		$arquivoConteudo  .= $res->desembolso.';'.$res->sedex.';'.$res->rareio.';'.$res->valor_cobrado.';'.$res->tabela.";\n";
	}

	if(is_file($arquivoDiretorio)) {
		unlink($arquivoDiretorio);
	}
	if(fopen($arquivoDiretorio,"w+")) {
		if (!$handle = fopen($arquivoDiretorio, 'w+')) {
			echo "\nFALHA AO CRIAR O ARQUIVO: ".$nomeArquivo."";
			continue;
		}
		if(!fwrite($handle, $arquivoConteudo)) {
			echo"\nFALHA AO ESCREVER NO ARQUIVO: <b>".$nomeArquivo."";
			continue;
		}
	} else {
		echo"\nERRO AO CRIAR O ARQUIVO: <b>".$nomeArquivo."";
		continue;
	}
	$relatorioDAO->registraRel($id_empresa,$arquivoDiretorio,'despesa por serviço');	
}


echo '</pre>';
?>