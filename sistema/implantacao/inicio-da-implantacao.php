<? $pagina = array(2);
$progresso = $franquia->validar_processo($c, $permissao_admin, $pagina); ?>
<table>
<tr id="tr_implantacao">
	<td style="width:30px">&nbsp;</td>
	<td style="width:250px;">&nbsp;Documentos</td>
	<td style="width:100px;">&nbsp;Datas</td>
	<td style="width:289px;">&nbsp;Observações</td>
</tr>
<?
$dt = $franquia->checklist(2, 1); $i = 0;
foreach ($dt as $f) { 
	$dt1 = $franquia->checklist_edit(2,$f->id_empresa_chk,$c->id_empresa);
	$ativo = ''; $data = ''; $observacao = '';
	if(count($dt1) > 0){
		$ativo = ($dt1[0]->ativo == 1) ? ' checked="checked"' : '';
		$data = ' value="'.$dt1[0]->data1.'"';
		$observacao = ' value="'.$dt1[0]->observacao.'"';
	} ?>
<tr>
	<td style="text-align:center">
		<? if($progresso < 100){?>
			<input type="checkbox" name="ativo<?=$i?>" id="ativo<?=$i?>"<?=$ativo?> />
			<input type="hidden" value="<?=$f->id_empresa_chk?>" name="registroi<?=$i?>" id="registroi<?=$i?>" />
		<? } elseif($permissao_admin == 'TRUE'){?>
			<input type="checkbox" name="ativo<?=$i?>" id="ativo<?=$i?>"<?=$ativo?> />
			<input type="hidden" value="<?=$f->id_empresa_chk?>" name="registroi<?=$i?>" id="registroi<?=$i?>" />
		<? } ?>
	</td>
	<td>&nbsp;<?=$f->item?></td>
	<td>
		<? if($progresso < 100){?>
			&nbsp;<input id="datai<?=$i?>" name="datai<?=$i?>" type="text" class="form_estilo" style="width:90px;"<?=$data?> />
			<script>$('#datai<?=$i?>').mask('99/99/9999');</script>
		<? } elseif($permissao_admin == 'TRUE'){?>
			&nbsp;<input id="datai<?=$i?>" name="datai<?=$i?>" type="text" class="form_estilo" style="width:90px;"<?=$data?> />
			<script>$('#datai<?=$i?>').mask('99/99/9999');</script>
		<? } else { echo '&nbsp;'.str_replace('"','',str_replace('value=','',$data)); } ?>
	</td>
	<td>
		<? if($progresso < 100){?>
			&nbsp;<input id="observacao<?=$i?>" name="observacao<?=$i?>" type="text" class="form_estilo" style="width:270px;"<?=$observacao?> />
		<? } elseif($permissao_admin == 'TRUE'){?>
			&nbsp;<input id="observacao<?=$i?>" name="observacao<?=$i?>" type="text" class="form_estilo" style="width:270px;"<?=$observacao?> />
		<? } else { echo '&nbsp;'.str_replace('"','',str_replace('value=','',$observacao)); } ?>
	</td>
</tr>
<? $i++; } 
	$dt = $franquia->checklist(2, 0); $j = 0;
	foreach ($dt as $f) { 
		$dt1 = $franquia->checklist_edit(2,$f->id_empresa_chk,$c->id_empresa); $data = '';
		if(count($dt1) > 0){
			$data = ' value="'.$dt1[0]->data1.'"';
		} ?>
<tr>
	<td colspan="4">
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
	<td colspan="2" style="height:40px">&nbsp;&nbsp;&nbsp;<strong>Progresso desta implantação:</strong></td>
	<td colspan="2"><div style="width:200px; border:solid 1px #222;">
		<div style="width:<?=$progresso*2?>px;background-color:#33CC00;text-align:center;"><?=round($progresso)?>%</div>
	</div></td>
</tr>
<tr>
	<td colspan="4">
		<? if($progresso < 100){?>
			<input type="button" value="Editar" class="button_busca" style="margin-left:10px" onclick="alterar_implantacao(2)" />
			<input type="hidden" value="<?=$i?>" name="totali" id="totali" />
			<input type="hidden" value="<?=$j?>" name="totalj" id="totalj" />
		<? } elseif($permissao_admin == 'TRUE'){?>
			<input type="button" value="Editar" class="button_busca" style="margin-left:10px" onclick="alterar_implantacao(2)" />
			<input type="hidden" value="<?=$i?>" name="totali" id="totali" />
			<input type="hidden" value="<?=$j?>" name="totalj" id="totalj" />
		<? } ?>
	</td>
</tr>
</table>