<?
$contaDAO = new ContaDAO();
if($controle_id_empresa==1){
	$financeiro_divisao='';

	$im = str_replace(',',"','",str_replace(',##',"","'".htmlentities($_COOKIE['fr_id_rel_royalties'])."##")."'");
	$lista = $financeiroDAO->listaRoyIn($im);
	$cont=0;
	#verifica permissão
	foreach ($lista as $l) {
		$errors='';
		$error='';
		$roy = $l->valor_royalties;
		$roy_rec = $l->roy_rec;
		$fpp = $l->valor_propaganda;
		$fpp_rec = $l->fpp_rec;
		if($roy_rec<$roy) $roy=(float)($roy)-(float)($roy_rec); else $roy = 0;
		if($fpp_rec<$fpp) $fpp=(float)($fpp)-(float)($fpp_rec); else $fpp = 0;
		$financeiro_divisao++;
		
		$roy_total = (float)($roy)+(float)($roy_total);
		$fpp_total = (float)($fpp)+(float)($fpp_total);
		
		$p_valor_roy .= '				
		<tr>
			<td>
				<div align="right"><strong>'.$l->fantasia.'</strong></div>
			</td>
			<td colspan="3">
				<strong>Royalties: </strong>
				<input type="hidden" name="id_rel_royalties"	value="'. $l->id_rel_royalties .'"  />
				<input type="text" class="form_estilo" name="roy'. $l->id_rel_royalties .'" id="roy'. $l->id_rel_royalties .'" onkeyup="moeda(event.keyCode,this.value,\'roy'. $l->id_rel_royalties .'\');"
				value="'. $roy .'" style="width: 150px" /> 	<strong>FPP: </strong>
				<input type="text" class="form_estilo" name="fpp'. $l->id_rel_royalties .'" id="fpp'. $l->id_rel_royalties .'" onkeyup="moeda(event.keyCode,this.value,\'fpp'. $l->id_rel_royalties .'\');"
				value="'. $fpp .'" style="width: 150px" /> Formato ####.##
			</td>
		</tr>
		';
		
	}
	?>
<form enctype="multipart/form-data" action="" method="post"	name="pedido_add">
<table width="800" cellpadding="4" cellspacing="1" class="result_tabela" style="margin:auto">
	<tr>
		<td colspan="4" class="tabela_tit">Recebimento</td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Conta: </strong></div>
		</td>
		<td width="170">
			<select name="financeiro_nossa_conta" style="width: 150px" class="form_estilo">
				<?
				$lista = $contaDAO->listarConta($controle_id_empresa);
				$p_valor='';
				foreach($lista as $l){
					$p_valor .= '<option value="'.$l->sigla.'" >'.$l->sigla.'</option>';
				}
				echo $p_valor;
				?>
			</select><font color="#FF0000">*</font>
		</td>

		<td width="150">
		<div align="right"><b>Forma:</b></div>
		</td>

		<td>
			<select name="financeiro_forma" style="width: 150px" class="form_estilo">
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
			<input type="text" class="form_estilo" name="financeiro_data_p"	onKeyUp="masc_numeros(this,'##/##/####');" style="width: 150px" /><font color="#FF0000">*</font>
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

	<?= $p_valor_roy ?>

	<tr>
		<td>
			<div align="right"><strong>Total</strong></div>
		</td>
		<td colspan="3">
			<strong>Royalties: </strong>
			<input type="text" class="form_estilo" name="roy_total" value="<?= $roy_total ?>" readonly style="width: 150px" /> 	
			<strong>FPP: </strong>
			<input type="text" class="form_estilo" name="fpp_total" value="<?= $fpp_total ?>" readonly style="width: 150px" />
			<strong>TOTAL: </strong>
			<input type="text" class="form_estilo" name="fpp_total" value="<? $total = (float)($fpp_total)+(float)($roy_total); echo $total; ?>" readonly style="width: 150px" />
		</td>
	</tr>

	<tr>
		<td colspan="4">
		<center>
			<input type="submit" class="button_busca" name="submit_receber_aplica" value="Lançar" />&nbsp; 
			<input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_add.action='financeiro_royalties.php'" class="button_busca" />
		</center>
		</td>
	</tr>
</table>
</form>
<? #fim da alteração de status
}
	  exit;
?>