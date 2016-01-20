<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
pt_register('GET','id_financeiro');
pt_register('GET','id_pedido_item');
if($id_financeiro<>'' and $id_pedido_item<>''){
	$sql 	= "SELECT f.*, uu.nome FROM vsites_financeiro as f, vsites_user_usuario as uu where f.id_pedido_item='$id_pedido_item' and f.id_financeiro='$id_financeiro' and f.financeiro_tipo='Desembolso' and f.id_usuario = uu.id_usuario";
	$query 	= $objQuery->SQLQuery($sql);
	$res = mysql_fetch_array($query);
	$nome			 			= $res['nome'];
	$financeiro_tipo 			= $res['financeiro_tipo'];
	$financeiro_data 			= $res['financeiro_data'];
	$financeiro_data 			= invert($financeiro_data,'/','php').' '.substr($res["financeiro_data"],11, 8);
	$financeiro_nossa_conta		= $res['financeiro_nossa_conta'];
	$financeiro_autorizacao 	= $res['financeiro_autorizacao'];
	$financeiro_autorizacao_data= $res['financeiro_autorizacao_data'];
	$financeiro_autorizacao_data= invert($financeiro_autorizacao_data,'/','php').' '.substr($res["financeiro_autorizacao_data"],11, 8);
	$financeiro_conferido 		= $res['financeiro_conferido'];
	$financeiro_classificacao	= $res['financeiro_classificacao'];
	$financeiro_banco 			= $res['financeiro_banco'];
	$financeiro_agencia			= $res['financeiro_agencia'];
	$financeiro_conta 			= $res['financeiro_conta'];
	$financeiro_identificacao	= $res['financeiro_identificacao'];
	$financeiro_favorecido		= $res['financeiro_favorecido'];
	$financeiro_cpf 			= $res['financeiro_cpf'];
	$financeiro_descricao 		= $res['financeiro_descricao'];
	$financeiro_desembolsado 	= $res['financeiro_desembolsado'];
	$financeiro_troco 			= $res['financeiro_troco'];
	$res['financeiro_valor']    = (strlen($res['financeiro_valor']) > 0) ? $res['financeiro_valor'] : 0;
	$res['financeiro_sedex']    = (strlen($res['financeiro_sedex']) > 0) ? $res['financeiro_sedex'] : 0;
	$res['financeiro_rateio']   = (strlen($res['financeiro_rateio']) > 0) ? $res['financeiro_rateio'] : 0;
	$financeiro_valor 			= number_format($res['financeiro_valor'],2,".","");
	$financeiro_sedex			= number_format($res['financeiro_sedex'],2,".","");
	$financeiro_rateio 			= number_format($res['financeiro_rateio'],2,".","");
	$financeiro_forma 			= $res['financeiro_forma'];
?>
<form enctype="multipart/form-data" action="#aba6" method="post" name="pedido_financeiro_add">
<table width="650" class="tabela">
	<tr>
		<td colspan="4" class="tabela_tit">Desembolso <?= $financeiro_data.' - '.$nome ?></td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Conta: </strong></div>
		</td>
		<td><select name="financeiro_nossa_conta" style="width: 150px"
			class="form_estilo">
			<?
			$p_valor = '<option value="'.$financeiro_nossa_conta.'">'.$financeiro_nossa_conta.'</option>';
			$contaDAO = new ContaDAO();
			$contas = $contaDAO->listarConta($controle_id_empresa);
			foreach($contas as $conta){
				$p_valor .= '<option value="'.$conta->sigla.'">'.$conta->sigla.'</option>';
			}
			echo $p_valor;
			?>
		</select><font color="#FF0000">*</font></td>
		<td>
		<div align="right"><b>Forma:</b></div>
		</td>
		<td><select name="financeiro_forma" style="width: 150px"
			class="form_estilo">
			<option value=""
			<? 	if($financeiro_forma=='') echo ' selected="select"'; ?>></option>
			<option value="Dinheiro"
			<? 	if($financeiro_forma=='Dinheiro') echo ' selected="select"'; ?>>Dinheiro</option>
			<option value="Cheque"
			<? 	if($financeiro_forma=='Cheque') echo ' selected="select"'; ?>>Cheque</option>
			<option value="Boleto"
			<? 	if($financeiro_forma=='Boleto') echo ' selected="select"'; ?>>Boleto</option>
			<option value="Depósito"
			<? 	if($financeiro_forma=='Depósito') echo ' selected="select"'; ?>>Depósito</option>
			<option value="C. Correio"
			<? 	if($financeiro_forma=='C. Correio') echo ' selected="select"'; ?>>Vale
			Postal</option>
			<option value="Dinheiro Certo"
			<? 	if($financeiro_forma=='Dinheiro Certo') echo ' selected="select"'; ?>>Dinheiro
			Certo</option>
			<option value="Malote"
			<? 	if($financeiro_forma=='Malote') echo ' selected="select"'; ?>>Malote</option>
		</select><font color="#FF0000">*</font></td>
	</tr>

	<tr>
		<td width="150">
		<div align="right"><strong>Classificação: </strong></div>
		</td>
		<td colspan="3"><select name="financeiro_classificacao"
			style="width: 450px" class="form_estilo">
			<?
			$sql = $objQuery->SQLQuery("SELECT * from vsites_classificacao  where ordem='1' order by classificacao");
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['id_classificacao'].'"';
				if($financeiro_classificacao==$res['id_classificacao']) echo ' selected="select"';
				echo ' >'.$res['classificacao'].'</option>';
			}
	  ?>
		</select><font color="#FF0000">*</font></td>
	</tr>

	<tr>
		<td width="150">
		<div align="right"><strong>Banco: </strong></div>
		</td>
		<td colspan="3"><select name="financeiro_banco" style="width: 450px"
			class="form_estilo">
			<option value=""></option>
			<?
			$sql = $objQuery->SQLQuery("SELECT * from vsites_banco as b order by banco");
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['id_banco'].'"';
				if($financeiro_banco==$res['id_banco']) echo ' selected="select"';
				echo ' >'.$res['banco'].'</option>';
			}
	  ?>
		</select></td>
	</tr>

	<tr>
		<td width="150">
		<div align="right"><strong>Agência: </strong></div>
		</td>
		<td><input type="text" class="form_estilo" name="financeiro_agencia"
			value="<?= $financeiro_agencia ?>" style="width: 150px" /></td>
		<td>
		<div align="right"><b>Conta:</b></div>
		</td>
		<td><input type="text" class="form_estilo" name="financeiro_conta"
			value="<?= $financeiro_conta ?>" style="width: 150px" /></td>
	</tr>

	<tr>
		<td width="150">
		<div align="right"><strong>Identificação: </strong></div>
		</td>
		<td><input type="text" class="form_estilo"
			name="financeiro_identificacao"
			value="<?= $financeiro_identificacao ?>" style="width: 150px" /></td>
		<td>
		<div align="right"><b>CPF/CNPJ:</b></div>
		</td>
		<td><input type="text" class="form_estilo" name="financeiro_cpf"
			value="<?= $financeiro_cpf ?>" style="width: 150px" /></td>
	</tr>

	<tr>
		<td width="150">
		<div align="right"><strong>Favorecido: </strong></div>
		</td>
		<td colspan="3"><input type="text" class="form_estilo"
			name="financeiro_favorecido" value="<?= $financeiro_favorecido ?>"
			style="width: 450px" /></td>

	</tr>

	<tr>
		<td width="150">
		<div align="right"><strong>Descrição: </strong></div>
		</td>
		<td colspan="3"><input type="text" class="form_estilo"
			name="financeiro_descricao" value="<?= $financeiro_descricao ?>"
			style="width: 450px" /><font color="#FF0000">*</font></td>

	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Custas: </strong></div>
		</td>
		<td><input type="text" class="form_estilo" id="financeiro_valor_edit"
			onkeyup="moeda(event.keyCode,this.value,'financeiro_valor_edit');"
			name="financeiro_valor" value="<?= $financeiro_valor ?>"
			style="width: 150px" /><font color="#FF0000">*</font><br>
		Forma ####.##</td>
		<td></td>
		<td>
		<div class="form_estilo" style="width: 150px"><input type="checkbox"
			name="financeiro_conferido"
			<? if($financeiro_conferido=='on') echo 'checked="checked"'; ?>
			onclick="if(financeiro_troco.value=='') financeiro_troco.value=0; if(financeiro_desembolsado.value=='') financeiro_desembolsado.value=0; if(financeiro_valor.value>0 ) { financeiro_valor.value=(parseFloat(financeiro_desembolsado.value) - parseFloat(financeiro_troco.value) - parseFloat(financeiro_rateio.value) - parseFloat(financeiro_sedex.value)).toFixed(2); } else { financeiro_rateio.value=(parseFloat(financeiro_desembolsado.value) - parseFloat(financeiro_troco.value) - parseFloat(financeiro_sedex.value)).toFixed(2); };" /><b>Conferido
		</b></div>


		</td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Correio: </strong></div>
		</td>
		<td><input type="text" class="form_estilo" id="financeiro_sedex_edit"
			onkeyup="moeda(event.keyCode,this.value,'financeiro_sedex_edit');"
			name="financeiro_sedex" value="<?= $financeiro_sedex ?>"
			style="width: 150px" /><font color="#FF0000">*</font><br>
		Forma ####.##</td>
		<td>
		<div align="right"><strong>Honorários: </strong></div>
		</td>
		<td><input type="text" class="form_estilo" id="financeiro_rateio_edit"
			onkeyup="moeda(event.keyCode,this.value,'financeiro_rateio_edit');"
			name="financeiro_rateio" value="<?= $financeiro_rateio ?>"
			style="width: 150px" /><font color="#FF0000">*</font><br>
		Forma ####.##</td>
	</tr>

	<?
	$permissao = verifica_permissao('Financeiro Pedido Edit',$controle_id_departamento_p,$controle_id_departamento_s);
	if($permissao == 'TRUE'){
		?>
	<tr>
		<td width="150">
		<div align="right"><b>Desembolsado: </b></div>
		</td>
		<td><input type="text" class="form_estilo"
			name="financeiro_desembolsado"
			<?
			$permissao = verifica_permissao('Financeiro Desembolsado',$controle_id_departamento_p,$controle_id_departamento_s);
			if($permissao == 'FALSE'){
				echo ' readonly="readonly" ';
			}
			?>
			id="financeiro_desembolsado_edit"
			onkeyup="moeda(event.keyCode,this.value,'financeiro_desembolsado_edit');"
			value="<?= $financeiro_desembolsado ?>" style="width: 150px" /><font
			color="#FF0000">*</font></td>
		<td>
		<div align="right"><b>Troco: </b></div>
		</td>
		<td><input type="text" class="form_estilo" name="financeiro_troco"
			id="financeiro_troco_edit"
			onkeyup="moeda(event.keyCode,this.value,'financeiro_troco_edit');"
			value="<?= $financeiro_troco ?>" style="width: 150px" /></td>

	</tr>
	<tr>
		<td width="150">
		<div align="right"><b>Autorização: </b></div>
		</td>
		<td><select name="financeiro_autorizacao" class="form_estilo"
			style="width: 150px">
			<option value="Pendente"
			<? if($financeiro_autorizacao=='Pendente') echo ' selected="select"'; ?>>Pendente</option>
			<option value="Aprovado"
			<? if($financeiro_autorizacao=='Aprovado') echo ' selected="select"'; ?>>Aprovado</option>
			<option value="Reprovado"
			<? if($financeiro_autorizacao=='Reprovado') echo ' selected="select"'; ?>>Reprovado</option>
		</select></td>
		<td>
		<div align="right"><b>Data da Autorização: </b></div>
		</td>
		<td><input type="text" class="form_estilo"
			name="financeiro_autorizacao_data" readonly="readonly"
			value="<?= $financeiro_autorizacao_data ?>" style="width: 150px" /></td>

	</tr>
	<? } else { ?>
	<tr>
		<td width="150">
		<div align="right"><b>Desembolsado: </b></div>
		</td>
		<td><input type="text" class="form_estilo"
			id="financeiro_desembolsado_edit"
			onkeyup="moeda(event.keyCode,this.value,'financeiro_desembolsado_edit');"
			name="financeiro_desembolsado"
			value="<?= $financeiro_desembolsado ?>" style="width: 150px" /></td>
		<td>
		<div align="right"><b>Troco: </b></div>
		</td>
		<td><input type="text" class="form_estilo" id="financeiro_troco_edit"
			onkeyup="moeda(event.keyCode,this.value,'financeiro_troco_edit');"
			name="financeiro_troco" value="<?= $financeiro_troco ?>"
			style="width: 150px" /></td>

	</tr>
	<tr>
		<td width="150">
		<div align="right"><b>Autorização: </b></div>
		</td>
		<td><input type="text" class="form_estilo"
			name="financeiro_autorizacao" readonly="readonly"
			value="<?= $financeiro_autorizacao ?>" style="width: 150px" /></td>
		<td>
		<div align="right"><b>Data da Autorização: </b></div>
		</td>
		<td><input type="text" class="form_estilo"
			name="financeiro_autorizacao_data" readonly="readonly"
			value="<?= $financeiro_autorizacao_data ?>" style="width: 150px" /></td>

	</tr>
	<? } ?>
	<tr>
		<td colspan="4">
		<center><input type="hidden" name="financeiro_old_autorizacao"
			value="<?= $financeiro_autorizacao ?>" /> <input type="hidden"
			name="id_financeiro" value="<?= $id_financeiro ?>" /> <input
			type="submit" class="button_busca" name="submit_financeiro_edit"
			value="Atualizar" /></center>

		</td>

	</tr>
</table>
</form>
<? } ?>