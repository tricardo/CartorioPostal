<?php include('header.php'); 

#if($controle_id_usuario != 1){
#    header('location:http://www.cartoriopostal.com.br/sistema/controle/financeiro_pagamento.php');
#    exit;
#}


$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);
$atividadeDAO = new AtividadeDAO();
$statusDAO = new StatusDAO();
$usuarioDAO = new UsuarioDAO();
$financeiroDAO = new FinanceiroDAO();
$contaDAO = new ContaDAO();
$pedidoDAO = new PedidoDAO();
$departamentoDAO = new DepartamentoDAO();
$atividadeverificaDAO = new AtividadeVerificaDAO();
$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$link = '';
$link .= '?pagina='.$c->pagina;
$c->busca_data_i = isset($c->busca_data_i) ? $c->busca_data_i : date('d/m/Y', strtotime('-5 years', strtotime(date('Y-m-d H:i:s'))));
$c->busca_data_f = isset($c->busca_data_f) ? $c->busca_data_f : date('d/m/Y');
$c->busca_data_i_a = isset($c->busca_data_i_a) ? $c->busca_data_i_a : date('d/m/Y', strtotime('-5 years', strtotime(date('Y-m-d H:i:s'))));
$c->busca_data_f_a = isset($c->busca_data_f_a) ? $c->busca_data_f_a : date('d/m/Y');
$c->busca_data_i_f = isset($c->busca_data_i_f) ? $c->busca_data_i_f : '';
$c->busca_data_f_f = isset($c->busca_data_f_f) ? $c->busca_data_f_f : '';
$c->busca_data_ci = isset($c->busca_data_ci) ? $c->busca_data_ci : '';
$c->busca_data_cf = isset($c->busca_data_cf) ? $c->busca_data_cf : '';

$arr_c = array('busca','busca_id_fatura','busca_autorizacao','busca_id_status','busca_forma_pagamento',
    'busca_id_atividade','busca_id_pacote','busca_origem','busca_id_departamento',
    'busca_id_usuario','busca_data_i','busca_data_f','busca_id_pedido','busca_ordenar','busca_ord',
    'busca_data_i_a','busca_data_f_a','busca_data_i_f','busca_data_f_f','busca_data_ci','busca_data_cf');
for($i = 0; $i < count($arr_c); $i++){
    $c->$arr_c[$i] = isset($c->$arr_c[$i]) ? $c->$arr_c[$i] : '';
    $link .= strlen($c->$arr_c[$i]) > 0 ? '&'.$arr_c[$i].'='.$c->$arr_c[$i] : '';
}

$arr_c = array('busca_e_nome','busca_e_cpf','busca_e_inicio','busca_e_prazo','busca_e_agenda','busca_e_data_atividade',
    'busca_e_departamento','busca_e_servico','busca_e_cidade','busca_e_estado','busca_e_status',
    'busca_e_atividade','busca_e_atendimento','busca_e_devedor','busca_e_forma','busca_e_origem');
for($i = 0; $i < count($arr_c); $i++){
    $c->$arr_c[$i] = isset($c->$arr_c[$i]) ? 1 : '';
    $link .= strlen($c->$arr_c[$i]) > 0 ? '&'.$c->$arr_c[$i].'=1' : '';
}



$acao_rec_pedido = '';
$big_msg_box_color = '';

if($_GET OR $_POST){
    if($_POST){
        $p = UTF_Encodes(Post_StdClass($_POST), 2);
        $acao_rec_pedido = isset($_POST['acao_rec_pedido']) ? $p->acao_rec_pedido : '';
    }
    if($acao_rec_pedido == ''){
        $acao_rec_pedido = isset($_GET['acao_rec_pedido']) ? $c->acao_rec_pedido : '';        
    }   
    if($acao_rec_pedido != ''){
        switch($acao_rec_pedido){
            case 'boleto': include('recebimentos-de-pedidos-boleto.php'); break;
        }  
    }
} ?>

