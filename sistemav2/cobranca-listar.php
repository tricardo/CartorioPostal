<?php include('header.php'); 

$permissao = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}


$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);

$atividadeDAO = new AtividadeDAO();
$atividadeverificaDAO = new AtividadeVerificaDAO();
$pedidoDAO = new PedidoDAO();
$usuarioDAO = new UsuarioDAO();

$usuarios = $usuarioDAO->listarAtivosDpto($controle_id_empresa, 19);

$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca = isset($c->busca) ? $c->busca : '';
$c->busca_id_fatura = isset($c->busca_id_fatura) ? $c->busca_id_fatura : '';
$c->busca_autorizacao = isset($c->busca_autorizacao) ? $c->busca_autorizacao : '';
$c->busca_id_status = isset($c->busca_id_status) ? $c->busca_id_status : '';
$c->busca_id_usuario_cb = isset($c->busca_id_usuario_cb) ? $c->busca_id_usuario_cb : '';
$c->busca_mes = isset($c->busca_mes) ? $c->busca_mes : '';
$c->busca_ano = isset($c->busca_ano) ? $c->busca_ano : '';
$c->busca_id_pedido = isset($c->busca_id_pedido) ? $c->busca_id_pedido : '';
$c->busca_ordenar = isset($c->busca_ordenar) ? $c->busca_ordenar : '';
$c->busca_ord = isset($c->busca_ord) ? $c->busca_ord : '';
$c->busca_e_nome = isset($c->busca_e_nome) ? $c->busca_e_nome : '';
$c->busca_e_cpf = isset($c->busca_e_cpf) ? $c->busca_e_cpf : '';
$c->busca_e_inicio = isset($c->busca_e_inicio) ? $c->busca_e_inicio : '';
$c->busca_e_prazo = isset($c->busca_e_prazo) ? $c->busca_e_prazo : '';
$c->busca_e_agenda = isset($c->busca_e_agenda) ? $c->busca_e_agenda : '';
$c->busca_e_data_atividade = isset($c->busca_e_data_atividade) ? $c->busca_e_data_atividade : '';
$c->busca_e_departamento = isset($c->busca_e_departamento) ? $c->busca_e_departamento : '';
$c->busca_e_servico = isset($c->busca_e_servico) ? $c->busca_e_servico : '';
$c->busca_e_cidade = isset($c->busca_e_cidade) ? $c->busca_e_cidade : '';
$c->busca_e_estado = isset($c->busca_e_estado) ? $c->busca_e_estado : '';
$c->busca_e_status = isset($c->busca_e_status) ? $c->busca_e_status : '';
$c->busca_e_atividade = isset($c->busca_e_atividade) ? $c->busca_e_atividade : '';
$c->busca_e_responsavel = isset($c->busca_e_responsavel) ? $c->busca_e_responsavel : '';
$c->busca_e_atendimento = isset($c->busca_e_atendimento) ? $c->busca_e_atendimento : '';
$c->busca_e_devedor = isset($c->busca_e_devedor) ? $c->busca_e_devedor : '';
$c->busca_e_forma = isset($c->busca_e_forma) ? $c->busca_e_forma : '';


