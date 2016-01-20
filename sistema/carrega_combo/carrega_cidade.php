<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require('../includes/browser.php');

pt_register('GET','estado');
pt_register('GET','cidade');

$browser2 	= new MyBrowser();
$versao 	= $browser2 -> browser('version');
$browser 	= $browser2 -> browser('browser');

if($browser!='MSIE') $cidade = utf8_decode($cidade);

$combo = '<option value="'.$cidade.'">'.$cidade.'</option>';
if($estado<>''){
	$servicoDAO = new ServicoDAO();
	$variacoes = $servicoDAO->listaCidades($estado);
	foreach($variacoes as $s){
		$combo .= '<option value="'.$s->cidade.'">'.$s->cidade.'</option>';
	}
}	
echo $combo;

?>