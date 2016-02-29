<?

// Informação Mysql

$dirpath='http://localhost/maladireta/';

$subokpath='http://localhost/maladireta/obrigado.html'; // Página mostrada após o usuário se inscrever no mailing.


$time_interval=0; // Intervalo em segundos para emails consecutivos

$defaultname="usuario"; // Nome padrão para usuário que se inscrever apenas com email, sem inserir o nome.


$confirm_subscription=0;   // 1/0 para  ON/OFF do email de confirmação. Edite o arquivo confirm.inc.php para as configurações do email.

$default_editor=1;         // 1 para editor WYSIWYG-HTML e 0 para editor manual.


?><?

// CONFIGURAÇÕES AVANÇADAS
// SOMENTE EDITE SE SOUBER O QUE ESTÁ FAZENDO, NÃO HÁ NECESSIDADE DE ALTERAÇÃO

$tableprefix="";
$mailserver_type=0;



?><?

include_once("../includes/maladireta/script.inc.php");


?>