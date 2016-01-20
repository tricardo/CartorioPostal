<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require("../includes/geraexcel/excelwriter.inc.php");

$arquivoDiretorio = "./exporta/" . $controle_id_usuario . ".xls";
$nomeArquivo = $controle_id_usuario . ".xls";

$excel = new ExcelWriter($arquivoDiretorio);

if ($excel == false) {
    echo $excel->error;
    exit;
}

$contaDAO = new ContaDAO();
//Escreve o nome dos campos de uma tabela
$linha_arq = 'ID;Fatura;Sacado;Vencimento;Valor;Valor Recebido';
$myArr = explode(';', $linha_arq);
$excel->writeLine($myArr);

$lista = $contaDAO->execSession('btto');
foreach ($lista as $l) {
    $linha_arq = $l->id_conta_fatura . ';' . $l->id_fatura . ';' . $l->sacado . ';' . invert($l->vencimento, '/', 'PHP') . ';' . $l->valor . ';' . $l->valor_pago;
    $myArr = explode(';', $linha_arq);
    $excel->writeLine($myArr);
}
header("Content-type: octet/stream");
header("Content-disposition: attachment; filename=exporta/" . $nomeArquivo . ";");
header("Content-Length: " . filesize($arquivoDiretorio));
readfile($arquivoDiretorio);
#Colocar aqui o script para download do arquivo
?>