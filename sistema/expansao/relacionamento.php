<? require('topo.php'); 
$exp_item->acao = 4;
$exp_item = $expansao->verAcessoExec($exp_item); 
if($exp_item->acesso == 0){
	if($exp_item->id_usuario != 1){
		if($exp_item->id_usuario != 56){
			echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
			require('rodape.php');
			exit;
		}
	}
} ?>
<form action="relacionamento.php" id="form1" name="form1" method="post">
<table width="100%" border="0" cellspacing="2" cellpadding="0" style="float:left; color:#333;">
	<tr>
		<td>
			<div class="busca1">
				<label>Consultor: </label>
				<select id="consultor" name="consultor" class="form_estilo" style="width:200px;">
					<option value="0">--</option>
				<? $dt = $expansao->carregar_consultor_relacionamento($exp_item, $c); foreach($dt as $b => $res){?>
					<option value="<?=$res->id_usuario?>"<?=($res->id_usuario == $c->consultor) ? ' selected="selected"':''?>><?=$res->nome?></option>
				<? } ?>	
				</select><br />
				<label>Ano:</label>
				<select name="ano" id="ano" class="form_estilo" style="width:100px;">
					<? $c->acao = 'data';
					$c->ano = ($c->ano == '') ? date('Y') : $c->ano;
					$dt = $expansao->carregar_combo($c);
					for($i = $dt[0]->data; $i <= date('Y'); $i++){ 
						echo "\t\t\t\t\t" . '<option value="'.$i.'" '.(($i == $c->ano) ? 
							'selected="selected"' : '').'>'.$i.'</option>'; 
					} ?>
				</select><br />
				<label>Dia:</label>
				<select id="dia" name="dia" class="form_estilo" style="width:100px;">
					<option value="0">--</option>
					<?for($i = 1; $i <= 31; $i++){?>
						<option value="<?=($i < 10) ? '0'.$i : $i;?>"<?=((int)$c->dia == $i) ? ' selected="selected"':''?>><?=($i < 10) ? '0'.$i : $i;?></option>
					<? } ?>
				</select><br />
				<label>Mês:</label>
				<select id="mes" name="mes" class="form_estilo" style="width:200px;">
				<? $c->mes = ($c->mes == '') ? date('m') : $c->mes; 
				$mes = array('01','02','03','04','05','06','07','08','09','10','11','12');
				$mesn = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
				for($i = 0; $i < count($mes); $i++){ ?>
					<option value="<?=(int)$mes[$i]?>" <? echo ((int)$mes[$i] == $c->mes) ? 'selected="selected"' : '';?>><?=$mes[$i].' - '.$mesn[$i]?></option>
				<? }?>
				</select><br />				
				<input type="submit" value="Buscar" name="btn2" id="btn2" class="button_busca" />
			</div>
		</td>
	</tr>
