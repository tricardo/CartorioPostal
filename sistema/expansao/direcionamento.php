<? require('topo.php'); 
$exp_item->acao = 3;
$exp_item = $expansao->verAcessoExec($exp_item);
if($exp_item->acesso == 0){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	require('rodape.php');
	exit;
}  ?>
<form action="direcionamento.php" id="form1" name="form1" method="post">
<table width="100%" border="0" cellspacing="2" cellpadding="0" style="float:left; color:#333;">
	<tr>
		<td> 
			<div class="busca1">
				<label>Consultor: </label>
				<? $c->sem_consultor = 1; $expansao->carregar_consultor($exp_item, $c); $c->sem_consultor = 0; ?><br />
				<label>UF:</label>
				<select name="uf" id="uf" class="form_estilo" style="width:100px;">
					<? $c->acao = 'uf';
					$dt = $expansao->carregar_combo($c); $cont = 0;
					foreach($dt as $b => $res){ 
						echo (count($dt) > 1 && $cont == 0) ? '<option value="">--</option>' . "\n" : ''; $cont++;
						echo "\t\t\t\t\t".'<option value="'.$res->estado_interesse.'"'.(($c->uf == $res->estado_interesse) ? 
							' selected="selected"' : '').'>'.$res->estado_interesse.'</option>' . "\n";
					} ?>
				</select><br />
				<label>Cidade:</label>
				<input value="<?=$c->cidade?>" type="text" name="cidade" id="cidade" class="form_estilo" style="width:197px;" maxlength="50" /><br />				
				<label>Status: </label>
				<? $expansao->carregar_status($exp_item, $c); ?><br />
				<label>Nº Ficha: </label>
				<input value="<?=$c->id_ficha2?>" type="text" name="id_ficha2" id="id_ficha2" class="form_estilo" style="width:98px;" maxlength="8" /><br />
				<label>Nome: </label>
				<input value="<?=$c->nome?>" type="text" name="nome" id="nome" class="form_estilo" style="width:198px;" maxlength="50" /><br />
				<input type="submit" value="Buscar" name="btn" id="btn" class="button_busca" style="margin-right:3px;" onclick="document.getElementById('bt_acao').value='busca';document.getElementById('form1').submit()."	/>
			</div>
			<div class="busca2" style="margin-top:-95px;width:400px;">
				<label style="margin-left:3px">Direcionar para: </label>
				<? $exp_item->consultor2 = 1; $expansao->carregar_consultor2($exp_item, $c); ?><br />
				<input type="button" value="Direcionar" name="btn2" id="btn2" class="button_busca" style="margin-left:110px;" onclick="document.getElementById('bt_acao').value='direcionar';document.getElementById('form1').submit();" />
				<input type="button" value="Duplicidade" name="btn3" id="btn3" class="button_busca" onclick="document.getElementById('bt_acao').value='duplicidade';document.getElementById('form1').submit();" />
				<input type="hidden" name="bt_acao" id="bt_acao" />
				<input type="hidden" id="pagina" name="pagina" value="<? echo isset($_GET['pagina']) ? $_GET['pagina'] : $c->pagina ?>" />
			</div>
			
		</td>
	</tr>
</table><br style="clear:both" /><br /><br />
<? if($c->bt_acao == 'direcionar' || $c->bt_acao == 'duplicidade'){
	if(is_array($c->id_ficha)){
		switch($c->bt_acao){
			case 'direcionar':
				if($c->consultor2 > 0){
					$expansao->direcionar($c);
				} else {
					echo "<script>alert('Selecione um consultor para prosseguir!');</script>";
				}
				break;
			default:
				for($i = 0; $i < count($c->id_ficha); $i++){ $c->duplicidades .= $c->id_ficha[$i] . ';'; }
				$expansao->excluir_duplicidade($c->c_id_usuario,$c->duplicidades);
		}
	} else {
		echo "<script>alert('Selecione um registro para prosseguir!');</script>";
	}
}
$dt = $expansao->direcionamento($c);?>
<div>
	<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
		<tr>
			<td colspan="9" class="barra_busca"><? $expansao->QTDPagina(); ?></td>
		</tr>
		<tr>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:50px;"></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;">
				<img src="../images/botoes/check2.png" id="checkbox_buttom" onclick="CheckAll('id_ficha[]');" />
				<input type="hidden" value="1" name="checkbox_image" id="checkbox_image" />
			</td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"><b>Editar</b></td>
			<td class="result_menu" style="background-color:#FFF"><b>Nome</b></td>
			<td class="result_menu" style="background-color:#FFF"><b>Consultor</b></td>
			<td class="result_menu" style="background-color:#FFF"><b>Cidade/UF</b></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:150px;"><b>Status</b></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:80px;"><b>Cadastro</b></td>
		</tr>
		<? $i = 0;
		foreach($dt as $b => $res){ ?>
		<tr>
			<td class="result_celula" style="text-align:center"><?=$res->id_ficha?></td>
			<td class="result_celula" style="text-align:center"><input type="checkbox" class="form_estilo" value="<?=$res->id_ficha?>" id="id_ficha<?=$i?>" name="id_ficha[]" /></td>
			<td class="result_celula" style="text-align:center"><a href="fichas-imprimir.php?id_ficha=<?=$res->id_ficha?>" target="_blank"><img src="../images/botoes/imprimir.png" style="width:22px;height:22px;" /></a></td>
			<td class="result_celula" style="text-align:center"><a href="fichas-editar.php?id_ficha=<?=$res->id_ficha?>&pg_clk=direcionamento"><img src="../images/botao_editar.png" /></a></td>
			<td class="result_celula"><?=ucwords($res->nome)?></td>
			<td class="result_celula"><?=$res->consultor?></td>
			<td class="result_celula"><?=ucwords(substr($res->cidade,0,100)).' / '.$res->uf?></td>
			<td class="result_celula" style="text-align:center;"><?=ucwords($res->status)?></td>
			<td class="result_celula" style="text-align:center;"><?=$res->data?></td>
		</tr>
		<? $i++; } ?>
		<tr>
			<td colspan="9" class="barra_busca"><? $expansao->QTDPagina(); ?></td>
		</tr>
	</table>
</div>
</form>
<? require('rodape.php'); ?>