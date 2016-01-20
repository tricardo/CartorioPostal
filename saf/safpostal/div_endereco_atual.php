				<div>
					<p>&nbsp;- ENDEREÇO ATUAL DO SOLICITANTE</p>
					<label style="margin-left:10px;"><strong>Endereço: <span>*</span></strong></label>
					<label style="margin-left:264px;"><strong>Nº.: <span>*</span></strong></label>
					<label style="margin-left:50px;"><strong>Complemento:</strong></label>
					<label style="margin-left:9px;"><strong>Bairro: <span>*</span></strong></label><br />
					<input name="endereco" type="text" class="form_estilo" id="endereco" style="width:334px; margin-left:10px;" value="<?=$c->endereco?>" maxlength="100" />
					<input name="numero" type="text" class="form_estilo" id="numero" style="width:73px; margin-left:10px;" value="<?=$c->numero?>" maxlength="10" />
					<input name="complemento" type="text" class="form_estilo" id="complemento" style="width:94px; margin-left:10px;" value="<?=$c->complemento?>" maxlength="40" />
					<input name="bairro" type="text" class="form_estilo" id="bairro" style="width:180px; margin-left:10px;" value="<?=$c->bairro?>" maxlength="50" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>UF: <span>*</span></strong></label>
					<label style="margin-left:61px;"><strong>Cidade: <span>*</span></strong></label>
					<label style="margin-left:383px;"><strong>CEP: <span>*</span></strong></label><br />
					<select style="width:84px; margin-left:10px;" class="form_estilo" id="estado" name="estado">
						<option value="<?= $estado ?>">UF</option>
						<? $sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
						while($res = mysql_fetch_array($sql)){
							echo '<option value="'.$res['estado'].'"';
							if($c->estado==$res['estado']) echo 'selected="selected"'; 
							echo '>'.$res['estado'].'</option>';
						} ?>
					</select>
					<input name="cidade" type="text" class="form_estilo" id="cidade" style="width:436px; margin-left:10px;" value="<?=$c->cidade?>" maxlength="120" />
					<input name="cep" type="text" class="form_estilo" id="cep" style="width:180px; margin-left:10px;" value="<?=$c->cep?>" maxlength="9" />
				
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Tipo do Imóvel:</strong></label>
					<label style="margin-left:258px;"><strong>Reside na Praça Desde:</strong></label><br />
					<select style="width:358px; margin-left:10px;" class="form_estilo" name="tip_imovel" id="tip_imovel">
						<option value="0">.:SELECIONE:.</option>
						<option value="1" <? if($c->tip_imovel == 1){ ?> selected="selected" <? } ?>>Própria</option>
						<option value="2" <? if($c->tip_imovel == 2){ ?> selected="selected" <? } ?>>Alugada</option>
						<option value="3" <? if($c->tip_imovel == 3){ ?> selected="selected" <? } ?>>Familiares</option>
					</select>
					<input name="reside_praca" type="text" class="form_estilo" id="reside_praca" style="width:358px; margin-left:9px;" value="<?=$c->reside_praca?>" maxlength="25" />
				</div>