<?
$id_meta=5;
$pg = 'paginas';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');
pt_register('GET','busca_dados');
pt_register('GET','pagina');
?>
<div id="container">
    <div class="box_e">
        <h2 style="color: #202A72;">SOLICITE SUA CERTIDÃO AGORA</h2>
        <div class="faixa_h"></div>
        <div id="servicos">
            <?require_once(URL_SITE_INCLUDE.'colunae.php');?>
        </div>
        <a href="<?= URL_SITE;?>envie-seu-depoimento-para-cartorio-postal/" title="Envie seu depoimento para Cartório Postal, clique aqui">
            <img src="<?= URL_IMAGES;?>pages/envie-seu-depoimento.png" alt="envie seu depoimento, clique aqui" title="Envie seu depoimento, clique aqui" style="margin-top: 20px;" />
        </a>
    </div>
    <div id="contant">
        <h1 style="color: #202A72; text-transform: uppercase;">DEPOIMENTOS DOS CLIENTES DA CARTÓRIO POSTAL</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/depoimentos-dos-clientes-da-cartorio-postal.png" alt="depoimentos dos clientes da cartorio postal" title="Depoimentos dos clientes da Cartório Postal" style="margin: 5px 0 20px 0;" />
        <div id="depoimento">
        Fundei a Cartório Postal em 1992. Deste ano em diante, a empresa vem crescendo e realizando conquistas importantes ao longo do tempo.<br /><br />
        A conquista mais importante é o sistema de franquias, adotado em 2009.<br /> Hoje, já somos <?= $n_fraquias = $n_fraquias[0]->total;?> unidades em todo o Brasil.<br /><br />
        A cada dia, colhemos reconhecimento e confiança dos nossos clientes<br /> e franqueados, reconhecimento este que valida nosso sucesso e <br />credibilidade.<br /><br />
        Um abraço a todos e coloco-me à disposição!<br /><br />
        <strong style="color: #202A72;">Presidente Sr. Flávio Lopes da Costa.</strong>
        </div>
        <div class="imagem_depoimento">
            <img src="<?= URL_IMAGES;?>pages/imagem-depoimento.png" alt="" title="" />
        </div>
        <div id="list">
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
            <?
            $onde ="";
            if($busca_dados<>''){$onde .= " and d.depoimento like '".$busca."%' ";}
            $condicao = "FROM cp_depoimento as d WHERE d.status='1' ORDER BY d.id_depoimento DESC";
            $campo = "d.id_depoimento, d.nome, d.email, d.depoimento, date_format(d.data, '%d/%m/%Y') as data, d.status";
            $url_busca = $_SERVER['REQUEST_URI'];
            $url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
            $url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
            $query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 5);
            $p_valor = "";
            $i = 0;
            while($res = mysql_fetch_array($query)){
            $p_valor .= '
            <tr>
                <td align="left" valign="middle" style="font-size: 15px; color: #333333;" class="faixa_depoimento">
                    <strong style="text-transform: uppercase;">POR - ' .$res["nome"] . '</strong> - Enviado: ' . $res["data"] . '
                </td>
            </tr>
            <tr>
                <td align="left" valign="middle">
                    <img src="'.URL_IMAGES.'pages/aspa_bottom.png" alt="depoimento" title="Depoimento postado por: ' .$res["nome"]. '" style="margin-top:10px;" />
                    <p style="font-size: 15px; color: #333333;">' . $res["depoimento"] . '</p>
                    <img src="'.URL_IMAGES.'pages/aspa_top.png" alt="depoimento" title="Depoimento postado por: ' .$res["nome"] . '" />
                </td>
            </tr>
            <tr>
                <td align="left" valign="middle" height="20"></td>
            </tr>';
            }
            echo $p_valor;
            ?>
            <tr>
                <td align="center" valign="middle" colspan="2">
                    <?
                    $objQuery->QTDPaginaOtimizado('/certidoes/depoimentos-dos-clientes-da-cartorio-postal/');
                    ?>
                </td>
            </tr>
        </table>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>