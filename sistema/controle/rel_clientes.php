<?php
if ($_POST['submit']) {
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );

	if(verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
		|| verifica_permissao('Supervisor Atendimento',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
		|| verifica_permissao('Supervisor Financeiro',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'){
			if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE'){
				echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
				exit;
			}
	}
	
	pt_register('POST','busca');
	pt_register('POST','mes');
	pt_register('POST','ano');
	pt_register('POST','sem');
	pt_register('POST','id_empresa');
	if($ano == '')$ano = date('Y');
	if($mes == '')$mes = date('m');
	
	if($busca=='semestre'){
		$ref  = $sem.'º semestre de '.$ano;
		if($sem==1){
			$mes_i = 1;
			$mes_f = 6;
		}else{
			$mes_i = 7;
			$mes_f = 12;
		}		
	}else if($busca=='mes'){
		$ref = $mes.'/'.$ano;
		$mes_i = $mes;
		$mes_f = $mes;
	}else{
		$ref = $ano;
		$mes_i = 1;
		$mes_f = 12;
	}
	
	$id_empresa = ($controle_id_empresa=='1')?$id_empresa:$controle_id_empresa;
	
	$relatorioDAO = new RelatorioDAO();
	$clientes = $relatorioDAO->faturamentoPorCliente($busca,$id_empresa,$ano,$sem,$mes);
	
	$nomeArquivo = "clientes_".$ano."_".$mes.".csv";
	$arquivoDiretorio = "./exporta/".$nomeArquivo;
	$arquivoConteudo = 'Referência;'.$ref.';
'.$clientes[0]->franquia.'CLIENTE;CNPJ;';
	for($i=$mes_i;$i<=$mes_f;$i++){
		$arquivoConteudo .= 'VALOR '.traduzMes($i).';';
		$arquivoConteudo .= 'PEDIDOS '.traduzMes($i).';';
	}
	$arquivoConteudo .= 'VALOR Ano;';
	$arquivoConteudo .= 'Pedidos Ano;';
	$arquivoConteudo.='
		';
	foreach($clientes as $c){
		$arquivoConteudo.="".$c->cliente.';'."\t".$c->cnpj;
		$valores=0;
		$pedidos=0;
		for($i=$mes_i;$i<=$mes_f;$i++){
			$arquivoConteudo .= ';'.number_format($c->valores[$i]->total,2,',','');
			$valores += $c->valores[$i]->total;
			$arquivoConteudo .= ';'.number_format($c->valores[$i]->pedidos,0);
			$pedidos += $c->valores[$i]->pedidos;
		}
		$arquivoConteudo.=';'.number_format($valores,2,',','');
		$arquivoConteudo.=';'.number_format($pedidos,2,',','');
		$arquivoConteudo.="\n";
	}
//	echo $arquivoDiretorio;
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

$empresaDAO = new EmpresaDAO();
$empresas = $empresaDAO->listarTodas();

pt_register('POST','mes');
pt_register('POST','ano');
pt_register('POST','sem');
if($ano == '')$ano = date('Y');
if($mes == '')$mes = date("m", strtotime("-1 month"));;
	?>
<script>
function toggleCombos(){
	if($('#busca').val()=='mes'){
		$('#busca_mes').show();
		$('#busca_sem').hide();
	}else if($('#busca').val()=='semestre'){
		$('#busca_mes').hide();
		$('#busca_sem').show();
	}else{
		$('#busca_mes').hide();
		$('#busca_sem').hide();
	}
}
</script>
<div id="topo">
	<h1 class="tit">
	<img src="../images/tit/tit_rel.png" alt="Título" />Relatório Mensal Consolidado</h1>
	<hr class="tit" />
	<br />
</div>
<div id="meio">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<form name="buscador" method="post">
		<div style="width: 280px; position: relative">
			
			<label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Busca por: </label>
			<select name="busca" id="busca" class="form_estilo" style="width: 150px; float: left" onchange="toggleCombos();">
				<option value="ano" <? if($busca== 'ano') echo 'selected="select"'; ?>>ano</option>
				<option value="semestre" <? if($busca== 'semestre') echo 'selected="select"'; ?>>semestre</option>
				<option value="mes" <? if($busca== 'mes') echo 'selected="select"'; ?>>mes</option>
			</select> 
			
			<div id="busca_mes">
				<label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Mês: </label>
				<select name="mes" class="form_estilo" style="width: 150px; float: left">
					<option value="01" <? if($mes=='') echo 'selected="select"'; ?>></option>
					<option value="01" <? if($mes=='01') echo 'selected="select"'; ?>>Janeiro</option>
					<option value="02" <? if($mes=='02') echo 'selected="select"'; ?>>Fevereiro</option>
					<option value="03" <? if($mes=='03') echo 'selected="select"'; ?>>Março</option>
					<option value="04" <? if($mes=='04') echo 'selected="select"'; ?>>Abril</option>
					<option value="05" <? if($mes=='05') echo 'selected="select"'; ?>>Maio</option>
					<option value="06" <? if($mes=='06') echo 'selected="select"'; ?>>Junho</option>
					<option value="07" <? if($mes=='07') echo 'selected="select"'; ?>>Julho</option>
					<option value="08" <? if($mes=='08') echo 'selected="select"'; ?>>Agosto</option>
					<option value="09" <? if($mes=='09') echo 'selected="select"'; ?>>Setembro</option>
					<option value="10" <? if($mes=='10') echo 'selected="select"'; ?>>Outubro</option>
					<option value="11" <? if($mes=='11') echo 'selected="select"'; ?>>Novembro</option>
					<option value="12" <? if($mes=='12') echo 'selected="select"'; ?>>Dezembro</option>
				</select> 
			</div>
			<div id="busca_sem">
				<label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Semestre: </label>
				<select name="sem" class="form_estilo" style="width: 150px; float: left">
					<option value="" <? if($sem == '') echo 'selected="select"'; ?>></option>
					<option value="1" <? if($sem == 1) echo 'selected="select"'; ?>>1º semestre</option>
					<option value="2" <? if($sem == 2) echo 'selected="select"'; ?>>2º semestre</option>
				</select> 
			</div>
			
			<label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Ano: </label>
			<select name="ano" class="form_estilo" style="width: 150px; float: left">
				<option value="2009" <? if($ano=='2009') echo 'selected="select"'; ?>>2009</option>
				<option value="2010" <? if($ano=='2010') echo 'selected="select"'; ?>>2010</option>
				<option value="2011" <? if($ano=='2011') echo 'selected="select"'; ?>>2011</option>
				<option value="2012" <? if($ano=='2012') echo 'selected="select"'; ?>>2012</option>
			</select>
			
			<?php if($controle_id_empresa=='1'){?>
			<label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Franquia: </label>
			<select name="id_empresa" class="form_estilo" style="width: 150px; float: left">
				<?php foreach($empresas as $e){?>
					<option value="<?php echo $e->id_empresa ?>" <? if($id_empresa==$e->id_empresa) echo 'selected="select"'; ?>><?php echo $e->fantasia ?></option>
				<?php }?>
			</select>
			<?php }?>
			<input type="submit" name="submit" class="button_busca" style="float: left" value=" Buscar " />
		</div>
		</form>
		<br />

		</td>
	</tr>
</table>
</div>
<?php }?>
<?php require('footer.php'); ?>
<script>
toggleCombos();
</script>
