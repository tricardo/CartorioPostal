<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$permissao = verifica_permissao('Financeiro_rel',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' and $controle_id_usuario!='46'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

pt_register('POST','datai');
pt_register('POST','dataf');
pt_register('POST','enviados');
$datai_sql = invert($datai,'-','SQL').' '.substr($datai,11, 8);
$dataf_sql = invert($dataf,'-','SQL').' '.substr($dataf,11, 8);

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".csv";
$nomeArquivo = $controle_id_usuario.".csv";

$arquivoConteudo  = 'Relatório de ;Desembolso por franquia
';
if($enviados<>'') 
	$arquivoConteudo  .= 'Pedidos Enviados
'; 
else
	$arquivoConteudo  .= 'Pedidos Recebidos
';
 
$arquivoConteudo  .= 'Entre ;'.$datai.' ;e '.$dataf.'; tirado em ;'.date('d/m/Y H:i:s').'
';
            
			$banco='';
			if($enviados<>'') $onde = " u2.id_empresa != '".$controle_id_empresa."' and  u.id_empresa='".$controle_id_empresa."' and pi.id_empresa_resp <> '' and pi.id_empresa_resp=ue.id_empresa and "; else $onde = "  u2.id_empresa = '".$controle_id_empresa."' and pi.id_empresa_resp='".$controle_id_empresa."' and u.id_empresa=ue.id_empresa and ";
			
			$sql = $objQuery->SQLQuery("SELECT sum(f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio) as total, date_format(f.financeiro_autorizacao_data, '%d/%m/%Y') as data, pi.valor, u.id_empresa, pi.id_pedido, pi.ordem, ue.fantasia from
            vsites_user_usuario as u, vsites_user_usuario as u2, vsites_pedido_item as pi, vsites_financeiro as f, vsites_user_empresa as ue where
            f.financeiro_tipo='Desembolso' and
            f.financeiro_autorizacao='Aprovado' and
            f.id_pedido_item=pi.id_pedido_item and
			".$onde."
			pi.id_usuario=u.id_usuario and
			f.id_usuario=u2.id_usuario and						
            f.financeiro_autorizacao_data >= '".$datai_sql."' and
            f.financeiro_autorizacao_data <= '".$dataf_sql."'
			group by f.id_pedido_item
            order by ue.id_empresa, pi.id_pedido, pi.ordem");
            $num = mysql_num_rows($sql);
            $subtotal = 0;
            $total = 0;
			while($res = mysql_fetch_array($sql)){

				$fantasia = $res['fantasia'];
				$financeiro_valor = $res['total'];
				$valor = $res['valor'];
				#$comissao = (float)($valor)/100*14;
				$id_empresa = $res['id_empresa'];
                
                if($old_id_empresa!=$id_empresa and $cont_empresa<>'') {
                  $arquivoConteudo  .= 'Subtotal:;'.number_format($subtotal,2,",","").';'.number_format($subtotal_valor,2,",","").';

';
                  $total = (float)($total)+(float)($subtotal);
				  $total_valor = (float)($total_valor)+(float)($subtotal_valor);
				  $total_comissao = (float)($total_comissao)+(float)($subtotal_comissao);
                  $subtotal=0;
				  $subtotal_valor=0;
				  #$subtotal_comissao=0;
                }
			    if($old_id_empresa!=$id_empresa)	{
                   $arquivoConteudo  .=  $fantasia.'
Pedido;Desembolso;Valor Cobrado;Data;Franquia
';
					$cont_empresa++;
                }
				$old_id_empresa = $id_empresa;	
				$subtotal = (float)($subtotal+$financeiro_valor);
				$subtotal_valor = (float)($subtotal_valor)+(float)($valor);
				#$subtotal_comissao = (float)($subtotal_comissao)+(float)($comissao);
				
                $arquivoConteudo  .= '#'.$res['id_pedido'].'/'.$res['ordem'].';'.number_format($financeiro_valor,2,",","").';'.number_format($valor,2,",","").';'.$res['data'].';'.$fantasia.';
';
            }
			
                 $arquivoConteudo  .= 'Subtotal:;'.number_format($subtotal,2,",","").';'.number_format($subtotal_valor,2,",","").';

';
            $total = (float)($total)+(float)($subtotal);
			$total_valor = (float)($total_valor)+(float)($subtotal_valor);
			#$total_comissao = (float)($total_comissao)+(float)($subtotal_comissao);			
            $subtotal=0;
			$subtotal_valor=0;
			#$subtotal_comissao=0;
            $arquivoConteudo  .= 'Total:;'.number_format($total,2,",","").';'.number_format($total_valor,2,",","").';

';
                  
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
