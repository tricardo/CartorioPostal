<label>Empresa: </label>
<input name="empresa_t" type="text" class="form_estilo" id="empresa_t" style="width:190px" value="<?=$c->empresa_t?>" maxlength="25" />

<label>Cargo Atual: </label>
<input name="cargo" type="text" class="form_estilo" id="cargo" style="width:191px" value="<?=$c->cargo?>" maxlength="25" /><br />


<label><br />Faça um Breve Relato Sobre seu Histórico: </label>
<textarea id="historico" name="historico" class="form_estilo" style="width:540px;height:120px;resize:none"><?=$c->historico?></textarea><br />


<label>Período: </label>
<select style="width:192px" class="form_estilo" name="periodo" id="periodo">
	<option value="">--</option>
	<option value="6 meses a 1 ano" <? if($c->periodo=='6 meses a 1 ano') echo 'selected'; ?>>6 meses a 1 ano</option>
	<option value="1 ano a 5 anos" <? if($c->periodo=='1 ano a 5 anos') echo 'selected'; ?>>1 ano a 5 anos</option>
	<option value="5 anos a 10 anos" <? if($c->periodo=='5 anos a 10 anos') echo 'selected'; ?>>5 anos a 10 anos</option>
	<option value="acima de 10 anos" <? if($c->periodo=='acima de 10 anos') echo 'selected'; ?>>acima de 10 anos</option>
</select>

<label>Funcionários:</label>
<select style="width:191px" class="form_estilo" name="funcionarios" id="funcionarios">
	<option value=""></option>
	<option value="1 a 5" <? if($c->funcionarios=='1 a 5') echo 'selected'; ?>>1 a 5</option>
	<option value="de 5 a 10" <? if($c->funcionarios=='de 5 a 10') echo 'selected'; ?>>de 5 a 10</option>
	<option value="de 10 a 50" <? if($c->funcionarios=='de 10 a 50') echo 'selected'; ?>>de 10 a 50</option>
	<option value="de 50 a 100" <? if($c->funcionarios=='de 50 a 100') echo 'selected'; ?>>de 50 a 100</option>
	<option value="acima de 100" <? if($c->funcionarios=='acima de 100') echo 'selected'; ?>>acima de 100</option>
</select><br />

<label>Faturamento:</label>
<select style="width:192px" class="form_estilo" name="faturamento" id="faturamento">
	<option value=""></option>
	<option value="Até R$ 50 mil" <? if($c->faturamento=='Até R$ 50 mil') echo 'selected'; ?>>Até R$ 50 mil</option>
	<option value="R$ 50 a R$ 100 mil" <? if($c->faturamento=='R$ 50 a R$ 100 mil') echo 'selected'; ?>>R$ 50 a R$ 100 mil</option>
	<option value="R$ 100 a R$ 300 mil" <? if($c->faturamento=='R$ 100 a R$ 300 mil') echo 'selected'; ?>>R$ 100 a R$ 300 mil</option>
	<option value="R$ 300 a R$ 500 mil" <? if($c->faturamento=='R$ 300 a R$ 500 mil') echo 'selected'; ?>>R$ 300 a R$ 500 mil</option>
	<option value="Acima de R$ 500 mil" <? if($c->faturamento=='Acima de R$ 500 mil') echo 'selected'; ?>>Acima de R$ 500 mil</option>
</select>

<label>Contato: </label>
<input name="contato" type="text" class="form_estilo" id="contato" style="width:191px" value="<?=$c->contato?>" maxlength="50" /><br />

<label>Ramo de Atuação:</label>
<input id="ramo_at" maxlength="40" name="ramo_at" value="<?=$c->ramo_at?>" type="text" style="width:190px" class="form_estilo" />

<label>Nome da Empresa:</label>
<input name="empresa_p" type="text" class="form_estilo" id="empresa_p" style="width:191px" value="<?=$c->empresa_p?>" maxlength="50" /><br />

<label>Cursos: </label>
<input type="text" style="width:190px" class="form_estilo" maxlength="50" id="cursos" name="cursos" value="<?=$c->cursos?>" />

<label>Grau de Escolaridade:</label>
<select style="width:192px" class="form_estilo" id="escolaridade" name="escolaridade">
	<option value="">--</option>
	<option value="Ensino fundamental: Incompleto" <? if($c->escolaridade=='Ensino fundamental: Incompleto') echo 'selected'; ?>>Ensino fundamental: Incompleto</option>
	<option value="Ensino fundamental: Completo" <? if($c->escolaridade=='Ensino fundamental: Completo') echo 'selected'; ?>>Ensino fundamental: Completo</option>
	<option value="">----------------------------------------------------------</option>
	<option value="Ensino médio: Incompleto" <? if($c->escolaridade=='Ensino médio: Incompleto') echo 'selected'; ?>>Ensino médio: Incompleto</option>
	<option value="Ensino médio: Completo" <? if($c->escolaridade=='Ensino médio: Completo') echo 'selected'; ?>>Ensino médio: Completo</option>
	<option value="">----------------------------------------------------------</option>
	<option value="Ensino superior: Incompleto" <? if($c->escolaridade=='Ensino superior: Incompleto') echo 'selected'; ?>>Ensino superior: Incompleto</option>
	<option value="Ensino superior: Completo" <? if($c->escolaridade=='Ensino superior: Completo') echo 'selected'; ?>>Ensino superior: Completo</option>
	<option value="">----------------------------------------------------------</option>
	<option value="Pós graduação" <? if($c->escolaridade=='Pós graduação') echo 'selected'; ?>>Pós graduação</option>
	<option value="Mestrado" <? if($c->escolaridade=='Mestrado') echo 'selected'; ?>>Mestrado</option>
	<option value="Doutorado" <? if($c->escolaridade=='Doutorado') echo 'selected'; ?>>Doutorado</option>
	<option value="MBA" <? if($c->escolaridade=='MBA') echo 'selected'; ?>>MBA</option>
</select><br />

<label>Qual Faculdade:</label>
<input name="faculdade" type="text" class="form_estilo" id="faculdade" style="width:190px" value="<?=$c->faculdade?>" maxlength="45" />

<label>Ano de Conclusão:</label>
<input name="conclusao" type="text" class="form_estilo" id="conclusao" style="width:191px" value="<?=$c->conclusao?>" maxlength="7" /><br />

<label>Tem ou Teve Negócio Próprio?</label>
<input style="margin-left:20px;" id="negocios1" name="negocios" type="radio" value="Sim" <?=($c->negocios=='Sim')?'checked':'';?> />Sim
<input style="margin-left:20px;" id="negocios2" name="negocios" type="radio" value="Não" <?=($c->negocios=='Não')?'checked':'';?> />Não