</table><br style="clear:both" /><br /><br />
<? $dt = $expansao->relacionamento($exp_item, $c);
$mes = 0;
if(count($dt[0]) > 0){ 
	$link = ($c->ano == '' || $c->ano == 0) ? 'ano='.date('Y').'&' : 'ano='.$c->ano.'&';
	$link.= ($c->mes == '' || $c->mes == 0) ? 'mes=0&' : 'mes='.$c->mes.'&';
	$link.= ($c->dia == '' || $c->dia == 0) ? 'dia=0&' : 'dia='.$c->dia.'&';
	$link.= ($c->consultor == '' || $c->consultor == 0) ? 'consultor=0' : 'consultor='.$c->consultor;
	?>
<?if($c->consultor > 0){?>
<div>
	<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
		<tr>
			<td colspan="13" style="text-align:right" class="result_menu">
				<a href="relacionamento-imprimir.php?<?=$link?>" target="_blank">
					<img src="../images/botoes/imprimir.png" style="width:22px;height:22px;" />
				</a>
			</td>
		</tr>
		<? $consultor = 0; $mes = 0; $i = 0; $j = 0;
		foreach($dt as $b => $res){ ?>
			<?if($consultor != $res->id_consultor && $i == 0){?>
				<tr style="font-weight:bold">
					<td class="result_menu" style="border-bottom:2px solid #CCC">Consultor</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Dia</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Fichas</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Tem Inter.</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Agend.</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">E-mail</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Não Atende</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Reunião</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Skype</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Telefone</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Tel./E-mail</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Outros</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Total</td>
				</tr>
			<? $consultor = $res->id_consultor; $i++; }
			if($consultor != $res->id_consultor && $i > 0){ $j = 0;?>
				<tr style="font-weight:bold">
					<td class="result_celula" style="border-bottom:2px solid #CCC">Total</td>
					<td class="result_celula" style="border-bottom:2px solid #CCC">&nbsp;</td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$fichas?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$interesse?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$agendamento?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$email ?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$natend?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$reuniao?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$skype?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$telefone?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$emtel?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$outro?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=($interesse+$agendamento+
						$email+$natend+$reuniao+$skype+$telefone+$emtel+$outro)?></td>
				</tr>
				<tr style="font-weight:bold">
					<td class="result_menu">Consultor</td>
					<td class="result_menu" style="text-align:center;width:80px;">Dia</td>
					<td class="result_menu" style="text-align:center;width:80px;">Fichas</td>
					<td class="result_menu" style="text-align:center;width:80px;">Tem Inter.</td>
					<td class="result_menu" style="text-align:center;width:80px;">Agend.</td>
					<td class="result_menu" style="text-align:center;width:80px;">E-mail</td>
					<td class="result_menu" style="text-align:center;width:80px;">Não Atende</td>
					<td class="result_menu" style="text-align:center;width:80px;">Reunião</td>
					<td class="result_menu" style="text-align:center;width:80px;">Skype</td>
					<td class="result_menu" style="text-align:center;width:80px;">Telefone</td>
					<td class="result_menu" style="text-align:center;width:80px;">Tel./E-mail</td>
					<td class="result_menu" style="text-align:center;width:80px;">Outros</td>
					<td class="result_menu" style="text-align:center;width:80px;border-bottom:2px solid #CCC">Total</td>
				</tr>			
			<? $consultor = $res->id_consultor; $i++; 
			$email = 0;$natend = 0;$agendamento = 0;$skype = 0;$telefone = 0;$emtel = 0;$outro = 0;$reuniao =0; $fichas = 0; }?>
			<?if($mes != $res->mes){ $mes = $res->mes; $j++;
				if($j > 1){ ?>
				<tr style="font-weight:bold">
					<td class="result_celula" style="border-bottom:2px solid #CCC">Total</td>
					<td class="result_celula" style="border-bottom:2px solid #CCC">&nbsp;</td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$fichas?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$interesse?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$agendamento?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$email ?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$natend?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$reuniao?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$skype?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$telefone?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$emtel?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$outro?></td>
					<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=($interesse+$agendamento+
						$email+$natend+$reuniao+$skype+$telefone+$emtel+$outro)?></td>
				</tr>
				<? } ?>
				<tr>	
					<td colspan="13" class="result_menu" style="font-weight:bold"><?=ucwords($expansao->mes($mes)).' de '.$c->ano?></td>			
				</tr>
			<? $email = 0;$natend = 0;$agendamento = 0;$skype = 0;$telefone = 0;$emtel = 0;$outro = 0;$reuniao =0; $fichas = 0; $interesse = 0; } 
			$email = $email + $res->email;
			$natend = $natend + $res->natend;
			$agendamento = $agendamento + $res->agendamento;
			$skype = $skype + $res->skype;
			$telefone = $telefone + $res->telefone;
			$emtel = $emtel + $res->emtel;
			$outro = $outro + $res->outro;
			$reuniao = $reuniao + $res->reuniao;
			$dt1 = $expansao->fichaCadDia($res->data);
			$dt2 = $expansao->pegaInteressadosDia($res->id_usuario, $res->data);
			$fichas = $fichas + $dt1[0]->total;
			$interesse = $interesse + $dt2; ?>
			<tr>
				<td class="result_celula"><?=$res->consultor?></td>
				<td class="result_celula" style="text-align:center"><?=$res->dia?></td>
				<td class="result_celula" style="text-align:center"><?=$dt1[0]->total?></td>
				<td class="result_celula" style="text-align:center"><?=$dt2?></td>
				<td class="result_celula" style="text-align:center"><?=$res->agendamento?></td>
				<td class="result_celula" style="text-align:center"><?=$res->email?></td>
				<td class="result_celula" style="text-align:center"><?=$res->natend?></td>
				<td class="result_celula" style="text-align:center"><?=$res->reuniao?></td>
				<td class="result_celula" style="text-align:center"><?=$res->skype?></td>
				<td class="result_celula" style="text-align:center"><?=$res->telefone?></td>
				<td class="result_celula" style="text-align:center"><?=$res->emtel?></td>
				<td class="result_celula" style="text-align:center"><?=$res->outro?></td>
				<td class="result_celula" style="text-align:center"><?=$dt2+$res->agendamento+$res->email+
				$res->natend+$res->reuniao+$res->skype+$res->telefone+$res->emtel+$res->outro?></td>
			</tr>
		<? } #if($i > 1){?>
		<tr style="font-weight:bold;border-bottom:2px solid #CCC">
			<td class="result_celula" style="border-bottom:2px solid #CCC">Total</td>
			<td class="result_celula" style="border-bottom:2px solid #CCC">&nbsp;</td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$fichas?></td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$interesse?></td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$agendamento?></td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$email ?></td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$natend?></td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$reuniao?></td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$skype?></td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$telefone?></td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$emtel?></td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=$outro?></td>
			<td class="result_celula" style="text-align:center;border-bottom:2px solid #CCC"><?=($interesse+$agendamento+
						$email+$natend+$reuniao+$skype+$telefone+$emtel+$outro)?></td>
		</tr>	
		<?#}?>
	</table>
</div>
<? } ?>
<? } else { echo '<span style="color:#FF0000;">Nenhum registro encontrado.</span>'; } ?>
</form>
<? require('rodape.php'); ?>