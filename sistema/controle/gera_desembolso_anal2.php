<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('POST','datai');
pt_register('POST','dataf');
$datai_sql = invert($datai,'-','SQL').' '.substr($datai,11, 8);
$dataf_sql = invert($dataf,'-','SQL').' '.substr($dataf,11, 8);


$arquivoDiretorio = "./exporta/".$controle_id_usuario.".csv";
$nomeArquivo = $controle_id_usuario.".csv";

$arquivoConteudo  = 'Relatório de ;Depósito por Banco; Analítico
';
$arquivoConteudo  .= 'Entre ;'.$datai.' ;e '.$dataf.'; tirado em ;'.date('d/m/Y H:i:s').'
;;;;;
';


$banco='';
$sql = $objQuery->SQLQuery("SELECT pi.ordem, f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio as total, f.financeiro_data, f.financeiro_descricao, f.financeiro_agencia, f.financeiro_conta,f.financeiro_favorecido,f.financeiro_identificacao, b.banco, u.nome, pi.id_pedido from
            vsites_user_usuario as u, vsites_pedido_item as pi, vsites_financeiro as f, vsites_banco as b where
            f.financeiro_tipo='Desembolso' and
            f.financeiro_autorizacao='Aprovado' and
			f.financeiro_forma='Depósito' and
            f.financeiro_banco=b.id_banco and
            f.id_pedido_item=pi.id_pedido_item and
            f.financeiro_conferido!='on' and
			f.execucao=0 and
            u.id_usuario=f.id_usuario and
			u.id_empresa = '".$controle_id_empresa."' and
            f.financeiro_autorizacao_data >= '".$datai_sql."' and
            f.financeiro_autorizacao_data <= '".$dataf_sql."'
            order by b.banco, f.financeiro_data, pi.id_pedido, pi.ordem");
$num = mysql_num_rows($sql);
$subtotal = 0;
$total = 0;
while($res = mysql_fetch_array($sql)){
	$id_pedido = $res['id_pedido'];
	$soma = $res['total'];
	$ordens = str_replace(';',' #'.$id_pedido.'/',$res['ordem']);
	$financeiro_descricao = '#'.$id_pedido.'/'.$ordens.' '.$res['financeiro_descricao'];
	$financeiro_valor = number_format($res['total'],2,".",",");
	$old_banco = $banco;
	$old_agencia = $agencia;
	$old_conta = $conta;
	$old_financeiro_data = $financeiro_data;
	$old_favorecido = $favorecido;
	$old_identificacao = $identificacao;

	$banco = $res['banco'];

	$nome = substr($res['nome'],0,9);
	$carac = strlen($nome);

	$agencia = substr($res['financeiro_agencia'],0,10);
	$carac = strlen($agencia);

	$conta = substr($res['financeiro_conta'],0,15);
	$carac = strlen($conta);

	$favorecido = substr($res['financeiro_favorecido'],0,35);
	$carac = strlen($favorecido);

	$identificacao = $res['financeiro_identificacao'];
	$carac = strlen($identificacao);

	$financeiro_data = $res['financeiro_data'];
		
	$cpf = substr(str_replace('/','',str_replace('-','',str_replace('.','',$res['financeiro_cpf']))),0,15);
	$carac = strlen($cpf);
	if(($old_agencia!=$agencia or $old_conta!=$conta or $old_favorecido!=$favorecido or $old_identificacao!=$identificacao or $old_financeiro_data!=$financeiro_data) and $cont_dep<>'') {
		$arquivoConteudo  .= ';;;;Subtotal: ;'.number_format($somatotal,2,".",",").'

';
		$somatotal = '';
	}

	if($old_banco!=$banco and $cont_banco<>'') {
		$arquivoConteudo  .= ';;;;Subtotal: ;'.number_format($subtotal,2,".",",").'

';
		$total = (float)($total)+(float)($subtotal);
		$subtotal=0;
	}
	if($old_banco!=$banco)	{
		$arquivoConteudo  .=  $banco.'
Protocolo;Usuário;Agência;CC;Favorecido;Valor
';
		$cont_banco++;
		$cont_dep++;

	}
	$subtotal=(float)($subtotal)+(float)($soma);
	$somatotal=(float)($somatotal)+(float)($soma);
	$arquivoConteudo  .= '#'.$res['id_pedido'].';'.$nome.';'.$agencia.';'.$conta.';'.$favorecido.';'.$financeiro_valor.'
'.$financeiro_descricao.'
';
}

$arquivoConteudo  .= ';;;;Subtotal;'.number_format($subtotal,2,".",",").'

';
$total = (float)($total)+(float)($subtotal);
$subtotal=0;
$arquivoConteudo  .= ';;;;Total:;'.number_format($total,2,".",",").'

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