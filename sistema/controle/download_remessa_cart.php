<?
require( "../includes/funcoes.php" );
require( "../includes/verifica_logado_controle.inc.php" );
require( "../includes/global.inc.php" );
require( "../includes/zip/zip.php" );

$remessaDAO = new RemessaCartDAO();
pt_register('GET','id_remessa_cart');

$anexo = $remessaDAO->selectPorId($id_remessa_cart,$controle_id_empresa);
if(is_null($anexo)){
	echo 'Download bloqueado pelo servidor. Contate o administrador';
	exit;
}

$zipfile = new zipfile($controle_id_usuario.'_'.date("d-m-Y").".zip");

$arquivo = 'remessa_cart/'.$anexo->arquivo;
$zipfile->addFileAndRead($arquivo);

echo $zipfile->file();
?>