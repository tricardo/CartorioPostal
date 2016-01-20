<label>Nome: <span>*</span></label>
<input name="nome" type="text" class="form_estilo" id="nome" value="<?=$c->nome?>" maxlength="100" /><br />

<label>E-mail: <span>*</span></label>
<input name="email" type="text" class="form_estilo" id="email" value="<?=$c->email?>" maxlength="50" /><br />

<label>RG: <span>*</span></label>
<input name="rg" type="text" class="form_estilo" id="rg" style="width:192px" value="<?=$c->rg?>" maxlength="13" />

<label>CPF: <span>*</span></label>
<select name="orgao_emissor" class="form_estilo" id="orgao_emissor" style="width:50px;">
	<option value="0">--</option>
	<option value="1" <?=($c->orgao_emissor==1)?'selected':'';?>>SSP-AC</option>
	<option value="2" <?=($c->orgao_emissor==2)?'selected':'';?>>SSP-AL</option>
	<option value="3" <?=($c->orgao_emissor==3)?'selected':'';?>>SSP-AM</option>
	<option value="4" <?=($c->orgao_emissor==4)?'selected':'';?>>SSP-AP</option>
	<option value="5" <?=($c->orgao_emissor==5)?'selected':'';?>>SSP-BA</option>
	<option value="6" <?=($c->orgao_emissor==6)?'selected':'';?>>SSP-CE</option>
	<option value="7" <?=($c->orgao_emissor==7)?'selected':'';?>>SSP-DF</option>
	<option value="8" <?=($c->orgao_emissor==8)?'selected':'';?>>SSP-ES</option>
	<option value="9" <?=($c->orgao_emissor==9)?'selected':'';?>>SSP-GO</option>
	<option value="10" <?=($c->orgao_emissor==10)?'selected':'';?>>SSP-MA</option>
	<option value="11" <?=($c->orgao_emissor==11)?'selected':'';?>>SSP-MG</option>
	<option value="12" <?=($c->orgao_emissor==12)?'selected':'';?>>SSP-MS</option>
	<option value="13" <?=($c->orgao_emissor==13)?'selected':'';?>>SSP-MT</option>
	<option value="14" <?=($c->orgao_emissor==14)?'selected':'';?>>SSP-PA</option>
	<option value="15" <?=($c->orgao_emissor==15)?'selected':'';?>>SSP-PB</option>
	<option value="16" <?=($c->orgao_emissor==16)?'selected':'';?>>SSP-PE</option>
	<option value="17" <?=($c->orgao_emissor==17)?'selected':'';?>>SSP-PI</option>
	<option value="18" <?=($c->orgao_emissor==18)?'selected':'';?>>SSP-PR</option>
	<option value="19" <?=($c->orgao_emissor==19)?'selected':'';?>>SSP-RJ</option>
	<option value="20" <?=($c->orgao_emissor==20)?'selected':'';?>>SSP-RN</option>
	<option value="21" <?=($c->orgao_emissor==21)?'selected':'';?>>SSP-RO</option>
	<option value="22" <?=($c->orgao_emissor==22)?'selected':'';?>>SSP-RR</option>
	<option value="23" <?=($c->orgao_emissor==23)?'selected':'';?>>SSP-RS</option>
	<option value="24" <?=($c->orgao_emissor==24)?'selected':'';?>>SSP-SC</option>
	<option value="25" <?=($c->orgao_emissor==25)?'selected':'';?>>SSP-SE</option>
	<option value="26" <?=($c->orgao_emissor==26)?'selected':'';?>>SSP-SP</option>
	<option value="27" <?=($c->orgao_emissor==27)?'selected':'';?>>SSP-TO</option>
</select>
<input name="cpf" type="text" class="form_estilo" id="cpf" style="width:138px;" value="<?=$c->cpf?>" maxlength="15" /><br />

