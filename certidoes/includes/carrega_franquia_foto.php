<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/funcoes.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/global.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/model/Database.php');

$siteDAO = new SiteDAO();
$p_valor = '<table cellpadding="0" cellspacing="0" border="0" class="jtable">
					<thead>
					<tr>
						<th class="centro" colspan="3">Galeria de Fotos: Inaugurações e Feiras</th>
					</tr>
					</thead>';
pt_register('GET','busca_franquia');
pt_register('GET','pagina');

$lista = $siteDAO->buscaFranquiaGaleria($busca_franquia,$pagina);
$cont=0;

foreach($lista as $l){	
	if($l->imagem_thumb<>'')$imagem_thumb = $l->imagem_thumb; else $imagem_thumb = 'franquia.jpg';
	$p_valor .= '<tr '.$classe.'>';
	$p_valor .= '<td class="centro"><a href="/franquia/sobre-franquia-ver/' . $l->id_thumbnail . '/" class="link"><img src="'.URL_SITE.'upload/thumb/' . $imagem_thumb . '" border="0" width="40"></a></td>';
	$p_valor .= '<td><a href="/franquia/sobre-franquia-ver/' . $l->id_thumbnail . '/" title="Artigo: '. $l->titulo . '" class="link">' . $l->titulo . '</a></td>';
	$p_valor .= '<td class="centro"><a href="/franquia/sobre-franquia-ver/' . $l->id_thumbnail . '/" class="link">' . $l->descricao. '</a></td>';
	$p_valor .= '</tr>';
	if(($cont%2)==0)	$classe = 'class="odd"'; else $classe='';
	$cont++;
}

$lista = array($siteDAO->QTDPaginaAjax(),25,$pagina,'carrega_franquia(\''.$busca_franquia.'\',\'##pagina\');');
$paginacao = AjaxPaginacao($lista);
echo $p_valor.'<tr><td colspan="3" class="paginacao">'.$paginacao.'</td></tr></table>';
?>