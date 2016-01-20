<? require('header-ajax.php');

if(!$c->ano) $c->ano = date('Y');
if(!$c->mes) $c->mes = date('m');

$dias_mes = ultimoDiaMes('01/'.$c->mes.'/'.$c->ano);
if(strlen($c->mes)==1) $c->mes2 = '0'.$c->mes; else $c->mes2 = $c->mes;

$dt = $expansao->agenda(1,$c,$exp_item);
foreach($dt as $b => $res){ 
	$evento_dia[(int)($res->dia)]=$res->dia;
	$evento_qtd[(int)($res->dia)]=$res->total;
}
$p_valor = '<ul>';
$cont=0;
$dia_semana = diasemana($c->ano.'/'.$c->mes.'/01');
if($dia_semana!=0){
	while($cont<$dia_semana){
		$cont2 = ($cont % 2);
		$p_valor .= '<li></li>';
		$cont++;
	}
} 
while($cont<35){
	$cont3=$cont-$dia_semana+1;
	$cont++;
	$classe = '';
	if($evento_qtd[$cont3] > 0){
		$classe = 'tem_evento';
	}
	if($cont3<=$dias_mes){
		$p_valor .= '<li id="dia'.$cont3.'" class="'.$classe.'"><a href="javascript:void();" 
			onclick="carrega_evento(\''.$cont3.'\',\''.$c->mes.'\',\''.$c->ano.'\');parent.document.getElementById(\'expansao_frame\').style.height=\'2000px\'">'.$cont3.'</a></li>';
	} else {
		$p_valor .= '<li></li>';
	}
}
echo $p_valor.'</ul>';
?>