<?php
require("includes.php");

if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE'){  
    header('location:pagina-erro.php');
    exit;
}

$empresaDAO = new EmpresaDAO();
pt_register('GET','pg');
pt_register('GET','mes');
pt_register('GET','ano');
pt_register('GET','pagina');
pt_register('GET','id_empresa');
pt_register('GET','id');
pt_register('GET','rel');

if(isset($rel) AND isset($id) AND is_numeric($id) AND $id > 0){
    switch($rel){
        case 'royalties':
    
            if(verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
                && verifica_permissao('Rel_comercial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
                && verifica_permissao('Supervisor Atendimento',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
                && verifica_permissao('Supervisor Financeiro',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' 
                ){
                if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE'){
                    header('location:pagina-erro.php');
                    exit;
                }
            }

            $relatorioDAO = new RelatorioDAO();
            $relatorio = $relatorioDAO->selectPorId($id_relatorio);
            if($controle_id_empresa != $relatorio->id_empresa && $controle_id_empresa!=1){
                header('location:pagina-erro.php');
                exit;
            }
            if(!is_file($relatorio->arquivo)){
                header('location:pagina-erro.php?erro=1');
                exit;
            }

            $relatorio->arquivo = str_replace('../','',$relatorio->arquivo);
            if(file_exists('../sistema/relatorios/'.$relatorio->arquivo)){
                $relatorio->arquivo = '../sistema/relatorios/'.$relatorio->arquivo;
            }
            
            header ("Content-type: octet/stream");
            header ("Content-disposition: attachment; filename=exporta/".$relatorio->arquivo.";");
            header("Content-Length: ".filesize($relatorio->arquivo));
            readfile($relatorio->arquivo);
            break;
            
        case 'boleto':
            
            $contaDAO = new ContaDAO();
            $b_id = $contaDAO->selectBoletosBradRoy($id,$controle_id_empresa);
            if($id=='' or $b_id->id_conta_fatura=='') {
                header('location:pagina-erro.php?erro=2');
                exit;t;
            }
            $id = $b_id->id_conta_fatura;
            $b = $contaDAO->selectBoletosBradPorId($id,'1');
            
            require( "boletos/gerabradescobrad.php" );
            exit;
            break;
        
        default:
            header('location:pagina-erro.php');
            exit;
    }
}

$paginas = RelTipTit($pg);

$c = Post_StdClass($_GET);
$c->mes        = isset($mes) ? $mes : date('m');
$c->ano        = isset($ano) ? $ano : date('Y');
$c->id_empresa = ($controle_id_empresa == 1) ? (isset($c->id_empresa) ? $c->id_empresa : '') : $controle_id_empresa;
$c->pagina     = isset($pagina) ? $pagina : 1;

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->ano) AND strlen($c->ano) > 0) ? '&ano='.$c->ano : '';
$link .= (isset($c->mes) AND strlen($c->mes) > 0) ? '&mes='.$c->mes : '';
$link .= (isset($c->id_empresa) AND strlen($c->id_empresa) > 0) ? '&id_empresa='.$c->id_empresa : '';

include('header2.php'); ?>
<script>
    menu(3,'bt-05');
    $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$paginas['retorno']?>" id="voltar"><?=$paginas['titulo']?></a> &rsaquo;&rsaquo; Royalties e Faturamento de Franquia');
    $('#sub-<?=$paginas['sub']?>').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get" action="<?=$link?>">
        <dl>
            <legend>Relatório Royalties e Faturamento de Franquia</legend>
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
        <?php if($controle_id_empresa==1){?> 
            <dt>Unidade:</dt>
            <dd>
                <select name="id_empresa" id="id_empresa" class="chzn-select">
                        <option value="" <?php if($c->id_empresa=='') echo 'selected="selected"'; ?>>Unidade</option>
                        <?php 
                        $empresas = $empresaDAO->listarTodasFranquias();
                        $p_valor = '';
                        foreach($empresas as $emp){
                            $p_valor .= '<option value="'.$emp->id_empresa.'" ';
                            $p_valor .= ($c->id_empresa==$emp->id_empresa)?' selected="selected"':'';
                            $p_valor .= '>'.str_ireplace('Cartório Postal - ','',  utf8_encode($emp->fantasia)).'</option>';
                        }
                        echo $p_valor; ?>
                </select>
            </dd>
        <?php } ?>
            <div class="buttons">
                <input type="hidden" name="pg" id="pg" value="<?=$pg?>">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">
    <?php 
    if($_GET AND isset($_GET['ano'])){ 
        $relatorioDAO = new RelatorioDAO();
        $listar = $relatorioDAO->busca_roy($c->id_empresa,$c->mes,$c->ano,$c->pagina); 
        if(count($listar) > 0){ ?>
            <div class="paginacao">
                <?php $relatorioDAO->QTDPagina(); ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="buttons size100">data</th>
                        <th>arquivo</th>
                        <th>unidade</th>
                        <th>royaltie</th>
                        <th>fpp</th>
                        <th class="buttons">boleto</th>
                        <th class="buttons">relatório</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $color = '#FFFEEE';
                    foreach ($listar as $f) { 
                        $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                    <tr <?=TRColor($color)?>>
                        <td class="buttons size100"><?=invert($f->data_relatorio,'/','XP')?></td>
                        <td><?= utf8_encode(ucwords($f->descricao))?></td>                  
                        <td><?= utf8_encode($f->empresa)?></td>                  
                        <td>R$ <?= $f->roy?></td>
                        <td>R$ <?= $f->fpp?></td>
                        <?php if($f->id_conta_fatura<>''){
                            if($f->valor_pago<$f->valor){ ?>
                            <td class="buttons"><a href="?id=<?=$f->id_relatorio?>&rel=boleto&pg=<?=$pg?>" target="_blank"><img src="images/bt-download.png"></a></td>
                        <?php } else { ?>
                            <td class="buttons">PAGO</td>
                        <?php }} else { ?>
                            <td class="buttons">-</td>
                        <?php } ?>
                            <td class="buttons"><a href="?id=<?=$f->id_relatorio?>&rel=royalties&pg=<?=$pg?>" target="_blank"><img src="images/bt-relat.png"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="paginacao">
                <?php $relatorioDAO->QTDPagina(); ?>
            </div>
  <?php } else { 
            RetornaVazio();
        }
    } else { 
        RetornaVazio(2);
    } 
    $show_msgbox = 0; ?>
</div>
<?php include('footer.php'); ?>
