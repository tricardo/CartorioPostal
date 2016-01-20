<?php
ob_start();
require( "../includes/funcoes.php" );
require( "../includes/verifica_logado_controle.inc.php" );
require( "../includes/global.inc.php" );

require('../includes/dias_uteis.php');

echo date("d/m/Y",strtotime(somar_dias_uteis(date("Y-m-d"),$_GET['dias'])));
?>