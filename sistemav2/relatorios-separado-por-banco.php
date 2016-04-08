<?php
require("includes.php");

$permissao = verifica_permissao('Rel_n_supervisores',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

if($_POST){
    
    require( "classes/spreadsheet_excel_writer/Writer.php" );
    
    pt_register('POST','datai');
    pt_register('POST','dataf');
    pt_register('POST','f');

    if(strlen($f) == 0){
    
        $arquivo = "exporta/sep-banco-analit-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";

        //monta as abas da planilha
        $abas = array(utf8_decode('Desembolso Analítico'));
        $i = 0;
        
        require('includes/excelstyle.php');

        $worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

        $datai_sql = invert($datai.' 00:00:00', '-', 'SQL') . ' ' . substr($datai, 11, 8);
        $dataf_sql = invert($dataf.' 23:59:59', '-', 'SQL') . ' ' . substr($dataf, 11, 8);


        $worksheet->setMerge(0, 0, 0, 5);
        $worksheet->write(0, 0, utf8_decode('Relatório de Depósito por Banco Analítico'), $styletitulo);

        $worksheet->setMerge(1, 0, 1, 5);
        $worksheet->write(1, 0, 'Entre ' . $datai . ' e ' . $dataf . ' tirado em ' . date('d/m/Y H:i:s'), $styletitulo);

        $financeiroDAO = new FinanceiroDAO();
        $lista = $financeiroDAO->relDesembolsoAnalitico($controle_id_empresa, $datai_sql, $dataf_sql);
        $subtotal = 0;
        $total = 0;

        $i = 2;
        
        
        foreach ($lista as $res) {
            $id_pedido = $res->id_pedido;
            $soma = $res->total;
            $ordens = str_replace(';', ' #' . $id_pedido . '/', $res->ordem);
            $financeiro_descricao = '#' . $res->id_pedido . '/' . $res->ordem . ' ' . $res->financeiro_descricao;
            $financeiro_valor = $res->total;
            $old_banco = $banco;
            $old_agencia = $agencia;
            $old_conta = $conta;
            $old_financeiro_data = $financeiro_data;
            $old_favorecido = $favorecido;
            $old_identificacao = $identificacao;

            $banco = $res->banco;

        $nome = substr($res->nome, 0, 9);
        $carac = strlen($nome);

        $agencia = substr($res->financeiro_agencia, 0, 10);
        $carac = strlen($agencia);

        $conta = substr($res->financeiro_conta, 0, 15);
        $carac = strlen($conta);

        $favorecido = substr($res->financeiro_favorecido, 0, 35);
        $carac = strlen($favorecido);

        $identificacao = $res->financeiro_identificacao;
        $carac = strlen($identificacao);

        $financeiro_data = $res->financeiro_data;

        $cpf = substr(str_replace('/', '', str_replace('-', '', str_replace('.', '', $res->financeiro_cpf))), 0, 15);
        $carac = strlen($cpf);
        if (($old_agencia != $agencia or $old_conta != $conta or $old_favorecido != $favorecido or $old_identificacao != $identificacao or $old_financeiro_data != $financeiro_data) and $cont_dep <> '') {
            $worksheet->setMerge($i, 0, $i, 4);
            $worksheet->write($i, 0, 'Subtotal: ', $styleright2);
            $worksheet->write($i, 5, $somatotal, $stylereal);
            $i++;        
            $somatotal = '';
            $worksheet->write($i, 0, '', $styletitulo2);
            $worksheet->write($i, 1, '', $styletitulo2);
            $worksheet->write($i, 2, '', $styletitulo2);
            $worksheet->write($i, 3, '', $styletitulo2);
            $worksheet->write($i, 4, '', $styletitulo2);
            $i++;

        }

        if ($old_banco != $banco and $cont_banco <> '') {
            $worksheet->setMerge($i, 0, $i, 4);
            $worksheet->write($i, 0, 'Total do Banco '.$old_banco.': ', $styleright2);
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
                $cont_dep++;
            }
            $subtotal = (float) ($subtotal) + (float) ($soma);
            $somatotal = (float) ($somatotal) + (float) ($soma);

            $worksheet->write($i, 0, '#' . $res->id_pedido, $styleleft);
            $worksheet->write($i, 1, $nome, $styleleft);
            $worksheet->write($i, 2, $agencia, $styleleft);
            $worksheet->write($i, 3, $conta, $styleleft);
            $worksheet->write($i, 4, $favorecido, $styleleft);
            $worksheet->write($i, 5, $financeiro_valor, $stylereal);
            $i++;
            $worksheet->write($i, 1, '', $styleleft);
            $worksheet->write($i, 2, '', $styleleft);
            $worksheet->write($i, 3, '', $styleleft);
            $worksheet->write($i, 4, '', $styleleft);
            $worksheet->write($i, 5, '', $styleleft);
            $worksheet->setMerge($i, 0, $i, 5);
            $worksheet->write($i, 0, $financeiro_descricao, $styleleft);
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

    } else {
        
        $arquivo = "exporta/sep-banco-analit-".($controle_id_empresa.$controle_id_usuario.date('YmdHis')).".xls";

        //monta as abas da planilha
        $abas = array(utf8_decode('Desembolso Sintético'));
        $i = 0;
        
        require('includes/excelstyle.php');

        $worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

        $datai_sql = invert($datai.' 00:00:00', '-', 'SQL') . ' ' . substr($datai, 11, 8);
        $dataf_sql = invert($dataf.' 23:59:59', '-', 'SQL') . ' ' . substr($dataf, 11, 8);


        $worksheet->setMerge(0, 0, 0, 5);
        $worksheet->write(0, 0, utf8_decode('Relatório de Depósito por Banco Sintético'), $styletitulo);

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

        
    }
    
} else {
    pt_register('GET','pg');
    $pagina = RelTipTit($pg);
    
     $datai = date('01/m/Y');
     $dataf = date('t/m/Y');
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Separado Por Banco');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank" id="form1" name="form1">
            <dl>
                <legend>Relatório Separado Por Banco</legend>
                <dt>Período Entre:</dt>
                <dd><input type="text" id="datai" name="datai" class="data" value="<?=$datai?>"></dd>
                <dt>E:</dt>
                <dd><input type="text" id="dataf" name="dataf" class="data" value="<?=$dataf?>"></dd>
                <div class="buttons">
                    <input type="hidden" value="" id="f" name="f">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                    <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                    <input type="button" value="sintético &rsaquo;&rsaquo;" onclick="$('#f').val('sintetico'); $('#form1').submit()">
                    <input type="submit" value="analítico &rsaquo;&rsaquo;">
                </div>
                <div class="instrictions">
                    <p>
                        <strong class="active">Observações:</strong><br>
                        * O relatório acima mostra apenas os desembolsos realizados em depósito; <br>
                        * A função desse relatório é agrupar os desembolsos por banco; <br>
                        * A diferença do Analitico é a linha com a descrição do desembolso.
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