<?php
$pedidoDAO = new PedidoDAO();
$empresaDAO = new EmpresaDAO();
$relatorioDAO = new RelatorioDAO();

echo '<pre>';

$empresas = $empresaDAO->listarTodas();
foreach($empresas as $emp){
	$id_empresa = $emp->id_empresa;
	echo "\n ".$emp->fantasia." ";
	$nomeArquivo = 'pendente'.date("sshYmdhms")."_".$id_empresa.".xls";
	$arquivoDiretorio = "../relatorios/pendente/".$nomeArquivo;
	
	$excel=new ExcelWriter($arquivoDiretorio);

	if($excel==false){
		echo $excel->error;
		exit;
	}

	//Unidade
	$myArr=array('Relação de pedidos pendente da unidade:'.$emp->fantasia);
	$excel->writeLine($myArr);

	//periodo
	$myArr=array('Até: '.date('m').'/'.date('m').'/'.date('Y'));
	$excel->writeLine($myArr);

	//espaço
	$myArr=array(' ');
	$excel->writeLine($myArr);
	
	//Escreve o nome dos campos de uma tabela
	$excel->writeLine(array('PEDIDO','Aberto HÁ (dias)','Pendente HÁ (dias)','DATA','Atendente'));
	
	$total_comissao = 0;
	$total = 0;
	$cont=0;
	$old_id_usuario='';
	
	$pedidos = $pedidoDAO->listarPendente($emp->id_empresa);
	
	foreach($pedidos as $pe){
		$diff = time()-strtotime($pe->data);
		$diff = number_format($diff/60/60/24,0);
		$excel->writeLine(array('#'.$pe->id_pedido.'/'.$pe->ordem,
								$diff,
								date("d/m/Y",strtotime($pe->data)),
								date("d/m/Y",strtotime($pe->data_atividade)),
								$pe->atendente
								)
							);
	}
	
	$excel->close();
	$objQuery->SQLQuery("INSERT INTO vsites_relatorios VALUES (null, ".$id_empresa.", 'em pendente', '".$arquivoDiretorio."', '".date("Y-m-d")."') ");
}
echo '</pre>';
?>