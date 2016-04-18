<?php include('header.php'); 

$permissao = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE') {
    header('location:pagina-erro.php');
    exit;
}

$financeiroDAO = new FinanceiroDAO();
$departamentoDAO = new DepartamentoDAO();
$pagamentoDAO = new PagamentoDAO();

$departamentos = $departamentoDAO->listar();
$forma = $financeiroDAO->listarFormaPagamentoCAP();

$c = Post_StdClass($_GET);

$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca = isset($c->busca) ? $c->busca : '';
$c->id_departamento = isset($c->id_departamento) ? $c->id_departamento : '';
$c->id_forma_pagamento = isset($c->id_forma_pagamento) ? $c->id_forma_pagamento : '';
$c->situacao = isset($c->situacao) ? $c->situacao : '';
$c->busca_data_i = isset($c->busca_data_i) ? $c->busca_data_i : date('01/m/Y', strtotime("- 1 month"));
$c->busca_data_f = isset($c->busca_data_f) ? $c->busca_data_f : date('t/m/Y', strtotime("+ 1 month"));

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
$link .= (isset($c->id_departamento) AND strlen($c->id_departamento) > 0) ? '&id_departamento='.$c->id_departamento : '';
$link .= (isset($c->id_forma_pagamento) AND strlen($c->id_forma_pagamento) > 0) ? '&id_forma_pagamento='.$c->id_forma_pagamento : '';
$link .= (isset($c->situacao) AND strlen($c->situacao) > 0) ? '&situacao='.$c->situacao : '';
$link .= (isset($c->busca_data_i) AND strlen($c->busca_data_i) > 0) ? '&busca_data_i='.$c->busca_data_i : '';
$link .= (isset($c->busca_data_f) AND strlen($c->busca_data_f) > 0) ? '&busca_data_f='.$c->busca_data_f : '';

if(isset($c->acao) AND $c->acao == 'excluir' AND isset($c->id_pagamento) AND $c->id_pagamento > 0){
    $pagamento = $pagamentoDAO->deletaPagamento($c->id_pagamento,$controle_id_empresa);
    $big_msg_box = ucwords(MsgBox(3));
    $show_msgbox = 0;
}


