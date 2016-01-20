<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_cli.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require( "../includes/zip/zip.php" );


pt_register('GET','id');
$num_ane_a = 0;
$num_ane   = 0;

$sql_ane = "select pa.anexo from vsites_pedido_anexo as pa, vsites_pedido_item as pi, vsites_pedido as p where pa.id_pedido_item='".$id."' and (pa.anexo_nome='Certidгo' or pa.anexo_nome='Declaraзгo de Busca' or pa.anexo_nome='Declaraзгo de Busca de Imуveis' or pa.anexo_nome='Instrumento de Protesto' or pa.anexo_nome='Documento do Cliente') and pa.id_pedido_item = pi.id_pedido_item and pi.id_pedido=p.id_pedido and p.id_pedido='".$cliente_login."' and md5(concat(p.id_pedido,p.data)) like '".$cliente_senha."%'";
$query_ane = $objQuery->SQLQuery($sql_ane);
$num_ane = mysql_num_rows($query_ane);
if($num_ane==0){
	echo 'Download bloqueado pelo servidor. Contate o administrador';
	exit;
}

$zipfile = new zipfile($conveniado_id_conveniado.'_'.date("d-m-Y").".zip");

while($res_ane = mysql_fetch_array($query_ane)){
	
	$pos = strrpos($res_ane['anexo'], "../");#alterado
	$file_path = $res_ane['anexo'];#alterado
	if ($pos === false) { $file_path = "../anexos/".$res_ane['anexo']; }#alterado
	$arquivo = $file_path;
	$zipfile->addFileAndRead($arquivo);
	
}
echo $zipfile->file();
?>