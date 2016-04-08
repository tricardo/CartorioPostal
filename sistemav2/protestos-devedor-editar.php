<?php include('header.php'); 

$permissao = verifica_permissao('Protesto',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$protestoDAO = new ProtestoDAO();


pt_register('GET','id_protesto');
pt_register('GET','id_protesto_rem');

if($id_protesto == 0){
    header('location:pagina-erro.php');
    exit;
}

#
$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca = isset($c->busca) ? $c->busca : '';
$c->id_protesto = $id_protesto;
$c->id_protesto_rem = $id_protesto_rem;

$link = '';
$link .= '?pagina='.$c->pagina.'&id_protesto='.$id_protesto;
$link .= strlen($c->busca) > 0 ? '&busca='.$c->busca : '';

$arr = array('pagina','id_protesto','id_protesto_rem','tit_num','tipo_endosso','data_emissao','data_vencimento',
    'valor','saldo','aceite','praca_pagamento','especie','dev_num','nosso_numero','dev_nome','cpf','outro_doc',
    'dev_endereco','dev_bairro','dev_cep','dev_cidade','dev_estado','num','num_pro','data_protocolo','custas',
    'custas_cart','decla_portador','data_ocorrencia','oco_tipo','registro_distr','cod_irr','comp_irr','tipo_cam',
    'oper_banco','contrato_banco','parcela_contrato','custas_gravacao');


if($_POST){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    if($errors == 0){
        $ci = UTF_Encodes($ci, 2);
        $ci->id_protesto = $id_protesto;
            $ci->id_protesto_rem = $id_protesto_rem;
            $ci->motivo_falencia = isset($ci->motivo_falencia) ? $ci->motivo_falencia : '';
            $ci->tipo = strlen($ci->cpf) > 14 ? 'cnpj' : 'cpf';
            $ci->id_usuario = $controle_id_usuario;
        if($id_protesto_rem > 0){
            $protestoDAO->atualizaDevedor($ci, $controle_id_empresa);
            $msgbox .= MsgBox();
        } else {
            $protestoDAO->inserirDevedor($ci);
            $msgbox .= MsgBox(2);
        }
    }
    
}

if($errors == 0){   
    if($id_protesto_rem > 0){     
        $ci = UTF_Encodes($protestoDAO->buscaDevedorPorId($id_protesto_rem, $controle_id_empresa));
    } else {
        $ci = CriarVar($arr); 
        $ci->data_emissao = '0000-00-00';
        $ci->data_vencimento = '0000-00-00';
        $ci->data_protocolo = '0000-00-00';
        $ci->data_ocorrencia = '0000-00-00';
        $ci->motivo_falencia = '';
    }
}?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; protestos  &rsaquo;&rsaquo; devedor &rsaquo;&rsaquo; <a href="protestos-devedor-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-15').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php 
    AddRegistro('protestos-devedor-editar.php'.$link.'&id_protesto_rem=0');
    $link .= '&id_protesto_rem='.$c->id_protesto_rem;  
    CamposObrigatorios(); ?> 
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3>dados do título</h3>
        <dl>
            <dt>Núm. Título:</dt>
            <dd>
                <input type="text" name="tit_num" id="tit_num" value="<?=$ci->tit_num ?>" maxlength="11" placeholder="Núm. Título" class="numero" maxlength="11">
            </dd>
            <dt>Endosso:</dt>
            <dd>
                <select name="tipo_endosso" id="tipo_endosso" class="chzn-select">
                    <?php foreach(TiposDeStatus(8) AS $status){ ?>
                        <option value="<?=$status['id']?>"<?= $status['id'] == $ci->tipo_endosso ? ' selected ' : ''; ?>><?=$status['texto']?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Emissão:</dt>
            <dd>
                <input type="text" name="data_emissao" id="data_emissao" value="<?=invert($ci->data_emissao,'/','PHP') ?>" class="data" placeholder="Emissão">
            </dd>
            <dt>Vencimento:</dt>
            <dd>
                <input type="text" name="data_vencimento" id="data_vencimento" value="<?=invert($ci->data_vencimento,'/','PHP') ?>" class="data" placeholder="Vencimento">
            </dd>
            <dt>Valor:</dt>
            <dd>
                <input type="text" name="valor" id="valor" value="<?=$ci->valor ?>" placeholder="Valor" class="numero">
            </dd>
            <dt>Saldo:</dt>
            <dd>
                <input type="text" name="saldo" id="saldo" value="<?=$ci->saldo ?>" placeholder="Saldo" class="numero">
            </dd>
            <dt>Aceite:</dt>
            <dd>
                <select name="aceite" id="aceite" class="chzn-select">
                    <?php foreach(TiposDeStatus(9) AS $status){ ?>
                        <option value="<?=$status['id']?>"<?= $status['id'] == $ci->aceite ? ' selected ' : ''; ?>><?=$status['texto']?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Praça:</dt>
            <dd>
                <input type="text" name="praca_pagamento" id="praca_pagamento" value="<?=$ci->praca_pagamento ?>" maxlength="20" placeholder="Praça" class="numero">
            </dd>
            <dt>Espécie:</dt>
            <dd>
                <input type="text" name="especie" id="especie" value="<?=$ci->especie ?>" placeholder="Espécie" class="numero" maxlength="3">
            </dd>
            <dt>Qtde. Devedor ou End.:</dt>
            <dd>
                <input type="text" name="dev_num" id="dev_num" value="<?=$ci->dev_num ?>" placeholder="Qtde. Devedor ou End." maxlength="1" class="numero">
            </dd>
            <dt>Nosso Número:</dt>
            <dd>
                <input type="text" name="nosso_numero" id="nosso_numero" value="<?=$ci->nosso_numero ?>" placeholder="Nosso Número">
            </dd>
        </dl>
        <h3>devedor</h3>
        <dl>
            <dt>Nome:</dt>
            <dd class="line1">
                <input type="text" name="dev_nome" id="dev_nome" value="<?= $ci->dev_nome ?>" placeholder="Nome do Credor">
            </dd>
            <dt>CPF/CNPJ:</dt>
            <dd>
                <input type="text" name="cpf" id="cpf" class="cpf" value="<?= $ci->cpf ?>" placeholder="CPF/CNPJ">
            </dd>
            <dt>Outro Doc.</dt>
            <dd>
                <input type="text" name="outro_doc" id="outro_doc" value="<?=$ci->outro_doc ?>" maxlength="11" placeholder="Outro Doc.">
            </dd>
            <dt>Endereço:</dt>
            <dd class="line1">
                <input type="text" name="dev_endereco" id="dev_endereco" value="<?= ($ci->dev_endereco) ?>" placeholder="Endereço">
            </dd>
            <dt>Bairro:</dt>
            <dd>
                <input type="text" name="dev_bairro" id="dev_bairro" value="<?= ($ci->dev_bairro) ?>" placeholder="Bairro">
            </dd>
            <dt>CEP:</dt>
            <dd>
                <input type="text" name="dev_cep" id="dev_cep" class="cep" value="<?= ($ci->dev_cep) ?>" placeholder="CEP" onkeyup="BuscaCep(this.id, 1, '')">
            </dd>
            <dt>Cidade:</dt>    
            <dd>
                <input type="text" name="dev_cidade" id="dev_cidade" value="<?= ($ci->dev_cidade) ?>" placeholder="Cidade">
            </dd>
            <dt>Estado:</dt>
            <dd>
                <select class="chzn-select" name="dev_estado" id="dev_estado">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $ci->dev_estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
                </select>
            </dd>
        </dl>
        <h3>cartório</h3>
        <dl>
            <dt>Número:</dt>
            <dd>
                <input type="text" name="num" id="num" value="<?= $ci->num ?>" placeholder="Número" class="numero"> 
            </dd>
            <dt>Protocolo:</dt>
            <dd>
                <input type="text" name="num_pro" id="num_pro" value="<?=$ci->num_pro ?>" maxlength="10" placeholder="Protocolo" class="numero"> 
            </dd>
            <dt>Data do Protoc.:</dt>
            <dd>
                <input type="text" name="data_protocolo" id="data_protocolo" value="<?=invert($ci->data_protocolo,'/','PHP')?>" placeholder="Data do Protoc." class="data">
            </dd>
            <dt>Custas:</dt>
            <dd>
                <input type="text" name="custas" id="custas" value="<?=$ci->custas ?>" placeholder="Custas" class="numero">
            </dd>
            <dt>Custas Cart. Dist.:</dt>
            <dd>
                <input type="text" name="custas_cart" id="custas_cart" value="<?=$ci->custas_cart ?>" placeholder="Custas Cart. Dist." class="numero">
            </dd>
            <dt>Declaração Portador:</dt>
            <dd>
                <input type="text" name="decla_portador" id="decla_portador" value="<?=$ci->decla_portador ?>" placeholder="Declaração Portador">
            </dd>
            <dt>Ocorrência:</dt>
            <dd>
                <input type="text" name="data_ocorrencia" id="data_ocorrencia" value="<?=invert($ci->data_ocorrencia,'/','PHP');?>" placeholder="Ocorrência" class="data">
            </dd>
            <dt>Tipo Ocorrência:</dt>
            <dd>
                <input type="text" name="oco_tipo" id="oco_tipo" value="<?=$ci->oco_tipo ?>" placeholder="Tipo Ocorrência">
            </dd>
            <dt>Registro Dist.:</dt>
            <dd>
                <input type="text" name="registro_distr" id="registro_distr" value="<?=$ci->registro_distr ?>" placeholder="Registro Dist." class="numero">
            </dd>
            <dt>Cód. Irregularidade:</dt>
            <dd>
                <input type="text" name="cod_irr" id="cod_irr" value="<?=$ci->cod_irr ?>" maxlength="2" placeholder="Cód. Irregularidade" class="numero">
            </dd>
            <dt>Compl. Irregularidade:</dt>
            <dd>
                <input type="text" name="comp_irr"id="comp_irr" value="<?=$ci->comp_irr ?>" maxlength="8" placeholder="Compl. Irregularidade">
            </dd>
            <dt>Tipo Cambio:</dt>
            <dd>
                <input type="text" name="tipo_cam" id="tipo_cam" value="<?=$ci->tipo_cam ?>" maxlength="1" placeholder="Tipo Cambio" class="numero">
            </dd>
            <dt>Núm. Oper. Banco:</dt>
            <dd>
                <input type="text" name="oper_banco" id="oper_banco" value="<?=$ci->oper_banco ?>" placeholder="Núm. Oper. Banco" class="numero">
            </dd>
            <dt>Núm. Contr. Banco:</dt>
            <dd>
                <input type="text" name="contrato_banco" id="contrato_banco" value="<?=$ci->contrato_banco ?>" placeholder="Núm. Contr. Banco" class="numero">
            </dd>
            <dt>Núm. Parc. Contr.:</dt>
            <dd>
                <input type="text" name="parcela_contrato" id="parcela_contrato" maxlength="3" value="<?=$ci->parcela_contrato ?>" placeholder="Núm. Parc. Contr." class="numero">
            </dd>
            <dt>Custa Gravação:</dt>
            <dd>
                <input type="text" name="custas_gravacao" id="custas_gravacao" value="<?=$ci->custas_gravacao ?>" placeholder="Custa Gravação" class="numero">
            </dd>
            <dt>Motivo de Falência:</dt>
            <dd class="checks">
                <input type="checkbox" name="motivo_falencia" id="motivo_falencia" <?= $ci->motivo_falencia=='on' ? 'checked="checked"' : ''; ?>>
                <span>Sim</span>
            </dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="<?=($id_protesto_rem > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
    </form>
    <script>
        preencheCampo();
    </script>
</div>
<?php include('footer.php'); ?>