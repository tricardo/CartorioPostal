<?php include('header.php'); 


$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);

$permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE') {
    header('location:pagina-erro.php');
    exit;
}


$contaDAO = new ContaDAO();
$financeiroDAO = new FinanceiroDAO();
$departamentoDAO = new DepartamentoDAO();
$statusDAO = new StatusDAO();
$empresaDAO = new EmpresaDAO();
$pedidoDAO = new PedidoDAO();
$atividadeDAO = new AtividadeDAO();
$financeiroverificaDAO = new FinanceiroVerificaDAO();

$show_msgbox = 0;


$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca_autorizacao = isset($c->busca_autorizacao) ? $c->busca_autorizacao : '';
$c->busca_data_i = isset($c->busca_data_i) ? $c->busca_data_i : date('01/m/Y', strtotime('-1 years', strtotime(date('Y-m-15'))));
$c->busca_data_f = isset($c->busca_data_f) ? $c->busca_data_f : date('01/m/Y');
$c->busca_id_departamento = isset($c->busca_id_departamento) ? $c->busca_id_departamento : '';
$c->busca_id_status = isset($c->busca_id_status) ? $c->busca_id_status : '';
$c->busca_id_empresa = isset($c->busca_id_empresa) ? $c->busca_id_empresa : '';
$c->busca_id_pedido = isset($c->busca_id_pedido) ? $c->busca_id_pedido : '';
$c->busca_ord = isset($c->busca_ord) ? $c->busca_ord : '';
$c->busca_ordenar = isset($c->busca_ordenar) ? $c->busca_ordenar : '';


$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= strlen($c->busca_autorizacao) > 0 ? '&busca_autorizacao='.$c->busca_autorizacao : '';
$link .= strlen($c->busca_data_i) > 0 ? '&busca_data_i='.$c->busca_data_i : '';
$link .= strlen($c->busca_data_f) > 0 ? '&busca_data_f='.$c->busca_data_f : '';
$link .= strlen($c->busca_id_departamento) > 0 ? '&busca_id_departamento='.$c->busca_id_departamento : '';
$link .= strlen($c->busca_id_status) > 0 ? '&busca_id_status='.$c->busca_id_status : '';
$link .= strlen($c->busca_id_empresa) > 0 ? '&busca_id_empresa='.$c->busca_id_empresa : '';
$link .= strlen($c->busca_id_pedido) > 0 ? '&busca_id_pedido='.$c->busca_id_pedido : '';
$link .= strlen($c->busca_ord) > 0 ? '&busca_ord='.$c->busca_ord : '';
$link .= strlen($c->busca_ordenar) > 0 ? '&busca_ordenar='.$c->busca_ordenar : '';

$busca = new stdClass();
$busca->busca_autorizacao=$c->busca_autorizacao;
$busca->busca_data_i=$c->busca_data_i;
$busca->busca_data_f=$c->busca_data_f;
$busca->busca_id_departamento=$c->busca_id_departamento;
$busca->busca_id_status=$c->busca_id_status;
$busca->busca_id_empresa=$c->busca_id_empresa;
$busca->busca_id_pedido=$c->busca_id_pedido;
$busca->busca_ord=$c->busca_ord;
$busca->busca_ordenar=$c->busca_ordenar;

