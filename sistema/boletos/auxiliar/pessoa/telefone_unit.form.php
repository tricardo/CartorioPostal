<div id="tel<?=$n?>">
	<input type="hidden" name="idTelefone[]" value="<?=$telefone->id ?>" id="id<?=$n?>"/>
	(<input type="text" name="ddd[]" size="1" value="<?=$telefone->ddd ?>" onkeyup="numeroMasc(this)" maxlength="2"/>)
	<input type="text" name="telNumero[]" size="15" value="<?=$telefone->getFormatNumero() ?>" onkeyup="telefoneMasc(this)" maxlength="9"/> 
	<input type="text" name="ramal[]" size="5" value="<?=$telefone->ramal ?>"/>
	<select name="idTipoTelefone[]">
		<option></option> 
		<? foreach($tiposTelefone as $tipo){ ?>
			<option value="<?=$tipo->id ?>" <?=($telefone->idTipoTelefone==$tipo->id)? 'selected="selected"':''?>> 
				<?=$tipo->descricao ?>
			</option>
		<? } ?>
	</select>
	<input type="text" name="obs[]" size="40" value="<?=$telefone->obs ?>"/>
	<a href="#" class="rem removeTel">x</a>
</div>