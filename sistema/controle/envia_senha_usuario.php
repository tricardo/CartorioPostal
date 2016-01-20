<?
require('header.php');
require_once('../model/DatabaseEAD.php');
$permissao = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE') {
    echo '<br><br><strong>Voc� n�o tem permiss�o para acessar essa p�gina</strong>';
    exit;
}
pt_register('GET', 'id');

$usuarioDAO = new UsuarioDAO();
$eadDAO = new EadDAO();
$usuario = $usuarioDAO->selectPorId($id);

if ($controle_id_empresa != '1' && ($usuario->id_empresa != $controle_id_empresa or $_SESSION['controle_teste'] != '')) {
    echo '<br>Usu�rio Inativo ou N�o � conveniado!<br>';
} else {

    $senha = '';
    $tamanho = 6;
    $caracteres = "abcdefghijkmnpqrstuvwxyz23456789";
    srand((double) microtime() * 1000000);
    for ($i = 0; $i < $tamanho; $i++) {
        $senha .= $caracteres[rand() % strlen($caracteres)];
    }
    #atualiza no sistema
    $usuarioDAO->atualizaSenha($usuario->email, $senha);
    #atualiza no ead
    $eadDAO->atualizaEad($usuario, $senha);

//error_reporting(0);
    set_time_limit(0);
    require("../includes/maladireta/config.inc.php");
    require("../includes/maladireta/class.Email.php");
    error_reporting(1);


    $Subject = 'Senha de Acesso do Sistema Corporativo';
    $html = 'Prezado(a) ' . $usuario->nome . ',<br><br>

As informa��es abaixo s�o confidenciais e importantes para voc� acessar nosso <strong style="color:#0000FF">Sistema Corporativo</strong>.<br><br>

Seu login �: ' . $usuario->email . '<br>
E sua senha de acesso �: ' . $senha . '<br><br>

Para entrar no sistema acesse www.cartoriopostal.com.br/login/ fa�a login na �rea corporativa para acessar o <strong style="color:#FF0000">Sistema Corporativo</strong>.<br>
Seu login e senha s� funcionar� quando a franquia for inaugurada.

Para entrar no nosso Servi�o de Atendimento a Franquia (SAF) acesse www.cartoriopostal.com.br/login/ e fa�a login.<br>
Voc� pode acessar o SAF a qualquer momento, mesmo antes da inaugura��o da sua unidade.

Caso contr�rio envie um e-mail para ti@cartoriopostal.com.br<br><br>

Att,<br>
Equipe Cart�rio Postal<br>
';

    include("../../includes/maladireta/class.PHPMailer.php");
    $mailer = new SMTPMailer();

    $From = 'Sistema Cart�rio Postal';
    $AddAddress = $usuario->email . ',' . $nome;
    $AddBCC = '';
    if ($controle_id_usuario != 1) {
        $AddBCC = 'ti@cartoriopostal.com.br';
    }
    $mailer->SEND($From, $AddAddress, $AddCC, $AddBCC, '', $Subject, $html);

    echo '<div id="meio"><br>Mensagem enviada com sucesso!<br>

<a href="usuario.php"> Clique aqui para voltar!</a><br/>
<a href="usuario_add.php"> Adicionar outro usu�rio!</a>';
    echo '<br><br>Senha Atual: '.$senha;
    echo '</div>';
}
include('footer.php');
?>