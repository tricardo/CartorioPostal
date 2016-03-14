<?
$dia_f=date('d');
$empresaDAO = new EmpresaDAO();
$relatorioDAO = new RelatorioDAO();

$retorna = 14;

while($retorna>0){

	$ano_mes = date('Y-m',strtotime("-".$retorna." month"));
	$ano_mes_exp = explode('-',$ano_mes);	
	$mes_referencia = date('m/Y',strtotime("-".$retorna." month"));
	$empresas = $empresaDAO->listarTodas();
	$mes=$ano_mes_exp[1];
	$ano=$ano_mes_exp[0];
foreach($empresas as $emp){
	$id_empresa = $emp->id_empresa;

	//Você pode colocar aqui o nome do arquivo que você deseja salvar.
	$nomeArquivo = 'geral_'.date("sshYmdhms")."_".$id_empresa.".xls";
	$arquivoDiretorio = "../relatorios/geral/".$nomeArquivo;

	$excel=new ExcelWriter($arquivoDiretorio);

	if($excel==false){
		echo $excel->error;
		exit;
	}

	//Unidade
	$myArr=array('Relatório de Faturamento:'.$emp->fantasia);
	$excel->writeLine($myArr);

	//periodo
	$myArr=array('Relatório Gerado em: '.date('d/m/Y'));
	$excel->writeLine($myArr);

	//periodo
	$myArr=array('Período : '.$mes_referencia);
	$excel->writeLine($myArr);

	$myArr=array('');
	$excel->writeLine($myArr);
	
	$dia=1;
	//campos
	$myArr=array('Dia','Total de Pedidos','No Prazo','Em Atraso ','Média',' No Prazo Op.','Em Atraso  Op.','Média Op','Qtdd de Abertos','Valor dos Abertos','Qtdd de Cancelados','Valor dos Cancelados','Qtdd em Conciliação','Valor em Conciliação',' Qtdd de Concluído','Valor Concluído','Qtdd de Faturamento','Valor de Faturamento','Recebido','À Receber','Google Cancelado','Google Valor Cancelado','Google Conciliação','Google Valor Conciliação','Google Fechado','Google Valor Fechado','Google Total','Google Valor Total');
	$excel->writeLine($myArr);

	$t_num_prazo				= '';
	$t_num_atraso				= '';
	$t_num_media				= '';
	$t_num_prazo_op				= '';
	$t_num_atraso_op			= '';
	$t_num_media_op				= '';
	$t_num_aberto				= '';
	$t_num_valor_aberto			= '';
	$t_num_conciliacao			= '';
	$t_num_valor_conciliacao	= '';
	$t_num_fechado				= '';
	$t_num_valor_fechado		= '';
	$t_num_cancelado			= '';
	$t_num_valor_cancelado		= '';
	$t_num_concluido			= '';
	$t_num_valor_concluido		= '';
	$t_num_total 				= '';
	$t_num_valor_recebido		= '';
	$t_num_google				= '';
	$t_num_valor_google			= '';
	$t_num_google_c				= '';
	$t_num_valor_google_c		= '';
	$t_num_google_con			= '';
	$t_num_valor_google_con		= '';
	$t_num_google_f				= '';
	$t_num_valor_google_f		= '';

	while($dia<=31){

		$num_prazo					= '';
		$num_atraso					= '';
		$num_media					= '';
		$num_prazo_op				= '';
		$num_atraso_op				= '';
		$num_media_op				= '';
		$num_aberto					= '';
		$num_valor_aberto			= '';
		$num_conciliacao			= '';
		$num_valor_conciliacao		= '';
		$num_fechado				= '';
		$num_valor_fechado			= '';
		$num_cancelado				= '';
		$num_valor_cancelado		= '';
		$num_concluido				= '';
		$num_valor_concluido		= '';
		$num_total 					= '';
		$num_valor_recebido			= '';
		$num_google					= '';
		$num_valor_google			= '';
		$num_google_c				= '';
		$num_valor_google_c			= '';
		$num_google_con				= '';
		$num_valor_google_con		= '';
		$num_google_f				= '';
		$num_valor_google_f			= '';
	
		#total de pedidos
		$query 	= $objQuery->SQLQuery("SELECT pi.data_prazo, pi.data, pi.inicio, pi.operacional, pi.dias, pi.id_status, pi.encerramento, pi.valor, pi.valor_rec as recebido, p.origem FROM 
			vsites_pedido_item as pi,
			vsites_pedido as p, 
			vsites_user_usuario as u 
			where 
				pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  
				pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and 
				pi.id_usuario=u.id_usuario and u.id_empresa='".$id_empresa."' and 
				pi.id_pedido=p.id_pedido ". $onde);
		$num_total = mysql_num_rows($query);
		
		
		$hoje = date('Y-m-d');
		while($res = mysql_fetch_array($query)){
			$data = $res['data'];
			$data = invert($data,'/','PHP');
			$data_prazo = invert($res['data_prazo'],'/','PHP');
			$data_prazo = invert($data_prazo,'-','SQL');
			$data_encerramento = invert($res['encerramento'],'/','PHP');
			$data_encerramento = invert($data_encerramento,'-','SQL');
			$data_operacional = $res['operacional'];
			$id_status = $res['id_status'];
			$num_valor_recebido = $res['recebido'];
			$origem = $res['origem'];

			if($data_prazo<$hoje and $data_encerramento=='0000-00-00' or $data_prazo<$data_encerramento and $data_encerramento!='0000-00-00' ) $num_atraso++; 
			else $num_prazo++;
			
			if($data_prazo<$hoje and $data_operacional=='0000-00-00' or $data_prazo<$data_operacional and $data_operacional!='0000-00-00' ) $num_atraso_op++; 
			else $num_prazo_op++;
			
			if($id_status==1 or $id_status==16) { 
				$num_aberto++;
				$num_valor_aberto=(float)($num_valor_aberto)+(float)($res['valor']);
			}

			if($id_status==2 or $id_status==11) { 
				$num_conciliacao++;
				$num_valor_conciliacao=(float)($num_valor_conciliacao)+(float)($res['valor']);
			}
			if($id_status==3) { 
				$num_cadastrado++;
				$num_valor_cadastrado=(float)($num_valor_cadastrado)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($id_status==4) { 
				$num_solicitacao++;
				$num_valor_solicitacao=(float)($num_valor_solicitacao)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}				
			if($id_status==5) { 
				$num_desembolso++;
				$num_valor_desembolso=(float)($num_valor_desembolso)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}

			if($id_status==12) { 
				$num_pendente++;
				$num_valor_pendente=(float)($num_valor_pendente)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}	

			if($id_status==6) { 
				$num_execucao++;
				$num_valor_execucao=(float)($num_valor_execucao)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}	
			if($id_status==7) { 
				$num_retorno++;
				$num_valor_retorno=(float)($num_valor_retorno)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($id_status==8) { 
				$num_faturamento++;
				$num_valor_faturamento=(float)($num_valor_faturamento)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($id_status==9) { 
				$num_entrega++;
				$num_valor_entrega=(float)($num_valor_entrega)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($id_status==10){ 
				$num_concluido++; 
				$num_valor_concluido=(float)($num_valor_concluido)+(float)($res['valor']); 
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($id_status==13){ 
				$num_juridico++;
				$num_valor_juridico=(float)($num_valor_juridico)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($id_status==14){ 
				$num_cancelado++;
				$num_valor_cancelado=(float)($num_valor_cancelado)+(float)($res['valor']);
			}
			if($id_status==15){ 
				$num_parado++;
				$num_valor_parado=(float)($num_valor_parado)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($id_status==17){ 
				$num_operacional++;
				$num_valor_operacional=(float)($num_valor_operacional)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($id_status==18){
				$num_entrega_franquia++;
				$num_valor_entrega_franquia=(float)($num_valor_entrega_franquia)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($id_status==19){ 
				$num_conciliacao_franquia++;
				$num_valor_conciliacao_franquia=(float)($num_valor_conciliacao_franquia)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($id_status==99){ 
				$num_retomar++;
				$num_valor_retomar=(float)($num_valor_retomar)+(float)($res['valor']);
				$num_fechado++;
				$num_valor_fechado=(float)($num_valor_fechado)+(float)($res['valor']);				
			}
			if($origem=='Google' or $origem=='Site') { 
				if($id_status!=14 and $id_status!=2 and $id_status!=11){ 
					$num_google_f++;
					$num_valor_google_f=(float)($num_valor_google_f)+(float)($res['valor']);
				}
				if($id_status==14){ 
					$num_google_c++;
					$num_valor_google_c=(float)($num_valor_google_c)+(float)($res['valor']);
				}
				if($id_status==2 or $id_status==11){ 
					$num_google_con++;
					$num_valor_google_con=(float)($num_valor_google_con)+(float)($res['valor']);
				}
				$num_google++;
				$num_valor_google=(float)($num_valor_google)+(float)($res['valor']);
			}				
			
		}

		$num_valor_areceber=(float)($num_valor_fechado)-(float)($num_valor_recebido);

		if($num_atraso<>0 and $num_prazo<>0)
			$num_media = 100/($num_atraso+$num_prazo)*$num_prazo;
		else
			$num_media = 0;

		if($num_atraso_op<>0 and $num_prazo_op<>0)
			$num_media_op = 100/($num_atraso_op+$num_prazo_op)*$num_prazo_op;
		else
			$num_media_op = 0;

		$num_media_op= number_format($num_media_op,2,",",".");
		
		//campos
		$myArr=array($dia,$num_total,$num_prazo,$num_atraso,$num_media,$num_prazo_op,$num_atraso_op,$num_media_op,$num_aberto,$num_valor_aberto,$num_cancelado,$num_valor_cancelado,$num_conciliacao,$num_valor_conciliacao,$num_concluido,$num_valor_concluido,$num_fechado,$num_valor_fechado,$num_valor_recebido,$num_valor_areceber,$num_google_c,$num_valor_google_c,$num_google_con,$num_valor_google_con,$num_google_f,$num_valor_google_f,$num_google,$num_valor_google);
		$excel->writeLine($myArr);
		$dia++;
		
		$t_num_total 				= $t_num_total+$num_total;
		$t_num_prazo				= $t_num_prazo+$num_prazo;
		$t_num_atraso				= $t_num_atraso+$num_atraso;
		$t_num_prazo_op				= $t_num_prazo_op+$num_prazo_op;
		$t_num_atraso_op			= $t_num_atraso_op+$num_atraso_op;
		$t_num_aberto				= $t_num_aberto+$num_aberto;
		$t_num_valor_aberto			= (float)($t_num_valor_aberto)+(float)($num_valor_aberto);
		$t_num_conciliacao			= $t_num_conciliacao+$num_conciliacao;
		$t_num_valor_conciliacao	= (float)($t_num_valor_conciliacao)+(float)($num_valor_conciliacao);
		$t_num_fechado				= $t_num_fechado+$num_fechado;
		$t_num_valor_fechado		= (float)($t_num_valor_fechado)+(float)($num_valor_fechado);
		$t_num_cancelado			= $t_num_cancelado+$num_cancelado;
		$t_num_valor_cancelado		= (float)($t_num_valor_cancelado)+(float)($num_valor_cancelado);
		$t_num_concluido			= $t_num_concluido+$num_concluido;
		$t_num_valor_concluido		= (float)($t_num_valor_concluido)+(float)($num_valor_concluido);
		$t_num_valor_recebido		= $t_num_valor_recebido+$num_valor_recebido;
		$t_num_google				= $t_num_google+$num_google;
		$t_num_valor_google			= (float)($t_num_valor_google)+(float)($num_valor_google);
		$t_num_google_c				= $t_num_google_c+$num_google_c;
		$t_num_valor_google_c		= (float)($t_num_valor_google_c)+(float)($num_valor_google_c);
		$t_num_google_con			= $t_num_google_con+$num_google_con;
		$t_num_valor_google_con		= (float)($t_num_valor_google_con)+(float)($num_valor_google_con);
		$t_num_google_f				= $t_num_google_f+$num_google_f;
		$t_num_valor_google_f		= (float)($t_num_valor_google_f)+(float)($num_valor_google_f);

	}
	$t_num_valor_areceber		= (float)($t_num_valor_fechado)-(float)($t_num_valor_recebido);

	if($t_num_atraso<>0 and $t_num_prazo<>0)
		$t_num_media = 100/($t_num_atraso+$t_num_prazo)*$t_num_prazo;
	else
		$t_num_media = 0;

	if($t_num_atraso_op<>0 and $t_num_prazo_op<>0)
		$t_num_media_op = 100/($t_num_atraso_op+$t_num_prazo_op)*$t_num_prazo_op;
	else
		$t_num_media_op = 0;
	$t_num_media_op= number_format($t_num_media_op,2,",",".");

	$myArr=array('Total',$t_num_total,$t_num_prazo,$t_num_atraso,$t_num_media,$t_num_prazo_op,$t_num_atraso_op,$t_num_media_op,$t_num_aberto,$t_num_valor_aberto,$t_num_cancelado,$t_num_valor_cancelado,$t_num_conciliacao,$t_num_valor_conciliacao,$t_num_concluido,$t_num_valor_concluido,$t_num_fechado,$t_num_valor_fechado,$t_num_valor_recebido,$t_num_valor_areceber,$t_num_google_c,$t_num_valor_google_c,$t_num_google_con,$t_num_valor_google_con,$t_num_google_f,$t_num_valor_google_f,$t_num_google,$t_num_valor_google);
	$excel->writeLine($myArr);
	
	$excel->close();
	
	$objQuery->SQLQuery("INSERT INTO vsites_relatorios VALUES (null, ".$id_empresa.", 'relatório geral', '".$arquivoDiretorio."', '".$ano."-".$mes."-01') ");
	echo 'Relatório de '.$id_empresa;
}
$retorna--;
}
exit;
?>