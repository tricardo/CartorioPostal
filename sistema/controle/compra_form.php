<?php if(count($errors)>0){?>
<div class="erro"><?php echo $error; ?></div>
<?php }
$departamentos_s = explode(',',$controle_id_departamento_s);
$departamentoDAO = new DepartamentoDAO();
if($perm_comp=='TRUE')
	$departamentos_s = $departamentoDAO->listar();
else
	$departamentos_s = $departamentoDAO->listar($departamentos_s);

switch($c->status){
	case 'Em Aberto':$prox_status = 'Iniciar Cotação';
		break;
	case 'Iniciar Cotação':$prox_status = '';
		break;
	case 'Concluída':$prox_status = '';
		break;
}
?>
		<form enctype="multipart/form-data" action="" method="post" name="compra_form">
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados da Compra</td>
			</tr>
			<tr>
				<td align="right"><strong>Solicitante:</strong></td>
				<td><input type="text" class="form_estilo" value="<?php echo $c->solicitante; ?>" readonly="readonly" name="solicitante" style="width:470px"/></td>
			</tr>
			
			<tr>
				<td align="right"><strong>Status:</strong></td>
				<td><input type="text" class="form_estilo" value="<?php echo $c->status; ?>" readonly="readonly" name="status"/></td>
			</tr>
			
			
			<tr>
				<td width="100">
				<div align="right"><strong>Departamento:</strong></div>
				</td>
				<td><select name="id_departamento" class="form_estilo" style="width:470px">
				<?php foreach($departamentos_s as $dep){?>
					<option value="<?php echo $dep->id_departamento?>"
					<?php if($dep->id_departamento==$c->id_departamento)echo 'selected="selected"'?>>
						<?php echo $dep->departamento ?></option>
						<?php } ?>
				</select></td>
			</tr>
			<tr>
				<td width="100">
				<div align="right"><strong>Produto:</strong></div>
				</td>
				<td><input type="text" name="produto" value="<?=$c->produto ?>"
					class="form_estilo  <?=(isset($errors['produto']))?'form_estilo_erro':''; ?>"  style="width:470px" /><font color="#F00">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Descrição: </strong></div>
				</td>
				<td>
					<textarea name="descricao" rows="4" style="height:50px; width:470px" class="form_estilo <?=(isset($errors['descricao']))?'form_estilo_erro':''; ?>"><?=$c->descricao ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Quantidade:</strong></div>
				</td>
				<td><input type="text" name="quantidade"
					value="<?=$c->quantidade ?>"
					class="form_estilo  <?=(isset($errors['quantidade']))?'form_estilo_erro':''; ?>"
					onKeyUp="masc_numeros(this,'#################');" /><font color="#F00">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Motivo:</strong></div>
				</td>
				<td><input type="text" name="motivo" value="<?=$c->motivo ?>" class="form_estilo"  style="width:470px"/></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Observação:</strong></div>
				</td>
				<td>
					<textarea name="observacao" rows="4" style="height:50px; width:470px" class="form_estilo <?=(isset($errors['observacao']))?'form_estilo_erro':''; ?>"><?=$c->observacao ?></textarea>
				</td>
			</tr>

			<?php if($c->id_compra==''){?>
			<tr>
				<td colspan="4" align="center">
					<input type="submit" name="submit_compra" value="Enviar" class="button_busca" />&nbsp;
					<input type="submit" name="cancelar" value="Voltar" onclick="document.compra_form.action='compra.php'" class="button_busca" />
				</td>
			</tr>
			<?php }else if($permissao_compra){ ?>
			<tr>
				<td colspan="4" align="center">
					<?php if($prox_status!=''){?>
						<input type="submit" name="submit_compra_status" value="<?php echo $prox_status ?>" class="button_busca" />&nbsp;
					<?php }else{ ?>
						<input type="hidden" name="submit_compra_status" value="Reprovada" class="button_busca" />&nbsp;
					<?php } ?>
					<?php if($c->status!='Reprovada' ){?>
						<input type="submit" name="submit_compra_reprovar" value="Reprovar" class="button_busca" 
						onclick="document.compra_form.submit_compra_status.value='Reprovada';"/>&nbsp;
					<?php } ?>
					<input type="submit" name="cancelar" value="Voltar" onclick="document.compra_form.action='compra.php'" class="button_busca" />
				</td>
			</tr>
			<?php } ?>
		</table>
		</form>
