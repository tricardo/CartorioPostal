<?php
pt_register('GET','id_empresa_upl');
$id_empresa_upl = isset($id_empresa_upl) ? $id_empresa_upl : 0;
$send           = 0;
$fld            = date('Y-m-d') <= $data_init_cp ? 'uploads/' : '../sistema/uploads/';

if($id_empresa_upl > 0 AND count($_FILES) == 0){
    $franquia->upload_empresa(3,$id,$controle_id_usuario,$id_empresa_upl);
    $msgbox .= MsgBox(3);
    $send = 1;
}

if($_FILES AND isset($opcoes_form) AND $opcoes_form == 3){
    $send = 1;
    if(isset($_FILES['arquivo'])){
        $err = ErrorFiles($_FILES['arquivo']['error']);
        if(!is_numeric($err)){
            $errors++;
            $campos.= 'arquivo;';
            $msgbox.= $err.";";
        } else {
            $ext  = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
            $nome = md5(date('YmdHis')).'.'.$ext;
            $err  = ExtensaoOk($ext);
            if(!is_numeric($err)){
                $errors++;
                $campos.= 'arquivo;';
                $msgbox.= $err.";";
            } else {
                if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $fld.$nome)){
                    $franquia->upload_empresa(1,$id,$controle_id_usuario,$nome);
                    $msgbox .= MsgBox(2);
                } else {
                    $errors++;
                    $campos.= 'arquivo;';
                    $msgbox.= "O arquivo não pode ser salvo!;";
                }
            }
        }
    } else {
            $err = ErrorFiles(4);
            $errors++;
            $campos.= 'arquivo;';
            $msgbox.= $err.";";
    }

}
?>
<form enctype="multipart/form-data" method="post" id="form3" aaction="<?=$link?>&opcoes_form=3">
    <h3>contratos</h3>
    <dl>
        <dt>Arquivo <span>*</span> :</dt>
        <dd class="line1">
            <input type="file" class="required" name="arquivo" id="arquivo" required placeholder="Arquivo {.doc, .xls, .pdf, .png, .jpg, .jpeg e .gif}">
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="editar &rsaquo;&rsaquo;" onclick="Validar(1)">
        </div>
    </dl>
    <?php 
    $listar = $franquia->upload_empresa(2,$id,0,'');
    if(count($listar) > 0){ ?>
    <h3>Histórico de Arquivos</h3>
    <dl class="box">
        <table class="table1">
            <thead>
                <tr>
                    <th class="size100">data</th>
                    <th>usuário</th>
                    <th>arquivo</th>
                    <?php
                    $exc_arq = in_array(4, $departamento_s) || in_array(1, $departamento_s) ? 1 : 0;
                    if($exc_arq == 1) { ?>
                        <th class="size100 size50">&nbsp;</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';

		foreach($listar AS $f){ 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                        <td class="size100"><?=invert($f->data, '/', 'PHP') ?></td>
                        <td><?=utf8_encode($f->nome)?></td>
                        <td><a href="<?=$fld.$f->arquivo?>" target="_blank"><?=$f->arquivo?></a></td>
                        <?php if($exc_arq == 1) { ?>
                            <td class="size100 size50">
                                <a href="<?=$link?>&opcoes_form=3&id_empresa_upl=<?=$f->id_empresa_upl?>">
                                    <img src="images/bt-del.png">
                                </a>
                            </td>
                        <?php } ?>
                    </tr>
		<?php } ?>
            </tbody>
        </table>
    </dl>
    <?php } ?>
</form>
<?php if($send == 1 AND isset($opcoes_form) AND $opcoes_form == 3){ ?>
    <div class="msgbox">
        <div class="panel"><a href="#" onclick="$('.msgbox').hide()">fechar X</a></div>
        <div class="text"></div>
    </div>
    <script>
        BoxMsg(1,<?=$errors?>,'<?=$campos?>','<?=$msgbox?>');
    </script>
<?php
}
$errors=0;
$campos='';
$msgbox='';
?>