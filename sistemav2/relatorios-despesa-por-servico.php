<?php
require("includes.php");


if($_POST){
    
    pt_register('POST','mes');
    pt_register('POST','ano');
    
    $relatorio = new RelatorioDAO();
    $dt        = $relatorio->DespesaServico($mes, $ano, $controle_id_empresa);
    //adiciona classe para montar o excel
    require_once "classes/spreadsheet_excel_writer/Writer.php";
			
    $arquivo = md5($controle_id_empresa.$controle_id_usuario.date('YmdHis')).'.xls';
    
    $workbook =& new Spreadsheet_Excel_Writer();
			
    //seta o nome do arquivo e coloca send para ir para download
    $workbook->send($arquivo);

    $abas = array('DESPESAS_'.DataAno($tipo = 4, $mes).'_'.$ano);
    
    for($i = 0; $i < count($abas); $i++){
        #planilha
        $worksheet =& $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

        $style1 =& $workbook->addFormat( array(
                'Size'=>11, 'FgColor'=>'black', 'Align'=>'center',
                'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1,
                'Top'=>1, 'Left'=>1, 'Right'=>1, 'Bottom'=>1, 'BorderColor'=>'black'
        ));

        $style2 =& $workbook->addFormat( array(
                'Size'=>10, 'FgColor'=>'black', 'Align'=>'center',
                'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 
                'Top'=>1, 'Left'=>1, 'Right'=>1, 'Bottom'=>1, 'BorderColor'=>'black'
        ));

        $style3 =& $workbook->addFormat( array(
                'Size'=>10, 'FgColor'=>'black', 'Align'=>'center',
                'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 
                'Top'=>1, 'Left'=>1, 'Right'=>1, 'Bottom'=>1, 'BorderColor'=>'black',
                'NumFormat'=>'_*R$ #,##0.00'
        ));

        $style4 =& $workbook->addFormat( array(
                'Size'=>10, 'Bottom'=>1, 'BorderColor'=>'black'
        ));

        #referencia
        $ref = array(
                'Data',
                'Serviço',
                'UF',
                'Cidade',
                'Resultado',
                'Pedido',
                'Ordem',
                'Custas',
                'Rateio',
                'Sedex',
                'Valor Cobrado'
        );
        $ref = UTF_ArrEncodes($ref,2);

        #linha 1
        for($j = 0; $j < count($ref); $j++){
                switch($j){
                        case 0: $worksheet->setColumn(0, $j, 11); break;
                        case 1: $worksheet->setColumn(0, $j, 23); break;
                        case 2: $worksheet->setColumn(0, $j, 6); break;
                        case 3: $worksheet->setColumn(0, $j, 23); break;
                        case 4: $worksheet->setColumn(0, $j, 8); break;
                        case 5: $worksheet->setColumn(0, $j, 8); break;
                        case 6: $worksheet->setColumn(0, $j, 10); break;
                        case 7: $worksheet->setColumn(0, $j, 10); break; 
                        case 8: $worksheet->setColumn(0, $j, 10); break;
                }
                $worksheet->write(0, $j, $ref[$j], $style1);
        }

        #linha 2
        $contador = 1;
        $custas   = (float) 0;
        $rateio   = (float) 0;
        $sedex    = (float) 0;
        foreach($dt as $k => $e){
                $data = explode(' ',$e->data);
                $dt   = explode('-',$data[0]);
                $data = $dt[2].'/'.$dt[1].'/'.$dt[0];
                $valor = array(
                        $data,
                        ucwords($e->descricao),
                        strtoupper($e->certidao_estado),
                        ucwords($e->certidao_cidade),
                        ucwords($e->certidao_resultado),
                        $e->id_pedido,
                        $e->ordem,
                        $e->custas,
                        $e->rateio,
                        $e->sedex,
                        $e->valor
                );
                $custas   = $custas + $e->custas;
                $rateio   = $rateio + $e->rateio;
                $sedex    = $sedex  + $e->sedex;
                for($j = 0; $j < count($valor); $j++){
                        switch($j){
                                case 6: case 7: case 8:
                                        $estilo = $style3; break;
                                default:
                                        $estilo = $style2;
                        }
                        $worksheet->write($contador, $j, $valor[$j], $estilo);
                }
                $contador++;
        }

        #linha 3

        for($j = 0; $j < count($ref); $j++){
                $estilo = $style3;
                switch($j){
                        case 6: $valor = $custas; break;
                        case 7: $valor = $rateio; break;
                        case 8: $valor = $sedex; break;
                        default: $estilo = $style2;
                }
                if($j == 0){
                        $worksheet->setMerge($contador, 0, $contador, 5);
                        $worksheet->write($contador, 0, 'Total', $estilo);
                } elseif($j > 5){
                        $worksheet->write($contador, $j, $valor, $estilo);
                } else {
                        $worksheet->write($contador, $j, '', $style4);
                }
        }
    }
    $workbook->close();
    exit();
    
} else {
    pt_register('GET','pg');
    $pagina = RelTipTit($pg);
    
    $c = new stdClass();
    $c->ano        = date('Y');
    $c->mes        = date('m');
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Despesa por Serviço');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Despesa por Serviço</legend>
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
                <div class="buttons">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                    <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                    <input type="submit" value="buscar &rsaquo;&rsaquo;">
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