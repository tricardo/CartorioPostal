<?php
$arr = array('id_usuario_com','conveniado','restricao','status',
    'retem_iss','nome','email','cpf','rg','im','id_pacote','tel','ramal',
    'tel2','ramal2','fax','site','endereco','numero','complemento','bairro',
    'cep','cidade','estado','data_ultimo_contato','data_aniversario','outros',
    'data_contrato_i','data_contrato_f');

if($_POST AND isset($_POST['f_cadastro'])){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }

    $arr1 = array('nome','email','tel','cep','endereco','numero','cidade','bairro','estado');
    for($i = 0; $i < count($arr1); $i++){
        if($$arr1[$i] == ""){
            $errors++;
            $campos.= $arr1[$i].';';
            $msgbox.= "preencha este campo!;";
        }
    }
    
    if (!validaTel($tel) AND $errors == 0) {
        $errors++;
        $campos.='tel;';
        $msgbox.= "O telefone é inválido!;";
    }
    
    if($errors == 0){
        if(strlen($cpf) == 14) {
            $valida = validaCPF($cpf);
            if ($valida == 'false') {
               $errors++;
               $campos.='cpf;';
               $msgbox.="CPF Inválido, digite corretamente!;";
            }
        } else {
            $valida = validaCNPJ($cpf);
            if ($valida == 'false') {
               $errors++;
               $campos.='cpf;';
               $msgbox.="CNPJ Inválido, digite corretamente!;";
            }
        }
    }
    
    if($errors == 0){
        $ci->tipo = strlen($cpf) == 14 ? 'cpf' : 'cnpj';
        $ci->restricao = isset($c->restricao) ? 'on' : ''; 
        $ci->retem_iss = isset($c->retem_iss) ? 'on' : ''; 
        $ci->conveniado= isset($c->conveniado) ? $c->conveniado[0] : 'Não';
        $ci->pacote    = isset($c->conveniado) ? ($c->conveniado == '' ? 0 : $c->conveniado) : 0;
        $ci->id_usuario= $controle_id_usuario;
        $ci = UTF_Encodes($ci, 2);
        if($id_cliente > 0){
            $ci->id_cliente= $id_cliente;
            $clienteDAO->atualizar($ci);
            
            $b = new stdClass();
            $b->data_aniversario = isset($data_aniversario) ? verifica_invert_data($data_aniversario,1) : '0000-00-00';
            $b->ultimo_contato = isset($data_ultimo_contato) ? verifica_invert_data($data_ultimo_contato, 1) : '0000-00-00';
            $b->data_contrato_i = isset($data_contrato_i) ? verifica_invert_data($data_contrato_i, 1) : '0000-00-00';
            $b->data_contrato_f = isset($data_contrato_f) ? verifica_invert_data($data_contrato_f, 1) : '0000-00-00';
            $b->id_cliente= $id_cliente;
            $e = $clienteDAO->buscaClienteCRM($id_cliente);
            if (count($e) > 0) {
                $crm = $clienteDAO->alteraClienteCRM($b);
            } else {
                $crm = $clienteDAO->insereClienteCRM($b);
            }
            $msgbox .= MsgBox();
        } else {
            $clienteDAO->inserir($ci);
            $msgbox .= MsgBox(2);
        }
        
    }
}
if($errors == 0){
if($id_cliente > 0){
    $ci = UTF_Encodes($clienteDAO->selectPorId($id_cliente));
} else {
    if($errors == 0){
        $ci = CriarVar($arr); 
    }
}}
?>
<form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>&opcoes_form=1">
    <h3>informações do cliente</h3>
    <dl>
        <dt>Prospectado:</dt>
        <dd class="line1">
            <select name="id_usuario_com" id="id_usuario_com" class="chzn-select line1">
                <option value="">Colaboradores</option>
                <?php
                $funcionarios = $usuarioDAO->listarPorDepartamentoEmpresa($controle_id_empresa, 14);
                $p_valor = '';
                foreach ($funcionarios as $f) {
                    $p_valor.='<option value="' . $f->id_usuario . '"';
                    if ($ci->id_usuario_com == $f->id_usuario)
                        $p_valor.=' selected="select" ';
                    $p_valor.='>' . utf8_encode($f->nome) . '</option>';
                }
                echo $p_valor;
                ?>
            </select>
        </dd>
        <dt>Conveniado:</dt>
        <dd class="checks">
            <input type="radio" name="conveniado[]" id="conveniado_s" value="Sim" <?=$ci->conveniado == 'Sim' ? 'checked="checked"' : '' ?>>
            <span>Sim</span>
            <input type="radio" name="conveniado[]" id="conveniado_n" value="Não" <?=($ci->conveniado != 'Sim') ? 'checked="checked"' : ''; ?>>
            <span>Não</span>
        </dd>
        <dt>Restrição?</dt>
        <dd class="checks">
            <input type="checkbox" <?=$ci->restricao == 'on' ? 'checked="checked"' : ''; ?> name="restricao" id="restricao">
            <span>Sim</span>
        </dd>
        <dt>Status:</dt>
        <dd>
            <select name="status" id="status" class="chzn-select">
                <?php $stt = TiposDeStatus(5);
                foreach($stt AS $st){ ?>
                    <option value="<?=$st['id']?>" <?=($ci->status==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                <?php } ?>
            </select>
        </dd>
        <dt>Retem ISS?</dt>
        <dd class="checks">
            <input type="checkbox" <?=$ci->retem_iss == 'on' ? 'checked="checked"' : ''; ?> name="retem_iss" id="retem_iss">
            <span>Sim</span>
        </dd>
        
        <dt>Nome <span>*</span>:</dt>
        <dd class="line1">
            <input type="text" name="nome" id="nome" class="required" value="<?= ($ci->nome) ?>" required placeholder="Nome">
        </dd>
        <dt>E-mail <span>*</span>:</dt>
        <dd class="line1"> 
            <input type="text" name="email" id="email" class="email required" value="<?= utf8_decode($ci->email) ?>" <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?> required placeholder="E-mail">
        </dd>
        <dt>CPF/CNPJ <span>*</span>:</dt>
        <dd>
            <input type="text" name="cpf" id="cpf" class="cpf required" value="<?= $ci->cpf ?>" required placeholder="CPF/CNPJ">
        </dd>
        <dt>RG/IE:</dt>
        <dd>
            <input type="text" name="rg" id="rg" value="<?= $ci->rg ?>" placeholder="RG/IE">
        </dd>
        <dt>IM:</dt>
        <dd>
            <input type="text" name="im" id="im" value="<?= $ci->im ?>" placeholder="IM">
        </dd>
        <dt>Pacote:</dt>
        <dd>
            <select name="id_pacote" id="id_pacote" class="chzn-select">
            <option value=""
            <?= $ci->id_pacote == '' ? ' selected="selected" ' : ''; ?>>Sem Pacote</option>
            <?php
            $pacotes = $pacoteDAO->listar();
            $p_valor = '';
            foreach ($pacotes as $pacote) {
                $p_valor .= '<option value="' . $pacote->id_pacote . '"';
                if ($ci->id_pacote == $pacote->id_pacote)
                    $p_valor.= ' selected="selected" ';
                $p_valor.=' >' . utf8_encode($pacote->pacote) . '</option>';
            }
            echo $p_valor;
            ?>
        </select>
        </dd>
        <dt>Telefone:</dt>
        <dd>
            <input type="text" name="tel" id="tel" class="fone required" value="<?= $ci->tel ?>" placeholder="Telefone" required>
        </dd>
        <dt>Ramal:</dt>
        <dd>
            <input type="text" name="ramal" id="ramal" value="<?= $ci->ramal ?>" placeholder="Ramal">
        </dd>
        <dt>Telefone:</dt>
        <dd>
            <input type="text" name="tel2" id="tel2" class="fone" value="<?= $ci->tel2 ?>" placeholder="Telefone">
        </dd>
        <dt>Ramal:</dt>
        <dd>
            <input type="text" name="ramal2" id="ramal2" value="<?= $ci->ramal2 ?>" placeholder="Ramal">
        </dd>
        <dt>Fax:</dt>
        <dd>
            <input type="text" name="fax" id="fax" class="fone" value="<?= $ci->fax ?>" placeholder="Fax"> 
        </dd>
        <dt>Outros:</dt>
        <dd>
            <input type="text" name="outros" id="outros" class="fone" value="<?= $ci->outros ?>" placeholder="Outros"> 
        </dd>
        <dt>Site:</dt>
        <dd class="line1"> 
            <input type="text" name="site" id="site" value="<?= utf8_decode($ci->site) ?>" placeholder="Site">
        </dd>
    </dl>
    <h3>endereço do cliente</h3>
    <dl>
        <dt>Endereço <span>*</span>:</dt>
        <dd class="line1">
            <input type="text" name="endereco" id="endereco" class="required" value="<?= ($ci->endereco) ?>" placeholder="Endereço" required>
        </dd>
        <dt>Número <span>*</span>:</dt>
        <dd>
            <input type="text" name="numero" id="numero" class="required" value="<?= ($ci->numero) ?>" placeholder="Número" required>
        </dd>
        <dt>Complemento:</dt>
        <dd>
            <input type="text" name="complemento" id="complemento" value="<?= ($ci->complemento) ?>" placeholder="Complemento">
        </dd>
        <dt>Bairro <span>*</span>:</dt>
        <dd>
            <input type="text" name="bairro" id="bairro" class="required" value="<?= ($ci->bairro) ?>" placeholder="Bairro" required>
        </dd>
        <dt>CEP <span>*</span>:</dt>
        <dd>
            <input type="text" name="cep" id="cep" class="cep required" value="<?= ($ci->cep) ?>" placeholder="CEP" onkeyup="BuscaCep(this.id, 1, '')" required>
        </dd>
        <dt>Cidade <span>*</span>:</dt>    
        <dd>
            <input type="text" name="cidade" id="cidade" value="<?= ($ci->cidade) ?>" placeholder="Cidade" class="required" required>
        </dd>
        <dt>Estado <span>*</span>:</dt>
        <dd>
            <select class="chzn-select required" name="estado" id="estado">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $ci->estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
            </select>
        </dd>
        <?php if($id_cliente == 0){ ?>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="<?=($id_cliente > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
        </div>
        <?php } ?>
    </dl>
    
    <?php
    $crm_data = '';
    $crm_data_p = '';
    if($id_cliente > 0){
        $data_contrato_i = '0000-00-00';
        $data_contrato_f = '0000-00-00';
        $data_aniversario = '0000-00-00';
        $data_ultimo_contato = '0000-00-00';
        $e = $clienteDAO->buscaClienteCRM($id_cliente);
        if (count($e) > 0) {
            $data_contrato_i = $e->data_contrato_i;
            $data_contrato_f = $e->data_contrato_f;
            $data_aniversario = $e->data_aniversario;
            $data_ultimo_contato = $e->ultimo_contato;
        } else {
            $e = new stdClass();
            $e->id_cliente = $id_cliente;
            $e->data_aniversario = $data_aniversario;
            $e->data_contrato_i = $data_contrato_i;
            $e->data_contrato_f = $data_contrato_f;
            $e->ultimo_contato = $data_ultimo_contato;
            $crm = $clienteDAO->insereClienteCRM($e);
        }
        $data = explode('-', $ci->data);
        $crm_data = $data[2] . '/' . $data[1] . '/' . $data[0];
        
        $pedido = $pedidoDAO->PegaUltimoPedido($ci->cpf);
        if(count($pedido) > 0){
            $d1 = explode(' ', $pedido->data);
            $d2 = explode('-', $d1[0]);
            $crm_data_p = $d2[2] . '/' . $d2[1] . '/' . $d2[0] . ' ' . $d1[1];
        }
     ?>
    
        <h3>crm</h3>
        <dl>
            <dt>Cliente desde:</dt>
            <dd>
                <input type="text" class="disabled" disabled="disabled" value="<?=$crm_data?>" placeholder="Cliente desde">
            </dd>
            <dt>Último Pedido:</dt>
            <dd>
                <input type="text" class="disabled" disabled="disabled" value="<?=$crm_data_p?>" placeholder="Último Pedido">
            </dd>
            <dt>Último Contato:</dt>
            <dd>
                <input class="data" type="text" name="data_ultimo_contato" id="data_ultimo_contato" value="<?= (isset($data_ultimo_contato) AND $data_ultimo_contato != '' AND $data_ultimo_contato != '0000-00-00') ? invert($data_ultimo_contato, '/', 'PHP') : ''; ?>" placeholder="Último Contato">
            </dd>
            <dt>Data de Aniversário:</dt>
            <dd>
                <input class="data" type="text" name="data_aniversario" id="data_aniversario" value="<?= (isset($data_aniversario) AND $data_aniversario != '' AND $data_aniversario != '0000-00-00') ? invert($data_aniversario, '/', 'PHP') : ''; ?>" placeholder="Data de Aniversário">
            </dd>
            <dt>Contrato de:</dt>
            <dd>
                <input class="data" type="text" name="data_contrato_i" id="data_contrato_i" value="<?= (isset($data_contrato_i) AND $data_contrato_i != '' AND $data_contrato_i != '0000-00-00') ? invert($data_contrato_i, '/', 'PHP') : ''; ?>" placeholder="Contrato de">
            </dd>
            <dt>Até:</dt>
            <dd>
                <input class="data" type="text" name="data_contrato_f" id="data_contrato_f" value="<?= (isset($data_contrato_f) AND $data_contrato_f != '' AND $data_contrato_f != '0000-00-00') ? invert($data_contrato_f, '/', 'PHP') : ''; ?>" placeholder="Até">
            </dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="<?=($id_cliente > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
        <?php
        $color = '#FFFEEE';
        $mes 	 	= array('','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');

        $total_qtde = 0;
        $total_vlr  = (float)0;
        $arr_qtde   = 0;

        $c = new stdClass();
        $c->cpf = $ci->cpf;
        $c->id_empresa = $controle_id_empresa;

        $pedido = $pedidoDAO->BalancoFianceiro($c);

        if(count($pedido) > 0){ ?>
        <h3>Balanço Financeiro <?php echo date('Y'); ?> (Últimos 100 pedidos)</h3>
        <dl class="box">
            <table class="table1">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th class="size100">Mês</th>
                            <th class="size100">Qtde.</th>
                            <th class="size100">Valor (R$)</th>
                        </tr>
                    </thead>
                    <?php

                    if(count($pedido) > 0){ ?>
                    <tbody>
                        <?php 
                        foreach($pedido as $ped => $p){ 
                            $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';
                            $valor      = number_format(((float)$arr_valor + (float)$p->valor), 2, ',', ' ');
                            $total_vlr  = (float)$total_vlr + (float)$p->valor;
                            $arr_qtde++; ?>
                            <tr <?=TRColor($color)?>>
                                <td><?=utf8_encode($p->nome)?></td>
                                <td class="size100"><?=$mes[substr($p->data,5,2)]?></td>
                                <td class="size100">1</td>
                                <td class="size100"><?= $valor;?></td>
                            </tr>  
                        <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="size100"><strong>Total</strong></th>
                                <th class="size100"><strong><?= $arr_qtde;?></strong></th>
                                <th class="size100"><strong><?= number_format($total_vlr, 2, ',', ' ');?></strong></th>
                            </tr>
                        </tfoot>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" class="nullable">Nenhum pedido computado</td>
                        </tr>
                    <?php } ?>
            </table>
        </dl>
        <?php } 
    } ?>
</form>
<?php if(isset($_POST['f_cadastro'])){ ?>
    <div class="msgbox">
        <div class="panel"><a href="#" onclick="$('.msgbox').hide()">fechar X</a></div>
        <div class="text"></div>
    </div>
    <script>
        BoxMsg(<?=($_POST) ? 1 : 0?>,<?=$errors?>,'<?=$campos?>','<?=$msgbox?>');
    </script>
<?php
}
$errors=0;
$campos='';
$msgbox='';
?>