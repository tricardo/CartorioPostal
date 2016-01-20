<?php
if ($_POST['submit']) {
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );

	if(verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
		&& verifica_permissao('Supervisor Atendimento',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
		&& verifica_permissao('Supervisor Financeiro',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'){
			if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE'){
				echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
				exit;
			}
	}
	
	pt_register('POST','mes');
	pt_register('POST','ano');
	pt_register('POST','id_empresa');
	pt_register('POST','cnpj_cliente');
	if($ano == '')$ano = date('Y');
	if($mes == '')$mes = date('m');
	
	$ref = $mes.'/'.$ano;
	
	$data_i = $ano.'-'.$mes.'-01 00:00:00';
	$data_f = $ano.'-'.$mes.'-31 23:59:59';
	$id_empresa = ($controle_id_empresa=='1')?$id_empresa:$controle_id_empresa;

echo '<pre>';
	$pedidoDAO = new PedidoDAO();
	$pedidos = $pedidoDAO->listaPedidosClientePJ($id_empresa,$data_i,$data_f,$cnpj_cliente);
print_r($pedidos);
die();
	$nomeArquivo = "cliente_".$ano."_".$mes.".csv";
	$arquivoDiretorio = "./exporta/".$nomeArquivo;
	$arquivoConteudo = 'Referência;'.$ref.';
'.$pedidos[0]->cpf.';
PEDIDO;VALOR
';	
		$valores=0;
	foreach($pedidos as $i=>$p){
		$arquivoConteudo .= '#'.$p->id_pedido;
		$arquivoConteudo .= '/'.$p->ordem;
		$arquivoConteudo .= ';'.number_format($p->valor,2,',','');
		$arquivoConteudo .= ';'.$p->contato;
		$arquivoConteudo .= ';'.$p->tel.' - '.$p->ramal;
		$arquivoConteudo .= ';'.$p->tel2.' - '.$p->ramal2;
		$arquivoConteudo .= ';'.$p->nome;
		$arquivoConteudo .="\n";
		$valores += $p->valor;
	}
	$arquivoConteudo.=($i+1).';'.number_format($valores,2,',','');
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
pt_register('POST','id_empresa');
pt_register('GET','cnpj_cliente');

if($id_empresa == '') $id_empresa = $controle_id_empresa;
if($ano == '')$ano = date("Y", strtotime("-1 month"));
if($mes == '')$mes = date("m", strtotime("-1 month"));
	?>

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
			<input type="hidden" name="cnpj_cliente" value="<?php echo $cnpj_cliente?>"/>
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
