<?
$pg = 'franquia';
require('includes/url.php');
require_once(URL_SITE_INCLUDE.'header.php');
?>
<div id="container">
    <div class="box_a">
        <div id="fundo_destaque">
            <div id="destaque_noticia">
                <?
                $sql = $objQuery->SQLQuery("SELECT ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada, ns.ordem FROM cp_news_nova as ns WHERE st_id='1' AND ns.destaque='1' ORDER BY ns.ordem ASC LIMIT 8");
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
        <div id="nav_c">
            <h1 style="text-transform: uppercase; color: #202A72;">CONHEÇA A <?= $fr->fantasia ?></h1>
            <div class="faixa_h"></div>
            <div id="texto_franquia">
                Cada vez mais nos preocupamos com facilidade e comodidade ao adquirirmos produtos e serviços.<br />
                
                Com mais de 18 anos de atuação no mercado, e uma rede de franquias que supera <?= $n_fraquias = $n_fraquias[0]->total;?> unidades espalhadas por todo o Brasil, 
                a Cartório Postal é a empresa pioneira em consultoria e assessoria documental.<br /><br />
                <?
                if($fr->id_empresa==1) echo ' A Matriz '; 
                    else echo 'A Unidade ';
                    echo $fr->fantasia;
                if($fr->inauguracao_data<>'' and $fr->inauguracao_data!='0000-00-00') echo ' está em operação desde '. invert($fr->inauguracao_data,'/','PHP') .' e ';
                ?>
                apresenta um mix relacionados à intermediação entre pessoas e órgãos públicos (cartórios e todas outras entidades), com abrangência nacional e internacional direcionados para pessoas físicas e jurídicas.
            </div>
            <div id="fachada_franquia">
                <img src="<?= URL_UPLOAD;?><?= $fr->imagem ?>" alt="<?= strtolower(str_replace('','-',$fr->fantasia)) ?>" title="<?= $fr->fantasia ?>" width="300"/>
            </div>
        </div>
    </div>
    <div class="cols_d">
        <a href="<?= URL_SITE;?>cartorio-postal-em-convenio-com-os-correios/" title="Cartório Postal nas agências dos Correios">
            <img src="<?= URL_IMAGES;?>pages/cartorio-postal-nas-agencias-dos-correios.png" alt="cartorio postal nas agencias dos correios" title="Cartório Postal nas agências dos Correios" />
        </a>
        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-recebe-o-selo-de-excelencia-em-franchising-2012.png" alt="cartorio-postal-recebe-o-selo-de-excelencia-em-franchising-2012" title="Cartório Postal recebe o selô de Excelência em Franchising 2012" style="margin-top: 20px;" />
        <a href="http://www.certisign.com.br/produtos-e-servicos/certificados-digitais?cod_rev=23289" title="Cartório Postal e a principal parceira em vendas da Certisign no território nacional" target="_blank">
            <img src="<?= URL_IMAGES;?>pages/cartorio-postal-e-a-principal-parceira-em-vendas-da-certisign-no-territorio-nacional.png" alt="cartorio postal e a principal parceira em vendas da certisign no territorio nacional" title="Cartório Postal e a principal parceira em vendas da Certisign no território nacional" style="margin-top: 20px;" />
        </a>
    </div>
    <div class="cols_e">
        <h2 style="color: #202A72;">SOLICITE SUA CERTIDÃO AGORA</h2>
        <div class="faixa_h"></div>
        <div id="servicos">
            <?require_once(URL_SITE_INCLUDE.'colunae.php');?>
        </div>
    </div>
    <div class="box_b">
        <strong style="font-size: 15px; text-transform: uppercase; color: #202A72;">VEJA TAMBÉM...</strong>
        <div class="faixa_h"></div>
        <div class="icones_box">
            <a href="/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/certidao/" title="Solicite sua Certidão aqui na Cartório Postal">
                <img src="<?= URL_IMAGES;?>pages/solicite-sua-certidao-aqui-na-cartorio-postal.png" alt="solicite sua certidao aqui na cartorio postal" title="Solicite sua Certidão aqui na Cartório Postal" />
            </a>
        </div>
        <div class="icones_box" style="margin-left: 6px;">
            <a href="/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/depoimento/" title="Deixe seu Depoimento aqui na Cartório Postal">
                <img src="<?= URL_IMAGES;?>pages/deixe-seu-depoimento-aqui-na-cartorio-postal.png" alt="deixe seu depoimento aqui na cartorio postal" title="Deixe seu Depoimento aqui na Cartório Postal" />
            </a>
        </div>
        <div class="icones_box" style="margin-left: 6px; margin-bottom: 20px;">
            <a href="/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/contato/" title="Entre em Contato com a Cartório Postal">
                <img src="<?= URL_IMAGES;?>pages/entre-em-contato-com-a-cartorio-postal.png" alt="entre em contato com a cartorio-postal" title="Entre em Contato com a Cartório Postal" />
            </a>
        </div>
        <h3 style="color: #202A72;">PRINCIPAIS SERVIÇOS</h3>
        <div class="faixa_h"></div>
        <div id="principais_servicos">
            <a href="#" title="">
                <img src="<?= URL_UPLOAD;?>servico-01.png" alt="" title="" />
            </a>
        </div>
        <div class="cols_d">
            <a href="#" title="A Cartório Postal é parceira do CNF (Cadastro Nacional de Falecidos)">
                <img src="<?= URL_IMAGES;?>pages/a-cartorio-postal-e-parceira-do-cnf-cadastro-nacional-de-falecidos.png" alt="a cartorio postal e parceira do cnf cadastro nacional de falecidos" title="A Cartório Postal é parceira do CNF (Cadastro Nacional de Falecidos)" style="margin-top: 5px;" />
            </a>
        </div>
        <div class="box_c">
            <h4 style="color: #202A72;">REGIÃO DE ATENDIMENTO DESSA UNIDADE</h4>
            <div class="faixa_h" style="margin-bottom: 5px;"></div>
            <?
            if($fr->id_empresa==1) echo 'span style="font: bold 15px/150% Arial; text-align: justify; color: #666666;">A Matriz da Cartório Postal é responsável pelo atendimento dessa região.</span><br />';
            else {
                echo '<span style="font: bold 15px/150% Arial; text-align: justify; color: #666666;">Essa unidade é responsável pelo atendimento dos clientes que residem nas seguintes regiões:</span><br />';
                $fr_cidades = $empresaDAO->listaEmpresaCidade($fr->id_empresa);
                $p_valor='';
                foreach($fr_cidades as $frc){
                    $p_valor .= '<li>'.$frc->estado.' - '.$frc->cidade.'</li>';					
                }
                echo '<ul class="franquia_cidade">'.$p_valor.'</ul>';
            }?>
        </div>
        <div class="box_c">
            <strong style="font-size: 15px; text-transform: uppercase; color: #202A72;">GALERIA DE FOTOS - <?= str_replace("Cartório Postal - ","",$fr->fantasia) ?></strong>
            <div class="faixa_h" style="margin-bottom: 3px;"></div>
            <?
            $lgaleria = $siteDAO->selecionaFranquiaGaleriaPorId($fr->id_empresa);
            if($lgaleria[0]->imagem<>''){
                $p_valor = '<ul class="franquia_galeria">';
                foreach($lgaleria as $l){
                    $p_valor .= '
                    <li>
                        <a href="'.URL_UPLOAD.''.$l->imagem.'" title="'.$l->descricao.'" rel="shadowbox[vocation]">
                            <img src="'.URL_UPLOAD.''.$l->imagem.'" alt="'.str_replace("-"," ",$l->url_amigavel).'" title="'.$l->nome_imagem.'" width="226"/>
                        </a>
                    </li>';
                }
                echo $p_valor.'</ul>';
            } else {
                echo 'Nenhuma foto da unidade foi encontrada';
            }
            ?>
            <br /><br /><br /><br /><br />
        </div>
    </div>
    <div class="box_d">
        <div id="area_plugin_facebook">
            <strong style="color: #202A72;">CURTA A CARTÓRIO POSTAL</strong>
            <div class="faixa_h"></div>
            <div id="plugin_facebook">
                <div id="fb-root"></div>
                <div class="fb-like-box" data-href="https://www.facebook.com/cartoriopostaloficial" width="290" height="288" data-show-faces="true" data-stream="false" data-header="true"></div>
            </div>
        </div>
        <div id="area_plugin_twitter">
            <strong style="color: #202A72;">ÚLTIMAS DO TWITTER - CARTÓRIO POSTAL</strong>
            <div class="faixa_h"></div>
            <div id="plugin_twitter">
                <? require_once(URL_SITE_INCLUDE.'tweet.php');?>
            </div>
        </div>
        <div id="area_midia_social">
            <strong style="color: #202A72;">SIGA AGORA A CARTÓRIO POSTAL</strong>
            <div class="faixa_h"></div>
            <a href="http://www.facebook.com/cartoriopostaloficial" title="Facebook da Cartório Postal" target="_blank">
                <img src="<?= URL_IMAGES;?>pages/facebook-da-cartorio-postal.png" alt="facebook da cartorio postal" title="Facebook da Cartório Postal" style="margin-top: 5px;" />
            </a>
            <a href="http://twitter.com/cartoriopostal" title="Twitter da Cartório Postal" target="_blank">
                <img src="<?= URL_IMAGES;?>pages/twitter-da-cartorio-postal.png" alt="twitter da cartorio postal" title="Twitter da Cartório Postal" style="margin-top: 11px;" />
            </a>
            <a href="http://www.vitrinedefranquias.com.br/" title="Blog da Cartório Postal" target="_blank">
                <img src="<?= URL_IMAGES;?>pages/blog-da-cartorio-postal.png" alt="blog da cartorio postal" title="Blog da Cartório Postal" style="margin-top: 11px;" />
            </a>
            <a href="http://www.youtube.com/user/SistecartCP" title="Youtube da Cartório Postal" target="_blank">
                <img src="<?= URL_IMAGES;?>pages/youtube-da-cartorio-postal.png" alt="youtube da cartorio postal" title="Youtube da Cartório Postal" style="margin-top: 11px;" />
            </a>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>