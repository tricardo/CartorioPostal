<?
require('header.php');
$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Voc� n�o tem permiss�o para acessar essa p�gina</strong>';
	exit;
}

set_time_limit(0);
require("../includes/maladireta/config.inc.php");
require("../includes/maladireta/class.Email.php");
error_reporting(1);
	
pt_register('GET','id');

$conveniadoDAO = new ConveniadoDAO();
$conveniado = $conveniadoDAO->selectPorId($id);
if($conveniado->status=='Ativo'){
	$senha = '';
	$tamanho = 6;$caracteres = "abcdefghijkmnpqrstuvwxyz23456789"; 	srand((double)microtime()*1000000);
	for($i=0; $i<$tamanho; $i++){
		$senha .= $caracteres[rand()%strlen($caracteres)];
	}

	$senha_new = $conveniado->email.$senha;
	$conveniado->senha_new = md5($senha_new);
	$conveniadoDAO->atualizaSenha($conveniado);

	/* envia uma mensagem */
		
	$Sender = "Senha de Acesso Cart�rio Postal <webmaster@cartoriopostal.com.br>";
	$Subject = 'Senha de Acesso Definitivo';
	$html = 'Prezado(a) '.$conveniado->nome.',<br><br>

As informa��es abaixo s�o confidenciais e importantes para voc� acessar nosso sistema.<br><br>

Seu login �: '.$conveniado->email.'<br>
E sua senha de acesso �: '.$senha.'<br><br>

Acesse www.cartoriopostal.com.br fa�a login na �rea restrita. Em caso de d�vidas entre no link suporte para ter ajuda on-line.<br>
Caso contr�rio envie um e-mail para webmaster@cartoriopostal.com.br<br><br>

Att,<br>
Cart�rio Postal<br>
';
	$CustomHeaders= '';
	$message = new Email($email, $Sender, $Subject, $CustomHeaders);
	$message->SetHtmlContent($html);
	$message->Send();

	echo '<div id="meio">'.$senha.'<br>Mensagem enviada com sucesso!<br>';
}else{
	echo '<br>Usu�rio Inativo ou N�o � conveniado!<br>';
}
echo '<a href="conveniado.php"> Clique aqui para voltar!</a>';
echo '</div>';
include('footer.php');
?>