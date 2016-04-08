<?php
require("includes.php");

if($_POST){
    require("classes/spreadsheet_excel_writer/Writer.php");

    pt_register('POST', 'ano');
    pt_register('POST', 'mes');
    pt_register('POST', 'banco');
    pt_register('POST', 'atualiza');
    pt_register('POST', 'analitico');
    $dia = '01';
    $total = new stdClass();
    $total->financeiro_desembolsado = 0;
    $total->financeiro_sedex = 0;
    $total->financeiro_rateio = 0;
    $total->financeiro_valor = 0;
    $total->financeiro_troco = 0;
    $total->recebimento = 0;
    
    $empresaDAO = new EmpresaDAO();
    $emp = $empresaDAO->selectPorId($controle_id_empresa);
    
    $arquivo = "exporta/fluxo-caixa-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";
    
    
    //monta as abas da planilha
    $abas = array('Fluxo de Caixa');
    $i = 0;
    require('includes/excelstyle.php');
    $worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

    $worksheet->setmerge(0, 0, 0,7);
    $worksheet->write(0, 0, utf8_decode('Relatório de ') . $emp->fantasia, $styletitulo);

    $worksheet->setmerge(1, 0, 1,7);
    $worksheet->write(1, 0, utf8_decode('Período de ' . $mes . '/' . $ano), $styletitulo2);

    $worksheet->write(2, 0, 'Data', $styletitulo3);
    $worksheet->write(2, 1, 'Desembolsado', $styletitulo3);
    $worksheet->write(2, 2, 'Custas', $styletitulo3);
    $worksheet->write(2, 3, 'Correios', $styletitulo3);
    $worksheet->write(2, 4, utf8_decode('Honorários/Despesas'), $styletitulo3);
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

    
} else {
    pt_register('GET','pg');
    pt_register('POST','mes');
    pt_register('POST','ano');
    $pagina = RelTipTit($pg);
    
    $c = new stdClass();
    $c->ano        = isset($mes) ? $mes : date('Y');
    $c->mes        = isset($ano) ? $ano : date('m');
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Fluxo de Caixa');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Fluxo de Caixa</legend>
                <dt>Mês:</dt>
                <dd>
                    <select id="mes" name="mes" class="chzn-select">
                        <?php foreach(DataAno() AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->mes ? ' selected="selected"' : ''?>><?=$f?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Ano:</dt>
                <dd>
                    <select id="ano" name="ano" class="chzn-select">
                        <?php foreach(DataAno(2) AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->ano ? ' selected="selected"' : ''?>><?=$f?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Banco:</dt>
                <dd>
                    <select name="banco" id="banco" class="chzn-select">
                        <?php
                        $contaDAO = new ContaDAO();
                        $contas = $contaDAO->listarConta($controle_id_empresa);
                        $p_valor = '<option value="" >Todos</option>';
                        foreach ($contas as $conta) {
                            $p_valor .= '<option value="' . utf8_encode($conta->sigla) . '" >' . utf8_encode($conta->sigla) . '</option>';
                        }
                        echo $p_valor;
                        ?>
                    </select> 
                </dd>
                <dt>Atualiza Caixa:</dt>
                <dd>
                    <select name="atualiza" id="atualiza" class="chzn-select">
                        <option value="1" >Sim</option>
                        <option value="" >Não</option>
                    </select>
                </dd>
                <dt>Caixa Analítico</dt>
                <dd>
                     <select name="analitico" id="analitico" class="chzn-select">
                        <option value="1" >Sim</option>
                        <option value="" selected>Não</option>
                    </select>	
                </dd>
                <div class="buttons">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                    <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                    <input type="submit" value="buscar &rsaquo;&rsaquo;">
                </div>
                <div class="instrictions">
                    <p>
                        <strong class="active">Observações:</strong><br>
                        * O relatório acima mostra a movimentação financeira dos caixas; <br>
                        * As Saídas são lançandas na tela de desembolso e contas a pagar; <br>
                        * As Entradas são lançandas na tela de recebimento e recebimento franquia;
                    </p>
                </div>
            </dl>
        </form>
        <script>preencheCampo()</script>
    </div>
    <div class="content-list-table">
        <?php if($_POST){
            RetornaVazio();
        } else {
            RetornaVazio(2); } ?>
    </div>
    <?php include('footer.php'); 
}?>