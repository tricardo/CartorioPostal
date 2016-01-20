<? require('topo.php'); ?>
<form action="fichas.php" id="form1" name="form1" method="post">
<table width="100%" border="0" cellspacing="2" cellpadding="0" style="float:left; color:#333;">
	<tr>
		<td>
			<div class="busca1">
				<label>Consultor: </label>
				<? $expansao->carregar_consultor($exp_item, $c); ?><br />
				<label>Status: </label>
				<? $expansao->carregar_status($exp_item, $c); ?><br />
				<label>Cidade:</label>
				<input value="<?=$c->cidade?>" type="text" name="cidade" id="cidade" class="form_estilo" style="width:197px;" maxlength="50" /><br />
				<label>Mês:</label>
				<select id="mes" name="mes" class="form_estilo" style="width:200px;">
				<? $mes = array('','01','02','03','04','05','06','07','08','09','10','11','12');
				$mesn = array('','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
				for($i = 0; $i < count($mes); $i++){ ?>
					<option value="<?=$i?>" <? echo ($i == $c->mes) ? 'selected="selected"' : '';?>><?=($i > 0) ? $mes[$i].' - '.$mesn[$i] : '--'?></option>
				<? }?>
				</select><br />
			</div>
			<div class="busca2" style="margin-top:-95px;">
				<label>Nome: </label>
				<input value="<?=$c->nome?>" type="text" name="nome" id="nome" class="form_estilo" style="width:200px;" maxlength="50" /><br />
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
				<label>Ano:</label>
				<select name="ano" id="ano" class="form_estilo" style="width:100px;">
					<option value="0">--</option>
					<? $c->acao = 'data';
					$dt = $expansao->carregar_combo($c);
					for($i = $dt[0]->data; $i <= date('Y'); $i++){ 
						echo "\t\t\t\t\t" . '<option value="'.$i.'" '.(($i == $c->ano) ? 
							'selected="selected"' : '').'>'.$i.'</option>'; 
					} ?>
				</select><br />
				<label>Nº Ficha: </label>
				<input value="<?=$c->id_ficha?>" type="text" name="id_ficha" id="id_ficha" class="form_estilo" style="width:98px;" maxlength="8" />
				<input type="submit" value="Buscar" name="btn2" id="btn2" class="button_busca" />
			</div>
		</td>
	</tr>
</table><br style="clear:both" /><br /><br />
<? $dt = $expansao->consulta($exp_item, $c);?>
<div>
	<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
		<tr>
			<td colspan="8" class="barra_busca"><? $expansao->QTDPagina(); ?></td>
		</tr>
		<tr>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:50px;"></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"><b>Editar</b></td>
			<td class="result_menu" style="background-color:#FFF"><b>Nome</b></td>
			<td class="result_menu" style="background-color:#FFF"><b>Consultor</b></td>
			<td class="result_menu" style="background-color:#FFF"><b>Cidade/UF</b></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:150px;"><b>Status</b></td>
			<td class="result_menu" style="background-color:#FFF;text-align:center;width:80px;"><b>Cadastro</b></td>
		</tr>
		<?
		$data1 = date('Y-m-d', strtotime("-30 days"));
		$data2 = date('Y-m-d', strtotime("+30 days"));
		foreach($dt as $b => $res){ ?>
		<tr>
			<td class="result_celula" style="text-align:center"><?=$res->id_ficha?></td>
			<td class="result_celula" style="text-align:center"><a href="fichas-imprimir.php?id_ficha=<?=$res->id_ficha?>" target="_blank"><img src="../images/botoes/imprimir.png" style="width:22px;height:22px;" /></a></td>
			<td class="result_celula" style="text-align:center"><a href="fichas-editar.php?id_ficha=<?=$res->id_ficha?>&pg_clk=fichas"><img src="../images/botao_editar.png" /></a></td>
			<td class="result_celula"><?=ucwords($res->nome)?></td>
			<td class="result_celula"><?=$res->consultor?></td>
			<td class="result_celula"><?=ucwords(substr($res->cidade,0,100)).' / '.$res->uf?></td>
			<td class="result_celula" style="text-align:center;"><?=ucwords($res->status)?></td>
			<td class="result_celula" style="text-align:center;"><?=$res->data?></td>
		</tr>
		<? /*$res->id_administrador = $exp_item->id_usuario;
		$dt1 = $expansao->listaRelacionamento($res,$data1,$data2);
		if(count($dt1) > 0){ ?>
		<tr>
			<td colspan="8" style="border:0;padding:0;margin:0;border-bottom:3px solid #CCC;">
				<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela" style="border:0;padding:0;margin:0">
					<?$i = 0; foreach($dt1 as $b1 => $res1){
					$data = explode('/',$res1->data_reuniao);?>
					<tr>
						<td class="result_celula" style="background-color:#FFFFCC;text-align:center;width:98px;border-left:none;<?=($i == 0) ? 'border-top:none' : ''?>"><?=$res1->id_ficha?></td>
						<td class="result_celula" style="background-color:#FFFFCC;text-align:center;width:40px"><a href="agenda.php?dia=<?=$data[0]?>&mes=<?=$data[1]?>&ano=<?=$data[2]?>&busc_agenda=1"><img src="../images/lupa.png" style="width:22px;height:22px" /></a></td>
						<td class="result_celula" style="background-color:#FFFFCC;<?=($i == 0) ? 'border-top:none' : ''?>"><?=$res1->consultor?> (Relacionamento)</td>						
						<td class="result_celula" style="background-color:#FFFFCC;text-align:center;width:150px;<?=($i == 0) ? 'border-top:none' : ''?>"><?=$res1->status?></td>
						<td class="result_celula" style="background-color:#FFFFCC;width:79px;text-align:center;border-right:none;<?=($i == 0) ? 'border-top:none' : ''?>">
							<?=$res1->data_reuniao?></td>
					</tr>
					<? $i++; } ?>
				</table>
			</td>
		</tr>	
		<? } */ } ?>
		<tr>
			<td colspan="8" class="barra_busca"><? $expansao->QTDPagina(); ?></td>
		</tr>
	</table>
</div>
</form>
<? require('rodape.php'); ?>