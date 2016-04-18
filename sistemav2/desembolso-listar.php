<?php include('header.php'); 

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);
$show_msgbox = 0;

$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$financeiroDAO = new FinanceiroDAO();
$departamentoDAO = new DepartamentoDAO();
$contaDAO = new ContaDAO();

$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca_autorizacao = isset($c->busca_autorizacao) ? $c->busca_autorizacao : 0;
$c->busca_forma = isset($c->busca_forma) ? $c->busca_forma : '';
$c->busca_id_departamento = isset($c->busca_id_departamento) ? $c->busca_id_departamento : '';
$c->busca_nossa_conta = isset($c->busca_nossa_conta) ? $c->busca_nossa_conta : '';
$c->busca_data_i = isset($c->busca_data_i) ? $c->busca_data_i : date('d/m/Y');
$c->busca_data_f = isset($c->busca_data_f) ? $c->busca_data_f : date('t/m/Y');
$c->busca_id_pedido = isset($c->busca_id_pedido) ? $c->busca_id_pedido : '';
$c->busca_ordem = isset($c->busca_ordem) ? $c->busca_ordem : '';


$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca_autorizacao) > 0 ? '&busca_autorizacao='.$c->busca_autorizacao : '';
$link .= strlen($c->busca_forma) > 0 ? '&busca_forma='.$c->busca_forma : '';
$link .= strlen($c->busca_id_departamento) > 0 ? '&busca_id_departamento='.$c->busca_id_departamento : '';
$link .= strlen($c->busca_nossa_conta) > 0 ? '&busca_nossa_conta='.$c->busca_nossa_conta : '';
$link .= strlen($c->busca_data_i) > 0 ? '&busca_data_i='.$c->busca_data_i : '';
$link .= strlen($c->busca_data_f) > 0 ? '&busca_data_f='.$c->busca_data_f : '';
$link .= strlen($c->busca_id_pedido) > 0 ? '&busca_id_pedido='.$c->busca_id_pedido : '';
$link .= strlen($c->busca_ordem) > 0 ? '&busca_ordem='.$c->busca_ordem : '';

