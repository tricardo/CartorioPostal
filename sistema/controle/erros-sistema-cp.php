<?php

require_once( '../includes/classQuery.php' );
require_once('../model/Database.php');

$teste = new Teste2DAO();
$teste->selectEmpresaCEP('36240-000');

?>