<script>
    menu(3,'bt-04');
    $('#titulo').html('financeiro &rsaquo;&rsaquo; pedidos');
    $('#sub-28').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get" id="form1" name="form1">
        <dl>
            <legend>Buscar Recebimentos de Pedidos</legend>
            <dt>Situação:</dt>
            <dd>
                <select name="busca_autorizacao" id="busca_autorizacao" class="chzn-select">
                    <option value="">Todos</option>
                    <option value="À Receber" <?=($c->busca_autorizacao == 'À Receber') ? 'selected="select"' : ''; ?>>À Receber</option>
                    <option value="Recebido" <?=($c->busca_autorizacao == 'Recebido') ? 'selected="select"':''; ?>>Recebido</option>
                </select>
            </dd>
            <dt>Status:</dt>
            <dd>
                <select name="busca_id_status" id="busca_id_status" class="chzn-select">
                    <option value="">Todos</option>
                    <?php $p_valor = '';			
                    foreach($statusDAO->listarTodos() as $s){			
                        $p_valor .= '<option value="'.$s->id_status.'"' .(($busca_id_status==$s->id_status) ? ' selected="selected" ' : '').'>'.utf8_encode($s->status).'</option>';		
                    }
                    echo $p_valor; ?>
                </select> 
            </dd>
            <dt>Forma:</dt>
            <dd>
                <select name="busca_forma_pagamento" id="busca_forma_pagamento" class="chzn-select">
                    <option value="">Todos</option>		
                    <?php $p_valor = '';		
                    foreach($financeiroDAO->listarFormaPagamento() as $s){			
                        $p_valor .= '<option value="'.$s->forma_pagamento.'"'.(($busca_forma_pagamento==$s->forma_pagamento) ? ' selected="selected" ' : '').'>'.utf8_encode($s->forma_pagamento).'</option>';	
                    }		
                    echo $p_valor; ?>	
                </select>
            </dd>
            <dt>Atividade:</dt>
            <dd>
                <select name="busca_id_atividade" id="busca_id_atividade" class="chzn-select">
                    <option value="" <?=($c->busca_id_atividade=='') ? ' selected="selected" ' : ''; ?>>Todos</option>
                    <?php $p_valor = '';
                    foreach($atividadeDAO->listaAtividadesTodas() as $s){			
                        $p_valor .= '<option value="'.$s->id_atividade.'"'.(($c->busca_id_atividade==$s->id_atividade) ? ' selected="selected" ' : '').' >'.utf8_encode($s->atividade).'</option>';
                    }		
                    echo $p_valor; ?>
                </select>
            </dd>
            <dt>Pacote:</dt> 	
            <dd>
                <select name="busca_id_pacote" id="busca_id_pacote" class="chzn-select">		
                    <option value="" <?=($c->busca_id_pacote=='') ? ' selected="selected" ' : ''; ?>>Sem Pacote</option>		
                    <?php $p_valor = '';		
                    foreach($financeiroDAO->listarPacote() as $s){			
                        $p_valor .= '<option value="'.$s->id_pacote.'"'.(($c->busca_id_pacote==$s->id_pacote) ? ' selected="selected" ' : '').'>'.utf8_encode($s->pacote).'</option>';		
                    }
                    echo $p_valor;	?>	
                </select>
            </dd>
            <dt>Origem:</dt> 	
            <dd>
                <select name="busca_origem" id="busca_origem" class="chzn-select">		
                    <option value="">Todos</option>		
                    <?php foreach($pedidoDAO->listarOrigem() as $l){			
                        echo '<option value="'.$l->origem.'"'.(($c->busca_origem==$l->origem) ? ' selected="selected" ' : '').'>'.utf8_encode($l->origem).'</option>';		
                    } ?>	
                </select> 	
            </dd>
            <dt>Departamento: </dt> 	
            <dd>
                <select name="busca_id_departamento" id="busca_id_departamento" class="chzn-select">
                    <option value=""<?=($c->busca_id_departamento=='') ? ' selected="selected" ' : ''; ?>>Todos</option>		
                    <?php $p_valor = '';			
                    foreach($departamentoDAO->listarDptoOrdem() as $s){				
                        $p_valor .= '<option value="'.$s->id_servico_departamento.'"'.(($c->busca_id_departamento==$s->id_servico_departamento) ? ' selected="selected" ' : ''). '>'.utf8_encode($s->departamento).'</option>';			
                    }			
                    echo $p_valor;?>	
                </select>	
            </dd>
            <dt>Atendente: </dt>   
            <dd>
                <select name="busca_id_usuario" id="busca_id_usuario" class="chzn-select">            
                    <option value="" <?=($c->busca_id_usuario=='') ? ' selected="selected" ' : ''; ?>>Todos</option>            
                    <?php $p_valor_combo = '';				
                    foreach($usuarioDAO->listarAtendentes($controle_id_empresa) as $s){					
                        $p_valor_combo .= '<option value="'.$s->id_usuario.'"'.(($busca_id_usuario==$s->id_usuario) ? ' selected="selected" ' : '').'>'.utf8_encode($s->nome).'</option>';				
                    }				
                    echo $p_valor_combo; ?>		
                </select>	
            </dd>
            
            <dt>Aberto Entre: </dt> 	
            <dd>
                <input type="text" name="busca_data_i" id="busca_data_i" value="<?=$c->busca_data_i?>" class="data"> 	
            </dd>
            <dt>E:</dt>
            <dd>
                <input type="text" name="busca_data_f" id="busca_data_f" value="<?=$c->busca_data_f?>" class="data"> 	
            </dd>
            
            <dt>Alterado Entre: </dt> 	
            <dd>
                <input type="text" name="busca_data_i_a" id="busca_data_i_a" value="<?=$c->busca_data_i_a?>" class="data"> 	
            </dd>
            <dt>E:</dt>
            <dd>
                <input type="text" name="busca_data_f_a" id="busca_data_f_a" value="<?=$c->busca_data_f_a?>" class="data"> 	
            </dd>
            
            <dt>Fechado Entre: </dt> 	
            <dd>
                <input type="text" name="busca_data_i_f" id="busca_data_i_f" value="<?=$c->busca_data_i_f?>" class="data"> 	
            </dd>
            <dt>E:</dt>
            <dd>
                <input type="text" name="busca_data_f_f" id="busca_data_f_f" value="<?=$c->busca_data_f_f?>" class="data"> 	
            </dd>
            
            <dt>Concl. Entre: </dt> 	
            <dd>
                <input type="text" name="busca_data_ci" id="busca_data_ci" value="<?=$c->busca_data_ci?>" class="data"> 	
            </dd>
            <dt>E:</dt>
            <dd>
                <input type="text" name="busca_data_cf" id="busca_data_cf" value="<?=$c->busca_data_cf?>" class="data"> 	
            </dd>
            <dt>Buscar:</dt>
            <dd class="line1">
                <input type="text" id="busca" name="busca" value="<?= $c->busca ?>" placeholder="Pesquisar">
            </dd>
            <dt>Ordem:</dt> 
            <dd>
                <input type="text" name="busca_id_pedido" id="busca_id_pedido" class="ordem" value="<?= $c->busca_id_pedido ?>" placeholder="Ordem"> 
            </dd>
            <dt>Fatura:</dt>
            <dd>
                <input type="text" class="numero" id="busca_id_fatura" name="busca_id_fatura" value="<?= $c->busca_id_fatura ?>" placeholder="Fatura">
            </dd>

            
            <dt>&nbsp;</dt><dd>&nbsp;</dd>
            <dt>Ordenar:</dt> 
            <dd>
                <select name="busca_ordenar" id="busca_ordenar" class="chzn-select">
                    <option value="" <?=$c->busca_ordenar=='' ? ' selected="selected" ' : '' ?>>Ordenar</option>		
                    <option value="Ordem" <?=$c->busca_ordenar=='Ordem' ? ' selected="selected" ':'' ?>>Ordem</option>		
                    <option value="Documento de" <?=$c->busca_ordenar=='Documento de' ? ' selected="selected" ':'' ?>>Documento de</option>		
                    <option value="Devedor" <?=$c->busca_ordenar=='Devedor' ? ' selected="selected" ':'' ?>>Devedor</option>		
                    <option value="Data" <?=$c->busca_ordenar=='Data' ? ' selected="selected" ':'' ?>>Data</option>		
                    <option value="Departamento" <?=$c->busca_ordenar=='Departamento' ? ' selected="selected" ':'' ?>>Departamento</option>		
                    <option value="Serviço" <?=$c->busca_ordenar=='Serviço' ? ' selected="selected" ':'' ?>>Serviço</option>		
                    <option value="Cidade" <?=$c->busca_ordenar=='Cidade' ? ' selected="selected" ':'' ?>>Cidade</option>		
                    <option value="Prazo" <?=$c->busca_ordenar=='Prazo' ? ' selected="selected" ':'' ?>>Prazo</option>		
                    <option value="Agenda" <?=$c->busca_ordenar=='Agenda' ? ' selected="selected" ':'' ?>>Agenda</option>		
                    <option value="Data Status"	<?=$c->busca_ordenar=='Data Status' ? ' selected="selected" ':'' ?>>Data Status</option>
		</select> 
            </dd>
            <dt>&nbsp;</dt>
            <dd>
                <select name="busca_ord" id="busca_ord" class="chzn-select">
                    <option value=""<?=($c->busca_ord=='') ? ' selected="selected" ' : ''; ?>>Crescente</option>
                    <option value="Decr"<?=($c->busca_ord=='Decr') ? ' selected="selected" '  : ''; ?>>Decrescente</option>
		</select>
            </dd>    
            <dt>Selecionar Colunas:</dt>
            <div class="dd checks">
                <input type="checkbox" name="check1" id="check1" value="1" onclick="CheckAll(this.id)"><span>Selecionar Todos</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_nome" <?=($c->busca_e_nome== 1) ? 'checked' : '' ?>><span>Documento de</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_cpf"<?=($c->busca_e_cpf== 1) ? 'checked' : '' ?>><span>CPF/CNPJ</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_inicio"<?=($c->busca_e_inicio== 1) ? 'checked' : '' ?>><span>Início</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_prazo"<?=($c->busca_e_prazo== 1) ? 'checked' : '' ?>><span>Prazo</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_agenda"<?=($c->busca_e_agenda== 1) ? 'checked' : '' ?>><span>Agenda</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_data_atividade"<?=($c->busca_e_data_atividade== 1) ? 'checked' : '' ?>><span>Data do Status</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_departamento"<?=($c->busca_e_departamento== 1) ? 'checked' : '' ?>><span>Departamento</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_servico"<?=($c->busca_e_servico== 1) ? 'checked' : '' ?>><span>Serviço</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_cidade"<?=($c->busca_e_cidade== 1) ? 'checked' : '' ?>><span>Cidade</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_estado"<?=($c->busca_e_estado== 1) ? 'checked' : '' ?>><span>Estado</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_status"<?=($c->busca_e_status== 1) ? 'checked' : '' ?>><span>Status</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_atividade"<?=($c->busca_e_atividade== 1) ? 'checked' : '' ?>><span>Atividade</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_atendimento"<?=($c->busca_e_atendimento== 1) ? 'checked' : '' ?>><span>Atendimento</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_devedor"<?=($c->busca_e_devedor== 1) ? 'checked' : '' ?>><span>Devedor</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_forma"<?=($c->busca_e_forma== 1) ? 'checked' : '' ?>><span>Forma de Pagto.</span><br>
		<input value="1" class="check1" type="checkbox" name="busca_e_origem" <?=($c->busca_e_origem== 1) ? 'checked' : '' ?>><span>Origem</span>	
            </div>
            <div class="buttons">
                <input type="hidden" id="NoStatusCheck" value="recebimentos-de-pedidos.php<?=$link?>">
                <input type="hidden" id="acao_rec_pedido" name="acao_rec_pedido">
                <input type="hidden" id="hash" name="hash" value="<?=date('s')?>">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
        </dl>
        <?php if($_GET OR $_POST){?>
        <dl>
            <div class="buttons">
                <input type="hidden" id="NoStatusCheck" value="recebimentos-de-pedidos.php<?=$link?>">
                <input type="hidden" id="acao_desembolso" name="acao_rec_pedido">
                <input type="hidden" id="hash" name="hash" value="<?=date('s')?>">
                <?php if($controle_id_usuario == 1){?>
                    <input type="button" value="alterar status &rsaquo;&rsaquo;" style="width: auto"  onclick="RecPedidoConfirm(1,'status')">
                <?php } else { ?>
                    <input type="button" value="alterar status &rsaquo;&rsaquo;" style="width: auto"  onclick="alert('Esta ação ainda não esta pronta!')">
                <?php }  ?>
                <input type="button" value="aprovar &rsaquo;&rsaquo;"  onclick="RecPedidoConfirm(1,'aprovar')">
		<?php if($c->busca_id_status==2){ ?>			
                    <input type="button" value="reprovar &rsaquo;&rsaquo;" onclick="RecPedidoConfirm(1,'reprovar')">
		<?php }
		if($controle_id_empresa==1){ ?>			
                    <input type="button" value="faturar &rsaquo;&rsaquo;" onclick="<?=$controle_id_usuario == 1 ? "RecPedidoConfirm(1,'faturar')":"alert('Esta ação ainda não esta pronta!')"?>">
		<?php } ?>
                    |
		<input type="button" value="exportar &rsaquo;&rsaquo;" onclick="RecPedidoConfirm(1,'arquivo')">
		<?php if($controle_id_empresa=='1'){ ?>		
                    <input type="button" value="exportar todos &rsaquo;&rsaquo;" style="width: auto" onclick="RecPedidoConfirm(0,'arquivo_todos')">&nbsp;
		<?php } ?>
            </div>
        </dl>
        <?php } ?>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">   
