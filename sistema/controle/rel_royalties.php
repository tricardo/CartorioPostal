<?php
if ($_POST['submit']) {
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );

	if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE' and verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' or $controle_id_empresa!=1){
		echo '<br><br><strong>Voc� n�o tem permiss�o para acessar essa p�gina</strong>';
		exit;
	}
	
	pt_register('POST','mes');
	pt_register('POST','ano');
	if($ano == '')$ano = date('Y');
	if($mes == '')$mes = date('m');
	
	$data_sem = $ano.'-'.$mes.'-31';
	$relatorioDAO = new RelatorioDAO();
	$royalties = $relatorioDAO->listaRoyalties($ano,$mes);
	
	$nomeArquivo = "royalties_".$ano."_".$mes.".csv";
	$arquivoDiretorio = "./exporta/".$nomeArquivo;

	$arquivoConteudo = 'Refer�ncia;'.$mes.'/'.$ano.';
Franquia;Royalties;Fundo de Propaganda;Faturamento;Despesa;Tipo
';
	$roy_t = 0;
	$fpp_t = 0;
	$fat_t = 0;
	$des_t = 0;
	foreach($royalties as $i=>$roy){
	
		if($roy->fixo==''){
			#$t_sub_pagar = (float)((float)($roy->faturamento)-(float)((float)($roy->faturamento)/100*(float)($roy->imposto)))-(float)($roy->despesa);
			#$roy->valor_royalties = (float)((float)($t_sub_pagar)/100)*(float)($roy->royalties);
			$tipo_fat = $roy->royalties.'%';
			if($roy->imposto=='' or $roy->imposto=='0') $tipo_fat.=' do Bruto'; else $tipo_fat.=' do L�quido';
		} else {
			$tipo_fat = 'Fixo '.$roy->fixo.' semestre';
		}
		#$roy->valor_propaganda = (float)((float)($t_sub_pagar)/100)*(float)(2);
		

		$roy_t = (float)($roy_t)+(float)($roy->valor_royalties);
		$fpp_t = (float)($fpp_t)+(float)($roy->valor_propaganda);
		$fat_t = (float)($fat_t)+(float)($roy->faturamento);
		$des_t = (float)($des_t)+(float)($roy->despesa);
		$arquivoConteudo .= $roy->franquia.';'.number_format($roy->valor_royalties,2,",",".").';'.number_format($roy->valor_propaganda,2,",",".").';'.number_format($roy->faturamento,2,",",".").';'.number_format($roy->despesa,2,",",".").';'.$tipo_fat.'
';
		#$relatorioDAO->RelFixo($ano."-".$mes,$roy->valor_royalties,$roy->id_empresa,$semestre);	
		#$relatorioDAO->insertRelFixo($roy->id_empresa,$ano."-".$mes.'-01',$roy->valor_royalties,$roy->valor_propaganda,$roy->faturamento,$roy->despesa,$roy->imposto,$roy->royalties,$roy->fixo);
	}
		$arquivoConteudo .= 'Total;'.number_format($roy_t,2,",",".").';'.number_format($fpp_t,2,",",".").';'.number_format($fat_t,2,",",".").';'.number_format($des_t,2,",",".").'
';
	
	if(is_file($arquivoDiretorio)) {
		unlink($arquivoDiretorio);
	}	
	if(fopen($arquivoDiretorio,"w+")) {
		if (!$handle = fopen($arquivoDiretorio, 'w+')) {
			echo "<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
			exit;
		}
		if(!fwrite($handle, $arquivoConteudo)) {
			echo"<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ESCREVER NO ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
			exit;
		}
		header ("Content-type: octet/stream");
		header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
		header("Content-Length: ".filesize($arquivoDiretorio));
		readfile($arquivoDiretorio);
		die();
	} else {
		echo"<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
		exit;
	}
	
}else { 
require('header.php');
pt_register('POST','mes');
pt_register('POST','ano');
if($ano == '')$ano = date('Y');
if($mes == '')$mes = date("m", strtotime("-1 month"));;
?>
<div id="topo">
	<h1 class="tit">
	<img src="../images/tit/tit_cartorio.png" alt="T�tulo" />Relat�rio Mensal Consolidado</h1>
	<hr class="tit" />
	<br />
</div>
<div id="meio">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<form name="buscador" method="post">
		<div style="float: left"><img src="../images/lupa.png" alt="busca" />
		</div>
		<div style="width: 280px; position: relative"><label
			style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">M�s</label>
		<input type="hidden" name="relatorio" value="<?php echo $relatorio ?>" />
		<select name="mes" class="form_estilo"
			style="width: 150px; float: left">
			<option value="01" <? if($mes=='01') echo 'selected="select"'; ?>>Janeiro</option>
			<option value="02" <? if($mes=='02') echo 'selected="select"'; ?>>Fevereiro</option>
			<option value="03" <? if($mes=='03') echo 'selected="select"'; ?>>Mar�o</option>
			<option value="04" <? if($mes=='04') echo 'selected="select"'; ?>>Abril</option>
			<option value="05" <? if($mes=='05') echo 'selected="select"'; ?>>Maio</option>
			<option value="06" <? if($mes=='06') echo 'selected="select"'; ?>>Junho</option>
			<option value="07" <? if($mes=='07') echo 'selected="select"'; ?>>Julho</option>
			<option value="08" <? if($mes=='08') echo 'selected="select"'; ?>>Agosto</option>
			<option value="09" <? if($mes=='09') echo 'selected="select"'; ?>>Setembro</option>
			<option value="10" <? if($mes=='10') echo 'selected="select"'; ?>>Outubro</option>
			<option value="11" <? if($mes=='11') echo 'selected="select"'; ?>>Novembro</option>
			<option value="12" <? if($mes=='12') echo 'selected="select"'; ?>>Dezembro</option>
		</select> <label
			style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Ano</label>
		<select name="ano" class="form_estilo"
			style="width: 150px; float: left">
			<?for($i = 2009; $i <= date('Y'); $i++){?>
			<option value="<?=$i?>"<?=($i == $ano) ? ' selected="selected"':''?>><?=$i?></option>
			<?}?>
		</select> 
		<input type="submit" name="submit" class="button_busca" style="float: left" value=" Buscar " /></div>
		</form>
		<br />

		</td>
	</tr>
</table>
</div>
<?php }?>
<?php require('footer.php'); ?>
