<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','cpf');
	pt_register('GET','form');

	// Pesquisa ID localidade-----------------------------------
		$sql 	= "SELECT uc.* FROM vsites_user_cliente as uc, vsites_user_usuario as uu WHERE uc.cpf = '".$cpf."' and uc.conveniado!='Sim' and uc.id_usuario=uu.id_usuario and uu.id_empresa='".$controle_id_empresa."'";
		$query 	= $objQuery->SQLQuery($sql);
		$res 	= mysql_fetch_array($query);
		$endereco 		= $res['endereco'];
		$complemento 	= $res['complemento'];
		$numero		 	= $res['numero'];
		$bairro	  		= $res['bairro'];
		$cidade	  		= $res['cidade'];
		$estado			= $res['estado'];
		$cep		 	= $res['cep'];
		$nome		 	= $res['nome'];
		$rg			 	= $res['rg'];
		$tel		 	= $res['tel'];
		$ramal		 	= $res['ramal'];
		$tel2		 	= $res['tel2'];
		$ramal2		 	= $res['ramal2'];
		$fax		 	= $res['fax'];
		$outros		 	= $res['outros'];
		$email		 	= $res['email'];
		$tipo		 	= $res['tipo'];
?>
<script type="text/javascript">
	 document.<?= $form ?>.endereco.value='<?= $endereco ?>';
	 document.<?= $form ?>.bairro.value='<?= $bairro ?>';
	 document.<?= $form ?>.cidade.value='<?= $cidade ?>';
	 document.<?= $form ?>.estado.value='<?= $estado ?>';
	 document.<?= $form ?>.cep.value='<?= $cep ?>';
	 document.<?= $form ?>.complemento.value='<?= $complemento ?>';
	 document.<?= $form ?>.numero.value='<?= $numero ?>';
	 document.<?= $form ?>.nome.value='<?= $nome ?>';
	 document.<?= $form ?>.tel.value='<?= $tel ?>';
	 document.<?= $form ?>.ramal.value='<?= $ramal ?>';
	 document.<?= $form ?>.tel2.value='<?= $tel2 ?>';
	 document.<?= $form ?>.ramal2.value='<?= $ramal2 ?>';
	 document.<?= $form ?>.fax.value='<?= $fax ?>';
	 document.<?= $form ?>.rg.value='<?= $rg ?>';
	 document.<?= $form ?>.outros.value='<?= $outros ?>';
	 document.<?= $form ?>.email.value='<?= $email ?>';
	 document.<?= $form ?>.id_cliente.value='';
     carrega_contato('','');
</script>
		
