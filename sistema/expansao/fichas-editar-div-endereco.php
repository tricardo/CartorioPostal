<label>Endereço: <span>*</span></label>
<input name="endereco" type="text" class="form_estilo" id="endereco" style="width:420px" value="<?=$c->endereco?>" maxlength="100" />

<label style="width:40px">Nº.: <span>*</span></label>
<input name="numero" type="text" class="form_estilo" id="numero" style="width:70px" value="<?=$c->numero?>" maxlength="10" /><br />

<label>Complemento:</label>
<input name="complemento" type="text" class="form_estilo" id="complemento" style="width:190px;;" value="<?=$c->complemento?>" maxlength="40" />

<label>Bairro: <span>*</span></label>
<input name="bairro" type="text" class="form_estilo" id="bairro" style="width:190px;" value="<?=$c->bairro?>" maxlength="50" /><br />

<label>CEP: <span>*</span></label>
<input name="cep" type="text" class="form_estilo" id="cep" style="width:190px" value="<?=$c->cep?>" maxlength="9" />

<label>UF: <span>*</span></label>
<select style="width:192px;" class="form_estilo" id="estado" name="estado">
	<? $dt = $expansao->estado(); $cont = 0;
	foreach($dt as $b => $res){ 
		echo (count($dt) > 1 && $cont == 0) ? '<option value="">--</option>' . "\n" : ''; $cont++;
		echo "\t\t\t\t\t".'<option value="'.$res->estado.'"'.(($c->estado == $res->estado) ? 
			' selected="selected"' : '').'>'.$res->estado.'</option>' . "\n";
	} ?>
</select><br />

<label>Cidade: <span>*</span></label>
<input name="cidade" type="text" class="form_estilo" id="cidade" style="width:539px" value="<?=$c->cidade?>" maxlength="120" /><br />


<label>Tipo do Imóvel:</label>
<select style="width:192px;" class="form_estilo" name="tip_imovel" id="tip_imovel">
	<option value="0">--</option>
	<option value="1" <? if($c->tip_imovel == 1){ ?> selected="selected" <? } ?>>Própria</option>
	<option value="2" <? if($c->tip_imovel == 2){ ?> selected="selected" <? } ?>>Alugada</option>
	<option value="3" <? if($c->tip_imovel == 3){ ?> selected="selected" <? } ?>>Familiares</option>
</select>

<label>Reside na Praça Desde:</label>
<input name="reside_praca" type="text" class="form_estilo" id="reside_praca" style="width:190px" value="<?=$c->reside_praca?>" maxlength="25" />