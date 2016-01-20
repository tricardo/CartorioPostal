<?
require "../includes/topo.php";
$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

function valida($str){
	$str = str_replace("'", "''", $str);
	$str = str_replace('"', '""', $str);
	$str = str_replace('&lt;', '', $str);
	$str = str_replace('&gt;', '', $str);
	$str = str_replace('<', '', $str);
	$str = str_replace('>', '', $str);
	$str = str_replace('\\', '', $str);
	$str = str_replace('(__) ____-____', '', $str);
	$str = str_replace('_____-___', '', $str);
	$str = str_replace('__/____', '', $str); 
	$str = str_replace('__/__/____', '', $str);
	return $str;
}
function orgao_emissor($id){
	switch($id){
		case 1: $orgao_emissor='SSP-AC'; break;
		case 2: $orgao_emissor='SSP-AL'; break;
		case 3: $orgao_emissor='SSP-AM'; break;
		case 4: $orgao_emissor='SSP-AP'; break;
		case 5: $orgao_emissor='SSP-BA'; break;
		case 6: $orgao_emissor='SSP-CE'; break;
		case 7: $orgao_emissor='SSP-DF'; break;
		case 8: $orgao_emissor='SSP-ES'; break;
		case 9: $orgao_emissor='SSP-GO'; break;
		case 10: $orgao_emissor='SSP-MA'; break;
		case 11: $orgao_emissor='SSP-MG'; break;
		case 12: $orgao_emissor='SSP-MS'; break;
		case 13: $orgao_emissor='SSP-MT'; break;
		case 14: $orgao_emissor='SSP-PA'; break;
		case 15: $orgao_emissor='SSP-PB'; break;
		case 16: $orgao_emissor='SSP-PE'; break;
		case 17: $orgao_emissor='SSP-PI'; break;
		case 18: $orgao_emissor='SSP-PR'; break;
		case 19: $orgao_emissor='SSP-RJ'; break;
		case 20: $orgao_emissor='SSP-RN'; break;
		case 21: $orgao_emissor='SSP-RO'; break;
		case 22: $orgao_emissor='SSP-RR'; break;
		case 23: $orgao_emissor='SSP-RS'; break;
		case 24: $orgao_emissor='SSP-SC'; break;
		case 25: $orgao_emissor='SSP-SE'; break;
		case 26: $orgao_emissor='SSP-SP'; break;
		case 27: $orgao_emissor='SSP-TO'; break;
	}
	return $orgao_emissor;
}
pt_register('GET','aba');
if($aba){$aba=$aba;}else{$aba=1;}
$dt  = new ListaInteressadosDAO();
$dt1 = new StatusDAO();
$dt2 = new FichaDAO();

pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','submit2');
pt_register('POST','submit3');
$c = new stdClass();

if($submit1){
	require "edita_submit1.php";
} elseif($submit2){
	require "edita_submit2.php";
} elseif($submit3){
	require "edita_submit3.php";
} else {
	$e = $dt->buscaFichaCadastros($id); if(count($e)>0) foreach($e as $cp => $valor){ $c->$cp = $valor; }
	$e = $dt->buscaCadastroAdicionais($id); if(count($e)>0) foreach($e as $cp => $valor){ $c->$cp = $valor; }
	$e = $dt->buscaConjuge($id); if(count($e)>0) foreach($e as $cp => $valor){ $c->$cp = $valor; }
	$e = $dt->buscaEndereco2($id); if(count($e)>0) foreach($e as $cp => $valor){ $c->$cp = $valor; }
	$e = $dt->buscaReferenciaBancaria($id); if(count($e)>0) foreach($e as $cp => $valor){ $c->$cp = $valor; }
	$e = $dt->buscaDemonstrativoRendimento($id); if(count($e)>0) foreach($e as $cp => $valor){ $c->$cp = $valor; }
	$e = $dt->buscaBensConsumo($id); if(count($e)>0) foreach($e as $cp => $valor){ $c->$cp = $valor; }
	$e = $dt->buscaDadosAdinistrativo($id); if(count($e)>0) foreach($e as $cp => $valor){ $c->$cp = $valor; }
}

if($c->id_status == 18 && $safpostal_id_empresa != 1){ header('Location: imprimir_ficha.php?id='.$id); }

