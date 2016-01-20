<?$dt = $expansao->buscaIDStatus($c->id_ficha);
 $dts = $expansaos->buscaStatus($dt->id_status);
if($dt->id_status == 5 || $dt->id_status == 10 || $dt->id_status == 12){
	$data = explode("-", $dt->data_reuniao); 
	$y = $data[0];
	$m = $data[1];
	$d = $data[2];
	$st = $dts->status .' ('.$d.'/'.$m.'/'.$y.')';
} else { $st = $dts->status; } ?>
<table class="tabela" id="cad3" style="display:none;width:800px">
	<tr>
		<td class="tabela_tit" style="width:800px">Histórico</td>
	</tr>
	<tr>
		<td class="tabela_tit">* Status - <span style="color:#ffcc00"><?=$st?></span></td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<?if($dt->id_status != 14){ ?>
	
			<label>Alterar Status: <span>*</span></label>
			<select id="id_status" name="id_status" class="form_estilo" style="width:191px" onchange="VerificaStatus(this.value)">
				<?if($dt->id_status != 14 && $dt->id_status != 13){ ?>
					<option value="0">--</option>
				<? }
				$e = $expansaos->buscaRelStatus($dt->id_status);
				foreach($e as $j => $brs){
					echo '<option value="'.$brs->id_status.'" ';
					if($c->id_status == $brs->id_status){ echo 'selected="selected" '; } 
						echo '>'.$brs->status.'</option>' . "\n";
				}
				if($controle_id_usuario == 1 && $dt->id_status == 20){
					echo '<option value="1">Aberto</option>';
				}
				if($dt->id_status != 16 && $dt->id_status != 14 && $dt->id_status != 13){
					echo '<option value="16"';
					if($dt->id_status == 16){ echo 'selected="selected" ';}
					echo '>Cancelar</option>' . "\n";
					echo '<option value="19"';
					if($dt->id_status == 19){ echo 'selected="selected" ';}
					echo '>Contato com Candidato</option>' . "\n";
				}
				if($controle_id_usuario == 1 || $controle_id_usuario == 56 || $controle_id_usuario == 272){?>
					<option value="21">Contato com o Consultor</option>
					<option value="20">Excluir</option>        	
				<? } ?>
			</select><br />

			<div id="reuniao_agendada" style="display:none;">
				<label>Data da Reunião: <span>*</span></label>
				<input type="text" style="width:191px;" class="form_estilo" maxlength="10" id="data_reuniao" name="data_reuniao" value="<?=$data_reuniao?>" />
				
				<label>Forma de Contato:</label>
				<select id="forma_pagto2" name="forma_pagto2" class="form_estilo" style="width:191px">
					<option value="0"></option>
					<? $f_pgto = $expansao->forma_pagto2();
					for($i = 0; $i < count($f_pgto[0]); $i++){?>
						<option value="<?=$f_pgto[0][$i]?>"><?=$f_pgto[1][$i]?></option>
					<? } ?>
				</select>
				<br />
			</div>
			
			<label>Observações: <span id="anotacao_obrigatoria" style="display:none; float:right"> *</span></label>
			<textarea id="observacao_expansao" name="observacao_expansao" class="form_estilo" style="width:540px;height:120px;resize:none"></textarea><br />
		<? } ?>
		</td>
	</tr>		
	<tr>
		<td style="text-align:center"><?criarBotao($executar_alteracoes, $c->id_status, 'historico')?></td>
	</tr>		
	<tr>
		<td class="busca1 tabela_tit_campos">	
			<div style="font-weight:normal; margin-left:10px">
				<div id="abre_historico">
					<a href="#historico" onclick="VisualizarHistorico(1, <?=$c->id_ficha?>);">+ Visualizar Histórico</a>
					<a name="historico"></a><br />
				</div>
				<a href="#" id="mstl" onclick="document.getElementById('hist').style.display='block';document.getElementById('mstl').style.display='none';document.getElementById('mstbr').style.display='none';" style="display:none">+ Visualizar Histórico</a><br id="mstbr" style="display:none" />
				<div id="hist" style="margin-top:10px; font-weight:normal; text-transform:none;"></div>
			</div>
			
			<? if($erro_sb == 1){echo "<script>document.getElementById('anotacao_obrigatoria').style.display = 'block';</script>";}
			if($erro_dt == 1){echo "<script>document.getElementById('reuniao_agendada').style.display = 'block';</script>";} ?>
		</td>
	</tr>

</table>
