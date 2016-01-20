<?php include('funcoes.php');
$c = new stdClass();
$expansao = new ExpansaoDAO();
$status = $expansao->listarStatus();
$consultor = $expansao->relatorioDiretoria(1, $c);
$dia       = date('d/m/Y H:i:s');
$HTML = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sistecart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>
<body>';
$HTML .= '<table cellpadding="1" cellspacing="4" style="font-family:Arial;font-size:10px; border:none;">
	<tr>		
		<td style="border:none;padding-bottom:10px;font-size:13px" colspan="'.(count($consultor)+2).'">
			&nbsp;DATA: '.$dia.'<br />
			&nbsp;TOTAL DE FICHAS DO DIA: '.$expansao->relatorioDiretoria(4, $c).'
		</td>
	</tr>
	<tr>
		<td style="border:solid 1px #999;background-color:#CCC;font-weight:bold;width:180px;text-align:center" rowspan="2">ATIVIDADE</td>
		<td style="border:solid 1px #999;background-color:#CCC;text-align:center;font-weight:bold;" colspan="'.(count($status)+1).'">STATUS</td>
	</tr>
	<tr>'."\n";

		foreach($status as $b => $res){
			$HTML .= "\t\t<td style=\"border:solid 1px #999;background-color:#CCC;font-weight:bold;text-align:center;width:100px;\">";
			$HTML .= strtoupper(strtolower($res->status))."</td>\n";
		}
		
		
		$HTML .= "\t\t<td style=\"border:solid 1px #999;background-color:#CCC;text-align:center;font-weight:bold;width:100px;\">TOTAL</td>";
	$HTML .= "\t</tr>\n";
	#echo $HTML;exit;
	
	$total_cols = 0; 
	$total_rows = array(); 
	$j          = 0;
	$color      = "#EEE";
	foreach($consultor as $b1 => $res1){
		$color      = $color == "#EEE" ? "#FFF" : "#EEE";
		$i          = 0;
		$total_cols = 0;
		$HTML      .= "\t<tr>\n";
		$HTML      .= "\t\t<td style=\"border:solid 1px #999;font-weight:bold;background-color:".$color."\">&nbsp;".strtoupper(strtolower($res1->nome))."</td>\n";
		foreach($status as $b => $res){
			$HTML .= "\t\t<td style=\"border:solid 1px #999;text-align:center;font-size:13px;background-color:".$color."\">";
			$c->id_usuario = $res1->id_usuario;
			$c->id_status = $res->id_status;
			$total = $expansao->relatorioDiretoria(3, $c);
			$HTML .= $total;
			$HTML .= "</td>\n";
			$total_cols = $total_cols + $total;
			$total_rows[$i] = $total_rows[$i] + $total;
			$i++;
		}
		$cor      = $total_cols == 0 ? "#CC0000" : "#000"; 
		$HTML     .= "\t\t<td style=\"border:solid 1px #999;text-align:center;font-weight:bold;width:80px;font-size:13px;background-color:".$color.";color:".$cor."\">".$total_cols."</td>";
		$HTML     .= "\t</tr>\n";
		$j++;
	}
	#echo $HTML;exit;
	
	
	
	$i = 0;
	foreach($status as $b1 => $res1){
		if($i == 0){
			$HTML .= "\t<tr>\n";
			$HTML .= "\t\t<td style=\"border:solid 1px #999;font-weight:bold; text-align:center;background-color:#CCC;\" rowspan=\"2\">&nbsp;TOTAL</td>\n";
			foreach($status as $b => $res){
				$HTML .= "\t\t<td style=\"border:solid 1px #999;background-color:#CCC;font-weight:bold;text-align:center;\">";
				$HTML .= strtoupper(strtolower($res->status))."</td>\n";
			}
			$HTML .= "\t\t<td style=\"border:solid 1px #999;background-color:#CCC;font-weight:bold;text-align:center;\">TOTAL</td>\n";
			$HTML .= "\t</tr>\n";
			$HTML .= "\t<tr>\n";
		} 
		$HTML .= "\t\t<td style=\"border:solid 1px #999;text-align:center;font-weight:bold;font-size:13px\">".$total_rows[$i]."</td>\n";
		$tot_tudo = $tot_tudo + $total_rows[$i];
		$i++;
	}
	$HTML .= "<td style=\"border:solid 1px #999;text-align:center;font-weight:bold;font-size:13px\">".$tot_tudo."</td>\n";
	$HTML .= "\t</tr>\n";
	#echo $HTML; exit;
	
	
$HTML .= '</table>';

