<?
header("Content-Type: text/html; charset=ISO-8859-1",true);

require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/funcoes.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/global.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/model/Database.php');


pt_register('GET','cidade');
pt_register('GET','estado');
pt_register('GET','bairro');

$servicoDAO = new ServicoDAO();
$lista = $servicoDAO->listaBairrosFranquia($estado,$cidade);
$p_valor = '<option value="">Selecione seu bairro</option>';
foreach($lista as $l){
	$bairro = RemoveAcentos($l->bairro);
	if($l->apelido<>'')$bairro=$l->apelido; else $bairro=$l->bairro;
	$p_valor .= '<option value="'.$bairro.'">'.$bairro.'</option>';
}
$p_valor .= '<option value="">Outros</option>';
echo $p_valor;
?>