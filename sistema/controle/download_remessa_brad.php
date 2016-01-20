<?
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require( "../includes/verifica_logado_controle.inc.php" );


pt_register('GET','id');
$contaDAO = new ContaDAO();
$arq = $contaDAO->selectArquivoPorId($id,$controle_id_empresa);

if(is_null($arq)){
	echo 'Download bloqueado pelo servidor. Contate o administrador';
	exit;
}

$arquivo = '../boletos/'.$arq->arquivo;

header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=".str_replace('../boletos/remessabradesco/','',$arq->arquivo).";");
header("Content-Length: ".filesize($arq->arquivo));
readfile($arq->arquivo);

?>