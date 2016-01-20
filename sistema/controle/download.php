<?
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$nomeArquivo = $_SESSION['controle_nomeArquivo'];
$arquivoDiretorio = $_SESSION['controle_arquivoDiretorio'];
if(str_replace('.xls','',str_replace('.csv','',$nomeArquivo))==$controle_id_usuario){
    header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
	header("Content-Length: ".filesize($arquivoDiretorio));
	readfile($arquivoDiretorio);
	exit;
}
echo 'Download bloqueado pelo servidor. Contate o administrador';
?>