$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca) > 0 ? '&busca='.$c->busca : '';
$link .= strlen($c->busca_id_fatura) > 0 ? '&busca_id_fatura='.$c->busca_id_fatura : '';
$link .= strlen($c->busca_autorizacao) > 0 ? '&busca_autorizacao='.$c->busca_autorizacao : '';
$link .= strlen($c->busca_id_status) > 0 ? '&busca_id_status='.$c->busca_id_status : '';
$link .= strlen($c->busca_id_usuario_cb) > 0 ? '&busca_id_usuario_cb='.$c->busca_id_usuario_cb : '';
$link .= strlen($c->busca_mes) > 0 ? '&busca_mes='.$c->busca_mes : '';
$link .= strlen($c->busca_ano) > 0 ? '&busca_ano='.$c->busca_ano : '';
$link .= strlen($c->busca_id_pedido) > 0 ? '&busca_id_pedido='.$c->busca_id_pedido : '';
$link .= strlen($c->busca_ordenar) > 0 ? '&busca_ordenar='.$c->busca_ordenar : '';
$link .= strlen($c->busca_ord) > 0 ? '&busca_ord='.$c->busca_ord : '';
$link .= strlen($c->busca_e_nome) > 0 ? '&busca_e_nome='.$c->busca_e_nome : '';
$link .= strlen($c->busca_e_cpf) > 0 ? '&busca_e_cpf='.$c->busca_e_cpf : '';
$link .= strlen($c->busca_e_inicio) > 0 ? '&busca_e_inicio='.$c->busca_e_inicio : '';
$link .= strlen($c->busca_e_prazo) > 0 ? '&busca_e_prazo='.$c->busca_e_prazo : '';
$link .= strlen($c->busca_e_agenda) > 0 ? '&busca_e_agenda='.$c->busca_e_agenda : '';
$link .= strlen($c->busca_e_data_atividade) > 0 ? '&busca_e_data_atividade='.$c->busca_e_data_atividade : '';
$link .= strlen($c->busca_e_departamento) > 0 ? '&busca_e_departamento='.$c->busca_e_departamento : '';
$link .= strlen($c->busca_e_servico) > 0 ? '&busca_e_servico='.$c->busca_e_servico : '';
$link .= strlen($c->busca_e_cidade) > 0 ? '&busca_e_cidade='.$c->busca_e_cidade : '';
$link .= strlen($c->busca_e_estado) > 0 ? '&busca_e_estado='.$c->busca_e_estado : '';
$link .= strlen($c->busca_e_status) > 0 ? '&busca_e_status='.$c->busca_e_status : '';
$link .= strlen($c->busca_e_atividade) > 0 ? '&busca_e_atividade='.$c->busca_e_atividade : '';
$link .= strlen($c->busca_e_responsavel) > 0 ? '&busca_e_responsavel='.$c->busca_e_responsavel : '';
$link .= strlen($c->busca_e_atendimento) > 0 ? '&busca_e_atendimento='.$c->busca_e_atendimento : '';
$link .= strlen($c->busca_e_devedor) > 0 ? '&busca_e_devedor='.$c->busca_e_devedor : '';
$link .= strlen($c->busca_e_forma) > 0 ? '&busca_e_forma='.$c->busca_e_forma : '';

