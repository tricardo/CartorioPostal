<? require('header-ajax.php');

if(!$c->ano) $c->ano = date('Y');
if(!$c->mes) $c->mes = date('m');

if($c->mes==12) {
	$c->mes_p=1;
	$c->ano_p=$c->ano+1;
} else {
	$c->mes_p=$c->mes+1;
	$c->ano_p=$c->ano;
}

if($c->mes==01) {
	$c->mes_a=12;
	$c->ano_a=$c->ano-1;
} else {
	$c->mes_a=$c->mes-1;
	$c->ano_a=$c->ano;
} ?>
<a href="javascript:void()" onclick="carrega_calendar('<?= $c->mes_a ?>','<?= $c->ano_a ?>');">
	<img src="../images/eventos/seta_e.png"></a><?= mes_ext($c->mes).' de '.$c->ano ?>
</a>
<a href="javascript:void()" onclick="carrega_calendar('<?= $c->mes_p ?>','<?= $c->ano_p ?>');">
	<img src="../images/eventos/seta_d.png">
</a>
