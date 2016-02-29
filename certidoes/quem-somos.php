<?
$id_meta=2;
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
        <a href="http://www3.catho.com.br/empregos/cartorio" title="Oportunidades de carreira na Cartório Postal, clique aqui" target="_blank">
            <img src="<?= URL_IMAGES;?>pages/oportunidades-de-carreira-na-cartorio-postal.png" alt="oportunidades de carreira na cartorio postal clique aqui" title="Oportunidades de carreira na Cartório Postal, clique aqui" style="margin-top: 20px;" />
        </a>
    </div>
    <div id="contant">
        <h1 style="color: #202A72;">QUEM SOMOS</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/quem-somos-buscamos-e-enviamos-suas-certidoes.png" alt="quem somos buscamos e enviamos suas certidoes para todo o territorio nacional" title="Quem somos: Buscamos e enviamos suas Certidões para todo o território nacional" style="margin: 5px 0 0 0;" />
        <div id="texto">
            A <strong>Cartório Postal</strong> é uma empresa de intermediação cartorária que apresenta um mix diversificado de serviços direcionados a pessoas físicas e jurídicas.<br /><br />
            Com mais de 19 anos de atuação no mercado brasileiro, a <strong>Cartório Postal</strong> é uma empresa pioneira que oferece intermediação na obtenção de documentos públicos e privados em todo o país e também presta assessoria completa para escritórios de contabilidade, imobiliárias, construtoras, advogados, bancos e instituições financeiras.<br /><br />
            Entre os principais serviços oferecidos, estão: busca de 2ª via de certidões (nascimento, casamento, óbito); pesquisa patrimonial (imóvel e veículo); encaminhamento de títulos para protesto (cheques, notas promissórias, duplicatas etc); reabilitação de crédito; regularização de imóveis; matrícula atualizada de imóveis; cidadania; pasta pronta (todos os documentos e procedimentos necessários para o processo de compra e venda, financiamento e consórcios); entre outros.<br /><br />
            Atualmente, a rede de franquias conta com mais de <?= $u_ativas;?> unidades espalhadas por todo o Brasil, garantindo agilidade, eficiência e excelência no atendimento.<br /><br />
            A missão da <strong>Cartório Postal</strong> é a de se manter como líder absoluta no segmento, zelando para que os serviços prestados pelos franqueados mantenham o mesmo padrão de qualidade praticado pelo Grupo Sistecart.<br /><br />
            <h3 style="color: #202A72;">PRINCIPAIS BENEFÍCIOS PARA O CLIENTE CARTÓRIO POSTAL</h3>
            <div class="faixa_h"></div>
            <ul>
                <li class="list_ordenada_a">Eliminação do tempo despendido na busca de documentos;</li>
                <li class="list_ordenada_a">Atendimento qualificado;</li>
                <li class="list_ordenada_a">Agilidade na busca e entrega dos documentos solicitados;</li>
                <li class="list_ordenada_a">Obtenção de documentos em qualquer lugar do Brasil;</li>
                <li class="list_ordenada_a">Comodidade para o cliente ao receber os documentos no local indicado;</li>
                <li class="list_ordenada_a">Otimização na gestão de serviços e documentos solicitados;</li>
                <li class="list_ordenada_a">Facilidade no controle administrativo dos pedidos;</li>
                <li class="list_ordenada_a">Rede com mais de <?= $u_ativas;?> unidades em todo o território nacional;</li>
                <li class="list_ordenada_a">Serviços executados com exatidão e sigilo.</li>
            </ul>
            <h4 style="color: #202A72;">SELO DE EXCELÊNCIA EM FRANCHISING 2012</h4>
            <div class="faixa_h"></div>
            <div class="selo_abf_a">
                Em maio de 2012, a <strong>Cartório Postal</strong> foi agraciada com o Selo Excelência em Franchising concedido pela Associação Brasileira de Franchising (ABF). A empresa também ocupa o primeiro lugar no ranking das marcas mais procuradas na ABF e também está no topo da lista de franquias com mais cadastros de investidores em 2011. 
            </div>
            <div class="selo_abf_b">
                <img src="<?= URL_IMAGES;?>pages/premio-abf-destaque-franchising-e-selo-de-excelencia-em-franchising-2012.png" alt="premio abf destaque franchising e selo de excelencia em franchising 2012" title="Prêmio ABF destaque franchising e Sêlo de Excelência em Franchising 2012" />
            </div>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>