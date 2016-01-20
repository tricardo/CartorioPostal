<?
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require('../includes/dias_uteis.php');
ini_set('max_execution_time', '0');
$permissao = verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('POST','mes');
pt_register('POST','ano');
pt_register('POST','rel_mensal');
	$dia='1';
	if($mes=='') $mes=date('m');
	if($ano=='') $ano=date('Y');
	
$arquivoDiretorio = "./exporta/".$controle_id_usuario.".csv";
$nomeArquivo = $controle_id_usuario.".csv";

$arquivoConteudo  = 'Pedidos Concluídos ';
$arquivoConteudo.=($rel_mensal)?' em ':' após ';
$arquivoConteudo.=': '.$mes.'/'.$ano.';
Pedido ;Serviço;Descrição;Variação ;Desembolso; Sedex;Rateio;Valor Cobrado;Valor da Tabela;
';
if($rel_mensal){
	$where =" and pi.encerramento<='".$ano."-".$mes."-31 23:59:59'";
}

	$num_receber = $num_valor-$num_recebido;
	$query 	= $objQuery->SQLQuery("SELECT pi.id_pedido_item,pi.id_pedido, pi.ordem, s.descricao, sv.variacao, 

										replace(pi.valor,'.',',') as valor_cobrado, replace(sv.valor_1,'.',',') as tabela 
								FROM vsites_pedido_item pi
								INNER JOIN  vsites_servico_var as sv ON pi.id_servico_var = sv.id_servico_var
								INNER JOIN  vsites_servico as s ON 	pi.id_servico=s.id_servico 
								INNER JOIN vsites_user_usuario as uu ON pi.id_usuario=uu.id_usuario
								WHERE pi.encerramento>='".$ano."-".$mes."-01 00:00:00'
								".$where." 
								and pi.id_status='10' 
								and uu.id_empresa='".$controle_id_empresa."' 
								GROUP BY pi.id_pedido_item");

   while($res = mysql_fetch_array($query)){
    $p_valor  .= $res['id_pedido'].';'.$res['ordem'].';'.$res['descricao'].';'.$res['variacao'].';'.$res['desembolso'].';'.$res['sedex'].';'.$res['rareio'].';'.$res['valor_cobrado'].';'.$res['tabela'].';
';
    }
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