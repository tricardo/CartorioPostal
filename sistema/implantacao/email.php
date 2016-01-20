<?
ob_start();
header("Content-Type: text/html; charset=iso-8859-1",true);
require("../includes/funcoes.php");
require("../includes/verifica_logado_controle.inc.php");
require("../includes/global.inc.php");

$perm_fin = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_pgto = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_cobr = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_sup = verifica_permissao('Supervisor', $controle_id_departamento_p, $controle_id_departamento_s);

$permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
$permissao_admin = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);

$franquia = new FranquiasDAO();
$c = new stdClass();
if($_POST){ foreach($_POST as $cp => $valor){ $c->$cp = $valor; } }
if($_GET){ foreach($_GET as $cp => $valor){ $c->$cp = $valor; } } 

switch(date('m')){
	case 1: $mes = 'janeiro'; break;
	case 2: $mes = 'fevereiro'; break;
	case 3: $mes = 'março'; break;
	case 4: $mes = 'abril'; break;
	case 5: $mes = 'maio'; break;
	case 6: $mes = 'junho'; break;
	case 7: $mes = 'julho'; break;
	case 8: $mes = 'agosto'; break;
	case 9: $mes = 'setembro'; break;
	case 10: $mes = 'outubro'; break;
	case 11: $mes = 'novembro'; break;
	case 12: $mes = 'dezembro'; break;
}

switch($c->acao){
	case 1:
		$dt = $franquia->envia_email(2, 1, $c, '');
		$franq = (trim($dt->fantasia) == 'Cartório Postal -') ? $dt->cidade .' - '. $dt->estado : $dt->fantasia;

		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Sistema Sistecart - Concluir Faixa de CEP</title>
		</head>
		<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
		Caro Administrador,<br /><br /> <strong>'.$dt->nome.'</strong>, solicita que você acesse o sistema da Sistecart e 
		finalize o processo da faixa de ceps para a franquia de <strong>'.$franq.'</strong>, para que ele dê continuidade no cadastro.<br />
		Obrigado.<br /><br />

		<a href="http://www.cartoriopostal.com.br/sistema/controle/franquias_editar.php?id='.$c->emp.'" target="_blank">Clique aqui</a> 
		e siga os passos abaixo:<br />
		<font size="4" style="font-weight:bold">Escolha a aba que deseja visualizar > 07 - Faixa de 
		CEPs</font><br /><br />

		Após efetuar as alterações clique no botão <strong>Finalizar Processo</strong> para dar continuidade ao 
		cadastro.<br /><br />

		São Paulo, '.date('d').' de '.$mes.' de '.date('Y').'.<br />
		Hora: '.date('H').':'.date('i').'. <br /><br />

		Atenciosamente,<br />
		Equipe Cartório Postal.
		</body>
		</html>';
		
		include("../../includes/maladireta/class.PHPMailer.php");
		$mailer = new SMTPMailer();

		$From = 'Sistema Implantacao';
		$AddAddress = 'ti@cartoriopostal.com.br,TI';
		$AddCC = $dt->email.','.$dt->nome;
		$Subject = 'Implantacao - Faixa de CEP';
		$mailer->SEND($From, $AddAddress, $AddCC, '', '', $Subject, $html); 

		/*
		$Recipiant = 'ti@cartoriopostal.com.br';
		$Cc = .' <'..'>';
		$Subject = 'Franquia - Faixa de CEP';
		
		set_time_limit(0);
		require("../includes/maladireta/config.inc.php");
		error_reporting(1);
		require("../includes/maladireta/class.Email.php");
		$Sender = "franquia@cartoriopostal.com.br";

		$CustomHeaders= '';
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->Cc = $Cc; 
		$message->SetHtmlContent($html);
		$pathToServerFile ="attachments/$at[1]/$at[2]";
		$serverFileMimeType = 'multipart/gased';
		$envio = $message->Send();*/
		
		$dt = $franquia->envia_email(3, 1, $c->emp, $c->usr);
		echo '<script>carregar_implantacao(7,'.$c->emp.');</script>';	
		
	break;
	
	case 2:
		$dt = $franquia->envia_email(2, 1, $c, '');
		$franq = (trim($dt->fantasia) == 'Cartório Postal -') ? $dt->cidade .' - '. $dt->estado : $dt->fantasia;

		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Sistema Sistecart - Liberar Sistema</title>
		</head>
		<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
		Caro Administrador,<br /><br /> <strong>'.$dt->nome.'</strong>, solicita que você libere o sistema da Sistecart
		para a franquia de <strong>'.$franq.'</strong>, para que ela possa dar inicio aos seus serviços.<br />
		Obrigado.<br /><br />

		<a href="http://www.cartoriopostal.com.br/sistema/controle/franquias_editar.php?id='.$c->emp.'" target="_blank">Clique aqui</a> 
		e siga os passos abaixo:<br />
		<font size="4" style="font-weight:bold">Escolha a aba que deseja visualizar > 00 - Dados da Franquia</font><br /><br />

		São Paulo, '.date('d').' de '.$mes.' de '.date('Y').'.<br />
		Hora: '.date('H').':'.date('i').'. <br /><br />

		Atenciosamente,<br />
		Equipe Cartório Postal.
		</body>
		</html>';
		
		include("../../includes/maladireta/class.PHPMailer.php");
		$mailer = new SMTPMailer();

		$From = 'Sistema Implantacao';
		$AddAddress = 'ti@cartoriopostal.com.br,TI';
		$AddCC = $dt->email.','.$dt->nome;
		$Subject = 'Implantacao - Liberar Sistema';
		$mailer->SEND($From, $AddAddress, $AddCC, '', '', $Subject, $html);
		
		/*$Recipiant = 'ti@cartoriopostal.com.br';
		$Cc = $dt->nome.' <'.$dt->email.'>';
		$Subject = 'Franquia - Liberar Sistema';
		
		set_time_limit(0);
		require("../includes/maladireta/config.inc.php");
		error_reporting(1);
		require("../includes/maladireta/class.Email.php");
		$Sender = "franquia@cartoriopostal.com.br";

		$CustomHeaders= '';
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->Cc = $Cc; 
		$message->SetHtmlContent($html);
		$pathToServerFile ="attachments/$at[1]/$at[2]";
		$serverFileMimeType = 'multipart/gased';
		$envio = $message->Send();*/
		
		$dt = $franquia->envia_email(3, 2, $c->emp, $c->usr);
		echo '<script>carregar_implantacao(10,'.$c->emp.');</script>';	
	break;
}
 ?>