<?php
ini_set('max_execution_time', '0');
require("../model/Database.php");
require("../includes/classQuery.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
require("../classes/spreadsheet_excel_writer/Writer.php");
//require_once("../includes/maladireta/class.Email.php");

require("../../includes/maladireta/class.PHPMailer.php");
$mailer = new SMTPMailer();
$AddBCC = 'ti@cartoriopostal.com.br';
$AddCC  = '';

$id_empresa_cont = $_GET['id_empresa'];
	
$empresaDAO = new EmpresaDAO();
$pedidoDAO = new PedidoDAO();
$relatorioDAO = new RelatorioDAO();
$contaDAO = new ContaDAO();

$retorna = 1;

$html = 'Consoante a assinatura do contrato de franquia firmado entre Vossa Senhoria e a Franqueadora, informamos que o boleto para pagamento dos Royalties, bem como o valor e dados para depósito do FPP, apurados no mês anterior estão disponíveis para download no sistema.<br><br>
Para acessá-lo será necessário clicar no menu:<br>
<b>INICIAR > RELÁTÓRIOS > RELATÓRIO DE ROYALTIES E FATURAMENTO</b><br><br>

E baixar o boleto e o relatório para conferencia dos valores e faturamento.

Reforçamos nossa parceria.<br><br>
Atenciosamente,<br>
Equipe Cartório Postal.<br>
<br>';

function mesesEntreDatas($data1,$data2){
    #formato ##/##/####
    $arr = explode('/',$data1); 
    $arr2 = explode('/',$data2); 

    $dia1 = $arr[0]; 
    $mes1 = $arr[1]; 
    $ano1 = $arr[2]; 

    $dia2 = $arr2[0]; 
    $mes2 = $arr2[1]; 
    $ano2 = $arr2[2]; 

    $a1 = ($ano2 - $ano1)*12;
    $m1 = ($mes2 - $mes1)+1;
    $m3 = ($m1 + $a1);
    return $m3;
}

while($retorna>0){

	$ano_mes = date((isset($_GET['datas']) ? $_GET['datas'] : 'Y-m'),strtotime("-".$retorna." month"));
	$ano_mes_exp = explode('-',$ano_mes);	
	$mes_referencia = date('m/Y',strtotime("-".$retorna." month"));
	$empresas = $empresaDAO->listarTodasCronRoy((isset($_GET['id_user_empresa']) ? $_GET['id_user_empresa'] : 0));

	echo '<pre>';
	$cont=0;
	foreach($empresas as $emp){
		
		#
		#
		#
		#print_r($empresas);
		#echo '<br><br>'.$emp->inicio.'>='.$ano_mes.'-01<br><br>';
		#exit;
		#
		#
		#
		
		$cont++;
		
		if($emp->id_empresa==1 or $emp->inicio!='0000-00-00' and $emp->inicio!='' and $emp->inicio>=$ano_mes.'-01') continue;
		if($id_empresa_cont!='' and $emp->id_empresa<=$id_empresa_cont) continue;
		#inicio do código excel
		$arquivo = '../relatorios/royalties/'.md5(date("YmdHis"))."_".$emp->id_empresa.".xls";
		echo 'passou aqui'; 
		#monta as abas da planilha
		$abas = array('Relatório de Royalties');
		$i = 0;
		$excelgrava='1';
		require('../includes/excelstyle.php');
		$worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

		
		$imposto = $emp->imposto;
		$fantasia = $emp->fantasia;
		$royalties = $emp->royalties;
		
		echo "\n".$emp->id_empresa." fazendo rel de ".$fantasia."\t\t".$imposto;

		$worksheet->setmerge(0, 0, 0,3);
		$worksheet->write(0, 0, $fantasia, $styletitulo2);
		$worksheet->write(0, 4, '', $stylebg);

		$worksheet->setmerge(1, 0, 1,4);
                
		$worksheet->write(1, 0, 'Referência: ' . $mes_referencia, $styletitulo4);

		#header
		$worksheet->write(2, 0, 'Dia', $styletitulo3);
		$worksheet->write(2, 1, 'Faturamento', $styletitulo3);
		$worksheet->write(2, 2, 'Royalties', $styletitulo3);
		$worksheet->write(2, 3, 'FPP', $styletitulo3);
		$worksheet->write(2, 4, '', $stylebg);

		$p_valor='';
		$num_fat=0;
		$t_num_fat=0;
		$t_num_royalties=0;
		$t_num_propaganda=0;
		$dia=1;
		$pedidos='';
		$done_roy='';		

		#meses entre data de hoje e data de inicio das atividades
		$qtddMeses = mesesEntreDatas(invert($emp->inicio,'/','PHP'),'01/'.$mes_referencia);
		if($qtddMeses>1) $qtddMeses--;
                
		#inicia as variaveis que vão ser gravadas no banco de dados
		$dados = new stdClass();
		$dados->id_empresa = $emp->id_empresa;
		$dados->data = $ano_mes.'-01';
		$dados->valor_royalties  = 0;
		$dados->valor_propaganda = 0;
		$dados->faturamento	 = 0;
		$dados->imposto		 	 = $imposto;
		$dados->roy				 = $royalties;
		$dados->despesa			 = 0;
		$dados->fixo			 = '';
		$linha = 2;
		$linha2=41;
                
                
		while($dia<=31){
			$linha++;
			$data = $ano_mes.'-'.$dia;
			$dados_roy = $relatorioDAO->dadosRoyalties($emp->id_empresa,$data);
			
			$num_fat=0;
			$num_propaganda=0;
			foreach($dados_roy as $dado){
				#dados pedidos
				$linha2++;
				$worksheet->setmerge($linha2, 0, $linha2,2);
				$worksheet->write($linha2, 0, '#'.$dado->id_pedido.'/'.$dado->ordem, $styleleft);
				$worksheet->write($linha2, 1, '', $styleleft);
				$worksheet->write($linha2, 2, '', $styleleft);
				$worksheet->write($linha2, 3, $dado->valor, $stylereal);
				$worksheet->write($linha2, 4, '', $stylebg);
				$num_fat=(float)($num_fat)+(float)($dado->valor);
			}
			$t_num_fat = (float)($t_num_fat)+(float)($num_fat);

			$num_royalties = (float)(($num_fat-((float)($num_fat)/100*(float)($imposto)))/100)*(float)($royalties);
			if($emp->fpp_tipo==0 or $emp->fpp_tipo==1){
				$num_propaganda = (float)(($num_fat-((float)($num_fat)/100*(float)($imposto)))/100)*(float)($emp->fpp);
			} else {
				$num_propaganda = (float)(($num_royalties-((float)($num_royalties)/100*(float)($imposto)))/100)*(float)($emp->fpp);
			}
			$t_num_royalties = (float)($t_num_royalties)+(float)($num_royalties);
			$t_num_propaganda = (float)($t_num_propaganda)+(float)($num_propaganda);

			$dados->valor_royalties  = (float)($dados->valor_royalties)+(float)($num_royalties);
			$dados->valor_propaganda = (float)($dados->valor_propaganda)+(float)($num_propaganda);
			$dados->faturamento		 = (float)($dados->faturamento)+(float)($num_fat);

			$num_royalties= number_format($num_royalties,2,".","");
			$num_propaganda= number_format($num_propaganda,2,".","");
			$num_fat= number_format($num_fat,2,".","");

			#dados
			$worksheet->write($linha, 0, $dia, $stylecenter);
			$worksheet->write($linha, 1, $num_fat, $stylereal);
			$worksheet->write($linha, 2, $num_royalties, $stylereal);
			$worksheet->write($linha, 3, $num_propaganda, $stylereal);
			$worksheet->write($linha, 4, '', $stylebg);
			$dia++;
		}

		if($imposto<>0 and $imposto<>''){
			$despesa = $relatorioDAO->despesasServicoRoyalties($emp->id_empresa, $ano_mes);
			$dados->despesa	= $despesa->total;
		} else {
			$despesa->total = 0;
		}

                #apuração dos royalties
		$t_sub_pagar = (float)((float)($t_num_fat)-(float)((float)($t_num_fat)/100*(float)($imposto)))-(float)($despesa->total);
		$t_pagar = (float)(
						(float)($t_sub_pagar)/100
					)*(float)($royalties);

                #valor por semestre                
		$semestre=0;
		$semestre_ext='';
                $semestre_fixo='';
		$semestre_4m=0;
                if($emp->sem1<>'0.00' and (float)($t_num_fat)<=(float)('50000.00')){
			$data_sem1 = date("Y-m-d", mktime(0, 0, 0, $ano_mes_exp[1] - 6,15, $ano_mes_exp[0]) );
			$data_sem2 = date("Y-m-d", mktime(0, 0, 0, $ano_mes_exp[1] - 12,15, $ano_mes_exp[0]) );
			$data_sem3 = date("Y-m-d", mktime(0, 0, 0, $ano_mes_exp[1] - 18,15, $ano_mes_exp[0]) );
                        
			if($emp->inicio>=$data_sem3 and $emp->{'mes_'.$qtddMeses}<>0) {
				$t_pagar = $emp->{'mes_'.$qtddMeses}; 
				$semestre=3;
				$semestre_ext='terceiro';
			}

			if($emp->inicio>=$data_sem2 and $emp->{'mes_'.$qtddMeses}<>0) {
				$t_pagar = $emp->{'mes_'.$qtddMeses};
				$semestre=2;
				$semestre_ext='segundo';
			}

			if($emp->inicio>=$data_sem1 and $emp->{'mes_'.$qtddMeses}<>0){
				$t_pagar = $emp->{'mes_'.$qtddMeses};
				$semestre=1;
				$semestre_ext='primeiro';
			}
		}

                #royalty fixo no mes
		if($emp->inicio!='0000-00-00' and $emp->sem1=='0'){                    
                    $imes = $qtddMeses;
                    while($imes!=0){
                        if($emp->{'mes_'.$imes}<>0 and $emp->{'mes_'.$imes}>=$t_pagar){
                            $t_pagar = $emp->{'mes_'.$imes};
                            $semestre_fixo = $emp->{'mes_'.$imes};
                            $semestre_4m=1;
                            break;
                        }
                        $imes--;
                    }
		}
                
		if($emp->fpp_tipo==0 or $emp->fpp_tipo==1){
			$t_pagar_fundo = (float)(
							(float)($t_sub_pagar)/100
						)*(float)($emp->fpp);
		} else {
			$t_pagar_fundo = (float)(
							(float)($t_pagar)/100
						)*(float)($emp->fpp);		
		}

		$b->valor = $t_pagar;		
		#adiciona os royalties no banco de dados
		$dados->valor_royalties  = $t_pagar;
		$dados->valor_propaganda  = $t_pagar_fundo;
		$dados->fixo			 = $semestre_ext.$semestre_fixo;
		$relatorioDAO->insereDadosRoyalties($dados);
		
		$t_num_fat = number_format($t_num_fat,2,".","");
		$t_num_propaganda = number_format($t_num_propaganda,2,".","");
		$t_num_royalties = number_format($t_num_royalties,2,".","");
		$t_despesa = number_format($despesa->total,2,".","");
		$t_sub_pagar = number_format($t_sub_pagar,2,".","");
		$t_pagar = number_format($t_pagar,2,".","");
		$t_pagar_fundo = number_format($t_pagar_fundo,2,".","");
		
		
		#dados totais
		$linha++;
		$worksheet->write($linha, 0, 'Totais', $stylecenter);
		$worksheet->write($linha, 1, $t_num_fat, $stylereal);
		$worksheet->write($linha, 2, $t_num_royalties, $stylereal);
		$worksheet->write($linha, 3, $t_num_propaganda, $stylereal);
		$worksheet->write($linha, 4, '', $stylebg);
		
		$linha++;
		$worksheet->setmerge($linha, 0, $linha,4);
		$worksheet->write($linha, 0, '', $stylebg);		

		if($imposto<>0 and $imposto<>'' and $semestre==0){
			$linha++;
			$worksheet->setmerge($linha, 0, $linha,2);
			$worksheet->write($linha, 1, '', $styleleft);
			$worksheet->write($linha, 2, '', $styleleft);
			$worksheet->write($linha, 0, 'Despesas Totais', $styleleft);
			$worksheet->write($linha, 3, $t_despesa, $stylereal);
			$worksheet->write($linha, 4, '', $stylebg);
			$linha++;
			$worksheet->setmerge($linha, 0, $linha,2);
			$worksheet->write($linha, 1, '', $styleleft);
			$worksheet->write($linha, 2, '', $styleleft);
			$worksheet->write($linha, 0, 'Lucro Bruto', $styleleft);
			$worksheet->write($linha, 3, $t_sub_pagar, $stylereal);
			$worksheet->write($linha, 4, '(Faturamento - Impostos - Despesas)', $styleleft);
			$pagar_memoria = '('.$royalties.'% Lucro Bruto)';
		} else {
			if($semestre==0 and $semestre_4m==0){
				$pagar_memoria = '('.$royalties.'% Faturamento)';
			} else {
				if($semestre!=0) $pagar_memoria = '(royalties fixos durante o '.$semestre.' semestre ou até atingir R$ 50.000,00)';
				else $pagar_memoria = '('.$royalties.'% ou '.$semestre_fixo.' fixo)';
			}
			$linha++;
			$worksheet->setmerge($linha, 0, $linha,4);			
			$worksheet->write($linha, 0, '', $stylebg);
			$linha++;
			$worksheet->setmerge($linha, 0, $linha,4);			
			$worksheet->write($linha, 0, '', $stylebg);
			
		}
	
		$linha++;
		$worksheet->setmerge($linha, 0, $linha,2);		
		$worksheet->write($linha, 0, 'Fundo de Propaganda', $styleleft);
		$worksheet->write($linha, 1, '', $styleleft);
		$worksheet->write($linha, 2, '', $styleleft);
		$worksheet->write($linha, 3, $t_pagar_fundo, $stylereal);
		$worksheet->write($linha, 4, '(2% Lucro Bruto)', $styleleft);

		$linha++;
		$worksheet->setmerge($linha, 0, $linha,2);
		$worksheet->write($linha, 0, 'Royalties:', $styleleft);
		$worksheet->write($linha, 1, '', $styleleft);
		$worksheet->write($linha, 2, '', $styleleft);
		$worksheet->write($linha, 3, $t_pagar, $stylereal);
		$worksheet->write($linha, 4, $pagar_memoria, $styleleft);

		$linha++;
		$worksheet->setmerge($linha, 0, $linha,4);			
		$worksheet->write($linha, 0, '', $stylebg);

		$linha++;
		$worksheet->setmerge($linha, 0, $linha,3);
		$worksheet->write($linha, 0, 'Pedidos Contabilizados:', $styletitulo4);
		$worksheet->write($linha, 4, '', $stylebg);

		$workbook->close();			

			#grava relatorio no banco
			$b->id_relatorio = $relatorioDAO->registraRelAnterior($emp->id_empresa,$arquivo,'royalties',$retorna);

			$b->juros_mora=10;
			$b->ocorrencia=1;
			$b->instrucao1='';
			$b->instrucao2='';
			$b->cpf=$emp->cpf;
			$b->sacado=$emp->empresa;
			$b->endereco=$emp->endereco;
			if($emp->numero<>'') $b->endereco.=','.$emp->numero;
			if($emp->complemento<>'') $b->endereco.='-'.$emp->complemento;
			$b->cep=$emp->cep;
			$b->emissao_papeleta=2;
			$b->vencimento=date('Y-m').'-08';
			$b->especie='12';
			$b->aceite='N';
			$b->mensagem1='';
			$b->mensagem2='Protesto após 5 dias';
			$b->id_conta=2;
			$b->emissao=date('%Y-%m-%d');
			$b->id_empresa_franquia=$emp->id_empresa;
			
			if($emp->tipo=='CNPJ') $b->tipo=2; else $b->tipo=1;
			#gera boleto
			if((float)($b->valor)>(float)('0.00')) {
				$id_conta_fatura = $contaDAO->inserirBoletoBrad($b,'1','1');
			}

		$AddAddress = $emp->email;		
	    $mailer->SEND('financeiro@cartoriopostal.com.br', $AddAddress, $AddCC, $AddBCC, '', 'Royalties e FPP Cartório Postal', $html);
	}
	
	$retorna--;
}
echo '</pre>';
?>
