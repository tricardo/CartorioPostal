<label>Deseja ser?</label>
<select name="franqueado" class="form_estilo" id="franqueado" style="width:192px">
	<option value="">--</option>
	<option value="Franqueado" <?=($c->franqueado=='Franqueado')?'selected':'';?>>Franqueado</option>
	<option value="S�cio" <?=($c->franqueado=='S�cio')?'selected':'';?>>S�cio</option>
	<option value="Fiador" <?=($c->franqueado=='Fiador')?'selected':'';?>>Fiador</option>
</select>

<label>Experi�ncia com Franq.?</label>
<select name="experiencia" class="form_estilo" id="experiencia" style="width:192px">
	<option value="2" <?=($c->experiencia==2)?'selected':'';?>>N�o</option>
	<option value="1" <?=($c->experiencia==1)?'selected':'';?>>Sim</option>
</select><br />

<label style="width:400px;text-align:left; margin-left:40px">Se N�o, Qual o Motivo de N�o Possuir o Neg�cio?</label><br />
<label>&nbsp;</label>
<input name="motivo" type="text" class="form_estilo" id="motivo" style="width:540px" value="<?=$c->motivo?>" maxlength="50" /><br />

<label>N�mero de Funcion�rios:</label>
<input name="funcionarios2" type="text" class="form_estilo" id="funcionarios2" style="width:190px" value="<?=$c->funcionarios2?>" maxlength="50" />

<label>Faturamento:</label>
<input name="faturamento2" type="text" class="form_estilo" id="faturamento2" style="width:190px" value="<?=$c->faturamento2?>" maxlength="50" /><br />

<label>Qual Franquia?</label>
<input name="qual_franquia" type="text" class="form_estilo" id="qual_franquia" style="width:190px" value="<?=$c->qual_franquia?>" maxlength="50" /><br />

<label style="width:480px;text-align:left; margin-left:40px">Na sua Opini�o Quais os Fatores Determinantes para o Sucesso de um Neg�cio?</label><br />
<label>&nbsp;</label>
<input name="opiniao" type="text" class="form_estilo" id="opiniao" style="width:540px;" value="<?=$c->opiniao?>" maxlength="50" />