<?php
require("includes.php");

pt_register('GET','rel');
pt_register('GET','pg');
if(verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
    && verifica_permissao('Rel_comercial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
    && verifica_permissao('Supervisor Atendimento',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
    && verifica_permissao('Supervisor Financeiro',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
    ){
	if($rel=='royalties'){
            if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE'){
                header('location:pagina-erro.php');
                exit;
            }
	}else {
            header('location:pagina-erro.php');
            exit;
	}
}

$empresaDAO = new EmpresaDAO();

$c = Post_StdClass($_GET);
$c->ano = isset($c->ano) ? $c->ano : date('Y');
$c->mes = isset($c->mes) ? $c->mes : date('m');
$c->id_empresa = isset($c->id_empresa) ? $c->id_empresa : '';
$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$erro = '';
switch($pg){
    case 'atendimento': $pag = 'Atendimento'; $sub = 33; break;
    case 'financeiro': case 'concilicao_franquia': 
        $pag = 'Financeiro'; $sub = 36; break;
    case 'diretoria': $pag  = 'Diretoria'; $sub = 34; break;
}
switch($rel){
    case 'conciliacao':
        $titulo = '<a href="relatorios-'.$pg.'.php" id="voltar">'.$pag.'</a> &rsaquo;&rsaquo; Aguardando Identificação de Depósito (Conciliação)';
        $c->relatorio = 'conciliação';
        break;
    case 'conciliacao_franquia':
        $titulo = '<a href="relatorios-'.$pg.'.php" id="voltar">'.$pag.'</a> &rsaquo;&rsaquo; Conciliação Franquia';
        $c->relatorio = 'conciliação franquia';
        break;
    case 'cancelados':
        $titulo = '<a href="relatorios-'.$pg.'.php" id="voltar">'.$pag.'</a> &rsaquo;&rsaquo; Pedidos Cancelados';
        $c->relatorio = 'relatório de cancelados';
        break;
    case 'em-aberto':
        $titulo = '<a href="relatorios-'.$pg.'.php" id="voltar">'.$pag.'</a> &rsaquo;&rsaquo; Pedidos Em Aberto por Período';
        $c->relatorio = 'em aberto';
        break;
    case 'orcamento':
        $titulo = '<a href="relatorios-'.$pg.'.php" id="voltar">'.$pag.'</a> &rsaquo;&rsaquo; Orçamentos Enviados';
        $c->relatorio = 'orçamento';
        break;
    case 'geral':
        $titulo = '<a href="relatorios-'.$pg.'.php" id="voltar">'.$pag.'</a> &rsaquo;&rsaquo; Gerencial Completo';
        $c->relatorio = 'relatório geral';
        break;
}

include('header2.php'); 
?>
<script>
    menu(3,'bt-05');
    $('#titulo').html('relatórios &rsaquo;&rsaquo; <?=$titulo?>');
    $('#sub-<?=$sub?>').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        <dl>
            <legend>Relatório <?=$pag?></legend>
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
            <input type="hidden" name="rel" id="pg" value="<?=$rel?>">
            <input type="hidden" name="pg" id="pg" value="<?=$pg?>">
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?rel=<?=$rel?>&pg=<?=$pg?>'">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>

<div class="content-list-table">   
<?php
if(isset($_GET['rel']) AND isset($_GET['pg']) AND isset($_GET['mes']) AND isset($_GET['ano'])){ 
    $relatorioDAO = new RelatorioDAO();
    $c->id_empresa = ($controle_id_empresa != 1) ? $controle_id_empresa : $c->id_empresa;
    $listar = $relatorioDAO->busca($c->id_empresa, $c->mes, $c->ano, $c->relatorio, $c->pagina); 
    $color = '#FFFFEE';?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $relatorioDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">data</th>
                    <th>arquivo</th>
                    <th>unidade</th>
                    <th class="buttons">download</th>
                </tr>
            </thead>
            <tbody>
               <?php foreach($listar as $i=>$r){ 
                $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$r->id_relatorio?></td>
                    <td class="buttons size100"><?=invert($r->data_relatorio,'/','XP')?></td>
                    <td><?=utf8_encode(ucwords($r->descricao))?></td>
                    <td><?=utf8_encode($r->empresa)?></td>
                    <td class="buttons"><a href="relatorios-downloads.php?id_relatorio=<?=$r->id_relatorio?>&rel=<?=$c->rel?>&pg=<?=$c->pg?>" target="_blank"><img src="images/bt-download.png"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $relatorioDAO->QTDPagina(); ?>
        </div>
        <script>PaginacaoWidth()</script>
    <?php } else { 
        RetornaVazio();
    } 
} else {
    RetornaVazio(2);
} ?>
</div>
<?php include('footer.php'); ?>