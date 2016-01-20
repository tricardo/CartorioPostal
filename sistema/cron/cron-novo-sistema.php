<? include('funcoes.php');
$c = new stdClass();
$NovoSistemaDAO = new NovoSistemaDAO();

$action = 0;
$total = 5;
switch($_GET['action']){
	case 1:
		$action = 1;
		$ret = $NovoSistemaDAO->Franquia(1);
		$ret .= $NovoSistemaDAO->Franquia(2);
		$msg = 'Franquia';
		break;
		
	case 2:
		$action = 1;
		$ret = $NovoSistemaDAO->FranquiaChecklist(1);
		$ret .= $NovoSistemaDAO->FranquiaChecklist(2);
		$msg = 'Franquia - Checklist';
		break;
		
	case 3: 
		$action = 1;
		$ret = $NovoSistemaDAO->FranquiaImplantacao(1);
		$ret .= $NovoSistemaDAO->FranquiaImplantacao(2);
		$msg = 'Franquia - Checklist Implantação';
		break;
}



if($action == 1){
	$HTML = '
	<!DOCTYPE HTML>
	<html lang="pt-br"><head><meta charset="utf-8"><style>body{font-family:Arial; font-size:14px}</style></head><body>
	<table style="font-size: 13px; font-family: Arial">
		<tr>
			<td colspan="2">&nbsp;</td>
			<td style="border:solid 1px #222; text-align:center;" colspan="2">Ins. / Upd.</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="border:solid 1px #222; text-align:center; width: 20%">Data</td>
			<td style="border:solid 1px #222; text-align:center; width: 10%">Total</td>
			<td style="border:solid 1px #222; text-align:center; width: 10%">Sim</td>
			<td style="border:solid 1px #222; text-align:center; width: 10%">Não</td>
			<td style="border:solid 1px #222;">Ação</td>
		</tr>'.$ret.'
	</table>
</body></html>';
	include("../../includes/maladireta/class.PHPMailer.php");
	$mailer = new SMTPMailer();
	$mailer->SEND('Sistema Novo', 'rafael.nascimento@cartoriopostal.com.br', '', '', '', 'Cron '.$_GET['action'].' Sistema Novo - '.$msg, $HTML); 	
	
	if(($_GET['action'] + 1) < $total){
		header('location: cron-novo-sistema.php?action='.($_GET['action'] + 1));
	}
	echo $total;
} else {
		echo 'Null';
}
?>
