<?php 
#var
$carrega   = 1;

if($_POST AND isset($_POST['f_franqueado'])){
    $f_emp = Post_StdClass($_POST);   
    $f_emp = UTF_Encodes($f_emp,2);
    $f_emp->id_empresa = $id;
    $f_emp->cep1    = $f_emp->cep1;
    $f_emp->bairro1 = $f_emp->bairro1;
    $f_emp->cidade1 = $f_emp->cidade1;
    $f_emp->uf1     = $f_emp->uf1;
    
    $franquia->empresa_implantacao($f_emp);
    $msgbox .= MsgBox();
} 
if($carrega == 1 AND $id > 0){
    $emp = $franquia->listar(5, $id);
    $emp = count($emp) > 0 ? UTF_Encodes($emp[0]) : new stdClass();
} ?>
<form enctype="multipart/form-data" method="post" id="form4" action="<?=$link?>&opcoes_form=4">
    <h3>informações do franqueado</h3>
    <dl>
        <dt>Franqueado:</dt>
        <dd class="line1">
            <input type="text" id="franqueado" name="franqueado" placeholder="Franqueado" value="<?=$emp->franqueado?>">
        </dd>
        <dt>E-mail:</dt>
        <dd class="line1">
            <input type="text" id="email" name="email" placeholder="E-mail" class="email" value="<?=$emp->email?>">
        </dd>
        <dt>Endereço:</dt>
        <dd class="line1">
            <input type="text" id="endereco" name="endereco" value="<?=$emp->endereco?>" placeholder="Endereço">
        </dd>
        <dt>Núm.:</dt>
        <dd>
            <input type="text" id="numero" name="numero" value="<?=$emp->numero?>">
        </dd>
        <dt>Compl.:</dt>
        <dd>
            <input type="text" id="complemento" name="complemento" placeholder="Complemento" value="<?=$emp->complemento?>">
        </dd>
        <dt>CEP:</dt>
        <dd>
            <input type="text" id="cep1" name="cep1" placeholder="CEP" value="<?=$emp->cep?>" onkeyup="BuscaCep(this.id, 1, '1')">
        </dd>
        <dt>Bairro:</dt>
        <dd>
            <input type="text" id="bairro1" name="bairro1" value="<?=$emp->bairro?>" placeholder="Bairro">	
        </dd>        
        <dt>Cidade:</dt>
        <dd>
            <input type="text" id="cidade1" name="cidade1" value="<?=$emp->cidade?>" placeholder="Cidade">	
        </dd>
         <dt>Estado:</dt>
        <dd>
            <select class="chzn-select" name="uf1" id="uf1">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $emp->uf) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
            </select>
        </dd>
        <dt>Telefone:</dt>
        <dd>
            <input type="text" id="telefone1" name="telefone1" value="<?=$emp->telefone1?>" placeholder="Telefone 1" class="fone">
        </dd>
        <dt>Telefone:</dt>
        <dd>
            <input type="text" id="telefone2" name="telefone2" value="<?=$emp->telefone2?>" placeholder="Telefone 2" class="fone">
            <input type="hidden" id="atendente" name="atendente" value="0">
        </dd>
        <dt>Consultor Comercial:</dt>
        <dd>
            <select id="id_consultor1" name="id_consultor1" class="chzn-select">
		<option value="0">Comercial</option>
		<?php $lista = UTF_Encodes($franquia->getQntUsuarios(3, 0, 0)); 
		foreach ($lista as $f) { ?>
                    <option value="<?=$f->id_usuario?>" <?=($f->id_usuario == $emp->id_consultor1) ?'selected="selected"':''?>><?=ucwords(strtolower($f->nome))?></option>
		<?php } ?>
            </select>
        </dd>
        <dt>Consultor Venda:</dt>
        <dd>
            <select id="id_consultor2" name="id_consultor2" class="chzn-select">
		<option value="0">Venda</option>
		<?php $lista = UTF_Encodes($franquia->getQntUsuarios(3, 0, 0)); 
		foreach ($lista as $f) { ?>
                    <option value="<?=$f->id_usuario?>" <?=($f->id_usuario == $emp->id_consultor2) ?'selected="selected"':''?>><?=ucwords(strtolower($f->nome))?></option>
		<?php } ?>
            </select>
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="editar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_franqueado">
        </div>
    </dl>
</form>
<?php if(isset($_POST['f_franqueado'])){ ?>
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