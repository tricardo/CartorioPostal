<? require('topo.php'); 
$exp_item->acao = 3;
$exp_item = $expansao->verAcessoExec($exp_item);
if($exp_item->acesso == 0){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	require('rodape.php');
	exit;
} ?>
<form action="duplicidades.php" id="form1" name="form1" method="post">
<? $id_ficha = array();
$c->finalizado = 1;
if($c->duplicidades != ''){ $expansao->excluir_duplicidade($c->c_id_usuario,$c->duplicidades); }
$dt = $expansao->duplicidades_verifica($exp_item, $c); $cont = 0; ?>
<div>
	<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
		<tr>
			<td colspan="10" class="barra_busca"><? $expansao->QTDPagina(); ?></td>
		</tr>
		<? foreach($dt as $b => $res){ 
			$id_ficha[] = $res->id_ficha;
			$dt1 = $expansao->duplicidade($id_ficha,$res->email); 
			if(count($dt1) > 0){ $cont++; ?>
				<?if($cont == 1){?>
				<tr>
					<td colspan="10" class="barra_busca" style="border-bottom:none">
						Os campos selecionados serão considerados duplicidades e serão varridos do sistema.
							<input type="button" class="button_busca" value="Duplicidade" onclick="excluir_duplicidades()" />
					</td>
				</tr>
				<tr>
					<td class="result_menu" style="background-color:#FFF;text-align:center;width:50px;"></td>
					<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"></td>
					<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"></td>
					<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"><b>Editar</b></td>
					<td class="result_menu" style="background-color:#FFF"><b>Nome</b></td>
					<td class="result_menu" style="background-color:#FFF"><b>E-mail</b></td>
					<td class="result_menu" style="background-color:#FFF"><b>Consultor</b></td>
					<td class="result_menu" style="background-color:#FFF"><b>Cidade/UF</b></td>
					<td class="result_menu" style="background-color:#FFF;text-align:center;width:150px;"><b>Status</b></td>
					<td class="result_menu" style="background-color:#FFF;text-align:center;width:80px;"><b>Cadastro</b></td>
				</tr>
				<?}?>
				<tr>
					<td class="result_celula" style="text-align:center"><?=$res->id_ficha?></td>
					<td class="result_celula" style="text-align:center"><input type="checkbox" name="dups" value="<?=$res->id_ficha?>" /></td>
					<td class="result_celula" style="text-align:center"><a href="fichas-imprimir.php?id_ficha=<?=$res->id_ficha?>" target="_blank"><img src="../images/botoes/imprimir.png" style="width:22px;height:22px;" /></a></td>
					<td class="result_celula" style="text-align:center"><a href="fichas-editar.php?id_ficha=<?=$res->id_ficha?>&&pg_clk=duplicidades"><img src="../images/botao_editar.png" /></a></td>
					<td class="result_celula"><?=ucwords($res->nome)?></td>
					<td class="result_celula"><?=strtolower($res->email)?></td>
					<td class="result_celula"><?=$res->consultor?></td>
					<td class="result_celula"><?=ucwords(substr($res->cidade,0,100)).' / '.$res->uf?></td>
					<td class="result_celula" style="text-align:center;"><?=ucwords($res->status)?></td>
					<td class="result_celula" style="text-align:center;"><?=$res->data?></td>
				</tr>
				<? $i = 1; foreach($dt1 as $b1 => $res1){ 
					$id_ficha[] = $res1->id_ficha;
					$borda = ($i == count($dt1)) ? ';border-bottom:2px solid #CCC' : ''; ?>
					<tr>
						<td class="result_celula" style="text-align:center<?=$borda?>"><?=$res1->id_ficha?></td>
						<td class="result_celula" style="text-align:center<?=$borda?>"><input type="checkbox" name="dups" value="<?=$res1->id_ficha?>" /></td>
						<td class="result_celula" style="text-align:center"><a href="fichas-imprimir.php?id_ficha=<?=$res->id_ficha?>" target="_blank"><img src="../images/botoes/imprimir.png" style="width:22px;height:22px;" /></a></td>
						<td class="result_celula" style="text-align:center<?=$borda?>"><a href="fichas-editar.php?id_ficha=<?=$res1->id_ficha?>&&pg_clk=duplicidades"><img src="../images/botao_editar.png" /></a></td>
						<td class="result_celula" style="text-align:left<?=$borda?>"><?=ucwords($res1->nome)?></td>
						<td class="result_celula" style="text-align:left<?=$borda?>"><?=strtolower($res1->email)?></td>
						<td class="result_celula" style="text-align:left<?=$borda?>"><? $dt2 = $expansao->usuario($res->id_usuario);
							echo $dt2[0]->nome; ?></td>
						<td class="result_celula" style="text-align:left<?=$borda?>"><?=ucwords(substr($res1->cidade,0,100)).' / '.$res1->uf?></td>
						<td class="result_celula" style="text-align:center<?=$borda?>"><?=ucwords($res1->status)?></td>
						<td class="result_celula" style="text-align:center<?=$borda?>"><?=$res1->data?></td>
					</tr>
				<? $i++; } ?>
				
		<? }} 
		if($cont > 0){?>
		<tr>
			<td colspan="10" class="barra_busca" style="border-bottom:none">
				Os campos selecionados serão considerados duplicidades e serão varridos do sistema.
					<input type="button" class="button_busca" value="Duplicidade" onclick="excluir_duplicidades()" />
					<input type="hidden" id="duplicidades" name="duplicidades" />
					<input type="hidden" id="pagina" name="pagina" value="<? echo isset($_GET['pagina']) ? $_GET['pagina'] : $c->pagina ?>" />
			</td>
	    </tr>
		<?} else {?>
		<tr>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:50px;"></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"><b>Editar</b></td>
			<td class="result_menu" style="background-color:#FFF"><b>Nome</b></td>
			<td class="result_menu" style="background-color:#FFF"><b>E-mail</b></td>
			<td class="result_menu" style="background-color:#FFF"><b>Consultor</b></td>
			<td class="result_menu" style="background-color:#FFF"><b>Cidade/UF</b></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:150px;"><b>Status</b></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:80px;"><b>Cadastro</b></td>
		</tr>
		<? } ?>
		<tr>
			<td colspan="10" class="barra_busca"><? $expansao->QTDPagina(); ?></td>
		</tr>
	</table>
</div>
</form>
<? require('rodape.php'); ?>