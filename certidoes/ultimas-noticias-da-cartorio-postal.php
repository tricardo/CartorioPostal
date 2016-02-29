<?
$id_meta=32;
$pg = 'paginas';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');
pt_register('GET','busca_dados');
pt_register('GET','pagina');
?>
<div id="container">
    <div class="box_e">
        <h2 style="color: #202A72;">SOLICITE SUA CERTIDÃO AGORA</h2>
        <div class="faixa_h"></div>
        <div id="servicos">
            <?require_once(URL_SITE_INCLUDE.'colunae.php');?>
        </div>
    </div>
    <div id="contant">
        <h1 style="color: #202A72;">ÚLTIMAS NOTÍCIAS DA CARTÓRIO POSTAL</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/ultimas-noticias-da-cartorio-postal.png" alt="ultimas noticias da cartorio postal" title="Últimas notícias da Cartório Postal" style="margin: 5px 0 0 0;" />
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
        <?
        $onde ="";
        if($busca_dados<>''){$onde .= " and (ci.nome_imagem like '%".$busca_dados."%') ";}
        $condicao = "FROM cp_news_nova as ns WHERE ns.st_id='1' " .$onde. " ORDER BY ns.id_news DESC";
        $campo = "ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada";
        $url_busca = $_SERVER['REQUEST_URI'];
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
        $url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
        $query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 5);
        while($res = mysql_fetch_array($query)){
        ?>
        <tr>
            <td><div style="width: 250px; height: 110px; overflow: hidden;"><a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>/" title="<?= $res['titulo_news'];?>"><img src="<?= URL_UPLOAD;?><?= $res['imagem_news'];?>" alt="<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>" width="250" /></a></div></td>
            <td align="left" valign="top">
                <div style="padding: 0 10px;">
                    <a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>/" title="<?= $res['titulo_news'];?>" class="link_titulo_ultima_noticia"><?= $res['titulo_news'];?></a><br /><br />
                    <a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>/" title="<?= $res['titulo_news'];?>" class="link_texto_ultima_noticia"><?= $res['texto_chamada'];?></a>
                </div>
            </td>
        </tr>
        <tr>
            <td height="5" colspan="2"></td>
        </tr>
        <?}?>
        <tr>
            <td height="50" align="center" valign="middle" colspan="5" bgcolor="#FFFFFF" style="font-size: 12px;">
                <?
                $objQuery->QTDPaginaOtimizado('/certidoes/ultimas-noticias-da-cartorio-postal/');
                ?>
            </td>
        </tr>
        </table>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>