<? 
header("Content-Type: text/html; charset=ISO-8859-1",true); 
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('GET','ano');
pt_register('GET','mes');


if(!$ano) $ano = date('Y');
if(!$mes) $mes = date('m');

if($mes==12) {
	$mes_p=1;
	$ano_p=$ano+1;
} else {
	$mes_p=$mes+1;
	$ano_p=$ano;
}

if($mes==01) {
	$mes_a=12;
	$ano_a=$ano-1;
} else {
	$mes_a=$mes-1;
	$ano_a=$ano;
}

?>
<a href="javascript:void()" onclick="carrega_calendar('<?= $mes_a ?>','<?= $ano_a ?>');"><img src="../images/eventos/seta_e.png"></a><?= mes_ext($mes).' de '.$ano ?><a href="javascript:void()" onclick="carrega_calendar('<?= $mes_p ?>','<?= $ano_p ?>');"><img src="../images/eventos/seta_d.png"></a>
