<?php
$arr = array('solicitante','status','id_departamento','motivo','produto','quantidade','descricao','observacao');

if($_POST AND isset($_POST['f_cadastro'])){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }

    $arr1 = array('produto','quantidade');
    for($i = 0; $i < count($arr1); $i++){
        if($$arr1[$i] == ""){
            $errors++;
            $campos.= $arr1[$i].';';
            $msgbox.= "preencha este campo!;";
        }
    }
    
    if($errors == 0){
        
        $ci = UTF_Encodes($ci, 2);
        if($id_compra > 0){
            $ci->id_compra= $id_compra;
            $compraDAO->atualizaStatus($ci,$ci->status,$controle_id_empresa);
            $msgbox .= MsgBox();
        } else {
            $compraDAO->inserir($ci);
            $msgbox .= MsgBox(2);
        }
        
    }
}
if($errors == 0){
if($id_compra > 0){
    $ci = UTF_Encodes($compraDAO->buscaPorId($id_compra,$controle_id_empresa));
} else {
    if($errors == 0){
        $ci = CriarVar($arr); 
    }
}}


switch($ci->status){
    case 'Em Aberto': $status = 'Iniciar Cotação'; break;
    default: $status = '';
} 
?>
<form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>&opcoes_form=1">
    <h3>informações da compra</h3>
    <dl>
        <dt>Solicitante:</dt>
        <dd>
            <input type="text" value="<?php echo $ci->solicitante; ?>" readonly="readonly" name="solicitante" id="solicitante" placeholder="Solicitante">
        </dd>
        <dt>Status:</dt>
        <dd>
            <input type="text" readonly="readonly" name="status" id="status" value="<?=$status?>" placeholder="Status">
        </dd>
        <dt>Departamento:</dt>
        <dd>
            <select name="id_departamento" id="id_departamento" class="chzn-select">
                <?php
                if($perm_comp == 'TRUE'){
                    echo '<option value="">Departamento</option>';
                }
                $p_valor ='';
                foreach($departamentos as $dep){
                    $p_valor .= '<option value="'.$dep->id_departamento.'"';
                    if($dep->id_departamento==$ci->id_departamento) $p_valor .= ' selected="selected" ';
                    $p_valor .= '>';
                    $p_valor .= utf8_encode($dep->departamento).'</option>';
                } 
                echo $p_valor;
                ?>
            </select>
        </dd>
        <dt>Motivo:</dt>
        <dd>
            <input type="text" name="motivo" id="motivo" value="<?=$ci->motivo ?>" placeholder="Motivo">
        </dd>
        <dt>Produto <span>*</span></dt>
        <dd>
            <input type="text" name="produto" id="produto" value="<?=$ci->produto ?>" placeholder="Produto" class="required" required>
        </dd>
        <dt>Quantidade <span>*</span>:</dt>
        <dd>
            <input type="text" name="quantidade" id="quantidade" value="<?=$ci->quantidade ?>" class="required numero" required placeholder="Quantidade">
        </dd>
        <dt>Descrição:</dt>
        <dd class="line1 txta-h">
            <textarea name="descricao" id="descricao" placeholder="Descrição"><?= str_replace('<br />', "\n", ($ci->descricao)); ?></textarea><br /><br />
        </dd>
        <dt>Observação:</dt>
        <dd class="line1 txta-h">
            <textarea name="observacao" id="observacao" placeholder="Observação"><?= str_replace('<br />', "\n", ($ci->observacao)); ?></textarea><br /><br />
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <?php if($id_compra == 0){ ?>
                <input type="submit" value="inserir &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            <?php } else if($perm_comp){
                if(strlen($status) > 0){ ?>                    
                    <input type="submit" style="width:auto" value="<?= $status ?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            <?php }   
            if($ci->status != 'Reprovada'){ ?>
                <input type="submit" value="Reprovar &rsaquo;&rsaquo;" onclick="Validar(1);$('#status').val('Reprovada');$('#form1').submit();" name="f_cadastro">
            <?php }} ?>
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