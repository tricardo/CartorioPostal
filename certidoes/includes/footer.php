<?
if($id_afiliado != ""){
    $empresaDAO = new EmpresaDAO();
    $fr = $empresaDAO->listaEmpresaAfiliado($id_afiliado);
}
?>
<div class="faixa_h"></div>
<div id="footer">
    <div id="link_footer">
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
			<tr>
                <td width="33%" align="left" valign="top" height="10" colspan="3"></td>
            </tr>
            <tr>
                <td width="33%" height="30" align="left" valign="top"><strong style="font-size: 15px; color: #202A72;">LINKS</strong></td>
                <td width="33%" align="left" valign="top"></td>
                <td width="33%" align="left" valign="top"><strong style="font-size: 15px; color: #202A72;">CENTRAL DE ATENDIMENTO</strong></td>
            </tr>
            <tr>
                <td height="30" align="left" valign="middle"><a href="<?= URL_SITE;?>" title="Página inicial" class="link_footer">Página Inicial</a></td>
                <td align="left" valign="middle"><a href="<?= URL_SITE;?>canal-de-imprensa/" title="Saiba o que está rolando nas mídias socias da Cartório Postal" class="link_footer">Canal de Imprensa</a></td>
                <td align="left" valign="middle">
                    <?
                    if($fr->tel)
                        echo '<strong style="font-size: 15px; color: #333333;">'.$fr->tel.'</strong>';
                    else
                       echo '<strong style="font-size: 15px; color: #333333;">(11) 3103.0800</strong>';
                    ?>
					<!--<strong style="font-size: 15px; color: #333333;">(11) 3103.0800</strong>//-->
                </td>
            </tr>
            <tr>
                <td height="20" align="left" valign="middle"><div class="linha_dash"></div></td>
                <td align="left" valign="middle"><div class="linha_dash"></div></td>
                <td align="left" valign="middle"><div class="linha_dash"></div></td>
            </tr>
            <tr>
                <td height="30" align="left" valign="middle"><a href="<?= URL_SITE;?>quem-somos/" title="Conheça a Cartório Postal" class="link_footer">Quem somos</a></td>
                <td align="left" valign="middle"><a href="<?= URL_SITE;?>ultimas-noticias-da-cartorio-postal/" title="Veja as últimas notícias da Cartório Postal" class="link_footer">Últimas notícias</a></td>
                <td align="left" valign="middle">
                    <?
                    if($fr->tel)
                        echo '<a href="mailto:'.str_replace('diretoria','contato',$fr->email).'" title="Clique para enviar um e-mail para a Cartório Postal" class="link_contato">'.str_replace('diretoria','contato',$fr->email).'</a>';
                    else
                        echo '<a href="mailto:contato@cartoriopostal.com.br" title="Clique para enviar um e-mail para a Cartório Postal" class="link_contato">contato@cartoriopostal.com.br</a>';
                    ?>
					<!--<a href="mailto:contato@cartoriopostal.com.br" title="Clique para enviar um e-mail para a Cartório Postal" class="link_contato">contato@cartoriopostal.com.br</a>//-->
                </td>
            </tr>
            <tr>
                <td height="20" align="left" valign="middle"><div class="linha_dash"></div></td>
                <td align="left" valign="middle"><div class="linha_dash"></div></td>
                <td align="left" valign="middle"></td>
            </tr>
            <tr>
                <td align="left" valign="middle"><a href="<?= URL_SITE;?>certidao/" title="A Cartório postal, possui diversos produtos e serviços, clique aqui e confira!" class="link_footer">Produtos e Serviços</a></td>
                <td align="left" valign="middle"><a href="<?= URL_SITE;?>depoimentos-dos-clientes-da-cartorio-postal/" title="Depoimentos dos clientes da Cartório Postal" class="link_footer">Depoimentos de clientes</a></td>
                <td align="left" valign="middle">
                    <a href="http://www.facebook.com/cartoriopostaloficial" target="_blank" title="Acompanhe a Cartório Postal no Facebook"><img src="<?= URL_IMAGES;?>footer/acompanhe-a-cartorio-postal-no-facebook.png" alt="acompanhe a cartorio postal no facebook" title="Acompanhe a Cartório Postal no Facebook" /></a>
                    <a href="http://twitter.com/cartoriopostal" target="_blank" title="Siga-nos no Twitter e fique conectado com todas as novidades da Cartório Postal"><img src="<?= URL_IMAGES;?>footer/siga-nos-no-twitter-e-fique-conectado-com-todas-as-novidades-da-cartorio-postal.png" alt="siga-nos no twitter e fique conectado com todas as novidades da cartorio postal" title="Siga-nos no Twitter e fique conectado com todas as novidades da Cartório Postal" style="margin-left: 10px;" /></a>
                    <a href="http://www.vitrinedefranquias.com.br/" target="_blank" title="Visite nosso blog e fique por dentro do que acontece na Cartório Postal"><img src="<?= URL_IMAGES;?>footer/visite-nosso-blog-e-fique-por-dentro-do-que-acontece-na-cartorio-postal.png" alt="visite nosso blog e fique por dentro do que acontece na cartorio postal" title="Visite nosso blog e fique por dentro do que acontece na Cartório Postal" style="margin-left: 10px;" /></a>
                    <a href="http://www.youtube.com/user/SistecartCP" target="_blank" title="Veja o canal Cartório Postal no YouTube"><img src="<?= URL_IMAGES;?>footer/veja-o-canal-cartorio-postal-no-you-tube.png" alt="veja o canal cartorio postal no youtube" title="Veja o canal Cartório Postal no YouTube" style="margin-left: 10px;" /></a>
                </td>
            </tr>
            <tr>
                <td height="20" align="left" valign="middle"><div class="linha_dash"></div></td>
                <td align="left" valign="middle"><div class="linha_dash"></div></td>
                <td align="left" valign="top"><br /></td>
            </tr>
            <tr>
                <td height="30" align="left" valign="middle"><a href="<?= URL_SITE;?>franquia-mais-procurada-do-brasil/" title="Seja um franqueado Cartório Postal" class="link_footer">Seja um franqueado</a></td>
                <td align="left" valign="middle"><a href="<?= URL_SITE;?>duvidas-frequentes-sobre-certidoes/" title="Dúvidas frequentes sobre certidões" class="link_footer">Dúvidas frequentes</a></td>
                <td align="left" valign="top">Copyright© 2012. Cartório Postal.<br />Todos os Direitos Reservados.</td>
            </tr>
            <tr>
                <td height="20" align="left" valign="middle"><div class="linha_dash"></div></td>
                <td align="left" valign="middle"><div class="linha_dash"></div></td>
                <td align="left" valign="top"></td>
            </tr>
            <tr>
                <td height="30" align="left" valign="middle"><a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal/" title="Saiba qual unidade da Cartório Postal que está mais próximo de você!" class="link_footer">Nossas unidades</a></td>
                <td align="left" valign="middle"><a href="<?= URL_SITE;?>fale-conosco/" title="Entre em contato com a Cartório Postal" class="link_footer">Fale conosco</a></td>
                <td align="left" valign="top">Desenvolvido por <a href="http://www.softfox.com.br/" title="Desenvolvido por Softfox - Soluções para Web" target="_blank" class="link_powered">Softfox - Soluções para Web</a></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>