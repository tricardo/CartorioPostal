<? 
header("Content-Type: text/html; charset=utf-8", true);
ini_set("session.cache_expire",3600);
session_start();
if(isset($_GET['id'])){
	include('funcoes.php');
	$conselho = new ConselhoDAO();
	$conselho->apuracao($_GET['id']);
}
?>
