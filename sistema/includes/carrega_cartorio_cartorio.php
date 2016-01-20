<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	include_once('../includes/browser.php');
	
	pt_register('GET','cartorio_estado');
	pt_register('GET','cartorio_cidade');
	pt_register('GET','cartorio_atribuicao');
	
	$browser2 	= new MyBrowser();
	$versao 	= $browser2 -> browser('version');
	$browser 	= $browser2 -> browser('browser');

	$cartorio_estado_2 = utf8_decode($cartorio_estado);
	$cartorio_cidade_2 = utf8_decode($cartorio_cidade);

	if($cartorio_cidade<>''){
		$sql 	= "SELECT nome, id_cartorio FROM vsites_cartorio WHERE (cidade = '".$cartorio_cidade_2."' or cidade = '".$cartorio_cidade."') and estado = '".$cartorio_estado."' and atribuicao = '".$cartorio_atribuicao."' and status='Ativo' order by nome";
		$query 	= $objQuery->SQLQuery($sql);
		while($res = mysql_fetch_array($query)){
				$valor .= '<option value="'.$res['id_cartorio'].'">'.$res['nome'].'</option>';
		}
	}
	echo $valor;
?>