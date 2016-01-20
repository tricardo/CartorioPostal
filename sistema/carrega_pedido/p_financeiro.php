<?
if($controle_id_usuario==""){
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );
	pt_register('GET','id_pedido_item');
	$departamento_s = explode(',' ,$controle_id_departamento_s);
	$departamento_p = explode(',' ,$controle_id_departamento_p);
	$pedidoDAO = new PedidoDAO();
}

#verifica se o usuário não está tentando burlar a url
if($controle_id_empresa==1)
    $p = $pedidoDAO->buscaPorId($id_pedido_item,0);
else
    $p = $pedidoDAO->buscaPorId($id_pedido_item,$controle_id_empresa);
$id_pedido_item = $p->id_pedido_item;
if($id_pedido_item==''){
	echo 'Você não tem permissão de alterar esse pedido';
	exit;
}

$bancoDAO = new BancoDAO();
$financeiroDAO = new FinanceiroDAO();
?>
<form action="#aba6" method="post" name="p_financeiro" id="p_financeiro"
	enctype="multipart/form-data"><input type="hidden" name="p_financeiro"
	value="1">
<table width="800" class="tabela">
	<tr>
		<td colspan="4" class="tabela_tit">Solicitar Desembolso</td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><b>Forma:</b></div>
		</td>
		<td width="200"><select name="financeiro_forma" style="width: 150px"
			class="form_estilo<? if($errors->financeiro_forma==1) echo '_erro'; ?>">
			<option value=""></option>
			<?
			$p_valor = "";
			$fin = $financeiroDAO->listarForma();
			foreach($fin as $f){
				$p_valor .='<option value="'.$f->forma_2.'" ';
				if($financeiro_forma==$f->forma_2) $p_valor .= ' selected ';
				$p_valor .='>'.$f->forma.'</option>';
			}
			echo $p_valor;
			?>
		</select> <font color="#FF0000">*</font></td>
		<td width="200"></td>
		<td></td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Classificação: </strong></div>
		</td>
		<td colspan="3"><select name="financeiro_classificacao"
			style="width: 560px"
			class="form_estilo<? if($errors->financeiro_classificacao==1) echo '_erro'; ?>">
			<option value=""></option>
			<?
			$p_valor = "";
			$fin = $financeiroDAO->listarClassificacao();
			foreach($fin as $f){
				$p_valor .='<option value="'.$f->id_classificacao.'" ';
				if($financeiro_classificacao==$f->id_classificacao) $p_valor .= ' selected ';
				$p_valor .='>'.$f->classificacao.'</option>';
			}
			echo $p_valor;
			?>
		</select> <font color="#FF0000">*</font></td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Banco: </strong></div>
		</td>
		<td colspan="3"><select name="financeiro_banco" style="width: 560px"
			class="form_estilo<? if($errors->financeiro_banco==1) echo '_erro'; ?>">
			<option value=""></option>
			<?
			$p_valor = "";
			$fin = $bancoDAO->listar();
			foreach($fin as $f){
				$p_valor .='<option value="'.$f->id_banco.'" ';
				if($financeiro_banco==$f->id_banco) $p_valor .= ' selected ';
				$p_valor .='>'.$f->banco.'</option>';
			}
			echo $p_valor;
			?>
		</select></td>
	</tr>

	<tr>
		<td width="150">
		<div align="right"><strong>Agência: </strong></div>
		</td>
		<td><input type="text" class="form_estilo" name="financeiro_agencia"
			style="width: 150px" value="<?= $financeiro_agencia ?>" /></td>
		<td>
		<div align="right"><b>Conta:</b></div>
		</td>
		<td><input type="text" class="form_estilo" name="financeiro_conta"
			style="width: 150px" value="<?= $financeiro_conta ?>" /></td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Identificação: </strong></div>
		</td>
		<td><input type="text" class="form_estilo"
			name="financeiro_identificacao" style="width: 150px"
			value="<?= $financeiro_identificacao ?>" /></td>
		<td>
		<div align="right"><b>CPF/CNPJ:</b></div>
		</td>
		<td><input type="text" class="form_estilo" name="financeiro_cpf"
			style="width: 150px" value="<?= $financeiro_cpf ?>" /></td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Favorecido: </strong></div>
		</td>
		<td colspan="3"><input type="text" class="form_estilo"
			name="financeiro_favorecido" style="width: 560px"
			value="<?= $financeiro_favorecido ?>" /></td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Descrição: </strong></div>
		</td>
		<td colspan="3"><? 
		if($financeiro_descricao==""){
			$financeiro_descricao = $p->servico.' ';
		}
		?> <input type="text"
			class="form_estilo<? if($errors->financeiro_descricao==1) echo '_erro'; ?>"
			name="financeiro_descricao" value="<?= $financeiro_descricao ?>"
			style="width: 560px" /> <font color="#FF0000">*</font></td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Custas: </strong></div>
		</td>
		<td colspan="3"><input type="text"
			class="form_estilo<? if($errors->financeiro_valor==1) echo '_erro'; ?>"
			name="financeiro_valor" value="<?= $financeiro_valor ?>"
			id="financeiro_valor"
			onkeyup="moeda(event.keyCode,this.value,'financeiro_valor');"
			style="width: 150px" /> <font color="#FF0000">*</font> Formato
		####.##</td>
	</tr>
	<tr>
		<td width="150" valign="top">
		<div align="right"><strong>Correio: </strong></div>
		</td>
		<td><input type="text"
			class="form_estilo<? if($errors->financeiro_sedex==1) echo '_erro'; ?>"
			id="financeiro_sedex_edit"
			onkeyup="moeda(event.keyCode,this.value,'financeiro_sedex_edit');"
			name="financeiro_sedex" value="<?= $financeiro_sedex ?>"
			style="width: 150px" /><br>
		Forma ####.##</td>
		<td valign="top">
		<div align="right"><strong>Honorários: </strong></div>
		</td>
		<td><input type="text"
			class="form_estilo<? if($errors->financeiro_rateio==1) echo '_erro'; ?>"
			id="financeiro_rateio_edit"
			onkeyup="moeda(event.keyCode,this.value,'financeiro_rateio_edit');"
			name="financeiro_rateio" value="<?= $financeiro_rateio ?>"
			style="width: 150px" /><br>
		Forma ####.##</td>
	</tr>
	<tr>
		<td colspan="4">
		<center><input type="submit" class="button_busca"
			name="submit_financeiro" value="Solicitar" />&nbsp; <input
			type="submit" name="cancelar" value="Cancelar"
			onclick="document.pedido_add.action='pedido.php'"
			class="button_busca" /></center>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="tabela_tit">Operações Financeiras</td>
	</tr>
	<tr>
		<td colspan="4">
		<?
		$p_valor = "";
		$fin = $financeiroDAO->listarPedidoItemDesembolso($id_pedido_item);
		foreach($fin as $f){
			$p_valor .= '
						<div class="form_estilo_r" style="width:85px; float:left; clear:left">'.invert($f->financeiro_data,'/','PHP'). '</div>
						<div class="form_estilo_r" style="width:75px; float:left">'.number_format($f->financeiro_valor,2,".","").'</div>
						<div class="form_estilo_r" style="width:80px; float:left">'.$f->financeiro_tipo.'</div>
						<div class="form_estilo_r" style="width:300px; float:left">'.substr($f->financeiro_descricao,0,50).'</div>
						<div class="form_estilo_r" style="width:100px; float:left">'.$f->financeiro_autorizacao.'</div>
						<input type="button" name="submit_editar" value="Editar" onclick="carrega_financeiro_edit(\''.$id_pedido_item.'\',\''.$f->id_financeiro.'\'); $(\'#windowMensagem\').show();" class="button_busca" style="float:left;" />';
		}

		$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
		if(($permissao == 'TRUE' || $p->id_empresa==$controle_id_empresa) ){
			$fin = $financeiroDAO->listarPedidoItemRecebimento($id_pedido_item,$controle_id_empresa);
			foreach($fin as $f){
				$p_valor .= '
				<div class="form_estilo_r" style="width:85px; float:left; clear:left">'.invert($f->financeiro_data,'/','PHP'). '</div>
				<div class="form_estilo_r" style="width:75px; float:left">'.number_format($f->financeiro_valor,2,".","").'</div>
				<div class="form_estilo_r" style="width:80px; float:left">'.$f->financeiro_tipo.'</div>
				<div class="form_estilo_r" style="width:300px; float:left">'.substr($f->financeiro_descricao,0,50).'</div>
				<div class="form_estilo_r" style="width:100px; float:left">'.$f->financeiro_autorizacao.'</div>
				<input type="button" name="submit_editar" value="Editar" onclick="carrega_financeiro_edit_r(\''.$id_pedido_item .'\',\''.$f->id_financeiro.'\'); $(\'#windowMensagem\').show();" class="button_busca" style="float:left;" />';
			}
			if($p->id_fatura<>'')	$p_valor .= '<tr><td colspan="4"><b>Fatura número:</b> '.$p->id_fatura.' - <a href="rel_baixar_boleto_fat.php?id='.$p->id_fatura.'" target="_blank">Clique aqui para ver o Boleto</a></td></tr>';
		}
		echo $p_valor;
		?>
		</td>
		
		</td>
	</tr>
</table>
</form>