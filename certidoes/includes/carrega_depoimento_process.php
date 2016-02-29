<? 
header("Content-Type: text/html; charset=ISO-8859-1",true); 
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/funcoes.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/global.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/model/Database.php');


$siteDAO = new SiteDAO();
pt_register('POST','nome');
pt_register('POST','email');
pt_register('POST','depoimento');
pt_register('POST','id_empresa');
$nome 		= utf8_decode($nome);
$email 		= utf8_decode($email);
$depoimento	= utf8_decode($depoimento);

$d->nome 		= $nome;
$d->email		= $email;
$d->depoimento 	= $depoimento;
$d->id_empresa 	= $id_empresa;
if($nome=='' or $depoimento==""){
	echo 'Preencha os dados corretamente';
} else {
	if($id_empresa=='')
		$siteDAO->inserirDepoimento($d);
	else
		$siteDAO->inserirDepoimentoFranquia($d);
	mail("erick@canaldosprofissionais.com.br","Depoimento: Cartório Postal",$depoimento,"from: ".$email."\nContent-type: text/html\n");
	
	echo 1;
}
?>