$acao_direcionamento = '';
$big_msg_box_color = '';
if($_GET OR $_POST){
    if($_POST){
        $p = UTF_Encodes(Post_StdClass($_POST), 2);
        $acao_direcionamento = isset($_POST['acao_direcionamento']) ? $p->acao_direcionamento : '';
    }
    if($acao_direcionamento == ''){
        $acao_direcionamento = isset($_GET['acao_direcionamento']) ? $c->acao_direcionamento : '';        
    }
    if($acao_direcionamento != ''){
        switch($acao_direcionamento){
            case 'aprovar': include('recebimentos-de-franquias-listar-aprovar.php'); break;
            case 'devolver': include('recebimentos-de-franquias-listar-devolver.php'); break;
        }  
    }
}
?>
<script>
    menu(3,'bt-04');
    $('#titulo').html('financeiro &rsaquo;&rsaquo; franquias');
    $('#sub-29').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get" id="form1" name="form1">       
        <dl>
            <legend>Buscar Recebimentos de Franquias</legend>
            <dt>Situação:</dt>
            <dd>
                <select name="busca_autorizacao" id="busca_autorizacao" class="chzn-select">		
                    <option value="À Receber" <?=($c->busca_autorizacao == '' or $c->busca_autorizacao == 'À Receber')? 'selected="select"' : ''; ?>>À Receber</option>
                    <option value="Recebido" <?=($c->busca_autorizacao == 'Recebido') ? 'selected="select"' : ''; ?>>Recebido</option>
                </select>
            </dd>
            <dt>Departamento:</dt>
            <dd>
                <select name="busca_id_departamento" id="busca_id_departamento" class="chzn-select">
                    <option value="" <?=($c->busca_id_departamento == '') ? ' selected="selected" ' : ''; ?>>Todos</option>
                    <?php $p_valor = '';
                    foreach ($departamentoDAO->listarDptoOrdem() as $s) {
                        $p_valor .= '<option value="' . $s->id_servico_departamento . '"'.(($c->busca_id_departamento == $s->id_servico_departamento) ? ' selected="selected" ' : '').'>' . utf8_encode($s->departamento) . '</option>';
                    }
                    echo $p_valor; ?>
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
            <dt>Status:</dt>
            <dd>
                <select name="busca_id_status" id="busca_id_status" class="chzn-select">
                    <option value="Todos">Todos (Exceto Concluído)</option>
                    <?php $p_valor = '';
                    foreach($statusDAO->listarTodos() as $s) {
                        $p_valor .= '<option value="' . $s->id_status . '"'.(($c->busca_id_status == $s->id_status) ? ' selected="selected" ' : '').' >' . utf8_encode($s->status) . '</option>';
                    }
                    echo $p_valor; ?>
                </select>
            </dd>
            <dt>Unidades:</dt>
            <dd>
                <select name="busca_id_empresa" id="busca_id_empresa" class="chzn-select">		
                    <option value="" <?=($c->busca_id_empresa=='') ? ' selected="selected" ' : ''; ?>>Todos</option>		
                    <?php $p_valor = '';			
                    foreach($empresaDAO->listarTodas() as $s){
                        $p_valor .= '<option value="'.$s->id_empresa.'"'.(($c->busca_id_empresa==$s->id_empresa) ? ' selected="selected" ' : '').'>'.utf8_encode(str_replace('Cartório Postal - ','',$s->fantasia)).'</option>';			
                    }			
                    echo $p_valor;		 
                    ?>        	
                </select>
            </dd>
            <dt>Ordenar:</dt> 
            <dd>
                <select name="busca_ordenar" id="busca_ordenar" class="chzn-select">
                    <option value="" <?=($c->busca_ordenar == '') ? ' selected="selected" ' : ''; ?>>Ordenar</option>
                    <option value="Ordem" <?=($c->busca_ordenar == 'Ordem') ? ' selected="selected" ' : ''; ?>>Ordem</option>
                    <option value="Documento de" <?=($c->busca_ordenar == 'Documento de') ? ' selected="selected" ' : ''; ?>>Documento de</option>
                    <option value="Data" <?=($c->busca_ordenar == 'Data') ? ' selected="selected" ' : ''; ?>>Data</option>
                    <option value="Departamento" <?=($c->busca_ordenar == 'Departamento') ? ' selected="selected" ' : ''; ?>>Departamento</option>
                    <option value="Serviço"	<?=($c->busca_ordenar == 'Serviço') ? ' selected="selected" ' : ''; ?>>Serviço</option>
                    <option value="Cidade" <?=($c->busca_ordenar == 'Cidade') ? ' selected="selected" ' : ''; ?>>Cidade</option>
                    <option value="Prazo" <?=($c->busca_ordenar == 'Prazo') ? ' selected="selected" ' : ''; ?>>Prazo</option>
                    <option value="Agenda" <?=($c->busca_ordenar == 'Agenda') ? ' selected="selected" ' : ''; ?>>Agenda</option>
                    <option value="Data Status" <?=($c->busca_ordenar == 'Data Status') ? ' selected="selected" ' : ''; ?>>Data Status</option>
		</select> 
            </dd>
            <dt>&nbsp;</dt>
            <dd>
                <select name="busca_ord" id="busca_ord" class="chzn-select">
                    <option value=""<?=($c->busca_ord=='') ? ' selected="selected" ' : ''; ?>>Crescente</option>
                    <option value="Decr"<?=($c->busca_ord=='Decr') ? ' selected="selected" '  : ''; ?>>Decrescente</option>
		</select>
            </dd>  
            <dt>Ordem:</dt> 
            <dd>
                <input type="text" class="ordem" name="busca_id_pedido" id="busca_id_pedido" value="<?= $c->busca_id_pedido ?>" placeholder="Ordem"> 
            </dd>
            
            <div class="buttons">
                <input type="hidden" id="NoStatusCheck" value="recebimentos-de-franquias-listar.php<?=$link?>">
                <input type="hidden" id="acao_direcionamento" name="acao_direcionamento">
                <input type="hidden" id="hash" name="hash" value="<?=date('s')?>">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
        </dl>
        <?php if($_GET OR $_POST){?>
        <dl>
            <div class="buttons">
                <input type="button" value="exportar &rsaquo;&rsaquo;" onclick="RecOutrasFranqConfirm(0,'arquivo')">
                |
                <input type="button" value="aprovar &rsaquo;&rsaquo;" onclick="RecOutrasFranqConfirm(1,'aprovar')">
                <input type="button" value="devolver &rsaquo;&rsaquo;" onclick="RecOutrasFranqConfirm(1,'devolver')">
            </div>
        </dl>
         <?php } ?>
    </form>
