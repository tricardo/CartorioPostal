<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('GET','busca_data_i');
pt_register('GET','busca_data_f');
pt_register('GET','busca_autorizacao');
pt_register('GET','busca_forma');
pt_register('GET','busca_id_status');
pt_register('GET','busca_id_empresa');
if($busca_id_status=='Todos'){
   $busca_id_status = '';
}

if($busca_id_empresa=='') {
	$onde_empresa = "u.id_empresa = '".$controle_id_empresa."' and ";
	$empresa_selecionada = 'Minha Unidade';
}else {
	if($busca_id_empresa=='_') {
		$onde_empresa = "pi.id_empresa_resp = '".$controle_id_empresa."' and ";
		$empresa_selecionada = 'Todas as Unidades Excedo a minha';
	} else {
		$onde_empresa = "pi.id_empresa_resp = '".$controle_id_empresa."' and u.id_empresa = '".$busca_id_empresa."' and";
		$sql = $objQuery->SQLQuery("SELECT fantasia from vsites_user_empresa as e where id_empresa='".$busca_id_empresa."'");		
		$res = mysql_fetch_array($sql);
		$empresa_selecionada = $res['fantasia'];
	}	
}

$datai_sql = invert($busca_data_i,'-','SQL').' '.substr($busca_data_i,11, 8);
$dataf_sql = invert($busca_data_f,'-','SQL').' '.substr($busca_data_f,11, 8);
$onde='';

if($busca_data_i<>'' and ($busca_autorizacao!='' and $busca_autorizacao!='Pendente')){ $onde .= " and f.financeiro_autorizacao_data>='".$datai_sql."'"; }
if($busca_data_i<>'' and ($busca_autorizacao=='' or $busca_autorizacao=='Pendente')){ $onde .= " and f.financeiro_data>='".$datai_sql."'"; }

if($busca_data_f<>'' and ($busca_autorizacao!='' and $busca_autorizacao!='Pendente')){ $onde .= " and f.financeiro_autorizacao_data<='".$dataf_sql."'"; }
if($busca_data_f<>'' and ($busca_autorizacao=='' or $busca_autorizacao=='Pendente')){ $onde .= " and f.financeiro_data<='".$dataf_sql."'"; }

if($busca_forma<>'') $onde .= " and f.financeiro_forma='".$busca_forma."'";

if($busca_id_status<>''){ 
   $onde .= " and pi.id_status='".$busca_id_status."'";
}

if($busca_autorizacao<>'') $onde .= " and f.financeiro_autorizacao='".$busca_autorizacao."'";

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".csv";
$nomeArquivo = $controle_id_usuario.".csv";


$arquivoConteudo  = 'Relatório ;'.$busca_autorizacao.';'.$empresa_selecionada.';;;;;;
';
$arquivoConteudo  .= 'Entre ;'.$busca_data_i.' e '.$busca_data_f.' ;tirado em '.date('d/m/Y H:i:s').';;;;;;
';

$arquivoConteudo  .= 'Data/Hora;Ordem;Descrição;Pago;Troco;Valor;;Feito;
';
  
			$sql = $objQuery->SQLQuery("SELECT f.financeiro_forma, f.rel, f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio as financeiro_valor, f.financeiro_desembolsado, f.financeiro_descricao, f.financeiro_troco, f.financeiro_autorizacao_data, f.financeiro_agencia, f.financeiro_conta, f.financeiro_favorecido, f.financeiro_identificacao, u.nome, pi.id_pedido, pi.ordem from
            vsites_user_usuario as u, vsites_user_usuario as u2, vsites_pedido_item as pi, vsites_financeiro as f where
			".$onde_empresa."
			f.id_usuario = u2.id_usuario and
			u2.id_empresa = '".$controle_id_empresa."' and
            f.financeiro_tipo='Desembolso' and
            f.id_pedido_item=pi.id_pedido_item and
            pi.id_usuario = u.id_usuario
			".$onde."
            order by f.financeiro_data asc");
            $num = mysql_num_rows($sql);
            $subtotal = 0;
            $total = 0;
			while($res = mysql_fetch_array($sql)){
			
			    $id_pedido = $res['id_pedido'];

                $nome = substr($res['nome'],0,9);
                $carac = strlen($nome);

                $agencia = $res['financeiro_agencia'];

                $conta = $res['financeiro_conta'];

                $favorecido = substr($res['financeiro_favorecido'],0,24);
                $carac = strlen($favorecido);
				
				$identificacao = $res['financeiro_identificacao'];
                $carac = strlen($identificacao);
                
                $cpf = substr(str_replace('/','',str_replace('-','',str_replace('.','',$res['financeiro_cpf']))),0,15);
                $carac = strlen($cpf);
                
				$financeiro_forma = $res['financeiro_forma'];
				$rel = $res['rel'];
				if($rel=='1') $rel='Sim'; else $rel='Não';
				
                $financeiro_valor = $res['financeiro_valor'];
                $total=(float)($total)+(float)($financeiro_valor);
				$financeiro_valor = number_format($financeiro_valor,2,".",",");
				
                $financeiro_troco = substr($res['financeiro_troco'],0,9);
                $carac = strlen(number_format($financeiro_troco,2,".",","));

                $financeiro_desembolsado = substr($res['financeiro_desembolsado'],0,9);
                $carac = strlen(number_format($financeiro_desembolsado,2,".",","));
				
				$financeiro_descricao = substr($res['financeiro_descricao'],0,40);
                $carac = strlen($financeiro_descricao);

                $cont_banco++;
                
                $arquivoConteudo .= invert($res['financeiro_autorizacao_data'],'/','PHP'). ' '.substr($res['financeiro_autorizacao_data'],11, 8).';#'.$res['id_pedido'].'/'.$res['ordem'].';'.$financeiro_descricao.';'.$financeiro_desembolsado.';'.$financeiro_troco.';'.$financeiro_valor.';'.$financeiro_forma.';'.$rel.';
';
            }

                  
                  
                  $arquivoConteudo .= ';;;;Total;'.$total.';;;';








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
	#update campos selecionados no relatorio
	$sql = $objQuery->SQLQuery("update vsites_user_usuario as u, vsites_pedido_item as pi, vsites_financeiro as f 
	set f.rel='1'	where
    f.financeiro_tipo='Desembolso' and
    f.id_pedido_item=pi.id_pedido_item and
    f.id_usuario = u.id_usuario and
	f.financeiro_autorizacao = 'Aprovado' and
    u.id_empresa = '".$controle_id_empresa."'
	".$onde);

    header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
	header("Content-Length: ".filesize($arquivoDiretorio));
	readfile($arquivoDiretorio);
} else {
   echo"<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
   exit;
}

?>