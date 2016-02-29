<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/funcoes.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/global.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/model/Database.php');

$siteDAO = new SiteDAO();
$p_valor = '';
pt_register('GET','pagina');

$lista = $siteDAO->listaDepoimento((int)($pagina));

foreach($lista as $l){
	$p_valor .= '<img src="'. URL_IMAGES .'aspas1.gif" alt="abre aspas"/>'.$l->depoimento.'<img src="'. URL_IMAGES .'aspas2.gif" alt="fecha aspas"/></p><b>Por: '.$l->nome.'</b><br><br>';
}

$lista = array($siteDAO->QTDPaginaAjax(),4,$pagina,'carrega_depoimento(\'##pagina\');');
$paginacao = AjaxPaginacao($lista);
echo $p_valor.''.$paginacao.'';
?>