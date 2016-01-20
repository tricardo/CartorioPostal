<? require('header-ajax.php');
$cor = '#FFF';
$dt = $expansaos; $dt1 = $expansao;
$e = $dt->buscaHistorico($c->id);
$f = $dt1->buscaDataInclude($c->id);
if(count($e) > 0){ ?>
<p align="right" style="margin-right:20px">
	<!--<a href="#historico" onclick="VisualizarHistorico(0, 0);">X Fechar Histórico</a>-->
	<a href="#" onclick="document.getElementById('hist').style.display='none';document.getElementById('mstl').style.display='block';document.getElementById('mstbr').style.display='block';">X Fechar Histórico</a>
</p>
<div style="height:300px;widht:99%;overflow:auto;">
	<table cellspacing="0" cellpadding="1" style="border:solid 1px #0D357D; width:98%; border-bottom:none">
		  <tr style="background:#7BB2E4;">
			<td style="border:solid 1px #0D357D; border-top:none; border-left:none;font-weight:bold">&nbsp;Status</td>
			<td style="border:solid 1px #0D357D; border-top:none; border-left:none;font-weight:bold">&nbsp;Consultor</td>
			<td style="border:solid 1px #0D357D; border-top:none; border-left:none;font-weight:bold; width:280px;">&nbsp;Observações</td>
			<td style="border:solid 1px #0D357D; border-top:none; border-left:none;border-right:none;font-weight:bold; width:80px; text-align:center">Cadastrado</td>
		  </tr>
		<?  #$dt1->retornaUltimoStatus($c->id); 
		foreach($e as $j => $hst){ 
			$color = ($color == '#FFFFCA') ? '#FFF' : '#FFFFCA'; ?>
		  <tr style="background:<?=$color?>;">
			<td style="border:solid 1px #0D357D; border-top:none; border-left:none;font-size:11px">&nbsp;<?
				echo ($hst->status == 'Excluído') ? 'Arquivo Morto' : $hst->status;?></td>
			<td style="border:solid 1px #0D357D; border-top:none; border-left:none;font-size:11px">&nbsp;<? if($hst->id_user_alt == 0){ echo 'Sistema';	} else {
				$u = $dt1->pega_usuario($hst->id_user_alt);
				echo $u[0]->nome;
			}?></td>
			<td style="border:solid 1px #0D357D; border-top:none; border-left:none;font-size:11px">&nbsp;<?=$hst->observacao?> <?
			switch($hst->id_status){
				case 5: case 10: case 12: case 19:
					$data = explode('-', $hst->data_reuniao);
					$d = $data[2].'/'.$data[1].'/'.$data[0];
					echo ($d == '00/00/0000') ? '' : '<br />&nbsp;<b style="font-size:11px;">['.$d.']</b>';
				break; }?></td>
			<td style="border:solid 1px #0D357D; border-top:none; border-left:none;border-right:none;; text-align:center;font-size:11px"><?
			if($hst->data_inclusao == '0000-00-00 00:00:00'){
				$data = explode('-', $f->data);
				echo $data[2].'/'.$data[1].'/'.$data[0];
			} else {
				$d = explode(' ', $hst->data_inclusao);
				$data = explode('-', $d[0]);
				$hora = explode(':', $d[1]);
				echo $data[2].'/'.$data[1].'/'.$data[0] . ' ' . $hora[0].':'.$hora[1];
			}
			?></td>
		  </tr>
		<? 
		$cor = ($cor == '#FFF') ? $cor = '#FFEBAE' : $cor = '#FFF'; 
		} ?>
	</table>
</div>
<? } else {
	echo '<span style="color:#FF0000;">Nenhum registro cadastrado.</span>';
}?>