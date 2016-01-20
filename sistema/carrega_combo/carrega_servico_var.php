<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
$acesso_conv='ok';
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
pt_register('GET','id_servico');
pt_register('GET','id_servico_var');

// Pesquisa ID localidade-----------------------------------
$servicoDAO = new ServicoDAO();
$variacoes = $servicoDAO->listaVariacao($id_servico);
$combo_1 = '<option ></option>';
$combo='';
foreach($variacoes as $s){
	$combo .= '<option value="'.$s->id_servico_var.'">'.$s->variacao.'</option>';
	if($s->id_servico_var==$id_servico_var) $combo_1 = '<option value="'.$s->id_servico_var.'">'.$s->variacao.'</option>';
}
echo $combo_1.$combo;
?>
