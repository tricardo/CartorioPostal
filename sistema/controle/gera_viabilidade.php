<?
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require('../includes/dias_uteis.php');
require("../includes/geraexcel/excelwriter.inc.php");

$permissao = verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

pt_register('POST','id_empresa');
pt_register('POST','crescimento');

$empresaDAO = new EmpresaDAO();
$emp = $empresaDAO->selectPorId($id_empresa);

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".xls";
$nomeArquivo = $controle_id_usuario.".xls";

$excel=new ExcelWriter($arquivoDiretorio);

if($excel==false){
	echo $excel->error;
	exit;
}

//Escreve o nome dos campos de uma tabela
$linha_arq = 'Relatorio de Planejamento Econômico Financeiro - Franquia '.$emp->fantasia.' - Taxa de Crescimento de '.$crescimento.'%;';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$linha_arq = 'ANO I;Operacionais;';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

#inicio do ano I
$linha_arq = ';1;2;3;4;5;6;7;8;9;10;11;12';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$linha_arq = 'MES';

$cont=0;
$linha_dias_uteis	= 'DIAS UTEIS';
$linha_despesa 		= 'DESPESAS';
$linha_vendas 		= 'VENDAS';
$linha_lucro	 	= 'LUCRO';
$linha_operacoes 	= 'OPERAÇÕES DO MÊS';
$linha_pedido_medio = 'TICKET MÉDIO';
$linha_pedido_dia 	= 'OPERAÇOES POR DIA';
$linha_enviado		= 'PEDIDOS ENVIADOS PARA REDE';
$linha_recebido		= 'PEDIDO RECEBIDOS DA REDE';
$sql_todos = $objQuery->SQLQuery("select *, date_format( str_to_date(mes, '%Y-%m'),'%m/%Y') as mes from vsites_rel_viabilidade as rv 
where rv.id_empresa='".$id_empresa."' order by mes ASC");
while($res = mysql_fetch_array($sql_todos)){
	$cont++;
	$pedido_medio = (float)($res['valor_pedido'])/(float)($res['operacoes']);
	$lucro = (float)($res['valor_pedido'])-(float)($res['despesa']);
	$linha_arq 			.= ";".$res['mes'];	
	$linha_despesa 		.= ";".$res['despesa'];
	$linha_vendas 		.= ";".$res['valor_pedido'];

	$linha_operacoes 	.= ";".$res['operacoes'];
	$linha_lucro 		.= ";".$lucro;
	$linha_pedido_medio	.= ";".$pedido_medio;
	$linha_enviado		.= ";".$res['enviado'];
	$linha_recebido		.= ";".$res['recebido'];
	$dias = dias_uteis('01/'.$res['mes'],'31/'.$res['mes']);
	$linha_dias_uteis	.= ";".$dias;
	$pedido_dia = $res['operacoes']/$dias;
	$linha_pedido_dia	.= ";".$pedido_dia;
	if($busca_data_i=='')	$busca_data_i = $res['mes'];

	$vendas_ano1 		= (float)($vendas_ano1)+(float)($res['valor_pedido']);
	$ticket_ano1 		= (float)($ticket_ano1)+(float)($pedido_medio);
	$operacoes_ano1		= (float)($operacoes_ano1)+(float)($res['operacoes']);
}

while($cont<12){
	$data = gmdate('m/Y',strtotime(date("d/m/Y", strtotime('01/'.$busca_data_i)) . " +".$cont." month"));
	$linha_arq .= ";".$data;
	$cont++;
}

$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$myArr = explode(';',$linha_dias_uteis);
$excel->writeLine($myArr);

$myArr = explode(';',$linha_pedido_dia);
$excel->writeLine($myArr);

$myArr = explode(';',$linha_despesa);
$excel->writeLine($myArr);

$myArr = explode(';',$linha_vendas);
$excel->writeLine($myArr);

$myArr = explode(';',$linha_lucro);
$excel->writeLine($myArr);

$myArr = explode(';',$linha_operacoes);
$excel->writeLine($myArr);

$myArr = explode(';',$linha_pedido_medio);
$excel->writeLine($myArr);

$myArr = explode(';',$linha_enviado);
$excel->writeLine($myArr);

$myArr = explode(';',$linha_recebido);
$excel->writeLine($myArr);

#fim do ano I
#inicio do ano II
$linha_arq = 'MES';
$linha_pedido_dia2[] = 'OPERAÇÕES POR DIA';
$linha_dias_uteis2[] = 'DIAS ÚTEIS';
$linha_vendas2[] = 'VENDA';
$linha_operacoes2[] = 'OPERAÇÕES DO MÊS';
$pedido_medio2[] = 'TICKET MÉDIO';
while($cont<24){
	$data = gmdate('m/Y',strtotime(date("d/m/Y", strtotime('01/'.$busca_data_i)) . " +".$cont." month"));
	$linha_arq .= ";".$data;	
	$pedido_medio = explode(';',$linha_pedido_medio);
	$pedido_dia = explode(';',$linha_pedido_dia);

	$cont2 = $cont-11;
	$calc_pedidomedio = (float)($pedido_medio[$cont2])+(float)($pedido_medio[$cont2])/100*$crescimento;	
	$pedido_medio2[] = $calc_pedidomedio;
	
	$dias = dias_uteis('01/'.$data,'31/'.$data);
	$linha_dias_uteis2[]	= $dias;
	$por_dia = $pedido_dia[$cont2]+$pedido_dia[$cont2]/100*$crescimento;
	$linha_pedido_dia2[]	= $por_dia;
	$linha_operacoes2[]	= $dias*$por_dia;
	$linha_vendas2[]	= $calc_pedidomedio*$dias*$por_dia;

	$vendas_ano2 		= (float)($vendas_ano2)+(float)($calc_pedidomedio*$dias*$por_dia);
	$ticket_ano2 		= (float)($ticket_ano2)+(float)($calc_pedidomedio);	
	$operacoes_ano2		= (float)($operacoes_ano2)+(float)($dias*$por_dia);

	$cont++;
	$linha_arq_mes .= ";".$cont;
	
}

$myArr = explode(';',';');
$excel->writeLine($myArr);

$myArr = explode(';','ANO II'.$linha_arq_mes);
$excel->writeLine($myArr);

$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$excel->writeLine($linha_dias_uteis2);

$excel->writeLine($linha_pedido_dia2);

$excel->writeLine($linha_vendas2);

$excel->writeLine($linha_operacoes2);

$excel->writeLine($pedido_medio2);


#fim do ano II


#statistica de 5 anos
$ticket_ano1 = $ticket_ano1/8;
$ticket_ano2 = $ticket_ano2/8;
$ticket_ano3 = (float)($ticket_ano2)*(float)(1.03);
$ticket_ano4 = (float)($ticket_ano3)*(float)(1.03);
$ticket_ano5 = (float)($ticket_ano4)*(float)(1.03);
$ticket5anos = 'Ticket Médio;'.$ticket_ano1.';'.$ticket_ano2.';'.$ticket_ano3.';'.$ticket_ano4.';'.$ticket_ano5;

$operacoes_ano1 = $operacoes_ano1/8;
$operacoes_ano2 = $operacoes_ano2/8;
$operacoes5anos = 'Operações por mês;'.$operacoes_ano1.';'.$operacoes_ano2.';'.$operacoes_ano2.';'.$operacoes_ano2.';'.$operacoes_ano2;

$mediavendas_ano1 = $vendas_ano1/8;
$mediavendas_ano2 = $vendas_ano2/8;
$mediavendas_ano3 = (float)($ticket_ano2)*(float)($operacoes_ano2);
$mediavendas_ano4 = (float)($ticket_ano3)*(float)($operacoes_ano2);
$mediavendas_ano5 = (float)($ticket_ano4)*(float)($operacoes_ano2);
$mediavendas5anos = 'Vendas média/mês;'.$mediavendas_ano1.';'.$mediavendas_ano2.';'.$mediavendas_ano3.';'.$mediavendas_ano4.';'.$mediavendas_ano5;

$vendas_ano3 = (float)($mediavendas_ano3)*8;
$vendas_ano4 = (float)($mediavendas_ano4)*8;
$vendas_ano5 = (float)($mediavendas_ano5)*8;

$vendas5anos = 'Vendas do Ano;'.$vendas_ano1.';'.$vendas_ano2.';'.$vendas_ano3.';'.$vendas_ano4.';'.$vendas_ano5;

$myArr = explode(';',';');
$excel->writeLine($myArr);

$myArr = explode(';','RECEITAS, MÉDIA DO ANO;ANO I; ANO II; ANO III; ANO IV; ANO V;');
$excel->writeLine($myArr);

$myArr = explode(';',$vendas5anos);
$excel->writeLine($myArr);

$myArr = explode(';',$mediavendas5anos);
$excel->writeLine($myArr);

$myArr = explode(';',$ticket5anos);
$excel->writeLine($myArr);

$myArr = explode(';',$operacoes5anos);
$excel->writeLine($myArr);

header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);

?>