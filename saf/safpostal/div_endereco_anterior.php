				<div>
					<p>&nbsp;- ENDEREÇO ANTERIOR DO SOLICITANTE</p>
					<label style="margin-left:10px;"><strong>Endereço: <span>*</span></strong></label>
					<label style="margin-left:264px;"><strong>Nº.: <span>*</span></strong></label>
					<label style="margin-left:50px;"><strong>Complemento:</strong></label>
					<label style="margin-left:9px;"><strong>Bairro: <span>*</span></strong></label><br />
					<input name="anterior_endereco" type="text" class="form_estilo" id="anterior_endereco" style="width:334px; margin-left:10px;" value="<?=$c->anterior_endereco?>" maxlength="100" />
					<input name="anterior_numero" type="text" class="form_estilo" id="anterior_numero" style="width:73px; margin-left:10px;" value="<?=$c->anterior_numero?>" maxlength="10" />
					<input name="anterior_complemento" type="text" class="form_estilo" id="anterior_complemento" style="width:94px; margin-left:10px;" value="<?=$c->anterior_complemento?>" maxlength="40" />
					<input name="anterior_bairro" type="text" class="form_estilo" id="anterior_bairro" style="width:180px; margin-left:10px;" value="<?=$c->anterior_bairro?>" maxlength="50" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>UF: <span>*</span></strong></label>
					<label style="margin-left:61px;"><strong>Cidade: <span>*</span></strong></label>
					<label style="margin-left:383px;"><strong>CEP: <span>*</span></strong></label><br />
					<select style="width:84px; margin-left:10px;" class="form_estilo" id="anterior_estado" name="anterior_estado">
						<option value="<?= $estado ?>">UF</option>
						<? $sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
						while($res = mysql_fetch_array($sql)){
							echo '<option value="'.$res['estado'].'"';
							if($c->anterior_estado==$res['estado']) echo 'selected="selected"'; 
							echo '>'.$res['estado'].'</option>';
						} ?>
					</select>
					<input name="anterior_cidade" type="text" class="form_estilo" id="anterior_cidade" style="width:436px; margin-left:10px;" value="<?=$c->anterior_cidade?>" maxlength="100" />
					<input name="anterior_cep" type="text" class="form_estilo" id="anterior_cep" style="width:180px; margin-left:10px;" value="<?=$c->anterior_cep?>" maxlength="9" />
				</div>