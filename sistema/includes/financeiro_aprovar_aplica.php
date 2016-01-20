<?
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	if(in_array('2',$departamento_p)!=1){
		echo '<br><br><strong>Você não tem permissão para realizar essa operação.</strong>';
		exit;
	}
	pt_register('POST','financeiro_descricao');
	pt_register('POST','financeiro_forma');
	pt_register('POST','financeiro_valor');
	pt_register('POST','financeiro_data_p');
	pt_register('POST','financeiro_identificacao');
	pt_register('POST','financeiro_nossa_conta');
	pt_register('POST','financeiro_classificacao');
	$financeiro_data_p = invert($financeiro_data_p,'-','SQL');
	
	$f->financeiro_descricao=$financeiro_descricao;
	$f->financeiro_forma=$financeiro_forma;
	$f->financeiro_data_p=$financeiro_data_p;
	$f->financeiro_identificacao=$financeiro_identificacao;
	$f->financeiro_nossa_conta=$financeiro_nossa_conta;
	$f->financeiro_classificacao=$financeiro_classificacao;

	if($financeiro_data_p=="--" or $financeiro_data_p>date('Y-m-d') or strlen($financeiro_data_p)!=10){
		echo '<div class="erro"><strong>Preencha a data do recebimento corretamente.</strong></div>';
		exit;
	}
	
	if($financeiro_valor=="" || $financeiro_nossa_conta==""){
		if($financeiro_valor=="")
		echo '<br><br><strong>O campo valor é obrigatório.</strong>';
		if($financeiro_nossa_conta==""){
			echo '<br><br><strong>O campo conta é obrigatório.</strong><br>';
			echo '<a href="conta.php">cadastrar conta</a>';
		}
		exit;
	}

	$im = str_replace(',',"','",str_replace(',##',"","'".htmlentities($_COOKIE['rec_id_pedido_item'])."##")."'");
	$lista = $financeiroDAO->listaPedidoIn($im,$controle_id_empresa);
	$cont=0;
	
	#verifica permissão
	foreach ($lista as $l) {

		$valor 				= (float)($l->valor) - (float)($l->valor_rec);
		if($valor<$financeiro_valor and $valor>0) {
			$financeiro_valor=(float)($financeiro_valor)-(float)($valor);
			$valor = (float)($valor);
		}else{
			if($valor>0 and $financeiro_valor>0) {
				$valor = $financeiro_valor;
				$financeiro_valor = 0;
			} else {
				$valor=0;
			}
		}

		$f->financeiro_valor=$valor;
		$f->id_status=$l->id_status;		
		$f->financeiro_valor_rec = (float)($l->valor_rec)+(float)($valor);

		$financeiroDAO->inserirRecebimento($l->id_pedido_item,$controle_id_empresa,$controle_id_usuario,$f);
		$id_pedido_item_ant = $l->id_pedido_item ;
		$cont++;
		$done = '<div class="sucesso">#'.$l->id_pedido.'/'.$l->ordem.': Registro atualizado com sucesso</div>';
		if($financeiro_valor==0) break;
	}

	if($cont==0){
		$errors=1;
		$error = '- Nenhuma ordem foi selecionada'.$cont;
	}

	if($financeiro_valor>0 and $cont<>0) {
		$f->financeiro_valor=$financeiro_valor;
		$f->id_status='';
		$f->financeiro_valor_rec = (float)($f->financeiro_valor_rec)+(float)($financeiro_valor);
		$financeiroDAO->inserirRecebimento($id_pedido_item_ant,$controle_id_empresa,$controle_id_usuario,$f);
	}

	if ($errors) {
		echo '<div class="erro">'.$error.'</div>';
	} else {
		echo $done;
	}

	echo "
		<script>
			eraseCookie('rec_id_pedido_item');
			eraseCookie('rec_id_pedido');
		</script><br>
		<a href=\"financeiro_pagamento.php\">Clique aqui para voltar</a><br></div>
		";
	unset($_COOKIE['rec_id_pedido_item']);
	unset($_COOKIE['rec_id_pedido']);

	require('footer.php');
	exit;
?>