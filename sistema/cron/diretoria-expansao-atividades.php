<? include('funcoes.php');
$c = new stdClass();
$expansao = new ExpansaoDAO();
$status = $expansao->listarStatus();
$consultor = $expansao->relatorioDiretoria(1, $c);
$HTML = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sistecart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>
<body>
<table cellpadding="1" cellspacing="4" style="font-family:Arial;font-size:12px; border:none;">
	<tr>		
		<td style="border:solid 1px #999;font-weight:bold" colspan="'.(count($consultor)+2).'">
			&nbsp;Data: '.date('d/m/Y H:i:s').'<br />
			&nbsp;Total Pedidos Dia: '.$expansao->relatorioDiretoria(4, $c).'
		</td>
	</tr>
	<tr>
		<td style="border:solid 1px #999;background-color:#CCC;font-weight:bold;width:180px" rowspan="2">&nbsp;Atividade</td>
		<td style="border:solid 1px #999;background-color:#CCC;text-align:center;font-weight:bold;" colspan="'.(count($consultor)+1).'">Consultores</td>
	</tr>
	<tr>'."\n";
		foreach($consultor as $b1 => $res1){
			$HTML .= "\t\t<td style=\"border:solid 1px #999;background-color:#CCC;font-weight:bold;text-align:center;width:100px;\">";
			$HTML .= $res1->nome."</td>\n";
		}
		$HTML .= "\t\t<td style=\"border:solid 1px #999;background-color:#CCC;text-align:center;font-weight:bold;\">Total</td>";
	$HTML .= "\t</tr>\n";
	
	$total_cols = 0; 
	$total_rows = array(); $j = 0;
	foreach($status as $b => $res){
		$i = 0;
		$total_cols = 0;
		$HTML .= "\t<tr>\n";
			$HTML .= "\t\t<td style=\"border:solid 1px #999;\">&nbsp;".$res->status."</td>\n";
			foreach($consultor as $b1 => $res1){
				$HTML .= "\t\t<td style=\"border:solid 1px #999;text-align:center;\">";
				$c->id_usuario = $res1->id_usuario;
				$c->id_status = $res->id_status;
				$total = $expansao->relatorioDiretoria(3, $c);
				$HTML .= $total;
				$HTML .= "</td>\n";
				$total_cols = $total_cols + $total;
				$total_rows[$i] = $total_rows[$i] + $total;
				$i++;
			}
		$HTML .= "\t\t<td style=\"border:solid 1px #999;text-align:center;font-weight:bold;width:80px\">".$total_cols."</td>";
		$HTML .= "\t</tr>\n";
		$j++;
	}
	
	$HTML .= "\t<tr>\n";
	$HTML .= "\t\t<td style=\"border:solid 1px #999;font-weight:bold\">&nbsp;Total</td>\n";
	$i = 0;
	foreach($consultor as $b1 => $res1){
		$HTML .= "\t\t<td style=\"border:solid 1px #999;text-align:center;font-weight:bold\">".$total_rows[$i]."</td>\n";
		$tot_tudo = $tot_tudo + $total_rows[$i];
		$i++;
	}
	$HTML .= "<td style=\"border:solid 1px #999;text-align:center;font-weight:bold\">".$tot_tudo."</td>\n";
	$HTML .= "\t</tr>\n";
	
$HTML .= '</table>
<br /><br />';

/*$consultor = $expansao->relatorioDiretoria(2, $c);
$HTML .= '<table cellpadding="1" cellspacing="4" style="font-family:Arial;font-size:12px; border:none;">
	<tr>		
		<td style="border:solid 1px #999;font-weight:bold" colspan="'.(count($consultor)+2).'">
			&nbsp;Data: '.date('d/m/Y H:i:s').'<br />
			&nbsp;Total Pedidos Dia: '.$expansao->relatorioDiretoria(4, $c).'
		</td>
	</tr>
	<tr>
		<td style="border:solid 1px #999;background-color:#CCC;font-weight:bold;width:180px" rowspan="2">&nbsp;Atividade</td>
		<td style="border:solid 1px #999;background-color:#CCC;text-align:center;font-weight:bold;" colspan="'.(count($consultor)+1).'">Consultores</td>
	</tr>
	<tr>'."\n";
		foreach($consultor as $b1 => $res1){
			$HTML .= "\t\t<td style=\"border:solid 1px #999;background-color:#CCC;font-weight:bold;text-align:center;width:100px;\">";
			$HTML .= $res1->nome."</td>\n";
		}
		$HTML .= "\t\t<td style=\"border:solid 1px #999;background-color:#CCC;text-align:center;font-weight:bold;\">Total</td>";
	$HTML .= "\t</tr>\n";
	
	$total_cols = 0; 
	$total_rows = array(); $j = 0;
	foreach($status as $b => $res){
		$i = 0;
		$total_cols = 0;
		$res->status = str_replace('Segunda','2ª', $res->status);
		$HTML .= "\t<tr>\n";
		$HTML .= "\t\t<td style=\"border:solid 1px #999;\">&nbsp;".$res->status."</td>\n";
		foreach($consultor as $b1 => $res1){
			$HTML .= "\t\t<td style=\"border:solid 1px #999;text-align:center;\">";
			$c->id_usuario = $res1->id_usuario;
			$c->id_status = $res->id_status;
			$total = $expansao->relatorioDiretoria(3, $c);
			$HTML .= $total;
			$HTML .= "</td>\n";
			$total_cols = $total_cols + $total;
			$total_rows[$i] = $total_rows[$i] + $total;
			$i++;
		}
		$HTML .= "\t\t<td style=\"border:solid 1px #999;text-align:center;font-weight:bold;width:80px\">".$total_cols."</td>";
		$HTML .= "\t</tr>\n";
		$j++;
	}
	
	$HTML .= "\t<tr>\n";
	$HTML .= "\t\t<td style=\"border:solid 1px #999;font-weight:bold\">&nbsp;Total</td>\n";
	$i = 0;
	$tot_tudo = 0;
	foreach($consultor as $b1 => $res1){
		$HTML .= "\t\t<td style=\"border:solid 1px #999;text-align:center;font-weight:bold\">".$total_rows[$i]."</td>\n";
		$tot_tudo = $tot_tudo + $total_rows[$i];
		$i++;
	}
	$HTML .= "<td style=\"border:solid 1px #999;text-align:center;font-weight:bold\">".$tot_tudo."</td>\n";
	$HTML .= "\t</tr>\n";
	
$HTML .= '</table><br /><br />';*/

