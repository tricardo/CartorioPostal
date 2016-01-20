<? $pagina = array(2,3,5,6,7,8);
$progresso = $franquia->validar_processo($c, $permissao_admin, $pagina);?>
<table>
<tr id="tr_implantacao">
	<td style="width:30px">&nbsp;</td>
	<td>&nbsp;Item</td>
	<td style="width:200px;">&nbsp;Data do Envio</td>
</tr>
<?
$dt = $franquia->checklist(8, 1); $j = 0; $i = 0;
foreach ($dt as $f) { 
	$dt1 = $franquia->checklist_edit(8,$f->id_empresa_chk,$c->id_empresa); $data = '';
	if(count($dt1) > 0){
		$ativo = ($dt1[0]->ativo == 1) ? ' checked="checked"' : '';
		$data1 = ' value="'.$dt1[0]->data1.'"';
		$data2 = ' value="'.$dt1[0]->data2.'"';
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
			&nbsp;<input id="datai1<?=$i?>" name="datai1<?=$i?>" type="text" class="form_estilo" style="width:90px;"<?=$data1?> />
			<script>$('#datai1<?=$i?>').mask('99/99/9999');</script>
		<? } elseif($permissao_admin == 'TRUE'){?>
			&nbsp;<input id="datai1<?=$i?>" name="datai1<?=$i?>" type="text" class="form_estilo" style="width:90px;"<?=$data1?> />
			<script>$('#datai1<?=$i?>').mask('99/99/9999');</script>
		<? } else { echo '&nbsp;'.str_replace('"','',str_replace('value=','',$data1)); } ?>
	</td>
</tr>
<? $i++; } ?>
<tr>
	<td colspan="2" style="height:40px">&nbsp;&nbsp;&nbsp;<strong>Progresso desta implantação:</strong></td>
	<td><div style="width:200px; border:solid 1px #222;">
		<div style="width:<?=$progresso*2?>px;background-color:#33CC00;text-align:center;"><?=round($progresso)?>%</div>
	</div></td>
</tr>
<tr>
	<td colspan="3">
		<? if($progresso < 100){?>
			<input type="button" value="Editar" class="button_busca" style="margin-left:10px" onclick="alterar_implantacao(8)" />
			<input type="hidden" value="<?=$i?>" name="totali" id="totali" />
			<input type="hidden" value="<?=$j?>" name="totalj" id="totalj" />
		<? } elseif($permissao_admin == 'TRUE'){?>
			<input type="button" value="Editar" class="button_busca" style="margin-left:10px" onclick="alterar_implantacao(8)" />
			<input type="hidden" value="<?=$i?>" name="totali" id="totali" />
			<input type="hidden" value="<?=$j?>" name="totalj" id="totalj" />
		<? } ?>
	</td>
</tr>
</table>