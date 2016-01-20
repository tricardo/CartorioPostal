<?
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

if($controle_id_empresa<>''){
	// SEPARA A STRING DE SAIDA POR ESPACO EM BRANCO
	pt_register('POST','macs');
	$sql = $objQuery->SQLQuery("insert into vsites_rede(id_empresa,id_usuario,mac) values ('".$controle_id_empresa."','".$controle_id_usuario."','".$macs."')");
}
?>