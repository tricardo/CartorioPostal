<?php

$pedidoDAO = new PedidoDAO();

echo '<pre>';
$sqlE = $objQuery->SQLQuery("SELECT id_empresa, empresa, fantasia FROM vsites_user_empresa ue WHERE status = 'Ativo'");
while($emp = mysql_fetch_object($sqlE)){
	$id_empresa = $emp->id_empresa;
	echo "\n ".$emp->fantasia." ";
	$nomeArquivo = 'emaberto'.date("Ymdhms")."_".$id_empresa.".xls";
	$arquivoDiretorio = "../relatorios/emaberto/".$nomeArquivo;
	
	$excel=new ExcelWriter($arquivoDiretorio);

	if($excel==false){
		echo $excel->error;
		exit;
	}
	
//Unidade
$myArr=array('Relação de pedidos em aberto da unidade:'.$emp->fantasia);
$excel->writeLine($myArr);

//periodo
$myArr=array('Até: '.date('m').'/'.date('m').'/'.date('Y'));
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
	
	$pedidos = $pedidoDAO->listarEmAberto($emp->id_empresa);
	
	foreach($pedidos as $pe){
		$diff = time()-strtotime($pe->data);
		$diff = number_format($diff/60/60/24,0);
		$excel->writeLine(array('#'.$pe->id_pedido.'/'.$pe->ordem,
								$diff,$pe->atendente,date("d/m/Y",strtotime($pe->data))));
	}
	
	$excel->close();
	$objQuery->SQLQuery("INSERT INTO vsites_relatorios VALUES (null, ".$id_empresa.", 'em aberto', '".$arquivoDiretorio."', '".date("Y-m-d")."') ");
}
echo '</pre>';

?>