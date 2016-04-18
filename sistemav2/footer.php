    <?php if($show_msgbox == 1){ ?>
        <div class="msgbox">
            <div class="panel"><a href="#" onclick="$('.msgbox').hide()">fechar X</a></div>
            <div class="text"></div>
        </div>
        <script>
            BoxMsg(<?=($_POST || defined('MSGBOX')) ? 1 : 0?>,<?=$errors?>,'<?=$campos?>','<?=$msgbox?>');
        </script>   
    <?php } 
    if(isset($big_msg_box) AND strlen($big_msg_box) > 0){?>
        <div class="msgbox">
            <div class="panel"><a href="#" onclick="$('.msgbox').hide()">fechar X</a></div>
            <div class="text" <?=isset($big_msg_box_color) ? '' : ''?>><?=$big_msg_box?></div>
        </div>
        <script>
            setTimeout("$('.msgbox').hide();", 10000);
        </script>  
    <?php } ?>
    <div class="ajax"></div>
    <script>
        AddButtonPageEdit();
        DivAddRegistro('<?=$navegador?>');
    </script>
</body>
</html>