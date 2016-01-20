<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id');
	pt_register('GET','id_cliente');
	pt_register('GET','form');

	// Pesquisa ID localidade-----------------------------------
		$sql 	= "SELECT uc.* FROM vsites_user_cliente as uc, vsites_user_usuario as uu WHERE uc.id_cliente = '".$id_cliente."' and uc.id_usuario=uu.id_usuario and uu.id_empresa='".$controle_id_empresa."'";
		$query 	= $objQuery->SQLQuery($sql);
		$res 	= mysql_fetch_array($query);

		$empresa	 	= $res['nome'];
		$rg			 	= $res['rg'];
		$cpf		 	= $res['cpf'];
		
		$endereco_f 	= $res['endereco'];
		$complemento_f 	= $res['complemento'];
		$numero_f		= $res['numero'];
		$bairro_f	  	= $res['bairro'];
		$cidade_f	  	= $res['cidade'];
		$estado_f		= $res['estado'];
		$cep_f		 	= $res['cep'];
		
		$retem_iss	 	= $res['retem_iss'];	
		$tipo	 		= $res['tipo'];	
		$id_pacote		= $res['id_pacote'];	
		
		$sql 	= "SELECT * FROM vsites_user_conveniado as uc WHERE id_conveniado = '".$id."' and id_cliente='".$id_cliente."'";
		$query 	= $objQuery->SQLQuery($sql);
		$res 	= mysql_fetch_array($query);
		$email		 	= $res['email'];
        $faturamento    = $res['faturamento'];
	    $nome			= $res['nome'];
		$contato		= $res['contato'];
	    $tel			= $res['tel'];
		$ramal			= $res['ramal'];
		$tel2			= $res['tel2'];
		$ramal2			= $res['ramal2'];
		$fax		 	= $res['fax'];
		$outros			= $res['outros'];

		$rg			    = $res['rg'];
		$cpf		 	= $res['cpf'];
		$endereco 	    = $res['endereco'];
		$complemento    = $res['complemento'];
		$numero		    = $res['numero'];
		$bairro	  	    = $res['bairro'];
		$cidade	  	    = $res['cidade'];
		$estado		    = $res['estado'];
		$cep		 	= $res['cep'];
	    $tipo	 	    = $res['tipo'];
        if($faturamento=='on'){
		   $rg			  = $res['rg'];
		   $cpf		 	  = $res['cpf'];
		   $endereco_f 	  = $res['endereco'];
		   $complemento_f = $res['complemento'];
		   $numero_f	  = $res['numero'];
		   $bairro_f	  = $res['bairro'];
		   $cidade_f	  = $res['cidade'];
		   $estado_f	  = $res['estado'];
		   $cep_f		  = $res['cep'];
		   $tipo	 	  = $res['tipo'];
        }
?>
<script type="text/javascript">
	 
	 document.<?= $form ?>.endereco.value='<?= $endereco ?>';
	 document.<?= $form ?>.bairro.value='<?= $bairro ?>';
	 document.<?= $form ?>.cidade.value='<?= $cidade ?>';
	 document.<?= $form ?>.estado.value='<?= $estado ?>';
	 document.<?= $form ?>.cep.value='<?= $cep ?>';
	 document.<?= $form ?>.complemento.value='<?= $complemento ?>';
	 document.<?= $form ?>.numero.value='<?= $numero ?>';
	 
     document.<?= $form ?>.endereco_f.value='<?= $endereco_f ?>';
	 document.<?= $form ?>.bairro_f.value='<?= $bairro_f ?>';
	 document.<?= $form ?>.cidade_f.value='<?= $cidade_f ?>';
	 document.<?= $form ?>.estado_f.value='<?= $estado_f ?>';
	 document.<?= $form ?>.cep_f.value='<?= $cep_f ?>';
	 document.<?= $form ?>.complemento_f.value='<?= $complemento_f ?>';
	 document.<?= $form ?>.numero_f.value='<?= $numero_f ?>';

	 document.<?= $form ?>.nome.value='<?= $empresa ?>';
	 document.<?= $form ?>.tel.value='<?= $tel ?>';
	 document.<?= $form ?>.ramal.value='<?= $ramal ?>';
	 document.<?= $form ?>.tel2.value='<?= $tel2 ?>';
	 document.<?= $form ?>.ramal2.value='<?= $ramal2 ?>';
	 document.<?= $form ?>.fax.value='<?= $fax ?>';
	 document.<?= $form ?>.rg.value='<?= $rg ?>';
	 document.<?= $form ?>.outros.value='<?= $outros ?>';
	 document.<?= $form ?>.email.value='<?= $email ?>';
	 document.<?= $form ?>.cpf.value='<?= $cpf ?>';
	 document.<?= $form ?>.tipo.value='<?= $tipo ?>';
	 document.<?= $form ?>.contato.value='<?= $nome ?> - <?= $contato ?>';	 
 	 document.<?= $form ?>.id_conveniado.value='<?= $id_cliente ?>';
	 <? 
	 if($retem_iss=='on'){
	 ?>
	 	document.<?= $form ?>.retem_iss.checked='checked';
	 <? } ?>
	 document.<?= $form ?>.id_pacote.selectedIndex = '<?= $id_pacote ?>';

</script>
		
