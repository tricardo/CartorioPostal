				<div>
					<p>&nbsp;- EXPERI�NCIA COM FRANQUIAS</p>
					<label style="margin-left:10px;"><strong>Deseja ser Franqueado, S�cio e/ou Fiador?</strong></label>
					<label style="margin-left:80px;"><strong>Tem Experi�ncia com Franquias?</strong></label><br />
					<input name="franqueado" type="text" class="form_estilo" id="franqueado" style="width:358px; margin-left:10px;" value="<?=$c->franqueado?>" maxlength="80" />
					<input style="margin-left:15px;" value="1" id="experiencia1" name="experiencia" type="radio" <?=($c->experiencia==1)?'checked="checked"':'';?> />
                    <label style="margin-left:20px;" for="experiencia1">Sim</label>
                    <input style="margin-left:20px;" value="2" id="experiencia2" name="experiencia" type="radio" <?=($c->experiencia==2)?'checked="checked"':'';?> />
                    <label style="margin-left:20px;" for="experiencia2">N�o</label>
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Se N�o, Qual o Motivo de N�o Possuir o Neg�cio?<br />&nbsp;</strong></label>
					<label style="margin-left:55px;"><strong>Se Sim, Responda as Perguntas Abaixo:<br />
					N�mero de Funcion�rios:</strong></label><br />
					<input name="motivo" type="text" class="form_estilo" id="motivo" style="width:358px; margin-left:10px;" value="<?=$c->motivo?>" maxlength="50" />
					<input name="funcionarios2" type="text" class="form_estilo" id="funcionarios2" style="width:358px; margin-left:9px;" value="<?=$c->funcionarios2?>" maxlength="50" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Faturamento:</strong></label>
					<label style="margin-left:285px;"><strong>Qual Franquia?</strong></label><br />
					<input name="faturamento2" type="text" class="form_estilo" id="faturamento2" style="width:358px; margin-left:10px;" value="<?=$c->faturamento2?>" maxlength="50" />
					<input name="qual_franquia" type="text" class="form_estilo" id="qual_franquia" style="width:358px; margin-left:9px;" value="<?=$c->qual_franquia?>" maxlength="50" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px; width:748px;"><strong>Na sua Opini�o Quais os Fatores Determinantes para o Sucesso de um Neg�cio?:</strong></label><br />
					<input name="opiniao" type="text" class="form_estilo" id="opiniao" style="width:731px; margin-left:10px;" value="<?=$c->opiniao?>" maxlength="50" />
				</div>