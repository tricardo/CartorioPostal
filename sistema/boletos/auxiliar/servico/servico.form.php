<fieldset>
	<legend>Cadastro de Servi&ccedil;o</legend>
	<script src="<?php echo $urlBase ?>/especjs/servico.form"></script>
	<form action="<?php echo $submit ?>" method="post">
		
		<input type="hidden" name="id_servico" value="<?php echo $servico->id_servico?>"/>
		
		<label>descri&ccedil;&atilde;o:</label>
		<input name="descricao" type="text" value="<?php echo $servico->descricao;?>" style="width:500px"/><br/>
		
		<label>departamento:</label>
		<select name="id_departamento" <?php if($servico->id_departamento!=''){ ?> disabled="disabled"<?php } ?>>
			<?php foreach($departamentos as $dep){ ?>
				<option value="<?php echo $dep->id_servico_departamento?>" 
				<?php if($dep->id_servico_departamento==$servico->id_departamento) echo 'selected="selected"'?>>
				<?php echo $dep->departamento ?>
				</option>
			<?php } ?>
		</select><br/>
		
		<label>status:</label>
		<select name="status">
			<option <?php if($servico->status=="Ativo") echo 'selected="selected"';?>>Ativo</option>
			<option <?php if($servico->status=="Inativo") echo 'selected="selected"';?>>Inativo</option>
		</select><br/>
		
		<label>site:</label>
		<input name="site" type="checkbox" value="1" <?php if($servico->site) echo 'checked="checked"'?>/><br/>
		
		<label>menu do site:</label>
		<input name="site_menu" type="checkbox" value="1" <?php if($servico->site_menu) echo 'checked="checked"'?>/><br/>

		<label>nome do servico para o site:</label>
		<input name="desc_site" type="text" value="<?= $servico->desc_site ?>" style="width:500px"/><br/>

		<label>descriçao do serviço para o site:</label>
		<textarea name="servico_desc" style="width:500px; height:150px"><?= $servico->servico_desc ?></textarea><br>

		<input name="remCampos" id="remCampos" type="hidden"/>
		<a href="#" class="add" id="addCampo">adicionar</a>campo
		<br/>
		
		<ul id="campos" class="sortable">
			<?php foreach($servico->campos as $n=>$campo){ ?>
			<?php require('campo.form.php');?>
			<?php } ?>
		</ul>
		
		<input type="submit" value="gravar"/>
		<input type="button" value="cancelar" class="cancelar"/>
	</form>
</fieldset>