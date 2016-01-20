<?
require('header.php');
$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
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
		
	$Sender = "Senha de Acesso Cartório Postal <webmaster@cartoriopostal.com.br>";
	$Subject = 'Senha de Acesso Definitivo';
	$html = 'Prezado(a) '.$conveniado->nome.',<br><br>

As informações abaixo são confidenciais e importantes para você acessar nosso sistema.<br><br>

Seu login é: '.$conveniado->email.'<br>
E sua senha de acesso é: '.$senha.'<br><br>

Acesse www.cartoriopostal.com.br faça login na àrea restrita. Em caso de dúvidas entre no link suporte para ter ajuda on-line.<br>
Caso contrário envie um e-mail para webmaster@cartoriopostal.com.br<br><br>

Att,<br>
Cartório Postal<br>
';
	$CustomHeaders= '';
	$message = new Email($email, $Sender, $Subject, $CustomHeaders);
	$message->SetHtmlContent($html);
	$message->Send();

	echo '<div id="meio">'.$senha.'<br>Mensagem enviada com sucesso!<br>';
}else{
	echo '<br>Usuário Inativo ou Não é conveniado!<br>';
}
echo '<a href="conveniado.php"> Clique aqui para voltar!</a>';
echo '</div>';
include('footer.php');
?>