<? 
header("Content-Type: text/html; charset=utf-8", true);
ini_set("session.cache_expire",3600);
session_start();
if(isset($_GET['estado'])){
	include('funcoes.php');
	#require('phpQuery/phpQuery/phpQuery.php');
	include('webservice-cep/phpQuery-onefile.php');
	$teste = new TesteDAO();
	$teste->faixa_cep($_GET['estado']);
}
?>
