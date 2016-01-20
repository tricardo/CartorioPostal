<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id');
	pt_register('GET','acao');	
	if($acao!='Excluído' and $acao!='Ativo'){
		echo 'Ação inválida, entre em contato com o administrador!';
		exit;
	}

	$sql = $objQuery->SQLQuery("update saf_forum_resposta set status='".$acao."' where id_forum_resposta='" . $id . "'");
	echo '
	<input type="button" name="excluir_'.$id.'" onclick="forum_resposta_acao(\'resposta_'.$id.'\',\''.$id.'\',\'Excluído\')" value = "Excluir">
	<input type="button" name="aprovar_'.$id.'" onclick="forum_resposta_acao(\'resposta_'.$id.'\',\''.$id.'\',\'Ativo\')" value = "Aprovar">
	<b>Status:</b> '.$acao.'
	';
?>