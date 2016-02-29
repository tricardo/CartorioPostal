<?
define('DB_PREFIXO','s_');
$uri = 'http://www.cartoriopostal.com.br/certidoes/';
	$url = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL']));
	$url = $url . '://' . $_SERVER['HTTP_HOST'];
	$pos = strpos($url,'localhost');
	if($pos > 0) { $uri = 'http://localhost/certidoes/'; }
define('URL_SITE',$uri);
define('URL_SITE_INCLUDE',$_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/');
define('URL_SITE_MODEL',$_SERVER['DOCUMENT_ROOT'].'/certidoes/model/');
define('URL_BASE',$_SERVER['DOCUMENT_ROOT'].'/certidoes/');
define('URL_IMAGES',$uri.'images/');
define('URL_UPLOAD',$uri.'upload/');
define('URL_COD','public_html/');
$url = 'certidoes';

$hot = 'http://www.cartoriopostal.com.br/';
	$url_h = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL']));
	$url_h = $url_h . '://' . $_SERVER['HTTP_HOST'];
	$pos = strpos($url_h,'localhost');
	if($pos > 0) { $hot = 'http://localhost/'; }
define('URL_SITE_H',$hot);
define('URL_COD','public_html/');
$url_h = '';
?>