<label>Data de Nascimento: <span>*</span></label>
<input name="nascimento" type="text" class="form_estilo" id="nascimento" style="width:192px" value="<?=$c->nascimento?>" maxlength="10" /><br />

<label>Residencial: <span>*</span></label>
<input name="tel_res" type="text" class="form_estilo" id="tel_res" style="width:192px" value="<?=$c->tel_res?>" maxlength="25" />

<label>Recado:</label>
<input name="tel_rec" type="text" class="form_estilo" id="tel_rec" style="width:191px" value="<?=$c->tel_rec?>" maxlength="25" /><br />

<label>Celular:</label>
<input name="tel_cel" type="text" class="form_estilo" id="tel_cel" style="width:192px" value="<?=$c->tel_cel?>" maxlength="25" /><br />
					
<label>Nacionalidade: <span>*</span></label>
<input name="nacionalidade" type="text" class="form_estilo" id="nacionalidade" style="width:192px" value="<?=$c->nacionalidade?>" maxlength="50" />

<label>Local de Nascimento:</label>
<input name="local_nascimento" type="text" class="form_estilo" id="local_nascimento" style="width:191px" value="<?=$c->local_nascimento?>" maxlength="50" /><br />

<label>Estado Civil: <span>*</span></label>
<select name="estado_civil" class="form_estilo" id="estado_civil" style="width:544px">
	<option value="">--</option>
	<option value="Casado(a)" <?=($c->estado_civil=='Casado(a)')?'selected':'';?>>Casado(a)</option>
	<option value="Solteiro(a)" <?=($c->estado_civil=='Solteiro(a)')?'selected':'';?>>Solteiro(a)</option>
	<option value="Viuvo(a)" <?=($c->estado_civil=='Viuvo(a)')?'selected':'';?>>Viuvo(a)</option>
	<option value="Separado(a)" <?=($c->estado_civil=='Separado(a)')?'selected':'';?>>Separado(a)</option>
	<option value="Divorciado(a)" <?=($c->estado_civil=='Divorciado(a)')?'selected':'';?>>Divorciado(a)</option>
	<option value="Amasiado(a)" <?=($c->estado_civil=='Amasiado(a)')?'selected':'';?>>Amasiado(a)</option>
</select><br />

<label>Possui Filhos?</label>
<select name="filhos" class="form_estilo" id="filhos" style="width:192px">
	<?$c->filhos = ($c->filhos == 'Sim') ? 1 : 0;?>
	<option value="0" <?=($c->filhos==0)?'selected':'';?>>Não</option>
	<option value="1" <?=($c->filhos==1)?'selected':'';?>>Sim</option>
</select>

<label>Quantos?</label>
<input name="filhos_quant" type="text" class="form_estilo" id="filhos_quant" style="width:191px" value="<?=$c->filhos_quant?>" maxlength="10" /><br />

<label>Regime de Casamento:</label>
<input name="regime" type="text" class="form_estilo" id="regime" style="width:190px" value="<?=$c->regime?>" maxlength="120" />

<label>Data do Casamento:</label>
<input name="data_casamento" type="text" class="form_estilo" id="data_casamento" style="width:191px" value="<?=$c->data_casamento?>" maxlength="10" /><br />

<label>Nome do Pai:</label>
<input name="nome_pai" type="text" class="form_estilo" id="nome_pai" style="width:190px" value="<?=$c->nome_pai?>" maxlength="120" />

<label>Nome da Mãe:</label>
<input name="nome_mae" type="text" class="form_estilo" id="nome_mae" style="width:191px" value="<?=$c->nome_mae?>" maxlength="120" /><br />

<label>Nome do Sócio:</label>
<input name="nome_socio" type="text" class="form_estilo" id="nome_socio" style="width:190px" value="<?=$c->nome_socio?>" maxlength="120" />

<label>Profissão: <span>*</span></label>
<input name="profissao" type="text" class="form_estilo" id="profissao" style="width:191px" value="<?=$c->profissao?>" maxlength="120" />