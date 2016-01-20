<? $dt = $franquia->upload_empresa(2,$c->id_empresa,0,'');
$total = count($dt);
if($total > 0){ ?>
	<label style="width:150px">Arquivos Cadastrados:</label><br /><br />
	<? foreach ($dt as $f) {  ?>
		<label>&nbsp;</label><a href="../uploads/<?=$f->arquivo?>" target="_blank">- <?=$f->arquivo?></a>
		<?if(in_array(4, $departamento_s) || in_array(1, $departamento_s)) {?>
		&nbsp;&nbsp;&nbsp;<a href="../controle/franquias_editar.php?id=<?=$c->id_empresa?>&id_upl=<?=$f->id_empresa_upl?>&implatacacao=<?=$c->id_implantacao?>">excluir</a>
		<?}?>
		<br />
<? } echo '<br /><br />'; } else { echo 'Nenhum arquivo encontrado<br /><br />'; } 
if(in_array(4, $departamento_s) || in_array(1, $departamento_s)) {?>
<label>Upload de Arquivos</label><input type="file" name="arquivo" id="arquivo" /><br />
<input type="hidden" name="id_implantacao" id="id_implantacao" value="13" />
<input type="submit" class="button_busca" value="cadastrar" /><?}?>