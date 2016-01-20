<?
require_once( "variaveis.php" );
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
require( "includes/funcoes.php" );
require( "includes/global.inc.php" );
require( "includes/classQuery.php" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?
	require_once('meta_tag.php');
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="shortcut icon" href="<?= URL_SITE ?>images/icone.gif" />
	<link href="<?= URL_SITE ?>css/style.css" rel="stylesheet" type="text/css" />
	<link href="<?= URL_SITE ?>css/popup.css" rel="stylesheet" type="text/css" />
	<link href="<?= URL_SITE ?>css/jtable.css" rel="stylesheet" type="text/css" />
	<link href="<?= URL_SITE ?>css/jphotogrid.css" rel="stylesheet" type="text/css" media="screen" /> 
	<!--[if IE]>
		<link href="<?= URL_SITE ?>css/jphotogrid.ie.css" rel="stylesheet" type="text/css" media="screen" />
	<![endif]--> 
	<script type="text/javascript" src="<?= URL_SITE ?>js/js.js"></script>
	<script type="text/javascript" src="<?= URL_SITE ?>js/ajax.js"></script>
	<script type="text/javascript" src="<?= URL_SITE ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?= URL_SITE ?>js/jcirculo/jquery.min.js"></script>
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
	  {lang: 'pt-BR'}
	</script>
	<!--dock fish menu -->
	<? 
	#somente na pagina inicial
	if($pg==''){
	?>
		<!-- slide show --> 
		<link rel="stylesheet" href="<?= URL_SITE ?>css/coin-slider-styles.css" type="text/css">
		<script type="text/javascript" src="<?= URL_SITE ?>js/coin-slider.min.js"></script>
		<script>
		$(document).ready(function(){
			$('#banner_home').coinslider({ width:668,height:189,hoverPause: true });
		});
		</script>
	<?
	}
	?>
	<!-- Organização de tabelas -->
	<script type="text/javascript" src="<?= URL_SITE ?>js/jtable/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="<?= URL_SITE ?>js/jtable/jquery.tablesorter.pager.js" ></script>
	<!-- Galeria de fotos -->
	<script src="<?= URL_SITE ?>js/jgaleria/jphotogrid.js"></script>
	<script src="<?= URL_SITE ?>js/jgaleria/setup.js"></script>
	<!--dock menu JS options -->
	<script type="text/javascript" src="<?= URL_SITE ?>js/interface.js"></script>
</head>
<body>