<?php
if($_GET){ 
    $listar = $financeiroDAO->buscaRecebimento($c,$controle_id_empresa,$c->pagina); 
    if(count($listar) > 0){ 
        if($controle_id_empresa == 1){
            $usuarioDAO = new UsuarioDAO();
            $usuarios = $usuarioDAO->todos();
        }
        
        $total_linha = 14;     
        $arr_cp = array('busca_e_nome','busca_e_cpf','busca_e_inicio','busca_e_prazo','busca_e_agenda',
            'busca_e_data_atividade','busca_e_departamento','busca_e_servico','busca_e_cidade',
            'busca_e_estado','busca_e_status','busca_e_atividade','busca_e_atendimento','busca_e_devedor',
            'busca_e_forma','busca_e_origem');    
        $arr_nm = array('Documento de','CPF/CNPJ','Início','Prazo','Agenda','Data do Status','Departamento',
            'Serviço','Cidade','Estado','Status','Atividade','Atendimento','Devedor','Forma de Pagto.',
            'Origem');
        
        $arr_vlr = array('certidao_nome','cpf','inicio','data_prazo','data_i','data_atividade',
            'departamento','servico','certidao_cidade','certidao_estado','status',
            'atividade','atendimento','certidao_devedor','forma_pagamento','origem');
                
        for($i = 0; $i < count($arr_cp); $i++){
            $total_linha = (isset($c->$arr_cp[$i]) AND $c->$arr_cp[$i] == 1) ? $total_linha + 1 : $total_linha;
        } ?>
        <div class="paginacao">
            <?php $financeiroDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr style="background: transparent">
                    <th colspan="<?=$total_linha?>" style="background: transparent">
                        <b>Valor Total: </b> <?=$listar[0]->valor_t?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| 
                        <b>Valor Recebido:</b> <?=$listar[0]->valor_rec_t?>
                    </th>
                </tr>
                <tr>
                    <th class="buttons"><input type="checkbox" name="check2" id="check2" value="1" onclick="CheckAll(this.id);CkechSession(2,'.check2','rec_pedido')"></th>
                    <th class="buttons">#</th>
                    <th class="buttons">ordem</th>
                    <th class="buttons">fatura</th>
                    <th>solicitante</th>
                    <?php $new_arr = array();
                    if($total_linha > 14){ 
                        for($i = 0; $i < count($arr_cp); $i++){
                            if(isset($c->$arr_cp[$i]) AND $c->$arr_cp[$i] == 1){ 
                                echo '<th>'.$arr_nm[$i].'</th>'."\n";
                                $new_arr[] = $arr_vlr[$i];
                            }
                        }                        
                    } ?>
                    <th class="buttons">custas</th>
                    <th class="buttons">honorários</th>
                    <th class="buttons">correios</th>
                    <th class="buttons">valor</th>
                    <th class="buttons">recebido</th>
                    <th class="buttons">lucro</th>
                    <th class="buttons">saldo</th>
                    <th class="buttons">novo boleto</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';               
                $valor_total            = 0;	
                $financeiro_valor_total = 0;
                $financeiro_sedex_total = 0;
                $financeiro_custas_total= 0;
                $financeiro_rateio_total= 0;
                $financeiro_lucro_total = 0;
                $financeiro_saldo_total = 0;
                foreach ($listar as $l) { 
                                        
                    $valor_total      = (float)($valor_total)+(float)($l->valor);
                    $financeiro_valor_total      = (float)($financeiro_valor_total)+(float)($l->total);
                    $financeiro_sedex_total      = (float)($financeiro_sedex_total)+(float)($l->sedex);
                    $financeiro_rateio_total      = (float)($financeiro_rateio_total)+(float)($l->rateio);
                    $financeiro_custas_total      = (float)($financeiro_custas_total)+(float)($l->custas);
                    $l->lucro = (float)$l->valor-(float)$l->sedex-(float)$l->custas-(float)$l->rateio;
                    $l->saldo = (float)$l->valor-(float)$l->total;
                    if($l->saldo<0) $l->saldo=0;
                    $financeiro_saldo_total      = (float)($financeiro_saldo_total)+(float)($l->saldo);
                    
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                    <tr <?=TRColor($color)?>>
                        <td class="buttons"><input <?=((isset($_SESSION['rec_pedido']) AND count($_SESSION['rec_pedido']) > 0 AND in_array($l->id_pedido_item, $_SESSION['rec_pedido'])) ? 'checked="checked"' : '')?> type="checkbox" name="id_recebimento[]" id="id_recebimento<?=$l->id_pedido_item?>" value="<?=$l->id_pedido_item?>" class="check2" onclick="CkechSession(1,this.id,'rec_pedido')"></td>
                        <td class="buttons"><?=$l->id_pedido_item?></td>
                        <td class="buttons">#<?=$l->id_pedido . '/'.$l->ordem?></td>
                        <td class="buttons"><?=strlen($l->id_fatura AND $controle_id_empresa == 1) > 0 ? '<a href="recebimentos-de-pedidos-fatura.php?id='.$l->id_fatura.'" target="_blank">'.$l->id_fatura.'</a>' : '-'?></td>
                        <td><?=utf8_encode($l->nome)?></td>   
                        <?php if(count($new_arr) > 0){ 
                            for($i = 0; $i < count($new_arr); $i++){
                                $valor = '';
                                switch($new_arr[$i]){
                                    case 'atendimento':
                                        $valor = isset($l->$new_arr[$i]) ? utf8_encode($l->$new_arr[$i]) : '';
                                        if($controle_id_empresa == 1 AND isset($l->$new_arr[$i])){
                                            $valor = isset($usuarios[$l->id_usuario]) ? utf8_encode($usuarios[$l->id_usuario]) : '';
                                        }
                                        break;
                                    case 'cpf':
                                        $valor = isset($l->$new_arr[$i]) ? str_replace('/','',str_replace('-','',str_replace('.','',$l->$new_arr[$i]))) : '';
                                        break;
                                    case 'inicio': case 'data_prazo': case 'data_i': case 'data_atividade':
                                        $valor = isset($l->$new_arr[$i]) ? invert($l->$new_arr[$i],'/','PHP') : '';
                                        break;
                                    default:
                                        $valor = isset($l->$new_arr[$i]) ? utf8_encode($l->$new_arr[$i]) : '';
                                }
                                echo '<td>'.$valor.'</td>';
                            }                        
                        } ?>
                        <td class="buttons"><?=number_format($l->custas,2,".","")?></td>
                        <td class="buttons"><?=number_format($l->rateio,2,".","")?></td>
                        <td class="buttons"><?=number_format($l->sedex,2,".","")?></td>
                        <td class="buttons"><?=number_format($l->valor,2,".","")?></td>
                        <td class="buttons"><?=number_format($l->total,2,".","")?></td>
                        <td class="buttons"><?=number_format($l->lucro,2,".","")?></td>
                        <td class="buttons"><?=number_format($l->saldo,2,".","")?></td>
                        <td class="buttons"><?=strlen($l->id_fatura AND $controle_id_empresa == 1) > 0 ? '<a href="#" onclick="RecNovoBoleto('.$l->id_fatura.')"><img src="images/bt-relat.png"></a>':'-'?></td>
                        <td class="buttons"><a href="pedidos-editar.php?id=<?=$l->id_pedido . '&ordem='.$l->ordem?>" target="_blank"><img src="images/bt-edit.png"></a></td>
                    </tr>
                <?php } 
                $financeiro_lucro_total = (float)$valor_total-(float)$financeiro_sedex_total-(float)$financeiro_custas_total-(float)$financeiro_rateio_total;?>            </tbody>
            <tfoot>
                <tr>
                    <th colspan="<?=$total_linha-10?>">&nbsp;</th>
                    <th>Total</th>
                    <th class="buttons"><?=number_format($financeiro_custas_total,2,".","")?></th>
                    <th class="buttons"><?=number_format($financeiro_rateio_total,2,".","")?></th>
                    <th class="buttons"><?=number_format($financeiro_sedex_total,2,".","")?></th>
                    <th class="buttons"><?=number_format($valor_total,2,".","")?></th>
                    <th class="buttons"><?=number_format($financeiro_valor_total,2,".","")?></th>
                    <th class="buttons"><?=number_format($financeiro_lucro_total,2,".","")?></th>
                    <th class="buttons"><?=number_format($financeiro_saldo_total,2,".","")?></th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </tfoot>
        </table>
        <div class="paginacao">
            <?php $financeiroDAO->QTDPagina(); ?>
        </div>
        <script>PaginacaoWidth()</script>
    <?php } else { 
        RetornaVazio();
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