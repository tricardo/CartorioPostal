<? require('header-ajax.php');

if(!$c->ano) $c->ano = date('Y');
if(!$c->mes) $c->mes = date('m');
if(!$c->dia) $c->dia = date('d');

if(strlen($c->mes)==1) $c->mes2 = '0'.$c->mes; else $c->mes2 = $c->mes;
if(strlen($c->dia)==1) $c->dia2 = '0'.$c->dia; else $c->dia2 = $c->dia;


$dt = $expansao->agenda(2,$c,$exp_item); 
?>
<h2 style="color:#0A4F80">Dia <?= (int)($c->dia) ?> de <?= mes_ext($c->mes) ?> de <?= (int)($c->ano) ?></h2>
<table class="result_tabela" cellpadding="4" cellspacing="1" width="100%">
	<tr style="font-weight:bold">
		<td class="result_menu" style="width:50px;text-align:center">&nbsp;</td>
		<td class="result_menu" style="width:80px;text-align:center">Data</td>
		<td class="result_menu">Nome</td>
		<td class="result_menu">Consultor</td>
		<td class="result_menu">Fez Contato</td>
		<td class="result_menu" style="width:270px;text-align:center">Status</td>
	</tr>
<? $exp_item->id_departamento_p = explode(',',$exp_item->id_departamento_p);
foreach($dt as $b => $res){ 
	$mostrar = 0;
	if($exp_item->id_usuario == 1){
		$mostrar = 1;
	}
	if((in_array(29, $exp_item->id_departamento_p)) && $mostrar == 0){ 
		$mostrar = 1;
	} 
	if($mostrar == 0 && $res->id_usuario == $exp_item->id_usuario){
		$mostrar = 1;
	}
	
	
	$color = ($color == '#FFF') ? '#F8F8F8' : '#FFF';
	echo '<tr>';
	if($mostrar == 1){
		echo '<td class="result_celula" style="text-align:center;background-color:'.$color.'"><a href="fichas-editar.php?id_ficha='.$res->id_ficha.'&aba=3">'.$res->id_ficha.'</a></td>';
	} else {
		echo '<td class="result_celula" style="text-align:center;background-color:'.$color.'">'.$res->id_ficha.'</td>';
	}
	echo '<td class="result_celula" style="text-align:center;background-color:'.$color.'">'.invert($res->agenda,'/','PHP').'</td>';
	echo '<td class="result_celula" style="background-color:'.$color.'">'.ucwords(strtolower($res->cliente)).'</td>';
	echo '<td class="result_celula" style="background-color:'.$color.'">'.ucwords(strtolower($res->consultor)).'</td>';
	echo '<td class="result_celula" style="background-color:'.$color.'">'.ucwords(strtolower($res->relacionamento)).'</td>';
	echo '<td class="result_celula" style="text-align:center;background-color:'.$color.'">'.$res->status1.'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="6" class="result_celula" style="background-color:'.$color.';border-bottom:2px #D5D5D5 dashed"><b>Observação: </b>'.strtolower($res->obs).'<br />&nbsp;</td>';
	echo '</tr>';
} ?>
</table>
