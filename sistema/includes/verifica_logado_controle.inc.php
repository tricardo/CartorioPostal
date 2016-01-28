<?
#$cache_limiter = session_cache_limiter(); 
ini_set("session.cache_expire",3600);
session_start();

require_once( '../includes/classQuery.php' );
require_once('../model/Database.php');
$controle_login 	= $_SESSION['controle_login'];
$controle_senha 	= $_SESSION['controle_senha'];
$controle_atividade	= $_SESSION['controle_atividade'];

if($controle_login){
	$usuarioDAO = new UsuarioDAO();
	$controle_cp   = $usuarioDAO->verifica_logado($controle_login,$controle_senha);
	$controle_nome = $controle_cp->nome;
	$controle_email = $controle_cp->email;
	$controle_sexo = $controle_cp->sexo;
	$controle_tel  = $controle_cp->tel;
	$controle_fax  = $controle_cp->fax;
	$controle_id_empresa = $controle_cp->id_empresa;
	$controle_id_pais = $controle_cp->id_pais;
	$controle_id_usuario = $controle_cp->id_usuario;
	$controle_id_departamento_p = $controle_cp->departamento_p;
	$controle_id_departamento_s = $controle_cp->departamento_s;
	
	$departamento_s = explode(',',$controle_cp->departamento_s);
	$departamento_p = explode(',',$controle_cp->departamento_p);
	if(count($departamento_s)){ foreach($departamento_s as $l){	$controle_depto_s[$l]='1';	} }
	if(count($departamento_p)){ foreach($departamento_p as $l){	$controle_depto_p[$l]='1';	} }
	if($controle_id_departamento_p==''){
		echo 'Entre em contato com o Administrador do Cartório Postal!';
		exit;
	}
}
if ($_SESSION['controle_logado'] != 'ok' or $controle_cp->id_empresa=='' or $_SESSION['controle_teste'] == 'Sim'){
	echo '
		<script type="text/javascript"> 
			document.location.replace("../login/"); 
		</script>';
	exit;
}
?>
