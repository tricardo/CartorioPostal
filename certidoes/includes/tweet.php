<?
define('MAGPIE_DIR', 'includes/rss/');
require_once(MAGPIE_DIR.'rss_fetch.inc');
$url = 'http://twitter.com/statuses/user_timeline/cartoriopostal.rss';
if($url){
	$rss = fetch_rss($url);
	$cont=0;
	$widget='<div class="tweet">';
	foreach ($rss->items as $item){
		$href = $item['link'];
		$title = $item['title'];
		$description = $item['description'];
		$summary = $item['summary'];
		$atom_content = $item['atom_content'];
		$pubdate = $item['pubdate'];
		$pubdate =str_replace('Sun','Dom.',$pubdate);
		$pubdate =str_replace('Mon','Seg.',$pubdate);
		$pubdate =str_replace('Thu','Ter.',$pubdate);
		$pubdate =str_replace('Wed','Qua.',$pubdate);
		$pubdate =str_replace('Thu','Qui.',$pubdate);
		$pubdate =str_replace('Fri','Sex.',$pubdate);
		$pubdate =str_replace('Sat','Sáb.',$pubdate);
		$pubdate =str_replace('Feb','Fev',$pubdate);
		$pubdate =str_replace('Apr','Abr',$pubdate);
		$pubdate =str_replace('May','Mai',$pubdate);
		$pubdate =str_replace('Aug','Ago',$pubdate);
		$pubdate =str_replace('Sep','Set',$pubdate);
		$pubdate =str_replace('Oct','Out',$pubdate);
		$pubdate =str_replace('Dec','Dez',$pubdate);
		$pubdate =str_replace('+0000','',$pubdate);
		$title =str_replace('cartoriopostal:','',$title);
		$title =str_replace('#','',$title);
		$widget.= '
		<a href="'.$href.'" title="Clique aqui" target="_blank"><strong style="color: #202A72;">Cartório Postal: </strong>'.$title.'
		<br />'.$pubdate.'</a>';
                $cont++;
		if($cont>=4) break;
	}
	echo $widget.'</div>';
}
?>