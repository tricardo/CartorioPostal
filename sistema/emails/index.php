<?
/*
 * File: example.php
 * Description: Received Mail Example
 * Created: 01-03-2006
 * Author: Mitul Koradia
 * Email: mitulkoradia@gmail.com
 * Cell : +91 9825273322
 */
include("receivemail.class.php");
// Creating a object of reciveMail Class
$obj= new receiveMail('suporte+cartoriopostal.com.br','a123d321','suporte@cartoriopostal.com.br','mail.cartoriopostal.com.br','imap','143/novalidate-cert',false);
//Connect to the Mail Box
$obj->connect();         //If connection fails give error message and exit


// Get Total Number of Unread Email in mail box
$tot=$obj->getTotalMails(); //Total Mails in Inbox Return integer value

echo "Total Mails:: $tot<br>";
#if($tot>20) $tot=20; 
$cont=0;
for($i=$tot;$i>0;$i--)
{
	if($cont==20) break;
	$cont++;
	
	$head=$obj->getHeaders($i);  // Get Header Info Return Array Of Headers **Array Keys are (subject,to,toOth,toNameOth,from,fromName)
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
	
	//$obj->deleteMails($i); // Delete Mail from Mail box
}
$obj->close_mailbox();   //Close Mail Box

?>