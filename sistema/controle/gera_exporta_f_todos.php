<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require('../includes/dias_uteis.php');
require("../includes/geraexcel/excelwriter.inc.php");
$error="";
$errors=0;
$error="<b>Ocorreram os seguintes erros:</b><ul> ";

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".xls";
$nomeArquivo = $controle_id_usuario.".xls";

$excel=new ExcelWriter($arquivoDiretorio);

if($excel==false){
	echo $excel->error;
	exit;
}

$busca_e_inicio   		= $_COOKIE['f_busca_e_inicio'] ;
$busca_e_conclu   		= $_COOKIE['p_busca_e_conclu'] ;
$busca_e_prazo   		= $_COOKIE['f_busca_e_prazo'] ;
$busca_e_agenda   		= $_COOKIE['f_busca_e_agenda'] ;
$busca_e_data_atividade 	= $_COOKIE['f_busca_e_data_atividade'] ;
$busca_e_valor   		= $_COOKIE['f_busca_e_valor'] ;
$busca_e_custas   		= $_COOKIE['f_busca_e_custas'] ;
$busca_e_rateio   		= $_COOKIE['f_busca_e_rateio'] ;
$busca_e_sedex   		= $_COOKIE['f_busca_e_sedex'] ;
$busca_e_departamento   	= $_COOKIE['f_busca_e_departamento'] ;
$busca_e_servico   		= $_COOKIE['f_busca_e_servico'] ;
$busca_e_status   		= $_COOKIE['f_busca_e_status'] ;
$busca_e_atividade   	= $_COOKIE['f_busca_e_atividade'] ;
$busca_e_responsavel   	= $_COOKIE['f_busca_e_responsavel'] ;
$busca_e_atendimento   	= $_COOKIE['f_busca_e_atendimento'] ;
$busca_e_forma   		= $_COOKIE['f_busca_e_forma'] ;
$busca_e_cpf   			= $_COOKIE['f_busca_e_cpf'] ;
$busca_e_cidade   		= $_COOKIE['f_busca_e_cidade'] ;
$busca_e_estado			= $_COOKIE['f_busca_e_estado'] ;
$busca_e_nome   			= $_COOKIE['f_busca_e_nome'] ;
$busca_e_devedor   		= $_COOKIE['f_busca_e_devedor'] ;
 
if($busca_e_inicio=='on') $r_inicio=';Abertura';
if($busca_e_prazo=='on') $r_prazo=';Prazo';
if($busca_e_conclu=='on') $r_conclu=';Concluído Oper.';
if($busca_e_status=='on') $r_status=';Status';
if($busca_e_data_atividade=='on') $r_data_atividade=';Data Status';
if($busca_e_atendimento=='on') $r_atendimento=';Atendimento';
if($busca_e_responsavel=='on') $r_responsavel=';Responsável';
if($busca_e_servico=='on') $r_servico=';Serviço';
if($busca_e_atividade=='on') $r_atividade=';Atividade';
if($busca_e_agenda=='on') $r_agenda=';Agenda';
if($busca_e_departamento=='on') $r_departamento=';Departamento';
if($busca_e_valor=='on') $r_valor=';Valor';
if($busca_e_custas=='on') $r_custas=';Custas';
if($busca_e_rateio=='on') $r_rateio=';Rateio';
if($busca_e_sedex=='on') $r_sedex=';Sedex';
if($busca_e_forma=='on') $r_forma=';Forma de Pagamento';
if($busca_e_cidade=='on') $r_cidade=';Cidade';
if($busca_e_estado=='on') $r_estado=';Estado';
if($busca_e_nome=='on') $r_nome=';Nome';
if($busca_e_cpf=='on') $r_cpf=';CPF/CNPJ Requerente';
if($busca_e_devedor=='on') $r_devedor=';Devedor';

$f_busca_ordenar = $_SESSION['f_busca_ordenar'];
$f_busca_ord	 = $_SESSION['f_busca_ord'];
 
if($busca_ord=='Decr') 				$busca_ordenar_por_o.= ' DESC ';
$busca_ordenar_por=' pi.id_pedido '.$busca_ordenar_por_o.', pi.ordem '.$busca_ordenar_por_o;
if($busca_ordenar=='Documento de') $busca_ordenar_por=' pi.certidao_nome '.$busca_ordenar_por_o; else
if($busca_ordenar=='Serviço') $busca_ordenar_por=' pi.id_servico '.$busca_ordenar_por_o; else
if($busca_ordenar=='Ordem') $busca_ordenar_por=' pi.id_pedido, pi.ordem '.$busca_ordenar_por_o; else
if($busca_ordenar=='Data') $busca_ordenar_por=' pi.data '.$busca_ordenar_por_o; else
if($busca_ordenar=='Cidade') $busca_ordenar_por=' pi.certidao_estado '.$busca_ordenar_por_o.', pi.certidao_cidade '.$busca_ordenar_por_o; else
if($busca_ordenar=='Estado') $busca_ordenar_por=' pi.certidao_estado '.$busca_ordenar_por_o; else
if($busca_ordenar=='Departamento') $busca_ordenar_por=' pi.id_servico_departamento '.$busca_ordenar_por_o; else
if($busca_ordenar=='Prazo') $busca_ordenar_por= $data_prazo_inc.$busca_ordenar_por_o; else
if($busca_ordenar=='Data Status') $busca_ordenar_por=' pi.data_atividade '.$busca_ordenar_por_o; else
if($busca_ordenar=='Agenda') $busca_ordenar_por=' pi.data_i '.$busca_ordenar_por_o.', pi.status_hora '.$busca_ordenar_por_o;
if($busca_ordenar=='Devedor') $busca_ordenar_por=' pi.certidao_devedor '.$busca_ordenar_por_o.', pi.certidao_nome '.$busca_ordenar_por_o;

