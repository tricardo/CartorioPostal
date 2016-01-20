<?php
require( "../includes/verifica_logado_ajax.inc.php");
$submit = $_POST['submit'];

if($submit){
	require( "../includes/global.inc.php" );
	require( "../includes/funcoes.php" );
    require("../classes/spreadsheet_excel_writer/Writer.php");

	$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
	
	pt_register('POST','ano');
	pt_register('POST','mes');
	pt_register('POST','dia_i');
	pt_register('POST','dia_f');
	pt_register('POST','id_empresa');
	if($controle_id_empresa!=1 or $id_empresa==''){
		$id_empresa = $controle_id_empresa;
	}
	if($dia_i=='') $dia_i = '01';
	if($dia_f=='') $dia_f = '31';
    $empresaDAO = new EmpresaDAO();
    $emp = $empresaDAO->selectPorId($id_empresa);
	
	if(strlen($dia_i)<2) $dia_i = '0'.$dia_i;
	if(strlen($dia_f)<2) $dia_f = '0'.$dia_f;
	
	$data_i = $ano.'-'.$mes.'-'.$dia_i.' 00:00:00';
	$data_f = $ano.'-'.$mes.'-'.$dia_f.' 23:59:59';

	$relatorioDAO = new RelatorioDAO();
	$lista = $relatorioDAO->relatorioGeraldoDia($controle_id_empresa,$data_i,$data_f);



    #inicio do código excel
    $arquivo = $controle_id_usuario . ".xls";
    //monta as abas da planilha
    $abas = array('Relatório Geral de Pedidos');
    $i = 0;
    require('../includes/excelstyle.php');
    $worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

    $worksheet->setmerge(0, 0, 0, 8);
    $worksheet->write(0, 0, 'Relatório de ' . $emp->fantasia, $styletitulo);

    $worksheet->setmerge(1, 0, 1, 8);
    $worksheet->write(1, 0, 'Período de ' . $dia_i . '/' . $mes . '/' . $ano.' até ' . $dia_f . '/' . $mes . '/' . $ano, $styletitulo2);

    $worksheet->write(2, 0, 'Data', $styletitulo3);
    $worksheet->write(2, 1, 'Em Aberto', $styletitulo3);
    $worksheet->write(2, 2, 'Valor Em Aberto', $styletitulo3);
    $worksheet->write(2, 3, 'Fechados', $styletitulo3);
    $worksheet->write(2, 4, 'Valor Fechados', $styletitulo3);
    $worksheet->write(2, 5, 'Concluídos', $styletitulo3);
    $worksheet->write(2, 6, 'Valor Concluídos', $styletitulo3);
    $worksheet->write(2, 7, 'Cancelados', $styletitulo3);
    $worksheet->write(2, 8, 'Valor Cancelados', $styletitulo3);

    $cont = 0;
    $i = 3;

	foreach($lista as $p){
		if($p->data!='0000-00-00')
			$data = date('d/m/Y',strtotime($p->data));
		else
			$data = 'Antigos';
        $j = 0;
        $worksheet->write($i, $j, $data, $styleleft);
        $j++;
        $worksheet->write($i, $j, $p->aberto, $stylecenter);
        $j++;
        $worksheet->write($i, $j, $p->aberto_valor, $stylereal);
        $j++;
        $worksheet->write($i, $j, $p->fechado, $stylecenter);
        $j++;
        $worksheet->write($i, $j, $p->fechado_valor, $stylereal);
        $j++;
        $worksheet->write($i, $j, $p->concluido, $stylecenter);
        $j++;
        $worksheet->write($i, $j, $p->concluido_valor, $stylereal);
        $j++;
        $worksheet->write($i, $j, $p->cancelado, $stylecenter);
        $j++;
        $worksheet->write($i, $j, $p->cancelado_valor, $stylereal);
        $j++;

		$i++;
	}
	//$excel->writeLine(array('Total','','','','','',$valor_valor,$valor_rateio,$valor_sedex));
	
    $i++;
    $worksheet->setmerge($i, 0, $i, 8);
    $worksheet->write($i, 0, ' ', $styletitulo4);

    $i++;
    $worksheet->setmerge($i, 0, $i, 8);
    $worksheet->write($i, 0, '- Entre os pedidos em aberto são contabilizados todos os pedidos, desde a liberação do sistema', $styletitulo4);
	
    $i++;
    $worksheet->setmerge($i, 0, $i, 8);
    $worksheet->write($i, 0, '- Entre os pedidos fechados são contabilizados os pedidos que receberam a atividade "serviço conferido" entre o período selecionado', $styletitulo4);
	
    $i++;
    $worksheet->setmerge($i, 0, $i, 8);
    $worksheet->write($i, 0, '- Entre os pedidos cancelados são contabilizados os pedidos que receberam a atividade "motivo do cancelamento" no período selecionado', $styletitulo4);
	$workbook->close();
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
		<td class="tabela_tit" colspan="4">Relatório de Geral</td>
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