<?
//error_reporting(0);
set_time_limit(0);
include("../a_sistema/includes/maladireta/config.inc.php");
include("../a_sistema/includes/maladireta/class.Email.php");
error_reporting(1);

$name_sender 	= 'Canal dos Profissionais';
$email_sender 	= 'contato@vsites.com.br';

include_once("../includes/maladireta/class.Email.php");

  $Sender = $name_sender." <".$email_sender.">";
  $Recipiant = '';
  $Cc = ''; 
  $Bcc = ''; 
  $Subject = 'Assunto';
  $content = 'conteudo do email';

//** you can still specify custom headers as long as you use the constant
//** 'EmailNewLine' to separate multiple headers.

  $CustomHeaders= '';

//** create the new email message. All constructor parameters are optional and
//** can be set later using the appropriate property.

  $message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
  $message->Cc = $Cc; 
  $message->Bcc = $Bcc; 
 		// $text=$row[5];
		// $html=$row[5];
		//$content=$content;
  $html = $content;
  $message->SetHtmlContent($html);

  $pathToServerFile ="attachments/$at[1]/$at[2]";        //** attach this very PHP script.
  $serverFileMimeType = 'multipart/mixed';  //** this PHP file is plain text.

//** attach the given file to be sent with this message. ANy number of
//** attachments can be associated with an email message. 

//** NOTE: If the file path does not exist or cannot be read by PHP the file
//** will not be sent with the email message.
  $message->Send();

?>
