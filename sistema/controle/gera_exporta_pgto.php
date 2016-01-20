<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require("../includes/geraexcel/excelwriter.inc.php");

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".xls";
$nomeArquivo = $controle_id_usuario.".xls";

$excel=new ExcelWriter($arquivoDiretorio);

if($excel==false){
	echo $excel->error;
	exit;
}

$pagamentoDAO = new PagamentoDAO();
//Escreve o nome dos campos de uma tabela
$linha_arq = 'ID;Favorecido;Descriчуo;Forma;Vencimento;Valor;Desconto;Multa/Juros;Valor Pg;';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$lista = $pagamentoDAO->execSession('pgto');
foreach($lista as $l){
	$linha_arq = $l->id_pagamento.';'.$l->favorecido.';'.$l->descricao.';'.$l->forma_pagamento.';'.invert($l->dt_vencimento,'/','PHP').';'.$l->valor.';'.$l->desconto.';'.$p->vlr_multa.';'.$l->valor_pg;
	$myArr = explode(';',$linha_arq);
	$excel->writeLine($myArr);
}
header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);
#Colocar aqui o script para download do arquivo
?>