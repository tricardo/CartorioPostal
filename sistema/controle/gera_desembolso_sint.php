<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require( "../classes/spreadsheet_excel_writer/Writer.php" );

$arquivo = $controle_id_usuario . ".xls";

//monta as abas da planilha
$abas = array('Desembolso Sintético');
$i=0;

require('../includes/excelstyle.php');

$worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));


pt_register('POST', 'datai');
pt_register('POST', 'dataf');
$datai_sql = invert($datai, '-', 'SQL') . ' ' . substr($datai, 11, 8);
$dataf_sql = invert($dataf, '-', 'SQL') . ' ' . substr($dataf, 11, 8);

$worksheet->setMerge(0, 0, 0, 5);
$worksheet->write(0, 0, 'Relatório de Depósito por Banco Sintético', $styletitulo);

//$worksheet->setMerge(0, 6, 6, 10);
//$worksheet->write(0, 6, ' ', $styletitulo);

$worksheet->setMerge(1, 0, 1, 5);
$worksheet->write(1, 0, 'Entre ' . $datai . ' e ' . $dataf . ' tirado em ' . date('d/m/Y H:i:s'), $styletitulo);

//$worksheet->write(1, $j, $texto, $estilo);
//$worksheet->setColumn(1, $j, $size);
                

$banco = '';
$financeiroDAO = new FinanceiroDAO();
$lista = $financeiroDAO->relDesembolsoSint($controle_id_empresa, $datai_sql, $dataf_sql);
$subtotal = 0;
$total = 0;

$i=2;
foreach($lista as $res) {
    
    $financeiro_valor = $res->total;
    $old_banco = $banco;
    $banco = $res->banco;

    $nome = substr($res->nome, 0, 9);
    $carac = strlen($nome);

    $agencia = $res->financeiro_agencia;

    $conta = $res->financeiro_conta;

    $favorecido = substr($res->financeiro_favorecido, 0, 24);
    $carac = strlen($favorecido);

    $cpf = substr(str_replace('/', '', str_replace('-', '', str_replace('.', '', $res->financeiro_cpf))), 0, 15);
    $carac = strlen($cpf);

    if ($old_banco != $banco and $cont_banco <> '') {
        $worksheet->setMerge($i, 0, $i, 4);
        $worksheet->write($i, 0, 'Subtotal: ', $styleright2);
        $worksheet->write($i, 5, $subtotal, $stylereal);
        $i++;
        $total = (float) ($total) + (float) ($subtotal);
        $subtotal = 0;
    }
    if ($old_banco != $banco) {
        $worksheet->setMerge($i, 0, $i, 5);
        $worksheet->write($i, 0, '', $styletitulo2);
        $i++;
        $worksheet->setMerge($i, 0, $i, 5);
        $worksheet->write($i, 0, $banco, $styletitulo2);
        $i++;
        $worksheet->write($i, 0, 'Protocolo', $styletitulo3);
        $worksheet->write($i, 1, 'Usuário', $styletitulo3);
        $worksheet->write($i, 2, 'Agência', $styletitulo3);
        $worksheet->write($i, 3, 'CC', $styletitulo3);
        $worksheet->write($i, 4, 'Favorecido', $styletitulo3);
        $worksheet->write($i, 5, 'Valor', $styletitulo3);
        $i++;
        $cont_banco++;
    }
    

    $subtotal = (float) ($subtotal) + (float) ($res->total);
    $worksheet->write($i, 0, '#' . $res->id_pedido, $styleleft);
    $worksheet->write($i, 1, $nome, $styleleft);
    $worksheet->write($i, 2, $agencia, $styleleft);
    $worksheet->write($i, 3, $conta, $styleleft);
    $worksheet->write($i, 4, $favorecido, $styleleft);
    $worksheet->write($i, 5, $financeiro_valor, $stylereal);
    $i++;
}

$worksheet->setMerge($i, 0, $i, 4);
$worksheet->write($i, 0, 'Subtotal: ', $styleright2);
    $worksheet->write($i, 5, $subtotal, $stylereal);
$i++;
$worksheet->write($i, 0, '', $styletitulo2);

$total = (float) ($total) + (float) ($subtotal);
$subtotal = 0;

$worksheet->setMerge($i, 0, $i, 4);
$worksheet->write($i, 0, 'Total: ', $styleright2);
$worksheet->write($i, 5, $total, $stylereal);
$i++;
$worksheet->write($i, 0, '', $styletitulo2);

#update campos selecionados no relatorio
$financeiroDAO->relDesembolsoSint($controle_id_empresa, $datai_sql, $dataf_sql);

$largura = $largura-6;
$inicio = 6;
$altura=$i-1;
for ($i = 0; $i <= $altura; $i++)
{
    for ($j = $inicio; $j < $largura; $j++) {
        $worksheet->writeBlank($i, $j, $stylebg);
    }
}

$workbook->close();
#Colocar aqui o script para download do arquivo
?>