<?
$id_meta=21;
$pg = 'paginas';
require('includes/url.php');
require_once(URL_SITE_INCLUDE.'header.php');
?>
<div id="container">
    <div class="box_f">
        <div id="coluna_e">
            <div class="box_h">
                <h1 style="color: #202A72;">SOBRE A FRANQUIA DA CARTÓRIO POSTAL</h1>
                <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
                <div class="faixa_h"></div>
                <img src="<?= URL_IMAGES;?>pages/sobre-a-franquia-da-cartorio-postal.png" alt="sobre a franquia da cartorio postal" title="Sobre a franquia da Cartório Postal" style="margin: 5px 0 0 0;" />
                <div id="texto">                    
                    A Franquia <strong>Sistecart - Cartório Postal</strong> é única em seu segmento. A empresa conta com um know-how desenvolvido ao longo dos seus 20 anos e vem se aprimorando constantemente.<br /><br />
                    O Franqueado da <strong>Sistecart - Cartório Postal</strong> terá um centro de conveniência que agrega em um único local, diversos serviços de assessoria e intermediação cartorária, para pessoas físicas e jurídicas.<br /><br />
                    O Franqueado prestará um serviço que permitirá a seus clientes total comodidade, qualidade, e otimização de tempo e dinheiro.
                </div>
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