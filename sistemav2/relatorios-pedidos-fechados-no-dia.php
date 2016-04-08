<?php
require("includes.php");

$empresaDAO = new EmpresaDAO();
$relatorioDAO = new RelatorioDAO();
if($_POST){
    
    if(	verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' AND
        verifica_permissao('Financeiro_rel',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' AND
        verifica_permissao('Rel_comercial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'){
        header('location:pagina-erro.php');
        exit;
    }
        
    require("classes/spreadsheet_excel_writer/Writer.php");
    
    pt_register('POST', 'dia');
    pt_register('POST', 'mes');
    pt_register('POST', 'ano');
    pt_register('GET', 'pg');
    
    $data = $ano.'-'.$mes.'-'.$dia;
    $diai = $dia; $mesi = $mes; $anoi = $ano;

    $emp = $empresaDAO->selectPorId($controle_id_empresa);
    $ret = $relatorioDAO->relatorioPedidosOperacional($controle_id_empresa, $data);
    
    #inicio do código excel
    $arquivo = md5($controle_id_empresa.$controle_id_usuario.date('YmdHis')).".xls";
    
    //monta as abas da planilha
    $abas = array('Pedidos Fechados no dia');
    $i = 0;
    
    
    require("includes/excelstyle.php");
    $worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

    $worksheet->setmerge(0, 0, 0, 4);
    $worksheet->write(0, 0, utf8_decode('Relatório de ') . $emp->fantasia, $styletitulo);
    
    $worksheet->setmerge(1, 0, 1, 4);
    $worksheet->write(1, 0, utf8_decode('Período de ') . $diai . '/' . $mesi . '/' . $anoi, $styletitulo2);

    $worksheet->write(2, 0, 'Pedido', $styletitulo3);
    $worksheet->write(2, 1, 'Nome', $styletitulo3);
    $worksheet->write(2, 2, utf8_decode('Descrição'), $styletitulo3);
    $worksheet->write(2, 3, 'Cidade', $styletitulo3);
    $worksheet->write(2, 4, 'Estado', $styletitulo3);
    //$worksheet->write(2, 5, 'Valor', $styletitulo3);

    $cont = 0;
    $i = 3;
    foreach ($ret as $r) {
        $j = 0;
        $worksheet->write($i, $j, $r->id_pedido.'/'.$r->ordem, $styleleft);
        $j++;

        $worksheet->write($i, $j, utf8_encode($r->nome), $styleleft);
        $j++;

        $worksheet->write($i, $j, utf8_encode($r->descricao), $styleleft);
        $j++;

        $worksheet->write($i, $j, utf8_encode($r->certidao_cidade), $styleleft);
        $j++;

        $worksheet->write($i, $j, utf8_encode($r->certidao_estado), $styleleft);
        $j++;

        //$worksheet->write($i, $j, $r->descricao, $styleleft);
        //$j++;

        $i++;
    }
    $workbook->close();
    
} else {
    pt_register('GET','pg');
    pt_register('GET','err');
    $pagina = RelTipTit($pg);
    
    $c = new stdClass();
    $c->ano = date('Y');
    $c->mes = date('m');
    $c->dia = date('d');
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Pedidos Fechados no dia');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Pedidos Fechados no dia</legend>
                <dt>Dia:</dt>
                <dd>
                    <select id="dia" name="dia" class="chzn-select">
                        <?php foreach(DataAno(3) AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->ano ? ' selected="selected"' : ''?>><?=$f?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Mês:</dt>
                <dd>
                    <select id="mes" name="mes" class="chzn-select">
                        <?php foreach(DataAno(1) AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->ano ? ' selected="selected"' : ''?>><?=$f?></option>
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
            <div class="instrictions">
                <p>
                    <strong class="active">Observações:</strong><br>
                    * O relatório acima lista todos os pedidos fechados no dia selecionado excluíndo os cancelados";<br>
                    * O relatório acima não lista os pedidos enviados por outra franquia para sua unidade";
                </p>
            </div>
        </form>
        <script>preencheCampo()</script>
    </div>
    <div class="content-list-table">
        <?php if($_POST){
            RetornaVazio();
        } else {
            if(isset($_SESSION['erro_rel_pj']) AND $_SESSION['erro_rel_pj'] != 'a'){
        	RetornaErro($_SESSION['erro_rel_pj']);
            } else {
                if(isset($err)){
                    RetornaVazio();
                } else {
                    RetornaVazio(2); 
                }
            }
        } ?>
    </div>
    <?php include('footer.php'); 
}?>