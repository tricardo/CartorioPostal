<?php

$pedidoDAO = new PedidoDAO();
$empresaDAO = new EmpresaDAO();
$relatorioDAO = new RelatorioDAO();
echo '<pre>';

$empresas = $empresaDAO->listarTodas();
foreach($empresas as $emp){
	$id_empresa = $emp->id_empresa;
	echo "\n > ".$emp->fantasia." ";
	$nomeArquivo = 'conciliacao_franquia'.date("Ymd")."_".$id_empresa.".xls";
	$arquivoDiretorio = "../relatorios/conciliacao_franquia/".$nomeArquivo;

	$excel=new ExcelWriter($arquivoDiretorio);

	if($excel==false){
		echo $excel->error;
		exit;
	}

	//Unidade
	$myArr=array('Relação de pedidos em conciliação franquia:'.$emp->fantasia);
	$excel->writeLine($myArr);

	//periodo
	$myArr=array('Até: '.date('d').'/'.date('m').'/'.date('Y'));
	$excel->writeLine($myArr);

	//espaço
	$myArr=array(' ');
	$excel->writeLine($myArr);

	//Escreve o nome dos campos de uma tabela
	$excel->writeLine(array('PEDIDO','ABERTO HÁ (dias) ','ATENDENTE'));

	$total_comissao = 0;
	$total = 0;
	$cont=0;
	$old_id_usuario='';

	$pedidos = $pedidoDAO->listarConciliacaoFranquia($emp->id_empresa);

	foreach($pedidos as $pe){
		$diff = time()-strtotime($pe->data_atividade);
		$diff = number_format($diff/60/60/24,0);
		$excel->writeLine(
					array('#'.$pe->id_pedido.'/'.$pe->ordem,
						$diff,
						$pe->atendente,
						date("d/m/Y",strtotime($pe->data_atividade))));
	}

	$excel->close();
	$relatorioDAO->registraRel($id_empresa,$arquivoDiretorio,'conciliação franquia');
}
echo '</pre>';

?>