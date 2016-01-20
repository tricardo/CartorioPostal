<?
require( "../includes/funcoes.php" );
require( "../includes/verifica_logado_controle.inc.php" );
require( "../includes/global.inc.php" );
require( "../includes/zip/zip.php" );

$retornoDAO = new RetornoDAO();
pt_register('GET','id_retorno');

$arq = $retornoDAO->selectPorId($id_retorno,$controle_id_empresa);

if(is_null($arq)){
	echo 'Download bloqueado pelo servidor. Contate o administrador';
	exit;
}

$zipfile = new zipfile($controle_id_usuario.'_'.date("d-m-Y").".zip");

$arquivo = 'exporta/retorno/'.$arq->arquivo;
$zipfile->addFileAndRead($arquivo);

echo $zipfile->file();
?>