
<label>Nome:</label>
<input name="conjuge_nome" type="text" class="form_estilo" id="conjuge_nome" value="<?=$c->conjuge_nome?>" maxlength="100" /><br />

<label>E-mail:</label>
<input name="conjuge_email" type="text" class="form_estilo" id="conjuge_email" value="<?=$c->conjuge_email?>" maxlength="50" /><br />

<label>RG:</label>
<input name="conjuge_rg" type="text" class="form_estilo" id="conjuge_rg" value="<?=$c->conjuge_rg?>" maxlength="13" style="width:192px" />

<label>CPF:</label>
<input name="conjuge_cpf" type="text" class="form_estilo" id="conjuge_cpf" value="<?=$c->conjuge_cpf?>" maxlength="15" style="width:191px" /><br />

<label>Data de Nascimento:</label>
<input name="conjuge_nascimento" type="text" class="form_estilo" id="conjuge_nascimeto" value="<?=$c->conjuge_nascimento?>" maxlength="10" style="width:192px" /><br />

<label>Nome do Pai:</label>
<input name="conjuge_nome_pai" type="text" class="form_estilo" id="conjuge_nome_pai" value="<?=$c->conjuge_nome_pai?>" maxlength="80" /><br />
	
<label>Nome da Mãe:</label>
<input name="conjuge_nome_mae" type="text" class="form_estilo" id="conjuge_nome_mae" value="<?=$c->conjuge_nome_mae?>" maxlength="80" /><br />

<label>Profissão:</label>
<input name="conjuge_profissao" type="text" class="form_estilo" id="conjuge_profissao" style="width:192px" value="<?=$c->conjuge_profissao?>" maxlength="70" />

<label>Cargo:</label>
<input name="conjuge_cargo" type="text" class="form_estilo" id="conjuge_cargo" style="width:191px" value="<?=$c->conjuge_cargo?>" maxlength="70" /><br />
	
<label>Empresa:</label>
<input name="conjuge_empresa" type="text" class="form_estilo" id="conjuge_empresa" value="<?=$c->conjuge_empresa?>" maxlength="50" /><br />

<label>Telefone:</label>
<input name="conjuge_telefone" type="text" class="form_estilo" id="conjuge_telefone" style="width:192px" value="<?=$c->conjuge_telefone?>" maxlength="15" />
	
<label>Admissao:</label>
<input name="conjuge_admissao" type="text" class="form_estilo" id="conjuge_admissao" style="width:191px" value="<?=$c->conjuge_admissao?>" maxlength="10" />

<label>Endereço da Empresa:</label>
<input name="conjuge_end_empresa" type="text" class="form_estilo" id="conjuge_end_empresa" value="<?=$c->conjuge_end_empresa?>" maxlength="60" style="width:423px" />

<label style="width:40px">Nº.:</label>
<input name="conjuge_numero" type="text" class="form_estilo" id="conjuge_numero" style="width:70px;" value="<?=$c->conjuge_numero?>" maxlength="10" /><br />

<label>Complemento:</label>
<input name="conjuge_complemento" type="text" class="form_estilo" id="conjuge_complemento" style="width:192px" value="<?=$c->conjuge_complemento?>" maxlength="40" />

<label>Bairro:</label>
<input name="conjuge_bairro" type="text" class="form_estilo" id="conjuge_bairro" style="width:191px" value="<?=$c->conjuge_bairro?>" maxlength="70" /><br />

<label>CEP:</label>
<input name="conjuge_cep" type="text" class="form_estilo" id="conjuge_cep" style="width:192px" value="<?=$c->conjuge_cep?>" maxlength="9" />

<label>UF:</label>
<select style="width:193px" class="form_estilo" id="conjuge_estado" name="conjuge_estado">
	<? $dt = $expansao->estado(); $cont = 0;
	foreach($dt as $b => $res){ 
		echo (count($dt) > 1 && $cont == 0) ? '<option value="">--</option>' . "\n" : ''; $cont++;
		echo "\t\t\t\t\t".'<option value="'.$res->estado.'"'.(($c->conjuge_estado == $res->estado) ? 
			' selected="selected"' : '').'>'.$res->estado.'</option>' . "\n";
	} ?>
</select><br />

<label>Cidade:</label>
<input name="conjuge_cidade" type="text" class="form_estilo" id="conjuge_cidade" value="<?=$c->conjuge_cidade?>" maxlength="120" /><br />
