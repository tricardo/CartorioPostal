<?
	if(in_array('2',$departamento_p)!=1){
		echo '<br><br><strong>Voc� n�o tem permiss�o para realizar essa opera��o.</strong>';
		exit;
	}
	
	$im = str_replace(',',"','",str_replace(',##',"","'".htmlentities($_COOKIE['p_id_pedido_item'])."##")."'");
	$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido_item'].'##'));
	$p_id_pedido = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido'].'##'));
	$cont=0;
	#verifica permiss�o
	$lista = $financeiroDAO->listaPedidoIn($im,$controle_id_empresa);
	foreach ($lista as $l) {
		$error='';
		$errors='';
		if($l->id_status!=2){
			$errors=1;
			$error='S� � poss�vel reprovar um pagamento quando o status do servi�o for Concilia��o';
		}

		if ($errors!=1){
			$s->status_obs='';
			$s->status_dias=0;
			$s->status_hora='';
			$done = $atividadeDAO->inserirAtividade('181',$s,$controle_id_usuario,$l->id_pedido_item);
			echo '<div class="sucesso">'.$p_id_pedido[$cont] .' Registro atualizado com sucesso!</div>';
		}

		if ($errors) {
			echo '<div class="erro">'.$p_id_pedido[$cont].' - ' .$error.'</div>';
		}
		$cont++;
	}
	echo '<br><br>';
?>