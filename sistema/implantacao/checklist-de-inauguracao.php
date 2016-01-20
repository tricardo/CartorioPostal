<? $pagina = array(2,3,5,6,7,8,9);
$progresso = $franquia->validar_processo($c, $permissao_admin, $pagina);?>
<table>
<tr id="tr_implantacao">
	<td style="width:30px">&nbsp;</td>
	<td style="width:239px;">&nbsp;Item</td>
	<td>&nbsp;Situação</td>
</tr>
<?
$dt = $franquia->checklist(9, 1); $j = 0; $i = 0;
foreach ($dt as $f) { 
	$dt1 = $franquia->checklist_edit(9,$f->id_empresa_chk,$c->id_empresa); 
	$item = '';
	if(count($dt1) > 0){
		$ativo = ($dt1[0]->ativo == 1) ? ' checked="checked"' : '';
		$item = $dt1[0]->item;
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
			&nbsp;<input id="itemi<?=$i?>" name="itemi<?=$i?>" type="text" class="form_estilo" value="<?=$item?>" />
		<? } elseif($permissao_admin == 'TRUE'){?>
			&nbsp;<input id="itemi<?=$i?>" name="itemi<?=$i?>" type="text" class="form_estilo" value="<?=$item?>" />
		<? } else { echo '&nbsp;'.$item; } ?>
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
			<input type="button" value="Editar" class="button_busca" style="margin-left:10px" onclick="alterar_implantacao(9)" />
			<input type="hidden" value="<?=$i?>" name="totali" id="totali" />
			<input type="hidden" value="<?=$j?>" name="totalj" id="totalj" />
		<? } elseif($permissao_admin == 'TRUE'){?>
			<input type="button" value="Editar" class="button_busca" style="margin-left:10px" onclick="alterar_implantacao(9)" />
			<input type="hidden" value="<?=$i?>" name="totali" id="totali" />
			<input type="hidden" value="<?=$j?>" name="totalj" id="totalj" />
		<? } ?>
	</td>
</tr>
</table>