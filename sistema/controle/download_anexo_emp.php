<?
require( "../includes/verifica_logado_controle.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require( "../includes/zip/zip.php" );


pt_register('GET','id');
$anexoDAO = new AnexoDAO();
$anexo = $anexoDAO->selectPorId($id);

if(is_null($anexo) or $controle_id_empresa!=1){
	echo 'Download bloqueado pelo servidor. Contate o administrador';
	exit;
}

$zipfile = new zipfile($controle_id_usuario.'_'.date("d-m-Y").".zip");
$arquivo = '../anexos_franquia/'.$anexo->anexo;
$zipfile->addFileAndRead($arquivo);

echo $zipfile->file();
?>