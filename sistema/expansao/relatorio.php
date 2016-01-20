<? require('topo.php'); 
$acesso_relatorio = array(1,56, 272);
if(!in_array($controle_id_usuario,$acesso_relatorio)){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	require('rodape.php');
	exit;
}
?>
<form action="relatorio.php" id="form1" name="form1" method="post">
<table width="100%" border="0" cellspacing="2" cellpadding="0" style="float:left; color:#333;" id="tab1">
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
				<? #if($controle_id_usuario == 1){ ?>
					<script>
						function imprimir_pagina() {
							document.getElementById('tab1').style.display = 'none';
							document.getElementById('tr1').style.display = 'none';
							document.getElementById('tr2').style.display = 'none';
							window.print();
							document.location.reload();
						}
					</script>
					<br /><input type="button" value="Imprimir" name="btn3" id="btn3" class="button_busca" onclick="imprimir_pagina()" />
				<? # } ?>
				<input type="submit" value="Buscar" name="btn2" id="btn2" class="button_busca" />
			</div>
		</td>
	</tr>
</table><br style="clear:both" /><br /><br />
<? $dt = $expansao->consulta($exp_item, $c);?>
<div>
	<table width="100%" cellpadding="4" cellspacing="1" id="tab2" style="background-color: #D5D5D5; border: 0px; color:#000; font-size: 12px">
		<tr id="tr1">
			<td colspan="6" style="background: #B8B8B8;"><? $expansao->QTDPagina(); ?></td>
		</tr>
		<tr>
			<td style="background-color:#FFF;text-align:center;width:50px;background: #F5F5F5;"></td>
			<td style="background-color:#FFF;background: #F5F5F5;"><b>Nome</b></td>
			<td style="background-color:#FFF;background: #F5F5F5;"><b>Consultor</b></td>
			<td style="background-color:#FFF;background: #F5F5F5;"><b>Cidade/UF</b></td>
			<td style="background-color:#FFF;text-align:center;width:150px;background: #F5F5F5;"><b>Status</b></td>
			<td style="background-color:#FFF;text-align:center;width:80px;background: #F5F5F5;"><b>Cadastro</b></td>
		</tr>
		<?
		$data1 = date('Y-m-d', strtotime("-30 days"));
		$data2 = date('Y-m-d', strtotime("+30 days"));
		foreach($dt as $b => $res){ ?>
		<tr>
			<td style="text-align:center; background: #FFFFFF; color:#000;"><?=$res->id_ficha?></td>
			<td style="background: #FFFFFF; color:#000;"><?=ucwords($res->nome)?><br><?=$res->email.'-'.ucwords($res->tel_res)?></td>
			<td style="background: #FFFFFF; color:#000;"><?=$res->consultor?></td>
			<td style="background: #FFFFFF; color:#000;"><?=ucwords(substr($res->cidade,0,100)).' / '.$res->uf?></td>
			<td style="text-align:center; background: #FFFFFF; color:#000;"><?=ucwords($res->status)?></td>
			<td style="text-align:center; background: #FFFFFF; color:#000;"><?=$res->data?></td>
		</tr>
		<? $dt1 = $expansao->relatorio_atividade($res->id_ficha);
		if(count($dt1) > 0){ ?>
		<tr>
			<td colspan="6" style="background-color:#F0F0F0;margin:0; padding:0">
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td colspan="4" style="border-bottom:solid 1px #CCC; font-weight:bold;height:30px;">
							&nbsp;Atividades da Ficha N.º <?=$res->id_ficha?></td>
					</tr>
				<? foreach($dt1 as $b1 => $res1){ ?>
					<tr>
						<td style="border-bottom:solid 1px #CCC;border-right:solid 1px #CCC;text-align:center;width:120px;height:30px">
							<? $data = explode(' ',$res1->data_inclusao);
							$hora = $data[1];
							$data = explode('-', $data[0]);
							echo $data[2].'/'.$data[1].'/'.$data[0].' '.$hora; ?>
						</td>
						<td style="border-bottom:solid 1px #CCC;border-right:solid 1px #CCC;width:180px;">
							&nbsp;&nbsp;<? $st1 = $expansao->PegaStatus($res1->id_status);
							echo $st1[0]->status; ?>
						</td>
						<td style="border-bottom:solid 1px #CCC;border-right:solid 1px #CCC;width:150px;">
							&nbsp;&nbsp;<? $us1 = $expansao->usuario($res1->id_user_alt); 
								echo (strlen($us1[0]->nome) > 0) ? $us1[0]->nome : 'Sistema'; ?>
						</td>
						<td style="border-bottom:solid 1px #CCC;">
							&nbsp;&nbsp;
							<?if($res1->data_reuniao != '0000-00-00'){
								$data = explode('-', $res1->data_reuniao);
								echo $data[2].'/'.$data[1].'/'.$data[0] . ' - ';
							} echo $res1->observacao?>
						</td>
					</tr>
				<? } ?>
				</table>
			</td>
		</tr>
		<? }} ?>
		<tr id="tr2">
			<td colspan="6" style="background: #B8B8B8;"><? $expansao->QTDPagina(); ?></td>
		</tr>
	</table>
</div>
</form>
<? require('rodape.php'); ?>
