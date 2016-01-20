<? $erro = ""; 
if($_POST){
	ob_start();
	require( "../includes/funcoes.php" );
	require( "../includes/verifica_logado_controle.inc.php" );
	require( "../includes/global.inc.php" );
	pt_register('POST','mes');
	pt_register('POST','ano');
	$erro = '<br /><br /><span style="color:#FF0000">Você deve selecionar o mês e o ano para fazer a consulta.</span>';
	if(($mes > 0) && ($ano > 0)){
		$relatorio = new RelatorioDAO();
		$dt        = $relatorio->DespesaServico($mes, $ano, $controle_id_empresa);
		switch($mes){
			case 1: $extenso = 'Janeiro_'; break;
			case 2: $extenso = 'Fevereiro_'; break;
			case 3: $extenso = 'Marco_'; break;
			case 4: $extenso = 'Abril_'; break;
			case 5: $extenso = 'Maio_'; break;
			case 6: $extenso = 'Junho_'; break;
			case 7: $extenso = 'Julho_'; break;
			case 8: $extenso = 'Agosto_'; break;
			case 9: $extenso = 'Setembro_'; break;
			case 10: $extenso = 'Outubro_'; break;
			case 11: $extenso = 'Novembro_'; break;
			case 12: $extenso = 'Dezembro_'; break;
		}
		$erro = '<br /><br /><span style="color:#FF0000">Nenhum pedido no mês de ';
		$erro .= str_replace('_','',$extenso).' de '.$ano.'.</span>';
		if(count($dt) > 0){
			$ano_extenso = $ano;
			$mes_extenso = $mes;
			
			//adiciona classe para montar o excel
			require_once "../classes/spreadsheet_excel_writer/Writer.php";
			
			//monta o nome do arquivo $ano = date('Y');
			$mes = date('m');
			$dia = date('d');
			$hor = date('H');
			$min = date('i');
			$seg = date('s');

			$arquivo = $ano.$mes.$dia.$hor.$min.$seg.'.xls';
			
			$workbook =& new Spreadsheet_Excel_Writer();
			
			//seta o nome do arquivo e coloca send para ir para download
			$workbook->send($arquivo);
			
			$abas = array('DESPESAS_'.$mes_extenso.'_'.$ano_extenso);
				
			for($i = 0; $i < count($abas); $i++){
				#planilha
				$worksheet =& $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));
				
				$style1 =& $workbook->addFormat( array(
					'Size'=>11, 'FgColor'=>'black', 'Align'=>'center',
					'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1,
					'Top'=>1, 'Left'=>1, 'Right'=>1, 'Bottom'=>1, 'BorderColor'=>'black'
				));
				
				$style2 =& $workbook->addFormat( array(
					'Size'=>10, 'FgColor'=>'black', 'Align'=>'center',
					'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 
					'Top'=>1, 'Left'=>1, 'Right'=>1, 'Bottom'=>1, 'BorderColor'=>'black'
				));
				
				$style3 =& $workbook->addFormat( array(
					'Size'=>10, 'FgColor'=>'black', 'Align'=>'center',
					'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 
					'Top'=>1, 'Left'=>1, 'Right'=>1, 'Bottom'=>1, 'BorderColor'=>'black',
					'NumFormat'=>'_*R$ #,##0.00'
				));

				$style4 =& $workbook->addFormat( array(
					'Size'=>10, 'Bottom'=>1, 'BorderColor'=>'black'
				));
				
				#referencia
				$ref = array(
					'Data',
					'Serviço',
					'UF',
					'Cidade',
					'Resultado',
					'Pedido',
					'Ordem',
					'Custas',
					'Rateio',
					'Sedex',
					'Valor Cobrado'
				);
				
				#linha 1
				for($j = 0; $j < count($ref); $j++){
					switch($j){
						case 0: $worksheet->setColumn(0, $j, 11); break;
						case 1: $worksheet->setColumn(0, $j, 23); break;
						case 2: $worksheet->setColumn(0, $j, 6); break;
						case 3: $worksheet->setColumn(0, $j, 23); break;
						case 4: $worksheet->setColumn(0, $j, 8); break;
						case 5: $worksheet->setColumn(0, $j, 8); break;
						case 6: $worksheet->setColumn(0, $j, 10); break;
						case 7: $worksheet->setColumn(0, $j, 10); break; 
						case 8: $worksheet->setColumn(0, $j, 10); break;
					}
					$worksheet->write(0, $j, $ref[$j], $style1);
				}
				
				#linha 2
				$contador = 1;
				$custas   = (float) 0;
				$rateio   = (float) 0;
				$sedex    = (float) 0;
				foreach($dt as $k => $e){
					$data = explode(' ',$e->data);
					$dt   = explode('-',$data[0]);
					$data = $dt[2].'/'.$dt[1].'/'.$dt[0];
					$valor = array(
						$data,
						ucwords($e->descricao),
						strtoupper($e->certidao_estado),
						ucwords($e->certidao_cidade),
						ucwords($e->certidao_resultado),
						$e->id_pedido,
						$e->ordem,
						$e->custas,
						$e->rateio,
						$e->sedex,
						$e->valor
					);
					$custas   = $custas + $e->custas;
					$rateio   = $rateio + $e->rateio;
					$sedex    = $sedex  + $e->sedex;
					for($j = 0; $j < count($valor); $j++){
						switch($j){
							case 6: case 7: case 8:
								$estilo = $style3; break;
							default:
								$estilo = $style2;
						}
						$worksheet->write($contador, $j, $valor[$j], $estilo);
					}
					$contador++;
				}
				
				#linha 3
				
				for($j = 0; $j < count($ref); $j++){
					$estilo = $style3;
					switch($j){
						case 6: $valor = $custas; break;
						case 7: $valor = $rateio; break;
						case 8: $valor = $sedex; break;
						default: $estilo = $style2;
					}
					if($j == 0){
						$worksheet->setMerge($contador, 0, $contador, 5);
						$worksheet->write($contador, 0, 'Total', $estilo);
					} elseif($j > 5){
						$worksheet->write($contador, $j, $valor, $estilo);
					} else {
						$worksheet->write($contador, $j, '', $style4);
					}
				}
			}
			$workbook->close();
			exit();
		}
	}
	echo $erro;
	echo '<br /><br /><a href="#" onclick="window.close();">Fechar</a> esta janela.';
	exit();
} 
require('header.php');?>
<form action="rel_despesa_servico.php" name="form1" method="post" target="_blank">
<div id="topo">
	<h1 class="tit">
	<img src="../images/tit/tit_cartorio.png" alt="Título" />Relatório Despesa Serviço</h1>
	<hr class="tit" /><br />
</div>
<div id="meio">
	
	<label style="margin-left:10px;"><strong>Mês</strong></label>
	<select name="mes" class="form_estilo">
		<? $mes = ($mes) ? $mes : date('m');
		$m = array('--','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
		for($i = 1; $i < count($m); $i++){?>
			<option value="<?=$i?>" <? if($mes == $i) echo 'selected="select"'; ?>><?=$m[$i]?></option>
		<?}?>
	</select>

	<label style="margin-left:10px;"><strong>Ano</strong></label>
	<select name="ano" class="form_estilo">
		<? $ano = ($ano) ? $ano : date('Y');
		for($i = 2009; $i <= date("Y"); $i++){?>
			<option value="<?=$i?>" <? if($ano == $i) echo 'selected="select"'; ?>><?=$i?></option>
		<?}?>
	</select> 
	
	<input type="submit" name="submit" class="button_busca" value=" Buscar " />
	
</div>
</form>
<?require('footer.php');?>
