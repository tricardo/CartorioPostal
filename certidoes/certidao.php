<?
$id_meta=1;
$pg = 'certidao';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');
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
        <h1 style="color: #202A72; text-transform: uppercase;"><? if($servico<>'') echo $servico; else echo 'CERTIDÃO É NA CARTÓRIO POSTAL'; ?></h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/certidao-e-na-cartorio-postal.png" alt="certidao e na cartorio postal" title="Certidão e na Cartório Postal" style="margin: 5px 0 0 0;" />
        <div id="texto">
            <?if($servico_desc==""){ echo ""?>
            <?}else{?>
            <?= '<p>'.$servico_desc.'</p><br /><br />'; ?>
            <?}?>
        </div>
        <h3 style="color: #202A72;">PREENCHA OS CAMPOS ABAIXO</h3>
        <div class="faixa_h"></div>
        <? require_once ('certidao-servico.php'); ?>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>