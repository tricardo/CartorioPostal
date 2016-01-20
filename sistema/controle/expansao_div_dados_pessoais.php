				<div>
					<p>&nbsp;- DADOS PESSOAIS DO CÔNJUGE SE HOUVER</p>
					<label style="margin-left:10px;"><strong>Nome:</strong></label>
					<label style="margin-left:355px;"><strong>RG:</strong></label>
					<label style="margin-left:150px;"><strong>CPF:</strong></label><br />
					<input name="conjuge_nome" type="text" class="form_estilo" id="conjuge_nome" style="width:374px; margin-left:10px;" value="<?=$c->conjuge_nome?>" maxlength="100" />
					<input name="conjuge_rg" type="text" class="form_estilo" id="conjuge_rg" style="width:154px; margin-left:13px;" value="<?=$c->conjuge_rg?>" maxlength="13" />
					<input name="conjuge_cpf" type="text" class="form_estilo" id="conjuge_cpf" style="width:154px; margin-left:13px;" value="<?=$c->conjuge_cpf?>" maxlength="15" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Data de Nascimento:</strong></label>
					<label style="margin-left:242px;"><strong>E-mail:</strong></label><br />
					<input name="conjuge_nascimento" type="text" class="form_estilo" id="conjuge_nascimeto" style="width:358px; margin-left:10px" value="<?=$c->conjuge_nascimento?>" maxlength="10" />
					<input name="conjuge_email" type="text" class="form_estilo" id="conjuge_email" style="width:358px; margin-left:9px;" value="<?=$c->conjuge_email?>" maxlength="50" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Nome do Pai:</strong></label>
					<label style="margin-left:290px;"><strong>Nome da Mãe:</strong></label><br />
					<input name="conjuge_nome_pai" type="text" class="form_estilo" id="conjuge_nome_pai" style="width:358px; margin-left:10px;" value="<?=$c->conjuge_nome_pai?>" maxlength="80" />
					<input name="conjuge_nome_mae" type="text" class="form_estilo" id="conjuge_nome_mae" style="width:358px; margin-left:9px;" value="<?=$c->conjuge_nome_mae?>" maxlength="80" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Profissão:</strong></label>
					<label style="margin-left:300px;"><strong>Cargo:</strong></label><br />
					<input name="conjuge_profissao" type="text" class="form_estilo" id="conjuge_profissao" style="width:358px; margin-left:10px;" value="<?=$c->conjuge_profissao?>" maxlength="70" />
					<input name="conjuge_cargo" type="text" class="form_estilo" id="conjuge_cargo" style="width:358px; margin-left:9px;" value="<?=$c->conjuge_cargo?>" maxlength="70" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Empresa:</strong></label>
					<label style="margin-left:375px;"><strong>Telefone:</strong></label>
					<label style="margin-left:48px;"><strong>Admissao:</strong></label><br />
					<input name="conjuge_empresa" type="text" class="form_estilo" id="conjuge_empresa" style="width:424px; margin-left:10px;" value="<?=$c->conjuge_empresa?>" maxlength="50" />
					<input name="conjuge_telefone" type="text" class="form_estilo" id="conjuge_telefone" style="width:94px; margin-left:10px;" value="<?=$c->conjuge_telefone?>" maxlength="15" />
					<input name="conjuge_admissao" type="text" class="form_estilo" id="conjuge_admissao" style="width:180px; margin-left:10px;" value="<?=$c->conjuge_admissao?>" maxlength="10" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Endereço da Empresa:</strong></label>
					<label style="margin-left:205px;"><strong>Nº.:</strong></label>
					<label style="margin-left:65px;"><strong>Complemento:</strong></label>
					<label style="margin-left:18px;"><strong>Bairro:</strong></label><br />
					<input name="conjuge_end_empresa" type="text" class="form_estilo" id="conjuge_end_empresa" style="width:334px; margin-left:10px;" value="<?=$c->conjuge_end_empresa?>" maxlength="60" />
					<input name="conjuge_numero" type="text" class="form_estilo" id="conjuge_numero" style="width:73px; margin-left:10px;" value="<?=$c->conjuge_numero?>" maxlength="10" />
					<input name="conjuge_complemento" type="text" class="form_estilo" id="conjuge_complemento" style="width:94px; margin-left:10px;" value="<?=$c->conjuge_complemento?>" maxlength="40" />
					<input name="conjuge_bairro" type="text" class="form_estilo" id="conjuge_bairro" style="width:180px; margin-left:10px;" value="<?=$c->conjuge_bairro?>" maxlength="70" />
					
					<label style="width:800px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>UF:</strong></label>
					<label style="margin-left:80px;"><strong>Cidade:</strong></label>
					<label style="margin-left:400px;"><strong>CEP:</strong></label><br />
					<select style="width:84px; margin-left:10px;" class="form_estilo" id="conjuge_estado" name="conjuge_estado">
						<option value="<?= $conjuge_estado ?>">UF</option>
						<?$sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
						while($res = mysql_fetch_array($sql)){
							echo '<option value="'.$res['estado'].'"';
							if($c->conjuge_estado==$res['estado']) echo 'selected="selected"'; 
							echo '>'.$res['estado'].'</option>';
						}?>
					</select>
					<input name="conjuge_cidade" type="text" class="form_estilo" id="conjuge_cidade" style="width:436px; margin-left:10px;" value="<?=$c->conjuge_cidade?>" maxlength="120" />
					<input name="conjuge_cep" type="text" class="form_estilo" id="conjuge_cep" style="width:180px; margin-left:10px;" value="<?=$c->conjuge_cep?>" maxlength="9" />
				</div>