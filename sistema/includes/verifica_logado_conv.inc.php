<?
session_start();
include_once( '../includes/classQuery.php' );
$conveniado_login 	= $_SESSION['conveniado_login'];
$conveniado_senha 	= $_SESSION['conveniado_senha'];
$conveniado_id 		= $_SESSION['conveniado_id'];
$conveniado_tabela 	= $_SESSION['conveniado_tabela'];
if($conveniado_tabela){
	$sql = $objQuery->SQLQuery("SELECT cc.*, c.id_cliente, uu.id_empresa, uu.id_usuario FROM vsites_user_conveniado as cc, vsites_user_cliente as c, vsites_user_usuario as uu WHERE cc.email = '".$conveniado_login."' and cc.senha='".$conveniado_senha."' and cc.status='Ativo' and c.id_cliente= cc.id_cliente and c.status='Ativo' and c.id_usuario=uu.id_usuario");
	$rowconv = mysql_fetch_array($sql);
    $conveniado_nome = $rowconv['nome'];
    $conveniado_tel = $rowconv['tel'];
    $conveniado_fax = $rowconv['fax'];
    $conveniado_id_cliente = $rowconv['id_cliente'];
    $controle_id_empresa = $rowconv['id_empresa'];

    $conveniado_id_conveniado = $rowconv['id_conveniado'];
    $conveniado->id_pacote = $rowconv['id_pacote'];
    $conveniado->tel2 = $rowconv['tel2'];
    $conveniado->tel = $rowconv['tel'];
    $conveniado->ramal2 = $rowconv['ramal2'];
    $conveniado->ramal = $rowconv['ramal'];

    $conveniado->fax = $rowconv['fax'];
    $conveniado->outros = $rowconv['outros'];
    $conveniado->email = $rowconv['email'];
    $conveniado->cpf = $rowconv['cpf'];
    $conveniado->rg = $rowconv['rg'];
    $conveniado->tipo = $rowconv['tipo'];
    $conveniado->complemento = $rowconv['complemento'];
    $conveniado->numero = $rowconv['numero'];
    $conveniado->endereco = $rowconv['endereco'];
    $conveniado->bairro = $rowconv['bairro'];
    $conveniado->cidade = $rowconv['cidade'];
    $conveniado->estado = $rowconv['estado'];
    $conveniado->cep = $rowconv['cep'];
    $conveniado->omesmo = $rowconv['omesmo'];
    $conveniado->complemento_f = $rowconv['complemento_f'];
    $conveniado->numero_f = $rowconv['numero_f'];
    $conveniado->endereco_f = $rowconv['endereco_f'];
    $conveniado->bairro_f = $rowconv['bairro_f'];
    $conveniado->cidade_f = $rowconv['cidade_f'];
    $conveniado->estado_f = $rowconv['estado_f'];
    $conveniado->cep_f = $rowconv['cep_f'];
    $conveniado->contato = $rowconv['contato'];                
}

if ($_SESSION['conveniado_logado'] != 'ok' or !$rowconv){
	echo '
		<script type="text/javascript"> 
			document.location.replace("../login/"); 
		</script>';
	exit;
}
?>