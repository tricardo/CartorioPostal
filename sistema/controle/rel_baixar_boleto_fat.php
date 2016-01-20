<?
require("../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('GET','id');
$contaDAO = new ContaDAO();
$b_id_fat = $contaDAO->selectBoletosBradFat($id,$controle_id_empresa);
if($id=='' or $b_id_fat[0]->id_fatura) {
	echo '<h1>Não existe boleto para esse boleto!</h1>';
	exit;
}

foreach($b_id_fat as $b_id){
	$id = $b_id->id_conta_fatura;
	$b = $contaDAO->selectBoletosBradPorId($id,'1');

	require( "../boletos/gerabradescobrad.php" );
}
?>