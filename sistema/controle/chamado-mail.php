<?

$servidor = "mail.cartoriopostal.com.br";
$usuario = "suporte@cartoriopostal.com.br";
$senha = "a123d321";

#$obj= new receiveMail('suporte+cartoriopostal.com.br','a123d321','suporte@cartoriopostal.com.br',
#	'mail.cartoriopostal.com.br','imap','143/novalidate-cert',false);

@ini_set('display_errors', '0');

$mbox = imap_open("{".$servidor.":143/novalidate-cert}INBOX",$usuario,$senha);

$erro[] = imap_last_error();
if ($erro[0] == "Mailbox is empty") {
	echo "não tem nenhuma mensagem";
	exit;
} elseif ($erro[0] == "POP3 connection broken in response") {
	echo "Usuario ou a senha estao errados";
	exit;
} elseif ($erro[0] == "Host not found (#11004): pop3.$servidor") {
	echo "O servidor $servidor esta errado";
	exit;
}
if ($erro[0] == "") {
	$numero_mensagens = imap_num_msg($mbox);
	$numero_mens_nao_lidas = imap_num_recent($mbox);

	if ($numero_mensagens == 1) {
		echo "você tem $numero_mensagens mensagem<br />";
	} else {
		echo "você tem $numero_mensagens mensagens<br /><br />";
	}
	
	setlocale(LC_ALL, 'pt_BR');
	for($i = 1;$i <= imap_num_msg($mbox);$i++) {
		date_default_timezone_set('America/Sao_Paulo');
		$headers = imap_header($mbox, $i);
		$data = str_replace(' ',',',$headers ->date);
		$data = explode(',', $data);
		switch($data[3]){
			case 'Jan': $mes = '01'; break;
			case 'Fev': $mes = '02'; break;
			case 'Mar': $mes = '03'; break;
			case 'Apr': $mes = '04'; break;
			case 'May': $mes = '05'; break;
			case 'Jun': $mes = '06'; break;
			case 'Jul': $mes = '07'; break;
			case 'Aug': $mes = '08'; break;
			case 'Sep': $mes = '09'; break;
			case 'Oct': $mes = '10'; break;
			case 'Nov': $mes = '11'; break;
			case 'Dec': $mes = '12'; break;
		}
		$dia  = ($data[2] < 10) ? '0'.$data[2] : $data[2];
		$data = $data[4].':'.$mes.':'.$dia.' '.$data[5];
		echo $data."<br/>";
		
		print_r($headers ); echo '<br /><br />';
	}
}

exit;
include("../emails/receivemail.class.php");

$obj= new receiveMail('suporte+cartoriopostal.com.br','a123d321','suporte@cartoriopostal.com.br',
	'mail.cartoriopostal.com.br','imap','143/novalidate-cert',false);

$obj->connect(); 
$tot = $obj->getTotalMails(); 
echo "Total Mails:: $tot<br>";

$cont=0;
for($i=$tot;$i>0;$i--)
{
	if($cont==20) break;
	$cont++;
	
	$head=$obj->getHeaders($i); 
	$corpo=str_replace('{Down}','',$obj->getBody($i));
	$corpo=str_replace('{Back}','',$corpo);
	$corpo=str_replace('{Escape}','',$corpo);
	$corpo=str_replace('{Tab}','',$corpo);
	$corpo=str_replace('{LMenu}','',$corpo);
	$corpo=str_replace('{Delete}','',$corpo);
	$corpo=str_replace('{Decimal}','',$corpo);
	$corpo=str_replace('{Up}','',$corpo);
	$corpo=str_replace('{Right}','',$corpo);
	$corpo=str_replace('{Left}','',$corpo);
	
	
	echo "Assunto: ".$head['subject']."<br>";
	echo "Para: ".$head['to']."<br>";
	echo "Para: ".$head['toOth']."<br>";
	echo "Para Nome: ".$head['toNameOth']."<br>";
	echo "De: ".$head['from']."<br>";
	echo "De Nome: ".$head['fromName']."<br>";
	echo "<br><br>";
	echo "<br>*******************************************************************************************<BR>";
	echo $corpo;  // Get Body Of Mail number Return String Get Mail id in interger
	
	$str=$obj->GetAttach($i,"./"); // Get attached File from Mail Return name of file in comma separated string  args. (mailid, Path to store file)
	$ar=explode(",",$str);
	foreach($ar as $key=>$value)
		echo ($value=="")?"":"Atteched File :: ".$value."<br>";
	echo "<br>------------------------------------------------------------------------------------------<BR>";
	
}
$obj->close_mailbox();   //Close Mail Box

?>