<?php
$arr = array('id_holding','id_fornecedor','conta_caixa','id_planoconta','id_forma_pagamento',
    'id_departamento','id_banco','agencia','conta','favorecido','cnpj','id_regime','nota','fisico',
    'valor','dt_vencimento','valor_ir','valor_pis','valor_cofins','qt_parcelas','parcela','descricao',
    'cod_barras','desconto','vlr_multa','valor_pg','dt_pagamento','id_conta','f_cadastro');
if($_POST AND isset($_POST['f_cadastro'])){
    $p = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    
    $p->total_pago = $id_pagamento != 0 ? (float)($p->valor)+(float)($p->vlr_multa)-(float)($p->desconto) : 0;
    if(isset($p->dt_pagamento) AND (($p->dt_pagamento=='00/00/0000' or strlen($p->dt_pagamento)<10) and $p->valor_pg!='0.00' AND $errors == 0)){
        $errors++;
        $campos.= 'dt_pagamento;';
        $msgbox.= "preencha a data do pagamento!;";
    }

     if(isset($p->id_conta) AND (($p->id_conta<>'' or $p->dt_pagamento!='00/00/0000') and ($p->valor_pg=='0.00' or  $p->valor_pg=='')  AND $errors == 0)){
        $errors++;
        $campos.= 'valor_pg;';
        $msgbox.= "preencha a valor pago!;";
    }
        
    if(isset($p->id_conta) AND (strlen($p->id_conta)==0 and $p->valor_pg!='0.00' AND $id_pagamento != 0  AND $errors == 0)){
        $errors++;
        $campos.= 'id_conta;';
        $msgbox.= "selecione a conta para debitar!;";
    }

    if(isset($p->valor_pg) AND (trim($p->valor_pg) != trim($p->total_pago) and $p->valor_pg!='0.00' AND $id_pagamento != 0  AND $errors == 0)){
        $errors++;
        $campos.= 'valor_pg;';
        $msgbox.= "valor pago incorreto: valor total + multa/juros - desconto = R$ ".$p->total_pago."!;";
    }

    if(isset($p->valor_pg) AND ($p->valor_pg=='' and $p->id_conta<>'' AND $p->id_pagamento != 0 AND $errors == 0)){
        $errors++;
        $campos.= 'valor_pg;';
        $msgbox.= "preencha o valor que foi pago!;";
    }
    if(strlen($p->dt_vencimento) > 0 AND !ValidaData($p->dt_vencimento) AND $errors == 0){
        $errors++;
        $campos.= 'dt_vencimento;';
        $msgbox.= "informe uma data válida!;";
    }
    
    if(isset($p->dt_pagamento) AND (strlen($p->dt_pagamento) > 0 AND !ValidaData($p->dt_pagamento) AND $errors == 0)){
        $errors++;
        $campos.= 'dt_pagamento;';
        $msgbox.= "informe uma data válida!;";
    }

    if($errors == 0){
        $arr1 = array('id_fornecedor','id_planoconta','favorecido','id_regime','id_forma_pagamento',
            'descricao','dt_vencimento','valor');
        for($i = 0; $i < count($arr1); $i++){
            if($$arr1[$i] == ""){
                $errors++;
                $campos.= $arr1[$i].';';
                $msgbox.= "preencha este campo!;";
            }
        }
    }
    
    if($errors == 0){
        $p = UTF_Encodes($p, 2);
        $p->id_empresa = $controle_id_empresa;
        if(strlen($p->dt_pagamento) > 0){
            $p->dt_pagamento = explode('/',$p->dt_pagamento);
            $p->dt_pagamento = $p->dt_pagamento[2].'-'.$p->dt_pagamento[1].'-'.$p->dt_pagamento[0];
        } else {
            $p->dt_pagamento = '0000-00-00';
        }
        if(strlen($p->dt_vencimento) > 0){
            $p->dt_vencimento = explode('/',$p->dt_vencimento);
            $p->dt_vencimento = $p->dt_vencimento[2].'-'.$p->dt_vencimento[1].'-'.$p->dt_vencimento[0];
        } else {
            $p->dt_vencimento = '0000-00-00';
        }
        if($id_pagamento > 0){
            $p->id_pagamento = $id_pagamento;
            $pagamentoDAO->atualizar($p);
            $msgbox .= MsgBox();
        } else {          
            $pagamentoDAO->inserir($p);
            $msgbox .= MsgBox(2);
        }
        
    }
}
if($errors == 0){
if($id_pagamento > 0){
    $p = UTF_Encodes($pagamentoDAO->buscaPorId($id_pagamento,$controle_id_empresa));
    $p->dt_pagamento = $p->dt_pagamento != '' ? invert($p->dt_pagamento,'/','PHP') : '';
    $p->dt_vencimento = $p->dt_vencimento != '' ? invert($p->dt_vencimento,'/','PHP') : '';
} else {
    if($errors == 0){
        $p = CriarVar($arr); 
    }
}}
?>
<form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>&opcoes_form=1">
    <h3>contas à pagar</h3>
    <dl>
        <?php if($controle_id_empresa == 1){ ?>
            <dt>Holding <span>*</span>:</dt>
            <dd>
                <select name="id_holding" id="id_holding" class="chzn-select required">
                    <option value="">Sistecart</option>
                    <?php  $holding = $pagamentoDAO->listaHolding();
                    $p_valor = '';
                    foreach($holding as $f){
                        $p_valor .= '<option value="'.$f->id_holding.'" ';
                        if($p->id_holding==$f->id_holding) $p_valor .= ' selected="selected"';
                        $p_valor .= '>'. utf8_encode($f->holding) .'</option>';
                    }
                    echo $p_valor; ?>
                </select>
            </dd>
        <?php } ?>
        <dt>Fornecedor:</dt>
        <dd>
            <select name="id_fornecedor" id="id_fornecedor" class="chzn-select required" onchange="carrega_fornecedor_contas(this.value)">
                <?php $fornecedores = $fornecedorDAO->lista($controle_id_empresa);
                $p_valor = '';
                foreach($fornecedores as $f){
                    $p_valor .= '<option value="'.$f->id_fornecedor.'" ' .(($p->id_fornecedor==$f->id_fornecedor) ? ' selected="selected"' : '').'>'. utf8_encode($f->fantasia) .'</option>';
                } 
                echo $p_valor; ?>
            </select>
        </dd>
        <dt>Núm. Classificação <span>*</span>:</dt>
        <dd>
            <input type="text" name="conta_caixa" id="conta_caixa" class="numero required" placeholder="Núm. Classificação">
        </dd>
        <dt>Classificação <span>*</span>:</dt>
        <dd>
            <select name="id_planoconta" id="id_planoconta" onchange="$('#conta_caixa').val(this.value);" class="chzn-select required">
                <?php $classificacao = $financeiroDAO->listarPlanoConta();
                $p_valor = '<option value="">Classificação</option>';
                foreach($classificacao as $f){
                    $p_valor .= '<option value="'.$f->id_planoconta.'"';
                    if($p->id_planoconta==$f->id_planoconta) $p_valor .= 'selected="selected"';
                    $p_valor .= '>'.utf8_encode($f->descricao).'</option>';
                }
                echo $p_valor; ?>
            </select>
        </dd>
        <dt>Forma:</dt>
        <dd>
            <select name="id_forma_pagamento" id="id_forma_pagamento" class="chzn-select" onchange="if($(this).val()=='4')$('#deposito').show(); else $('#deposito').hide();">
                <?php $forma = $financeiroDAO->listarFormaPagamentoCAP();
                $p_valor = '';
                foreach($forma as $f){
                    $p_valor .= '<option value="'.$f->id_forma_pagamento.'" ';
                    if($p->id_forma_pagamento==$f->id_forma_pagamento) $p_valor .= 'selected="selected"';
                    $p_valor .= '>'.utf8_encode($f->forma_pagamento).'</option>';
                }
                echo $p_valor; ?>
            </select>
        </dd>
        <dt>Centro de Custo:</dt>
        <dd>
            <select name="id_departamento" id="id_departamento" class="chzn-select">
                <?php $p_valor ='<option value="0" '.(($p->id_departamento==0) ? ' selected="selected"' : '') .'>Rateio</option>';
                $departamentos_s = $departamentoDAO->listar();
                foreach($departamentos_s as $dep){
                    $p_valor .='<option value="'.$dep->id_departamento.'"';
                    if($dep->id_departamento==$p->id_departamento) $p_valor .= ' selected="selected"';
                    $p_valor .= '>'. $dep->departamento.'</option>';
                } 
                echo $p_valor; ?>
            </select>
        </dd>
        <div id="deposito">
            <dt>Banco:</dt>
            <dd>
                <select name="id_banco" id="id_banco" class="chzn-select">
                    <option>Banco</option>
                    <?php $bancos = $bancoDAO->listar();
                    foreach($bancos as $banco){ ?>
                        <option value="<?=$banco->id_banco;?>" <?=($p->id_banco==$banco->id_banco)?'selected="selected"':''?>><?=utf8_encode($banco->banco); ?></option>
                    <?php }?>
                </select>
            </dd>
            <dt>Agência:</dt>
            <dd>
                <input type="text" id="agencia" name="agencia" value="<?=$p->agencia ?>" placeholder="Agência">
            </dd>
            <dt>Conta:</dt>
            <dd>
                <input type="text" name="conta" id="conta" value="<?=$p->conta ?>" placeholder="Conta">
            </dd>
            <dt>&nbsp;</dt><dd>&nbsp;</dd>
        </div>
        <dt>Favorecido <span>*</span>:</dt>
        <dd class="line1">
            <input type="text" class="line1 required" required="required" id="favorecido" name="favorecido" value="<?=$p->favorecido ?>" placeholder="Favorecido">
        </dd>
        <dt>CPF/CNPJ:</dt>
        <dd>
            <input type="text" id="cnpj" name="cnpj" value="<?=$p->cnpj ?>" class="cpf">
        </dd>
        <dt>Regime Trib. <span>*</span>:</dt>
        <dd>
            <select name="id_regime" id="id_regime" class="chzn-select required">
                <?php $regime = $regimeDAO->listar();
                $p_valor = '';
                foreach($regime as $f){
                    $p_valor .= '<option value="'.$f->id_regime.'" '.(($p->id_regime==$f->id_regime) ? ' selected="selected"' : '').'>'. utf8_encode($f->nome) .'</option>';
                }
                echo $p_valor; ?>
            </select>
        </dd>
        <dt>Nota:</dt>
        <dd>
            <input type="text" name="nota" id="nota" value="<?= $p->nota ?>" placeholder="Nota">
        </dd>
        <dt>Doc. Físico:</dt>
        <dd class="checks">
            <input id="fisico" name="fisico" type="checkbox" value="1" <?=(isset($p->fisico) AND $p->fisico==1)?'checked':'';?>>
            <span>Recebido</span>
        </dd>
        <dt>Valor Total <span>*</span>:</dt>
        <dd>
            <input type="text" name="valor" id="valor" value="<?=$p->valor ?>" class="money required" required="required" placeholder="Valor Total">
        </dd>
        <dt>Vencimento:</dt>
        <dd>
            <input type="text" name="dt_vencimento" id="dt_vencimento" value="<?=$p->dt_vencimento?>" class="data required" required="required" placeholder="Vencimento">
        </dd>
        <dt>IR:</dt>
        <dd>
            <input type="text" readonly="readonly" name="valor_ir" id="valor_ir" value="<?php echo $p->valor_ir ?>" placeholder="IR">
        </dd>
        <dt>PIS:</dt>
        <dd>
            <input type="text" readonly="readonly" name="valor_pis" id="valor_pis" value="<?php echo $p->valor_pis ?>" placeholder="PIS">
        </dd>
        <dt>COFINS:</dt>
        <dd>
            <input type="text" readonly="readonly" name="valor_cofins" id="valor_cofins" value="<?php echo $p->valor_cofins ?>" placeholder="COFINS">
        </dd>
        <dt>&nbsp;</dt>
        <dd>&nbsp;</dd>
        <?php if((isset($p->parcela) AND $p->parcela<>'') or $id_pagamento==0){ 
            if(isset($p->parcela) AND $p->parcela<>'' and $id_pagamento<>0){ ?>
                <dt>Parcela:</dt>
                <dd><input type="text" readonly="readonly" value="<?=$p->parcela.' de '. $p->qt_parcelas?>"></dd>
                <dt>&nbsp;</dt>
                <dd>&nbsp;</dd>
                <input type="hidden" name="qt_parcelas" id="qt_parcelas" value="<?=$p->qt_parcelas?>">
                <input type="hidden" name="parcela" value="<?=$p->parcela?>">
            <?php } else { 
                if($id_pagamento=0){ ?>
                <dt>&Duplicar</dt>
                <dd>
                    <input type="text" name="qt_parcelas" id="qt_parcelas" value="<?=$p->qt_parcelas?>" class="numero"> 
                </dd>
                <dt>&nbsp;</dt>
                <dd>&nbsp;</dd>
            <?php }} 
        } ?>
        <dt>Descrição <span>*</span>:</dt>
        <dd class="line1 txta-h">
            <textarea class="required" name="descricao" id="descricao" placeholder="Descrição"><?= str_replace('<br />', "\n", ($p->descricao)); ?></textarea>
        </dd>
        <?php if($id_pagamento==0){ ?>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="<?=($id_pagamento > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        <?php } ?>
    </dl>
    <?php if($id_pagamento<>0){ ?>
        <h3>dados sobre o pagamento</h3>
        <dl>
            <dt>Cód. de Barras:</dt>
            <dd>
                <input type="text" name="cod_barras" id="cod_barras" value="<?=$p->cod_barras?>" placeholder="Cód. de Barras">
            </dd>
            <dt>Debitar <span>*</span>:</dt>
            <dd>
                <select name="id_conta" id="id_conta" required="required" class="chzn-select required">
                    <option>Debitar</option>
                    <?php  $contas = $contaDAO->listarConta($controle_id_empresa);
                    $p_valor = '';
                    foreach($contas as $f){
                        $p_valor .= '<option value="'.$f->id_conta.'" ';
                        if($p->id_conta==$f->id_conta) $p_valor .= ' selected="selected"';
                        $p_valor .= '>'. utf8_encode($f->sigla) .'</option>';
                    } 
                    echo $p_valor; ?>
                </select>
            </dd>
            <dt>Desconto:</dt>
            <dd>
                <input type="text" name="desconto" id="desconto" class="money" value="<?=$p->desconto ?>" placeholder="Desconto">
            </dd>
            <dt>Multa/Juros:</dt>
            <dd>
                <input type="text" name="vlr_multa" id="vlr_multa" class="money" value="<?=$p->vlr_multa ?>" placeholder="Multa/Juros">
            </dd>
            <dt>Total Pago:</dt>
            <dd>
                <input type="text" name="valor_pg" id="valor_pg" class="money" value="<?=$p->valor_pg ?>" placeholder="Total Pago">
            </dd>
            <dt>Data Pago:</dt>
            <dd>
                <input type="text" name="dt_pagamento" id="dt_pagamento" class="data" value="<?=$p->dt_pagamento?>" placeholder="Data Pago">
            </dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="<?=($id_pagamento > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
    <?php } 
    echo ($p->id_forma_pagamento=='4') ? "<script>$('#deposito').show()</script>" : "<script>$('#deposito').hide()</script>";?>
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