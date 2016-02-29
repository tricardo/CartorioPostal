<?
$id_meta=24;
$pg = 'paginas';
require('includes/url.php');
require_once(URL_SITE_INCLUDE.'header.php');
echo '<meta HTTP-EQUIV="refresh" CONTENT="5; URL='.URL_SITE.'">';
?>
<div id="container">
    <div class="box_f">
        <div id="coluna_e">
            <div class="box_h">
                <img src="<?= URL_IMAGES;?>pages/mensagem-enviada-com-sucesso.png" alt="mensagem enviada com sucesso" title="Mensagem enviada com sucesso!" />
            </div>
            <div class="box_c"></div>
        </div>
        <div class="box_g"></div>
        <div class="box_i" style="margin-top: 20px;"></div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>
