<label>Tipo da Franquia: <span>*</span></label>
<select name="tipo_franquia" class="form_estilo" id="tipo_franquia" style="width:192px;">
	<option value="0" <?echo($c->tipo_franquia==0)?'selected':'';?>></option>
	<option value="1" <?echo($c->tipo_franquia==1)?'selected':'';?>>Master</option>
	<option value="2" <?echo($c->tipo_franquia==2)?'selected':'';?>>Unitária</option>
	<option value="3" <?echo($c->tipo_franquia==3)?'selected':'';?>>Subfranquia</option>
	<option value="4" <?echo($c->tipo_franquia==4)?'selected':'';?>>Internacional</option>
</select>


<label>N.º COF:</label>
<input name="num_cof2" value="<?=$c->num_cof2?>" type="text" class="form_estilo" id="num_cof2" maxlength="14" style="width:190px;" /><br />

<label>Valor da COF:</label>
<input name="valor_cof" value="<?=$c->valor_cof?>" type="text" class="form_estilo" id="valor_cof"  maxlength="14" style="width:190px;" />

<label>Forma de Pagto.: <span>*</span></label>
<input name="forma_pagto" value="<?=$c->forma_pagto?>" type="text" class="form_estilo" id="forma_pagto" maxlength="30" style="width:190px;" /><br />

<label>Origem:</label>
<select name="origem2" class="form_estilo" id="origem2" style="width:192px;">
	<option value="0" <?=($c->origem2==0)?'selected':'';?>></option>
	<option value="1" <?=($c->origem2==1)?'selected':'';?>>ABF</option>
	<option value="2" <?=($c->origem2==2)?'selected':'';?>>E-mail</option>
	<option value="3" <?=($c->origem2==3)?'selected':'';?>>Site</option>
</select>

<label>Valor Efetivo: <span>*</span></label>
<input name="valor_efetivo" value="<?=$c->valor_efetivo?>" type="text" class="form_estilo" id="valor_efetivo" maxlength="14" style="width:190px;" /><br />

<label>Valor do Royaltie: </label>
<input name="valor_royaltie" value="<?=$c->valor_royaltie?>" type="text" class="form_estilo" id="valor_royaltie" maxlength="14" style="width:190px;" /><br />

<label>N.º COF Emitido:</label>
<input style="margin-left:10px;" id="cof_emitido1" name="num_cof_emitida[]" type="radio" value="1" <?=($c->num_cof_emitida==1)?'checked':'';?> />Sim
<input style="margin-left:20px;" id="cof_emitido2" name="num_cof_emitida[]" type="radio" value="0" <?=($c->num_cof_emitida==0)?'checked':'';?> />Não<br />


<label>Tipo do Arquivo:</label>
<select name="tipo_upload" class="form_estilo" id="tipo_upload" style="width:192px;">
	<? $tipo_up = $expansao->tipo_upload(2,0);
	for($i = 0; $i < count($tipo_up[0]); $i++){ ?>
		<option value="<?=$tipo_up[0][$i]?>"><?=$tipo_up[1][$i]?></option>
	<? } ?>				
</select>
<label>Arquivo:</label>
<input type="file" name="arquivo" id="arquivo" />