$show_msgbox = 0; 
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
            case 'colaborador': include('cobranca-listar-colaborador.php'); break;
            case 'acompanhar': case 'notificar': case 'notificado': case 'apoio_juridico': case 'efetuado':
                include('cobranca-listar-acompanhar.php'); break;
        }  
    }
}
?>
<script>
    menu(3,'bt-04');
    $('#titulo').html('financeiro &rsaquo;&rsaquo; cobrança');
    $('#sub-52').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get" id="form1" name="form1">
        <dl>
            <legend>Buscar Cobranças</legend>
            <dt>Buscar:</dt>
            <dd class="line1">
                <input type="text" id="busca" name="busca" value="<?= $c->busca ?>" placeholder="Pesquisar">
            </dd>
            <dt>Fatura:</dt>
            <dd>
                <input type="text" class="numero" id="busca_id_fatura" name="busca_id_fatura" value="<?= $c->busca_id_fatura ?>" placeholder="Fatura">
            </dd>
            <dt>Situação:</dt>
            <dd>
                <select name="busca_autorizacao" id="busca_autorizacao" class="chzn-select">
                    <option value="À Receber" <?=($c->busca_autorizacao == '' or $c->busca_autorizacao == 'À Receber') ? 'selected="select"' : ''; ?>>À Receber</option>
                    <option value="Acompanhar" <?=($c->busca_autorizacao == 'Acompanhar') ? 'selected="select"' : ''; ?>>Acompanhar</option>
                    <option value="Notificar" <?=($c->busca_autorizacao == 'Notificar') ? 'selected="select"':''; ?>>Notificar</option>
                    <option value="Notificado" <?=($c->busca_autorizacao == 'Notificado') ? 'selected="select"':''; ?>>Notificado</option>
                    <option value="Recebido" <?=($c->busca_autorizacao == 'Recebido') ? 'selected="select"':''; ?>>Recebido</option>
                </select>
            </dd>
            <dt>Status:</dt>
            <dd>
                <select name="busca_id_status" id="busca_id_status" class="chzn-select">
                    <option value="20" <?=($c->busca_id_status == '20') ? 'selected="selected"':'' ?>>Inadimplente</option>
                    <option value="11" <?=($c->busca_id_status == '11') ? 'selected="selected"':'' ?>>Confirmação</option>
                </select> 
            </dd>
            <dt>Responsável:</dt>
            <dd>
                <select name="busca_id_usuario_cb" id="busca_id_usuario_cb" class="chzn-select">
                    <option value="_"<?=($c->busca_id_usuario_cb == '_')  ? ' selected="selected" ' : ''; ?>>Não Direcionados</option>
                    <option value=""<?=($c->busca_id_usuario_cb == '') ? ' selected="selected" ':''; ?>>Todos</option>
                    <?php $p_valor = '';
                    foreach ($usuarios as $u) {
                        $p_valor .= '<option value="' . $u->id_usuario . '"';
                        if ($c->busca_id_usuario_cb == $u->id_usuario){
                            $p_valor .= ' selected="selected" ';
                        }
                        $p_valor .= ' >' . utf8_encode($u->nome) . '</option>';
                    }
                    echo $p_valor; ?>
                </select>
            </dd>
            <dt>&nbsp;</dt><dd>&nbsp;</dd>
            <dt>Mês:</dt>
            <dd>
                <select id="busca_mes" name="busca_mes" class="chzn-select">
                    <option value="">Todos</option>
                    <?php foreach(DataAno() AS $p => $f){ ?>
                    <option value="<?=$p?>"<?=$p==$c->busca_ano ? ' selected="selected"' : ''?>><?=$f?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Ano:</dt>
            <dd>
                <select id="busca_ano" name="busca_ano" class="chzn-select">
                    <option value="">Todos</option>
                    <?php foreach(DataAno(2) AS $p => $f){ ?>
                    <option value="<?=$p?>"<?=$p==$c->busca_ano ? ' selected="selected"' : ''?>><?=$f?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Ordem:</dt> 
            <dd>
                <input type="text" name="busca_id_pedido" id="busca_id_pedido" class="ordem" value="<?= $c->busca_id_pedido ?>" placeholder="Ordem"> 
            </dd>
            <dt>&nbsp;</dt><dd>&nbsp;</dd>
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
            <dt>Selecionar Colunas:</dt>
            <div class="dd checks">
                <?php
                $colunas = array('Documento de','Devedor','Data','Departamento','Serviço','Cidade');
                ?>
                <input type="checkbox" name="check1" id="check1" value="1" onclick="CheckAll(this.id)"><span>Selecionar Todos</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_nome" <?=($c->busca_e_nome == 1) ?'checked' : '' ?>><span>Documento de</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_cpf" <?=($c->busca_e_cpf == 1) ?'checked' : '' ?>><span>CPF/CNPJ</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_inicio" <?=($c->busca_e_inicio == 1) ? 'checked' : '' ?>><span>Início</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_prazo" <?=($c->busca_e_prazo == 1) ? 'checked' : '' ?>><span>Prazo</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_agenda" <?=($c->busca_e_agenda == 1) ? 'checked' : '' ?>><span>Agenda</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_data_atividade" <?=($c->busca_e_data_atividade == 1) ?'checked' : '' ?>><span>Data do Status</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_departamento" <?=($c->busca_e_departamento == 1) ?'checked' : '' ?>><span>Departamento</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_servico" <?=($c->busca_e_servico == 1) ?'checked' : '' ?>><span>Serviço</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_cidade" <?=($c->busca_e_cidade == 1) ?'checked' : '' ?>><span>Cidade</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_estado" <?=($c->busca_e_estado == 1) ?'checked' : '' ?>><span>Estado</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_status" <?=($c->busca_e_status == 1) ?'checked' : '' ?>><span>Status</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_atividade" <?=($c->busca_e_atividade == 1) ?'checked' : '' ?>><span>Atividade</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_responsavel" <?=($c->busca_e_responsavel == 1) ?'checked' : '' ?>><span>Responsável</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_atendimento" <?=($c->busca_e_atendimento == 1) ?'checked' : '' ?>><span>Atendimento</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_devedor" <?=($c->busca_e_devedor == 1) ?'checked' : '' ?>><span>Devedor</span><br>
                <input value="1" class="check1" type="checkbox" name="busca_e_forma" <?=($c->busca_e_forma == 1) ?'checked' : '' ?>><span>Forma de Pagto.</span>
            </div>
            <div class="buttons">
                <input type="hidden" id="NoStatusCheck" value="cobranca-listar.php<?=$link?>">
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
            <div class="buttons">
                <?php if ($c->busca_autorizacao == 'À Receber') { ?>
                    <input type="button" value="acompanhar &rsaquo;&rsaquo;" onclick="CobrancaConfirm(1,'acompanhar')" style="width:auto">
                <?php } 
                if ($c->busca_id_status == '20' && $c->busca_autorizacao == 'Acompanhar') { ?>
                    <input type="button" value="notificar &rsaquo;&rsaquo;" onclick="CobrancaConfirm(1,'notificar')">
                <?php } elseif ($c->busca_autorizacao == 'Notificar') { ?>
                    <input type="button" value="notificado &rsaquo;&rsaquo;" onclick="CobrancaConfirm(1,'notificado')">
                <?php } elseif ($c->busca_autorizacao == 'Notificado') { ?>
                    <input type="button" value="apoio jurídico &rsaquo;&rsaquo;" onclick="CobrancaConfirm(1,'apoio_juridico')" style="width:auto">
                <?php } elseif ($c->busca_autorizacao == 'Recebido') { ?>
                    <input type="button" value="efetuado &rsaquo;&rsaquo;" onclick="CobrancaConfirm(1,'efetuado')">
                <?php } ?>
                | 
                <input type="button" value="colaborador &rsaquo;&rsaquo;" onclick="CobrancaConfirm(1,'colaborador')" style="width:auto">
            </div>
        </dl>
        <?php } ?>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">   
<?php
if($_GET){ 
    $pedidos = $pedidoDAO->cobranca_listar($c);
    if(count($pedidos) > 0){ 
        ?>
        <div class="paginacao">
            <?php $pedidoDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons"><input type="checkbox" name="check2" id="check2" value="1" onclick="CheckAll(this.id);CkechSession(2,'.check2','cobranca')"></th>
                    <th class="buttons">ordem</th>	
                    <th>solicitante</th>	
                    <th class="buttons">fatura</th>
                    <?php $p_valor = '';
                    $cols = 4;
                    if ($c->busca_e_cpf == 1){
                        $p_valor .= '<th class="buttons">CNPJ/CPF</th>';$cols++;
                    }
                    if ($c->busca_e_nome == 1){
                        $p_valor .= '<th>Documento de</th>';$cols++;
                    }
                    if ($c->busca_e_devedor == 1){
                        $p_valor .= '<th>Devedor</th>';$cols++;
                    }
                    if ($c->busca_e_inicio == 1){
                        $p_valor .= '<th class="buttons">Início</th>';$cols++;
                    }
                    if ($c->busca_e_prazo == 1){
                        $p_valor .= '<th class="buttons">Prazo</th>';$cols++;
                    }
                    if ($c->busca_e_agenda == 1){
                        $p_valor .= '<th class="buttons">Agenda</th>';$cols++;
                    }
                    if ($c->busca_e_data_atividade == 1){
                        $p_valor .= '<th>Data Status</th>';$cols++;
                    }
                    if ($c->busca_e_forma == 1){
                        $p_valor .= '<th>Forma</th>';$cols++;
                    }
                    echo $p_valor; ?>
                    <th class="buttons">agenda</th>	
                    <th class="buttons">valor</th>	
                    <th class="buttons">recebido</th>	
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                $valor_total = 0;
                $financeiro_valor_total = 0;
                foreach($pedidos as $p){ 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; 
                    $id_pedido_item = $p->id_pedido_item;
                    $atendente = isset($p->atendente) ? $p->atendente : '';
                    $id_usuario_op = $p->id_usuario_op;
                    $departamento = isset($p->departamento) ? $p->departamento : '';
                    $data_prazo = ($p->data_prazo != '0000-00-00') ? invert($p->data_prazo, '/', 'PHP') : '';
                    $data_agenda = ($p->data_i != '0000-00-00') ? date("d/m/Y", strtotime(somar_dias_uteis($p->data_i, $p->dias))) : '';
                    $valor = $p->valor;
                    $financeiro_valor = $p->total;
                    $responsavel = isset($p->nome_resp) ? $p->nome_resp : '';
                    $valor = number_format($valor, 2, ".", "");
                    $financeiro_valor = number_format($financeiro_valor, 2, ".", "");
                    $valor_total = (float) ($valor_total) + (float) ($valor);
                    $financeiro_valor_total = (float) ($financeiro_valor_total) + (float) ($financeiro_valor);
                    $valor = 'R$ ' . $valor;
                    $financeiro_valor_num = $financeiro_valor;
                    $financeiro_valor = 'R$ ' . $financeiro_valor;   ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><input <?=((isset($_SESSION['cobranca']) AND count($_SESSION['cobranca']) > 0 AND in_array($p->id_pedido_item.';'.$p->id_pedido.';'.$p->ordem, $_SESSION['cobranca'])) ? 'checked="checked"' : '')?> type="checkbox" name="id_cobranca[]" id="id_cobranca<?=$p->id_pedido_item?>" value="<?=$p->id_pedido_item.';'.$p->id_pedido.';'.$p->ordem?>" class="check2" onclick="CkechSession(1,this.id,'cobranca')"></td>
                    <td>#<?=$p->id_pedido . '/' . $p->ordem?></td>
                    <td><?=utf8_encode(ucwords(strtolower($p->nome)))?></td>
                    <td class="buttons"><?=$p->id_fatura <> 0 ? '<a href="cobranca-listar-fatura.php?id_fatura='.$p->id_fatura.'" target="_blank">'.$p->id_fatura.'</a>' : ''?></td>
                     <?php $p_valor = '';
                    if ($c->busca_e_cpf == 1)
                        $p_valor .= '<td class="buttons">'.str_replace('/', '', str_replace('-', '', str_replace('.', '', $p->cpf))).'</td>';
                    if ($c->busca_e_nome == 1)
                        $p_valor .= '<td>'.utf8_encode(ucwords(strtolower($p->certidao_nome))).'</td>';
                    if ($c->busca_e_devedor == 1)
                        $p_valor .= '<td>'.utf8_encode(ucwords(strtolower($p->certidao_devedor))).'</td>';
                    if ($c->busca_e_inicio == 1)
                        $p_valor .= '<td class="buttons">'.($p->inicio != '0000-00-00 00:00:00' ? invert($p->inicio, '/', 'PHP') : '').'</td>';
                    if ($c->busca_e_prazo == 1)
                        $p_valor .= '<td class="buttons">'.$data_prazo.'</td>';
                    if ($c->busca_e_agenda == 1)
                        $p_valor .= '<td class="buttons">'.$data_agenda.'</td>';
                    if ($c->busca_e_data_atividade == 1)
                        $p_valor .= '<td>'.invert($p->data_atividade, '/', 'PHP').'</td>';
                    if ($c->busca_e_forma == 1)
                        $p_valor .= '<td>'.(isset($p->forma_pagamento) ? $p->forma_pagamento :'').'</td>';
                    echo $p_valor; ?>
                    <td class="buttons"><?=($p->data_i != '0000-00-00') ? invert($p->data_i, '/', 'PHP') . '-' . $p->status_hora : ''?></td>
                    <td class="buttons"><?=$valor?></td>
                    <td class="buttons"><?=$financeiro_valor?></td>
                    <td class="buttons"><a href="pedidos-editar.php?id=<?=$p->id_pedido . '&ordem='.$p->ordem?>" target="_blank"><img src="images/bt-edit.png"></a></td>
               </tr>
                <?php } 
                $valor_total = 'R$ ' . number_format($valor_total, 2, ".", ",");
                $financeiro_valor_total = 'R$ ' . number_format($financeiro_valor_total, 2, ".", ",");?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="<?=$cols?>">&nbsp;</th>
                    <th>Total</th>
                    <th class="buttons"><?=$valor_total?></th>
                    <th class="buttons"><?=$financeiro_valor_total?></th>
                    <th>&nbsp;</th>
                </tr>
            </tfoot>
            
        </table>
        <div class="paginacao">
            <?php $pedidoDAO->QTDPagina(); ?>
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
