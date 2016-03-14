<?php

$pedidoDAO = new PedidoDAO();
$empresaDAO = new EmpresaDAO();
$relatorioDAO = new RelatorioDAO();
$empresas = $empresaDAO->listarTodas();

$ano_mes = date('Y-m',strtotime("-1 month"));
$ultimo_dia = date("d", strtotime($ano_mes."-01 -1 day + 1 month"));

$data_i = $ano_mes.'-01 00:00:00';
$data_f = $ano_mes.'-31 00:00:00';
echo '<pre>';
foreach($empresas as $emp){
	$id_empresa = $emp->id_empresa;
	echo "\n ".$emp->fantasia." ";
	$nomeArquivo = 'clientes_'.md5(date("Ymdhms"))."_".$emp->id_empresa.".xls";
	$arquivoDiretorio = "../relatorios/clientes/".$nomeArquivo;

	$pedidos = $pedidoDAO->listaPedidosClientePJ($emp->id_empresa,$data_i,$data_f);
	
	if(count($pedidos)==0) continue;
	
	$excel=new ExcelWriter($arquivoDiretorio);
	if(!$excel){
		echo $excel->error;
		continue;
	}
	$excel->writeLine(array('Ranking de Clientes da unidade '.$emp->fantasia));
	$excel->writeLine(array('Referente '.invert($data_i,'/','PHP').' até '.invert($data_f,'/','PHP')));
	$excel->writeLine(array(""));
	$excel->writeLine(array("CLIENTE","CNPJ","TOTAL","PEDIDOS"));
	
	foreach($pedidos as $p){
		$excel->writeLine(array($p->nome,$p->cpf,$p->total,$p->pedidos));
		#grava no banco de dados
		$dados = new stdClass();
		$dados->id_empresa = $emp->id_empresa;
		$dados->data = $ano_mes.'-'.$ultimo_dia;
		$dados->cliente = $p->nome;
		$dados->cnpj  	= $p->cpf;
		$dados->total   = $p->total;
		$dados->pedidos = $p->pedidos;

		$relatorioDAO->insereDadosClientes($dados);
	}
	$excel->close();
	$relatorioDAO->registraRel($emp->id_empresa,$arquivoDiretorio,'clientes');
}
echo '</pre>';
?>