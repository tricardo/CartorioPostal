<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
include_once( "../includes/verifica_logado_conveniado.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require( "../includes/zip/zip.php" );

$acao = 2;
pt_register('GET','id');
pt_register('GET','id_sercod');
pt_register('GET','id_ser');

$dt = new stdClass();
$dt->acao=$acao;
$dt->id=$id;
$dt->conveniado_id_cliente=$conveniado_id_cliente;
$dt->id_ser=$id_ser;

$ConveniadoDAO = new ConveniadoDAO();
$conveniado    = $ConveniadoDAO->Download($dt);

if(count($conveniado) > 0){
	$zipfile = new zipfile($conveniado_id_conveniado.'_'.date("d-m-Y").".zip");
	foreach($conveniado as $c => $conv){
		$pos = strrpos($conv->anexo, "../");#alterado
		$file_path = $conv->anexo;#alterado
		if ($pos === false) { $file_path = "../anexos/".$conv->anexo; }#alterado
		$arquivo = $file_path;
		$zipfile->addFileAndRead($arquivo);
		if($acao == 2){
			$certidao_cnpj = $conv->certidao_cnpj;
			$certidao_cpf = $conv->certidao_cpf;
			$certidao_devedor = $conv->certidao_devedor;
		}
	}
	echo $zipfile->file();
}  else {
	echo 'Download bloqueado pelo servidor. Contate o administrador';
	exit;
}
?>