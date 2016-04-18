<?php 
#var
$carrega   = 1;
$passo     = 9;
if($_POST AND isset($_POST['f_inauguracao'])){
    $f_emp = Post_StdClass($_POST);   
    $f_emp = UTF_Encodes($f_emp,2);
    $f_emp->id_empresa = $id;
    $f_emp->passo      = $passo;
    
    $franquia->checklist_exec($f_emp);
    $franquia->checklist_exec($f_emp,0);
    $msgbox .= MsgBox();
} 
$progresso = $franquia->validar_processo($id, $passo); ?>
<form enctype="multipart/form-data" method="post" id="form10" action="<?=$link?>&opcoes_form=10">
    <h3>checklist de inauguração</h3>
    <dl>
        <table class="table1">
            <thead>
                <tr>
                    <th class="size100">
                        <input type="checkbox" name="check1" id="check1" value="1" onclick="CheckAll(this.id)">
                    </th>
                    <th>item</th>
                    <th>situacao</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $lista = UTF_Encodes($franquia->checklist($passo, 1)); 
                foreach($lista AS $f){
                    $lista1  = $franquia->checklist_edit($passo, $f->id_empresa_chk, $id); 
                    $lista1  = count($lista1) > 0 ? $lista1[0] : new stdClass();
                    $checked = (isset($lista1->ativo) AND $lista1->ativo == 1) ? ' checked="checked"' : '';
                    $data1   = (isset($lista1->data1)) ? $lista1->data1 : '';
                    $data2   = (isset($lista1->data2)) ? $lista1->data2 : '';
                    $item    = (isset($lista1->item)) ? $lista1->item : '';
                    $obs     = (isset($lista1->observacao)) ? $lista1->observacao : '';?>
                <tr>
                    <td>
                        <input <?=($progresso == 100 AND $controle_id_usuario != 1) ? 'disabled="disabled"' : ''?><?=$checked?> class="check1" type="checkbox" name="ativo<?=$f->id_empresa_chk?>" id="ativo<?=$f->id_empresa_chk?>" value="<?=$f->id_empresa_chk?>">
                    </td>
                    <td><?=$f->item?></td>
                    <td><input value="<?=$item?>" <?=($progresso == 100 AND $controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> id="item<?=$f->id_empresa_chk?>" name="item<?=$f->id_empresa_chk?>" placeholder="Situação" type="text"></td>
                </tr>
                <?php }  ?>
                <tr>
                    <td colspan="3"><strong>Progresso da Implantação:</strong></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php ProgressoBar($progresso) ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="editar &rsaquo;&rsaquo;" onclick="Validar(1)" <?=($progresso == 100 AND $controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> name="f_inauguracao">
        </div>
    </dl>
</form>
<?php if(isset($_POST['f_inauguracao'])){ ?>
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