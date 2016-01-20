<?php
if ($_POST['submit']) {
    require( "../includes/funcoes.php" );
    require( "../includes/verifica_logado_controle.inc.php");
    require( "../includes/global.inc.php" );
    require("../classes/spreadsheet_excel_writer/Writer.php");

    pt_register('POST', 'anoi');
    pt_register('POST', 'mesi');
    pt_register('POST', 'diai');
    
    $empresaDAO = new EmpresaDAO();
    $emp = $empresaDAO->selectPorId($controle_id_empresa);
    $relatorioDAO = new RelatorioDAO();
    $ret = $relatorioDAO->relatorioPedidosOperacional($controle_id_empresa,$anoi.'-'.$mesi.'-'.$diai);

    #inicio do código excel
    $arquivo = $controle_id_usuario . ".xls";
    //monta as abas da planilha
    $abas = array('Pedidos Fechados no dia');
    $i = 0;
    require('../includes/excelstyle.php');
    $worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

    $worksheet->setmerge(0, 0, 0, 4);
    $worksheet->write(0, 0, 'Relatório de ' . $emp->fantasia, $styletitulo);

    $worksheet->setmerge(1, 0, 1, 4);
    $worksheet->write(1, 0, 'Período de ' . $diai . '/' . $mesi . '/' . $anoi, $styletitulo2);

    $worksheet->write(2, 0, 'Pedido', $styletitulo3);
    $worksheet->write(2, 1, 'Nome', $styletitulo3);
    $worksheet->write(2, 2, 'Descrição', $styletitulo3);
    $worksheet->write(2, 3, 'Cidade', $styletitulo3);
    $worksheet->write(2, 4, 'Estado', $styletitulo3);
    //$worksheet->write(2, 5, 'Valor', $styletitulo3);

    $cont = 0;
    $i = 3;
    foreach ($ret as $r) {
        $j = 0;
        $worksheet->write($i, $j, $r->id_pedido.'/'.$r->ordem, $styleleft);
        $j++;

        $worksheet->write($i, $j, $r->nome, $styleleft);
        $j++;

        $worksheet->write($i, $j, $r->descricao, $styleleft);
        $j++;

        $worksheet->write($i, $j, $r->certidao_cidade, $styleleft);
        $j++;

        $worksheet->write($i, $j, $r->certidao_estado, $styleleft);
        $j++;

        //$worksheet->write($i, $j, $r->descricao, $styleleft);
        //$j++;

        $i++;
    }
    $workbook->close();
} else {
    require('header.php');
    $diai = 01;
    $mesi = (int) date('m');
    $anoi = (int) date('Y');

    ?>
    <div id="topo">
        <h1 class="tit">
            <img src="../images/tit/tit_cartorio.png" alt="Título" />Relatório de Fechados do Dia</h1>
        <hr class="tit" />
        <br />
    </div>
    <div id="meio">
        <table border="0" height="100%" width="100%">
            <tr>
                <td valign="top">
                    <form name="buscador" id="buscador" action="" method="post" target="_blank">
                        <div class="busca1">
                            <label>Data Inicial: </label>
                            <select name="diai" id="dia" class="form_estilo" style="width: 50px; float: left">
                                <?
                                $p_valor = '';
                                for ($i = 1; $i <= 31; $i++) {
                                    if ($i < 10)
                                        $i2 = '0' . $i; else
                                        $i2 = $i;
                                    $p_valor .= '<option value="' . $i2 . '" ';
                                    if ($diai == $i)
                                        $p_valor.= 'selected="select"';
                                    $p_valor.='>' . $i2 . '</option>';
                                }
                                echo $p_valor;
                                ?>
                            </select>
                            <select name="mesi" id="mes" class="form_estilo" style="width: 50px; float: left">
                                <?
                                $p_valor = '';
                                for ($i = 1; $i <= 12; $i++) {
                                    if ($i < 10)
                                        $i2 = '0' . $i; else
                                        $i2 = $i;
                                    $p_valor .= '<option value="' . $i2 . '" ';
                                    if ($mesi == $i)
                                        $p_valor.= 'selected="select"';
                                    $p_valor.='>' . $i2 . '</option>';
                                }
                                echo $p_valor;
                                ?>
                            </select> 
                            <select name="anoi" id="ano" class="form_estilo" style="width: 80px; float: left">
                                <? for ($i = 2010; $i <= (int) date('Y'); $i++) { ?>
                                    <option value="<?= $i ?>" <? if ($anoi == $i)
                                echo 'selected="select"'; ?>><?= $i ?></option>
                                        <? } ?>
                            </select> 
                            <input type="submit" name="submit" class="button_busca" value=" Exportar " />
                        </div>

                        <br/><br/><br/><br/><br/>
                        <b>Observações:</b>
                        <br/>- O relatório acima lista todos os pedidos fechados no dia selecionado excluíndo os cancelados";
                        <br/>- O relatório acima não lista os pedidos enviados por outra franquia para sua unidade";
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <?php
    require('footer.php');
}
?>
