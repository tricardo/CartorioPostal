<label style="width:758px; text-align:right; display:inline-block;">Campos marcados com 
(<span style="color:#FF0000;">*</span>) são de preenchimento obrigatório.</label>
<form name="form_interesse" action="interessados_edit.php?id=<?=$id?>&aba=2" method="post">
	<?$d = $dt->buscaIDStatus($id); 
	$id_status_atual = $d->id_status;
	$e = $dt1->buscaStatus($id_status_atual);?>
	<div id="status" class="div_titulo">&nbsp;- <strong>Status Atual:</strong> <?
	if($id_status_atual == 5 || $id_status_atual == 10 || $id_status_atual == 12){
		$data = explode("-", $d->data_reuniao); 
		$y = $data[0];
		$m = $data[1];
		$d = $data[2];
		echo $e->status .' ('.$d.'/'.$m.'/'.$y.')';
	} else { echo $e->status; } ?></div>
	<?if($id_status_atual != 14){?>
	<div class="div_form">
		<label style="width:758px;">&nbsp;</label>
		
		<label style="margin-left:10px;"><strong>Alterar Status: <span>*</span></strong></label>
		<select id="id_status" name="id_status" class="form_estilo" 
		style="width:356px; margin-left:8px;" onchange="VerificaStatus(this.value)">
		<?if($id_status_atual != 14 && $id_status_atual != 13){ ?>
			<option value="0">.:SELECIONE:.</option>
		<?}
		$e = $dt1->buscaRelStatus($id_status_atual);									
		foreach($e as $j => $brs){
			echo '<option value="'.$brs->id_status.'" ';
			if($c->id_status == $brs->id_status){ 
				echo 'selected="selected" ';} 
			echo '>'.$brs->status.'</option>' . "\n";
		}									
		if($id_status_atual != 16 && $id_status_atual != 14 && $id_status_atual != 13){
			echo '<option value="16"';
			if($id_status_atual == 16){ echo 'selected="selected" ';}
			echo '>Cancelar</option>' . "\n";
			echo '<option value="19"';
			if($id_status_atual == 19){ echo 'selected="selected" ';}
			echo '>Contato com Candidato</option>' . "\n";
		} 
        if($safpostal_id_usuario == 1 || $safpostal_id_usuario == 56 || $safpostal_id_usuario == 272){?>
        	<option value="20">Excluir</option>
        <? }?>
		</select>
		
		<div id="reuniao_agendada" style="margin-left:10px; display:none;">
			<label style="width:758px;">&nbsp;</label>
			<label><strong>Data da Reunião:</strong> <span>*</span></label>
            <input type="text" style="width:356px;" class="form_estilo" maxlength="10" id="data_reuniao" name="data_reuniao" value="<?=$data_reuniao?>" />
        </div>
		
		<label style="width:758px;">&nbsp;</label>
		<label style="margin-left:10px;"><strong>Observações: <span id="anotacao_obrigatoria" style="display:none; float:right"> *</span></strong></label> <br />
		<textarea id="observacao_expansao" name="observacao_expansao" 
		class="form_estilo" style="width:734px; height:120px; margin-left:10px;"><?=$c->observacao_expansao?></textarea>
		<label style="width:758px;">&nbsp;</label>
		
	</div>
	<input name="submit2" id="submit2" type="submit" value="Alterar" style="width:90px; margin-left:669px;" />
	<?}?>
</form>
<div style="font-weight:normal;">
	<div id="abre_historico"><a href="#historico" onclick="VisualizarHistorico(1, <?=$id?>);">+ Visualizar Histórico</a><a name="historico"></a><br /></div>
	<div id="hist" style="margin-top:10px; font-weight:normal; text-transform:none;"></div>
</div>
<?
if($erro_sb == 1){echo "<script>document.getElementById('anotacao_obrigatoria').style.display = 'block';</script>";}
if($erro_dt == 1){echo "<script>document.getElementById('reuniao_agendada').style.display = 'block';</script>";}
?>