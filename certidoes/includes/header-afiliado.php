<?
ob_start();
session_start();
$sessao = session_id();
$timestamp = time();
$timeout = time() - 300;
$ip = $_SERVER['REMOTE_ADDR'];
require_once(URL_SITE_INCLUDE.'browser.php');
require_once(URL_SITE_INCLUDE.'classQuery.php');
require_once(URL_SITE_MODEL.'Database.php');
require_once(URL_SITE_MODEL.'DatabaseSite.php');
require_once(URL_SITE_INCLUDE.'global.php');
require_once(URL_SITE_INCLUDE.'funcoes.php');
require_once(URL_SITE_INCLUDE.'Redimencionar.php');
pt_register('GET','lingua');
if($lingua<>''){
    if($lingua!='br' AND $lingua!='es' AND $lingua!='en') $lingua = 'br';
    $_SESSION['lingua'] = $lingua;
}else{
    $lingua = $_SESSION['lingua'];
    if($lingua=='') $lingua = 'br';
}
require_once(URL_BASE.'language/'.$lingua.'.php');
header('Content-Type: text/html; charset=iso-8859-1');
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$siteDAO = new SiteDAO();
$userOnline = $siteDAO->usuariosOnline($sessao,$ip);
$n_fraquias = $siteDAO->totalFranquias();

$pedidoDAO = new PedidoDAO();
$servicosMenu = $pedidoDAO->selectServicosSiteMenu();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?require_once(URL_SITE_INCLUDE.'meta-tag.php');?>
<link href="<?= URL_IMAGES;?>header/favicon.ico" rel="apple-touch-icon"  />
<link href="<?= URL_IMAGES;?>header/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?= URL_SITE;?>css/import.css?<?=date('is')?>" rel="stylesheet" type="text/css" charset="iso-8859-1" />
<script src="<?= URL_SITE;?>js/script.js?<?=date('is')?>" language="javascript" type="text/javascript"></script>
<script src="http://platform.twitter.com/widgets.js" language="javascript" type="text/javascript"></script>
<script src="http://widgets.twimg.com/j/2/widget.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
$(function(){
    $("#destaque_noticia").cycle({
        fx: 'fade',
        speed: 1500,
        timeout: 5000,
        pager: '#pager'
    })
})

$(function(){
    $("#imagem_destaque_franquia").cycle({
        fx: 'fade',
        speed: 1500,
        timeout: 5000
    })
})

$(function(){
    $("#produtos").cycle({
        fx: 'fade',
        speed: 1500,
        timeout: 5000
    })
})
</script>
<script language="javascript" type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-11318282-1']);
_gaq.push(['_trackPageview']);
(function(){
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

Shadowbox.init({
    language        : 'pt',
    continuous      : true,
    counterType     : "skip",
    gallery         : "mustang",
    handleOversize  : "drag",
    player          : ['img', 'html', 'swf']
});

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if(d.getElementById(id))
        return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
}
(document, 'script', 'facebook-jssdk'));
</script>

	<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
	  {lang: 'pt-BR'}
	</script>

</head>