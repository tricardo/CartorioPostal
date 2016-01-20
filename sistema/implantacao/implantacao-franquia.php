<?
if(isset($c->id_empresa_imp)){
	$franquia->empresa_implantacao($c);
}
$dt = $franquia->listar(5, $c);
?>
<label>Franqueado:</label>
	<input type="text" id="franqueado" name="franqueado" value="<?=$dt[0]->franqueado?>" class="form_estilo" />
<label>E-mail:</label>
	<input type="text" id="email" name="email" value="<?=$dt[0]->email?>" class="form_estilo" /><br />
<label>Endereço:</label>
	<input type="text" id="endereco" name="endereco" value="<?=$dt[0]->endereco?>" class="form_estilo" style="width:169px" />
	<input type="text" id="numero" name="numero" value="<?=$dt[0]->numero?>" class="form_estilo" style="width:40px" />
	<input type="text" id="complemento" name="complemento" value="<?=$dt[0]->complemento?>" class="form_estilo" style="width:64px" />
<label style="width:38px">CEP:</label>
	<input type="text" id="cep" name="cep" value="<?=$dt[0]->cep?>" class="form_estilo" style="width:100px" />
<label style="width:48px">UF:</label>
	<input type="text" id="uf" name="uf" value="<?=$dt[0]->uf?>" class="form_estilo" style="width:60px" /><br />
<label>Bairro:</label>
	<input type="text" id="bairro" name="bairro" value="<?=$dt[0]->bairro?>" class="form_estilo" />	
<label>Cidade:</label>
	<input type="text" id="cidade" name="cidade" value="<?=$dt[0]->cidade?>" class="form_estilo" /><br />	
<label>Telefone:</label>
	<input type="text" id="telefone1" name="telefone1" value="<?=$dt[0]->telefone1?>" class="form_estilo" />
<label>Telefone:</label>
	<input type="text" id="telefone2" name="telefone2" value="<?=$dt[0]->telefone2?>" class="form_estilo" /><br />
	<input type="hidden" id="atendente" name="atendente" value="0" />
<!--<label>Atendente:</label>
	<select id="atendente" name="atendente" class="form_estilo">
		<option value="0"></option>
		<  
		foreach ($list as $f) { ?>
			<option value="<=$f->id_usuario?>" <=($f->id_usuario == $dt[0]->id_usuario) ?'selected="selected"':''?>><=ucwords(strtolower($f->nome))?></option>
		< } ?>
	</select><br />-->
<label>Consultor Comercial:</label>
	<select id="id_consultor1" name="id_consultor1" class="form_estilo" style="margin-top:10px">
		<option value="0"></option>
		<? $list = $franquia->getQntUsuarios(3, 0, 0); 
		foreach ($list as $f) { ?>
			<option value="<?=$f->id_usuario?>" <?=($f->id_usuario == $dt[0]->id_consultor1) ?'selected="selected"':''?>><?=ucwords(strtolower($f->nome))?></option>
		<? } ?>
	</select>
<label>Consultor de Vendas:</label>
	<select id="id_consultor2" name="id_consultor2" class="form_estilo" style="margin-top:10px">
		<option value="0"></option>
		<? foreach ($list as $f) { ?>
			<option value="<?=$f->id_usuario?>" <?=($f->id_usuario == $dt[0]->id_consultor2) ?'selected="selected"':''?>><?=ucwords(strtolower($f->nome))?></option>
		<? } ?>
	</select><br />
<label>&nbsp;</label>
	<input type="hidden" id="id_empresa_imp" name="id_empresa_imp" value="<?=$dt[0]->id_empresa_imp?>" />
	<input type="button" value="Editar" class="button_busca" onclick="franquia_editar(3,<?=$c->id_empresa?>)" /><br />&nbsp;