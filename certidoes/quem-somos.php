<?
$id_meta=2;
$pg = 'paginas';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');
?>
<div id="container">
    <div class="box_e">
        <h2 style="color: #202A72;">SOLICITE SUA CERTID�O AGORA</h2>
        <div class="faixa_h"></div>
        <div id="servicos">
            <?require_once(URL_SITE_INCLUDE.'colunae.php');?>
        </div>
        <a href="http://www3.catho.com.br/empregos/cartorio" title="Oportunidades de carreira na Cart�rio Postal, clique aqui" target="_blank">
            <img src="<?= URL_IMAGES;?>pages/oportunidades-de-carreira-na-cartorio-postal.png" alt="oportunidades de carreira na cartorio postal clique aqui" title="Oportunidades de carreira na Cart�rio Postal, clique aqui" style="margin-top: 20px;" />
        </a>
    </div>
    <div id="contant">
        <h1 style="color: #202A72;">QUEM SOMOS</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a p�gina anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/quem-somos-buscamos-e-enviamos-suas-certidoes.png" alt="quem somos buscamos e enviamos suas certidoes para todo o territorio nacional" title="Quem somos: Buscamos e enviamos suas Certid�es para todo o territ�rio nacional" style="margin: 5px 0 0 0;" />
        <div id="texto">
            A <strong>Cart�rio Postal</strong> � uma empresa de intermedia��o cartor�ria que apresenta um mix diversificado de servi�os direcionados a pessoas f�sicas e jur�dicas.<br /><br />
            Com mais de 19 anos de atua��o no mercado brasileiro, a <strong>Cart�rio Postal</strong> � uma empresa pioneira que oferece intermedia��o na obten��o de documentos p�blicos e privados em todo o pa�s e tamb�m presta assessoria completa para escrit�rios de contabilidade, imobili�rias, construtoras, advogados, bancos e institui��es financeiras.<br /><br />
            Entre os principais servi�os oferecidos, est�o: busca de 2� via de certid�es (nascimento, casamento, �bito); pesquisa patrimonial (im�vel e ve�culo); encaminhamento de t�tulos para protesto (cheques, notas promiss�rias, duplicatas etc); reabilita��o de cr�dito; regulariza��o de im�veis; matr�cula atualizada de im�veis; cidadania; pasta pronta (todos os documentos e procedimentos necess�rios para o processo de compra e venda, financiamento e cons�rcios); entre outros.<br /><br />
            Atualmente, a rede de franquias conta com mais de <?= $u_ativas;?> unidades espalhadas por todo o Brasil, garantindo agilidade, efici�ncia e excel�ncia no atendimento.<br /><br />
            A miss�o da <strong>Cart�rio Postal</strong> � a de se manter como l�der absoluta no segmento, zelando para que os servi�os prestados pelos franqueados mantenham o mesmo padr�o de qualidade praticado pelo Grupo Sistecart.<br /><br />
            <h3 style="color: #202A72;">PRINCIPAIS BENEF�CIOS PARA O CLIENTE CART�RIO POSTAL</h3>
            <div class="faixa_h"></div>
            <ul>
                <li class="list_ordenada_a">Elimina��o do tempo despendido na busca de documentos;</li>
                <li class="list_ordenada_a">Atendimento qualificado;</li>
                <li class="list_ordenada_a">Agilidade na busca e entrega dos documentos solicitados;</li>
                <li class="list_ordenada_a">Obten��o de documentos em qualquer lugar do Brasil;</li>
                <li class="list_ordenada_a">Comodidade para o cliente ao receber os documentos no local indicado;</li>
                <li class="list_ordenada_a">Otimiza��o na gest�o de servi�os e documentos solicitados;</li>
                <li class="list_ordenada_a">Facilidade no controle administrativo dos pedidos;</li>
                <li class="list_ordenada_a">Rede com mais de <?= $u_ativas;?> unidades em todo o territ�rio nacional;</li>
                <li class="list_ordenada_a">Servi�os executados com exatid�o e sigilo.</li>
            </ul>
            <h4 style="color: #202A72;">SELO DE EXCEL�NCIA EM FRANCHISING 2012</h4>
            <div class="faixa_h"></div>
            <div class="selo_abf_a">
                Em maio de 2012, a <strong>Cart�rio Postal</strong> foi agraciada com o Selo Excel�ncia em Franchising concedido pela Associa��o Brasileira de Franchising (ABF). A empresa tamb�m ocupa o primeiro lugar no ranking das marcas mais procuradas na ABF e tamb�m est� no topo da lista de franquias com mais cadastros de investidores em 2011. 
            </div>
            <div class="selo_abf_b">
                <img src="<?= URL_IMAGES;?>pages/premio-abf-destaque-franchising-e-selo-de-excelencia-em-franchising-2012.png" alt="premio abf destaque franchising e selo de excelencia em franchising 2012" title="Pr�mio ABF destaque franchising e S�lo de Excel�ncia em Franchising 2012" />
            </div>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>