<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/funcoes.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/global.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/model/Database.php');


pt_register('GET','id_servico');
pt_register('GET','id_servico_var');


$servicoDAO = new ServicoDAO();

$lista = $servicoDAO->verificaServicoVar($id_servico_var);
$p_valor = '<option value="'.$lista->id_servico_var.'">'.char_upper(strtoupper(strtolower($lista->variacao))).'</option>';

$lista = $servicoDAO->listaVariacao($id_servico);
foreach($lista as $l){
	$p_valor .= '<option value="'.$l->id_servico_var.'">'.char_upper(strtoupper(strtolower($l->variacao))).'</option>';
}
echo $p_valor;
?>
