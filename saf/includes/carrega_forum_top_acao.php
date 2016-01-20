<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id');
	pt_register('GET','acao');	
	if($acao!='Inativo' and $acao!='Ativo'){
		echo 'Ação inválida, entre em contato com o administrador!';
		exit;
	}

	$sql = $objQuery->SQLQuery("update saf_forum set status='".$acao."' where id_forum='" . $id . "'");
	echo '
	<input type="button" name="ativar_'.$id.'" onclick="forum_topico_acao(\'topico_'.$id.'\',\''.$id.'\',\'Ativo\')" value = "Ativar">
	<input type="button" name="inativar_'.$id.'" onclick="forum_topico_acao(\'topico_'.$id.'\',\''.$id.'\',\'Inativo\')" value = "Inativar">
	<b>Status:</b> '.$acao.'
	';
?>