<?
$id_meta=31;
$pg = 'paginas';
require('includes/url.php');
require_once(URL_SITE_INCLUDE.'header.php');
pt_register('GET','busca_dados');
pt_register('GET','pagina');
?>
<div id="container">
    <div class="box_f">
        <div id="coluna_e">
            <div class="box_h">
                <h1 style="color: #202A72;">GALERIA DE FOTOS DA CARTÓRIO POSTAL</h1>
                <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
                <div class="faixa_h"></div>
                <img src="<?= URL_IMAGES;?>pages/galeria-de-fotos-das-unidades-da-cartorio-postal.png" alt="galeria de fotos da cartorio postal" title="Galeria de fotos da Cartório Postal" style="margin: 5px 0 20px 0;" />
                <strong style="font-size: 15px; color: #202A72;">ESCOLHA SUA GALERIA ABAIXO</strong>
                <div class="faixa_h"></div>
                <form name="form" action="" method="GET" enctype="multipart/form-data">
                    <fieldset style="border: 1px solid #DDDDDD; margin-top: 5px; font-size: 12px; color: #333333;">
                        <legend><label for="busca_dados">Pesquisa:</label></legend>
                        <table align="center" width="100%" border="0" cellspacing="5" cellpadding="5">
                            <tr>
                                <td width="85%" align="left" valign="middle">
                                    <input name="busca_dados" type="text" id="busca_dados" value="<?= $busca_dados?>" />
                                </td>
                                <td align="center" valign="middle">
                                    <input type="submit" name="submit1" id="pesquisar" value=" " class="bt_pesquisar" title="Clique aqui para fazer a pesquisa" />
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </form>
                <table align="center" width="100%" border="0" cellspacing="5" cellpadding="5" bgcolor="#DDDDDD" style="margin-top: 5px;">
                <?
                $loop_cols = 3;
                $i = 1;
                $onde ="";
                if($busca_dados<>''){$onde .= " and (ci.nome_imagem like '%".$busca_dados."%') ";}
                $condicao = "FROM cp_cat_imagem as ci, cartorio_banco2.vsites_user_empresa as ue WHERE ci.id_empresa=ue.id_empresa AND ci.st_id='1' AND ue.status='Ativo' " .$onde. " ORDER BY ci.id_cat_imagem DESC";
                $campo = "ci.id_cat_imagem, ci.nome_imagem, ci.url_amigavel, ci.descricao, ci.cat_imagem, ue.id_empresa, ue.fantasia";
                $url_busca = $_SERVER['REQUEST_URI'];
                $url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
                $url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
                $query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 6);
                while($list = mysql_fetch_array($query)){
                    if($i < $loop_cols){
                        echo '
                            <td align="center" valign="top" bgcolor="#FFFFFF">
                                <div class="area_galeria">
                                    <div class="galeria"><a href="'.URL_SITE.'galeria-de-fotos-da-unidade-cartorio-postal/'.$list['id_cat_imagem'].'/'.$list['url_amigavel'].'/" title="'.$list['descricao'].'"><img src="'.URL_UPLOAD.''.$list['cat_imagem'].'" alt="'.$list['url_amigavel'].'" title="'.$list['descricao'].'" width="212" /></a></div>
                                    <div class="list_imagem"><a href="'.URL_SITE.'galeria-de-fotos-da-unidade-cartorio-postal/'.$list['id_cat_imagem'].'/'.$list['url_amigavel'].'/" title="'.$list['descricao'].'" class="link_galeria">'.$list['nome_imagem'].'</a></div>
                                </div>
                            </td>
                        ';
                    }elseif($i == $loop_cols){
                        echo '
                            <td align="center" valign="top" bgcolor="#FFFFFF">
                                <div class="area_galeria">
                                    <div class="galeria"><a href="'.URL_SITE.'galeria-de-fotos-da-unidade-cartorio-postal/'.$list['id_cat_imagem'].'/'.$list['url_amigavel'].'/" title="'.$list['descricao'].'"><img src="'.URL_UPLOAD.''.$list['cat_imagem'].'" alt="'.$list['url_amigavel'].'" title="'.$list['descricao'].'" width="212" /></a></div>
                                    <div class="list_imagem"><a href="'.URL_SITE.'galeria-de-fotos-da-unidade-cartorio-postal/'.$list['id_cat_imagem'].'/'.$list['url_amigavel'].'/" title="'.$list['descricao'].'" class="link_galeria">'.$list['nome_imagem'].'</a></div>
                                </div>
                            </td>
                            </tr>
                            <tr>
                        ';
                        $i = 0;
                    }
                $i++;
                }
                ?>
                <tr>
                    <td align="center" valign="middle" colspan="5" bgcolor="#FFFFFF" style="font-size: 12px;">
                        <?
                        $objQuery->QTDPaginaOtimizado('/certidoes/galeria-de-fotos-da-cartorio-postal/');
                        ?>
                    </td>
                </tr>
                </table>
            </div>
            <div class="box_c">
                <h3 style="color: #202A72;">SAIBA MAIS SOBRE:</h3>
                <div class="faixa_h"></div>
                <div class="icones_box">
                    <a href="<?= URL_SITE;?>sobre-a-franquia-da-cartorio-postal/" title="Sobre a Franquia mais procurada do Brasil">
                        <img src="<?= URL_IMAGES;?>pages/franquia-mais-procurada-do-brasil.png" alt="franquia mais procurada do brasil" title="Franquia mais procurada do Brasil" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>porque-ser-um-franqueado-da-cartorio-postal/" title="Porque ser um franqueado da Cartório Postal">
                        <img src="<?= URL_IMAGES;?>pages/porque-ser-um-franqueado-cartorio-postal.png" alt="porque ser um franqueado da cartorio postal" title="Porque ser um franqueado da Cartório Postal" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>vantagens-da-franquia-da-cartorio-postal/" title="Vantagens da franquia da Cartório Postal">
                        <img src="<?= URL_IMAGES;?>pages/vantagens-da-franquia-cartorio-postal.png" alt="vantagens da franquia da cartorio postal" title="Vantagens da franquia da Cartório Postal" />
                    </a>
                </div>
                <div class="icones_box">
                    <a href="<?= URL_SITE;?>pre-cadastro-da-franquia-cartorio-postal/" title="Pré cadastro da franquia Cartório Postal">
                        <img src="<?= URL_IMAGES;?>pages/pre-cadastro-da-franquia-cartorio-postal.png" alt="pre cadastro da franquia cartorio postal" title="Pré cadastro da franquia Cartório Postal" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal/" title="Conheça as unidades da Cartório Postal">
                        <img src="<?= URL_IMAGES;?>pages/conheca-as-unidades-da-cartorio-postal.png" alt="conheca as unidades da cartorio postal" title="Conheça as unidades da Cartório Postal" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>galeria-de-fotos-da-cartorio-postal/" title="Galeria de fotos da Cartório Postal">
                        <img src="<?= URL_IMAGES;?>pages/galeria-de-fotos-da-cartorio-postal.png" alt="galeria de fotos da cartorio postal" title="Galeria de fotos da Cartório Postal" />
                    </a>
                </div>
            </div>
        </div>
        <div class="box_g">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top">
                        <a href="<?= URL_SITE;?>pre-cadastro-da-franquia-cartorio-postal/" title="Faça seu Pré cadastro">
                            <img src="<?= URL_IMAGES;?>pages/faca-seu-pre-cadastro.png" alt="faca seu pre cadastro" title="Faça seu Pré cadastro" style="margin-bottom: 20px;" />
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="box_i">
                            <h2 style="color: #202A72;">PRINCIPAIS SERVIÇOS:</h2>
                            <div class="faixa_h"></div>
                            <ul class="marcador_servicos">
                                <?= PRINCIPAIS_SERVICOS;?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" height="205">
                        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-excelencia-em-franchising-2012.png" alt="cartorio postal excelencia em franchising-2012" title="Cartório Postal - Excelência em Franchising 2012" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="box_i" style="margin-top: 20px;">
            <h4 style="color: #202A72;">OFERECEMOS TAMBÉM:</h4>
            <div class="faixa_h"></div>
            <ul class="marcador_servicos">
                <?= OFERECEMOS_TAMBEM;?>
            </ul>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>