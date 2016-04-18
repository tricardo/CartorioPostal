<?php include('header.php'); 


?>

<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; pedidos &rsaquo;&rsaquo; editar');
    $('#sub-18').css({'font-weight':'bold'});
</script>
<div class="content-list-forms"></div>
<div class="content-list-table">   
    <h3>
        <p>No momento esta página encontra-se em construção.</p>
        <p>Solicitamos que volte em breve ou aguarde atualização do sistema informando o funcionamento desta página.</p>
        <p>Até que esta página seja concluída, utilize o sistema antigo <a href="../sistema/controle/pedido_edit.php?id=<?=$_GET['id']?>&ordem=<?=$_GET['ordem']?>" target="_blank">clicando aqui.</a></p>
    </h3>
</div>
<?php include('footer.php'); ?>