<label>Modelo do Veículo:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="50" name="modelo_veiculo" id="modelo_veiculo" value="<?=$c->modelo_veiculo?>" />

<label>Marca do Veículo:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="50" name="marca_veiculo" id="marca_veiculo" value="<?=$c->marca_veiculo?>" /><br />

<label>Ano do Veículo:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="10" name="ano_veiculo" id="ano_veiculo" value="<?=$c->ano_veiculo?>" />

<label>Placa do Veículo:</label>
<input type="text" style="width:190px;; text-transform:uppercase;" class="form_estilo" maxlength="10" name="placa_veiculo" id="placa_veiculo" value="<?=$c->placa_veiculo?>" /><br />

<label>Valor do Veículo:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="25" name="valor_veiculo" id="valor_veiculo" value="<?=$c->valor_veiculo?>" />

<label>Financiado?</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="50" name="financiado" id="financiado" value="<?=$c->financiado?>" /><br />

<label>Imóvel:</label>
<select style="width:190px;" class="form_estilo" name="imovel" id="imovel">
	<option value="">--</option>
	<option value="Própria" <?=($c->imovel=='Própria')?'selected="selected"':'';?>>Próprio</option>
	<option value="Alugada" <?=($c->imovel=='Alugada')?'selected="selected"':'';?>>Alugado</option>
</select>

<label>Valor Venal:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="25" name="valor_venal" id="valor_venal" value="<?=$c->valor_venal?>" /><br />

<label style="width:210px; text-align:left; margin-left:8px">Somatória do Valor Financiado:</label>
<input type="text" style="width:190px;" class="form_estilo" maxlength="25" name="somatoria" id="somatoria" value="<?=$c->somatoria?>" />