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
<link href="<?= URL_SITE;?>css/shadowbox.css?<?=date('is');?>" rel="stylesheet" type="text/css" charset="iso-8859-1" />
<link href="<?= URL_SITE;?>css/main-menu.css?<?=date('is');?>" rel="stylesheet" type="text/css" charset="iso-8859-1" />
<link href="<?= URL_SITE;?>css/hotsite.css?<?=date('is');?>" rel="stylesheet" type="text/css" charset="iso-8859-1" />
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
	$("#destaque-noticia").cycle({
		fx: 'fade',
		speed: 1500,
		timeout: 5000,
		pager: '#pager'
	})
})

$(function(){
	$("#imagem-destaque-franquia").cycle({
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

Shadowbox.init({
	language		: 'pt',
	continuous		: true,
	counterType		: "skip",
	gallery			: "mustang",
	handleOversize	: "drag",
	player			: ['img', 'html', 'swf']
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
<? if($pg=='hotsite' and $link=='contato') { echo 'onload="initialize(); '; ?> showAddress('<?= $emp->endereco ?>, <?= $emp->numero ?>, <?= $emp->cidade?>, <?= $emp->estado ?>','<?= $emp->fantasia.'<br />'.$emp->endereco.','.$emp->numero.' '.$emp->complemento.'-'.$emp->bairro.'<br />'.$emp->cidade.'-'.$emp->estado.' CEP: '.$emp->cep.'<br />Tel: '.$emp->tel ?>'); <? echo 'return false;"'; } ?>
>
<div id="area-header">
	<div id="header">
		<div id="logo">
			<a href="<?= URL_SITE;?>" title="Cartório Postal <?= $fr->fantasia;?>, Solicite suas Certidões"><img src="<?= URL_IMAGES;?>header/cartorio-postal-solicite-suas-certidoes.png" alt="Cartório Postal <?= $fr->fantasia;?>, Solicite suas Certidões" title="Cartório Postal <?= $fr->fantasia;?>, Solicite suas Certidões" /></a>
		</div>
		<div id="menu">
			<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center" valign="middle">
						<a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>" title=""><img src="<?= URL_IMAGES;?>header/pagina-principal.png" alt="" title="" /></a>
					</td>
					<td align="center" valign="middle">
						<a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/certidao" title="Solicite sua Certidão aqui na Cartório Postal - <?= $fr->fantasia;?>"><img src="<?= URL_IMAGES;?>header/faca-seu-pedido.png" alt="Solicite sua Certidão aqui na Cartório Postal - <?= $fr->fantasia;?>" title="Solicite sua Certidão aqui na Cartório Postal - <?= $fr->fantasia;?>" /></a>
					</td>
					<td align="center" valign="middle">
						<a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/produtos-e-servicos" title="A Cartório Postal - <?= $fr->fantasia;?>, possui diversos produtos e serviços"><img src="<?= URL_IMAGES;?>header/produtos-e-servicos.png" alt="A Cartório Postal - <?= $fr->fantasia;?>, possui diversos produtos e serviços" title="A Cartório Postal - <?= $fr->fantasia;?>, possui diversos produtos e serviços" /></a>
					</td>
					<td align="center" valign="middle">
						<a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/nossas-parcerias" title="Faça parte também dessa Parceria"><img src="<?= URL_IMAGES;?>header/nossas-parcerias.png" alt="Faça parte também dessa Parceria" title="Faça parte também dessa Parceria" /></a>
					</td>
					<td align="center" valign="middle">
						<a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/canal-de-imprensa" title="Leia as notícias da Cartório Postal -  <?= $fr->fantasia;?>"><img src="<?= URL_IMAGES;?>header/imprensa.png" alt="Leia as notícias da Cartório Postal -  <?= $fr->fantasia;?>" title="Leia as notícias da Cartório Postal -  <?= $fr->fantasia;?>" /></a>
					</td>
					<td align="center" valign="middle">
						<a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/galeria-de-fotos" title="Acesse nossa Galeria de fotos"><img src="<?= URL_IMAGES;?>header/galeria-de-fotos.png" alt="Acesse nossa Galeria de fotos" title="Acesse nossa Galeria de fotos" /></a>
					</td>
					<td align="center" valign="middle">
						<a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/fale-conosco" title="Entre em Contato com a Cartório Postal"><img src="<?= URL_IMAGES;?>header/contato.png" alt="" title="" /></a>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>