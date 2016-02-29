<?
$id_meta=1;
$pg = 'imprensa-ver';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');
pt_register('GET','id_imprensa_cat');
pt_register('GET','id_imprensa');

$id_imprensa_cat = explode('/',$id_imprensa_cat);
$id_imprensa = $id_imprensa_cat[2];
$id_imprensa_cat = $id_imprensa_cat[0];

$sql = $objQuery->SQLQuery("SELECT c.id_imprensa_cat, i.id_imprensa, i.titulo, i.url_amigavel, i.artigo, i.view, i.status, date_format(i.data, '%d/%m/%Y') as data FROM site_imprensa as i, site_imprensa_cat as c WHERE i.id_imprensa_cat=c.id_imprensa_cat AND i.status='1' AND c.id_imprensa_cat='" .$id_imprensa_cat. "' AND i.id_imprensa='" .$id_imprensa. "'");
$objQuery->SQLQuery("UPDATE site_imprensa as i SET view = view+1 WHERE $id_imprensa = '$id_imprensa'");
$res = mysql_fetch_array($sql);
?>
<div id="container">
    <div class="box_e">
        <h2 style="color: #202A72;">SOLICITE SUA CERTIDÃO AGORA</h2>
        <div class="faixa_h"></div>
        <div id="servicos">
            <?require_once(URL_SITE_INCLUDE.'colunae.php');?>
        </div>
        <a href="<?= URL_SITE;?>fale-com-nosso-assessor-de-imprensa/" title="Fale com nosso Assessor de Imprensa, clique aqui">
            <img src="<?= URL_IMAGES;?>pages/fale-com-nosso-assessor-de-imprensa.png" alt="fale com nosso assessor de imprensa, clique aqui" title="Fale com nosso Assessor de Imprensa, clique aqui" style="margin-top: 20px;" />
        </a>
    </div>
    <div id="contant">
        <h3 style="color: #202A72;">LEIA OUTROS ARTIGOS: </h3>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <span style="font-size: 12px; color: #999999;">Publicado em: <?= $res['data'];?></span><br /><br />
        <h1 style="font-size: 25px; font-weight: bold; color: #000000;"><?= $res['titulo'];?></h1>
        <div class="linha_h1"></div>
        <table border="0" width="100%" align="center" cellpadding="2" cellspacing="2">
            <tr>
                <td width="10%" align="left">
                    <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?= $url_rede;?>" data-text="Buscamos suas certidões em qualquer lugar do Brasil" data-count="horizontal" data-via="cartoriopostal">Tweet</a>
                </td>
                <td width="90%" align="left">
                    <a href="http://www.facebook.com/share.php?u=<?= $url_rede;?>" target="_blank">
                    <img src="<?= URL_IMAGES;?>/pages/facebook-share.png" alt="compartilhar no facebook" title="Compartilhar no Facebook" /></a>
                </td>
            </tr>
        </table>
        <div id="texto"><?= $res['artigo'];?></div>
        <div class="linha_h1"></div>
        <table border="0" width="100%" align="center" cellpadding="2" cellspacing="2">
            <tr>
                <td width="10%" align="left">
                    <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?= $url_rede;?>" data-text="Buscamos suas certidões em qualquer lugar do Brasil" data-count="horizontal" data-via="cartoriopostal">Tweet</a>
                </td>
                <td width="90%" align="left">
                    <a href="http://www.facebook.com/share.php?u=<?= $url_rede;?>" target="_blank">
                    <img src="<?= URL_IMAGES;?>/pages/facebook-share.png" alt="compartilhar no facebook" title="Compartilhar no Facebook" /></a>
                </td>
            </tr>
        </table>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>