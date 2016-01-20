<?
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require('../includes/dias_uteis.php');
$permissao = verifica_permissao('Rel_atendimento',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

	
pt_register('POST','mes');
$dia='1';
$ano='2009';

pt_register('POST','busca_id_usuario');
pt_register('POST','busca_origem');
$onde ='';
if($busca_id_usuario<>''){ $onde .= " and pi.id_usuario='".$busca_id_usuario."'"; }
if($busca_origem<>''){ $onde .= " and p.origem='".$busca_origem."'"; }

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".csv";
$nomeArquivo = $controle_id_usuario.".csv";


$arquivoConteudo  = 'Dia ;Recebido;Orçamento;Cadastrado;Conciliação;Aberto;Pendente;Cancelado;Duplicidade;Falta de Dados
';
$dia=1;
	while($dia<=31){
	
	$query 	= $objQuery->SQLQuery("SELECT pi.id_pedido_item FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where pi.id_status='16' and pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$num_orcamento = mysql_num_rows($query);	
	
	$query 	= $objQuery->SQLQuery("SELECT pi.id_pedido_item FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where pi.id_atividade='200' and pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$num_duplicidade = mysql_num_rows($query);
	
	$query 	= $objQuery->SQLQuery("SELECT pi.id_pedido_item FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where pi.id_atividade='204' and pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$num_faltadedados = mysql_num_rows($query);
	
	$query 	= $objQuery->SQLQuery("SELECT pi.id_pedido_item FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where pi.id_status='14' and pi.id_atividade!='200' and pi.id_atividade!='204' and (pi.atendimento >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.atendimento <= '".$ano."-".$mes."-".$dia." 23:59:59' or pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and  pi.atendimento = '0000-00-00 00:00:00') and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$num_cancelado = mysql_num_rows($query);
	
	$query 	= $objQuery->SQLQuery("SELECT pi.id_pedido_item FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$num_recebido = mysql_num_rows($query);
	
	$query 	= $objQuery->SQLQuery("SELECT pi.id_pedido_item FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where pi.id_status='1' and pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$num_aberto = mysql_num_rows($query);	
	
	$query 	= $objQuery->SQLQuery("SELECT pi.id_pedido_item FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where pi.id_status='12' and pi.data >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.data <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	$num_pendente = mysql_num_rows($query);	
	
	$query 	= $objQuery->SQLQuery("SELECT ".$data_prazo_inc." as data_prazo, pi.data, pi.inicio, pi.dias, pi.id_status, pi.encerramento FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where pi.id_status!='14' and pi.atendimento >= '".$ano."-".$mes."-".$dia." 00:00:00' and  pi.atendimento <= '".$ano."-".$mes."-".$dia." 23:59:59' and pi.id_usuario=u.id_usuario and u.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido ". $onde);
	
	$num_conciliacao=0;
	$num_cadastrado=0;
	
    while($res = mysql_fetch_array($query)){
	   $id_status = $res['id_status'];
	   if($id_status==2  or $id_status==11)  $num_conciliacao++; else
	   if($id_status!=1 and $id_status!=12 and $id_status!=16)  $num_cadastrado++;
    }

	$t_num_cadastrado= $t_num_cadastrado+$num_cadastrado;
	$t_num_cancelado= $t_num_cancelado+$num_cancelado;
	$t_num_faltadedados= $t_num_faltadedados+$num_faltadedados;
	$t_num_duplicidade= $t_num_duplicidade+$num_duplicidade;
	$t_num_aberto = $t_num_aberto+$num_aberto;
	$t_num_conciliacao = $t_num_conciliacao+$num_conciliacao;
	$t_num_recebido = $t_num_recebido+$num_recebido;
	$t_num_orcamento = $t_num_orcamento+$num_orcamento;
	$t_num_pendente = $t_num_pendente+$num_pendente;
	$p_valor .= $dia . ';' . $num_recebido . ';'. $num_orcamento . ';' . $num_cadastrado . ';'  . $num_conciliacao . ';'. $num_aberto . ';'. $num_pendente . ';' . $num_cancelado . ';' . $num_duplicidade . ';' . $num_faltadedados . ';
';
	
	$dia++;
	}
	   
    
	
	
	
	
    
	$p_valor .= 'Total;'.$t_num_recebido . ';' . $t_num_orcamento .';' . $t_num_cadastrado . ';' . $t_num_conciliacao. ';' . $t_num_aberto . ';' . $t_num_pendente . ';' . $t_num_cancelado . ';' . $t_num_duplicidade . ';' . $t_num_faltadedados . ';
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