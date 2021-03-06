<?php
$pedidoDAO = new PedidoDAO();
$empresaDAO = new EmpresaDAO();
$relatorioDAO = new RelatorioDAO();
echo '<pre>';
$empresas = $empresaDAO->listarTodas();
foreach($empresas as $emp){
	$id_empresa = $emp->id_empresa;
	echo "\n ".$emp->fantasia." ";
	$nomeArquivo = 'conciliacao_'.date("sshYmdhms")."_".$id_empresa.".xls";
	$arquivoDiretorio = "../relatorios/conciliacao/".$nomeArquivo;
	
	$excel=new ExcelWriter($arquivoDiretorio);

	if($excel==false){
		echo $excel->error;
		exit;
	}
	
//Unidade
$myArr=array('Rela��o de pedidos em concilia��o e confirma��o da unidade:'.$emp->fantasia);
$excel->writeLine($myArr);

//periodo
$myArr=array('At�: '.date('d').'/'.date('m').'/'.date('Y'));
$excel->writeLine($myArr);

//espa�o
$myArr=array(' ');
$excel->writeLine($myArr);

	
	//Escreve o nome dos campos de uma tabela
	$excel->writeLine(array('PEDIDO','ABERTO H� (dias) ','ATENDENTE'));
	
	$total_comissao = 0;
	$total = 0;
	$cont=0;
	$old_id_usuario='';
	
	$pedidos = $pedidoDAO->listarConciliacao($emp->id_empresa);
	
	foreach($pedidos as $pe){
		$diff = time()-strtotime($pe->data);
		$diff = number_format($diff/60/60/24,0);
		$excel->writeLine(array('#'.$pe->id_pedido.'/'.$pe->ordem,
								$diff,$pe->atendente,date("d/m/Y",strtotime($pe->data))));
	}
	
	$excel->close();
	$relatorioDAO->registraRel($id_empresa,$arquivoDiretorio,'concilia��o');
}
echo '</pre>';

?>