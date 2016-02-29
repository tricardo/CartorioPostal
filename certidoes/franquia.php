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
                $sql = $objQuery->SQLQuery("SELECT ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada, ns.ordem FROM cp_news_nova as ns WHERE st_id='1' AND ns.id_empresa='0' ORDER BY ns.id_news DESC LIMIT 8");
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
        <div id="nav_f">
            <h1 style="text-transform: uppercase; color: #202A72;">CONHEÇA A UNIDADE DA CARTÓRIO POSTAL: <?= $fr->fantasia ?></h1>
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
                apresenta um mix relacionados à intermediação entre pessoas e órgãos públicos (cartórios e todas outras entidades), com abrangência nacional e internacional direcionados para pessoas físicas e jurídicas.<br /><br />
				<? if($fr->id_pais==32){ ?>
				<strong>Endereço:</strong> <?= $fr->endereco ?>, <?= $fr->numero?>, <?= $fr->complemento?>, <?= $fr->bairro?><br />
				<? } ?>
				<strong>Fale consoco:</strong> <?= $fr->tel?><br />
				<strong>E-mail:</strong> <?= str_replace('diretoria','contato',$fr->email)?>
            </div>
            <div id="fachada_franquia">
                <img src="<?= URL_UPLOAD;?><?= $fr->imagem ?>" alt="<?= strtolower(str_replace('','-',$fr->fantasia)) ?>" title="<?= $fr->fantasia ?>" width="300"/>
            </div>
        </div>
    </div>
    <div class="cols_d">
        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-recebe-o-selo-de-excelencia-em-franchising-2012.png" alt="cartorio-postal-recebe-o-selo-de-excelencia-em-franchising-2012" title="Cartório Postal recebe o selô de Excelência em Franchising 2012" style="margin-top: 20px;" />
        <?/* if($fr->codrev==""){?>
        <a href="http://www.certisign.com.br/produtos-e-servicos/certificados-digitais?cod_rev=23289" title="Cartório Postal e a principal parceira em vendas da Certisign no território nacional" target="_blank">
            <img src="<?= URL_IMAGES;?>pages/cartorio-postal-e-a-principal-parceira-em-vendas-da-certisign-no-territorio-nacional.png" alt="cartorio postal e a principal parceira em vendas da certisign no territorio nacional" title="Cartório Postal e a principal parceira em vendas da Certisign no território nacional" style="margin-top: 20px;" />
        </a>
        <?}else{?>
        <a href="http://www.certisign.com.br/produtos-e-servicos/certificados-digitais?cod_rev=<?= $fr->codrev ?>" title="Cartório Postal e a principal parceira em vendas da Certisign no território nacional" target="_blank">
            <img src="<?= URL_IMAGES;?>pages/cartorio-postal-e-a-principal-parceira-em-vendas-da-certisign-no-territorio-nacional.png" alt="cartorio postal e a principal parceira em vendas da certisign no territorio nacional" title="Cartório Postal e a principal parceira em vendas da Certisign no território nacional" style="margin-top: 20px;" />
        </a>
        <?}*/?>
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
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <?
        switch($link){
            case 'certidao':
                require('certidao-servico.php');
                break;
            case 'depoimento':
                require('franquia-depoimentos.php');
                break;
            case 'contato':
                require('franquia-contato.php');
                break;
        }
        ?>
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
            <div id="produtos">
                <img src="<?= URL_IMAGES;?>pages/produto-post-office-express.png" alt="post office express" title="Post Office Express" width="520" height="185" />
                <img src="<?= URL_IMAGES;?>pages/produto-servicos.png" alt="101 servicos a sua disposicao" title="101 Serviços a sua disposição" width="520" height="185" />
                <img src="<?= URL_IMAGES;?>pages/produto-certidao.png" alt="certidao com rapidez e praticidade" title="Certidão com Rapidez e Praticidade" width="520" height="185" />
            </div>
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
            if($fr->id_empresa==1) echo '<span style="font: bold 15px/150% Arial; text-align: justify; color: #666666;">A Matriz da Cartório Postal é responsável pelo atendimento dessa região.</span><br />';
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
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>