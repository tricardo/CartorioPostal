<?php include('header.php'); ?>
<script>
    menu(3,'bt-01');
    $('#titulo').html('erro');
</script>
<div class="content-list-forms"></div>
<div class="content-list-table"> 
    <h3><?php
    $erro = isset($_GET['erro']) ? $_GET['erro'] : '';
    switch($erro){
        case 1: echo 'Arquivo não encontrado!'; break;
        case 2: echo 'Não existe boleto para esse relatorio!'; break;
        case 3: echo 'Falha ao criar o arquivo!'; break;
        case 4: echo 'Falha ao escrever no arquivo!'; break;
        case 5: echo 'Voce deve selecionar pelo menos um pedido para prosseguir com a sua busca!'; break;
        case 6: echo 'Boleto não encontrado!'; break;
        default: echo 'Você não tem permissão para acessar essa página!';
    } ?></h3>
    
    <div class="content-forms no-forms">
        <form enctype="multipart/form-data" method="post" id="form1">
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="javascript:history.go(-1)" style="margin-left: -80px">
            </div>
        </form>
    </div>
    
</div>
<?php include('footer.php'); ?>