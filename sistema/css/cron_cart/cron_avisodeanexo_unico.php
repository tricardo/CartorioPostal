<?
require("../includes/classQuery.php");
require("../includes/funcoes.php");

//error_reporting(0);
set_time_limit(0);
require("../includes/maladireta/config.inc.php");
require("../includes/maladireta/class.Email.php");
error_reporting(1);

$data=date('Y-m-d');
#nextel recebe aviso apenas dos anexos que são diferentes de Documento do Cliente
$sql = $objQuery->SQLQuery("SELECT p.id_conveniado, uc.email, pi.id_pedido, pi.ordem FROM vsites_user_cliente as uc, vsites_pedido as p, vsites_pedido_item as pi, vsites_pedido_anexo as pa WHERE uc.id_cliente='49294' and uc.id_cliente=p.id_conveniado and p.id_pedido=pi.id_pedido and pi.id_pedido_item=pa.id_pedido_item and pa.data >= '".$data." 00:00:00' and pa.data <= '".$data." 23:59:59' and pa.anexo_nome!='Documento do Cliente'");
while($res = mysql_fetch_array($sql)){
			$email = explode(';',str_replace(' ','',$res['email'].';contato@vsites.com.br'));
			if($res['id_conveniado']!=$old_id_conveniado and $old_id_conveniado<>''){
			  
				$Sender = "Aviso do Cartorio Postal <contato@cartoriopostal.com.br>";
				$Recipiant = $email[0]; 
				$Cc = '';
				$Bcc = ''; 
				$Subject = 'Aviso de arquivo anexado no Sistema Cartório Postal';
				$html = 'Prezado(a),<br><br>

				Hoje foram anexados arquivos nos seguintes serviços:
				<br>
				'.$ordem.'
				<br><br>
				Att,<br>
				Equipe Cartório Postal<br>
				';
				//** you can still specify custom headers as long as you use the constant
				//** 'EmailNewLine' to separate multiple headers.			
				$pathToServerFile ="attachments/$at[1]/$at[2]";        //** attach this very PHP script.
				$serverFileMimeType = 'multipart/mixed';  //** this PHP file is plain text.
				$CustomHeaders= '';
			
				#envia o primeiro email
				$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
				$message->Cc = $Cc; 
				$message->Bcc = $Bcc; 
				$message->SetHtmlContent($html);
				$message->Send();
				#envia o segundo email se possuir
				if($email[1]<>''){
					$Recipiant = $email[1]; 
					$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
					$message->Cc = $Cc; 
					$message->Bcc = $Bcc;
					$message->SetHtmlContent($html);
					$message->Send();
				}
				if($email[2]<>''){
					$Recipiant = $email[2]; 
					$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
					$message->Cc = $Cc; 
					$message->Bcc = $Bcc;
					$message->SetHtmlContent($html);
					$message->Send();
				}
				echo '<br>Mensagem enviada com sucesso!<br>'.$ordem;
				$ordem = '';

			}else {
				$ordem .= $res['id_pedido'].'/'.$res['ordem'].'<br>';
			}
			$old_id_conveniado = $res['id_conveniado'];
}
if($ordem<>''){
		  
	$Sender = "Aviso do Cartorio Postal <contato@cartoriopostal.com.br>";
	$Recipiant = $email[0]; 
	$Cc = '';
	$Bcc = ''; 
	$Subject = 'Aviso de arquivo anexado no Sistema Cartório Postal';
	$html = 'Prezado(a),<br><br>
		Hoje foram anexados arquivos nos seguintes serviços:
	<br>
	'.$ordem.'
	<br><br>
	Att,<br>
	Equipe Cartório Postal<br>
	';
	//** you can still specify custom headers as long as you use the constant
	//** 'EmailNewLine' to separate multiple headers.			
	$pathToServerFile ="attachments/$at[1]/$at[2]";        //** attach this very PHP script.
	$serverFileMimeType = 'multipart/mixed';  //** this PHP file is plain text.
	$CustomHeaders= '';

	#envia o primeiro email
	$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
	$message->Cc = $Cc; 
	$message->Bcc = $Bcc; 
	$message->SetHtmlContent($html);
	$message->Send();
	#envia o segundo email se possuir
	if($email[1]<>''){
		$Recipiant = $email[1]; 
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->Cc = $Cc; 
		$message->Bcc = $Bcc;
		$message->SetHtmlContent($html);
		$message->Send();
	}
	if($email[2]<>''){
		$Recipiant = $email[2]; 
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->Cc = $Cc; 
		$message->Bcc = $Bcc;
		$message->SetHtmlContent($html);
		$message->Send();
	}
	echo '<br>Mensagem enviada com sucesso!<br>'.$ordem;
}

?>