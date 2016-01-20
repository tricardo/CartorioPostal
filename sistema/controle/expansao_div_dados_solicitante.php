				<div>
					<p>&nbsp;- DADOS PESSOAIS</p>
					<label style="margin-left:10px;"><strong>Nome: <span>*</span></strong></label>
					<label style="margin-left:328px;"><strong>RG: <span>*</span></strong></label>
					<label style="margin-left:186px;"><strong>CPF: <span>*</span></strong></label><br />
					<input name="nome" type="text" class="form_estilo" id="nome" style="width:358px; margin-left:10px;" value="<?=$c->nome?>" maxlength="100" />
					<input name="rg" type="text" class="form_estilo" id="rg" style="width:134px; margin-left:9px;" value="<?=$c->rg?>" maxlength="13" />
					<select name="orgao_emissor" class="form_estilo" id="orgao_emissor" style="width:70px; margin-left:-4px;">
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
					<input name="cpf" type="text" class="form_estilo" id="cpf" style="width:136px; margin-left:10px;" value="<?=$c->cpf?>" maxlength="15" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Data de Nascimento: <span>*</span></strong></label>
					<label style="margin-left:230px;"><strong>E-mail: <span>*</span></strong></label><br />
					<input name="nascimento" type="text" class="form_estilo" id="nascimento" style="width:358px; margin-left:10px;" value="<?=$c->nascimento?>" maxlength="10" />
					<input name="email" type="text" class="form_estilo" id="email" style="width:358px; margin-left:9px;" value="<?=$c->email?>" maxlength="50" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Residencial: <span>*</span></strong></label>
					<label style="margin-left:164px;"><strong>Recado:</strong></label>
					<label style="margin-left:190px;"><strong>Celular:</strong></label><br />
					<input name="tel_res" type="text" class="form_estilo" id="tel_res" style="width:232px; margin-left:10px;" value="<?=$c->tel_res?>" maxlength="25" />
					<input name="tel_rec" type="text" class="form_estilo" id="tel_rec" style="width:232px; margin-left:11px;" value="<?=$c->tel_rec?>" maxlength="25" />
					<input name="tel_cel" type="text" class="form_estilo" id="tel_cel" style="width:232px; margin-left:11px;" value="<?=$c->tel_cel?>" maxlength="25" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Nacionalidade: <span>*</span></strong></label>
					<label style="margin-left:267px;"><strong>Local de Nascimento:</strong></label><br />
					<input name="nacionalidade" type="text" class="form_estilo" id="nacionalidade" style="width:358px; margin-left:10px;" value="<?=$c->nacionalidade?>" maxlength="50" />
					<input name="local_nascimento" type="text" class="form_estilo" id="local_nascimento" style="width:358px; margin-left:9px;" value="<?=$c->local_nascimento?>" maxlength="50" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Estado Civil: <span>*</span></strong></label>
					<label style="margin-left:313px;"><strong>Possui Filhos?</strong></label>
					<label style="margin-left:98px;"><strong>Quantos?</strong></label><br />
					<select name="estado_civil" class="form_estilo" id="estado_civil" style="width:404px; margin-left:10px;">
						<option value="">.:SELECIONE:.</option>
						<option value="Casado(a)" <?=($c->estado_civil=='Casado(a)')?'selected':'';?>>Casado(a)</option>
						<option value="Solteiro(a)" <?=($c->estado_civil=='Solteiro(a)')?'selected':'';?>>Solteiro(a)</option>
						<option value="Viuvo(a)" <?=($c->estado_civil=='Viuvo(a)')?'selected':'';?>>Viuvo(a)</option>
						<option value="Separado(a)" <?=($c->estado_civil=='Separado(a)')?'selected':'';?>>Separado(a)</option>
						<option value="Divorciado(a)" <?=($c->estado_civil=='Divorciado(a)')?'selected':'';?>>Divorciado(a)</option>
						<option value="Amasiado(a)" <?=($c->estado_civil=='Amasiado(a)')?'selected':'';?>>Amasiado(a)</option>
					</select>
					<input style="margin-left:15px;" id="filhos1" name="filhos" type="radio" value="Sim" <?=($c->filhos=='Sim')?'checked':'';?> />
					<label style="margin-left:10px;" for="filhos1">Sim</label>
					<input style="margin-left:25px;"  id="filhos2" name="filhos" type="radio" value="Não" <?=($c->filhos=='Não')?'checked':''; ?> />
					<label style="margin-left:10px;" for="filhos2">Não</label>
					<input name="filhos_quant" type="text" class="form_estilo" id="filhos_quant" style="width:120px; margin-left:46px;" value="<?=$c->filhos_quant?>" maxlength="10" />
			
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Regime de Casamento:</strong></label>
					<label style="margin-left:230px;"><strong>Data do Casamento:</strong></label><br />
					<input name="regime" type="text" class="form_estilo" id="regime" style="width:358px; margin-left:10px;" value="<?=$c->regime?>" maxlength="120" />
					<input name="data_casamento" type="text" class="form_estilo" id="data_casamento" style="width:358px; margin-left:9px;" value="<?=$c->data_casamento?>" maxlength="10" />

					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Nome do Pai:</strong></label>
					<label style="margin-left:290px;"><strong>Nome da Mãe:</strong></label><br />
					<input name="nome_pai" type="text" class="form_estilo" id="nome_pai" style="width:358px; margin-left:10px;" value="<?=$c->nome_pai?>" maxlength="120" />
					<input name="nome_mae" type="text" class="form_estilo" id="nome_mae" style="width:358px; margin-left:9px;" value="<?=$c->nome_mae?>" maxlength="120" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Nome do Sócio:</strong></label>
					<label style="margin-left:272px;"><strong>Profissão: <span>*</span></strong></label><br />
					<input name="nome_socio" type="text" class="form_estilo" id="nome_socio" style="width:358px; margin-left:10px;" value="<?=$c->nome_socio?>" maxlength="120" />
					<input name="profissao" type="text" class="form_estilo" id="profissao" style="width:358px; margin-left:9px;" value="<?=$c->profissao?>" maxlength="120" />
				</div>