<?php
if(navegador(2) == 'ie'){
    $verifica_nav = VerificaNavegadorSO();
    if($verifica_nav->num_version < 11){
        NoExplorer();    
        exit;
    }
}?>
<!DOCTYPE html>
<html>
<head>
<title>SISTEMA CARTÓRIO POSTAL</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="images/cartoriopostal-ico.gif" type="image/png" rel="shortcut icon">
<script src="https://www.google.com/jsapi" type="text/javascript"></script>
<script src="jquery/jquery-2.1.0.min.js" type="text/javascript"></script>
<script src="jquery/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script> 
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="jquery/jquery-maskedmoney.js" type="text/javascript"></script>
<script src="shadowbox/shadowbox.js" type="text/javascript"></script>
<script src="js/funcoes.js?n=<?=date('is')?>" type="text/javascript"></script>
<link href="shadowbox/shadowbox.css" rel="stylesheet" type="text/css">
<?php if(defined('COMUNICADOS')){ ?>
    <link href="css/informativo.css?n=<?=date('is')?>" type="text/css" rel="stylesheet">
<?php } else { ?>
    <link href="css/sistema.css?n=<?=date('is')?>" type="text/css" rel="stylesheet">
<?php } 
$navegador = navegador(); 
echo (strlen($navegador) > 0) ? ' <link href="css/'.$navegador.'.css?n='.date('is').'" type="text/css" rel="stylesheet">' : '';
if(PRODUCAO == 0){ ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58589188-19', 'auto');
  ga('send', 'pageview');

</script>
<?php } ?>
</head>
<body>