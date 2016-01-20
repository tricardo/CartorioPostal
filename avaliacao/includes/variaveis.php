<?
ob_start();
session_start();
$sessao = session_id();
$ip = $_SERVER['REMOTE_ADDR'];
define ('URL_SITE','/avaliacao/');
define ('URL_IMAGES','/avaliacao/images/');
define ('URL_SITE_LINK',URL_SITE);
?>