$acao_desembolso = '';
$big_msg_box_color = '';
if($_GET OR $_POST){
    if($_POST){
        $p = UTF_Encodes(Post_StdClass($_POST), 2);
        $acao_desembolso = isset($_POST['acao_desembolso']) ? $p->acao_desembolso : '';
    }
    if($acao_desembolso == ''){
        $acao_desembolso = isset($_GET['acao_desembolso']) ? $c->acao_desembolso : '';        
    }
    if($acao_desembolso != ''){
        switch($acao_desembolso){
            case 'aprovar': include('desembolso-listar-aprovar.php'); break;
            case 'reprovar': include('desembolso-listar-reprovar.php'); break;
            case 'execucao': include('desembolso-listar-execucao.php'); break;
            case 'efetuado': include('desembolso-listar-efetuado.php'); break;
            case 'conferido': include('desembolso-listar-conferido.php'); break;
            case 'alterar_conta': include('desembolso-listar-alterar-conta.php'); break;
        }  
    }
} ?>
<script>
    menu(3,'bt-04');
    $('#titulo').html('financeiro &rsaquo;&rsaquo; desembolso');
    $('#sub-27').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get" id="form1" name="form1">
        <dl>
            <legend>Buscar Desembolsos</legend>
            <dt>Situação:</dt>
            <dd>
                <select name="busca_autorizacao" id="busca_autorizacao" class="chzn-select">
                    <?php foreach(TiposDeStatus(12) AS $f){ ?>
                        <option value="<?=$f['id']?>" <?=$c->busca_autorizacao==$f['id'] ? 'selected="select"' : '' ?>><?=$f['texto']?></option>
                    <?php } ?>
                </select>
            </dd>
            
            <dt>Forma:</dt> 
            <dd>
                <select name="busca_forma" id="busca_forma" class="chzn-select">
                    <option value="" <?= ($c->busca_forma=='') ? 'selected="select"' : ''; ?>>Forma</option>
                    <?php foreach($financeiroDAO->listarForma() as $f){ ?>
                       <option value="<?=utf8_encode($f->forma_2)?>" <?=($c->busca_forma==$f->forma_2) ? ' selected ' : ''?>><?=utf8_encode($f->forma)?></option>
                    <?php } ?>
                    <option value="_" <?= ($c->busca_forma=='_') ? 'selected="select"' : '' ?>>Todos (exceto depósito e boleto)</option>
                </select>
            </dd>
            
            <dt>Departamento:</dt>
            <dd>
                <select name="busca_id_departamento" id="busca_id_departamento" class="chzn-select">
                    <option value="" <?=($c->busca_id_departamento=='') ? ' selected="selected" ' : ''; ?>>Todos</option>
                        <?php foreach($departamentoDAO->listarDptoOrdem() as $f){ ?>
                            <option value="<?=$f->id_servico_departamento?>" <?=($c->busca_id_departamento==$f->id_servico_departamento) ? ' selected="selected" ':''?> ><?=utf8_encode($f->departamento)?></option>
                        <?php } ?>
                </select>
            </dd>
            
            <dt>Banco:</dt> 
            <dd>
                <select name="busca_nossa_conta" id="busca_nossa_conta" class="chzn-select">
                    <option value="" <?= ($c->busca_nossa_conta=='') ? ' selected="selected" ' : ''; ?>>Todos</option>
                    <?php  foreach($contaDAO->listarConta($controle_id_empresa) as $f){ ?>
                        <option value="<?=utf8_encode($f->sigla)?>" <?=(utf8_encode($f->sigla)==$c->busca_nossa_conta) ? 'selected="select"' : '';?>><?=utf8_encode($f->sigla)?></option>
                    <?php } ?>
                </select>
            </dd>
            
            <dt>Entre:</dt>
            <dd>
                <input type="text" name="busca_data_i" id="busca_data_i" value="<?= $c->busca_data_i ?>" class="data" placeholder="Data Inicio">
            </dd>
            <dt>e:</dt>
            <dd>
                <input type="text" name="busca_data_f" id="busca_data_f" value="<?= $c->busca_data_f ?>" class="data" placeholder="Data Fim">
            </dd>
            
            <dt>Ordem:</dt>
            <dd>
                <input type="text" name="busca_id_pedido" id="busca_id_pedido" value="<?= $c->busca_id_pedido ?>" class="numero" placeholder="Ordem">
            </dd>
            <dt>Serviço:</dt>
            <dd>
                <input type="text" name="busca_ordem" id="busca_ordem" value="<?= $c->busca_ordem ?>" class="numero" placeholder="Serviço">
            </dd>
            
            <div class="buttons">
                <input type="hidden" id="NoStatusCheck" value="desembolso-listar.php<?=$link?>">
                <input type="hidden" id="acao_desembolso" name="acao_desembolso">
                <input type="hidden" id="hash" name="hash" value="<?=date('s')?>">
                <?php 
                #echo $acao_desembolso;
                if($c->busca_autorizacao == 0 AND ($_POST OR $_GET)) { ?>
                    <input type="button" value="aprovar &rsaquo;&rsaquo;" onclick="AcaoDesembolso('aprovar','form1');">
                    <input type="button" value="reprovar &rsaquo;&rsaquo;" onclick="AcaoDesembolso('reprovar','form1');">
                <?php } else { 
                    if($c->busca_autorizacao==3 AND ($_POST OR $_GET)){?>
                        <input type="button" value="em execução &rsaquo;&rsaquo;" style="width: auto"  onclick="AcaoDesembolso('execucao','form1');">
                        <input type="button" value="efetuado &rsaquo;&rsaquo;"  onclick="DesembolsoConfirm(1,'efetuado')">
                    <?php } else {
                        if($c->busca_autorizacao==4  AND ($_POST OR $_GET)){?>
                            <input type="button" value="conferido &rsaquo;&rsaquo;" onclick="AcaoDesembolso('conferido','form1');">
                    <?php }
                    }
                } 
                if($_POST OR $_GET){ ?>
                <input type="button" value="alterar conta &rsaquo;&rsaquo;" style="width: auto" onclick="DesembolsoConfirm(1,'alterar_conta')">
                | 
                <?php } ?>
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <?php if($_POST OR $_GET){?>
                    <input type="button" value="exportar &rsaquo;&rsaquo;" onclick="DesembolsoConfirm(0,'arquivo')">  
                <?php } ?>
                <input type="submit" value="buscar &rsaquo;&rsaquo;"> 
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">   
<?php if($_GET OR $_POST){ 
    $busca = new stdClass();
    $busca->busca_id_departamento = $c->busca_id_departamento;
    $busca->busca_nossa_conta 	= $c->busca_nossa_conta;
    $busca->busca_id_pedido = $c->busca_id_pedido;
    $busca->busca_ordem = $c->busca_ordem;
    $busca->busca_data_i = $c->busca_data_i.' 00:00:00';
    $busca->busca_data_f = $c->busca_data_f.' 23:59:59';
    $busca->busca_autorizacao = $c->busca_autorizacao;
    $busca->busca_forma = $c->busca_forma;
    
    
    $lista = $financeiroDAO->buscaDesembolso($busca,$controle_id_empresa,$c->pagina);
    if(count($lista) > 0 AND $lista[0]->financeiro_valor_t != ''){ ?>
        <div class="paginacao">
            <?php $financeiroDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr style="background: transparent">
                    <th colspan="9" style="background: transparent">
                        <b>Movimentação do Período</b><br> 
                        Solicitado: R$ <?= number_format($lista[0]->financeiro_valor_t,2,".","") ?>&nbsp;
                        Desembolsado: R$ <?= number_format($lista[0]->financeiro_desembolsado_t,2,".","") ?>&nbsp;
                        Troco: R$ <?= number_format($lista[0]->financeiro_troco_t,2,".","") ?>&nbsp;
                    </th>
                </tr>
                <tr>
                    <th class="buttons"><input type="checkbox" name="check3" id="check3" value="1" onclick="CheckAll(this.id);CkechSession(2,'.check3','desembolso')"></th>
                    <th class="buttons">#</th>
                    <th class="buttons">ordem</th>
                    <th>forma</th>
                    <th class="buttons size100">desembolso</th>
                    <th class="buttons size100">desembolsado</th>
                    <th class="buttons size100">troco</th>
                    <th class="buttons size100">valor recebido</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                $valor_total          		= 0;
                $financeiro_valor_total     	= 0;
                $financeiro_troco_total         = 0;
                $financeiro_desembolsado_total  = 0;
                foreach($lista as $l){
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; 
                    $id_pedido_item = $l->id_pedido_item;
                    $data_prazo     = invert($l->data_prazo,'/','PHP');
                    $data_agenda    = invert($l->data_i,'/','PHP');
                    $valor          = $l->valor;
                    $rel            = $l->rel;
                    if($rel=='1') $rel='Sim'; else $rel='Não';
                    $financeiro_valor = $l->financeiro_valor;
                    $financeiro_troco = $l->financeiro_troco;
                    $financeiro_desembolsado = $l->financeiro_desembolsado;
                    if($financeiro_troco=='')$financeiro_troco='0';
                    if($financeiro_desembolsado=='')$financeiro_desembolsado='0';
                    if($financeiro_valor>$valor){
                        $erro_desembolso = "error";
                    } else { $erro_desembolso = ""; }
                    if($l->des2==1){ 
                        $erro_desembolso2 = "error";
                    } else { $erro_desembolso2 = ""; }


                    $valor_total      = (float)($valor_total)+(float)($l->valor);
                    $financeiro_valor_total      = (float)($financeiro_valor_total)+(float)($financeiro_valor);
                    $financeiro_troco_total      = (float)($financeiro_troco_total)+(float)($financeiro_troco);
                    $financeiro_desembolsado_total      = (float)($financeiro_desembolsado_total)+(float)($financeiro_desembolsado);
                    $valor            = 'R$ '.number_format($valor,2,".","");
                    $financeiro_valor = 'R$ '.number_format($financeiro_valor,2,".","");
                    $financeiro_troco = 'R$ '.number_format($financeiro_troco,2,".","");
                    $financeiro_desembolsado = 'R$ '.number_format($financeiro_desembolsado,2,".",""); ?>
                    <tr <?=TRColor($color)?>>
                        <td class="buttons"><input <?=((isset($_SESSION['desembolso']) AND count($_SESSION['desembolso']) > 0 AND in_array($l->id_financeiro.';'.$l->id_pedido_item.';'.$l->id_pedido.';'.$l->ordem, $_SESSION['desembolso'])) ? 'checked="checked"' : '')?> type="checkbox" name="id_desembolso[]" id="id_desembolso<?=$l->id_pedido_item?>" value="<?=$l->id_financeiro.';'.$l->id_pedido_item.';'.$l->id_pedido.';'.$l->ordem?>" class="check1" onclick="CkechSession(1,this.id,'desembolso')"></td>
                        <td class="buttons"><?=$l->id_financeiro?></td>
                        <td class="buttons <?=$erro_desembolso2?>"><a href="#" onclick="DesembolsoPedido(<?=$l->id_financeiro.','.$l->id_pedido_item.','.$l->id_pedido . ','.$l->ordem.',1'?>)">#<?=$l->id_pedido . '/'.$l->ordem?></a></td>
                        <td><?=utf8_encode($l->financeiro_forma)?></td>
                        <td class="buttons size100 <?=$erro_desembolso?>"><a href="#" onclick="DesembolsoPedido(<?=$l->id_financeiro.','.$l->id_pedido_item.','.$l->id_pedido . ','.$l->ordem.',2'?>)"><?=$financeiro_valor?></a></td>
                        <td class="buttons size100"><?=$financeiro_desembolsado?></td>
                        <td class="buttons size100"><?=$financeiro_troco?></td>
                        <td class="buttons size100"><?=$valor?></td>
                        <td class="buttons"><a href="pedidos-editar.php?id=<?=$l->id_pedido . '&ordem='.$l->ordem?>" target="_blank"><img src="images/bt-edit.png"></a></td>
                    </tr>
                <?php } 
                $valor_total            		= 'R$ '.number_format($valor_total,2,".","");
                $financeiro_valor_total     	= 'R$ '.number_format($financeiro_valor_total,2,".","");
                $financeiro_troco_total         = 'R$ '.number_format($financeiro_troco_total,2,".","");
                $financeiro_desembolsado_total  = 'R$ '.number_format($financeiro_desembolsado_total,2,".",""); ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">&nbsp;</th>
                    <th>Total</th>
                    <th class="buttons size100"><?=$financeiro_valor_total?></th>
                    <th class="buttons size100"><?=$financeiro_desembolsado_total?></th>
                    <th class="buttons size100"><?=$financeiro_troco_total?></th>
                    <th class="buttons size100"><?=$valor_total?></th>
                    <th>&nbsp;</th>
                </tr>
            </tfoot>
        </table>
        <div class="paginacao">
            <?php $financeiroDAO->QTDPagina(); ?>
        </div>
    <?php } else { 
        RetornaVazio();
        $zera_sessao = 1;
    }    
} else {
    RetornaVazio(2);
    $zera_sessao = 1;
} 
if(isset($zera_sessao)){ 
    echo "<script>CkechSession(3,'.check1','zera_sessao')</script>";
} ?>
</div>
<?php include('footer.php'); ?>