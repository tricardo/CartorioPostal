<?php
require( "../includes/verifica_logado_ajax.inc.php");
$submit = $_POST['submit'];

if($submit){
	require( "../includes/global.inc.php" );
	require( "../includes/funcoes.php" );
	require("../includes/geraexcel/excelwriter.inc.php");

	$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
	
	pt_register('POST','ano');
	pt_register('POST','mes');
	pt_register('POST','dia_i');
	pt_register('POST','dia_f');
	if($dia_i=='') $dia_i = '01';
	if($dia_f=='') $dia_f = '31';
	
	if(strlen($dia_i)<2) $dia_i = '0'.$dia_i;
	if(strlen($dia_f)<2) $dia_f = '0'.$dia_f;
	
	$data_i = $ano.'-'.$mes.'-'.$dia_i.' 00:00:00';
	$data_f = $ano.'-'.$mes.'-'.$dia_f.' 23:59:59';

	$pedidoDAO = new PedidoDAO();
	$pedidos = $pedidoDAO->listaPedidosRecFranquia($controle_id_empresa,$data_i,$data_f);
	//print_r($pedidos);
	echo $controle_id_empresa;
	exit();

	$nomeArquivo = 'cadastrados_'.date("Ymd")."_".$controle_id_empresa.".xls";
	$arquivoDiretorio = "../relatorios/cadastrados/".$nomeArquivo;
	$excel=new ExcelWriter($arquivoDiretorio);

	if($excel==false){
		echo $excel->error."????";
		exit;
	}

	$semana=0;
	$toral = 0;
	$pedidos_conta = 0;

	$excel->writeLine(array('Data','Ordem','Franquia','Serviço','Cidade','Estado','Status','Prazo','Custas','Honorários','Sedex'));

	foreach($pedidos as $i=>$p){
		$data = date('d/m/Y',strtotime($p->data));
		$pedidos_conta++;
		$total = (float)($p->financeiro_valor)+(float)($p->financeiro_sedex)+(float)($p->financeiro_rateio);
		$lucro = (float)($p->valor)-(float)($total);
		$excel->writeLine(array($data,$p->id_pedido.'/'.$p->ordem,$p->fantasia,$p->servico,$p->certidao_cidade,$p->certidao_estado,$p->status,invert($p->data_prazo,'/','PHP'),$p->financeiro_valor,$p->financeiro_rateio,$p->financeiro_sedex));

		$valor_valor = (float)($p->financeiro_valor)+(float)($valor_valor);
		$valor_sedex = (float)($p->financeiro_sedex)+(float)($valor_sedex);
		$valor_rateio = (float)($p->financeiro_rateio)+(float)($valor_rateio);

	}
	$excel->writeLine(array('Total','','','','','',$valor_valor,$valor_rateio,$valor_sedex));
	
	$excel->close();
	header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
	header("Content-Length: ".filesize($arquivoDiretorio));
	readfile($arquivoDiretorio);
	die();
//	echo '</table>';
}else{

	require('header.php');
	$empresaDAO = new EmpresaDAO();
	$empresas = $empresaDAO->listarTodas();
	?>
<div id="meio">
<form method="post">
<table class="tabela">
	<tr>
		<td class="tabela_tit" colspan="4">Relatório de pedidos cadastrados</td>
	</tr>
	<tr>
		<td align="right"><b>Entre dia:</b></td>
		<td colspan="2"><input type="text" name="dia_i" class="form_estilo" size="1" />
		<b>e </b><input type="text" name="dia_f" class="form_estilo" size="1" /></td>
	</tr>
	<tr>
		<td align="right"><b>Mês</b></td>
		<td colspan="2">
		<select name="mes" class="form_estilo" style="width:85px" >
			<option value="01">Janeiro</option>
			<option value="02">Fevereiro</option>
			<option value="03">Março</option>
			<option value="04">Abril</option>
			<option value="05">Maio</option>
			<option value="06">Junho</option>
			<option value="07">Julho</option>
			<option value="08">Agosto</option>
			<option value="09">Setembro</option>
			<option value="10">Outubro</option>
			<option value="11">Novembro</option>
			<option value="12">Dezembro</option>
		</select>
		<b>Ano:</b>
		
			<select name="ano" class="form_estilo">
				<option>2012</option>
				<option>2011</option>
				<option>2010</option>
				<option>2009</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><input type="submit" name="submit" value="enviar" class="button_busca" /></td>
	</tr>
</table>
</form>
</div>
<?php 
}
?>