<?php
require("includes.php");

$pedidoDAO = new PedidoDAO();
$departamentoDAO = new DepartamentoDAO();
$usuarioDAO = new UsuarioDAO();
if($_POST){
    
    if(	verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' AND
        verifica_permissao('Financeiro_rel',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' AND
        verifica_permissao('Rel_comercial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'){
        header('location:pagina-erro.php');
        exit;
    }
        
    require("includes/geraexcel/excelwriter.inc.php");
    
    pt_register('POST', 'ano');
    pt_register('GET', 'pg');
    
    $data1 = $ano.'-01-01 00:00:00';
    $data2 = $ano.'-12-31 23:59:59';

    $dt = new stdClass();
    $dt->id_empresa = $controle_id_empresa;
    $dt->data1 = $data1; 
    $dt->data2 = $data2;

    $relatorioDAO = new RelatorioDAO();
    $faturamento = $relatorioDAO->FaturamentoClienteCorporativo($dt);

    if(count($faturamento) > 0){
            $arquivo = md5(date('YmdHis')).'.xls';
            $workbook =& new Spreadsheet_Excel_Writer();
            $workbook->send($arquivo);		
            $worksheet =& $workbook->addWorksheet('fat_cliente_corporativo_'.$ano);

            $style1 =& $workbook->addFormat( array(
                    'Size'=>10, 'FgColor'=>'black', 'BgColor'=>'gray', 'Align'=>'left',
                    'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1,
                    'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black'
            ));
            $style2 =& $workbook->addFormat( array(
                    'Size'=>10, 'FgColor'=>'black', 'BgColor'=>'gray', 'Align'=>'center',
                    'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1,
                    'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black'
            ));
            $style3 =& $workbook->addFormat( array(
                    'Size'=>10, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
                    'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>0,
                    'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black',
                    'NumFormat'=>'_*R$ #,##0.00'
            ));
            $style4 =& $workbook->addFormat( array(
                    'Size'=>10, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
                    'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>0,
                    'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black'
            ));
            $style5 =& $workbook->addFormat( array(
                    'Size'=>10, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
                    'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>0,
                    'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black'
            ));
            $style6 =& $workbook->addFormat( array(
                    'Size'=>10, 'FgColor'=>'black', 'BgColor'=>'gray', 'Align'=>'center',
                    'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1,
                    'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black',
                    'NumFormat'=>'_*R$ #,##0.00'
            ));
            $style7 =& $workbook->addFormat( array(
                    'Size'=>10, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
                    'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
                    'Top'=>0, 'Bottom'=>1, 'Left'=>1, 'Right'=>0, 'BorderColor'=>'white',
                    'NumFormat'=>'_*R$ #,##0.00'
            ));
            $style8 =& $workbook->addFormat( array(
                    'Size'=>10, 'FgColor'=>'black', 'BgColor'=>'gray', 'Align'=>'center',
                    'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>0,
                    'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black',
                    'NumFormat'=>'_*R$ #,##0.00'
            ));
            $style9 =& $workbook->addFormat( array(
                    'Size'=>10, 'FgColor'=>'black', 'BgColor'=>'gray', 'Align'=>'center',
                    'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>0,
                    'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black'
            ));

            $worksheet->write(0, 0, ' Nome', $style1);
            $worksheet->write(0, 1, ' CNPJ', $style1);
            $worksheet->write(0, 2, ' Contato', $style1);
            $worksheet->write(0, 3, ' Telefone', $style1);
            $worksheet->setColumn(0, 0, 40); 
            $worksheet->setColumn(0, 1, 18); 
            $worksheet->setColumn(0, 2, 40); 
            $worksheet->setColumn(0, 3, 13); 
            $mes = array('Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez');
            $col = 4;
            for($i = 0; $i < count($mes); $i++){
                    $worksheet->write(0, $col, $mes[$i].'/'.$ano, $style2);
                    $worksheet->write(0, ($col+1), 'Pedidos', $style2);
                    $worksheet->setColumn(0, $col, 10); 
                    $worksheet->setColumn(0, ($col+1), 10); 
                    $col = $col + 2;
            }
            $worksheet->write(0, 28, '                     Total', $style2);
            $worksheet->write(0, 29, '', $style2);
            $worksheet->setColumn(0, 28, 10); 
            $worksheet->setColumn(0, 29, 10); 
            $linha++;
            #inicia sequencia do banco
            $nome2 = '';
            $flag  = 0;
            $total_pedidos = 0;
            $total_valor   = 0;
            $soma_geral_pedidos = 0;
            $soma_geral_valores = 0;
            $soma = 0;
            foreach($faturamento as $w => $fat){
                    if($fat->nome != $nome2 && $flag == 1){
                            $worksheet->write($linha, 0, ' '.strtoupper(trim($nome)), $style4);
                            $worksheet->write($linha, 1, ' '.trim($cpf), $style4);
                            $worksheet->write($linha, 2, ' '.strtoupper(trim($contato)), $style4);
                            $worksheet->write($linha, 3, ' '.trim($telefone), $style4);
                            $mes = explode('¬', $total_mes);
                            $valor  = explode('¬', $total_vlr);
                            $pedidos = explode('¬', $total_pdd);
                            $col    = 4;	
                            for($i = 1; $i <= 12; $i++){	
                                    $m = $i;
                                    if($m < 10){ $m = '0'.$i; }
                                    if(in_array($m, $mes)){
                                            $key = array_search($i, $mes);
                                            $worksheet->write($linha, $col, (float)$valor[$key], $style3);
                                            $worksheet->write($linha, ($col+1), $pedidos[$key], $style5);
                                            $total_pedidos += (int)$pedidos[$key];
                                            $total_valor   += (float)$valor[$key];
                                    } else {
                                            $worksheet->write($linha, $col, '0', $style3);
                                            $worksheet->write($linha, ($col+1), '0', $style5);
                                    }
                                    $col = $col + 2;
                            }
                            $worksheet->write($linha, 28, $total_valor, $style3);
                            $worksheet->write($linha, 29, $total_pedidos, $style5);
                            $soma_geral_pedidos += $total_pedidos;
                            $soma_geral_valores += $total_valor;

                            #add o novo nome
                            $nome2 = $fat->nome;
                            $linha++;
                            #zera todas as variaveis
                            $nome      = '';
                            $cpf       = '';
                            $contato   = '';
                            $telefone  = '';
                            $total_mes = '';
                            $total_vlr = '';
                            $total_pdd = '';
                            $total_pedidos = 0;
                            $total_valor   = 0;
                            #reinicia novas variaveis
                            $nome      = strtoupper(trim($fat->nome));
                            $cpf       = $fat->cpf;
                            $contato   = strtoupper(trim($fat->contato));
                            $telefone  = $fat->tel;
                            $total_mes = $fat->mes.'¬';
                            $total_vlr = $fat->valor.'¬';
                            $total_pdd = $fat->pedidos.'¬';

                            if(($soma == (count($faturamento)-1)) && $nome != ''){
                                    $soma++;
                                    $worksheet->write($linha, 0, ' '.strtoupper(trim($nome)), $style4);
                                    $worksheet->write($linha, 1, ' '.trim($cpf), $style4);
                                    $worksheet->write($linha, 2, ' '.strtoupper(trim($contato)), $style4);
                                    $worksheet->write($linha, 3, ' '.trim($telefone), $style4);
                                    $mes = explode('¬', $total_mes);
                                    $valor  = explode('¬', $total_vlr);
                                    $pedidos = explode('¬', $total_pdd);
                                    $col    = 4;	
                                    for($i = 1; $i <= 12; $i++){	
                                            $m = $i;
                                            if($m < 10){ $m = '0'.$i; }
                                            if(in_array($m, $mes)){
                                                    $key = array_search($i, $mes);
                                                    $worksheet->write($linha, $col, (float)$valor[$key], $style3);
                                                    $worksheet->write($linha, ($col+1), $pedidos[$key], $style5);
                                                    $total_pedidos += (int)$pedidos[$key];
                                                    $total_valor   += (float)$valor[$key];
                                            } else {
                                                    $worksheet->write($linha, $col, '0', $style3);
                                                    $worksheet->write($linha, ($col+1), '0', $style5);
                                            }
                                            $col = $col + 2;
                                    }
                                    $worksheet->write($linha, 28, $total_valor, $style3);
                                    $worksheet->write($linha, 29, $total_pedidos, $style5);
                                    $soma_geral_pedidos += $total_pedidos;
                                    $soma_geral_valores += $total_valor;
                            }
                    } else {
                            if($nome == ''){
                                    $nome      = strtoupper(trim($fat->nome));
                                    $cpf       = trim($fat->cpf);
                                    $contato   = strtoupper(trim($fat->contato));
                                    $telefone  = trim($fat->tel);
                            }
                            $total_mes .= $fat->mes.'¬';
                            $total_vlr .= $fat->valor.'¬';
                            $total_pdd .= $fat->pedidos.'¬';
                            $flag  = 1;
                            $nome2 = $fat->nome;
                    }
                    $soma++;
            }

            $linha++;
            for($i = 0; $i < 28; $i++){
                    $worksheet->write($linha, $i, '', $style7);
            }
            $worksheet->write($linha, 28, $soma_geral_valores, $style8);
            $worksheet->write($linha, 29, $soma_geral_pedidos, $style9);

            $workbook->close();
            $_SESSION['erro_rel_pj'] = '';
    } else {
        header('location:relatorios-pedidos-faturamento-por-cliente-corporativo.php?&pg='.$pg.'&err=1');
        exit;
    }
    
} else {
    pt_register('GET','pg');
    pt_register('GET','err');
    $pagina = RelTipTit($pg);
    
    $c = new stdClass();
    $c->ano        = date('Y');
    $c->mes        = date('m');
    $c->dia_i      = '01';
    $c->dia_f      = date('d');
    $c->id_empresa = '';
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Faturamento por Cliente Corporativo');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Faturamento por Cliente Corporativo</legend>
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