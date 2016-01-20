<? $pagina = array(2,3,5,6,7);
$progresso = $franquia->validar_processo($c, $permissao_admin, $pagina); 
$progresso = $franquia->checklist_valida(7,$c->id_empresa);
if($permissao_admin == 'TRUE'){ 
	$dt = $franquia->tipo_franquia($c->id_empresa); 
	$id_franquia_tipo = $dt[0]->franquia_tipo; ?>
	<label>ID:</label>
		<input type="text" class="form_estilo" value="0" readonly="readonly" id="id_franquia_regiao" name="id_franquia_regiao" />
	<label>Finalizar Processo:</label>
		<input type="checkbox" class="form_estilo" id="ativo" name="ativo" <?=(count($progresso) > 0 && $progresso[0]->ativo == 1) ? 'checked="checked"' : ''?>
		<input type="hidden" name="registro" id="registro" value="<?=(count($progresso) > 0) ? $progresso[0]->id_empresa_chk : 0?>" /><br />
	<label>CEP Início:</label>
		<input type="text" class="form_estilo" name="cep_i" id="cep_i" value="<?=$cep_i?>" />
		<script>$('#cep_i').mask('99999-999');</script>
	<label>CEP Fim:</label>
		<input type="text" class="form_estilo" name="cep_f" id="cep_f" value="<?=$cep_f?>" /><br />
		<script>$('#cep_f').mask('99999-999');</script>
	<label>Apelido:</label>
		<input type="text" class="form_estilo" name="apelido" id="apelido" value="<?=$apelido?>" />
	<label>Loja:</label>
		<select class="form_estilo" name="loja" id="loja">
			<option value="1" <?=($loja == 1) ? 'selected="selected"' : ''?>>Sim</option>
			<option value="0" <?=($loja == 0) ? 'selected="selected"' : ''?>>Não</option>
		</select><br />
	<label>Cidade:</label>
		<input type="text" class="form_estilo" name="cidade" id="cidade" value="<?=$cidade?>" />
	<label>UF:</label>
		<select class="form_estilo" name="estado" id="estado">
			<? $estado = array('AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT',
				'MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP',
				'SE','TO');
			for($i = 0; $i < count($estado); $i++){ ?>
				<option value="<?=$estado[$i]?>" <?=($estado[$i] == trim($uf)) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
			<? } ?>
		</select><br />
	<label>Latitude:</label>
		<input type="text" class="form_estilo" name="latitude" id="latitude" value="<?=$latitude?>" />
	<label>Longitude:</label>
		<input type="text" class="form_estilo" name="longitude" id="longitude" value="<?=$longitude?>" /><br />
	<label>CDT:</label>
		<input type="text" class="form_estilo" name="cdt" id="cdt" value="<?=$cdt?>" />
	<label>Distância:</label>
		<input type="text" class="form_estilo" name="distancia" id="distancia" value="<?=$distancia?>" /><br />
	<label>&nbsp;</label>
		<input type="button" value="Incluir" class="button_busca" id="btn" onclick="alterar_implantacao(7)" /><br />&nbsp;
	<div id="franquias">
		<table style="width:100%;">
			<tr>
				<td colspan="6" style="text-align:right"><a href="#" onclick="faixa_cep(2,0)">cadastrar nova faixa de cep</a></td>
			</tr>
			<tr id="tr_implantacao">
				<td colspan="2" style="text-align:center">CEP</td>
				<td>Apelido</td>
				<td>Cidade</td>
				<td style="width:70px;text-align:center">Estado</td>
				<td style="width:50px;"></td>
			</tr>
		<? $dt = $franquia->listar(3, $c); 
		for($i = 0; $i < count($dt); $i++){ ?>
			<tr style="background-color:<?=($color == '#FFF') ? $color = '#CCC' : $color = '#FFF' ?>">
				<td id="cep_i<?=$i?>" style="width:70px;text-align:center"><?=$dt[$i]->cep_i?></td>
				<td id="cep_f<?=$i?>" style="width:70px;text-align:center"><?=$dt[$i]->cep_f?></td>
				<td id="apelido<?=$i?>"><?=$dt[$i]->apelido?></td>
				<td id="cidade<?=$i?>"><?=$dt[$i]->cidade?></td>
				<td id="estado<?=$i?>" style="text-align:center"><?=$dt[$i]->estado?></td>
				<td style="text-align:center">
					<img src="../images/botao_editar.png" style="width:15px;height:15px;cursor:pointer" onclick="faixa_cep(1,<?=$i?>)" />
					<input type="hidden" name="loja<?=$i?>" id="loja<?=$i?>" value="<?=$dt[$i]->loja?>" />
					<input type="hidden" name="latitude<?=$i?>" id="latitude<?=$i?>" value="<?=$dt[$i]->latitude?>" />
					<input type="hidden" name="longitude<?=$i?>" id="longitude<?=$i?>" value="<?=$dt[$i]->longitude?>" />
					<input type="hidden" name="cdt<?=$i?>" id="cdt<?=$i?>" value="<?=$dt[$i]->cdt?>" />
					<input type="hidden" name="distancia<?=$i?>" id="distancia<?=$i?>" value="<?=$dt[$i]->distancia?>" />
					<input type="hidden" name="id_franquia_regiao<?=$i?>" id="id_franquia_regiao<?=$i?>" value="<?=$dt[$i]->id_franquia_regiao?>" />
				</td>
			</tr>
		<? } ?>
		</table>
	</div>
<? #} 
} else {
	if(count($progresso) == 0 || $progresso[0]->ativo == 0){
		$dt = $franquia->envia_email(1, 1, $c->id_empresa, $controle_cp->id_usuario);
		if(count($dt) > 0){
			echo '<span style="color:#FF0000">Você deve aguardar o TI finalizar o processo.</span>';
		} else {
			echo '<span style="color:#FF0000">O TI é responsável por validar este passo.</span>
				<br /><span>Para solicitar o andamento ao TI, <a href="#" 
				onclick="implantacao_email(1, '.$c->id_empresa.','.$controle_cp->id_usuario.')">clique aqui</a>.</span>';
		}
	} else {
		echo '<span style="color:#FF0000">Processo concluído.</span>';
	}
 } ?>