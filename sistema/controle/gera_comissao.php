<?php
require("../includes/verifica_logado_ajax.inc.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
require("../includes/dias_uteis.php");
require("../includes/geraexcel/excelwriter.inc.php");
$errors=0;
$error="<b>Ocorreram os seguintes erros:</b><ul>";

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".xls";
$nomeArquivo = $controle_id_usuario.".xls";

$excel=new ExcelWriter($arquivoDiretorio);

if($excel==false){
	echo $excel->error;
	exit;
}

pt_register('GET','mes');

if($mes=='') $mes = '04';
$ano = '2011';
//Escreve o nome dos campos de uma tabela
$linha_arq = 'Relatório de Comissão por Atendente';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);
 

$sql = $objQuery->SQLQuery("select replace(format(SUM(pi.valor),2),',','') as valor 
	from vsites_pedido_item as pi 
	INNER JOIN vsites_user_usuario as uu ON	uu.id_empresa='".$controle_id_empresa."' and uu.id_usuario=pi.id_usuario
	INNER JOIN vsites_pedido as p ON p.id_pedido=pi.id_pedido where 
	pi.id_status!='14' and pi.id_status!='16' and pi.id_status!='1' and DATE_FORMAT(pi.data,'%Y-%m')='".$ano."-".$mes."' and p.nome not like '%HSBC%' group by date_format(pi.data,'%Y-%m')");
$res = mysql_fetch_array($sql);
$faturamento = $res['valor'];

$linha_arq = 'Ref. '.$mes.'/'.$ano;
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$linha_arq = 'Faturamento do Mês: R$ '.$faturamento;
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$sql = $objQuery->SQLQuery("select uu.nome, replace(format(SUM(f.financeiro_valor),2),',','') as valor_rec, date_format(pi.data,'%m/%Y') as ref
	from vsites_pedido_item as pi 
	INNER JOIN vsites_user_usuario as uu ON	uu.id_empresa='".$controle_id_empresa."' and uu.id_usuario=pi.id_usuario 
	INNER JOIN vsites_pedido as p ON p.id_pedido=pi.id_pedido, 
	vsites_financeiro as f where 
	pi.id_pedido_item = f.id_pedido_item and 
	f.financeiro_tipo = 'Recebimento' and 
	f.financeiro_autorizacao = 'Aprovado' and 
	date_format(pi.data,'%Y-%m')>='2011-03' and 
	date_format(pi.data,'%Y-%m')<='".$ano."-".$mes."' and 
	pi.id_status!='14' and 
	date_format(f.financeiro_autorizacao_data,'%Y-%m')='".$ano."-".$mes."' and 
	p.nome not like '%HSBC%'
	group by date_format(pi.data,'%Y-%m'), uu.id_usuario order by date_format(pi.data,'%Y-%m') DESC, uu.nome ASC");

$linha_arq = '';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);


$ref_ant='';
while($res = mysql_fetch_array($sql)){
	if($ref_ant!=$res['ref']){
		if($soma_total!='') {
			$linha_arq = 'Total;R$ '.number_format($soma_total, 2, ',', '');
			$myArr = explode(';',$linha_arq);
			$excel->writeLine($myArr);
			$soma_total='';
		}
		
		$linha_arq = '';
		$myArr = explode(';',$linha_arq);
		$excel->writeLine($myArr);

		$linha_arq = 'Mês de Referência: '.$res['ref'];
		$myArr = explode(';',$linha_arq);
		$excel->writeLine($myArr);

		$linha_arq = 'Atendente;Valor Recebido';
		$myArr = explode(';',$linha_arq);
		$excel->writeLine($myArr);
	}
	$soma_total = (float)($soma_total)+(float)($res['valor_rec']);
	$linha_arq = $res['nome'].';R$ '.number_format($res['valor_rec'], 2, ',', '');
	$myArr = explode(';',$linha_arq);
	$excel->writeLine($myArr);
	$ref_ant=$res['ref'];
}
	$linha_arq = 'Total;R$ '.number_format($soma_total, 2, ',', '');
	$myArr = explode(';',$linha_arq);
	$excel->writeLine($myArr);


header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);
?>