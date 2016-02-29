<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/funcoes.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/global.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/model/Database.php');

pt_register('GET','estado');
$combo = '<option value=""></option>';
if($estado<>''){
	$servicoDAO = new ServicoDAO();
	$variacoes = $servicoDAO->listaCidades($estado);
	foreach($variacoes as $s){
		$combo .= '<option value="'.$s->cidade.'">'.$s->cidade.'</option>';
	}
}	
echo $combo;

?>