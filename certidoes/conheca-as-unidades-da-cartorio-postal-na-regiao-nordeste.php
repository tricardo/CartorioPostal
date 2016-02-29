<?
$id_meta=27;
$pg = 'paginas';
require('includes/url.php');
require_once(URL_SITE_INCLUDE.'header.php');
?>
<div id="container">
    <div class="box_f">
        <div id="coluna_e">
            <div class="box_h">
                <h1 style="color: #202A72;">CONHE�A AS UNIDADES DA CART�RIO POSTAL NA REGI�O NORDESTE</h1>
                <a href="javascript:history.back()" title="Clique aqui para voltar para a p�gina anterior" style="float: right;" class="link_voltar">VOLTAR</a>
                <div class="faixa_h"></div>
                <img src="<?= URL_IMAGES;?>pages/conheca-as-unidades-da-cartorio-postal-na-regiao-nordeste.png" alt="conheca as unidades da cartorio postal na regi�o nordeste" title="Conhe�a as unidades da Cart�rio Postal na Regi�o Nordeste" style="margin: 5px 0 20px 0;" />
                <strong style="font-size: 15px; color: #202A72;">FA�A SUA PESQUISA POR ESTADO, CIDADE E/OU BAIRRO</strong>
                <fieldset style="margin-top: 5px; font-size: 12px;">
                <form name="frm" action="" method="post" enctype="multipart/form-data">
                    <table border="0" width="100%" align="center" cellpadding="3" cellspacing="3">
                        <tr>
                            <td width="15%" align="left" valign="middle"><label for="fale_estado" accesskey="4">Seu Estado</label></td>
                            <td><label for="carrega_cidade" accesskey="5">Sua Cidade</label></td>
                            <td><label for="carrega_bairro" accesskey="6">Seu Bairro</label></td>
                        </tr>
                        <tr>
                            <td>
                                <select name="fale_estado" id="fale_estado" onChange="carrega_cidades(this.value,'');">
                                    <option value="">UF</option>
                                    <?
                                    $servicoDAO = new ServicoDAO();
                                    $lista = $servicoDAO->listaRegiaoNordeste();
                                    $p_valor = '';
                                    foreach ($lista as $l){
                                        $p_valor .= '<option value="'.$l->estado.'"';
                                        if($fale_estado==$l->estado) $p_valor .= 'selected="selected"'; 
                                        $p_valor .= '>'.$l->estado.'</option>';
                                    }
                                    echo $p_valor;
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select name="fale_cidade" id="carrega_cidade" class="form_estilo" onChange="carrega_bairros(fale_estado.value,this.value); carrega_franquias(this.value,fale_estado.value,'');">
                                    <? if($fale_estado<>''){ ?>
                                        <script language="javascript" type="text/javascript">
                                            carrega_cidades('<?= $fale_estado ?>','<?= $fale_cidade ?>');
                                        </script>
                                    <? } ?>	
                                </select>
                            </td>
                            <td>
                                <select name="fale_bairro" id="carrega_bairro" onChange="carrega_franquias(fale_cidade.value,fale_estado.value,this.value);">
                                <? if($fale_estado<>'' and $fale_cidade<>''){ ?>
                                    <script language="javascript" type="text/javascript">
                                        carrega_bairros('<?= $fale_estado ?>','<?= $fale_cidade ?>');
                                    </script>
                                <? } ?>	
                                </select>
                                <?
                                $empresaDAO = new EmpresaDAO();
                                $emp = $empresaDAO->listaEmpresa('','','');
                                ?>
                            </td>
                        </tr>
                    </table>
                    </form>
                </fieldset>
                <div id="carrega_franquia"></div>
            </div>
            <div class="box_h">
                <br /><strong style="font-size: 15px; color: #202A72;">ESCOLHA SUA REGI�O E VISITE NOSSA LOJA MAIS PR�XIMA DE VOC�</strong>
                <div class="faixa_h"></div>
                <div class="icones_box">
                    <a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal-na-regiao-norte/" title="Conhe�a as unidades da Cart�rio Postal na regi�o Norte">
                        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-na-regiao-norte.png" alt="conheca as unidades da cartorio postal na regiao norte" title="Conhe�a as unidades da Cart�rio Postal na regi�o Norte" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal-na-regiao-nordeste/" title="Conhe�a as unidades da Cart�rio Postal na regi�o Nordeste">
                        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-na-regiao-nordeste.png" alt="conheca as unidades da cartorio postal na regiao nordeste" title="Conhe�a as unidades da Cart�rio Postal na regi�o Nordeste" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal-na-regiao-centro-oeste/" title="Conhe�a as unidades da Cart�rio Postal na regi�o Centro Oeste">
                        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-na-regiao-centro-oeste.png" alt="conheca as unidades da cartorio postal na regiao centro oeste" title="Conhe�a as unidades da Cart�rio Postal na regi�o Centro Oeste" />
                    </a>
                </div>
                <div class="icones_box">
                    <a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal-na-regiao-sudeste/" title="Conhe�a as unidades da Cart�rio Postal na regi�o Sudeste">
                        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-na-regiao-sudeste.png" alt="conheca as unidades da cartorio postal na regiao sudeste" title="Conhe�a as unidades da Cart�rio Postal na regi�o Sudeste" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal-na-regiao-sul/" title="Conhe�a as unidades da Cart�rio Postal na regi�o Sul">
                        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-na-regiao-sul.png" alt="conheca as unidades da cartorio postal na regiao sul" title="Conhe�a as unidades da Cart�rio Postal na regi�o Sul" />
                    </a>
                </div>
				<div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>conheca-as-unidades-do-exterior-da-cartorio-postal/" title="Conheca as Unidades do Exterior da Cart�rio Postal">
                        <img src="<?= URL_IMAGES;?>pages/conheca-as-unidades-do-exterior-da-cartorio-postal.png" alt="conheca as unidades do exterior da cartorio postal" title="Conheca as Unidades do Exterior da Cart�rio Postal" />
                    </a>
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
                    <a href="<?= URL_SITE;?>porque-ser-um-franqueado-da-cartorio-postal/" title="Porque ser um franqueado da Cart�rio Postal">
                        <img src="<?= URL_IMAGES;?>pages/porque-ser-um-franqueado-cartorio-postal.png" alt="porque ser um franqueado da cartorio postal" title="Porque ser um franqueado da Cart�rio Postal" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>vantagens-da-franquia-da-cartorio-postal/" title="Vantagens da franquia da Cart�rio Postal">
                        <img src="<?= URL_IMAGES;?>pages/vantagens-da-franquia-cartorio-postal.png" alt="vantagens da franquia da cartorio postal" title="Vantagens da franquia da Cart�rio Postal" />
                    </a>
                </div>
                <div class="icones_box">
                    <a href="<?= URL_SITE;?>pre-cadastro-da-franquia-cartorio-postal/" title="Pr� cadastro da franquia Cart�rio Postal">
                        <img src="<?= URL_IMAGES;?>pages/pre-cadastro-da-franquia-cartorio-postal.png" alt="pre cadastro da franquia cartorio postal" title="Pr� cadastro da franquia Cart�rio Postal" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal/" title="Conhe�a as unidades da Cart�rio Postal">
                        <img src="<?= URL_IMAGES;?>pages/conheca-as-unidades-da-cartorio-postal.png" alt="conheca as unidades da cartorio postal" title="Conhe�a as unidades da Cart�rio Postal" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>galeria-de-fotos-da-cartorio-postal/" title="Galeria de fotos da Cart�rio Postal">
                        <img src="<?= URL_IMAGES;?>pages/galeria-de-fotos-da-cartorio-postal.png" alt="galeria de fotos da cartorio postal" title="Galeria de fotos da Cart�rio Postal" />
                    </a>
                </div>
            </div>
        </div>
        <div class="box_g">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top">
                        <a href="<?= URL_SITE;?>pre-cadastro-da-franquia-cartorio-postal/" title="Fa�a seu Pr� cadastro">
                            <img src="<?= URL_IMAGES;?>pages/faca-seu-pre-cadastro.png" alt="faca seu pre cadastro" title="Fa�a seu Pr� cadastro" style="margin-bottom: 20px;" />
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="box_i">
                            <h2 style="color: #202A72;">PRINCIPAIS SERVI�OS:</h2>
                            <div class="faixa_h"></div>
                            <ul class="marcador_servicos">
                                <?= PRINCIPAIS_SERVICOS;?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" height="205">
                        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-excelencia-em-franchising-2012.png" alt="cartorio postal excelencia em franchising-2012" title="Cart�rio Postal - Excel�ncia em Franchising 2012" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="box_i" style="margin-top: 20px;">
            <h4 style="color: #202A72;">OFERECEMOS TAMB�M:</h4>
            <div class="faixa_h"></div>
            <ul class="marcador_servicos">
                <?= OFERECEMOS_TAMBEM;?>
            </ul>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>