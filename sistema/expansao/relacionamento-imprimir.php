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
<br /><br />
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
<table width="100%" cellpadding="0" cellspacing="0"  style="position:relative;text-transform:uppercase">
	<tr>
		<td style="text-align:right;font-size:10px;">Cartório Postal - <?=date('d/m/Y H:i:s')?>&nbsp;&nbsp;</td>
	</tr>
</table><br /><br />
<script>window.print();</script>
<? require('rodape.php'); ?>