$HTML .= '<table cellpadding="1" cellspacing="4" style="font-family:Arial;font-size:12px; border:none;">
	<tr>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;width:40px;">&nbsp;</td>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;width:40px;">&nbsp;Ficha</td>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;width:180px;">&nbsp;Consultor</td>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;width:140px;">&nbsp;Hora/Data</td>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;width:140px;">&nbsp;Status</td>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;width:140px;">&nbsp;Local de Interesse</td>
		<td style="border:solid 1px #999;font-weight:bold;background-color:#CCC;">&nbsp;Conversa</td>
	</tr>';
	$conversa = $expansao->listarConversa(1);
	$i = 1;
	foreach($conversa as $b1 => $res){
		$data = explode(' ',$res->data_inclusao);		
		$data1 = explode('-',$data[0]);
		$data = $data1[2].'/'.$data1[1].'/'.$data1[0].' '.$data[1];
		$status = $expansao->PegaStatus($res->id_status);
		$HTML .= '<tr>		
			<td style="border:solid 1px #999;text-align:center">'.$i.'</td>
			<td style="border:solid 1px #999;text-align:center">'.$res->id_ficha.'</td>
			<td style="border:solid 1px #999">&nbsp;'.$res->consultor.'</td>
			<td style="border:solid 1px #999">&nbsp;'.$data.'</td>
			<td style="border:solid 1px #999">&nbsp;'.$status[0]->status.'</td>
			<td style="border:solid 1px #999">&nbsp;'.$res->cidade_interesse.' - '.$res->estado_interesse.'</td>
			<td style="border:solid 1px #999">&nbsp;'.$res->observacao.'</td>
		</tr>';
		$i++;
	}
	$conversa = $expansao->listarConversa(2);
	foreach($conversa as $b1 => $res){
		$data = explode(' ',$res->data_inclusao);		
		$data1 = explode('-',$data[0]);
		$data = $data1[2].'/'.$data1[1].'/'.$data1[0].' '.$data[1];
		$status = $expansao->PegaStatus($res->id_status);
		$HTML .= '<tr>		
			<td style="border:solid 1px #999;text-align:center">'.$i.'</td>
			<td style="border:solid 1px #999;text-align:center">&nbsp;'.$res->id_ficha.'</td>
			<td style="border:solid 1px #999">&nbsp;'.$res->consultor.'</td>
			<td style="border:solid 1px #999">&nbsp;'.$data.'</td>
			<td style="border:solid 1px #999">&nbsp;'.$status[0]->status.'</td>
			<td style="border:solid 1px #999">&nbsp;'.$res->cidade_interesse.' - '.$res->estado_interesse.'</td>
			<td style="border:solid 1px #999">&nbsp;'.$res->observacao.'</td>
		</tr>';
		$i++;
	}
$HTML .= '</table>';

$HTML .= '</body>
</html>';

echo $HTML; exit;
include("../../includes/maladireta/class.PHPMailer.php");
$mailer = new SMTPMailer();

$From = 'Sistema Expansão';
if($_GET['teste'] == 1){
	$AddAddress = 'antonio.alves@softfox.com.br';
} else {
	$AddAddress = 'flavio.lopes@cartoriopostal.com.br;elizabeth.costa@cartoriopostal.com.br;claudia.mattos@cartoriopostal.com.br;ti@cartoriopostal.com.br';
}
$AddBCC = 'ti@cartoriopostal.com.br';
$Subject = 'Relatório Expansão (Diretoria)';
$mailer->SEND($From, $AddAddress, '', $AddBCC, '', $Subject, $HTML); ?>
