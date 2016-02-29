<?
$id_meta=3;
$pg = 'paginas';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');
pt_register('GET','id_imprensa_cat');
pt_register('GET','id_imprensa');
pt_register('GET','pagina');
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
        <h1 style="color: #202A72;">NOTÍCIAS SOBRE A CARTÓRIO POSTAL</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/noticias-sobre-a-cartorio-postal.png" alt="noticias sobre a cartorio postal" title="Canal de imprensa: Notícias sobre a Cartório Postal" style="margin: 5px 0 20px 0;" />
        O Canal de Imprensa a é área de notícias com foco em artigos, canais de relacionamento e as últimas novidades do site "Vitrine de Franquias".<br /><br />
        <h3 style="color: #202A72;">ARTIGOS</h3>
        <div class="faixa_h"></div>
        <ul>
            <?
            if($id_imprensa_cat==''){
                $lista = $siteDAO->contaArtigos();
                $p_valor = '';
                foreach($lista as $l){
                        $p_valor .= '<li class="list_ordenada_a"><a href="'.URL_SITE.'certidao-imprensa/'.$l->id_imprensa_cat.'/" class="link_normal"><strong>'.$l->cat.': '.$l->total.'</strong></a></li>';
                }
                echo $p_valor;
            }
            ?>
        </ul>
        <h4 style="color: #202A72;">CANAIS DE RELACIONAMENTO</h4>
        <div class="faixa_h"></div>
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="7%" height="45" align="left" valign="middle">
                    <img src="<?= URL_IMAGES;?>pages/icone-facebook.png" alt="acompanhe a cartorio postal no facebook" title="Acompanhe a Cartório Postal no Facebook" />
                </td>
                <td align="left" valign="middle">
                    <a href="http://www.facebook.com/cartoriopostaloficial" title="Acompanhe a Cartório Postal no Facebook" class="link_normal" target="_blank">Acompanhe a Cartório Postal no Facebook.</a>
                </td>
            </tr>
            <tr>
                <td height="45" align="left" valign="middle">
                    <img src="<?= URL_IMAGES;?>pages/icone-twitter.png" alt="siga-nos no twitter e fique conectado com todas as novidades da cartorio postal" title="Siga-nos no Twitter e fique conectado com todas as novidades da Cartório Postal" />
                </td>
                <td align="left" valign="middle">
                    <a href="http://twitter.com/cartoriopostal" title="Siga-nos no Twitter e fique conectado com todas as novidades da Cartório Postal" class="link_normal" target="_blank">Siga-nos no Twitter e fique conectado com todas as novidades da Cartório Postal.</a>
                </td>
            </tr>
            <tr>
                <td height="45" align="left" valign="middle">
                    <img src="<?= URL_IMAGES;?>pages/icone-rss.png" alt="inscreva-se agora no rss da cartorio postal" title="Inscreva-se agora no RSS da Cartório Postal" />
                </td>
                <td align="left" valign="middle">
                    <a href="http://vitrinedefranquias.com.br/feed/" title="Inscreva-se agora no RSS da Cartório Postal" class="link_normal" target="_blank">Inscreva-se agora no RSS da Cartório Postal.</a>
                </td>
            </tr>
            <tr>
                <td height="45" align="left" valign="middle">
                    <img src="<?= URL_IMAGES;?>pages/icone-blogger.png" alt="visite nosso blog e fique por dentro do que acontece na cartorio postal" title="Visite nosso blog e fique por dentro do que acontece na Cartório Postal" />
                </td>
                <td align="left" valign="middle">
                    <a href="http://vitrinedefranquias.com.br" title="Visite nosso blog e fique por dentro do que acontece na Cartório Postal" class="link_normal" target="_blank">Visite nosso blog e fique por dentro do que acontece na Cartório Postal.</a>
                </td>
            </tr>
            <tr>
                <td height="45" align="left" valign="middle">
                    <img src="<?= URL_IMAGES;?>pages/icone-youtube.png" alt="veja o canal cartorio postal no youtube" title="Veja o canal Cartório Postal no YouTube" />
                </td>
                <td align="left" valign="middle">
                    <a href="http://www.youtube.com/user/SistecartCP" title="Veja o canal Cartório Postal no YouTube" class="link_normal" target="_blank">Veja o canal Cartório Postal no YouTube.</a>
                </td>
            </tr>
            <tr>
                <td height="20" align="left" valign="middle" colspan="2"></td>
            </tr>
        </table>
        <h4 style="color: #202A72;">ÚLTIMAS NOTÍCIAS DO BLOG VITRINE DE FRANQUIAS</h4>
        <div class="faixa_h"></div>
        <? require_once(URL_SITE_INCLUDE.'blogger.php');?>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>