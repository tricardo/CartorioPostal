<? 
header("Content-Type: text/html; charset=ISO-8859-1",true); 
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/funcoes.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/global.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/model/Database.php');


$siteDAO = new SiteDAO();
pt_register('POST','nome');
pt_register('POST','email');
pt_register('POST','mensagem');
$nome 		= utf8_decode($nome);
$email 		= utf8_decode($email);
$assunto	= utf8_decode($mensagem);

$d->nome 		= $nome;
$d->email		= $email;
$d->assunto 	= $assunto;
if($nome=='' or $assunto=="" or $email==""){
	echo 'Preencha os dados corretamente';
} else {
	$siteDAO->inserirImprensa($d);

	$msg .= "<b>Nome:</b> ".$nome."<br>";
	$msg .= "<b>Email:</b> ".$email."<br>";
	$msg .= "<b>Assunto:</b> ".$assunto."<br>";
	
	mail("imprensa@cartoriopostal.com.br","Assessor: Cartório Postal",$msg,"from: ".$email."\nContent-type: text/html\n");
	mail("ti@cartoriopostal.com.br","Assessor: Cartório Postal",$msg,"from: ".$email."\nContent-type: text/html\n");
	
	echo 1;
}
?>