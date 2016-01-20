<?$Recipiant .= 'T.I <ti@cartoriopostal.com.br>';
$Cc = '';
$Bcc = 'Rafael Nascimento <rafael.nascimento@cartoriopostal.com.br>';
$Subject = 'Ficha de Novos Interessados - Finalizar Processo';

$html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Emitir Contrato</title>
<style type="text/css">
<!--
body,td,th {
    font-family: Verdana;
    font-size: 11px;
    color: #333333;
}
body {
    margin:15px;
}
hr {
    margin:0;
    padding:0;
    width:600px;
    background-color:#0071B6;
    height:3px;
    border:none;
    float:left;
}
.topo1 {
    float:left;
    width:25%;
    text-align:left;
}
.topo2 {
    float:right;
    width:75%;
    text-align:right;
}
.id {
    font-size:16px;
    font-weight:bold;
    float:left;
    color:#0071B6;
    width:600px;
}
.estrutura {
    border:solid 1px #0071B6;
    float:left;
    width:600px;
    margin-bottom:15px;
    padding-bottom:15px;
}
.titulo {
    background-color:#95D8FF;
    border-bottom:solid 2px #0071B6;
    float:left;
    width:600px;	
}
.titulo p {
    margin:3px;
    padding:3px;
    font-weight:bold;
}
.subtitulo {
    background-color:#FFE391;
    border-bottom:solid 1px #AE8300;
    float:left;
    width:600px;
}
.subtitulo2 {
    border-top:solid 1px #AE8300;
}
.subtitulo p {
    margin:3px;
    padding:3px;
}
.corpo {
    width:600px;
    margin-bottom:8px;
    padding-bottom:8px;
    float:left;
}
.corpo p {
    float:left;
    margin:0;
    padding:0;
    margin-left:10px;
    margin-top:5px;
    padding-left:10px;
    padding-top:5px;
}
-->
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td width="600" style="font-weight:bold">
        <p class="topo1">Novos Interessados</p>
        <p class="topo2">Franquia: '.utf8_encode($safpostal_fantasia).'</p>
        <hr />
        <p class="id">Finalizar Processo</p></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0">
	  <tr>
        <td width="150" height="25"><strong>#ID da Ficha:</strong></td>
        <td>'.$id.'</td>
      </tr>
      <tr>
        <td colspan="2">Caro Administrador, você deve acessar o sistema do SAF e finalizar o processo
		digitando a cidade, estado e faixa de ceps.</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>';


set_time_limit(0);
require("../includes/maladireta/config.inc.php");
error_reporting(1);
require("../includes/maladireta/class.Email.php");
$Sender = "Cartório Postal - SAF <expansao@cartoriopostal.com.br>";

$CustomHeaders= '';
$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
$message->Cc = $Cc; 
$message->Bcc = $Bcc; 
$message->SetHtmlContent($html);
$pathToServerFile ="attachments/$at[1]/$at[2]";
$serverFileMimeType = 'multipart/gased';
$message->Send();?>