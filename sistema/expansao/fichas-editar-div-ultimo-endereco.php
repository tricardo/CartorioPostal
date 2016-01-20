
<label>Endereço: <span>*</span></label>
<input name="anterior_endereco" type="text" class="form_estilo" id="anterior_endereco" style="width:420px" value="<?=$c->anterior_endereco?>" maxlength="100" />

<label style="width:40px">Nº.: <span>*</span></label>
<input name="anterior_numero" type="text" class="form_estilo" id="anterior_numero" style="width:70px" value="<?=$c->anterior_numero?>" maxlength="10" /><br />

<label>Complemento:</label>
<input name="anterior_complemento" type="text" class="form_estilo" id="anterior_complemento" style="width:190px" value="<?=$c->anterior_complemento?>" maxlength="40" />

<label>Bairro: <span>*</span></label>
<input name="anterior_bairro" type="text" class="form_estilo" id="anterior_bairro" style="width:190px" value="<?=$c->anterior_bairro?>" maxlength="50" /><br />

<label>CEP: <span>*</span></label>
<input name="anterior_cep" type="text" class="form_estilo" id="anterior_cep" style="width:190px" value="<?=$c->anterior_cep?>" maxlength="9" />

<label>UF: <span>*</span></label>
<select style="width:190px" class="form_estilo" id="anterior_estado" name="anterior_estado">
	<? $dt = $expansao->estado(); $cont = 0;
	foreach($dt as $b => $res){ 
		echo (count($dt) > 1 && $cont == 0) ? '<option value="">--</option>' . "\n" : ''; $cont++;
		echo "\t\t\t\t\t".'<option value="'.$res->estado.'"'.(($c->anterior_estado == $res->estado) ? 
			' selected="selected"' : '').'>'.$res->estado.'</option>' . "\n";
	} ?>
</select><br />

<label>Cidade: <span>*</span></label>
<input name="anterior_cidade" type="text" class="form_estilo" id="anterior_cidade" style="width:539px" value="<?=$c->anterior_cidade?>" maxlength="100" />

