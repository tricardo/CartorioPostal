<?
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$nomeArquivo = 'intellibrary.exe';
$arquivoDiretorio = '../downloads/';
if($controle_id_empresa<>''){
	header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
	header("Content-Length: ".filesize($arquivoDiretorio));
	readfile($arquivoDiretorio);	
	exit;
}
echo 'Download bloqueado pelo servidor. Contate o administrador';
?>