?>
<script>
    menu(3,'bt-04');
    $('#titulo').html('financeiro &rsaquo;&rsaquo; cobrança');
    $('#sub-26').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get" id="form1" name="form1">
        <dl>
            <legend>Buscar Contas à Pagar</legend>
            <dt>Pesquisar:</dt>
            <dd><input type="text" name="busca" id="busca" value="<?=(isset($c->busca)) ? $c->busca : ''?>" placeholder="Pesquisar"></dd>
            <dt>Centro de Custo:</dt>
            <dd>
                <select name="id_departamento" id="id_departamento" class="chzn-select">
                    <?php $p_valor = '<option value="">Centro de Custo</option>';
                    foreach ($departamentos as $dep) {
                        $p_valor .= '<option value="' . $dep->id_departamento . '"';
                        if ($dep->id_departamento == $c->id_departamento) $p_valor .= ' selected="selected"';
                        $p_valor .= '>' . utf8_encode($dep->departamento) . '</option>';
                    }
                    echo $p_valor; ?>
                </select>
            </dd>
            <dt>Forma:</dt>
            <dd>
                <select name="id_forma_pagamento" id="id_forma_pagamento" class="chzn-select">
                    <?php $p_valor = '<option value="">Forma</option>';
                    foreach ($forma as $f) {
                        $p_valor .= '<option value="' . $f->id_forma_pagamento . '" ';
                        if ($c->id_forma_pagamento == $f->id_forma_pagamento)
                            $p_valor .= 'selected="selected"';
                        $p_valor .= '>' . utf8_encode($f->forma_pagamento) . '</option>';
                    }
                    echo $p_valor;
                    ?>
                </select>
            </dd>
            <dt>Situação:</dt>
            <dd>
                <select name="situacao" id="situacao" class="chzn-select">
                    <option <?=($c->situacao == 'À Pagar') ? 'selected="selected"':''; ?> value="À Pagar">À Pagar</option>
                    <option <?=($c->situacao == 'Pagas') ? 'selected="selected"':''; ?> value="Pagas">Pagas</option>
                    <option <?=($c->situacao == '') ? 'selected="selected"':''; ?> value="">Todas</option>
                </select>
            </dd>
            <dt>Início:</dt>
            <dd><input type="text" id="busca_data_i" name="busca_data_i" class="data" value="<?=$c->busca_data_i?>"></dd>
            <dt>Fim:</dt>
            <dd><input type="text" id="busca_data_f" name="busca_data_f" class="data" value="<?=$c->busca_data_f?>"></dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <?php if ($controle_id_empresa == '1' AND ($_POST OR $_GET)) { ?>
                    <input type="button" value="exportar &rsaquo;&rsaquo;" onclick="ExportarContasPagar()">
                <?php } ?>
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">   
<?php
AddRegistro('contas-a-pagar-editar.php'.$link.'&id_pagamento=0');
if($_GET){ 
    $c->data_i = ($c->busca_data_i != "") ? invert($c->busca_data_i, '-', 'SQL') : '';
    $c->data_f = ($c->busca_data_f != "") ? invert($c->busca_data_f, '-', 'SQL') : '';
    $listar = $pagamentoDAO->busca($c, $controle_id_empresa, $c->pagina); ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $pagamentoDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons sizeauto">parc.</th>
                    <th>fornecedor</th>
                    <th>descrição</th>
                    <th>forma</th>
                    <th class="buttons sizeauto">doc. físico</th>
                    <th class="buttons sizeauto">vencimento</th>
                    <th class="buttons sizeauto">valor</th>
                    <th class="buttons sizeauto">desconto</th>
                    <th class="buttons sizeauto">multa/juros</th>
                    <th class="buttons sizeauto">valor pago</th>
                    <th class="buttons">editar</th>
                    <?php if($controle_depto_p['27']!=1){ ?>
                        <th class="buttons">deletar</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $p) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; 
                    $estilo = (isset($p->dt_vencimento) AND ($p->dt_vencimento < date("Y-m-d") AND (isset($p->dt_pagamento) AND $p->dt_pagamento == '//'))) ? ' style="background:#cc0303;color:#FFF;"' : '';
                    $fisico = $p->fisico == '1' ? 'Sim' : 'Não';
                    ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$p->id_pagamento?></td>
                    <td class="buttons sizeauto"><?=$p->parcela . '/' . $p->qt_parcelas?></td>
                    <td><?=utf8_encode(ucwords(strtolower($p->favorecido)))?></td>
                    <td><?=utf8_encode(ucwords(strtolower($p->descricao)))?></td>
                    <td><?=utf8_encode(ucwords(strtolower($p->forma_pagamento)))?></td>
                    <td<?=$estilo?> class="buttons sizeauto"><?=$fisico?></td>
                    <td class="buttons sizeauto"><?=invert($p->dt_vencimento, '/', 'PHP')?></td>
                    <td class="buttons sizeauto"<?=$estilo?>><?=$p->valor?></td>
                    <td class="buttons sizeauto"<?=$estilo?>><?=$p->desconto?></td>
                    <td class="buttons sizeauto"<?=$estilo?>><?=$p->vlr_multa?></td>
                    <td class="buttons sizeauto"<?=$estilo?>><?=$p->valor_pg?></td>
                    <td class="buttons"><a href="contas-a-pagar-editar.php<?=$link.'&id_pagamento='.$p->id_pagamento ?>"><img src="images/bt-edit.png"></a></td>
                    <?php if($controle_depto_p['27']!=1){ ?>
                        <td class="buttons"><a href="contas-a-pagar-listar.php<?=$link.'&acao=excluir&id_pagamento='.$p->id_pagamento ?>"><img src="images/bt-del.png"></a></td>
                    <?php } ?>
                </tr>
                <?php }
                $res = $pagamentoDAO->result();
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">&nbsp;</th>
                    <th colspan="2">Total</th>
                    <th class="buttons"><?=$res->valor?></th>
                    <th class="buttons"><?=$res->desconto?></th>
                    <th class="buttons"><?=$res->vlr_multa?></th>
                    <th class="buttons"><?=$res->valor_pg?></th>
                    <?php if($controle_depto_p['27']!=1){ ?>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    <?php } else { ?>
                        <th>&nbsp;</th>
                    <?php } ?>
                </tr>
            </tfoot>
        </table>
        <div class="paginacao">
            <?php $pagamentoDAO->QTDPagina(); ?>
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