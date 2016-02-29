<?
$id_meta=7;
$pg = 'paginas';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');
pt_register('GET','id_cat');
pt_register('GET','id_duvida');
pt_register('GET','pagina');
?>
<div id="container">
    <div class="box_e">
        <h2 style="color: #202A72;">SOLICITE SUA CERTID�O AGORA</h2>
        <div class="faixa_h"></div>
        <div id="servicos">
            <?require_once(URL_SITE_INCLUDE.'colunae.php');?>
        </div>
    </div>
    <div id="contant">
        <h1 style="color: #202A72;">D�VIDAS FREQUENTES SOBRE CERTID�ES</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a p�gina anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/duvidas-frequentes-sobre-certidoes.png" alt="duvidas frequentes sobre certidoes" title="D�vidas frequentes sobre certid�es" style="margin: 5px 0 20px 0;" />
        Aqui voc� tira todas as suas d�vidas sobre documentos, entre outros assuntos.<br /><br />
        <h3 style="color: #202A72;">ARTIGOS</h3>
        <div class="faixa_h"></div>
        <ul>
            <?
            if($id_imprensa_cat==''){
                $lista = $siteDAO->contaDuvidas();
                $p_valor = '';
                foreach($lista as $l){
                        $p_valor .= '<li class="list_ordenada_a"><a href="'.URL_SITE.'duvida-certidao/'.$l->id_cat.'/" class="link_normal"><strong>'.$l->cat.': '.$l->total.'</strong></a></li>';
                }
                echo $p_valor;
            }
            ?>
        </ul>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>