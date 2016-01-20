<?
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$dia='1';
pt_register('POST','mes');
pt_register('POST','ano');
if($ano=='') $ano = date('Y');
	
$permissao = verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' || $controle_id_empresa!='1'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

pt_register('POST','busca_id_empresa');

$sql = $objQuery->SQLQuery("SELECT imposto, fantasia, royalties from vsites_user_empresa as ue where id_empresa!='1' and id_empresa='".$busca_id_empresa."' order by nome");
$res = mysql_fetch_array($sql);
$imposto = $res['imposto'];
$fantasia = $res['fantasia'];
$royalties = $res['royalties'];

$onde ='';
if($busca_id_empresa<>''){ $onde .= " and u.id_empresa='".$busca_id_empresa."'"; }

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);



$arquivoDiretorio = "./exporta/".$controle_id_usuario.".csv";
$nomeArquivo = $controle_id_usuario.".csv";


$arquivoConteudo  = $fantasia.';
Referência:; '.$mes.'/'.$ano.'
Dia;Cadastrado ;Em Aberto;Concluídos;Cancelados;Faturamento;Despesas;Recebimento
';

    $p_valor='';
	$dia=1;
    while($dia<=31){
	$query 	= $objQuery->SQLQuery("SELECT pi.id_status FROM vsites_pedido_item as pi, vsites_user_usuario as u where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_status='10' and pi.id_usuario=u.id_usuario and u.id_empresa!='1' ".$onde);
	$num_concluido = mysql_num_rows($query);
    $t_num_concluido = $t_num_concluido+$num_concluido;
	
	$query 	= $objQuery->SQLQuery("SELECT pi.id_status FROM vsites_pedido_item as pi, vsites_user_usuario as u where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa!='1' ".$onde);
	$num_cadastrados = mysql_num_rows($query);
    $t_num_cadastrados = $t_num_cadastrados+$num_cadastrados;
	
	$query 	= $objQuery->SQLQuery("SELECT pi.id_status FROM vsites_pedido_item as pi, vsites_user_usuario as u where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_status!='14' and pi.id_status!='10' and pi.id_usuario=u.id_usuario and u.id_empresa!='1' ".$onde);
	$num_abertos = mysql_num_rows($query);
    $t_num_abertos = $t_num_abertos+$num_abertos;

	$query 	= $objQuery->SQLQuery("SELECT pi.id_status FROM vsites_pedido_item as pi, vsites_user_usuario as u where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_status='14' and pi.id_usuario=u.id_usuario and u.id_empresa!='1' ".$onde);
	$num_cancelados = mysql_num_rows($query);
    $t_num_cancelados = $t_num_cancelados+$num_cancelados;
	
	$query 	= $objQuery->SQLQuery("SELECT SUM(pi.valor) as valor_soma FROM vsites_pedido_item as pi, vsites_user_usuario as u where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_status!='14' and pi.id_usuario=u.id_usuario and u.id_empresa!='1' ".$onde);
	$res = mysql_fetch_array($query);
	$num_faturamento_total = $res['valor_soma'];

	$query 	= $objQuery->SQLQuery("SELECT SUM(f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio) as valor_despesa FROM vsites_pedido_item as pi, vsites_user_usuario as u, vsites_financeiro as f where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa!='1' and f.id_pedido_item=pi.id_pedido_item and f.financeiro_tipo='Desembolso' and f.financeiro_autorizacao='Aprovado' ".$onde);
	$res = mysql_fetch_array($query);
	$num_despesa = $res['valor_despesa'];
	
	$query 	= $objQuery->SQLQuery("SELECT SUM(f.financeiro_valor) as valor_recebimento FROM vsites_pedido_item as pi, vsites_user_usuario as u, vsites_financeiro as f where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa!='1' and f.id_pedido_item=pi.id_pedido_item and f.financeiro_tipo='Recebimento' and f.financeiro_autorizacao='Aprovado' ".$onde);
	$res = mysql_fetch_array($query);
	$num_recebimento = $res['valor_recebimento'];
	
	$t_num_faturamento = $t_num_faturamento+$num_faturamento;
	$t_num_faturamento_total = $t_num_faturamento_total+$num_faturamento_total;
    $num_faturamento= number_format($num_faturamento,2,",",".");
	$num_faturamento_total= number_format($num_faturamento_total,2,",",".");
	
	$t_num_despesa = $t_num_despesa+$num_despesa;
	$num_despesa= number_format($num_despesa,2,",",".");
	
	$t_num_recebimento = $t_num_recebimento+$num_recebimento;
	$num_recebimento= number_format($num_recebimento,2,",",".");
	
	#$num_royalties = (float)(($num_faturamento-($num_faturamento/100*$imposto))/100)*(float)($royalties);
	#$t_num_royalties = $t_num_royalties+$num_royalties;
	#$num_royalties= number_format($num_royalties,2,",",".");
	
	#$num_cadastrados = $num_abertos+$num_concluido+$num_cancelados;
	
	$p_valor .= $dia . ';'. $num_cadastrados . ';'  . $num_abertos . ';' . $num_concluido . ';' . $num_cancelados . ';' . $num_faturamento_total .';' . $num_despesa . ';' . $num_recebimento . ';
';
	$dia++;
	}
	
	#$t_num_cadastrados  = $t_num_abertos+$t_num_concluido+$t_num_cancelados;
	
	$t_num_despesa      = number_format($t_num_despesa,2,",",".");
	$t_num_recebimento      = number_format($t_num_recebimento,2,",",".");
	$t_num_faturamento  = number_format($t_num_faturamento,2,",",".");
	$t_num_faturamento_total= number_format($t_num_faturamento_total,2,",",".");
	$t_num_royalties= number_format($t_num_royalties,2,",",".");
	
	$p_valor .= 'Total;'.$t_num_cadastrados.';'.$t_num_abertos.';'.$t_num_concluido.';'.$t_num_cancelados.';'.$t_num_faturamento_total.';'.$t_num_despesa.';'.$t_num_recebimento.';
';	

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