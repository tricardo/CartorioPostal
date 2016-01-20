<?
$Recipiant = 'Luana Aparecida <luana.aparecida@cartoriopostal.com.br>, Renato Bacin <renato.bacin@cartoriopostal.com.br>, Priscila Paro <priscilaparoadv@cartoriopostal.com.br>';
$Cc = $res['nome'].' <'.$res['email'].'>';
$Bcc = 'TI <ti@cartoriopostal.com.br>';
$Subject = 'Ficha de Novos Interessados - Elaborar COF';

$og = orgao_emissor($c->orgao_emissor);

switch($c->tipo_franquia){
	case 1:
		$franquia = 'Master - '.$c->estado_interesse;
	break;
	case 2:
		$franquia = 'Unitária - '.$c->cidade_interesse;
	break;
	case 3:
		$franquia = 'Internacional - Brasil';
	break;
}

$tel = $c->tel_res;
if(strlen($c->tel_rec) > 0){ $tel .= ' / '.$c->tel_rec; }
if(strlen($c->tel_cel) > 0){ $tel .= ' / '.$c->tel_cel; }

$html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Elaborar COF</title>
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
        <p class="topo2">Franquia: '.$controle_fantasia.'</p>
        <hr />
        <p class="id">Elaborar COF</p></td>
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
        <td width="150" height="25"><strong>Nome Completo:</strong></td>
        <td>'.$c->nome.'</td>
      </tr>
      <tr>
        <td height="25"><strong>Nacionalidade:</strong></td>
        <td>'.$c->nacionalidade.'</td>
      </tr>
      <tr>
        <td height="25"><strong>Data de Nascimento:</strong></td>
        <td>'.$c->nascimento.'</td>
      </tr>
      <tr>
        <td height="25"><strong>Estado Civil:</strong></td>
        <td>'.$c->estado_civil.'</td>
      </tr>
      <tr>
        <td height="25"><strong>Profiss&atilde;o:</strong></td>
        <td>'.$c->profissao.'</td>
      </tr>
      <tr>
        <td height="25"><strong>Endere&ccedil;o:</strong></td>
        <td>'.$c->endereco.', '.$c->numero.' '.$c->complemento.'<br />
		'.$c->bairro.' - '.$c->cep.' - '.$c->cidade.' - '.$c->estado.'</td>
      </tr>
      <tr>
        <td height="25"><strong>RG:</strong></td>
        <td>'.$c->rg.' '.$og.'</td>
      </tr>
      <tr>
        <td height="25"><strong>CPF:</strong></td>
        <td>'.$c->cpf.'</td>
      </tr>
	  <tr>
        <td height="25"><strong>Telefone:</strong></td>
        <td>'.$tel.'</td>
      </tr>
	  <tr>
        <td height="25"><strong>Tipo Franquia:</strong></td>
        <td>'.$franquia.'</td>
      </tr>
	  <tr>
        <td height="25"><strong>Valor da Franquia:</strong></td>
        <td>R$ '.$c->valor_efetivo.'</td>
      </tr>
	  <tr>
        <td height="25"><strong>Cidade de Interesse:</strong></td>
        <td>'.$c->cidade_interesse.'</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>';

/*
set_time_limit(0);
require("../includes/maladireta/config.inc.php");
error_reporting(1);
require("../includes/maladireta/class.Email.php");
$Sender = "Cartorio Postal - Expansão <expansao@cartoriopostal.com.br>";

$CustomHeaders= '';
$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
$message->Cc = $Cc; 
$message->Bcc = $Bcc; 
$message->SetHtmlContent($html);
$pathToServerFile ="attachments/$at[1]/$at[2]";
$serverFileMimeType = 'multipart/gased';
$message->Send();*/

include("../../includes/maladireta/class.PHPMailer.php");
$mailer = new SMTPMailer();

$From = 'Sistema Expansao';
$AddAddress = 'luana.aparecida@cartoriopostal.com.br,Luana Aparecida;renato.bacin@cartoriopostal.com.br,Renato Bacin;
	priscilaparoadv@cartoriopostal.com.br,Priscila Paro';
$AddCC = $res['email'].','.$res['nome'];
$AddBCC = 'ti@cartoriopostal.com.br';
$Subject = 'Expansao - Elaborar COF';
$mailer->SEND($From, $AddAddress, $AddCC, $AddBCC, '', $Subject, $html); 
?>