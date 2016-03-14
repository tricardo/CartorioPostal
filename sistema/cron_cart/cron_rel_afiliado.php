<?php
$pedidoDAO = new PedidoDAO();
$afiliadoDAO = new AfiliadoDAO();
$relatorioDAO = new RelatorioDAO();
$afiliados = $afiliadoDAO->listarTodos();

$ano = date("Y", strtotime("-1 month"));
$mes = date("m", strtotime("-1 month"));

$data_i = $ano.'-'.'01'.'-01 00:00:00';
$data_f = $ano.'-'.$mes.'-'.date("d", strtotime("-1 day", strtotime(date("Y-m-01")))).' 00:00:00';

echo '<pre>';
echo 'de '.$data_i.' até '.$data_f."\n";

foreach($afiliados as $a){
	$nomeArquivo = 'afiliado_'.$a->id_afiliado.'_'.date("Ymd").".xls";
	$arquivoDiretorio = "../relatorios/afiliado/".$nomeArquivo;

	$pedidos = $pedidoDAO->listaComissaoAfiliado($a->id_afiliado,$data_i,$data_f);

	$excel=new ExcelWriter($arquivoDiretorio);
	if(!$excel){
		echo $excel->error;
	}
	$excel->writeLine(array('Relação de comissionamento do afiliado '.$a->nome));
	$excel->writeLine(array('Referente '.invert($data_i,'/','PHP').' até '.invert($data_f,'/','PHP')));
	$excel->writeLine(array(''));
	$excel->writeLine(array("ORDEM","VALOR","COMISSÃO","VALOR À PAGAR"));
	$comissao_total = 0;
	$valor_total = 0;
	foreach($pedidos as $p){
		$comissao = $p->valor/100*$a->comissao;
		$comissao_total = $comissao_total+$comissao;
		$valor_total = $valor_total+$p->valor;
		$excel->writeLine(array($p->id_pedido.'/'.$p->ordem,$p->valor,$a->comissao.'%',$comissao));
	}
	$excel->writeLine(array("Total",$valor_total,"",$comissao_total));	
	$excel->close();
	$relatorioDAO->registraRel(1,$arquivoDiretorio,'afiliados');
}
echo '</pre>';
?>