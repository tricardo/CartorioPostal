<?php
ini_set('memory_limit','128M'); 
include('funcoes.php');


$teste = new TesteDAO();
$data = $teste->royaltie_inativa(((isset($_GET['id']) AND is_numeric($_GET['id'])) ? $_GET['id'] : 0), date('Y'));
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
echo '<p>Recebimentos de Royalties e FPP</p>';
echo '<table>';
echo '<thead>
<tr>
<th>Franquia</th>
<th>Referência</td>
<th>Royalties á Receber</th>
<th>FPP á Receber</th>
<th>Royalties Recebido</th>
<th>FPP Recebido</th>
</tr></thead><tbody>';
$roy = 0; $fpp = 0; $roy_rec = 0; $fpp_rec = 0;
for($i = 0; $i < count($data); $i++){
	$roy = $roy + $data[$i]->roy;
	$fpp = $fpp + $data[$i]->fpp;
	$roy_rec = $roy_rec + $data[$i]->roy_rec;
	$fpp_rec = $fpp_rec + $data[$i]->fpp_rec;
	
	echo '<tr>';
	echo '<th>'.$data[$i]->fantasia.'</th>';
	echo '<th>'.$data[$i]->ref.'</th>';
	echo '<th>'.$data[$i]->roy.'</th>';
	echo '<th>'.$data[$i]->fpp.'</th>';
	echo '<th>'.$data[$i]->roy_rec.'</th>';
	echo '<th>'.$data[$i]->fpp_rec.'</th>';
	echo '</tr>';
}
echo '</tbody><tfoot><tr>';
	echo '<th></th>';
	echo '<th></th>';
	echo '<th>'.$roy.'</th>';
	echo '<th>'.$fpp.'</th>';
	echo '<th>'.$roy_rec.'</th>';
	echo '<th>'.$fpp_rec.'</th>';
	echo '</tr></tfoot>';
echo '</table>';
echo '</body></html>';
