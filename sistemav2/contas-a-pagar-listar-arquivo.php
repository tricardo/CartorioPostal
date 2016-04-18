<?php
require("includes.php");

$permissao = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE') {
    header('location:pagina-erro.php');
    exit;
}

require("includes/geraexcel/excelwriter.inc.php");


$arquivoDiretorio = "./exporta/".md5(date('YmdHis').$controle_id_usuario).".xls";
$nomeArquivo = md5(date('YmdHis').$controle_id_usuario).".xls";

$excel=new ExcelWriter($arquivoDiretorio);

if($excel==false){
    header('location:pagina-erro.php?erro=3');
    exit;
}

$pagamentoDAO = new PagamentoDAO();
//Escreve o nome dos campos de uma tabela
$linha_arq = 'ID;Favorecido;Descrição;Forma;Vencimento;Valor;Desconto;Multa/Juros;Valor Pg;';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$lista = $pagamentoDAO->execSession('pgto');
foreach($lista as $l){
	$linha_arq = $l->id_pagamento.';'.$l->favorecido.';'.$l->descricao.';'.$l->forma_pagamento.';'.invert($l->dt_vencimento,'/','PHP').';'.$l->valor.';'.$l->desconto.';'.$l->vlr_multa.';'.$l->valor_pg;
	$myArr = explode(';',$linha_arq);
	$excel->writeLine($myArr);
}
header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);