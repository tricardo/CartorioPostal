	<?php $fornecedorDAO = new FornecedorDAO(); ?>
	<form enctype="multipart/form-data" action="#aba1" method="post" name="compra_proposta_form">
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Nova Proposta</td>
			</tr>
			<tr>
				<td align="right"><strong>Fornecedor:</strong></td>
				<td>
					<select name="id_fornecedor" id="fornecedor" class="form_estilo <?=(isset($errors['id_fornecedor']))?'form_estilo_erro':''; ?>" onchange="carrega_fornecedor_contas(this.value)" style="width:470px">
					<option></option>
					<?php 
					$fornecedores = $fornecedorDAO->lista($controle_id_empresa);
					$p_valor = '';
					foreach($fornecedores as $f){
						$p_valor .= '<option value="'.$f->id_fornecedor.'" ';
						if($p->id_fornecedor==$f->id_fornecedor) $p_valor .= ' selected="selected"';
						$p_valor .= '>'. $f->fantasia .'</option>';
					}
					echo $p_valor;
					?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>
				<div align="right"><strong>Valor:</strong></div>
				</td>
				<td><input type="text" name="valor"
					value="<?=$v->valor ?>"
					class="form_estilo  <?=(isset($errors['valor']))?'form_estilo_erro':''; ?>"/>
					 <font color="#FF0000">*</font></td>
			</tr>
			
			<tr>
				<td>
				<div align="right"><strong>Arquivo:</strong></div>
				</td>
				<td><input type="file" name="arquivo" class="form_estilo"/></td>
			</tr>
			
			<tr>
				<td colspan="4" align="center">
				<?php if($p->id_proposta==''){ ?>
					<input type="submit" name="submit_proposta" value="Inserir" class="button_busca" />&nbsp;
					<input type="submit" name="cancelar" value="Voltar" onclick="document.compra_form.action='compra.php#aba1'" class="button_busca" />
				<?php } ?>
				</td>
			</tr>
		</table>
		</form>