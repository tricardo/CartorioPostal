<?php 
$arr = array('razao','fantasia','cnpj','ie','id_regime','fax','endereco','numero','complemento','bairro','cep',
    'cidade','estado','id_banco','agencia','conta','favorecido','contato1','email1','tel1','ramal1',
    'contato2','email2','tel2','ramal2','descProduto','creditoCompra');

if($_POST AND isset($_POST['f_cadastro'])){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    
    $arr1 = array('razao','fantasia');
    for($i = 0; $i < count($arr1); $i++){
        if($$arr1[$i] == ""){
            $errors++;
            $campos.= $arr1[$i].';';
            $msgbox.= "preencha este campo!;";
        }
    }
    
    if($errors == 0 AND strlen($cnpj) > 0){
        $valida = validaCNPJ($cnpj);
        if ($valida == 'false') {
           $errors++;
           $campos.='cnpj;';
           $msgbox.="CNPJ Inválido, digite corretamente!;";
        }
    }
    
     if($errors == 0){
        $ci->id_fornecedor = $id_fornecedor;
        $ci->id_empresa    = $controle_id_empresa;
        $ci = UTF_Encodes($ci, 2);
        if($id_fornecedor > 0){
            $fornecedorDAO->atualizar($ci);
            $msgbox .= MsgBox();
        } else {
            $fornecedorDAO->inserir($ci);
            $msgbox .= MsgBox(2);
        }
    }
}

