<?php
require("includes.php");


if($_POST){
    
    require("classes/spreadsheet_excel_writer/Writer.php");
    
    pt_register('POST', 'datai');
    pt_register('POST', 'dataf');
    
    
    $datai = strlen($datai) == 0 ? date('01/m/Y') : $datai;
    $dataf = strlen($dataf) == 0 ? date('t/m/Y') : $dataf;
    $datai = explode('/',$datai);
    $dataf = explode('/',$dataf);
    
    $anoi = $datai[2];
    $mesi = $datai[1];
    $diai = $datai[0];
    $anof = $dataf[2];
    $mesf = $dataf[1];
    $diaf = $dataf[0];
    $total = new stdClass();
    $total->valor = 0;
    $total->valor_rec = 0;
    
    $empresaDAO = new EmpresaDAO();
    $emp = $empresaDAO->selectPorId($controle_id_empresa);
    $relatorioDAO = new RelatorioDAO();
    $ret = $relatorioDAO->relatorioPedidosFaturar($controle_id_empresa,$anoi.'-'.$mesi.'-'.$diai,$anof.'-'.$mesf.'-'.$diaf);
    
    $arquivo = "exporta/ped-fat-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";
    
    //monta as abas da planilha
    $abas = array(utf8_decode('Pedidos à Faturar'));
    $i = 0;
    require('includes/excelstyle.php');
    $worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

    $worksheet->setmerge(0, 0, 0, 6);
    $worksheet->write(0, 0, utf8_decode('Relatório de ') . $emp->fantasia, $styletitulo);

    $worksheet->setmerge(1, 0, 1, 6);
    $worksheet->write(1, 0, utf8_decode('Período de ') . $diai . '/' . $mesi . '/' . $anoi.utf8_decode(' até ' ). $diai . '/' . $mesi . '/' . $anoi, $styletitulo2);

    $worksheet->write(2, 0, 'Nome', $styletitulo3);
    $worksheet->write(2, 1, 'Pedido', $styletitulo3);
    $worksheet->write(2, 2, utf8_decode('Início'), $styletitulo3);
    $worksheet->write(2, 3, 'Prazo', $styletitulo3);
    $worksheet->write(2, 4, 'Valor', $styletitulo3);
    $worksheet->write(2, 5, 'Valor Recebido', $styletitulo3);
    $worksheet->write(2, 6, 'Status', $styletitulo3);

    $cont = 0;
    $i = 3;
    
    foreach ($ret as $r) {
        $j = 0;
        $worksheet->write($i, $j, $r->nome, $styleleft);
        $j++;

        $worksheet->write($i, $j, $r->id_pedido.'/'.$r->ordem, $stylecenter);
        $j++;

        $worksheet->write($i, $j, $r->inicio, $stylecenter);
        $j++;

        $worksheet->write($i, $j, $r->prazo, $stylecenter);
        $j++;

        $worksheet->write($i, $j, $r->valor, $stylereal);
        $j++;

        $worksheet->write($i, $j, $r->valor_rec, $stylereal);
        $j++;

        $worksheet->write($i, $j, $r->status, $styleleft);
        $j++;

        $i++;
        $total->valor = (float) ($total->valor) + (float) ($r->valor);
        $total->valor_rec = (float) ($total->valor_rec) + (float) ($r->valor_rec);
    }

    $j = 0;
    $worksheet->write($i, $j, '', $stylebg);
    $j++;
    $worksheet->write($i, $j, '', $stylebg);
    $j++;
    $worksheet->write($i, $j, '', $stylebg);
    $j++;
    $worksheet->write($i, $j, 'Total: ', $stylecenter);
    $j++;
    $worksheet->write($i, $j, $total->valor, $stylereal);
    $j++;

    $worksheet->write($i, $j, $total->valor_rec, $stylereal);
    $j++;
    $worksheet->write($i, $j, '', $stylebg);
    $j++;

    $i++;
    $workbook->close();
    
} else {
    pt_register('GET','pg');
    pt_register('POST','mes');
    pt_register('POST','ano');
    $pagina = RelTipTit($pg);
    
     $datai = date('01/m/Y');
     $dataf = date('t/m/Y');
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; pedidos a Faturar');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório pedidos a Faturar</legend>
                <dt>Início:</dt>
                <dd><input type="text" id="datai" name="datai" class="data" value="<?=$datai?>"></dd>
                <dt>Fim:</dt>
                <dd><input type="text" id="dataf" name="dataf" class="data" value="<?=$dataf?>"></dd>
                <div class="buttons">
                    <input type="hidden" value="1" id="f" name="f">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                    <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                    <input type="submit" value="buscar &rsaquo;&rsaquo;">
                </div>
                <div class="instrictions">
                    <p>
                        <strong class="active">Observações:</strong><br>
                        * O relatório acima lista todos os pedidos fechados e que ainda estão em execução, ou seja, que foram dado "Serviço Conferido" e ainda não foi aplicado "Concluído"; 
                        * O filtro por data, relaciona a data de cadastro no sistema.
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