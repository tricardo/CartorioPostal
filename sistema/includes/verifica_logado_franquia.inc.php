<?
session_start();
include_once( '../includes/classQuery.php' );
$franquia_login 	= $_SESSION['franquia_login'];
$franquia_senha 	= $_SESSION['franquia_senha'];
$franquia_id 		= $_SESSION['franquia_id'];
$franquia_tabela 	= $_SESSION['franquia_tabela'];
if($franquia_tabela){
	$sql = $objQuery->SQLQuery("SELECT ".$franquia_tabela.".*, vsites_user_empresa.id_empresa FROM ".$franquia_tabela.", vsites_user_empresa WHERE ".$franquia_tabela.".email = '".$franquia_login."' and ".$franquia_tabela.".senha='".$franquia_senha."' and ".$franquia_tabela.".status='Ativo' and vsites_user_empresa.id_empresa= vsites_user_usuario.id_empresa");
	$row = mysql_fetch_array($sql);
	$franquia_nome = $row['nome'];
	$franquia_sexo = $row['sexo'];
	$franquia_tel = $row['tel'];
	$franquia_fax = $row['fax'];
	$franquia_id_empresa = $row['id_empresa'];	
	$franquia_id_usuario = $row['id_usuario'];	
	$franquia_id_departamento_p = $row['departamento_p'];
	if($franquia_id_departamento_p==''){
		echo 'Entre em contato com o Administrador do Cartório Postal!';
		exit;
	}
	
	$franquia_id_departamento_s = $row['departamento_s'];
		
}
if ($_SESSION['franquia_logado'] != 'ok' or !$row){
	echo '
		<script type="text/javascript"> 
			document.location.replace("../login/"); 
		</script>';
	exit;
}
?>