</div>

<div class="content-list-table">   
<?php
if($_GET){ 
    $busca->busca_data_i = invert($c->busca_data_i, '-', 'SQL');
    $busca->busca_data_f = invert($c->busca_data_f, '-', 'SQL');
    $buscapedido = $financeiroDAO->buscaRecebimentoF($busca, $controle_id_empresa, $c->pagina);
    if(count($buscapedido) > 0){  ?>
        <div class="paginacao">
            <?php $financeiroDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons"><input type="checkbox" name="check1" id="check1" value="1" onclick="CheckAll(this.id);CkechSession(2,'.check1','royalties')"></th>
                    <th class="buttons">#</th>
                    <th class="buttons">ordem</th>	
                    <th>unidade</th>	
                    <th>serviço</th>
                    <th class="buttons">recebido em</th>
                    <th class="buttons">custas</th>	
                    <th class="buttons">correios</th>	
                    <th class="buttons">honorários</th>	
                    <th class="buttons">custo total</th>	
                    <th class="buttons">valor rec.</th>	
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                $financeiro_valor_f_total = 0;
                $financeiro_valor_total = 0;
                $financeiro_valor_stotal = 0;
                $financeiro_valor_rtotal = 0;
                $financeiro_valor_vtotal = 0;
                $comissao_total = 0;
                foreach($buscapedido as $p){ 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';   
                    $financeiro_valor_f = $p->financeiro_valor_f;
                    $comissao = number_format((float) ($p->valor) / 100 * 14, 2, ".", ",");
                    $financeiro_valor_f = number_format($financeiro_valor_f, 2, ".", ",");
                    
                    $financeiro_valor_f_total = (float) ($financeiro_valor_f_total) + (float) ($financeiro_valor_f);
                    $financeiro_valor_total = (float) ($financeiro_valor_total) + (float) ($p->financeiro_valor);
                    $financeiro_valor_stotal = (float) ($financeiro_valor_stotal) + (float) ($p->financeiro_sedex);
                    $financeiro_valor_rtotal = (float) ($financeiro_valor_rtotal) + (float) ($p->financeiro_rateio);
                    $financeiro_valor_vtotal = (float) ($financeiro_valor_vtotal) + (float) ($p->financeiro_custas);
                    
                    $p->financeiro_valor = number_format($p->financeiro_valor, 2, ".", "");
                    $p->financeiro_sedex = number_format((float) ($p->financeiro_sedex), 2, ".", "");
                    $p->financeiro_rateio = number_format((float) ($p->financeiro_rateio), 2, ".", "");
                    $p->financeiro_custas = number_format((float) ($p->financeiro_custas), 2, ".", "");
                    
                    $comissao_total = (float) ($comissao_total) + (float) ($comissao);
                    $financeiro_valor_f_num = $financeiro_valor_f;
                    $id_re = $p->id_financeiro;
                    ?>
                     <tr <?=TRColor($color)?>>
                        <td class="buttons"><input <?=((isset($_SESSION['fi_franquia']) AND count($_SESSION['fi_franquia']) > 0 AND in_array($p->id_financeiro.';'.$p->id_pedido_item, $_SESSION['fi_franquia'])) ? 'checked="checked"' : '')?> type="checkbox" name="id_financeiro[]" id="id_financeiro<?=$p->id_financeiro?>" value="<?=$p->id_financeiro.';'.$p->id_pedido_item?>" class="check1" onclick="CkechSession(1,this.id,'fi_franquia')"></td>
                        <td class="buttons"><?=$p->id_financeiro?></td>
                        <td class="buttons"><?='#'.$p->id_pedido . '/' . $p->ordem ?></td>
                        <td><?=utf8_encode($p->fantasia)?></td>
                        <td><?=utf8_encode($p->servico)?></td>
                        <td class="buttons"><?=invert($p->financeiro_autorizacao_data, '/', 'PHP') ?></td>
                        <td class="buttons"><?=$p->financeiro_custas?></td>
                        <td class="buttons"><?=$p->financeiro_sedex?></td>
                        <td class="buttons"><?=$p->financeiro_rateio?></td>
                        <td class="buttons"><?=$p->financeiro_valor?></td>
                        <td class="buttons"><?=$financeiro_valor_f?></td>                        
                        <td class="buttons"><a href="pedidos-editar.php?id=<?=$p->id_pedido . '&ordem='.$p->ordem?>" target="_blank"><img src="images/bt-edit.png"></a></td>
                    </tr>
                <?php } ?>
            </tbody>   
            <tfoot>
                <tr>
                    <th colspan="4"></th>
                    <th colspan="2">total</th>
                    <th class="buttons"><?=number_format((float)$financeiro_valor_vtotal, 2, '.', '')?></th>
                    <th class="buttons"><?=number_format((float)$financeiro_valor_stotal, 2, '.', '')?></th>
                    <th class="buttons"><?=number_format((float)$financeiro_valor_rtotal, 2, '.', '')?></th>
                    <th class="buttons"><?=number_format((float)$financeiro_valor_total, 2, '.', '')?></th>
                    <th class="buttons"><?=number_format((float)$financeiro_valor_f_total, 2, '.', '')?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <div class="paginacao">
            <?php $financeiroDAO->QTDPagina(); ?>
        </div>
    <?php 
    } else { 
        RetornaVazio();
        $zera_sessao = 1;
    }    
} else {
    RetornaVazio(2);
    $zera_sessao = 1;
} 
if(isset($zera_sessao)){ 
    echo "<script>CkechSession(3,'.check3','zera_sessao')</script>";
} ?>
</div>
<?php include('footer.php'); ?>