<div>
					<p>&nbsp;- BENS DE CONSUMO</p>
					<label style="margin-left:10px"><strong>Modelo do Veículo:</strong></label>
					<label style="margin-left:105px"><strong>Marca do Veículo:</strong></label>
					<label style="margin-left:117px"><strong>Ano do Veículo:</strong></label><br />
					<input type="text" style="width:231px; margin-left:10px" class="form_estilo" maxlength="50" name="modelo_veiculo" id="modelo_veiculo" value="<?=$c->modelo_veiculo?>" />
					<input type="text" style="width:230px; margin-left:10px" class="form_estilo" maxlength="50" name="marca_veiculo" id="marca_veiculo" value="<?=$c->marca_veiculo?>" />
					<input type="text" style="width:231px; margin-left:10px" class="form_estilo" maxlength="10" name="ano_veiculo" id="ano_veiculo" value="<?=$c->ano_veiculo?>" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px"><strong>Placa do Veículo:</strong></label>
					<label style="margin-left:117px"><strong>Valor do Veículo:</strong></label>
					<label style="margin-left:117px"><strong>Financiado?</strong></label><br />
					<input type="text" style="width:231px; margin-left:10px; text-transform:uppercase;" class="form_estilo" maxlength="10" name="placa_veiculo" id="placa_veiculo" value="<?=$c->placa_veiculo?>" />
					<input type="text" style="width:230px; margin-left:10px" class="form_estilo" maxlength="25" name="valor_veiculo" id="valor_veiculo" value="<?=$c->valor_veiculo?>" />
					<input type="text" style="width:231px; margin-left:10px" class="form_estilo" maxlength="50" name="financiado" id="financiado" value="<?=$c->financiado?>" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px"><strong>Imóvel:</strong></label>
					<label style="margin-left:191px"><strong>Valor Venal:</strong></label>
					<label style="margin-left:155px"><strong>Somatória do Valor Financiado:</strong></label><br />
					<select style="width:231px; margin-left:10px" class="form_estilo" name="imovel" id="imovel">
						<option value="">:.Selecione</option>
						<option value="Própria" <?=($c->imovel=='Própria')?'selected="selected"':'';?>>Próprio</option>
						<option value="Alugada" <?=($c->imovel=='Alugada')?'selected="selected"':'';?>>Alugado</option>
					</select>
					<input type="text" style="width:232px; margin-left:10px" class="form_estilo" maxlength="25" name="valor_venal" id="valor_venal" value="<?=$c->valor_venal?>" />
					<input type="text" style="width:231px; margin-left:10px" class="form_estilo" maxlength="25" name="somatoria" id="somatoria" value="<?=$c->somatoria?>" />
					<label style="width:758px;">&nbsp;</label>
				</div>