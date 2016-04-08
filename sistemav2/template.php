<?php
include('header.php');
echo "<script>
     menu(3,'bt-".$bt."');
    $('#titulo').html(".$titulo.");
    $('#sub-".$pagina['sub']."').css({'font-weight':'bold'});
    </script>";
echo '
    <div class="content-list-forms"></div>
        <div class="content-list-table"> 
        <h3>'.$h3.'</h3>
        <div class="content-forms no-forms">
            <form enctype="multipart/form-data" method="post" id="form1">
                <div class="buttons">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="javascript:history.go(-1)" style="margin-left: -80px">
                </div>
            </form>
        </div>
    </div>';
include('footer.php'); 