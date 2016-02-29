<?
header("Content-Type: text/html; charset=ISO-8859-1",true);

require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/funcoes.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/global.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/model/Database.php');
pt_register('GET','cidade');
pt_register('GET','estado');

$servicoDAO = new ServicoDAO();
$lista = $servicoDAO->listaCidades($estado);
$p_valor = '<option value="">Selecione sua cidade</option>';
foreach($lista as $l){
	$cidade = RemoveAcentos($l->cidade);
	$p_valor .= '<option value="'.$cidade.'">'.$l->cidade.'</option>';
}
echo $p_valor;
?>