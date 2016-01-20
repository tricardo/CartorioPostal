<?php

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require("../classes/spreadsheet_excel_writer/Writer.php");

pt_register('POST', 'ano');
pt_register('POST', 'mes');
pt_register('POST', 'dia');
pt_register('POST', 'banco');
pt_register('POST', 'atualiza');
pt_register('POST', 'analitico');

$empresaDAO = new EmpresaDAO();
$emp = $empresaDAO->selectPorId($controle_id_empresa);

#inicio do código excel
$arquivo = $controle_id_usuario . ".xls";
//monta as abas da planilha
$abas = array('Fluxo de Caixa');
$i = 0;
require('../includes/excelstyle.php');
$worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

$worksheet->setmerge(0, 0, 0,7);
$worksheet->write(0, 0, 'Relatório de ' . $emp->fantasia, $styletitulo);

$worksheet->setmerge(1, 0, 1,7);
$worksheet->write(1, 0, 'Período de ' . $mes . '/' . $ano, $styletitulo2);

$worksheet->write(2, 0, 'Data', $styletitulo3);
$worksheet->write(2, 1, 'Desembolsado', $styletitulo3);
$worksheet->write(2, 2, 'Custas', $styletitulo3);
$worksheet->write(2, 3, 'Correios', $styletitulo3);
$worksheet->write(2, 4, 'Honorários/Despesas', $styletitulo3);
$worksheet->write(2, 5, 'Troco', $styletitulo3);
$worksheet->write(2, 6, 'Recebimento', $styletitulo3);
$worksheet->write(2, 7, 'Conta', $styletitulo3);


$financeiroDAO = new FinanceiroDAO();
if($analitico=='')
	$ret = $financeiroDAO->listaFluxoCaixa($dia, $mes, $ano, $controle_id_empresa, $banco, $atualiza);
else
	$ret = $financeiroDAO->listaFluxoCaixaItem($dia, $mes, $ano, $controle_id_empresa, $banco, $atualiza);
$cont = 0;

$i = 3;
foreach ($ret as $r) {
    $j = 0;
    $worksheet->write($i, $j, invert($r->data, '/', 'PHP'), $stylecenter);
    $j++;

    $worksheet->write($i, $j, $r->financeiro_desembolsado, $stylereal);
    $j++;

    $worksheet->write($i, $j, $r->financeiro_valor, $stylereal);
    $j++;

    $worksheet->write($i, $j, $r->financeiro_sedex, $stylereal);
    $j++;

    $worksheet->write($i, $j, $r->financeiro_rateio, $stylereal);
    $j++;

    $worksheet->write($i, $j, $r->financeiro_troco, $stylereal);
    $j++;

    $worksheet->write($i, $j, $r->recebimento, $stylereal);
    $j++;

    $worksheet->write($i, $j, $r->financeiro_nossa_conta, $styleleft);
    $j++;

    $i++;
    $total->financeiro_desembolsado = (float) ($total->financeiro_desembolsado) + (float) ($r->financeiro_desembolsado);
    $total->financeiro_sedex = (float) ($total->financeiro_sedex) + (float) ($r->financeiro_sedex);
    $total->financeiro_rateio = (float) ($total->financeiro_rateio) + (float) ($r->financeiro_rateio);
    $total->financeiro_valor = (float) ($total->financeiro_valor) + (float) ($r->financeiro_valor);
    $total->financeiro_troco = (float) ($total->financeiro_troco) + (float) ($r->financeiro_troco);
    $total->recebimento = (float) ($total->recebimento) + (float) ($r->recebimento);
}

$j = 0;
$worksheet->write($i, $j, 'Total: ', $stylecenter);
$j++;

$worksheet->write($i, $j, $total->financeiro_desembolsado, $stylereal);
$j++;

$worksheet->write($i, $j, $total->financeiro_valor, $stylereal);
$j++;

$worksheet->write($i, $j, $total->financeiro_sedex, $stylereal);
$j++;

$worksheet->write($i, $j, $total->financeiro_rateio, $stylereal);
$j++;

$worksheet->write($i, $j, $total->financeiro_troco, $stylereal);
$j++;

$worksheet->write($i, $j, $total->recebimento, $stylereal);
$j++;

$worksheet->write($i, $j, '', $styleleft);
$j++;

$i++;


$workbook->close();
?>