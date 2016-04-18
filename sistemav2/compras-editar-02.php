<?php
$arr = array('id_fornecedor','valor');

if($_POST AND isset($_POST['f_proposta'])){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }

    $arr1 = array('id_fornecedor','valor');
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
            $compraDAO->atualizar($ci);
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

?>
<form enctype="multipart/form-data" method="post" id="form2" action="<?=$link?>&opcoes_form=2">
    <h3>propostas</h3>
    <dl>
        <dt>Solicitante:</dt>
        <dd>
            
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="inserir &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_proposta">          
        </div>
    </dl>
    

    <?php $pedido = array();
    $color = '#FFFEEE';
    if($id_compra > 0){ ?>
    <h3>Propostas</h3>
    <dl class="box">
        <table class="table1">
                <thead>
                    <tr>
                        <th>Fornecedor</th>
                        <th class="size">&nbsp;</th>
                        <th class="size100">Valor (R$)</th>
                        <th class="size">Arquivo</th>
                    </tr>
                </thead>
                <?php

                if(count($pedido) > 0){ ?>
                <tbody>
                    <?php 
                    foreach($pedido as $ped => $p){ 
                        $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';?>
                        <tr <?=TRColor($color)?>>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>  
                    <?php } ?>
                    </tbody>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="nullable">Nenhuma proposta encontrada</td>
                    </tr>
                <?php } ?>
        </table>
    </dl>
    <?php } ?>
</form>
<?php if(isset($_POST['f_proposta'])){ ?>
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