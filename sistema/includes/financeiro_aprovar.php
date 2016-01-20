<?
	$financeiro_divisao='';
	setcookie ("rec_id_pedido_item", $_COOKIE['p_id_pedido_item']);
	setcookie ("rec_id_pedido", $_COOKIE['p_id_pedido']);

	$im = str_replace(',',"','",str_replace(',##',"","'".htmlentities($_COOKIE['p_id_pedido_item'])."##")."'");
	$lista = $financeiroDAO->listaPedidoIn($im,$controle_id_empresa);

	$cont=0;
	#verifica permissão
	foreach ($lista as $l) {
		$errors='';
		$error='';
		$valor = $l->valor;
		$financeiro_valor_rec = $l->valor_rec;
		if($financeiro_valor_rec<$valor) $valor=(float)($valor)-(float)($financeiro_valor_rec); else $valor = "";
		$financeiro_valor = $financeiro_valor+$valor;		
		$financeiro_divisao++;
	}
	?>
<form enctype="multipart/form-data" action="" method="post"	name="pedido_add">

<table width="800" cellpadding="4" cellspacing="1" class="result_tabela">
	<tr>
		<td colspan="4" class="tabela_tit">Recebimento</td>
	</tr>
	<tr>
		<td width="150" valign="top">
		<div align="right"><strong>Referente as ordens: </strong></div>
		</td>
		<td colspan="3"><?= str_replace(',',' - ',$_COOKIE['p_id_pedido']); ?>
		<br>
		<br>
		<b>Foram selecionados <?= $ext_num ?> pedidos.</b> 
		<input type="hidden" name="financeiro_divisao" value="<?= $financeiro_divisao ?>" />
		</td>
	</tr>
	<tr>
		<td colspan="4" class="tabela_tit">Confirmar Recebimento</td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Conta: </strong></div>
		</td>
		<td width="170">
			<select name="financeiro_nossa_conta" style="width: 150px" class="form_estilo">
				<?
				$lista = $contaDAO->listarConta($controle_id_empresa);
				foreach($lista as $l){
					echo '<option value="'.$l->sigla.'" >'.$l->sigla.'</option>';
				}
				?>
			</select><font color="#FF0000">*</font>
		</td>

		<td width="150">
		<div align="right"><b>Forma:</b></div>
		</td>

		<td>
			<select name="financeiro_forma" style="width: 150px" class="form_estilo">
				<option value="Dinheiro">Dinheiro</option>
				<option value="Cheque">Cheque</option>
				<option value="Boleto">Boleto</option>
				<option value="Depósito">Depósito</option>
				<option value="C. Correio">Vale Postal</option>
				<option value="Dinheiro Certo">Dinheiro Certo</option>
				<option value="Malote">Malote</option>
			</select><font color="#FF0000">*</font>
		</td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Classificação: </strong></div>
		</td>

		<td colspan="3">
			<select name="financeiro_classificacao" style="width: 490px" class="form_estilo">
			<?
				$lista = $financeiroDAO->listarClassificacaoRec();
				foreach($lista as $l){
					echo '<option value="'.$l->id_classificacao.'" >'.$l->classificacao.'</option>';
				}
			?>
			</select>
			<font color="#FF0000">*</font>
		</td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Identificação: </strong></div>
		</td>
		<td>
			<input type="text" class="form_estilo" name="financeiro_identificacao" style="width: 150px" /></td>
		<td>
			<div align="right"><strong>Data de Rec.: </strong></div>
		</td>

		<td>
			<input type="text" class="form_estilo" name="financeiro_data_p"	onKeyUp="masc_numeros(this,'##/##/####');" style="width: 150px" />
			<font color="#FF0000">*</font>
		</td>
	</tr>

	<tr>
		<td width="150">
			<div align="right"><strong>Descrição: </strong></div>
		</td>
		<td colspan="3">
			<input type="text" class="form_estilo" name="financeiro_descricao" style="width: 490px" />
		</td>
	</tr>
	<tr>
		<td width="150">
			<div align="right"><strong>Valor: </strong></div>
		</td>
		<td colspan="3">
			<input type="text" class="form_estilo" name="financeiro_valor" id="financeiro_valor" onkeyup="moeda(event.keyCode,this.value,'financeiro_valor');"
			value="<?= $financeiro_valor ?>" style="width: 150px" /><font color="#FF0000">*</font> Formato ####.##
		</td>
	</tr>
	<tr>
		<td colspan="4">
		<center>
			<input type="submit" class="button_busca" name="submit_financeiro_aprovar_valor" value="Lançar" />&nbsp; 
			<input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_add.action='financeiro_pagamento.php'" class="button_busca" />
		</center>
		</td>
	</tr>
</table>
</form>
<? #fim da alteração de status
	  exit;
?>