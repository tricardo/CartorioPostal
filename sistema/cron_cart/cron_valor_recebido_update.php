<?php
require("../includes/verifica_logado_controle.inc.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");

$conta = new CronDAO();
$dt = $conta->CronValorPago();

$pedido    = array();
$valor     = array();
$id_fatura = 0;
$i 		   = 0;
$j         = 0;

foreach($dt as $k => $arr){
	if($id_fatura == 0){
		$id_fatura = $arr->id_fatura;
		$pedido[$i] = array(
			'id_empresa'=>$arr->id_empresa, 	
			'id_fatura'=>$arr->id_fatura,
			'tipo'=>$arr->tipo,
			'valor_custas'=>$arr->valor_custas,
			'valor_pago'=>(float)$arr->valor_pago
		);
		$valor[$i][$j] = array(
			'id_pedido_item'=>$arr->id_pedido_item,
			'valor'=>$arr->valor,
			'valor_rec'=>$arr->valor_rec
		);
		#echo $arr->id_pedido_item.' |A  '.$i.'-'.$j.'<br>';
	} else {
		if($arr->id_fatura == $id_fatura){
			$j++;
			$valor[$i][$j] = array(
				'id_pedido_item'=>$arr->id_pedido_item,
				'valor'=>$arr->valor,
				'valor_rec'=>$arr->valor_rec
			);
			#echo $arr->id_pedido_item.' |B  '.$i.'-'.$j.'<br>';
		} else {
			$i++;
			$j = 0;
			$pedido[$i] = array(
				'id_empresa'=>$arr->id_empresa, 	
				'id_fatura'=>$arr->id_fatura,
				'tipo'=>$arr->tipo,
				'valor_custas'=>$arr->valor_custas,
				'valor_pago'=>(float)$arr->valor_pago
			);
			$valor[$i][$j] = array(
				'id_pedido_item'=>$arr->id_pedido_item,
				'valor'=>$arr->valor,
				'valor_rec'=>$arr->valor_rec
			);
			#echo $arr->id_pedido_item.' |C  '.$i.'-'.$j.'<br>';
		}
		$id_fatura = $arr->id_fatura;
	}
}
#exit();
for($i = 0; $i < count($pedido); $i++){
	$v = number_format($pedido[$i]['valor_pago'], 2, ',', '.');
	echo '<div style="font-weight:bold">'.$pedido[$i]['id_empresa'] . ' | ';
	echo 'fatura = '.$pedido[$i]['id_fatura'] . ' | valor pago = ';
	echo $v;
	echo '</div>';
	$total_temp = $pedido[$i]['valor_pago'];
	
	$total = $pedido[$i]['valor_pago'];
	for($j = 0; $j < count($valor[$i]); $j++){
		$subtracao = (float)$valor[$i][$j]['valor'] - $valor[$i][$j]['valor_rec'];
		if($pedido[$i]['tipo'] == 1 || $pedido[$i]['tipo'] == 4){
			$subtracao = (float)($valor[$i][$j]['valor'] + $pedido[$i]['valor_custas']) - $valor[$i][$j]['valor_rec'];
		}
		
		$total = (float)$total - $subtracao;
		
		$v1 = (float)$valor[$i][$j]['valor'];
		$v2 = (float)$valor[$i][$j]['valor_rec'];
		
		$total2 = $v1 - $v2;
		if(($j + 1) == count($valor[$i])){
			$total2 = ($v1 - $v2) + $total;
		}
				
		echo ($j + 1) .'-> ';
		echo $valor[$i][$j]['id_pedido_item'] . ' | ';
		echo number_format($total_temp, 2, ',', '.') . ' - (';
		if($pedido[$i]['tipo'] == 1 || $pedido[$i]['tipo'] == 4){
			echo '('.number_format($v1, 2, ',', '.') . ' + ';
			echo number_format($pedido[$i]['valor_custas'], 2, ',', '.').') - ';
		} else {
			echo number_format($v1, 2, ',', '.') . ' - ';
		}
		echo number_format($v2, 2, ',', '.') .') = ';
		echo number_format($total, 2, ',', '.');
		if(($j + 1) == count($valor[$i])){
			$testa = $pedido[$i]['valor_pago'];
			$resto = (float)($subtracao + $total);
			if($total == $testa){
				echo '';
			}else{
				echo ' | lançar '.$resto;
			}
		} else {
			echo $subtracao;
		}
		echo '<br />';
		$total_temp = $total;
	}
	echo '<hr>';
}
?>