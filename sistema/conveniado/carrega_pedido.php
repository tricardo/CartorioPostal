<?

header("Content-Type: text/html; charset=ISO-8859-1", true);
include_once( "../includes/verifica_logado_conveniado.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$erro = 0;
$msg_error = '';
$servicosDAO = new servicoDAO();
foreach ($_GET as $cp => $valor) {
    pt_register('GET', (string) $cp);
    $p->{$cp} = ${$cp};
}

$p->origem = 'Site';

$p->id_empresa_atend = $controle_id_empresa;

$p->id_usuario = $conveniado->id_usuario;
$p->id_pacote = $conveniado->id_pacote;
$p->nome = $conveniado->nome;
$p->id_conveniado = $conveniado_id_cliente;
$p->id_cliente = $conveniado_id_conveniado;
$p->tel2 = $conveniado->tel2;
$p->tel = $conveniado->tel;
$p->ramal2 = $conveniado->ramal2;
$p->ramal = $conveniado->ramal;
$p->fax = $conveniado->fax;
$p->outros = $conveniado->outros;
$p->email = $conveniado_login;
$p->cpf = $conveniado->cpf;
$p->rg = $conveniado->rg;
$p->tipo = $conveniado->tipo;
$p->complemento = $conveniado->complemento;
$p->numero = $conveniado->numero;
$p->endereco = $conveniado->endereco;
$p->bairro = $conveniado->bairro;
$p->cidade = $conveniado->cidade;
$p->estado = $conveniado->estado;
$p->cep = $conveniado->cep;
$p->omesmo = $conveniado->omesmo;
$p->complemento_f = $conveniado->complemento_f;
$p->numero_f = $conveniado->numero_f;
$p->endereco_f = $conveniado->endereco_f;
$p->bairro_f = $conveniado->bairro_f;
$p->cidade_f = $conveniado->cidade_f;
$p->estado_f = $conveniado->estado_f;
$p->cep_f = $conveniado->cep_f;
$p->forma_pagamento = 'Faturado';
$p->contato = $conveniado->contato;
$p->contato_rg = '';
$p->obs = '';
$p->direcionamento = 'Sim';
if($p->dias=='') $p->dias=15; 
if ($p->cpf == "" || $p->cep == "" || $p->numero == "" || $p->endereco == "" || $p->cidade == "" || $p->estado == "" || $p->bairro == "" || $p->nome == "" ||
        $p->id_servico == "" || $p->id_servico_var == "" || $p->id_servico_var == "0" || $p->id_servico_departamento == "" || !is_numeric($p->id_servico) || !is_numeric($p->id_servico_var)) {
    if ($p->cep == "")
        $error .= "<li><b>CEP Inv�lido.</b></li>";
    if ($p->cpf == "")
        $error .= "<li><b>CPF/CNPJ inv�lido.</b></li>";
    if ($p->numero == "")
        $error .= "<li><b>N�mero do N�mero Inv�lido.</b></li>";
    if ($p->endereco == "")
        $error .= "<li><b>Endere�o Inv�lido.</b></li>";
    if ($cidade == "")
        $error .= "<li><b>Cidade Inv�lida.</b></li>";
    if ($estado == "")
        $error .= "<li><b>Estado Inv�lido.</b></li>";
    if ($bairro == "")
        $error .= "<li><b>Bairro Inv�lido.</b></li>";
    if ($nome == "")
        $error .= "<li><b>Nome Inv�lido.</b></li>";
    if ($id_servico == "" or $id_servico == "0" or !is_numeric($id_servico))
        $error .= "<li><b>Servi�o Inv�lido.</b></li>";
    if ($id_servico_var == "" or $id_servico_var == "0" or !is_numeric($id_servico_var))
        $error .= "<li><b>Varia��o Inv�lida.</b></li>";
    if ($id_servico_departamento == "")
        $error .= "<li><b>Departamento Inv�lido.</b></li>";
}

//if ($valor == "" or $valor == "0") {
//    $errors['valor'] = 1;
//    $error.="<li><b>O campo \"valor\" precisa ser preenchido.</b></li>";
//}
//if ($origem != "Ponto de Venda") {
//    $id_ponto = '';
//} else {
//   if ($id_ponto == '') {
//        $errors['id_ponto'] = 1;
//        $error.="<li><b>Selecione o Ponto de Venda.</b></li>";
//    }
//}

if ($email <> '') {
    $valida = validaEMAIL($p->email);
    if ($valida == 'false') {
        $errors['email'] = 1;
        $error.="<li><b>E-mail Inv�lido, digite corretamente.</b></li>";
    }
}

if ($tipo == 'cpf') {
    $valida = validaCPF($p->cpf);
    if ($valida == 'false') {
        $errors['cpf'] = 1;
        $error.="<li><b>CPF Inv�lido, digite corretamente.</b></li>";
    }
} else {
    $valida = validaCNPJ($p->cpf);
    if ($valida == 'false') {
        $errors['cpf'] = 1;
        $error.="<li><b>CNPJ Inv�lido, digite corretamente.</b></li>";
    }
}

#verifica servico
$res_servico = $servicosDAO->verificaServicoVar($p->id_servico_var);
if ($res_servico->total == '0') {
    $error .= '<li><b>Varia��o inv�lida, selecione novamente</b></li>';
    $errors['id_servico_var'] = 1;
}
$msg_error = $error;
if (count($errors) == '0') {
    $pedidoDAO = new PedidoDAO();
    $cadastrar_pedido = $pedidoDAO->inserir($p);
    echo '<img src="../images/null.gif" onload="RetornaErro(\'' . $form . '\', \'' . $msg_error . '\', 0);" />' . " \n";
    echo "<script language=\"javascript\" type=\"text/javascript\"> 
		document.getElementById('".$form ."').innerHTML = ''; 
          </script>
          <br><br><br><br><br><br><br><br><br>Pedido cadastrado com sucesso com protocolo n�mero ".$cadastrar_pedido."!<br><br><br>";
} else {
    echo '<img src="../images/null.gif" onload="RetornaErro(\'' . $form . '\', \'' . $msg_error . '\', 1);" />' . " \n";
}
?>