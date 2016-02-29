<?
$id_meta=1;
$pg = 'paginas';
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require_once(URL_SITE_INCLUDE.'header.php');
?>
<div id="container">
    <div class="box_a">
        <div id="fundo_destaque">
            <div id="destaque_noticia">
                <?
                $sql = $objQuery->SQLQuery("SELECT ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada FROM cp_news_nova as ns WHERE st_id='1' ORDER BY ns.id_news DESC LIMIT 8");
                while($res = mysql_fetch_array($sql)){
                ?>
                <ul>
                    <li>
                        <div class="imagem_destaque">
                            <a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>/" title="<?= $res['titulo_news'];?>"><img src="<?= URL_UPLOAD;?><?= $res['imagem_news'];?>" alt="<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>" width="580" /></a>
                        </div>
                        <div class="texto_destaque">
                            <a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>/" title="<?= $res['titulo_news'];?>" class="link_titulo_destaque"><?= $res['titulo_news'];?></a><br /><br />
                            <a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>/" title="<?= $res['titulo_news'];?>" class="link_destaque"><?= $res['texto_chamada'];?></a>
                        </div>
                    </li>
                </ul>
                <?}?>
            </div>
            <div id="n_destaque">
                <span id="pager"></span>
            </div>
        </div>
        <div id="nav_a">
            <h1 style="color: #202A72;">CONHEÇA A CARTÓRIO POSTAL</h1>
            <div class="faixa_h"></div>
            <div class="texto_nav_a">
                <p>
                    Cada vez mais nos preocupamos com facilidade e comodidade ao adquirirmos produtos e serviços. 
                    Com a sensação de não dar tempo para nada e os trabalhos acumulando, perdemos prazos para fechamento de negócios e outros serviços que necessitam de documentos e vias de contratos, que muitas vezes não estão mais conosco.
                    <br /><br />

                    A Cartório Postal surge para agilizar seus negócios, seja uma simples certidão de nascimento aos mais variados documentos solicitados na hora de comprar um imóvel. 
                    São mais de 150 serviços à sua disposição, onde você terá prazo, as melhores condições de pagamento e, claro, tempo para curtir o melhor da vida!
                    <br /><br />

                    <strong>Você vai receber a certidão digitalmente em sua máquina e posteriormente o físico emitido pelo Órgão competente.</strong>
                </p>
            </div>
        </div>
    </div>
    <div class="cols_d">
        <!--<a href="<?= URL_SITE;?>cartorio-postal-em-convenio-com-os-correios/" title="Cartório Postal nas agências dos Correios">
            <img src="<?= URL_IMAGES;?>pages/cartorio-postal-nas-agencias-dos-correios.png" alt="cartorio postal nas agencias dos correios" title="Cartório Postal nas agências dos Correios" />
        </a>//-->
        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-recebe-o-selo-de-excelencia-em-franchising-2012.png" alt="cartorio-postal-recebe-o-selo-de-excelencia-em-franchising-2012" title="Cartório Postal recebe o selô de Excelência em Franchising 2012" style="margin-top: 20px;" />
        <!--<a href="<?= URL_SITE;?>certisign-selecione-sua-regiao-e-peca-o-seu-certificado-digital/" title="Compre sua Certificação Digital com a Cartório Postal">
            <img src="<?= URL_IMAGES;?>pages/cartorio-postal-e-a-principal-parceira-em-vendas-da-certisign-no-territorio-nacional.png" alt="compre sua certificacao digital com a cartorio postal" title="Compre sua Certificação Digital com a Cartório Postal" style="margin-top: 20px;" />
        </a>//-->
    </div>
    <div class="cols_e">
        <h2 style="color: #202A72;">SOLICITE SUA CERTIDÃO AGORA</h2>
        <div class="faixa_h"></div>
        <div id="servicos">
            <?require_once(URL_SITE_INCLUDE.'colunae.php');?>
        </div>
    </div>
    <div class="box_b">
        <div class="box_j">
            <h4 style="color: #202A72;">DESTAQUES</h4>
            <div class="faixa_h"></div>
            <div class="cols_d_2">
                <a href="<?= URL_SITE;?>certidao/" title="Solicite sua Certidão aqui na Cartório Postal">
                    <img src="<?= URL_IMAGES;?>pages/solicite-sua-certidao-agora.png" alt="solicite sua certidao aqui na cartorio postal" title="Solicite sua Certidão aqui na Cartório Postal" style="margin-top: 5px;" />
                </a>
            </div>
            <div id="principais_servicos">
                <div id="produtos">
					<a href="http://certificadodigital.cacb.org.br/selecionar" target="_blank" title="Parceria com CACB"><img src="<?= URL_IMAGES;?>pages/parceria-qmcd-cp.png" alt="Parceria com CACB" title="Parceria com CACB" width="520" height="185" /></a>
					<a href="<?= URL_SITE?>certidao-digital/" title="Enviaremos sua Certdião Digital e posteriormente a Via impressa"><img src="<?= URL_IMAGES;?>pages/certidao-digital.png" alt="enviaremos sua certdião digital e posteriormente a via impressa" title="Enviaremos sua Certdião Digital e posteriormente a Via impressa" width="520" height="185" /></a>
					<img src="<?= URL_IMAGES;?>pages/doccloud.png" alt="doccloud" title="Doccloud" width="520" height="185" />
					<a href="<?= URL_SITE?>treinamento-e-desenvolvimento-para-consultores/" title="Treinamento e Desenvolvimento para Consultores"><img src="<?= URL_IMAGES;?>pages/treinamento-e-desenvolvimento-para-consultores.png" alt="treinamento e desenvolvimento para consultores" title="Treinamento e Desenvolvimento para Consultores" width="520" height="185" /></a>
					<img src="<?= URL_IMAGES;?>pages/expansao-internacional.png" alt="expansao internacional" title="Expansão Internacional" width="520" height="185" />
                    <!--<a href="http://www.cartoriopostal.com.br/certidoes/noticia/68/parceria-dpvat-jst/" title="Seguro para Acidentes de Trânsito" target="_blank"><img src="<?= URL_IMAGES;?>pages/dpvat.png" alt="seguro para acidentes de transito" title="Seguro para Acidentes de Trânsito" width="520" height="185" /></a>//-->
                    <img src="<?= URL_IMAGES;?>pages/logistica-de-distribuicao.png" alt="logistica de distribuicao" title="Logística de Distribuição" width="520" height="185" />
                    <img src="<?= URL_IMAGES;?>pages/nossas-parcerias.png" alt="nossas parcerias" title="Nossas Parcerias" width="520" height="185" />
                    <img src="<?= URL_IMAGES;?>pages/nossas-marcas.png" alt="nossas marcas" title="Nossas-Marcas" width="520" height="185" />
                    <a href="http://www.cartoriopostal.com.br/certidoes/noticia/35/microfranquia-seu-pet-com-sobrenome" title="Seja nosso franqueado Seu Pet com Sobrenome" target="_blank"><img src="<?= URL_IMAGES;?>pages/seu-pet-com-sobrenome.png" alt="seja nosso franqueado seu pet com sobrenome" title="Seja nosso franqueado Seu Pet com Sobrenome" width="520" height="185" /></a>
                    <a href="http://www.cartoriopostal.com.br/certidoes/noticia/25/cartorio-postal-lanca-modelo-multiservicos" title="Cartório Postal Multi Serviços" target="_blank"><img src="<?= URL_IMAGES;?>pages/cartorio-postal-multi-servicos.png" alt="cartorio postal multi servicos" title="Cartório Postal Multi Serviços" width="520" height="185" /></a>
                    <img src="<?= URL_IMAGES;?>pages/produto-certidao.png" alt="certidao com rapidez e praticidade" title="Certidão com Rapidez e Praticidade" width="520" height="185" />
                    <a href="http://www.cacadoresdeheranca.com.br/ch/index.php" title="Caçadores de Herança" target="_blank"><img src="<?= URL_IMAGES;?>pages/cacadores-de-heranca.png" alt="cacadores de heranca" title="Caçadores de Herança" width="520" height="185" /></a>
                    <a href="http://www.vitrinedefranquias.com.br/" title="Vitrine de Franquia" target="_blank"><img src="<?= URL_IMAGES;?>pages/vitrine-de-franquias.png" alt="vitrine de franquias" title="Vitrine de Franquias" width="520" height="185" /></a>
                    <img src="<?= URL_IMAGES;?>pages/cartorio-postal-agora-tambem-esta-em-londres.png" alt="cartorio postal agora tambem esta em londres" title="Cartório Postal agora também está em Londres" width="520" height="185" />
                    <img src="<?= URL_IMAGES;?>pages/cartorio-postal-mais-de-1-milhao-de-clientes-atendidos.png" alt="cartorio postal mais de 1 milhao de clientes atendidos" title="Cartorio Postal, mais de 1 milhão de clientes atendidos" width="520" height="185" />
                    <a href="<?= URL_SITE;?>noticia/25/cartorio-postal-lanca-modelo-multiservicos/" title="Seja um Representante Cartório Postal"><img src="<?= URL_IMAGES;?>pages/multi-servicos.png" alt="seja um representante cartorio postal" title="Seja um Representante Cartório Postal" width="520" height="185" /></a>
                    <img src="<?= URL_IMAGES;?>pages/cartorio-postal-agora-tambem-esta-em-bruxelas.png" alt="cartorio postal agora tambem esta em bruxelas" title="Cartório Postal agora também está em Bruxelas" width="520" height="185" />
                    <img src="<?= URL_IMAGES;?>pages/produto-post-office-express.png" alt="post office express" title="Post Office Express" width="520" height="185" />
                    <img src="<?= URL_IMAGES;?>pages/produto-servicos.png" alt="101 servicos a sua disposicao" title="101 Serviços a sua disposição" width="520" height="185" />
                </div>
            </div>
        </div>
        <h3 style="color: #202A72;">SAIBA MAIS SOBRE A FRANQUIA CARTÓRIO POSTAL...</h3>
        <div class="faixa_h"></div>
        <div class="icones_box">
            <a href="<?= URL_SITE;?>franquia-mais-procurada-do-brasil/" title="Saiba mais sobre a franquia mais procurada do Brasil">
                <img src="<?= URL_IMAGES;?>pages/saiba-mais-sobre-a-franquia-mais-procurada-do-brasil.png" alt="saiba mais sobre a franquia mais procurada do brasil" title="Saiba mais sobre a franquia mais procurada do Brasil" />
            </a>
        </div>
        <div class="icones_box" style="margin-left: 6px;">
            <a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal/" title="Conheça as unidades da Cartório Postal">
                <img src="<?= URL_IMAGES;?>pages/conheca-as-unidades-da-cartorio-postal.png" alt="conheca as unidades da cartorio postal" title="Conheça as unidades da Cartório Postal" />
            </a>
        </div>
        <div class="icones_box" style="margin-left: 6px;">
            <div class="numero_fraquias">
                <div  style="padding: 8px;">
                    SOMOS HOJE<br />
                    <strong style="font-size: 25px; color: #EFB700;"><?= $u_ativas;?></strong><br />
                    LOJAS
                </div>
            </div>
            <img src="<?= URL_IMAGES;?>pages/numero-de-franquias-da-cartorio-postal.png" alt="numero de franquias da cartorio postal" title="Número de franquias da Cartório Postal" />
        </div>
        <div class="box_c">
            <h5 style="color: #202A72;">OUTRAS NOTÍCIAS</h5>
            <a href="<?= URL_SITE;?>ultimas-noticias-da-cartorio-postal/" title="Clique aqui para ver outras Notícias da Cartório Postal" style="float: right;" class="link_voltar">LEIA MAIS:.</a>
            <div class="faixa_h"></div>
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
                <?
                $sql = $objQuery->SQLQuery("SELECT ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada, ns.ordem FROM cp_news_nova as ns WHERE ns.st_id='1' AND ns.destaque='2' AND ns.ordem>='1' ORDER BY ns.ordem ASC LIMIT 3");
                while($res = mysql_fetch_array($sql)){
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
            </table>
        </div>
    </div>
    <div class="box_d">
        <div id="area_plugin_facebook">
            <strong style="color: #202A72;">CURTA A CARTÓRIO POSTAL</strong>
            <div class="faixa_h"></div>
            <div id="plugin_facebook">
                <div id="fb-root"></div>
                <div class="fb-like-box" data-href="https://www.facebook.com/cartoriopostaloficial" data-width="290px" data-height="286px" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="true" data-show-border="false"></div>
            </div>
        </div>
        <div id="area_plugin_twitter">
            <strong style="color: #202A72;">ÚLTIMAS DO TWITTER - CARTÓRIO POSTAL</strong>
            <div class="faixa_h"></div>
            <div id="plugin_twitter">
                <a class="twitter-timeline" href="https://twitter.com/cartoriopostal" data-widget-id="357574104934674432">Tweets de @cartoriopostal</a>
                <script language="javascript" type="text/javascript">
                !function(d,s,id){
                    var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
                    if(!d.getElementById(id)){
                        js=d.createElement(s);
                        js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js,fjs);
                    }
                }(document,"script","twitter-wjs");
                </script>
            </div>
        </div>
        <div id="area_midia_social">
            <strong style="color: #202A72;">INTERAGINDO COM VOCÊ</strong>
            <div class="faixa_h"></div>
            <a href="https://www.facebook.com/cartoriopostaloficial/app_195646697137509" title="Clique aqui e solicite sua certidão na Cartório Postal através de nossa página no Facebook" class="link_img" target="_blank">
                <img src="<?= URL_IMAGES;?>pages/solicite-sua-certidao-na-cartorio-postal-atraves-de-nossa-pagina-no-facebook.png" alt="clique aqui e solicite sua certidao na cartorio postal atraves de nossa pagina no facebook" title="Clique aqui e solicite sua certidão na Cartório Postal através de nossa página no Facebook" style="margin-top: 5px;" />
            </a>
        </div>
    </div>
</div>
<div id="apDiv_popup">
	<a href="#" onClick="fechar_popup()" title="Clique aqui para fechar o banner"><img src="<?= URL_IMAGES;?>fechar.png" alt="" title="" width="450" /></a><br /><br />
	<a href="http://www.cartoriopostal.com.br/certidoes/noticia/36/workshop-apresentacao-franquias/" title="Workshop Cartório Postal" target="_blank"><img src="<?= URL_IMAGES;?>workshop.png" alt="workshop cartório postal" title="Workshop Cartório Postal" width="450" /></a>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>