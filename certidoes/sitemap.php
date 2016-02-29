<? 
$id_meta=1;
$pg = 'certidao';
require('includes/url.php');
#require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require_once(URL_SITE_INCLUDE.'browser.php');
require_once(URL_SITE_INCLUDE.'classQuery.php');
require_once(URL_SITE_MODEL.'Database.php');
require_once(URL_SITE_MODEL.'DatabaseSite.php');
require_once(URL_SITE_INCLUDE.'global.php');
require_once(URL_SITE_INCLUDE.'funcoes.php');

$pedidoDAO = new PedidoDAO();
$sitemapDAO = new SitemapDAO();

$p_valor = '<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';

#$lista = $sitemapDAO->SitemapFotos();
#foreach($lista as $l){
#	$p_valor .= '
#	<url>
#		<loc>http://www.cartoriopostal.com.br/franquia/sobre-franquia-ver/'.$l->id_thumbnail.'/</loc>
#		<changefreq>weekly</changefreq>
#	</url>
#';
#}

#$lista = $sitemapDAO->SitemapImprensa();
#foreach($lista as $l){
#	$p_valor .= '
#	<url>
#		<loc>http://www.cartoriopostal.com.br/certidoes/certidao-imprensa-ver.php?id='.$l->id_imprensa.'&amp;id_imprensa_cat='.$l->id_imprensa_cat.'</loc>
#		<changefreq>weekly</changefreq>
#	</url>
#';
#}

#$lista = $sitemapDAO->SitemapDuvidas();
#foreach($lista as $l){
#	$p_valor .= '
#	<url>
#		<loc>http://www.cartoriopostal.com.br/certidoes/duvida-certidao-ver.php?id='.$l->id_duvida.'&amp;busca_cat='.$l->id_cat.'</loc>
#		<changefreq>weekly</changefreq>
#	</url>
#';
#}

$lista = $pedidoDAO->selectServicosSite();
foreach($lista as $l){
	if($l->desc_site<>'') $descricao_menu = $l->desc_site; else $descricao_menu=$l->descricao;
	$p_valor .= '
	<url>
		<loc>http://www.cartoriopostal.com.br/certidao/'.$l->id_servico.'/'.str_replace('-2a-via','',strtolower(limpa_url($descricao_menu))).'</loc>
		<changefreq>weekly</changefreq>
	</url>
';
}
$empresaDAO = new EmpresaDAO();
$lista = $empresaDAO->listaEmpresas();
foreach($lista as $l){
	$p_valor .= '
	<url>
		<loc>http://www.cartoriopostal.com.br/'.strtolower(limpa_url(str_replace(' ','',$l->estado))).'/'.strtolower(limpa_url(str_replace(' ','',$l->cidade))).'-'.strtolower(limpa_url(str_replace(' ','',$l->bairro))).'</loc>
		<changefreq>weekly</changefreq>
	</url>
';
}

$p_valor .= '
</urlset>';

$arquivoDiretorio = "../sitemap_outros.xml";
$nomeArquivo = "sitemap_outros.xml";
$arquivoConteudo = $p_valor;

if(fopen($arquivoDiretorio,"w+")) {

	if (!$handle = fopen($arquivoDiretorio, 'w+')) {
		echo "<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
		exit;
	}

	if(!fwrite($handle, $arquivoConteudo)) {
		echo"<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ESCREVER NO ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
		exit;
	}
} else {
	echo"<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
	exit;
}
?>