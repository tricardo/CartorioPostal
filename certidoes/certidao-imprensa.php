<?
$id_meta=1;
$pg = 'imprensa';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');
pt_register('GET','busca');
pt_register('POST','id');
pt_register('GET','pagina');
pt_register('POST','submit1');
pt_register('GET','id_imprensa_cat');
$sql = $objQuery->SQLQuery("SELECT ic.id_imprensa_cat, ic.cat, i.id_imprensa, i.url_amigavel FROM site_imprensa as i INNER JOIN site_imprensa_cat as ic ON ic.id_imprensa_cat=i.id_imprensa_cat WHERE ic.id_imprensa_cat='" .$id_imprensa_cat. "'");
$res = mysql_fetch_array($sql);
?>
<div id="container">
    <div class="box_e">
        <h2 style="color: #202A72;">SOLICITE SUA CERTIDÃO AGORA</h2>
        <div class="faixa_h"></div>
        <div id="servicos">
            <?require_once(URL_SITE_INCLUDE.'colunae.php');?>
        </div>
        <a href="<?= URL_SITE;?>fale-com-nosso-assessor-de-imprensa/" title="Fale com nosso Assessor de Imprensa, clique aqui">
            <img src="<?= URL_IMAGES;?>pages/fale-com-nosso-assessor-de-imprensa.png" alt="fale com nosso assessor de imprensa, clique aqui" title="Fale com nosso Assessor de Imprensa, clique aqui" style="margin-top: 20px;" />
        </a>
    </div>
    <div id="contant">
        <h1 style="color: #202A72; text-transform: uppercase;">ARTIGO SOBRE: <? echo $res['cat'];?></h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/leia-os-artigos-da-cartorio-postal.png" alt="leia os artigos da cartorio postal" title="Leia os artigos da Cartório Postal" style="margin: 5px 0 20px 0;" />
        <div id="list">
        <form name="form" action="" method="get" enctype="multipart/form-data">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="20%" align="left"><label for="busca" accesskey="1">Buscar outros artigos:</label></td>
                    <td width="65%" align="left"><input name="busca" type="text" id="busca" value="<?= $busca;?>"/></td>
                    <td width="15%" align="center" valign="middle"><input type="submit" name="submit1" id="busca" value=" " title="Clique aqui para fazer a pesquisa" class="bt_buscar" /></td>
                </tr>
                <tr>
                    <td height="25" colspan="3"></td>
                </tr>
            </table>
        </form>
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="80%" align="left" valign="middle" class="list_td"><strong>Título do artigo</strong></td>
                <td width="20%" align="center" valign="middle" class="list_td"><strong>Nº de acessos</strong></td>
            </tr>
            <?
            $onde ="";
            if($busca<>''){$onde .= " and i.titulo like '".$busca."%' ";}
            $condicao = "FROM site_imprensa as i, site_imprensa_cat as c WHERE i.id_imprensa_cat=c.id_imprensa_cat AND i.status='1' AND i.id_imprensa_cat='".$id_imprensa_cat."' " .$onde. " ORDER BY i.id_imprensa DESC";
            $campo = "c.id_imprensa_cat, i.id_imprensa, i.titulo, i.url_amigavel, i.view, i.status";
            $url_busca = $_SERVER['REQUEST_URI'];
            $url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
            $url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
            $query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 20);
            $p_valor = "";
            $i = 0;
            while($res = mysql_fetch_array($query)){
            $p_valor .= '
            <tr>
                <td align="left" valign="middle">
                    <a href="'.URL_SITE.'certidao-imprensa-ver/'.$res['id_imprensa_cat'].'/'.$res['url_amigavel'].'/'.$res['id_imprensa'].'/" title="'.$res['titulo'].'" class="list">'.$res['titulo'].'</a>
                </td>
                <td align="center" valign="middle">
                    <a href="'.URL_SITE.'certidao-imprensa-ver/'.$res['id_imprensa_cat'].'/'.$res['url_amigavel'].'/'.$res['id_imprensa'].'/" title="'.$res['titulo'].'" class="list">'.$res['view'].'</a>
                </td>
            </tr>';
            }
            echo $p_valor;
            ?>
            <tr>
                <td align="center" valign="middle" colspan="2">
                    <?
                    $objQuery->QTDPaginaOtimizado('/certidoes/certidao-imprensa/'.$id_imprensa_cat.'/');
                    ?>
                </td>
            </tr>
        </table>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>