if(!$c->id_usuario){
	$e = $dt2->buscaIDFicha($id); 
	$c->id_usuario = $e->id_usuario;
}
if($safpostal_id_usuario != $c->id_usuario){
	if($safpostal_id_usuario != 1 && $safpostal_id_usuario != 56 && $safpostal_id_usuario != 272){
		echo '<label style="color:#FF0000; margin-left:20px; margin-top:10px;">Você não tem permissão para visualizar esta página.</label>';
		exit();
	}
}
?>
<div id="principal">
	<div style="width:152px;"><? require "menu_lateral.php"; ?></div>
	<div style="width:768px;">
		<div id="titulo">
			<div id="titulo1">&nbsp; Interessados</div>
			<div id="titulo2">Franquia: <? echo $safpostal_fantasia ?></div>
		</div>
		<div id="ficha_id_numero">ID Ficha: #<?=$id?></div>
		<div id="abas">
			<div id="aba1" onclick="CarregaAba(1);">Cadastro</div>
			<div id="aba2" onclick="CarregaAba(2);">Status</div>
			<div id="aba3" onclick="CarregaAba(3);">Aprovar</div>
			<div id="aba4" style="width:422px; border:none; border-bottom:solid 1px #686868; 
				height:14px; text-align:right;"><a href="javascript:window.history.go(-1)" 
				style="color:#0066FF">Voltar</a></div>
		</div>
		<div id="titulo_form">CADASTRO DE NOVOS INTERESSADOS </div>
		<div id="pagina1">
			<label style="width:758px; text-align:right; display:inline-block;">Campos marcados com 
			(<span style="color:#FF0000;">*</span>) são de preenchimento obrigatório.</label>
			<form name="form_interesse" action="interessados_edit.php?id=<?=$id?>&aba=<?=$aba?>" method="post" enctype="multipart/form-data">
			<!-- div 1 -->
			<? require "div_dados_administrativos.php"; ?>
			<!-- div 2 -->
			<div id="dados_solicitante" class="div_titulo">&nbsp;- Dados do Solicitante</div>
			<div class="div_form">
				<? require "div_dados_solicitante.php"; ?>
				<? require "div_dados_pessoais.php"; ?>
				<? require "div_endereco_atual.php"; ?>
				<? require "div_endereco_anterior.php"; ?>			
				<? require "div_lazer.php"; ?>
			</div>
			<!-- div 3 -->
			<div id="historico_profissional" class="div_titulo">&nbsp;- Histórico Profissional e Empresarial</div>
			<div class="div_form">
				<? require "div_experiencia_franquia.php"; ?>				
				<? require "div_historico_profissional.php"; ?>
				<? require "div_sobre_franquia.php"; ?>
			</div>
			<!-- div 4 -->
			<div id="informacao_financeira" class="div_titulo">&nbsp;- Informações Financeiras e Adicionais</div>
			<div class="div_form">
				<? require "div_informacao_financeira.php"; ?>
				<? require "div_referencia_bancaria.php"; ?>
				<? require "div_demonstrativo_rendimento.php"; ?>
				<? require "div_bens_consumo.php"; ?>
			</div>
			<input name="submit1" id="submit1" type="submit" value="Alterar" style="width:90px; margin-left:669px;" />
            
			</form>
		</div>
		<div id="pagina2"><? require "div_status.php"; ?></div>
		<div id="pagina3"><? require "div_aprovar_cadastro.php"; ?></div>
	</div>
</div>
<? if($errors > 0){
	$funcao = "";
	$funcao .= "document.getElementById('".$cp."').style.border='2px #CC3300 solid'; ";
	$funcao .= "document.getElementById('".$cp."').focus(); ";?>

		<img src="../images/null.gif" border="0" height="1" width="1" onload="<?=$funcao?>; document.getElementById('box_news').style.display='block';" />
		
<? } ?>
<div class="box_ativa round" id="box_news" style=" width:350px; height:200px; border:5px solid black; position: fixed; top: 35%; right: 32%; background-color: white;">
	<div class="ba_tit" style="background-color:#FFCC00">
		<span style="float: right; cursor: pointer; color:#FF0000; font-weight:bold " onclick="$('#box_news').hide();" class="hb_tit">X</span>
		<span class="hb_tit" style="font-weight:bold; color:#FF0000;">ERRO!</span>
	</div>
	<div class="ba_box" style="color:#FF0000; margin:10px; border:none; text-align:left; font-weight:bold; text-transform:uppercase"><?=$error?></div>
</div>
<script>CarregaAba(<?=$aba?>); Anexos(<?=$id?>, 1, 0);</script>
<? require "../includes/rodape.php"; ?>