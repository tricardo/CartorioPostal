<? 
$progresso = $franquia->checklist_valida(2,$c->id_empresa);
$passo = (($progresso[1] * 100) / $progresso[0]);
if($permissao_admin == 'FALSE' && $passo < 100){
	echo '<br /><br /><span style="color:#FF0000">Voc� deve finalizar o passo 2 para dar continuidade a este 
		passo!</span><br /><br />&nbsp;';
	exit;
} else { 
	$progresso = $franquia->checklist_valida(3,$c->id_empresa);
	$passo = (($progresso[1] * 100) / $progresso[0]);
	if($permissao_admin == 'FALSE' && $passo < 100){
		echo '<br /><br /><span style="color:#FF0000">Voc� deve finalizar o passo anterior para dar continuidade a este 
				passo!</span><br /><br />&nbsp;';
		exit;
	}
}
$progresso = $franquia->checklist_valida(4,$c->id_empresa);
$progresso = (($progresso[1] * 100) / $progresso[0]);?>
<table>
<? $dt = $franquia->checklist(4, 0); $j = 0; $i = 0;
	foreach ($dt as $f) { 
		$dt1 = $franquia->checklist_edit(4,$f->id_empresa_chk,$c->id_empresa); $data = '';
		if(count($dt1) > 0){ $data = ' value="'.$dt1[0]->data1.'"'; } ?>
		<tr>
			<td colspan="2">
				<? if($progresso < 100){?>
					<label style="width:auto;text-align:left;margin-left:38px;font-weight:normal"><?=$f->item?></label>
						<input type="text" name="dataj<?=$j?>" id="dataj<?=$j?>" class="form_estilo" style="width:90px;"<?=$data?> />
						<input type="hidden" value="<?=$f->id_empresa_chk?>" name="registroj<?=$j?>" id="registroj<?=$j?>" />
						<script>$('#dataj<?=$j?>').mask('99/99/9999');</script>
				<? } elseif($permissao_admin == 'TRUE'){?>
					<label style="width:auto;text-align:left;margin-left:38px;font-weight:normal"><?=$f->item?></label>
						<input type="text" name="dataj<?=$j?>" id="dataj<?=$j?>" class="form_estilo" style="width:90px;"<?=$data?> />
						<input type="hidden" value="<?=$f->id_empresa_chk?>" name="registroj<?=$j?>" id="registroj<?=$j?>" />
						<script>$('#dataj<?=$j?>').mask('99/99/9999');</script>
				<? } else { ?>
					<label style="width:500px;font-weight:normal;text-align:left;margin-left:38px;">
						<?=$f->item.': '.str_replace('"','',str_replace('value=','',$data))?>
					</label>
				<? } ?>
			</td>
		</tr>
<? $j++; } ?>
<tr>
	<td style="height:40px">&nbsp;&nbsp;&nbsp;<strong>Progresso desta implanta��o:</strong></td>
	<td><div style="width:200px; border:solid 1px #222;">
		<div style="width:<?=$progresso*2?>px;background-color:#33CC00;text-align:center;"><?=round($progresso)?>%</div>
	</div></td>
</tr>
<tr>
	<td colspan="2">
		<? if($progresso < 100){?>
			<input type="button" value="Editar" class="button_busca" style="margin-left:10px" onclick="alterar_implantacao(4)" />
			<input type="hidden" value="<?=$i?>" name="totali" id="totali" />
			<input type="hidden" value="<?=$j?>" name="totalj" id="totalj" />
		<? } elseif($permissao_admin == 'TRUE'){?>
			<input type="button" value="Editar" class="button_busca" style="margin-left:10px" onclick="alterar_implantacao(4)" />
			<input type="hidden" value="<?=$i?>" name="totali" id="totali" />
			<input type="hidden" value="<?=$j?>" name="totalj" id="totalj" />
		<? } ?>
	</td>
</tr>
</table>