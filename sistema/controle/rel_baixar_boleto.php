<?
require("../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('GET','id');
$contaDAO = new ContaDAO();
$b_id = $contaDAO->selectBoletosBradRoy($id,$controle_id_empresa);
if($id=='' or $b_id->id_conta_fatura=='') {
	echo '<h1>Não existe boleto para esse relatorio!</h1>';
	exit;
}
$id = $b_id->id_conta_fatura;
$b = $contaDAO->selectBoletosBradPorId($id,'1');

require( "../boletos/gerabradescobrad.php" );
?>