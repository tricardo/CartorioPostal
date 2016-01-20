<label style="width:270px; text-align:left; margin-left:8px">Tem Capital Imediato Disponível para Investir?</label>
<input style="margin-left:10px;" id="capital1" name="capital" type="radio" value="Sim" <?=($c->capital=='Sim')?'checked':'';?> />Sim
<input style="margin-left:20px;" id="capital2" name="capital" type="radio" value="Não" <?=($c->capital=='Não')?'checked':'';?> />Não<br />

<label>Valor Disponível:</label>
<input onKeyPress="moeda(this);" type="text" style="width:191pxpx" id="valor_disp" name="valor_disp" class="form_estilo" maxlength="14" value="<?=$c->valor_disp?>" />

<label><br />Informe se Depende de Empréstimo ou Venda de Bens para Investir em sua Franquia Cartório Postal:</label>
<textarea style="width:540px;height:120px;resize:none" class="form_estilo" id="emprestimo" name="emprestimo"><?=$c->emprestimo?></textarea><br />

<label><br />Informe se o Capital Citado for de Terceiros:</label>
<textarea class="form_estilo" style="width:540px;height:120px;resize:none" id="capital_terc" name="capital_terc"><?=$c->capital_terc?></textarea><br />

<label style="width:250px; text-align:left; margin-left:8px">Quando Pretende dar Início ao Negócio?</label>
<select class="form_estilo" style="width:191px;" id="inicio_neg" name="inicio_neg">
	<option value="">--</option>
	<option value="Imediato" <? if($c->inicio_neg=='Imediato') echo 'selected'; ?>>Imediato</option>
	<option value="2 meses" <? if($c->inicio_neg=='2 meses') echo 'selected'; ?>>2 meses</option>
	<option value="4 meses" <? if($c->inicio_neg=='4 meses') echo 'selected'; ?>>4 meses</option>
	<option value="6 meses" <? if($c->inicio_neg=='6 meses') echo 'selected'; ?>>6 meses</option>
	<option value="8 meses" <? if($c->inicio_neg=='8 meses') echo 'selected'; ?>>8 meses</option>
	<option value="acima de 8 meses" <? if($c->inicio_neg=='acima de 8 meses') echo 'selected'; ?>>acima de 8 meses</option>
</select><br />

<label style="width:250px; text-align:left; margin-left:8px">Qual o seu Tempo Dedicado a Franquia?</label>
<input id="dedicado_franq1" name="dedicado_franq" type="radio" value="Integral" <?=($c->dedicado_franq=='Integral')?'checked':'';?> />Integral
<input id="dedicado_franq2" name="dedicado_franq" type="radio" value="Parcial" <?=($c->dedicado_franq=='Parcial')?'checked':'';?> />Parcial
<input id="dedicado_franq3" name="dedicado_franq" type="radio" value="Como Investidor" <?=($c->dedicado_franq=='Como Investidor')?'checked':'';?> />Como Investidor<br />

<label style="width:250px; text-align:left; margin-left:8px">A Franquia Será a Principal Fonte de Renda?</label>
<input style="margin-left:10px;" id="fonte_renda1" name="fonte_renda" type="radio" value="Sim" <?=($c->fonte_renda=='Sim')?'checked':'';?> />Sim
<input id="fonte_renda2" name="fonte_renda" type="radio" value="Não" <?=($c->fonte_renda=='Não')?'checked':'';?> />Não
<input id="fonte_renda3" name="fonte_renda" type="radio" value="Temporariamente" <?=($c->fonte_renda=='Temporariamente')?'checked':'';?> />Temporariamente<br />

<label style="width:250px; text-align:left; margin-left:8px">Pretende Ter Sócios? Especifique.</label>
<input type="text" style="width:189px" class="form_estilo" id="socios" name="socios" value="<?=$c->socios?>" maxlength="50" />