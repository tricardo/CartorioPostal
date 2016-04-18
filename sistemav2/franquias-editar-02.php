<?php 
#var
$f_emp     = new stdClass();
if($_POST AND isset($_POST['f_correio'])){
    $f_emp = Post_StdClass($_POST);
    $cp = array('id_fichacorreio','quantidade');
    for($i = 0; $i < count($cp); $i++){
        if($f_emp->$cp[$i] == ""){
            $errors++;
            $campos.= $cp[$i].';';
            $msgbox.= "preencha este campo!;";
        }
    }  
    
    if($errors == 0) {
        $correioDAO->inserirFichaCorreio($id, $controle_id_usuario, $emp->id_fichacorreio, $emp->quantidade);
        $msgbox .= MsgBox();
    }
} ?>
<form enctype="multipart/form-data" method="post" id="form2" action="<?=$link?>" onsubmit="$('#form2').attr('action', $('#form2').attr('action')+'&opcoes_form=2'">
    <h3>ficha dos correios</h3>
    <dl>
        <dt>Tipo de Ficha <span>*</span> :</dt>
        <dd>
            <select name="id_fichacorreio"id="id_fichacorreio" class="chzn-select required">
                <option value="">Tipo de Ficha</option>
                <?php
                $p_valor = "";
                $lista = UTF_Encodes($correioDAO->listarTipoFicha());
                foreach ($lista as $l) {
                    $p_valor .='<option value="' . $l->id_fichacorreio . '" ';
                    if ($emp->id_fichacorreio == $l->id_fichacorreio) $p_valor .= ' selected ';
                    $p_valor .= '>' . $l->fichacorreio . '</option>';
                }
                echo $p_valor; ?>
            </select>
        </dd>
        <dt>Quantidade <span>*</span>:</dt>
        <dd>
            <input type="text" class="numero" id="quantidade" name="quantidade" value="<?=isset($emp->quantidade) ? $emp->quantidade : '' ?>" required placeholder="Quantidade">
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="editar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_correio">
        </div>
    </dl>
    <?php
    $listar = $correioDAO->listarFicha($id); 
    if(count($listar) > 0){ ?>
    <h3>Histórico de Fichas</h3>
    <dl class="box">
        <table class="table1">
            <thead>
                <tr>
                    <th class="size100">data</th>
                    <th>tipo de ficha</th>
                    <th class="size100">quantidade</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
		foreach($listar AS $f){ 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                        <td class="size100"><?=invert($f->data, '/', 'PHP') ?></td>
                        <td><?=utf8_encode($f->fichacorreio)?></td>
                        <td class="size100"><?=$f->quantidade?></td>
                    </tr>
		<?php } ?>
            </tbody>
        </table>
    </dl>
    <?php } ?>
</form>
<?php if(isset($_POST['f_correio'])){ ?>
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