<?
#session_cache_limiter('private');
#$cache_limiter = session_cache_limiter(); 
ini_set("session.cache_expire",3600);
session_start();

require( '../includes/classQuery.php' );
require( '../model/Database.php' );
$safpostal_login 	= $_SESSION['safpostal_login'];
$safpostal_senha 	= $_SESSION['safpostal_senha'];
$safpostal_id 		= $_SESSION['safpostal_id'];
$safpostal_tabela 	= $_SESSION['safpostal_tabela'];

if($safpostal_login){
	$sql = $objQuery->SQLQuery("SELECT uu.*, ue.fantasia FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE uu.email = '".$safpostal_login."' and uu.senha='".$safpostal_senha."' and uu.status!='Cancelado' and uu.id_empresa=ue.id_empresa");
	$row = mysql_fetch_array($sql);
	$safpostal_nome = $row['nome'];
	$safpostal_fantasia= $row['fantasia'];
	$safpostal_sexo = $row['sexo'];
	$safpostal_tel = $row['tel'];
	$safpostal_fax = $row['fax'];
	$safpostal_id_empresa = $row['id_empresa'];
	$safpostal_id_usuario = $row['id_usuario'];	
	$safpostal_departamento_saf = $row['departamento_saf'];
	$safpostal_departamento_p = $row['departamento_p'];
	$ext_departamento_saf = explode(',',$safpostal_departamento_saf);
	$ext_departamento_p = explode(',',$safpostal_departamento_p);
}

if ($_SESSION['safpostal_logado'] != 'ok' or !$row or $_SESSION['safpostal_teste'] == 'Sim'){
	echo '
		<script type="text/javascript"> 
			document.location.replace("/login/"); 
		</script>';
	exit;
}
?>