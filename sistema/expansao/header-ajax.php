<? ob_start();
header("Content-Type: text/html; charset=iso-8859-1", true);
require("../includes/funcoes.php");
require("../includes/verifica_logado_controle.inc.php");
require("../includes/global.inc.php");


$perm_fin = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_pgto = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_cobr = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_sup = verifica_permissao('Supervisor', $controle_id_departamento_p, $controle_id_departamento_s);

$expansao = new ExpansaoDAO();
$expansaos= new ExpansaoStatusDAO();
$strings  = new StringsDAO();

$exp_item = $expansao->verAcesso(1, $controle_id_empresa, $controle_id_usuario, 
	$controle_id_departamento_p, $controle_id_departamento_s, $controle_nome);
if($exp_item->acesso == 0){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	require('rodape.php');
	exit;
}

$c        = new stdClass();
$c->c_id_usuario = $controle_id_usuario;
$c->c_nome     = $controle_nome; 
$direcao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
$c->c_direcao = ($direcao == 'FALSE' or $controle_id_empresa!='1') ? 0 : 1;

if((isset($_GET)) || (isset($_POST))){
    if(isset($_GET)){
        foreach($_GET as $cp => $valor){ $c->$cp = $strings->html_entities('', $valor); }
    }
    if(isset($_POST)){
        foreach($_POST as $cp => $valor){ $c->$cp = $strings->html_entities('', $valor); }
    }
} ?>