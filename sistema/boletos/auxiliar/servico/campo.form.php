<li>
	<?php /** <a href="<?php echo $campo->id_servico_campo?>" class="rem remCampo" style="float:left">remover campo</a> **/ ?>
	<input type="hidden" name="id_servico_campo[<?php echo $n?>]" value="<?php echo $campo->id_servico_campo?>"/>
	campo:
	<?php if($campo->id_servico_campo!=''){ ?>
		<input type="text" name="campo_campo[<?php echo $n?>]" value="<?php echo $campo->campo ?>" readonly="readonly"/>
	<?php }else{ ?>
	<select name="campo_campo[<?php echo $n?>]">
		<?php foreach($campos as $c){ ?>
			<option <?php if($c->Field==$campo->campo) echo 'selected="selected"'?>>
				<?php echo $c->Field?>
			</option>
		<?php }?>
	</select>
	<?php } ?>
	nome:<input type="text" name="campo_nome[<?php echo $n?>]" value="<?php echo $campo->nome ?>" class="maiusculas"/>
	site:<input name="campo_site[<?php echo $n?>]" type="checkbox" <?php if($campo->site==1) echo 'checked="checked"'?> value="1"/>
	obrigat&oacute;rio:<input name="campo_obrigatorio[<?php echo $n?>]" type="checkbox" <?php if($campo->obrigatorio==1) echo 'checked="checked"'?> value="1"/>
</li>