if($errors == 0){
if($id_fornecedor > 0){
    $ci = UTF_Encodes($fornecedorDAO->buscaPorId($id_fornecedor,$controle_id_empresa));
}else {
    $ci = CriarVar($arr); 
}}
?>
<form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>&opcoes_form=1">
    <h3>informações do fornecedor</h3>
    <dl>
        <dt>Razão Social <span>*</span>:</dt>
        <dd class="line1">
            <input type="text" name="razao" id="razao" value="<?= ($ci->razao) ?>" required placeholder="Razão Social"> 
        </dd>
        <dt>Fantasia <span>*</span>:</dt>
        <dd class="line1"> 
            <input type="text" name="fantasia" id="fantasia" value="<?= ($ci->fantasia) ?>" required placeholder="Fantasia"> 
        </dd>
        <dt>CNPJ:</dt>
        <dd>
            <input type="text" name="cnpj" id="cnpj" class="cpf" value="<?= $ci->cnpj ?>" placeholder="CNPJ">
        </dd>
        <dt>IE:</dt>
        <dd>
            <input type="text" name="ie" id="ie" value="<?= $ci->ie ?>" placeholder="IE">
        </dd>
        <dt>Regime de Tributação:</dt>
        <dd>
            <select name="id_regime" id="id_regime" class="chzn-select">
                <option>Regime de Tributação</option>
                <?php $regimes = $regimeDAO->listar();
                foreach($regimes as $regime){ ?>
                    <option value="<?=$regime->id_regime;?>" <?=($ci->id_regime == $regime->id_regime)?'selected="selected"':''?>><?=utf8_encode($regime->nome); ?></option>
                <?php }?>
            </select>
        </dd>
        <dt>Fax:</dt>
        <dd>
            <input type="text" name="fax" id="fax" class="fone" value="<?= $ci->fax ?>" placeholder="Fax"> 
        </dd>
    </dl>
    
    <h3>endereço do fornecedor</h3>
    <dl>
        <dt>Endereço:</dt>
        <dd class="line1">
            <input type="text" name="endereco" id="endereco" value="<?= ($ci->endereco) ?>" placeholder="Endereço">
        </dd>
        <dt>Número:</dt>
        <dd>
            <input type="text" name="numero" id="numero" value="<?= ($ci->numero) ?>" placeholder="Número">
        </dd>
        <dt>Complemento:</dt>
        <dd>
            <input type="text" name="complemento" id="complemento" value="<?= ($ci->complemento) ?>" placeholder="Complemento">
        </dd>
        <dt>Bairro:</dt>
        <dd>
            <input type="text" name="bairro" id="bairro" value="<?= ($ci->bairro) ?>" placeholder="Bairro">
        </dd>
        <dt>CEP:</dt>
        <dd>
            <input type="text" name="cep" id="cep" class="cep" value="<?= ($ci->cep) ?>" placeholder="CEP" onkeyup="BuscaCep(this.id, 1, '')">
        </dd>
        <dt>Cidade:</dt>    
        <dd>
            <input type="text" name="cidade" id="cidade" value="<?= ($ci->cidade) ?>" placeholder="Cidade">
        </dd>
        <dt>Estado:</dt>
        <dd>
            <select class="chzn-select" name="estado" id="estado">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $ci->estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
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
                <option value="<?= $f->id_banco; ?>"<?= ($ci->id_banco == $f->id_banco) ? 'selected="selected"' : '' ?>>
                    <?= ($f->banco); ?>
                </option>
                <?php } ?>
            </select>
        </dd>
        <dt>Agência:</dt>
        <dd>
            <input type="text" name="agencia" id="agencia" value="<?= ($ci->agencia) ?>" maxlength="15" placeholder="Agência">
        </dd>
        <dt>Conta:</dt>
        <dd>
            <input type="text" name="conta" id="conta" value="<?= ($ci->conta) ?>" maxlength="15" placeholder="Conta">
        </dd>
        <dt>Favorecido:</dt>
        <dd class="line1">
            <input type="text" name="favorecido" id="favorecido" value="<?= ($ci->favorecido) ?>" maxlength="255" placeholder="Favorecido">
        </dd>
    </dl>
    <h3>contatos</h3>
    <dl>
        <dt>Contato:</dt>
        <dd>
            <input type="text" name="contato1" id="contato1" value="<?= $ci->contato1 ?>" placeholder="Contato">
        </dd>
        <dt>E-mail:</dt>
        <dd> 
            <input type="text" name="email1" id="email1" class="email" value="<?= utf8_decode($ci->email1) ?>" placeholder="E-mail">
        </dd>
        <dt>Telefone:</dt>
        <dd>
            <input type="text" name="tel1" id="tel1" class="fone" value="<?= $ci->tel1 ?>" placeholder="Telefone">
        </dd>
        <dt>Ramal:</dt>
        <dd>
            <input type="text" name="ramal1" id="ramal1" value="<?= $ci->ramal1 ?>" placeholder="Ramal">
        </dd>
        <dt>Contato:</dt>
        <dd>
            <input type="text" name="contato2" id="contato2" value="<?= $ci->contato2 ?>" placeholder="Contato">
        </dd>
        <dt>E-mail:</dt>
        <dd> 
            <input type="text" name="email2" id="email2" class="email" value="<?= utf8_decode($ci->email2) ?>" placeholder="E-mail">
        </dd>
        <dt>Telefone:</dt>
        <dd>
            <input type="text" name="tel2" id="tel2" class="fone" value="<?= $ci->tel2 ?>" placeholder="Telefone">
        </dd>
        <dt>Ramal:</dt>
        <dd>
            <input type="text" name="ramal2" id="ramal2" value="<?= $ci->ramal2 ?>" placeholder="Ramal">
        </dd>
    </dl>
    <h3>serviços</h3>
    <dl>
        <dt>Descritivo:</dt>
        <dd class="line1 txta-h">
            <textarea name="descProduto" id="descProduto" placeholder="Descritivo de Produtos e Serviços"><?= str_replace('<br />', "\n", ($ci->descProduto)); ?></textarea>
        </dd>
        <dt>Crédito de Compra</dt>
        <dd>
            <input type="text" class="numero" value="<?=$ci->creditoCompra?>" name="creditoCompra" id="creditoCompra" placeholder="Crédito de Compra">
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="<?=($id_fornecedor > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
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
