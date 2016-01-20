<div class="formulario" id="categoriaForm">
	<fieldset>
		<legend>G&ecirc;nero</legend>
	<form method="post" action="<?=$submit ?>">
		<input type="hidden" name="id" value="<?=$categoria->id?>" id="idCategoria"/>
		<? if($categoria->idSupCategoria!=''){?>
		<label for"idSupCategoria">G&ecirc;nero:</label>
		<select name="idSupCategoria" id="idSupCategoria">
			<option value=""> --- </option>
			<?php foreach($categorias as $cat){ ?>
				<option value="<?=$cat->id ?>" <?=($categoria->idSupCategoria==$cat->id)?'selected="selected"':''?>>
					<?=$cat ?>
				</option>
			<?php } ?>
		</select>
		<br/>
		<? } ?>
		<label for="nome">Tipo:</label>
		<input type="text" id="nome" name="nome" value="<?=$categoria->nome ?>"/><br/>
		<input type="submit" value="gravar"/>
	</form>
	
	</fieldset>
</div>
