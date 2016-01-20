<?
#require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/classQuery.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require('../includes/dias_uteis.php');
ini_set('max_execution_time', '0');

pt_register('POST','mes');
pt_register('POST','ano');
pt_register('POST','origem');
pt_register('POST','busca_id_departamento');
$mes = 1;
$controle_id_empresa = 20;
$controle_id_usuario = 1;
	$dia='1';
	if($mes=='') $mes=date('m');
	if($ano=='') $ano=date('Y');
if($origem<>'') $onde = " and p.origem='".$origem."'";
if($busca_id_departamento<>'') $onde = " and pi.id_servico_departamento='".$busca_id_departamento."'";
$arquivoDiretorio = "./exporta/".$controle_id_usuario.".csv";
$nomeArquivo = $controle_id_usuario.".csv";


$arquivoConteudo  = 'Dia ;Total de Pedidos;No Prazo;Em Atraso ;Média; No Prazo Op.;Em Atraso  Op.;Média Op;Aberto;Conciliação;Cadastrado;Solicitação;Desembolso;Execução;Retorno;Faturamento;Entrega;Concluído;Confirmação;Pendente;Jurídico;Cancelado;Parado;Retomar;Orçamento;Operacional;Valor Total;Valor dos Cancelados; Recebido; Á Receber; Despesa;Valor dos Concluído;Despesa dos Concluído;Valor em Aberto;Despesa em Aberto;
';

    $p_valor='';
	$t_num_cadastrado=0;
	$t_num_prazo=0;
	$t_num_atraso=0;
	$t_num_cancelado=0;
	$t_num_concluido=0;
	$t_num_aberto=0;
	$t_num_valor=0;
	$t_num_valor_canc=0;
	$t_num_recebido=0;
	$t_num_receber=0;
	$t_num_despesa=0;	
	while($dia<=31){
	$query 	= $objQuery->SQLQuery("SELECT pi.* FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where pi.id_status='14' and pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$num_cancelado = mysql_num_rows($query);
	
    $sql_canc = $objQuery->SQLQuery("SELECT SUM(pi.valor) as total from vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u  where  pi.id_status='14' and pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$res_canc = mysql_fetch_array($sql_canc);
	$num_valor_canc = $res_canc['total'];
	
    $sql5 = $objQuery->SQLQuery("SELECT SUM(pi.valor) as total from vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u  where  pi.id_status!='14' and pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$res = mysql_fetch_array($sql5);
	$num_valor = $res['total'];	
	
    $sql5 = $objQuery->SQLQuery("SELECT SUM(pi.valor) as total from vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u  where  pi.id_status!='14' and pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_status='10' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$res = mysql_fetch_array($sql5);
	$num_valor_conc = $res['total'];		

	$query 	= $objQuery->SQLQuery("SELECT SUM(f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio) as valor_despesa FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u, vsites_financeiro as f where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and f.id_pedido_item=pi.id_pedido_item and f.financeiro_tipo='Desembolso' and f.financeiro_autorizacao='Aprovado' and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ".$onde);
	$res = mysql_fetch_array($query);
	$num_despesa = $res['valor_despesa'];

	$query 	= $objQuery->SQLQuery("SELECT SUM(f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio) as valor_despesa FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u, vsites_financeiro as f where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_status='10' and pi.id_usuario=u.id_usuario and f.id_pedido_item=pi.id_pedido_item and f.financeiro_tipo='Desembolso' and f.financeiro_autorizacao='Aprovado' and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ".$onde);
	$res = mysql_fetch_array($query);
	$num_despesa_conc = $res['valor_despesa'];
	
	$query 	= $objQuery->SQLQuery("SELECT SUM(f.financeiro_valor) as valor_recebido FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u, vsites_financeiro as f where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and f.id_pedido_item=pi.id_pedido_item and f.financeiro_tipo='Recebimento' and f.financeiro_autorizacao='Aprovado' and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ".$onde);
	$res = mysql_fetch_array($query);
	$num_recebido = $res['valor_recebido'];	

	$num_receber = $num_valor-$num_recebido;
	$query 	= $objQuery->SQLQuery("SELECT ".$data_prazo_inc." as data_prazo, pi.data, pi.inicio, pi.operacional, pi.dias, pi.id_status, pi.encerramento FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where pi.id_status!='14' and pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$num_total = mysql_num_rows($query);
    $num_total = $num_total+$num_cancelado;
	
	$num_atraso=0;
	$num_prazo =0;
	$num_atraso_op=0;
	$num_prazo_op =0;
	$num_concluido=0;
	$num_aberto=0;
	$num_conciliacao=0;
	$num_cadastrado=0;
	$num_solicitacao=0;
	$num_desembolso=0;
	$num_execucao=0;
	$num_retorno=0;
	$num_faturamento=0;
	$num_entrega=0;
	$num_confirmacao=0;
	$num_pendente=0;
	$num_juridico=0;
	$num_parado=0;
	$num_retomar=0;
	$num_orcamento=0;
	$num_operacional=0;
	
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
       if($data_prazo<$hoje and $id_status!='10' or $data_prazo<$data_encerramento and $id_status=='10' ) $num_atraso++; else
       $num_prazo++;
	   if($data_prazo<$hoje and $data_operacional=='0000-00-00' or $data_prazo<$data_operacional and $data_operacional!='0000-00-00' ) $num_atraso_op++; else
       $num_prazo_op++;
	   if($id_status==10) $num_concluido++;
	   if($id_status==1) $num_aberto++;
	   if($id_status==2) $num_conciliacao++;
	   if($id_status==3) $num_cadastrado++;
	   if($id_status==4) $num_solicitacao++;
	   if($id_status==5) $num_desembolso++;
	   if($id_status==6) $num_execucao++;
	   if($id_status==7) $num_retorno++;
	   if($id_status==8) $num_faturamento++;
	   if($id_status==9) $num_entrega++;
	   if($id_status==11) $num_confirmacao++;
	   if($id_status==12) $num_pendente++;
	   if($id_status==13) $num_juridico++;
	   if($id_status==15) $num_parado++;
	   if($id_status==99) $num_retomar++;
	   if($id_status==16) $num_orcamento++;
	   if($id_status==17) $num_operacional++;
 
    }

    if($num_atraso<>0 and $num_prazo<>0)
       $num_media = 100/($num_atraso+$num_prazo)*$num_prazo;
    else
       $num_media = 0;
	   
    if($num_atraso_op<>0 and $num_prazo_op<>0)
       $num_media_op = 100/($num_atraso_op+$num_prazo_op)*$num_prazo_op;
    else
       $num_media_op = 0;	   
	$num_valor_aberto = $num_valor-$num_valor_conc;
	$num_despesa_aberto = $num_despesa-$num_despesa_conc;
	$t_num_total= $t_num_total+$num_total;
	$t_num_prazo= $t_num_prazo+$num_prazo;
	$t_num_atraso= $t_num_atraso+$num_atraso;
	$t_num_cancelado= $t_num_cancelado+$num_cancelado;
	$t_num_concluido = $t_num_concluido+$num_concluido;
	$t_num_aberto = $t_num_aberto+$num_aberto;
	$t_num_valor= $t_num_valor+$num_valor;
	$t_num_valor_conc= $t_num_valor_conc+$num_valor_conc;
	$t_num_valor_canc= $t_num_valor_canc+$num_valor_canc;
	$t_num_recebido= $t_num_recebido+$num_recebido;
	$t_num_receber= $t_num_receber+$num_receber;
	$t_num_despesa= $t_num_despesa+$num_despesa;
	$t_num_despesa_conc= $t_num_despesa_conc+$num_despesa_conc;
	$t_num_despesa_aberto= $t_num_despesa_aberto+$num_despesa_aberto;
	$t_num_valor_aberto= $t_num_valor_aberto+$num_valor_aberto;
	
	$t_num_aberto= $t_num_aberto+$num_aberto;
	$t_num_cadastrado= $t_num_cadastrado+$num_cadastrado;
	$t_num_conciliacao= $t_num_conciliacao+$num_conciliacao;
	$t_num_solicitacao= $t_num_solicitacao+$num_solicitacao;
	$t_num_desembolso= $t_num_desembolso+$num_desembolso;
	$t_num_execucao= $t_num_execucao+$num_execucao;
	$t_num_retorno= $t_num_retorno+$num_retorno;
	$t_num_faturamento= $t_num_faturamento+$num_faturamento;
	$t_num_entrega= $t_num_entrega+$num_entrega;
	$t_num_confirmacao= $t_num_confirmacao+$num_confirmacao;
	$t_num_pendente= $t_num_pendente+$num_pendente;
	$t_num_juridico= $t_num_juridico+$num_juridico;
	$t_num_parado= $t_num_parado+$num_parado;
	$t_num_retomar= $t_num_retomar+$num_retomar;
	$t_num_orcamento= $t_num_orcamento+$num_orcamento;
	$t_num_operacional= $t_num_operacional+$num_operacional;
	$t_num_prazo_op= $t_num_prazo_op+$num_prazo_op;
	$t_num_atraso_op= $t_num_atraso_op+$num_atraso_op;
	
    $num_valor= number_format($num_valor,2,",",".");
	$num_valor_canc= number_format($num_valor_canc,2,",",".");
	$num_valor_conc= number_format($num_valor_conc,2,",",".");
	$num_recebido= number_format($num_recebido,2,",",".");
	$num_receber= number_format($num_receber,2,",",".");
	$num_despesa_aberto= number_format($num_despesa_aberto,2,",",".");
	$num_valor_aberto= number_format($num_valor_aberto,2,",",".");
	
	$num_despesa= number_format($num_despesa,2,",",".");
	$num_despesa_conc= number_format($num_despesa_conc,2,",",".");
    $num_media= number_format($num_media,2,",",".");
	$num_media_op= number_format($num_media_op,2,",",".");
	$p_valor .= $dia . ';' . $num_total . ';' . $num_prazo .';' . $num_atraso . ';' . $num_media . '%;' . $num_prazo_op .';' . $num_atraso_op . ';' . $num_media_op . '%;' . $num_aberto . ';'. $num_conciliacao . ';'. $num_cadastrado . ';'. $num_solicitacao . ';'. $num_desembolso . ';'. $num_execucao . ';'. $num_retorno . ';'. $num_faturamento . ';'. $num_entrega . ';'. $num_concluido . ';'. $num_confirmacao . ';'. $num_pendente . ';'. $num_juridico . ';'. $num_cancelado . ';'. $num_parado . ';' . $num_retomar . ';'. $num_orcamento . ';'. $num_operacional. ';'. $num_valor . ';' . $num_valor_canc . ';' . $num_recebido . ';' . $num_receber . ';' . $num_despesa . ';' . $num_valor_conc . ';' . $num_despesa_conc.';' . $num_valor_aberto . ';' . $num_despesa_aberto.';
	';
	$dia++;
	}

    if($t_num_atraso<>0 and $t_num_prazo<>0)
       $t_num_media = 100/($t_num_atraso+$t_num_prazo)*$t_num_prazo;
    else
       $t_num_media = 0;

    if($t_num_atraso_op<>0 and $t_num_prazo_op<>0)
       $t_num_media_op = 100/($t_num_atraso_op+$t_num_prazo_op)*$t_num_prazo_op;
    else
       $t_num_media_op = 0;
	   
    $t_num_valor= number_format($t_num_valor,2,",",".");
	$t_num_valor_conc= number_format($t_num_valor_conc,2,",",".");
	$t_num_valor_canc= number_format($t_num_valor_canc,2,",",".");
	$t_num_recebido= number_format($t_num_recebido,2,",",".");
	$t_num_receber= number_format($t_num_receber,2,",",".");
	$t_num_valor_aberto= number_format($t_num_valor_aberto,2,",",".");
	$t_num_despesa_aberto= number_format($t_num_despesa_aberto,2,",",".");
	$t_num_despesa= number_format($t_num_despesa,2,",",".");
	$t_num_despesa_conc= number_format($t_num_despesa_conc,2,",",".");
    $t_num_media= number_format($t_num_media,2,",",".");
	$t_num_media_op= number_format($t_num_media_op,2,",",".");
	$p_valor .= 'Total;'.$t_num_total . ';' . $t_num_prazo .';' . $t_num_atraso . ';' .  $t_num_media . '%;' . $t_num_prazo_op .';' . $t_num_atraso_op . ';' .  $t_num_media_op . '%;' . $t_num_aberto . ';'. $t_num_conciliacao . ';'. $t_num_cadastrado . ';'. $t_num_solicitacao . ';'. $t_num_desembolso . ';'. $t_num_execucao . ';'. $t_num_retorno . ';'. $t_num_faturamento . ';'. $t_num_entrega . ';'. $t_num_concluido . ';'. $t_num_confirmacao . ';'. $t_num_pendente . ';'. $t_num_juridico . ';'. $t_num_cancelado . ';'. $t_num_parado . ';' . $t_num_retomar . ';'. $t_num_orcamento . ';'. $t_num_operacional. ';' . $t_num_valor . ';' . $t_num_valor_canc . ';' . $t_num_recebido . ';' . $t_num_receber . ';' . $t_num_despesa . ';' . $t_num_valor_conc . ';' . $t_num_despesa_conc . ';' . $t_num_valor_aberto . ';' . $t_num_despesa_aberto . ';';	
	$arquivoConteudo  .=  $p_valor;


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
} else {
   echo"<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
   exit;
}	
?>