$HTML .= '<table cellpadding="1" cellspacing="4" style="font-family:Arial;font-size:11px; border:none;">
	<tr>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;width:40px;">&nbsp;FICHA</td>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;width:180px;">&nbsp;CONSULTOR</td>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;width:140px;">&nbsp;HORA / DATA</td>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;width:140px;">&nbsp;STATUS</td>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;">&nbsp;CONVERSAS</td>
	</tr>';
	$observacao= $expansao->listarfichaiddia();
	$conversa = $expansao->listarfichadia();
	$ids = array();
	foreach($observacao as $b1 => $res){
		$color = ' style="background-color:#F3F3F3"';
		$border= ';border-top:solid 2px #999';
		$HTML .= '<tr'.$color.'>		
			<td style="border:solid 1px #999;text-align:center'.$border.';font-weight:bold">&nbsp;'.$res->id_ficha.'</td>
			<td style="border:solid 1px #999'.$border.';font-weight:bold">&nbsp;'.$res->consultor.'</td>
			<td style="border:solid 1px #999'.$border.';text-align:center;font-weight:bold" colspan="3">&nbsp;'.$res->status.' [ <span style="color:#CC0000">'.utf8_decode('Região Interesse:').' '.strtoupper(strtolower($res->cidade_interesse .' / '. $res->estado_interesse)).'</span> ]'.'</td>
		</tr>';
		$ids[] = $res->id_ficha;
		$ficha    = 0;
		$historico = $expansao->listarHistorico($res->id_ficha);
		if(count($historico) > 0){
			for($j = 0; $j < count($historico); $j++){
				$color = ($ficha != $historico[$j]->id_ficha && $ficha != 0) ? ' style="background-color:#F3F3F3"' : '';
				$border= ($ficha != $historico[$j]->id_ficha && $ficha != 0) ? ';border-top:solid 2px #999' : '';
				$HTML .= '<tr'.$color.'>		
					<td style="border:solid 1px #999;text-align:center'.$border.'">-</td>
					<td style="border:solid 1px #999'.$border.'">&nbsp;'.$historico[$j]->consultor.'</td>
					<td style="border:solid 1px #999'.$border.'">&nbsp;'.$historico[$j]->data.'</td>
					<td style="border:solid 1px #999'.$border.'">&nbsp;'.$historico[$j]->status.'</td>
					<td style="border:solid 1px #999'.$border.'">&nbsp;'.$historico[$j]->observacao.'</td>
				</tr>';
				$ficha = $historico[$j]->id_ficha;
			}
		}
	}
	$ficha    = 0;
	foreach($conversa as $b1 => $res){
		if(!in_array($res->id_ficha, $ids)){
			if($ficha == 0){
				$HTML .= '<tr>		
					<td style="background-color: #999;height:5px" colspan="5"></td>
				</tr>';
			}
			$historico = $expansao->listarHistorico($res->id_ficha);
			if(count($historico) > 0){
				for($j = 0; $j < count($historico); $j++){
					$color = ($ficha != $historico[$j]->id_ficha && $ficha != 0) ? ' style="background-color:#F3F3F3"' : '';
					$border= ($ficha != $historico[$j]->id_ficha && $ficha != 0) ? ';border-top:solid 2px #999' : '';
					$HTML .= '<tr'.$color.'>		
						<td style="border:solid 1px #999;text-align:center'.$border.'">&nbsp;'.($ficha != $historico[$j]->id_ficha ? $historico[$j]->id_ficha : '-').'</td>
						<td style="border:solid 1px #999'.$border.'">&nbsp;'.$historico[$j]->consultor.'</td>
						<td style="border:solid 1px #999'.$border.'">&nbsp;'.$historico[$j]->data.'</td>
						<td style="border:solid 1px #999'.$border.'">&nbsp;'.$historico[$j]->status.'</td>
						<td style="border:solid 1px #999'.$border.'">&nbsp;'.$historico[$j]->observacao.'</td>
					</tr>';
					$ficha = $historico[$j]->id_ficha;
				}
			}
		}
	}

$HTML .= '</table>';
$HTML .= '<script type="text/javascript">';
$HTML .= "
	google.load('visualization', '1.0', {'packages':['corechart']});
	google.setOnLoadCallback(drawChart);
	
	 function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([";
        $i = 0;
        foreach($status as $b => $res){
			$HTML .= "['".strtoupper(strtolower($res->status))."', ".$total_rows[$i]."]";
			$HTML .= $i < count($status) - 1 ? "," : "";
          $i++;
		}
        $HTML .= "]);        
        var options = {'title':'Relatorio Expansao - ".$dia."',
                       'width':800,
                       'height':600};
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
     }";
$HTML .= '</script><div id="chart_div"></div>';

$HTML .= '</body>
</html>';
#echo $HTML; exit;
if(date('H') < 21){
	echo $HTML;
} else {
	#echo 2; exit;
	include("../../includes/maladireta/class.PHPMailer.php");
	$mailer = new SMTPMailer();

	$From = 'Sistema Expansão';
	if($_GET['teste'] == 1){
		$AddAddress = 'antonio.alves@softfox.com.br';
	} else {
		#$AddAddress = 'antonio.alves@softfox.com.br';
		$AddAddress = 'flavio.lopes@cartoriopostal.com.br;elizabeth.costa@cartoriopostal.com.br;claudia.mattos@cartoriopostal.com.br;jefferson.ramirez@cartoriopostal.com.br';
	}
	$AddBCC = 'ti@cartoriopostal.com.br';
	$Subject = 'Relatório Expansão';
	$mailer->SEND($From, $AddAddress, '', $AddBCC, '', $Subject, $HTML); 
} ?>
