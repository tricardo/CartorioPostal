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
<div id="header">
    <div id="area_do_header">
        <div id="logo">
            <a href="<?= URL_SITE;?>" title="Cartório Postal, Solicite suas Certidões"><img src="<?= URL_IMAGES;?>header/cartorio-postal-solicite-suas-certidoes.png" alt="cartorio postal, solicite suas certidoes" title="Cartório Postal, Solicite suas Certidões" /></a>
        </div>
		<div id="documentos">
			<img src="<?= URL_IMAGES;?>pages/documentos.png" alt="" title="" />
		</div>
        <div id="visitantes">
            <form name="frm_login" action="/sistema/login/login_vai.php" method="post" enctype="multipart/form-data">
                <table border="0" width="100%" align="center" cellpadding="1" cellspacing="1">
                    <tr>
                        <td align="left" valign="middle"><img src="<?= URL_IMAGES;?>header/visitantes.png" alt="visitantes online" title="Visitantes online" /></td>
                        <td align="left" valign="middle" colspan="2">
                            <? 
                            if($userOnline == 1){
                                echo "<strong style='color: #666666;'>Nós temos ".$userOnline." visitante online</strong>";
                            }else{
                                echo "<strong style='color: #666666;'>Nós temos ".$userOnline." visitantes online</strong>";
                            }
                            ?>
                        </td>
                    </tr>
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
    <div class="linha_h"></div>
    <div id="menu_bar_s">
        <div id="area_menu_bar_s">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>" title="Página inicial"><img src="<?= URL_IMAGES;?>header/home.png" alt="pagina inicial" title="Página inicial" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>quem-somos/" title="Conheça a Cartório Postal"><img src="<?= URL_IMAGES;?>header/quem-somos.png" alt="conheca a cartorio postal" title="Conheça a Cartório Postal" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>certidao/" title="A Cartório postal, possui diversos produtos e serviços, clique aqui e confira!"><img src="<?= URL_IMAGES;?>header/produtos-servicos-certidao.png" alt="a cartorio postal, possui diversos produtos e servicos, clique aqui e confira" title="A Cartório postal, possui diversos produtos e serviços, clique aqui e confira!" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>franquia-mais-procurada-do-brasil/" title="Seja um franqueado Cartório Postal"><img src="<?= URL_IMAGES;?>header/seja-um-franqueado-cartorio-postal.png" alt="seja um franqueado cartorio postal" title="Seja um franqueado Cartório Postal" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal/" title="Saiba qual unidade da Cartório Postal que está mais próximo de você!"><img src="<?= URL_IMAGES;?>header/nossas-unidades.png" alt="saiba qual unidade da cartorio postal que esta mais proximo de voce" title="Saiba qual unidade da Cartório Postal que está mais próximo de você!" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>canal-de-imprensa/" title="Saiba o que está rolando nas mídias socias da Cartório Postal"><img src="<?= URL_IMAGES;?>header/canal-de-imprensa.png" alt="saiba o que esta rolando nas midias socias da cartorio postal" title="Saiba o que está rolando nas mídias socias da Cartório Postal" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>depoimentos-dos-clientes-da-cartorio-postal/" title="Depoimentos dos clientes da Cartório Postal"><img src="<?= URL_IMAGES;?>header/depoimentos-de-clientes.png" alt="depoimentos de clientes" title="Depoimentos de clientes" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>duvidas-frequentes-sobre-certidoes/" title="Dúvidas frequentes sobre certidões"><img src="<?= URL_IMAGES;?>header/duvidas-frequentes.png" alt="duvidas frenquentes sobre certidoes" title="Dúvidas frequentes sobre certidões" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>fale-conosco/" title="Entre em contato com a Cartório Postal"><img src="<?= URL_IMAGES;?>header/fale-conosco.png" alt="entre em contato com a cartorio postal" title="Entre em contato com a Cartório Postal" /></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>