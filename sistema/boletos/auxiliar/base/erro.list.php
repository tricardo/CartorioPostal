<?php if(isset($erros)) { ?>
<div class="erro">
        <?php foreach($erros as $erro) {?>
            <?php echo utf8_decode($erro) ?><br/>
        <?php } ?>
</div>
<?php }if(isset($alertas)) { ?>
<div class="alerta">
        <?php foreach($alertas as $alerta) {?>
            <?php echo utf8_decode($alerta); ?><br/>
        <?php } ?>
</div>
<?php }if(isset($mensagens) && count($mensagens)>0) { ?>
<div class="sucesso">
        <?php foreach($mensagens as $mensagem) { ?>
            <?php echo utf8_decode($mensagem)?><br/>
        <?php } ?>
</div>
<?php } ?>
