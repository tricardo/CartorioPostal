<?php include('header.php'); 

$permissao = verifica_permissao('Direcionamento',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}
require('includes/dias_uteis.php');
$pedidoDAO = new PedidoDAO();
$atividadeDAO = new AtividadeDAO();
$statusDAO = new StatusDAO();
$servicoDAO = new ServicoDAO();
$usuarioDAO = new UsuarioDAO();
$empresaDAO = new EmpresaDAO();
$financeiroDAO = new FinanceiroDAO();
$empresaDAO = new EmpresaDAO();
$atividadeverificaDAO = new AtividadeVerificaDAO();

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);
$show_msgbox = 0;

$exibe = 0;
$inc_status_obs = '';
if(isset($_SESSION['monitoramento_id_empresa']) AND $_SESSION['monitoramento_id_empresa'] == 1){
    $exibe = 1;
    $inc_status_obs = "[".$_SESSION['monitoramento_nome']."] - ";
} elseif($controle_id_empresa == 1){
    $exibe = 1;
    $inc_status_obs = "[".$controle_id_usuario.' : '.$controle_nome."] - ";
}

$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca_id_status = isset($c->busca_id_status) ? $c->busca_id_status : '';
$c->busca_id_servico = isset($c->busca_id_servico) ? $c->busca_id_servico : '';
$c->busca_data_i = isset($c->busca_data_i) ? $c->busca_data_i : date('d/m/').(date('Y')-1);
$c->busca_data_f = isset($c->busca_data_f) ? $c->busca_data_f : date('d/m/Y');
$c->busca_id_usuario_op = isset($c->busca_id_usuario_op) ? $c->busca_id_usuario_op : '';
$c->busca_ordem = isset($c->busca_ordem) ? $c->busca_ordem : '';
$c->busca_ordenar = isset($c->busca_ordenar) ? $c->busca_ordenar : '';
$c->busca_ord = isset($c->busca_ord) ? $c->busca_ord : '';
$c->busca_jadirecionados = isset($c->busca_jadirecionados) ? $c->busca_jadirecionados : '';
$c->estado_dir = isset($c->estado_dir) ? $c->estado_dir : array();
$c->busca_e_inicio = isset($c->busca_e_inicio) ? $c->busca_e_inicio : '';
$c->busca_e_prazo = isset($c->busca_e_prazo) ? $c->busca_e_prazo : '';
$c->busca_e_data_atividade = isset($c->busca_e_data_atividade) ? $c->busca_e_data_atividade : '';
$c->busca_e_servico = isset($c->busca_e_servico) ? $c->busca_e_servico : '';
$c->busca_e_cidade = isset($c->busca_e_cidade) ? $c->busca_e_cidade : '';
$c->busca_e_estado = isset($c->busca_e_estado) ? $c->busca_e_estado : '';
$c->busca_e_status = isset($c->busca_e_status) ? $c->busca_e_status : '';
$c->busca_e_atividade = isset($c->busca_e_atividade) ? $c->busca_e_atividade : '';
$c->busca_e_responsavel = isset($c->busca_e_responsavel) ? $c->busca_e_responsavel : '';
$c->busca_e_atendimento = isset($c->busca_e_atendimento) ? $c->busca_e_atendimento : '';
$c->busca_e_devedor = isset($c->busca_e_devedor) ? $c->busca_e_devedor : '';
$c->id_usuario = isset($c->id_usuario) ? $c->id_usuario : '';
$c->id_empresa_resp = isset($c->id_empresa_resp) ? $c->id_empresa_resp : '';
$c->busca_departamentos = explode(',',$controle_id_departamento_s);

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca_id_status) AND strlen($c->busca_id_status) > 0) ? '&busca_id_status='.$c->busca_id_status : '';
$link .= (isset($c->busca_id_servico) AND strlen($c->busca_id_servico) > 0) ? '&busca_id_servico='.$c->busca_id_servico : '';
$link .= (isset($c->busca_data_i) AND strlen($c->busca_data_i) > 0) ? '&busca_data_i='.$c->busca_data_i : '';
$link .= (isset($c->busca_data_f) AND strlen($c->busca_data_f) > 0) ? '&busca_data_f='.$c->busca_data_f : '';
$link .= (isset($c->busca_id_usuario_op) AND strlen($c->busca_id_usuario_op) > 0) ? '&busca_id_usuario_op='.$c->busca_id_usuario_op : '';
$link .= (isset($c->busca_ordem) AND strlen($c->busca_ordem) > 0) ? '&busca_ordem='.$c->busca_ordem : '';
$link .= (isset($c->busca_ordenar) AND strlen($c->busca_ordenar) > 0) ? '&busca_ordenar='.$c->busca_ordenar : '';
$link .= (isset($c->busca_ord) AND strlen($c->busca_ord) > 0) ? '&busca_ord='.$c->busca_ord : '';
$link .= (isset($c->busca_jadirecionados) AND strlen($c->busca_jadirecionados) > 0) ? '&busca_jadirecionados='.$c->busca_jadirecionados : '';
$link .= (isset($c->busca_e_inicio) AND strlen($c->busca_e_inicio) > 0) ? '&busca_e_inicio='.$c->busca_e_inicio : '';
$link .= (isset($c->busca_e_prazo) AND strlen($c->busca_e_prazo) > 0) ? '&busca_e_prazo='.$c->busca_e_prazo : '';
$link .= (isset($c->busca_e_data_atividade) AND strlen($c->busca_e_data_atividade) > 0) ? '&busca_e_data_atividade='.$c->busca_e_data_atividade : '';
$link .= (isset($c->busca_e_servico) AND strlen($c->busca_e_servico) > 0) ? '&busca_e_servico='.$c->busca_e_servico : '';
$link .= (isset($c->busca_e_cidade) AND strlen($c->busca_e_cidade) > 0) ? '&busca_e_cidade='.$c->busca_e_cidade : '';
$link .= (isset($c->busca_e_estado) AND strlen($c->busca_e_estado) > 0) ? '&busca_e_estado='.$c->busca_e_estado : '';
$link .= (isset($c->busca_e_status) AND strlen($c->busca_e_status) > 0) ? '&busca_e_status='.$c->busca_e_status : '';
$link .= (isset($c->busca_e_atividade) AND strlen($c->busca_e_atividade) > 0) ? '&busca_e_atividade='.$c->busca_e_atividade : '';
$link .= (isset($c->busca_e_responsavel) AND strlen($c->busca_e_responsavel) > 0) ? '&busca_e_responsavel='.$c->busca_e_responsavel : '';
$link .= (isset($c->busca_e_atendimento) AND strlen($c->busca_e_atendimento) > 0) ? '&busca_e_atendimento='.$c->busca_e_atendimento : '';
$link .= (isset($c->busca_e_devedor) AND strlen($c->busca_e_devedor) > 0) ? '&busca_e_devedor='.$c->busca_e_devedor : '';
$link .= (isset($c->estado_dir) AND count($c->estado_dir) > 0) ? '&estado_dir='.implode(',',$c->estado_dir) : '';

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
            case 'colaborador': include('direcionamento-listar-colaborador.php'); break;
            case 'unidade': include('direcionamento-listar-unidade.php'); break;
            case 'alterar_senha': include('direcionamento-listar-alterar-senha.php'); break;
        }  
    }
} ?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; direcionamento');
    $('#sub-16').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get" id="form1" name="form1">       
        <dl>
            <legend>Buscar Ordens</legend>
            <dt>Status:</dt> 
            <dd>
                <select name="busca_id_status" id="busca_id_status" class="chzn-select">
                    <option value="Todos">Todos</option>
                    <?php $p_valor = '';
                    foreach($statusDAO->listarDirecionamento() as $s){
                        $p_valor .= '<option value="'.$s->id_status.'"';
                        if($c->busca_id_status==$s->id_status) $p_valor .=  ' selected="selected" ';
                        $p_valor .=  ' >'.utf8_encode($s->status).'</option>';
                    }
                    echo $p_valor; ?>
		</select> 
            </dd>    
            <dt>Servico:</dt>
            <dd>
                <select name="busca_id_servico" id="busca_id_servico" class="chzn-select">
                    <option value="">Todos</option>
                    <?php $p_valor = '';
                    foreach($servicoDAO->lista() as $s){
                        $p_valor .= '<option value="'.$s->id_servico.'"';
                        if($c->busca_id_servico==$s->id_servico) $p_valor .= ' selected="selected" ';
                        $p_valor .= ' >'.utf8_encode($s->descricao).'</option>';
                    }
                    echo $p_valor; ?>
		</select>
            </dd>
            <dt>Entre:</dt>
            <dd>
                <input value="<?=$c->busca_data_i?>" type="text" name="busca_data_i" id="busca_data_i" class="data" placeholder="Data Inicio"> 
            </dd>
            <dt>E:</dt>
            <dd>
                <input value="<?=$c->busca_data_f?>" type="text" name="busca_data_f" id="busca_data_f" class="data" placeholder="Data Fim"> 
            </dd>    
            <dt>Responsável:</dt> 
            <dd>
                <select name="busca_id_usuario_op" id="busca_id_usuario_op" class="chzn-select">
                    <option value="Todos"<?=($c->busca_id_usuario_op=='') ? ' selected="selected" ' : ''; ?>>Todos</option>
                    <?php $p_valor = '';                    
                    foreach($usuarioDAO->listarAtivos($controle_id_empresa) as $us){
                        $p_valor .= '<option value="'.$us->id_usuario.'"';
                        if($c->busca_id_usuario_op==$us->id_usuario) $p_valor.= ' selected="selected" ';
                        $p_valor.=  ' >'.utf8_encode($us->nome).'</option>';
                    }
                    echo $p_valor; ?>
		</select> 
            </dd>
            <dt>Ordem:</dt> 
            <dd>
                <input type="text" class="ordem" name="busca_ordem" id="busca_ordem" value="<?= $c->busca_ordem ?>" placeholder="Ordem"> 
            </dd>
            <dt>Ordenar:</dt> 
            <dd>
                <select name="busca_ordenar" id="busca_ordenar" class="chzn-select">
                    <option value=""<?=($c->busca_ordenar=='') ? ' selected="selected" ' : ''; ?>>Ordenar</option>
                    <option value="Ordem"<?=($c->busca_ordenar=='Ordem')  ? ' selected="selected" ' : '';?>>Ordem</option>
                    <option value="Documento de"<?=($c->busca_ordenar=='Documento de')  ? ' selected="selected" ' : ''; ?>>Documento de</option>
                    <option value="Data"<?=($c->busca_ordenar=='Data')  ? ' selected="selected" ' : '';?>>Data</option>
                    <option value="Departamento"<?=($c->busca_ordenar=='Departamento')  ? ' selected="selected" ' : ''; ?>>Departamento</option>
                    <option value="Serviço"<?=($c->busca_ordenar=='Serviço')  ? ' selected="selected" ' : ''; ?>>Serviço</option>
                    <option value="Cidade"<?=($c->busca_ordenar=='Cidade')  ? ' selected="selected" ' : '';?>>Cidade</option>
                    <option value="Estado"<?=($c->busca_ordenar=='Estado') ? ' selected="selected" ' : '';?>>Estado</option>
                    <option value="Prazo"<?=($c->busca_ordenar=='Prazo')  ? ' selected="selected" ' : ''; ?>>Prazo</option>
                    <option value="Agenda"<?=($c->busca_ordenar=='Agenda')  ? ' selected="selected" ' : '';?>>Agenda</option>
                    <option value="Data Atividade"<?=($c->busca_ordenar=='Data Atividade')  ? ' selected="selected" ' : ''; ?>>Data Atividade</option>
		</select> 
            </dd>
            <dt>&nbsp;</dt>
            <dd>
                <select name="busca_ord" id="busca_ord" class="chzn-select">
                    <option value=""<?=($c->busca_ord=='') ? ' selected="selected" ' : ''; ?>>Crescente</option>
                    <option value="Decr"<?=($c->busca_ord=='Decr') ? ' selected="selected" '  : ''; ?>>Decrescente</option>
		</select>
            </dd>    
            <dt>Já Direcionado?</dt>   
            <dd class="checks">
                <input type="checkbox"  name="busca_jadirecionados" id="busca_jadirecionados" <?=($c->busca_jadirecionados=='on') ? ' checked="checked"' : ''; ?>>
                <span>Sim</span>
            </dd>  
            <dt>&nbsp;</dt>
            <dd>&nbsp;</dd>
            <dt>Selecionar Colunas:</dt>
            <div class="dd checks">
                <input type="checkbox" name="check1" id="check1" value="1" onclick="CheckAll(this.id)"><span>Selecionar Todos</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_inicio" id="busca_e_inicio" <?=($c->busca_e_inicio!='') ? 'checked="checked"' : '' ?>><span>Início</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_prazo" id="busca_e_prazo" <?=($c->busca_e_prazo!='') ? 'checked="checked"' : '' ?>><span>Prazo</span><br> 
                <input value="1" class="check1" type="checkbox" name="busca_e_data_atividade" id="busca_e_data_atividade" <?=($c->busca_e_data_atividade!='') ? 'checked="checked"' : '' ?>><span>Data Status</span><br> 
                <input value="1" class="check1" type="checkbox" name="busca_e_servico" id="busca_e_servico" <?=($c->busca_e_servico!='') ? 'checked="checked"' : '' ?>><span>Serviço</span><br> 
                <input value="1" class="check1" type="checkbox" name="busca_e_cidade" id="busca_e_cidade" <?=($c->busca_e_cidade!='') ? 'checked="checked"' : '' ?>><span>Cidade</span><br> 
                <input value="1" class="check1" type="checkbox" name="busca_e_estado" id="busca_e_estado" <?=($c->busca_e_estado!='') ? 'checked="checked"' : '' ?>><span>Estado</span><br> 
                <input value="1" class="check1" type="checkbox" name="busca_e_status" id="busca_e_status" <?=($c->busca_e_status!='') ? 'checked="checked"' : '' ?>><span>Status</span><br> 
                <input value="1" class="check1" type="checkbox" name="busca_e_atividade" id="busca_e_atividade" <?=($c->busca_e_atividade!='') ? 'checked="checked"' : '' ?>><span>Atividade</span><br> 
                <input value="1" class="check1" type="checkbox" name="busca_e_responsavel" id="busca_e_responsavel" <?=($c->busca_e_responsavel!='') ? 'checked="checked"' : '' ?>><span>Responsável</span><br> 
                <input value="1" class="check1" type="checkbox" name="busca_e_atendimento" id="busca_e_atendimento" <?=($c->busca_e_atendimento!='') ? 'checked="checked"' : '' ?>><span>Atendimento</span><br> 
                <input value="1" class="check1" type="checkbox" name="busca_e_devedor" id="busca_e_devedor" <?=($c->busca_e_devedor!='') ? 'checked="checked"' : '' ?>><span>Devedor</span>
            </div>
            <dt>Selecionar Estados:</dt>
            <div class="dd checks">
                <input type="checkbox" name="check2" id="check2" value="1" onclick="CheckAll(this.id)"><span>Selecionar Todos</span><br>
                <?php foreach(UFs(0) AS $e){ ?>
                <input value="<?=$e?>" class="check2" type="checkbox" name="estado_dir[]" id="estado_dir<?=$e?>" <?=(in_array($e, $c->estado_dir)) ? 'checked="checked"' : '' ?>><span><?=$e?></span><br>
                <?php } ?>
            </div>
            
            
            <div class="buttons">
                <input type="hidden" id="NoStatusCheck" value="direcionamento-listar.php<?=$link?>">
                <input type="hidden" id="acao_direcionamento" name="acao_direcionamento">
                <input type="hidden" id="hash" name="hash" value="<?=date('s')?>">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
           
        </dl>
        <?php if($_GET OR $_POST){?>
        <dl>
            <dt>Direcionar:</dt>
            <dd>
                <select name="id_usuario" id="id_usuario" class="chzn-select">
                    <option value="">Colaborador</option>
                    <?php $p_valor='';
                    foreach($usuarioDAO->listarAtivos($controle_id_empresa) as $u){
                        $departamento_p = explode(',',$u->departamento_p);
                        foreach($departamento_p as $dep){
                            if(in_array($dep,$departamento_s) and $dep<>''){
                                $p_valor .= '<option value="'.$u->id_usuario.'"';
                                if($c->id_usuario==$u->id_usuario) $p_valor .= ' selected="selected" ';
                                $p_valor .= ' >'.utf8_encode($u->nome).'</option>';
                                break;
                            }
                        }
                    }
                    echo $p_valor; ?>
		</select>
            </dd>
            <?php if($exibe == 1){ ?>
                <dt>Direcionar:</dt>
                <dd>
                    <select name="id_empresa_resp" id="id_empresa_resp" class="chzn-select">
			<option value="">Unidade</option>
			<?php $p_valor='';
			foreach($empresaDAO->listarDiff($controle_id_empresa) as $emp){
                            $p_valor .= '<option value="'.$emp->id_empresa.'"';
                            if($c->id_empresa_resp==$emp->id_empresa) $p_valor .= ' selected="selected" ';
                            $p_valor .= ' >'.utf8_encode($emp->fantasia).'</option>';
			}
			echo $p_valor; ?>
                    </select>
                </dd>
            <?php } ?>
            <div class="buttons">
                <input type="button" value="alterar status &rsaquo;&rsaquo;" onclick="DirecionamentoConfirm(1,'alterar_status')" style="width:auto">
                <input type="button" value="exportar &rsaquo;&rsaquo;" onclick="LocationTargetAcao('exportar','form1','direcionamento-listar-exportar.php','acao_direcionamento')">
                <?php if($controle_id_empresa == 1){?>
                    <input type="button" value="exportar todos &rsaquo;&rsaquo;" onclick="LocationTargetAcao('exportar_todos','form1','direcionamento-listar-exportar-todos.php','acao_direcionamento')" style="width:auto">
                <?php } ?>
                | 
                <input type="button" value="colaborador &rsaquo;&rsaquo;" onclick="DirecionamentoConfirm(1,'colaborador')" style="width:auto">
                <?php if($exibe == 1){ ?>
                    <input type="button" value="unidade &rsaquo;&rsaquo;" onclick="DirecionamentoConfirm(1,'unidade');">
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
    $busca = $c;
    $pedidos = $pedidoDAO->buscaDirecionamento($busca,$c->pagina);
    if(count($pedidos) > 0){ ?>
        <div class="paginacao">
            <?php $pedidoDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons"><input type="checkbox" name="check3" id="check3" value="1" onclick="CheckAll(this.id);CkechSession(2,'.check1','direcionamento')"></th>
                    <th class="buttons">ordem</th>
                    <th>documento</th>
                    <?php
                    if($c->busca_e_devedor!='')        echo '<th>Devedor</th>';
                    if($c->busca_e_inicio!='')         echo '<th class="buttons">Início</th>';
                    if($c->busca_e_prazo!='')          echo '<th class="buttons">Prazo</th>';
                    if($c->busca_e_data_atividade!='') echo '<th class="buttons">Data Status</th>';
                    if($c->busca_e_status!='') 	    echo '<th>Status</th>';
                    if($c->busca_e_atividade!='') 	    echo '<th>Atividade</th>';
                    if($c->busca_e_servico!='') 	    echo '<th>Serviço</th>';
                    if($c->busca_e_cidade!='')         echo '<th>Cidade</th>';
                    if($c->busca_e_estado!='') 	    echo '<th class="buttons">UF</th>';
                    if($c->busca_e_responsavel!='')    echo '<th>Responsável</th>';
                    if($c->busca_e_atendimento!='')    echo '<th>Atendimento</th>';
                    ?>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                 <?php $color = '#FFFEEE';
                foreach($pedidos as $p){ 
                    $empresa_resp = "";
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; 
                    if($p->empresa_resp<>'' and $p->id_empresa_resp==$controle_id_empresa){ 
                        $color = '#DDDDFF'; 
                    }
                    if($p->empresa_resp<>''){ $empresa_resp	= ' - '.$p->empresa_resp; }
                    $atendente   = $p->atendente;
                    $id_atividade = $p->id_atividade;
                    $data_atividade = $p->data_atividade;
                    $responsavel = $p->responsavel;
                    $id_departamento_resp = $p->id_departamento_resp;
                    
                    ?>
                     <tr <?=TRColor($color)?>>
                        <td class="buttons"><input <?=((isset($_SESSION['direcionamento']) AND count($_SESSION['direcionamento']) > 0 AND in_array($p->id_pedido_item.';'.$p->id_pedido.';'.$p->ordem, $_SESSION['direcionamento'])) ? 'checked="checked"' : '')?> type="checkbox" name="id_direcionamento[]" id="id_direcionamento<?=$p->id_pedido_item?>" value="<?=$p->id_pedido_item.';'.$p->id_pedido.';'.$p->ordem?>" class="check3" onclick="CkechSession(1,this.id,'direcionamento')"></td>
                        <td class="buttons"><?='#' . $p->id_pedido . '/'.$p->ordem?></td>
                        <td><?=utf8_encode(ucwords(strtolower($p->certidao_nome.$p->certidao_nome_proprietario)))?></td>
                        <?php
                        if($c->busca_e_devedor!='')        echo '<td>'.utf8_encode(ucwords(strtolower($p->certidao_devedor))).'</td>';
                        if($c->busca_e_inicio!='')         echo '<td class="buttons">'.utf8_encode(ucwords(strtolower(invert($p->inicio,'/','PHP')))).'</td>';
                        if($c->busca_e_prazo!='')          echo '<td class="buttons">'.utf8_encode(ucwords(strtolower(invert($p->data_prazo,'/','PHP')))).'</td>';
                        if($c->busca_e_data_atividade!='') echo '<td class="buttons">'.utf8_encode(ucwords(strtolower(invert($p->data_atividade,'/','PHP')))).'</td>';
                        if($c->busca_e_status!='') 	   echo '<td>'.utf8_encode(ucwords(strtolower($p->status))).'</td>';
                        if($c->busca_e_atividade!='') 	    echo '<td>'.utf8_encode(ucwords(strtolower($p->atividade))).'</td>';
                        if($c->busca_e_servico!='') 	    echo '<td>'.utf8_encode(ucwords(strtolower($p->desc_servico))).'</td>';
                        if($c->busca_e_cidade!='')         echo '<td>'.utf8_encode(ucwords(strtolower($p->certidao_cidade))).'</td>';
                        if($c->busca_e_estado!='') 	    echo '<td class="buttons">'.$p->certidao_estado.'</td>';
                        if($c->busca_e_responsavel!='')    echo '<td>'.utf8_encode(ucwords(strtolower($responsavel /*.$p->empresa_dir*/))).'</td>';
                        if($c->busca_e_atendimento!='')    echo '<td>'.utf8_encode(ucwords(strtolower($atendente .$p->empresa_resp))).'</td>';
                        ?>
                        <td class="buttons"><a href="pedidos-editar.php?id=<?=$p->id_pedido . '&ordem='.$p->ordem?>" target="_blank"><img src="images/bt-edit.png"></a></td>
                    </tr>
                <?php } ?>
            </tbody>    
        </table>
        <div class="paginacao">
            <?php $pedidoDAO->QTDPagina(); ?>
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
    echo "<script>CkechSession(3,'.check3','zera_sessao')</script>";
} ?>
</div>
<?php include('footer.php'); ?>