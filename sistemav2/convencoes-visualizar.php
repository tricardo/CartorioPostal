<?php include('header.php'); 
pt_register('GET','id_convencao');
$id_convencao = isset($id_convencao) ? $id_convencao : 1; ?>
<script>
    menu(3,'bt-01');
    $('#titulo').html('inciar &rsaquo;&rsaquo; convenções  &rsaquo;&rsaquo; <a href="convencoes.php" id="voltar">listar</a>');
    $('#sub-49').css({'font-weight':'bold'});
</script>
<?php
switch($id_convencao){
    case 1: ?>
    <div class="content-galeria">
    <?php $p = 'convencoes/1-convencao-estadual-sp/';
    foreach(listar_arquivos($p) AS $f){
        echo '<a href="'.$p.$f['id'].'" title="Clique aqui" rel="shadowbox[vocation]"><img src="'.$p.$f['id'].'"></a>';
    } ?>
    </div>
    <?php break; ?>

<?php 
} ?>
<div class="content-forms no-forms">
    <form enctype="multipart/form-data" method="post" id="form1">
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
        </div>
    </form>
</div>
<?php include('footer.php'); ?>