//Escreve o nome dos campos de uma tabela
$linha_arq = '#'.$r_inicio.$r_prazo.$r_conclu.$r_data_atividade.';Solicitante;CPF;CNPJ'.$r_nome.$r_devedor.$r_forma.$r_cpf.$r_atendimento.$r_responsavel.$r_servico.$r_cidade.$r_estado.$r_atividade.$r_status.$r_agenda.';Valor'.';Custas'.';Honorários'.';Correios'.$r_departamento.';Controle do Cliente';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$sql_usuario_resp = " CASE WHEN pi.id_usuario_op != 0 THEN (SELECT uu_resp.nome from vsites_user_usuario as uu_resp where  uu_resp.id_usuario=pi.id_usuario_op) ELSE ('') END";

$sql_franquia = " CASE WHEN pi.id_empresa_resp <> '0' and pi.id_empresa_resp != '".$controle_id_empresa."' THEN (SELECT uf.fantasia from vsites_user_empresa as uf where  uf.id_empresa=pi.id_empresa_resp) ELSE
	CASE WHEN pi.id_empresa_resp <> '0' and pi.id_empresa_resp = '".$controle_id_empresa."' THEN (SELECT uf.fantasia from vsites_user_empresa as uf where  uf.id_empresa=uu.id_empresa) ELSE ('') END END";

$campo = 'p.nome as solicitante, pi.controle_cliente ,pi.certidao_cpf, pi.certidao_cnpj, '.$_SESSION['pedido_campo'];
$condicao = $_SESSION['pedido_condicao'];
$sql_todos = $objQuery->SQLQuery("select ".$campo." ".$condicao." limit 1300");
if($controle_id_usuario == 1){
	#echo "select ".$campo." ".$condicao." limit 1000";	
	#exit;
}
while($res = mysql_fetch_array($sql_todos)){
	$cont++;
	#if($res["id_empresa_resp"]<>0 and $res["id_empresa_resp"]==$controle_id_empresa) $outra_franquia = ';'.$res['fantasia'].';'; else $outra_franquia = ';;'.$res['fantasia'];
	if($busca_e_inicio=='on') $r_inicio=';'.invert($res['inicio'],'/','PHP'); else $r_inicio='';
	if($busca_e_conclu=='on') $r_conclu=';'.invert($res["operacional"],'/','php'); else $r_conclu='';
	if($busca_e_prazo=='on') $r_prazo=';'.invert($res["data_prazo"],'/','php'); else $r_prazo='';
	if($busca_e_status=='on') $r_status=';'.$res["status"]; else $r_status='';
	if($busca_e_data_atividade=='on') $r_data_atividade=';'.invert($res['data_atividade'],'/','PHP');  else $r_data_atividade='';
	if($busca_e_atendimento=='on') $r_atendimento=';'.$res['atendente']; else $r_atendimento='';
	if($busca_e_responsavel=='on') $r_responsavel=';'.$res['responsavel']; else $r_responsavel='';
	if($busca_e_servico=='on') $r_servico=';'.$res['servico']; else $r_servico='';
	if($busca_e_cidade=='on') $r_cidade=';'.$res['certidao_cidade']; else $r_cidade='';
	if($busca_e_estado=='on') $r_estado=';'.$res['certidao_estado']; else $r_estado='';
	if($busca_e_atividade=='on') $r_atividade=';'.$res['atividade']; else $r_atividade='';
	if($busca_e_agenda=='on') $r_agenda=';'.invert($res['data_i'],'/','PHP'); else $r_agenda='';
	if($busca_e_departamento=='on') $r_departamento=';'.$res['departamento']; else $r_departamento='';
	$r_valor=';'.$res["valor"];
	$r_custas=';'.$res['custas'];
	$r_rateio=';'.$res['rateio'];
	$r_sedex=';'.$res['sedex'];
	if($busca_e_nome=='on') $r_nome=';'.$res["certidao_nome"]; else $r_nome='';
	if($busca_e_forma=='on') $r_forma=';'.$res["forma_pagamento"]; else $r_forma='';
	if($busca_e_cpf=='on') $r_cpf=';'.$res["cpf"].' .'; else $r_cpf='';
	if($busca_e_devedor=='on') $r_devedor=';'.$res["certidao_devedor"]; else $r_devedor='';
	$r_controle_cliente=';'.$res["controle_cliente"];

	$linha_arq = '#'.$res['id_pedido'].'/'.$res['ordem'].$r_inicio.$r_prazo.$r_conclu.$r_data_atividade.';'.$res['solicitante'].';'.$res['certidao_cpf'].' .;'.$res['certidao_cnpj'].' .'.$r_nome.$r_devedor.$r_forma.$r_cpf.$r_atendimento.$r_responsavel.$r_servico.$r_cidade.$r_estado.$r_atividade.$r_status.$r_agenda.$r_valor.$r_custas.$r_rateio.$r_sedex.$r_departamento.$r_controle_cliente;
	#echo $linha_arq;exit;
	$myArr = explode(';',$linha_arq);
	$excel->writeLine($myArr);
}

header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);
#Colocar aqui o script para download do arquivo
?>
