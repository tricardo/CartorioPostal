<? 
require "phpmailer/class.phpmailer.php";

class SMTPMailer {
	
	public function SEND($From, $AddAddress, $AddCC, $AddBCC, $AddReplyTo, $Subject, $Body){
	
		$mail = new PHPMailer();
	 
		#Define o m�todo de envio
		$mail->Mailer     = "smtp";
	 
		#Define que a mensagem poder� ter formata��o HTML
		$mail->IsHTML(true);
		 
		#Define que a codifica��o do conte�do da mensagem ser� utf-8
		$mail->CharSet    = "iso-8859-1";
		 
		#Define que os emails enviadas utilizar�o SMTP Seguro tls
		#$mail->SMTPSecure = "";
		 
		#Define que o Host que enviar� a mensagem � o Cartorio Postal
		$mail->Host       = "sharedrelay-cluster.mandic.net.br";
		 
		#Define a porta utilizada pelo Cartorio Postal para o envio autenticado
		$mail->Port       = "587";                  
		 
		#Define que a mensagem utiliza m�todo de envio autenticado
		$mail->SMTPAuth   = "true";
		 
		#Define o usu�rio da Cartorio Postal autenticado respons�vel pelo envio
		#Defina o email e o nome que aparecer� como remetente no cabe�alho
		switch($_SESSION['username_send_mail']){
			case 1:
				$mail->Username   = "cartoriopostal@shared.mandic.net.br";
				$mail->From       = 'cartoriopostal@shared.mandic.net.br';
			break;

			default:
			$mail->Username   = "cartoriopostal@shared.mandic.net.br";
			$mail->From       = 'cartoriopostal@shared.mandic.net.br';
		}
		 
		#Define a senha deste usu�rio citado acima
		$mail->Password   = "Mandic@123!";
		 		

		$mail->FromName   = $From;
				 
		#Define o destinat�rio que receber� a mensagem
		if(substr_count($AddAddress, ';') > 0){
			$AddAddress = explode(';', $AddAddress);
			for($i = 0; $i < count($AddAddress); $i++){
				if(substr_count($AddAddress[$i], ',') > 0){
					$AddAddress2 = explode(',', $AddAddress[$i]);
					$mail->AddAddress($AddAddress2[0],$AddAddress2[1]);
				} else {
					$mail->AddAddress($AddAddress[$i],'');
				}
			}
		} else {
			if(substr_count($AddAddress, ',') > 0){
				$AddAddress2 = explode(',', $AddAddress);
				$mail->AddAddress($AddAddress2[0],$AddAddress2[1]);
			} elseif(strlen($AddAddress) > 0) {
				$mail->AddAddress($AddAddress,'');
			}
		}
		
		#Define o destinat�rio que receber� a c�pia
		if(substr_count($AddCC, ';') > 0){
			$AddCC = explode(';', $AddCC);
			for($i = 0; $i < count($AddCC); $i++){
				if(substr_count($AddCC[$i], ',') > 0){
					$AddCC2 = explode(',', $AddCC[$i]);
					$mail->AddCC($AddCC2[0],$AddCC2[1]);
				} else {
					$mail->AddCC($AddCC[$i],'');
				}
			}
		} else {
			if(substr_count($AddCC, ',') > 0){
				$AddCC2 = explode(',', $AddCC);
				$mail->AddCC($AddCC2[0],$AddCC2[1]);
			} elseif(strlen($AddCC) > 0) {
				$mail->AddCC($AddCC,'');
			}
		}
				
		#Define o destinat�rio que receber� a c�pia oculta
		if(substr_count($AddBCC, ';') > 0){
			$AddBCC = explode(';', $AddBCC);
			for($i = 0; $i < count($AddBCC); $i++){
				if(substr_count($AddBCC[$i], ',') > 0){
					$AddBCC2 = explode(',', $AddBCC[$i]);
					$mail->AddBCC($AddBCC2[0],$AddBCC2[1]);
				} else {
					$mail->AddBCC($AddBCC[$i],'');
				}
			}
		} else {
			if(substr_count($AddBCC, ',') > 0){
				$AddBCC2 = explode(',', $AddBCC);
				$mail->AddBCC($AddBCC2[0],$AddBCC2[1]);
			} elseif(strlen($AddBCC) > 0) {
				$mail->AddBCC($AddBCC,'');
			}
		}
		
		#Define o email que receber� resposta desta mensagem, quando o destinat�rio responder
		if(substr_count($AddReplyTo, ';') > 0){
			$AddReplyTo = explode(';', $AddReplyTo);
			for($i = 0; $i < count($AddReplyTo); $i++){
				if(substr_count($AddReplyTo[$i], ',') > 0){
					$AddReplyTo2 = explode(',', $AddReplyTo[$i]);
					$mail->AddReplyTo($AddReplyTo2[0],$AddReplyTo2[1]);
				} else {
					$mail->AddReplyTo($AddReplyTo[$i],'');
				}
			}
		} elseif(strlen($AddReplyTo) > 0) {
			$mail->AddReplyTo($AddReplyTo,'');
		}
		
		#Assunto da mensagem
		$mail->Subject    = $Subject;
		 
		#Toda a estrutura HTML e corpo da mensagem
		$mail->Body       = $Body; 
		
		if (!$mail->Send()){
			return 0;
		} else {
			return 1;
		}
	} 
} ?>