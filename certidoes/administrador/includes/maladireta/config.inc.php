<?

// Informa��o Mysql

$dirpath='http://localhost/maladireta/';

$subokpath='http://localhost/maladireta/obrigado.html'; // P�gina mostrada ap�s o usu�rio se inscrever no mailing.


$time_interval=0; // Intervalo em segundos para emails consecutivos

$defaultname="usuario"; // Nome padr�o para usu�rio que se inscrever apenas com email, sem inserir o nome.


$confirm_subscription=0;   // 1/0 para  ON/OFF do email de confirma��o. Edite o arquivo confirm.inc.php para as configura��es do email.

$default_editor=1;         // 1 para editor WYSIWYG-HTML e 0 para editor manual.


?><?

// CONFIGURA��ES AVAN�ADAS
// SOMENTE EDITE SE SOUBER O QUE EST� FAZENDO, N�O H� NECESSIDADE DE ALTERA��O

$tableprefix="";
$mailserver_type=0;



?><?

include_once("../includes/maladireta/script.inc.php");


?>