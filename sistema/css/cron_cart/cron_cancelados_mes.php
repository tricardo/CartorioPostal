<?
$empresaDAO = new EmpresaDAO();
$relatorioDAO = new RelatorioDAO();

$dia=date('d');
$mes=date('m');
$ano=date('Y');
echo '<pre>';

$empresas = $empresaDAO->listarTodas();
foreach($empresas as $emp){
	$id_empresa = $emp->id_empresa;
	//Você pode colocar aqui o nome do arquivo que você deseja salvar.
	$nomeArquivo = 'cancelados'.date("ssHYmdhms")."_".$id_empresa.".xls";
	$arquivoDiretorio = "../relatorios/canceladosmes/".$nomeArquivo;

	$excel=new ExcelWriter($arquivoDiretorio);

	if($excel==false){
		echo $excel->error;
		exit;
	}
	echo "\n\t".date("H:i:s u",time())." [ ".time()."]\t";


	//Unidade
	$myArr=array('Relação de pedidos cancelados da unidade:'.$emp->fantasia);
	$excel->writeLine($myArr);

	//periodo
	$myArr=array('Relatório Gerado em : '.date('d/m/Y'));
	$excel->writeLine($myArr);

	//periodo
	$myArr=array('Referente Período de : 01/'.$mes.'/'.$ano.' até '.$dia.'/'.$mes.'/'.$ano);
	$excel->writeLine($myArr);

	//espaço
	$myArr=array(' ');
	$excel->writeLine($myArr);

	//campos
	$myArr=array('Pedido','Origem','Data de Cadastro','Status','Motivo de Cancelamento');
	$excel->writeLine($myArr);

	$p_valor='';
	$sql = "SELECT pi.id_pedido, pi.ordem, p.origem, pi.data, pi.id_status, ps.status_obs, s.status FROM 
								vsites_pedido_item as pi LEFT JOIN vsites_status as s ON s.id_status=pi.id_status,
								vsites_pedido_status as ps,
								vsites_pedido as p,
								vsites_user_usuario as u
								WHERE 
									pi.id_status='14' and 
									pi.data >= '".$ano."-".$mes."-01 00:00:00' and  
									pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and 
									pi.id_usuario=u.id_usuario and u.id_empresa='".$id_empresa."' and 
									pi.id_pedido=p.id_pedido and
									(ps.id_atividade=124 or ps.id_atividade=204 or ps.id_atividade=200) and	
									pi.id_pedido_item = ps.id_pedido_item 
									group by pi.id_pedido_item order by pi.id_pedido_item DESC, ps.id_pedido_status desc";
	$query 	= $objQuery->SQLQuery($sql);
	$num_cancelado = mysql_num_rows($query);
	while($res = mysql_fetch_array($query)){
		$data = $res['data'];
		$data = invert($data,'/','PHP');

		//Escreve o nome dos campos de uma tabela
		$myArr=array($res['id_pedido'].'-'.$res['ordem'],$res['origem'],$data,$res['status'],$res['status_obs']);
		$excel->writeLine($myArr);

	}

	$excel->close();

	echo " ... ".date("H:i:s u",time())." [ ".time()."]";
	$relatorioDAO->registraRel($id_empresa,$arquivoDiretorio,'relatório de cancelados');

}
echo '</pre>';
?>