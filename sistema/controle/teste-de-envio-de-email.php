<html>
<body>
<? 
	include("../../includes/maladireta/class.PHPMailer.php");
	$mailer = new SMTPMailer();
	
	$From = 'Sistema Teste';
	$AddAddress = '';
	$AddCC = '';
	$AddBCC = '';
	$Subject = 'Email Teste';
	$Body = 'corpo do email<br /> teste.<br />'.date('Y-m-d H:i:s');
	if($mailer->SEND($From, $AddAddress, $AddCC, $AddBCC, $AddReplyTo, $Subject, $Body) == 1){
		echo 'enviado';
	} else {
		echo 'problema';
	}
?>
</body>
</html>