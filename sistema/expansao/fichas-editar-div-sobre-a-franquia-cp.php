<label style="width:100%;text-align:left;margin-left:8px">Enumere o que você considera importante na franquia Cartório Postal, sendo que o número 1 é o mais importante:</label><br />
<? $dt = $expansao->EnumPergunta(); $i = 0; $valor = array();
foreach($dt as $j => $ep){
	$id_pergunta[$i] = $ep->id_enum_perg;
	$pergunta[$i]    = $ep->pergunta;
	$ret = $expansao->relFichaLazer2($c->id_ficha, $ep->id_enum_perg);
	$valor[$i] = $ret[0]->valor;
	$i++;
} 
for($i = 0; $i < count($id_pergunta); $i++){ ?>
	<input type="hidden" value="<?=$id_pergunta[$i]?>" name="id_pergunta[]" id="id_pergunta<?=$i?>" />
	<input onKeyUp="masc_numeros(this,'#');" name="perguntas[]" id="pergunta<?=$i?>" value="<?=$valor[$i]?>" type="text" class="form_estilo" maxlength="1" style="text-align:center; width:50px; margin-left:10px;" />
	<label style="font-weight:normal; margin-top:2px;width:500px;margin-left:8px;text-align:left"><?=$pergunta[$i]?></label><br />		
<? } ?>
<input type="hidden" value="<?=$i?>" name="id_pergunta_total" id="id_pergunta_total" />

<label><br />Como Conheceu as Franquias Cartório Postal:</label>
<textarea class="form_estilo" style="width:540px;height:120px;resize:none" id="conheceu_cp" name="conheceu_cp"><?=$c->conheceu_cp?></textarea><br />

<label style="width:250px; text-align:left; margin-left:8px">Já Esteve em uma de Nossas Unidades?</label>
<input style="margin-left:10px;" id="unidades1" name="unidades" type="radio" value="Sim" <?=($c->unidades=='Sim')?'checked':'';?> />Sim
<input id="unidades2" name="unidades" type="radio" value="Não" <?=($c->unidades=='Não')?'checked':'';?> />Não<br />

<label>Qual?</label>
<input type="text" style="width:540px" class="form_estilo" id="unidades_valor" name="unidades_valor" maxlength="25" value="<?=$c->unidades_valor?>" /><br />

<label style="width:360px; text-align:left; margin-left:8px">Deseja Receber Comunicados de Outras Empresas da Rede?</label>
<input style="margin-left:15px;" id="comunicados1" name="comunicados" type="radio" value="Sim" <?=($c->comunicados=='Sim')?'checked':'';?> />Sim
<input id="comunicados2" name="comunicados" type="radio" value="Não" <?=($c->comunicados=='Não')?'checked':'';?> />Não<br />

<label><br />Porque o Interesse em ser um Franqueado?</label>
<textarea class="form_estilo" style="width:540px;height:120px;resize:none" id="interesse" name="interesse"><?=$c->interesse?></textarea><br />

<label style="width:250px; text-align:left; margin-left:8px">Selecione o Estado e a Cidade de Interesse: </label>
<select style="width:190px;" class="form_estilo" name="estado_interesse" id="estado_interesse">
<? $dt = $expansao->estado(); $cont = 0;
foreach($dt as $b => $res){ 
	echo (count($dt) > 1 && $cont == 0) ? '<option value="">--</option>' . "\n" : ''; $cont++;
	echo "\t\t\t\t\t".'<option value="'.$res->estado.'"'.(($c->estado_interesse == $res->estado) ? 
		' selected="selected"' : '').'>'.$res->estado.'</option>' . "\n";
} ?>
</select>
<input type="text" style="width:231px; margin-left:10px;" class="form_estilo" id="cidade_interesse" name="cidade_interesse" value="<?=$c->cidade_interesse?>" maxlength="120" /><br />

<label><br />Seu Espaço Para Observações:</label>
<textarea class="form_estilo" style="width:540px;height:120px;resize:none" id="observacao" name="observacao"><?=$c->observacao?></textarea>