			<div id="dados_administrativos" class="div_titulo">&nbsp;- Dados Administrativos</div>
			<div class="div_form">
				<div id="informativo">
					<p>&nbsp;- Informativo</p>
					<label style="margin-left:10px;"><strong>Tipo da Franquia: <span>*</span></strong></label>
					<label style="margin-left:91px;"><strong>N.º COF:</strong></label>
					<label style="margin-left:123px;"><strong>Valor da COF:</strong></label>
					<label style="margin-left:82px;"><strong>Forma de Pagto.: <span>*</span></strong></label><br />
					<select name="tipo_franquia" class="form_estilo" id="tipo_franquia" style="margin-left:10px; width:200px;">
						<option value="0" <?echo($c->tipo_franquia==0)?'selected':'';?>></option>
						<option value="1" <?echo($c->tipo_franquia==1)?'selected':'';?>>Master</option>
						<option value="2" <?echo($c->tipo_franquia==2)?'selected':'';?>>Unitária</option>
						<option value="3" <?echo($c->tipo_franquia==3)?'selected':'';?>>Internacional</option>
					</select>
					<input name="num_cof" value="<?=$c->num_cof?>" type="text" class="form_estilo" id="num_cof" style="width:150px; margin-left:10px;" maxlength="14" />
					<input name="valor_cof" value="<?=$c->valor_cof?>" type="text" class="form_estilo" id="valor_cof" style="width:150px; margin-left:14px;" maxlength="14" />
					<input name="forma_pagto" value="<?=$c->forma_pagto?>" type="text" class="form_estilo" id="forma_pagto" style="width:175px; margin-left:14px;" maxlength="30" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Origem:</strong></label>
					<label style="margin-left:157px;"><strong>N.º COF Emitido:</strong></label>
					<label style="margin-left:73px;"><strong>Valor Efetivo da Franquia: <span>*</span></strong></label><br />
					<select name="origem" class="form_estilo" id="origem" style="width:200px; margin-left:10px;">
						<option value="0" <?=($c->origem==0)?'selected':'';?>></option>
						<option value="1" <?=($c->origem==1)?'selected':'';?>>ABF</option>
						<option value="2" <?=($c->origem==2)?'selected':'';?>>E-mail</option>
						<option value="3" <?=($c->origem==3)?'selected':'';?>>Site</option>
					</select>
					<input id="cof_emitido1" style="margin-left:10px;" name="num_cof_emitida" type="radio" value="1" <?=($c->num_cof_emitida==1)?'checked':'';?> />
					<label for="cof_emitido1" style="width:80px;">Sim</label>
					<input id="cof_emitido2" name="num_cof_emitida" type="radio" value="0" <?=($c->num_cof_emitida==0)?'checked':'';?> /> 
					<label for="cof_emitido2" style="width:71px;">Não</label>
					<input name="valor_efetivo" value="<?=$c->valor_efetivo?>" type="text" class="form_estilo" id="valor_efetivo" style="width:150px; margin-left:-34px;" maxlength="14" />
			
					<label style="width:758px;">&nbsp;</label>
					<label style="width:758px; font-weight:bold; margin-left:10px;">Anexar Arquivos</label>
					<?for($i=1;$i<=5;$i++){?>
						<input style="margin-left:10px;" size="116" class="form_estilo" type="file" name="arquivo[]" />
					<?}?>
					<label style="width:758px;">&nbsp;</label>
				</div>
				<div id="anexos"></div>	
				
			</div>