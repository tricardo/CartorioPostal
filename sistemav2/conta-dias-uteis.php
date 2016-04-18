<?php
require("includes/verifica_logado_controle.inc-ajax.php");         
require('includes/dias_uteis.php');

$dias = (isset($_POST['dias']) AND is_numeric($_POST['dias'])) ? $_POST['dias'] : 0;

?><script>$('#data_posdias').val('<?=date("d/m/Y",strtotime(somar_dias_uteis(date("Y-m-d"),$dias)));?>')</script> 