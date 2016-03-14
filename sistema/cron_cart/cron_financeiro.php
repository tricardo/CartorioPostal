<?php
ini_set('max_execution_time', '0');
require("../model/Database.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");

$financeiroDAO = new FinanceiroDAO();
$financeiroDAO->replaceFinanceiroFin();
require_once("../includes/maladireta/class.Email.php");

$message = new Email('thauan.ricardo@ssiconsultoria.com.br','thauan.ricardo@ssiconsultoria.com.br','Teste',$CustomHeaders);
$message->Cc = '';
$message->SetHtmlContent('Fim com Sucesso');
$message->Send();

echo '<pre>Fim</pre>';
?>