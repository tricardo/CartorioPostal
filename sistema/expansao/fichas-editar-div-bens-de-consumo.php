<label>Modelo do Ve�culo:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="50" name="modelo_veiculo" id="modelo_veiculo" value="<?=$c->modelo_veiculo?>" />

<label>Marca do Ve�culo:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="50" name="marca_veiculo" id="marca_veiculo" value="<?=$c->marca_veiculo?>" /><br />

<label>Ano do Ve�culo:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="10" name="ano_veiculo" id="ano_veiculo" value="<?=$c->ano_veiculo?>" />

<label>Placa do Ve�culo:</label>
<input type="text" style="width:190px;; text-transform:uppercase;" class="form_estilo" maxlength="10" name="placa_veiculo" id="placa_veiculo" value="<?=$c->placa_veiculo?>" /><br />

<label>Valor do Ve�culo:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="25" name="valor_veiculo" id="valor_veiculo" value="<?=$c->valor_veiculo?>" />

<label>Financiado?</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="50" name="financiado" id="financiado" value="<?=$c->financiado?>" /><br />

<label>Im�vel:</label>
<select style="width:190px;" class="form_estilo" name="imovel" id="imovel">
	<option value="">--</option>
	<option value="Pr�pria" <?=($c->imovel=='Pr�pria')?'selected="selected"':'';?>>Pr�prio</option>
	<option value="Alugada" <?=($c->imovel=='Alugada')?'selected="selected"':'';?>>Alugado</option>
</select>

<label>Valor Venal:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="25" name="valor_venal" id="valor_venal" value="<?=$c->valor_venal?>" /><br />

<label style="width:210px; text-align:left; margin-left:8px">Somat�ria do Valor Financiado:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="25" name="somatoria" id="somatoria" value="<?=$c->somatoria?>" />