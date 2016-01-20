<? require('topo.php');  
echo '<table>';
$soma = 0;
for($i = 1; $i <= 31; $i++){
	$dia = ($i < 10) ? '0'.$i : $i;
	$mes = ((int)date('m')) ? '0'.((int)date('m')) : date('m');
	$ano = 	date('Y');
	$data= $dia.'/'.$mes.'/'.$ano;
	$dt = $expansao->fichaCadDia($data);
	echo '<tr><td>'.$data . '</td><td>'. $dt[0]->total . '</td></tr>';
	$soma = $soma + $dt[0]->total;
}
echo '<tr><td>Total</td><td>'.$soma.'</td></tr>';
echo '</table>';
 require('rodape.php'); ?>