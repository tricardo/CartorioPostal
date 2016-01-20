<?php
$empresaDAO = new EmpresaDAO();
$empresas = $empresaDAO->listarTodas();
if(count($errors)>0){?>
<div class="erro">
	<?php echo $error; ?>
</div>
<?php
}
?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">
		<blockquote>
		<form enctype="multipart/form-data" action="" method="post" name="fornecedor_form">
		<input type="hidden" name="id_chamado" value="<?php echo $c->id_chamado?>"/>
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados do Chamado
				<?
				if($id<>''){
					echo 'Cadastro: '.invert($c->data_cadastro,'/','PHP').' Atualização: '.invert($c->data_atualizacao,'/','PHP');
				}
				?>
				</td>
			</tr>
			 <?if($c->status=="1"){?>
			<tr>
				<td colspan="4" style="height:25px; text-align:center; color:#FF0000;">
					Esta tarefa já foi concluída e este formulário bloqueado para alterações. 
					<a href="javascript:window.history.go(-1)" style="color:#FF0000;">Voltar.</a>
				</td>
			</tr>
			<?}?>
			<tr>
				<td width="100">
				<div align="right"><strong>Pergunta:</strong></div>
				</td>
				<td colspan="3">
					<input <?=($c->status=="1")?'disabled="disabled"':'';?> type="text" name="pergunta" value="<?=$c->pergunta ?>" style="width:514px"
					 class="form_estilo <?=(isset($errors['pergunta']))?'form_estilo_erro':''; ?>" />
					 <font color="#FF0000">*</font>
				</td>
			</tr>
			<tr>
			  <td align="right"><strong>Forma Atend.:</strong></td>
			  <td colspan="3">
              	<select <?=($c->status=="1")?'disabled="disabled"':'';?> name="forma_atend" style="width: 150px" class="form_estilo  <?=(isset($errors['id_empresa']))?'form_estilo_erro':''; ?>">
                	<option value="0">--</option>
                    <option value="1" <?=($c->forma_atend=="1")?'selected="selected"':'';?>>Telefone</option>
                    <option value="2" <?=($c->forma_atend=="2")?'selected="selected"':'';?>>E-mail</option>
                    <option value="3" <?=($c->forma_atend=="3")?'selected="selected"':'';?>>Skype</option>
                    </select></td>
		    </tr>
			<tr>
				<td align="right"><strong>Franquia:</strong></td>
				<td>
					<select <?=($c->status=="1")?'disabled="disabled"':'';?> name="id_empresa" style="width: 150px" class="form_estilo  <?=(isset($errors['id_empresa']))?'form_estilo_erro':''; ?>">
					<?php foreach($empresas as $e){ ?>
						<option value="<?=$e->id_empresa;?>"
						<?=($c->id_empresa == $e->id_empresa)?'selected="selected"':''?>><?=$e->fantasia; ?></option>
					<?php }?>
					</select><font color="#FF0000">*</font>
				</td>
				<td align="right"><strong>Status:</strong></td>
				<td>
					<select <?=($c->status=="1")?'disabled="disabled"':'';?> name="status" style="width: 150px" class="form_estilo">
						<option <?=($c->status=="0" or $c->status=="")?'selected="selected"':'';?> value="0">Pendente</option>
						<option <?=($c->status=="1")?'selected="selected"':'';?> value="1">Resolvido</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">
				<strong>Pedido:</strong>
				</td>
				<td><input <?=($c->status=="1")?'disabled="disabled"':'';?> type="text" name="id_pedido" value="<?=$c->id_pedido?>" style="width: 150px"
					class="form_estilo  <?=(isset($errors['id_pedido']))?'form_estilo_erro':''; ?>"
					onKeyUp="masc_numeros(this,'#########');" /></td>
				<td align="right"><strong>Ordem:</strong></td>
				<td>
					<input <?=($c->status=="1")?'disabled="disabled"':'';?> type="text" name="ordem" style="width: 150px" value="<?=$c->ordem ?>"
					class="form_estilo <?=(isset($errors['ordem']))?'form_estilo_erro':''; ?>"
					onKeyUp="masc_numeros(this,'########');" />
				</td>
			</tr>
			<?if($id<>''){?>
			<tr>
				<td align="right"><strong>Abertura:</strong></td>
				<td><?
						$dt = explode(' ',$c->data_cadastro);
						$dt1 = explode('-',$dt[0]);
					?><input <?=($c->status=="1")?'disabled="disabled"':'';?> type="text" name="ab_data" id="ab_data" maxlength="10" value="<?=$dt1[2].'/'.$dt1[1].'/'.$dt1[0]?>"
					class="form_estilo <?=(isset($errors['ordem']))?'form_estilo_erro':''; ?>" /> (xx/xx/xxxx)<br />
					<input <?=($c->status=="1")?'disabled="disabled"':'';?> type="text" name="ab_hora" id="ab_hora" maxlength="5" value="<?=substr($dt[1], 0, 5)?>" 
					class="form_estilo <?=(isset($errors['ordem']))?'form_estilo_erro':''; ?>" /> (xx:xx)
				</td>
				<td align="right"><strong>Fechamento:</strong></td>
				<td><? if($c->data_atualizacao != '0000-00-00 00:00:00'){
						$dt = explode(' ',$c->data_atualizacao);
						$dt1 = explode('-',$dt[0]);
						$data_atualizacao = $dt1[2].'/'.$dt1[1].'/'.$dt1[0];
						$hora_atualizacao = substr($dt[1], 0, 5);
					} ?><input <?=($c->status=="1")?'disabled="disabled"':'';?> type="text" name="fc_data" id="fc_data" maxlength="10" value="<?=$data_atualizacao?>" 
					class="form_estilo <?=(isset($errors['ordem']))?'form_estilo_erro':''; ?>" /> (xx/xx/xxxx)<br />
					<input <?=($c->status=="1")?'disabled="disabled"':'';?> type="text" name="fc_hora" id="fc_hora" maxlength="5" value="<?=$hora_atualizacao?>" 
					class="form_estilo <?=(isset($errors['ordem']))?'form_estilo_erro':''; ?>" /> (xx:xx)
					<script>jQuery.noConflict();
						jQuery(function($){  
							$("#ab_data").mask("99/99/9999");
							$("#fc_data").mask("99/99/9999");
							$("#ab_hora").mask("99:99");
							$("#fc_hora").mask("99:99");
						});
					</script>
				</td>
			</tr>
			<?}?>
			<tr>
				<td width="100" align="right" valign="top">
				<strong>Resposta:</strong>
				</td>
				<td colspan="3">
					<?if($c->status=="1"){
						$c->resposta = explode("Content-Transfer-Encoding: base64 Content-ID:", $c->resposta);
							$c->resposta = $c->resposta[0];
							$c->resposta = str_replace("\n","",$c->resposta);
							$c->resposta = str_replace("\t","",$c->resposta);
							echo '<br /><br />'.$c->resposta;
					}else{
						if($c->forma_atend == 2){
							$c->resposta = explode("Content-Transfer-Encoding: base64 Content-ID:", $c->resposta);
							$c->resposta = $c->resposta[0];
							$c->resposta = str_replace("\n","",$c->resposta);
							$c->resposta = str_replace("\t","",$c->resposta);
							echo '<br /><br />'.$c->resposta;
						} else {
						$c->resposta = str_replace('<br />',"\n",$c->resposta);
						$c->resposta = str_replace('<b>',"",$c->resposta);
						$c->resposta = str_replace('</b>',"",$c->resposta);
						?>
					<textarea <?=($c->status=="1")?'disabled="disabled"':'';?> name="resposta" style="width: 493px; height: 100px;" class="form_estilo <?=(isset($errors['resposta']))?'form_estilo_erro':''; ?>" rows="5"><?=$c->resposta ?></textarea>
					<? }} ?>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center">
					<input <?=($c->status=="1")?'disabled="disabled"':'';?> type="submit" name="submit" value="Enviar" class="button_busca" />&nbsp;
					<input <?=($c->status=="1")?'disabled="disabled"':'';?> type="submit" name="cancelar" value="Cancelar" onclick="document.fornecedor_form.action='chamado.php'" class="button_busca" /></td>
			</tr>
		</table>
				<div id="resgata_endereco"></div>
		</form>

		</blockquote>
		</td>
	</tr>
</table>
