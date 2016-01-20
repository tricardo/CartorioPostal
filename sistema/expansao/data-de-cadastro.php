<? require('topo.php'); 

$exp_item->acao = 3;
$exp_item = $expansao->verAcessoExec($exp_item);
if($exp_item->acesso == 0){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	require('rodape.php');
	exit;
} 

if(isset($c->id_ficha)){
	$c->id_ficha = (int) $c->id_ficha;
} ?>
<form action="data-de-cadastro.php" id="form1" name="form1" method="post">
<table width="100%" border="0" cellspacing="2" cellpadding="0" style="float:left; color:#333;">
	<tr>
		<td>
			<div class="busca1" style="width:330px;">
				<label>N.º da Ficha: </label>
				<input type="text" name="id_ficha" id="id_ficha" class="form_estilo" maxlength="10" value="<?=$c->id_ficha?>" />
				<input type="submit" class="button_busca" value="buscar" name="btn" id="btn" onclick="document.getElementById('btn').value='buscar'" />
			</div>
		</td>
	</tr>
</table><br style="clear:both" /><br />
<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
	<tr>
		<td colspan="7" class="barra_busca"><? $expansao->QTDPagina(); ?></td>
	</tr>
	<tr>
		<td class="result_menu" style="background-color:#FFF;text-align:center;width:50px;"></td>
		<td class="result_menu" style="background-color:#FFF"><b>Nome</b></td>
		<td class="result_menu" style="background-color:#FFF"><b>Consultor</b></td>
		<td class="result_menu" style="background-color:#FFF"><b>Cidade/UF</b></td>
		<td class="result_menu" style="background-color:#FFF;text-align:center;width:150px;"><b>Status</b></td>
		<td class="result_menu" style="background-color:#FFF;text-align:center;width:80px;"><b>Data</b></td>
		<td class="result_menu" style="background-color:#FFF;text-align:center;width:100px;"></td>
	</tr>
	<? if(isset($c->id_ficha)){ 
		if(isset($c->id_datacad) && $c->btn == ''){
			if($c->id_datacad != ''){
				$data = explode('/',$c->id_datacad);
				if(checkdate($data[1], $data[0], $data[2])){				
					$expansao->data_de_cadastro(2,$c);
				} else {
					echo "<script>openAlertBox('Data de Cadastro','Digite uma data válida!','data-de-cadastro.php?id_ficha=".$c->id_ficha."');</script>";
				}
			} else {
				echo "<script>openAlertBox('Data de Cadastro','Digite uma data válida!','data-de-cadastro.php?id_ficha=".$c->id_ficha."');</script>";
			}
		}
	
		$dt = $expansao->data_de_cadastro(1,$c);		
		foreach($dt as $b => $res){ 
			$data = explode('/',$res->data);
			$dia  = ($data[0] < 10) ? '0'.$data[0] : $data[0];
			$mes  = ($data[1] < 10) ? '0'.$data[1] : $data[1];
			$data = $dia.'/'.$mes.'/'.$data[2];?>
			<tr>
				<td class="result_celula" style="text-align:center"><?=$res->id_ficha?></td>
				<td class="result_celula"><?=ucwords($res->nome)?></td>
				<td class="result_celula"><?=$res->consultor?></td>
				<td class="result_celula"><?=ucwords(substr($res->cidade,0,100)).' / '.$res->uf?></td>
				<td class="result_celula" style="text-align:center;"><?=ucwords($res->status)?></td>
				<td class="result_celula" style="text-align:center;"><?=$res->data?></td>
				<td class="result_celula" style="text-align:center;">
					<input style="width:65px;" type="text" name="id_datacad" id="id_datacad" class="form_estilo" maxlength="10" value="<?=$data?>" />
					<input type="button" style="width:20px;" class="button_busca" value="ok" name="btn" id="btn" onclick="document.getElementById('form1').submit();document.getElementById('btn').value='data'" />
					<script>$('#id_datacad').mask('99/99/9999');</script>
				</td>
			</tr>
	<? }
	} ?>
	<tr>
		<td colspan="7" class="barra_busca"><? $expansao->QTDPagina(); ?></td>
	</tr>
</table>
</form>
<? require('rodape.php'); ?>