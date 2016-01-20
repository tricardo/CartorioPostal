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
$fantasia = $res['fantasia'].' - '.$res['royalties'].'%';
$royalties = $res['royalties'];

$onde ='';
if($busca_id_empresa<>''){ $onde .= " and u.id_empresa='".$busca_id_empresa."'"; }

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);



$arquivoDiretorio = "./exporta/".$controle_id_usuario.".csv";
$nomeArquivo = $controle_id_usuario.".csv";


$arquivoConteudo  = $fantasia.';
Referência:; '.$mes.'/'.$ano.';
Dia;Faturamento;Impostos;Royalties;Propaganda
';

    $p_valor='';
	$dia=1;
    while($dia<=31){
	
	$query 	= $objQuery->SQLQuery("SELECT sum( pi.valor) as valor_fat FROM vsites_pedido_item as pi, vsites_user_usuario as u where pi.encerramento >= '".$ano."-".$mes."-".$dia." 00:00:00' and pi.encerramento <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa!='1' and pi.id_status!='14' ".$onde);
	$res = mysql_fetch_array($query);
	$num_fat = $res['valor_fat'];

	$t_num_fat = $t_num_fat+$num_fat;

	$query22 	= $objQuery->SQLQuery("SELECT pi.id_pedido, pi.ordem, pi.valor FROM vsites_pedido_item as pi, vsites_user_usuario as u where pi.encerramento >= '".$ano."-".$mes."-".$dia." 00:00:00' and pi.encerramento <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa!='1' and pi.id_status!='14' ".$onde);
	while($res22 = mysql_fetch_array($query22)){
		$pedidos .= '#'.$res22['id_pedido'].'/'.$res22['ordem'].';'.str_replace('.',',',$res22['valor']).';
';
	}    
		
	$num_royalties = (float)(($num_fat-((float)($num_fat)/100*(float)($imposto)))/100)*(float)($royalties);
	$num_propaganda = (float)(($num_fat-((float)($num_fat)/100*(float)($imposto)))/100)*(float)(2);
	$t_num_royalties = $t_num_royalties+$num_royalties;
	$t_num_propaganda = $t_num_propaganda+$num_propaganda;
	$num_royalties= number_format($num_royalties,2,",",".");
	$num_propaganda= number_format($num_propaganda,2,",",".");
	$num_fat= number_format($num_fat,2,",",".");
	$p_valor .= $dia . ';'.$num_fat.';'.$imposto.';' . $num_royalties. ';' . $num_propaganda. ';
';
	$dia++;
	}
	$t_num_fat= number_format($t_num_fat,2,",",".");
	$t_num_propaganda= number_format($t_num_propaganda,2,",",".");
	$t_num_royalties= number_format($t_num_royalties,2,",",".");
	$p_valor .= 'Total;'.$t_num_fat.';'.$imposto.';'.$t_num_royalties. ';'.$t_num_propaganda. ';
';	


	$p_valor .= 'Pedidos Contabilizados:
'.$pedidos;
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