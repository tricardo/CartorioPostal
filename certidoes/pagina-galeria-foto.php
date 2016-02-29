<?
$id_meta=1;
$pg = 'pagina_imagens';
require('includes/url.php');
require_once(URL_SITE_INCLUDE.'header.php');
pt_register('GET','id');
$sql = $objQuery->SQLQuery("SELECT ci.id_cat_imagem, ci.descricao, im.st_id FROM cp_cat_imagem as ci, cp_imagem as im WHERE ci.id_cat_imagem=im.id_cat_imagem AND im.st_id='1' AND im.id_cat_imagem='" .$id. "'");
$list = mysql_fetch_array($sql);
?>
<div id="container">
    <div class="box_f">
        <div id="coluna_e">
            <div class="box_h">
                <h1 style="text-transform: uppercase; color: #202A72;"><?= $list['descricao'];?></h1>
                <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
                <div class="faixa_h"></div>
                <table align="center" width="100" border="0" cellspacing="5" cellpadding="5" bgcolor="#DDDDDD" style="margin-top: 5px;">
                <?
                $loop_cols = 3;
                $i = 1;
                $sql = $objQuery->SQLQuery("SELECT ci.id_cat_imagem, im.id_imagem, ci.nome_imagem, ci.descricao, ci.url_amigavel, im.imagem, im.st_id FROM cp_cat_imagem as ci, cp_imagem as im WHERE ci.id_cat_imagem=im.id_cat_imagem AND im.st_id='1' AND im.id_cat_imagem='" .$id. "' ORDER BY im.id_cat_imagem DESC LIMIT 12");
                while($list = mysql_fetch_array($sql)){
                    if($i < $loop_cols){
                        echo '
                            <td align="center" valign="top" bgcolor="#FFFFFF">
                                <div class="galeria"><a href="'.URL_UPLOAD.''.$list['imagem'].'" title="'.$list['descricao'].'" rel="shadowbox[vocation]"><img src="'.URL_UPLOAD.''.$list['imagem'].'" alt="'.str_replace("-"," ",$list['url_amigavel']).'" title="'.$list['descricao'].'" width="212" /></a></div>
                            </td>
                        ';
                    }elseif($i == $loop_cols){
                        echo '
                            <td align="center" valign="top" bgcolor="#FFFFFF">
                                <div class="galeria"><a href="'.URL_UPLOAD.''.$list['imagem'].'" title="'.$list['descricao'].'" rel="shadowbox[vocation]"><img src="'.URL_UPLOAD.''.$list['imagem'].'" alt="'.str_replace("-"," ",$list['url_amigavel']).'" title="'.$list['descricao'].'" width="212" /></a></div>
                            </td>
                            </tr>
                            <tr>
                        ';
                        $i = 0;
                    }
                $i++;
                }
                ?>
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