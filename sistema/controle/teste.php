<?
ob_start();
require("../includes/funcoes.php"); 
require("../includes/global.inc.php");
require_once('../model/Database.php');


$box = new ReceiveImapDAO('suporte+cartoriopostal.com.br','a123d321','suporte@cartoriopostal.com.br', 'mail.cartoriopostal.com.br',
	'imap', '143/novalidate-cert', false);

$box->connect();
$total = $box->total();

for($i = 1; $i <= $total; $i++){
	$box->headers($i);
	echo $box->mail_header();
	echo $box->mail_body_strip_tags();
	#echo $box->body;
}

$box->disconnect(); ?>