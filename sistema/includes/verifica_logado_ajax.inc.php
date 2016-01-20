<?

ini_set("session.cache_expire", 3600);
session_start();
include_once( '../includes/classQuery.php' );
include_once( '../model/Database.php' );

$controle_login = $_SESSION['controle_login'];
if ($controle_login) {
    $controle_senha = $_SESSION['controle_senha'];
    $controle_id = $_SESSION['controle_id'];
    $controle_tabela = $_SESSION['controle_tabela'];
    $controle_atividade = $_SESSION['controle_atividade'];

    $sql = $objQuery->SQLQuery("SELECT uu.*, ue.id_pais FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE uu.email =  '" . $controle_login . "' and uu.senha='" . $controle_senha . "' and uu.status='Ativo' and uu.id_empresa=ue.id_empresa limit 1");
    $row = mysql_fetch_array($sql);
    $controle_nome = $row['nome'];
    $controle_sexo = $row['sexo'];
    $controle_tel = $row['tel'];
    $controle_fax = $row['fax'];
    $controle_id_usuario = $row['id_usuario'];
    $controle_id_empresa = $row['id_empresa'];
	$controle_id_pais = $row['id_pais'];
    $controle_id_departamento = $row['departamento_p'];
    $departamento_pos = strpos($controle_id_departamento, ',');
    $departamento_p = substr($row['departamento_p'], 0, $departamento_pos);
    $controle_id_departamento = $departamento_p;

    $controle_id_departamento_p = $row['departamento_p'];
    if ($controle_id_departamento_p == '') {
        echo 'Entre em contato com o Administrador do Cartório Postal!';
        exit;
    }

    $controle_id_departamento_s = $row['departamento_s'];
}

$conveniado_login = $_SESSION['conveniado_login'];
$conveniado_senha = $_SESSION['conveniado_senha'];
$conveniado_id = $_SESSION['conveniado_id'];
$conveniado_tabela = $_SESSION['conveniado_tabela'];
if ($conveniado_login <> '') {
    $sql = $objQuery->SQLQuery("SELECT cc.*, c.id_cliente, uu.id_empresa FROM vsites_user_conveniado as cc, vsites_user_cliente as c, vsites_user_usuario as uu WHERE cc.email = '" . $conveniado_login . "' and cc.senha='" . $conveniado_senha . "' and cc.status='Ativo' and c.id_cliente= cc.id_cliente and c.status='Ativo' and c.id_usuario=uu.id_usuario");
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

if (($_SESSION['controle_logado'] != 'ok' or !$row) and (($_SESSION['conveniado_login'] == '' or !$rowconv) and $acesso_conv == 'ok')) {
    echo '
			<script type="text/javascript"> 
				document.location.replace("/login/"); 
			</script>';
    exit;
}
?>