<?
require( "../includes/verifica_logado_controle.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require( "../includes/zip/zip.php" );


pt_register('GET','id_remessa_cart');

$remessaDAO = new RemessaCartDAO();
$arq = $remessaDAO->selectPorId($id_remessa_cart,$controle_id_empresa);

if(is_null($arq)){
	echo 'Download bloqueado pelo servidor. Contate o administrador';
	exit;
}

$zipfile = new zipfile($controle_id_usuario.'_'.date("d-m-Y").".zip");

$arquivo = 'remessa_cart/'.$arq->arquivo;
$zipfile->addFileAndRead($arquivo);

echo $zipfile->file();
?>