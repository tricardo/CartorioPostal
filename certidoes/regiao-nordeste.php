<?
$id_meta=37;
$pg = 'paginas';
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
        <h1 style="color: #202A72;">CARTÓRIO POSTAL EM CONVÊNIO COM OS CORREIOS</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-em-convenio-com-os-correios.png" alt="cartorio postal em convenio com os correios" title="Cartório Postal em convênio com os Correios" style="margin: 5px 0 0 0;" />
        <div id="texto">
            A <strong>Sistecart - Cartório Postal</strong>, em convênio com os Correios, oferece a você, cliente que busca rapidez e facilidade, a solicitação de certidões em todo território nacional através de formulários de solicitação disponibilizados nas agências dos Correios.<br /><br />
            <h3 style="color: #202A72;">PARCERIA PREMIADA</h3>
            <div class="faixa_h"></div>
            A Ação conjunta entre Correios e <strong>Sistecart - Cartório Postal</strong> foi aclamada pelo Concurso Inovação na Gestão Pública Federal, onde a experiência contribuiu para facilitar a obtenção de segundas vias de certidões de nascimento, de casamento, de óbito e de registro de imóveis, bem como certidões negativas de protesto, especialmente para a grande população originária de outras regiões do país residente em São Paulo, evitando deslocamento às suas localidades de origem, com redução significativa de custos e tempo para os interessados.<br /><br />
            <h4 style="color: #202A72;">CONFIRA AS AGÊNCIAS QUE DISPONIBILIZA OS FORMULÁRIOS DA CARTÓRIO POSTAL</h4>
            <div class="faixa_h"></div>
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
                <tr>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>cartorio-postal-em-convenio-com-os-correios/regiao-sul/" title="Clique aqui"><img src="<?= URL_IMAGES;?>pages/correios-sul.png" alt="correios sul" title="" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>cartorio-postal-em-convenio-com-os-correios/regiao-sudeste/" title="Clique aqui"><img src="<?= URL_IMAGES;?>pages/correios-sudeste.png" alt="correios sudeste" title="" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>cartorio-postal-em-convenio-com-os-correios/regiao-centro-oeste/" title="Clique aqui"><img src="<?= URL_IMAGES;?>pages/correios-centro-oeste.png" alt="correios centro oeste" title="" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>cartorio-postal-em-convenio-com-os-correios/regiao-nordeste/" title="Clique aqui"><img src="<?= URL_IMAGES;?>pages/correios-nordeste.png" alt="correios nordeste" title="" /></a>
                    </td>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>cartorio-postal-em-convenio-com-os-correios/regiao-norte/" title="Clique aqui"><img src="<?= URL_IMAGES;?>pages/correios-norte.png" alt="correios norte" title="" /></a>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle">
                        <strong style="font-size: 12px; color: #202A72;">SUL</strong>
                    </td>
                    <td align="left" valign="middle">
                        <strong style="font-size: 12px; color: #202A72;">SUDESTE</strong>
                    </td>
                    <td align="left" valign="middle">
                        <strong style="font-size: 12px; color: #202A72;">CENTRO OESTE</strong>
                    </td>
                    <td align="left" valign="middle">
                        <strong style="font-size: 12px; color: #202A72;">NORDESTE</strong>
                    </td>
                    <td align="left" valign="middle">
                        <strong style="font-size: 12px; color: #202A72;">NORTE</strong>
                    </td>
                </tr>
            </table>
            <br /><strong style="font-size: 15px; color: #202A72;">REGIÃO NORDESTE</strong>
            <div class="faixa_h"></div>
            <table border="0" width="100%" align="center" cellpadding="2" cellspacing="2" style="margin-top: 5px;">
                <tr>
                <?
                $loop_cols = 1;
                $objQuery->classQueryMulti(1);
                $sql = $objQuery->SQLQuery("SELECT ue.id_empresa, ue.fantasia, ag.id_agcorreios, ag.status, ag.nome, ag.endereco, ag.bairro, ag.cidade, ag.estado, ag.cep, ag.tel, ag.fax FROM vsites_agcorreios as ag, vsites_user_empresa as ue WHERE ((ag.id_empresa=ue.id_empresa) AND (ag.status='1') AND (ag.estado in ('AL','BA','CE','MA','PB','PE','PI','RN','SE'))) ORDER BY ag.estado, ag.cidade ASC");
                $i = 1;
                while($list = mysql_fetch_array($sql)){
                    if($i < $loop_cols){
                        echo '
                            <td align="left" valign="middle"><strong>Nome da agência</strong>: '.$list['nome'].'</td>
                            ';
                    }elseif($i == $loop_cols){
                        echo '
                            <td align="left" valign="middle" colspan="3"><strong>Nome da agência</strong>: '.$list['nome'].'</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle" colspan="3"><strong>Endereço</strong>: '.$list['endereco'].'</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>Bairro</strong>: '.$list['bairro'].'</td>
                                <td align="left" valign="middle"><strong>Cidade</strong>: '.$list['cidade'].'</td>
                                <td align="left" valign="middle"><strong>UF</strong>: '.$list['estado'].'</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle" colspan="3"><strong>CEP</strong>: '.$list['cep'].'</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>Telefone</strong>: '.$list['tel'].'</td>
                                <td align="left" valign="middle" colspan="2"><strong>Fax</strong>: '.$list['fax'].'</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle" height="20" colspan="3" bgcolor="#EEEEEE"></td>
                            </tr>
                            <tr>
                            ';
                            $i = 0;
                    }
                $i++;
                }
                $objQuery->classQueryMulti(0);
                ?>
                </tr>
            </table>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>