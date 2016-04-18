<?php 
#var
$carrega   = 1;
$passo     = 11; 
$lista     = $franquia->checklist_valida($passo, $id);
$progresso = $lista[0] == 1 ? 100 : 99;
?>
<form enctype="multipart/form-data" method="post" id="form12" action="<?=$link?>&opcoes_form=12">
    <h3>inauguração</h3>
    <dl>
        <table class="table1">
            <tbody>
                <tr>
                    <td class="active"><?=  utf8_encode($lista[1])?></td>
                </tr>
 
                <tr>
                    <td><strong>Progresso da Implantação:</strong></td>
                </tr>
                <tr>
                    <td>
                        <?php ProgressoBar($progresso) ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
        </div>
    </dl>
</form>
<?php if(isset($_POST['f_inicio_ativ'])){ ?>
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