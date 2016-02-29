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
$EmpresaDAO = new EmpresaDAO();
$userOnline = $siteDAO->usuariosOnline($sessao,$ip);
$n_fraquias = $siteDAO->totalFranquias();
$u_ativas = $EmpresaDAO->totalUnidadesAtivas();
$n_fraquias2 = $siteDAO->totalFranquias();

$pedidoDAO = new PedidoDAO();
$servicosMenu = $pedidoDAO->selectServicosSiteMenu();

pt_register('GET', 'p_novo');
#print_r($_GET);
#if($p_novo == 1){
	#unset($_SESSION['p']);
	#unset($_SESSION['id_pedido']);
	#exit;
#}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?require_once(URL_SITE_INCLUDE.'meta-tag.php');?>
<link href="<?= URL_IMAGES;?>header/favicon.ico" rel="apple-touch-icon"  />
<link href="<?= URL_IMAGES;?>header/favicon.ico" rel="shortcut icon" type="image/x-icon" />

<link href="<?= URL_SITE;?>css/shadowbox.css?<?=date('is')?>" rel="stylesheet" type="text/css" charset="iso-8859-1" />
<link href="<?= URL_SITE;?>css/main-menu.css?<?=date('is')?>" rel="stylesheet" type="text/css" charset="iso-8859-1" />
<link href="<?= URL_SITE;?>css/form.css?<?=date('is')?>" rel="stylesheet" type="text/css" charset="iso-8859-1" />
<link href="<?= URL_SITE;?>css/layout.css?<?=date('is')?>" rel="stylesheet" type="text/css" charset="iso-8859-1" />
<link href="<?= URL_SITE;?>css/parceria-unilever.css?<?=date('is')?>" rel="stylesheet" type="text/css" charset="iso-8859-1" />

<script src="<?= URL_SITE;?>js/ajax.js?<?=date('is');?>" language="javascript" type="text/javascript"></script>
<script src="<?= URL_SITE;?>js/jquery.js?<?=date('is');?>" language="javascript" type="text/javascript"></script>
<script src="<?= URL_SITE;?>js/cycle.js?<?=date('is');?>" language="javascript" type="text/javascript"></script>
<script src="<?= URL_SITE;?>js/jcarousellite.js?<?=date('is');?>" language="javascript" type="text/javascript"></script>
<script src="<?= URL_SITE;?>js/js.js?<?=date('is');?>" language="javascript" type="text/javascript"></script>
<script src="<?= URL_SITE;?>js/maskedinput.js?<?=date('is');?>" language="javascript" type="text/javascript"></script>
<script src="<?= URL_SITE;?>js/mask_form.js?<?=date('is');?>" language="javascript" type="text/javascript"></script>
<script src="<?= URL_SITE;?>js/shadowbox/shadowbox.js?<?=date('is');?>" language="javascript" type="text/javascript"></script>
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
        timeout: 10000
    })
})
</script>
<script language="javascript" type="text/javascript">
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-58589188-1', 'auto');
	ga('send', 'pageview');

Shadowbox.init({
    language        : 'pt',
    continuous      : true,
    counterType     : "skip",
    gallery         : "mustang",
    handleOversize  : "drag",
    player          : ['img', 'html', 'swf']
});


(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
</head>
<body class="layout" 
<? if($pg=='fale-conosco') { echo 'onload="initialize(); '; ?> showAddress('<?= $emp->endereco ?>, <?= $emp->numero ?>, <?= $emp->cidade?>, <?= $emp->estado ?>','<?= $emp->fantasia.'<br />'.$emp->endereco.','.$emp->numero.' '.$emp->complemento.'-'.$emp->bairro.'<br />'.$emp->cidade.'-'.$emp->estado.' CEP: '.$emp->cep.'<br />Tel: '.$emp->tel ?>'); <? echo 'return false;"'; } ?>
<? if($pg=='franquia' and $link=='contato') { echo 'onload="initialize(); '; ?> showAddress('<?= $emp->endereco ?>, <?= $emp->numero ?>, <?= $emp->cidade?>, <?= $emp->estado ?>','<?= $emp->fantasia.'<br />'.$emp->endereco.','.$emp->numero.' '.$emp->complemento.'-'.$emp->bairro.'<br />'.$emp->cidade.'-'.$emp->estado.' CEP: '.$emp->cep.'<br />Tel: '.$emp->tel ?>'); <? echo 'return false;"'; } ?>
>
<div id="header-parceria">
    <div id="area-do-header-parceria">
        <div id="logo-parceria">
            <a href="<?= URL_SITE;?>parceria-unilever/" title="Cartório Postal, Solicite suas Certidões"><img src="<?= URL_IMAGES;?>header/cartorio-postal-solicite-suas-certidoes.png" alt="cartorio postal, solicite suas certidoes" title="Cartório Postal, Solicite suas Certidões" /></a>
        </div>
		<div id="documentos-parceria">
			<a href="http://www.unilever.com.br/" target="_blank"><img src="<?= URL_IMAGES;?>pages/unilever-logo.png" alt="unilever brasil" title="Unilever Brasil" /></a>
		</div>
        <div id="visitantes-parceria">
            <form name="frm_login" action="/sistema/login/login_vai.php" method="post" enctype="multipart/form-data">
                <table border="0" width="100%" align="center" cellpadding="1" cellspacing="1">
                    <tr>
                        <td align="center" valign="middle"></td>
                        <td align="left" valign="middle" colspan="2"><strong>ACOMPANHE SEUS PEDIDOS ONLINE</strong></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle"><label for="login" accesskey="1"><strong>LOGIN:</strong></label></td>
                        <td align="left" valign="middle" colspan="2"><input name="login" type="text" id="login" value="<?= $login;?>" /></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle"><label for="senha" accesskey="2"><strong>SENHA:</strong></label></td>
                        <td align="left" valign="middle"><input name="senha" type="password" id="senha" value="<?= $senha;?>" /></td>
                        <td align="center" valign="middle"><input type="submit" name="submit1" class="bt_entrar" value=" " title="Clique para você acompanhar o andamento do seu pedido"/></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="linha-h"></div>
</div>