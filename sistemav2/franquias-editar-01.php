<?php 
#var
$carrega   = 1;
$total_mes = 18;

#$errors=0;
#$campos='';
#$msgbox='';
$emp = array('status','franquia_tipo','id_recursivo','empresa','fantasia','cpf','rg','nome',
    'email','tel','ramal','skype','cel','endereco','numero','bairro','complemento','cidade','estado','cep',
    'id_banco','agencia','conta','favorecido','data_cof','adendo','adendo_data','inauguracao_data',
    'validade_contrato','precontrato','aditivo','exclusividade','notificacao','sem1','sem2','sem3','roy_min',
    'roy_min2','inicio','data_hotsite','royalties','imposto','fpp','fpp_tipo','mes_1','mes_2','mes_3','mes_4',
    'mes_5','mes_6','mes_7','mes_8','mes_9','mes_10','mes_11','mes_12','mes_13','mes_14','mes_15','mes_16',
    'mes_17','mes_18','ip','f_cadastro');

if($_POST AND isset($_POST['f_cadastro'])){
    $f_emp = Post_StdClass($_POST);
    $controle_id_departamento_p = explode(',', $controle_id_departamento_p);
    if(in_array('1', $controle_id_departamento_p) || in_array('17', $controle_id_departamento_p)) {
        $f_emp->inicio = invert($f_emp->inicio,'-','SQL');
    }
    
    $f_emp->estado                = $f_emp->estados;
    $f_emp->adendo_data       = ($f_emp->adendo_data != '') ? invert($f_emp->adendo_data, '-', 'SQL') : '';
    $f_emp->data_hotsite      = ($f_emp->data_hotsite != '') ? invert($f_emp->data_hotsite, '-', 'SQL') : '';
    $f_emp->inauguracao_data  = ($f_emp->inauguracao_data != '') ? invert($f_emp->inauguracao_data, '-', 'SQL') : '';
    $f_emp->validade_contrato = ($f_emp->validade_contrato != '') ? invert($f_emp->validade_contrato, '-', 'SQL') : '';
    $f_emp->data_cof          = ($f_emp->data_cof != '') ? invert($f_emp->data_cof, '-', 'SQL') : '';
    $f_emp->aditivo           = ($f_emp->aditivo != '') ? invert($f_emp->aditivo, '-', 'SQL') : '';
    $f_emp->precontrato = ($f_emp->precontrato != '') ? invert($f_emp->precontrato, '-', 'SQL') : '';
    if ($f_emp->royalties == "" || $f_emp->cpf == "" || $f_emp->nome == "" || $f_emp->email == "" || $f_emp->fantasia == "" || 
        $f_emp->empresa == "" || $f_emp->tel == "" || $f_emp->email == "" || $f_emp->endereco == "" || $f_emp->cidade == "" || 
        $f_emp->estado == "" || $f_emp->bairro == "" || $f_emp->cep == "" || 
                ($f_emp->adendo == 1 && $f_emp->adendo_data == '')) {
            
            $cp = array('royalties','cpf','nome','email','empresa','fantasia','tel','endereco',
                'bairro','cidade','estado','cep');
            for($i = 0; $i < count($cp); $i++){
                if($f_emp->$cp[$i] == ""){
                    $errors++;
                    $campos.= $cp[$i].';';
                    $msgbox.= "preencha este campo!;";
                }
            }
            if (($f_emp->adendo == 1 && $f_emp->adendo_data == '')){
                $errors++;
                $campos.= 'adendo_data;';
                $msgbox.= "erro na data!;";
            }
	}
    $valida = validaEMAIL($f_emp->email);
    if ($valida == 'false' AND $errors == 0) {
        $errors++;
        $campos.= 'email;';
        $msgbox.= "e-mail inválido, digite corretamente!;";
    }

    if ($f_emp->status=='Ativo' and $f_emp->inicio=='') {
        $errors++;
        $campos.= 'inicio;';
        $msgbox.= "preencha o campo início antes de ativar a franquia!;";
    }
	
    if($f_emp->cpf != ""){
        if (strlen($f_emp->cpf) <= 14) {
            $valida = validaCPF($f_emp->cpf);
            if ($valida == 'false') {
                $errors++;
                $campos.= 'cpf;';
                $msgbox.= "CPF Inválido, digite corretamente!;";
            }
        } else {
            $valida = validaCNPJ($f_emp->cpf);
            if ($valida == 'false' and $f_emp->franquia_tipo!=4) {
                $errors++;
                $campos.= 'cpf;';
                $msgbox.= "CNPJ Inválido, digite corretamente!;";
            }
        }
    }
        
    $f_emp->notificacao = str_replace("\n", '<br />', $f_emp->notificacao);
		
    if($errors == 0) {
        $f_emp->id_empresa = $id;
        $f_emp->total_mes  = $total_mes;
        if($id > 0){
            $f_emp = UTF_Encodes($f_emp,2);
            $f_emp->tipo = strlen($f_emp->cpf) == 14 ? 'cpf' : 'cnpj';
            $empresaDAO->atualizar($f_emp);
            $roy = $royalties->listar_franquia($f_emp->id_empresa);
            if(count($roy) > 0){
                $royalties->atualizar($f_emp);
            } else {
                $royalties->inserir($f_emp);
            }
            $msgbox .= MsgBox();
        } else {
            $empresaDAO->inserir($f_emp);
            $msgbox .= MsgBox(2);
        }
    }
    $carrega = $errors > 0 ? 0 : 1;
    $emp     = $errors > 0 ? $f_emp : new stdClass();
}
if($errors == 0){
if($carrega == 1 AND $id > 0){
    $emp = UTF_Encodes($empresaDAO->selectPorId($id));
}else {
    $emp = CriarVar($emp); 
}} ?>
<form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>&opcoes_form=1">
    <h3>informações da franquia</h3>
    <dl>
        <dt>Status <span>*</span>:</dt>
        <dd>
            <select name="status" id="status" class="chzn-select required" <?=($controle_id_usuario == 1) ? '' : 'disabled="disabled"'?>>
                <?php $stt = TiposDeStatus(3);
                foreach($stt AS $st){ ?>
                    <option value="<?=$st['id']?>" <?=($emp->status==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                <?php } ?>
            </select>
        </dd>
        <dt>Tipo da Franquia <span>*</span>:</dt>
        <dd>
            <select name="franquia_tipo" id="franquia_tipo" class="chzn-select required" <?=($controle_id_usuario == 1) ? '' : 'disabled="disabled"'?>>
                <?php $stt = TiposDeStatus(2);
                foreach($stt AS $st){ ?>
                    <option value="<?=$st['id']?>" <?=($emp->franquia_tipo==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                <?php } ?>
            </select>
        </dd>
        <dt>Franquia Master <span>*</span>:</dt>
        <dd class="line1">
            <select name="id_recursivo" id="id_recursivo" class="chzn-select required line1" <?=($controle_id_usuario == 1) ? '' : 'disabled="disabled"'?>>
                <option value="0">Franquia Master</option>
                <?php $listar = UTF_Encodes($franquia->listar(4, $id));
                foreach ($listar as $f) { ?>
                    <option value="<?=$f->id_empresa?>" <?=($f->id_empresa==$emp->id_recursivo)?'selected="selected"':''?>><?=($f->fantasia)?></option>
                <?php } ?>
            </select>
        </dd>
        <dt>Empresa <span>*</span>:</dt>
        <dd class="line1">
            <input type="text"  class="required" name="empresa" id="empresa" value="<?= ($emp->empresa) ?>" required placeholder="Empresa"> 
        </dd>
        <dt>Fantasia <span>*</span>:</dt>
        <dd class="line1"> 
            <input type="text" name="fantasia" id="fantasia" value="<?= ($emp->fantasia) ?>" required placeholder="Unidade" class="required"> 
        </dd>
        <dt>CPF / CNPJ <span>*</span>:</dt>
        <dd>
            <input type="text" name="cpf" id="cpf" class="cpf" value="<?= $emp->cpf ?>" required placeholder="CPF/CNPJ" class="required">
        </dd>
        <dt>RG/IE:</dt>
        <dd>
            <input type="text" name="rg" id="rg" value="<?= $emp->rg ?>" placeholder="RG/IE">
        </dd>
    </dl>
    <h3>informações de contato</h3>
    <dl>
        <dt>Proprietário:</dt>
        <dd class="line1">
            <input type="text" name="nome" id="nome" value="<?= ($emp->nome) ?>" required placeholder="Proprietário">
        </dd>
        <dt>E-mail <span>*</span>:</dt>
        <dd class="line1"> 
            <input type="text" name="email" id="email" class="email cp required" value="<?= utf8_decode($emp->email) ?>" <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?> required placeholder="E-mail">
        </dd>
        <dt>Skype:</dt>
        <dd class="line1"> 
            <input type="text" name="skype" id="skype" value="<?= utf8_decode($emp->skype) ?>" placeholder="Skype">
        </dd>
        <dt>Telefone <span>*</span>:</dt>
        <dd>
            <input type="text" name="tel" id="tel" class="fone required" value="<?= $emp->tel ?>" required placeholder="Telefone">
        </dd>
        <dt>Ramal:</dt>
        <dd>
            <input type="text" name="ramal" id="ramal" value="<?= $emp->ramal ?>" placeholder="Ramal">
        </dd>
        <dt>Celular:</dt>
        <dd>
            <input type="text" name="cel" id="cel" class="fone" class="telefone" value="<?= $emp->cel ?>" placeholder="Celular"> 
        </dd>
    </dl>
    <h3>endereço da unidade</h3>
    <dl>
        <dt>Endereço <span>*</span>:</dt>
        <dd class="line1">
            <input type="text" name="endereco" id="endereco" value="<?= ($emp->endereco) ?>" placeholder="Endereço" required class="required">
        </dd>
        <dt>Número <span>*</span>:</dt>
        <dd>
            <input type="text" name="numero" id="numero" value="<?= ($emp->numero) ?>" placeholder="Número" required class="required">
        </dd>
        <dt>Complemento:</dt>
        <dd>
            <input type="text" name="complemento" id="complemento" value="<?= ($emp->complemento) ?>" placeholder="Complemento">
        </dd>
        <dt>Bairro <span>*</span>:</dt>
        <dd>
            <input type="text" name="bairro" id="bairro" value="<?= ($emp->bairro) ?>" placeholder="Bairro" required class="required">
        </dd>
        <dt>CEP <span>*</span>:</dt>
        <dd>
            <input type="text" name="cep" id="cep" class="cep required" value="<?= ($emp->cep) ?>" placeholder="CEP" onkeyup="BuscaCep(this.id, 1, '')" required>
        </dd>
        <dt>Cidade <span>*</span>:</dt>    
        <dd>
            <input type="text" name="cidade" id="cidade" value="<?= ($emp->cidade) ?>" placeholder="Cidade" required class="required">
        </dd>
        <dt>Estado <span>*</span>:</dt>
        <dd>
            <select class="chzn-select required" name="estados" id="estados">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $emp->estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
            </select>
        </dd>
    </dl>
    <h3>informações bancárias</h3>
    <dl>
        <dt>Banco:</dt>
        <dd class="line1">
            <select name="id_banco" id="id_banco" class="chzn-select line1">
                <option value="0">Banco</option>
                <?php $listar = UTF_Encodes($bancoDAO->listar());
                foreach ($listar as $f) { ?>
                <option value="<?= $f->id_banco; ?>"<?= ($emp->id_banco == $f->id_banco) ? 'selected="selected"' : '' ?>>
                    <?= ($f->banco); ?>
                </option>
                <?php } ?>
            </select>
        </dd>
        <dt>Agência:</dt>
        <dd>
            <input type="text" name="agencia" id="agencia" value="<?= ($emp->agencia) ?>" maxlength="15" placeholder="Agência">
        </dd>
        <dt>Conta:</dt>
        <dd>
            <input type="text" name="conta" id="conta" value="<?= ($emp->conta) ?>" maxlength="15" placeholder="Conta">
        </dd>
        <dt>Favorecido:</dt>
        <dd class="line1">
            <input type="text" name="favorecido" id="favorecido" value="<?= ($emp->favorecido) ?>" maxlength="255" placeholder="Favorecido">
        </dd>
    </dl>
    <h3>informações jurídicas</h3>
    <dl>
        <dt>Assinatura da COF:</dt>
        <dd>
            <input class="data" type="text" name="data_cof" id="data_cof" value="<?= ($emp->data_cof != '') ? invert($emp->data_cof, '/', 'PHP') : ''; ?>" placeholder="Assinatura da COF">
        </dd>
        <dt>Adendo HSBC <span>*</span>:</dt>
        <dd>
            <input type="checkbox" id="adendo" name="adendo" value="1" <?= ($emp->adendo) ? 'checked="checked"' : '' ?>>
            <input class="data" style="width: 142px;" type="text" name="adendo_data" id="adendo_data" value="<?= ($emp->adendo_data != '') ? invert($emp->adendo_data, '/', 'PHP') : ''; ?>" placeholder="Adendo HSBC" required>
        </dd>
        <dt>Início de Contrato:</dt>
        <dd>
            <input class="data" type="text" name="inauguracao_data" id="inauguracao_data" value="<?= ($emp->inauguracao_data != '') ? invert($emp->inauguracao_data, '/', 'PHP') : ''; ?>" placeholder="Início de Contrato">
        </dd>
        <dt>Final de Contrato:</dt>
        <dd>
            <input class="data" type="text" name="validade_contrato" id="validade_contrato" value="<?= ($emp->validade_contrato != '') ? invert($emp->validade_contrato, '/', 'PHP') : ''; ?>" placeholder="Final de Contrato">
        </dd>
        <dt>Pré-Contrato</dt>
        <dd>
            <input class="data" type="text" name="precontrato" id="precontrato" value="<?= ($emp->precontrato != '') ? invert($emp->precontrato, '/', 'PHP') : ''; ?>" placeholder="Pré-Contrato">
        </dd>
        <dt>Aditivo de Royaltie:</dt>
        <dd>
            <input class="data" type="text" name="aditivo" id="aditivo" value="<?= ($emp->aditivo != '') ? invert($emp->aditivo, '/', 'PHP') : ''; ?>" placeholder="Aditivo de Royalty">
        </dd>
        <dt>Exclusividade:</dt>
        <dd>
            <input type="text" name="exclusividade" id="Exclusividade" class="numero" value="<?= $emp->exclusividade; ?>" placeholder="Exclusividade">
        </dd>
        <dt class="apagar">&nbsp;</dt><dd>&nbsp;</dd>
        <dt>Notificação:</dt>
        <dd class="line1 txta-h">
            <textarea name="notificacao" id="notificacao" placeholder="Notificação"><?= str_replace('<br />', "\n", ($emp->notificacao)); ?></textarea><br /><br />
        </dd>
    </dl>
    <h3>informações do ti</h3>
    <?php if($controle_id_usuario == 1 && $controle_id_empresa == 1){ ?>
        <input type="hidden" name="sem1" id="sem1" value="<?= $emp->sem1 ?>" />
        <input type="hidden" name="sem2" id="sem2" value="<?= $emp->sem2 ?>" />
        <input type="hidden" name="sem3" id="sem3" value="<?= $emp->sem3 ?>" />
        <input type="hidden" name="roy_min"  id="roy_min" value="<?= $emp->roy_min ?>" />
        <input type="hidden" name="roy_min2"  id="roy_min2" value="<?= $emp->roy_min2 ?>" />
    <?php } ?>
    <dl>
        <dt>Liberação:</dt>
        <dd>
            <input class="data" type="text" name="inicio" id="inicio" value="<?= ($emp->inicio != '') ? invert($emp->inicio, '/', 'PHP') : ''; ?>"  <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?> placeholder="Liberação">
        </dd>
        <dt>Hotsite:</dt>
        <dd>
            <input class="data" type="text" name="data_hotsite" id="data_hotsite" value="<?= ($emp->data_hotsite != '') ? invert($emp->data_hotsite, '/', 'PHP') : ''; ?>"  <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?> placeholder="Hotsite">
        </dd>
        <dt>Royalties:</dt>
        <dd>
            <input type="text" id="royalties" class="money" name="royalties" value="<?=($emp->royalties == '') ? 0 : $emp->royalties ?>" <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?> placeholder="Royalties">
        </dd>
        <dt>Deduzir Imposto:</dt>
        <dd>
            <input type="text" name="imposto" class="money" value="<?=($emp->imposto == '') ? 0 : $emp->imposto ?>" id="imposto" <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?> placeholder="Deduzir Impostos">
        </dd>
        <dt>FPP:</dt>
        <dd>
            <input type="text" name="fpp" id="fpp" class="money" value="<?=$emp->fpp?>" <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?>>
        </dd>
        <dt>Tipo FPP:</dt>
        <dd>
            <select name="fpp_tipo" id="fpp_tipo" class="chzn-select" <?=($controle_id_usuario == 1) ? '' : 'disabled="disabled"'?>>
                <option value="0"></option>
                <option value="1" <?=($emp->fpp_tipo==1)?'selected="selected"':''?>>Faturamento</option>
                <option value="2" <?=($emp->fpp_tipo==2)?'selected="selected"':''?>>Royaltie</option>
            </select>
        </dd>
        <dt>IP:</dt>
        <dd class="line1 txta-h">
            <textarea name="ip" id="ip" placeholder="IP" <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?> ><?= str_replace('<br />', "\n", ($emp->ip)); ?></textarea><br /><br />
        </dd>
        <div class="checkboxes">
            <p>Royalties Fixo:</p>
            <?php 
            $roy = $royalties->listar_franquia($id);
            if(count($roy) > 0){
                foreach ($roy as $f){
                    for($i = 1; $i <= $total_mes; $i++){
                        $mes = 'mes_'.$i;
                        $arr->$mes = $f->$mes;
                    }
                }
            }
            for($i = 1; $i <= $total_mes; $i++){
                for($j = 1; $j <= 4; $j++){ 
                    if($i <= $total_mes){ 
                        $mes = 'mes_'.$i;
                        $valor = (isset($arr->$mes)) ? $arr->$mes : '0.00';?>
                        <label><?=$i?>° Mês:</label> 
                        <input type="text" name="mes_<?=$i?>" id="mes_<?=$i?>" value="<?=$valor?>" class="mes money" <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?>>
            <?php       $i++; 
                    }
                } 
                $i--;
            } ?>
        </div>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <?php if($id > 0){ ?><input type="button" value="mensagem &rsaquo;&rsaquo;" onclick="location.href='franquias-msg.php<?=$link?>'"><?php } ?>
            <input type="submit" value="<?=($id > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
        </div>
    </dl>
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