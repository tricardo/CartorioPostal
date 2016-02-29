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
						<th class="centro">Abrir</th>
						<th>Nome</th>
						<th class="centro">Acessos</th>
					</tr>
					</thead>';
pt_register('GET','busca_duvida');
pt_register('GET','busca_cat');
pt_register('GET','pagina');

$lista = $siteDAO->buscaDuvidas($busca_duvida,$busca_cat,$pagina);
$cont=0;

foreach($lista as $l){	
	$p_valor .= '<tr '.$classe.'>';
	$p_valor .= '<td class="centro"><a href="duvida-certidao-ver.php?id=' . $l->id_duvida . '&busca_cat='.$busca_cat.'" class="link"><img src="'.URL_IMAGES.'icon/edit.png" width="16" height="16" /></a></td>';
	$p_valor .= '<td><a href="duvida-certidao-ver.php?id=' . $l->id_duvida . '&busca_cat='.$busca_cat.'" title="Artigo: '. $l->titulo . '" class="link">' . $l->titulo . '</a></td>';
	$p_valor .= '<td class="centro"><a href="duvida-certidao-ver.php?id=' . $l->id_duvida . '&busca_cat='.$busca_cat.'" class="link">' . $l->view . '</a></td>';
	$p_valor .= '</tr>';
	if(($cont%2)==0)	$classe = 'class="odd"'; else $classe='';
	$cont++;
}

$lista = array($siteDAO->QTDPaginaAjax(),25,$pagina,'carrega_duvidas(\''.$busca_duvida.'\',\''.$busca_cat.'\',\'##pagina\');');
$paginacao = AjaxPaginacao($lista);
echo $p_valor.'<tr><td colspan="3" class="paginacao">'.$paginacao.'</td></tr></table>';
?>