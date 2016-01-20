<?php
ini_set('memory_limit','128M'); 
include('funcoes.php');


$teste = new TesteDAO();
$data = $teste->royaltie_mensal('2014-07');
echo '<html><head><style>
body { 
	margin: 1%; 
	text-align: left; 
	ont-family: Arial;
	font-size: 14px;
	}
table {
	font-family: Arial;
	font-size: 14px;
	width: 100%;
}
table thead tr th, table tfoot tr th {
	font-weight: bold;
	background: #BBB;
	text-align: left;
}
table tbody tr th {
	font-weight: normal;
	text-align: left;
}
th {
	border: solid 1px #DDD;
	padding: 5px;
}
</style></head><body>';
echo '<p>Mês Julho/2014</p>';
echo '<table>';
echo '<thead>
<tr>
<th>Data</td>
<th>Unidade</td>
<th>Royaltie</td>
<th>FPP</td>
</tr></thead><tbody>';
$roy = 0; $fpp = 0;
for($i = 0; $i < count($data); $i++){
	$dt = explode('-', $data[$i]->data_relatorio);
	$data[$i]->data_relatorio = $dt[2].'/'.$dt[1].'/'.$dt[0];
	echo '<tr>';
	echo '<th>'.$data[$i]->data_relatorio.'</td>';
	echo '<th>'.$data[$i]->empresa.'</td>';
	echo '<th>'.$data[$i]->roy.'</td>';
	echo '<th>'.$data[$i]->fpp.'</td>';
	echo '</tr>';
	$fpp = $fpp + $data[$i]->fpp;
	$roy = $roy + $data[$i]->roy;
}
echo '</tbody><tfoot><tr>';
	echo '<th></td>';
	echo '<th></td>';
	echo '<th>'.$roy.'</td>';
	echo '<th>'.$fpp.'</td>';
	echo '</tr></tfoot>';
echo '</table>';
echo '</body></html>';
