<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require('../includes/dias_uteis.php');
require("../includes/geraexcel/excelwriter.inc.php");

$error="";
$errors=0;
$error="<b>Ocorreram os seguintes erros:</b><ul>";

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".xls";
$nomeArquivo = $controle_id_usuario.".xls";

$excel=new ExcelWriter($arquivoDiretorio);

if($excel==false){
	echo $excel->error;
	exit;
}

$busca_e_inicio   		= $_COOKIE['f_busca_e_inicio'] ;
$busca_e_prazo   		= $_COOKIE['f_busca_e_prazo'] ;
$busca_e_agenda   		= $_COOKIE['f_busca_e_agenda'] ;
$busca_e_data_atividade 	= $_COOKIE['f_busca_e_data_atividade'] ;
$busca_e_valor   		= $_COOKIE['f_busca_e_valor'] ;
$busca_e_departamento   	= $_COOKIE['f_busca_e_departamento'] ;
$busca_e_servico   		= $_COOKIE['f_busca_e_servico'] ;
$busca_e_cidade   		= $_COOKIE['f_busca_e_cidade'] ;
$busca_e_estado   		= $_COOKIE['f_busca_e_estado'] ;
$busca_e_status   		= $_COOKIE['f_busca_e_status'] ;
$busca_e_atividade   	= $_COOKIE['f_busca_e_atividade'] ;
$busca_e_responsavel   	= $_COOKIE['f_busca_e_responsavel'] ;
$busca_e_atendimento   	= $_COOKIE['f_busca_e_atendimento'] ;
$busca_e_forma   		= $_COOKIE['f_busca_e_forma'] ;
$busca_e_cpf   			= $_COOKIE['f_busca_e_cpf'] ;
$busca_e_nome   			= $_COOKIE['f_busca_e_nome'] ;
$busca_e_devedor   		= $_COOKIE['f_busca_e_devedor'] ;

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

 
if($busca_e_inicio=='on') $r_inicio=';Abertura';
if($busca_e_prazo=='on') $r_prazo=';Prazo';
if($busca_e_status=='on') $r_status=';Status';
if($busca_e_data_atividade=='on') $r_data_atividade=';Data Status';
if($busca_e_atendimento=='on') $r_atendimento=';Atendimento';
if($busca_e_responsavel=='on') $r_responsavel=';Responsável';
if($busca_e_servico=='on') $r_servico=';Serviço';
if($busca_e_atividade=='on') $r_atividade=';Atividade';
if($busca_e_agenda=='on') $r_agenda=';Agenda';
if($busca_e_departamento=='on') $r_departamento=';Departamento';
if($busca_e_valor=='on') $r_valor=';Valor';
if($busca_e_forma=='on') $r_forma=';Forma de Pagamento';
if($busca_e_nome=='on') $r_nome=';Nome';
if($busca_e_cpf=='on') $r_cpf=';CPF/CNPJ Requerente';
if($busca_e_devedor=='on') $r_devedor=';Devedor';
if($busca_e_cidade=='on') $r_cidade=';Cidade';
if($busca_e_estado=='on') $r_estado=';Estado';
 
//Escreve o nome dos campos de uma tabela
$linha_arq = '#'.$r_inicio.$r_prazo.$r_data_atividade.';CPF;CNPJ'.$r_nome.$r_devedor.$r_forma.$r_cpf.$r_atendimento.$r_responsavel.$r_servico.$r_cidade.$r_estado.$r_atividade.$r_status.$r_agenda.';Valor'.$r_departamento;
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);
 
$sql_usuario_resp = " CASE WHEN pi.id_usuario_op != 0 THEN (SELECT uu_resp.nome from vsites_user_usuario as uu_resp where  uu_resp.id_usuario=pi.id_usuario_op) ELSE ('') END";

$sql_franquia = " CASE WHEN pi.id_empresa_resp <> '0' and pi.id_empresa_resp != '".$controle_id_empresa."' THEN (SELECT uf.fantasia from vsites_user_empresa as uf where  uf.id_empresa=pi.id_empresa_resp) ELSE
	CASE WHEN pi.id_empresa_resp <> '0' and pi.id_empresa_resp = '".$controle_id_empresa."' THEN (SELECT uf.fantasia from vsites_user_empresa as uf where  uf.id_empresa=uu.id_empresa) ELSE ('') END END";

$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido_item'].'##'));
$p_id_pedido = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido'].'##'));

$cont=0;
foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
	$valida = valida_numero($id_pedido_item);
	if($valida!='TRUE'){
		echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
		exit;
	}

	$cont++;
	$sql = $objQuery->SQLQuery("SELECT ".$data_prazo_inc." as data_prazo,(".$sql_franquia.") as fantasia,(".$sql_usuario_resp.") as responsavel, pi.certidao_matricula, pi.certidao_cidade, pi.certidao_estado, pi.id_empresa_resp,
		st.status, a.atividade, uu.nome as atendente, pi.certidao_devedor, p.forma_pagamento, p.cpf, pi.data_i, pi.*, p.data, pi.inicio, p.cpf, p.nome, p.cidade, p.estado, p.contato, s.descricao as servico, sd.departamento, pi.valor
        from vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as uu, vsites_atividades as a, vsites_servico as s, vsites_status as st, vsites_servico_departamento as sd where 
		pi.id_pedido_item='".$id_pedido_item."' and 
		pi.id_pedido = p.id_pedido and 
		pi.id_servico = s.id_servico and
        pi.id_usuario = uu.id_usuario and
		(uu.id_empresa='".$controle_id_empresa."' or pi.id_empresa_resp='".$controle_id_empresa."' ) and
		pi.id_atividade = a.id_atividade and 
		pi.id_servico_departamento = sd.id_servico_departamento and
        pi.id_status = st.id_status order by ".$busca_ordenar_por);
	$num = mysql_num_rows($sql);
	if($num<>''){
		$res = mysql_fetch_array($sql);
		if($res["id_empresa_resp"]<>0 and $res["id_empresa_resp"]==$controle_id_empresa) $outra_franquia = ';'.$res['fantasia'].';'; else $outra_franquia = ';;'.$res['fantasia'];
		if($busca_e_inicio=='on') $r_inicio=';'.invert($res['inicio'],'/','PHP'); else $r_inicio='';
		if($busca_e_prazo=='on') $r_prazo=';'.invert($res["data_prazo"],'/','php'); else $r_prazo='';
		if($busca_e_status=='on') $r_status=';'.$res["status"]; else $r_status='';
		if($busca_e_data_atividade=='on') $r_data_atividade=';'.invert($res['data_atividade'],'/','PHP');  else $r_data_atividade='';
		if($busca_e_atendimento=='on') $r_atendimento=';'.$res['atendente']; else $r_atendimento='';
		if($busca_e_responsavel=='on') $r_responsavel=';'.$res['responsavel']; else $r_responsavel='';
		if($busca_e_servico=='on') $r_servico=';'.$res['servico']; else $r_servico='';
		if($busca_e_atividade=='on') $r_atividade=';'.$res['atividade']; else $r_atividade='';
		if($busca_e_agenda=='on') $r_agenda=';'.invert($res['data_i'],'/','PHP'); else $r_agenda='';
		if($busca_e_departamento=='on') $r_departamento=';'.$res['departamento']; else $r_departamento='';
		$r_valor=';'.$res["valor"];
		if($busca_e_nome=='on') $r_nome=';'.$res["certidao_nome"]; else $r_nome='';
		if($busca_e_cidade=='on') $r_cidade=';'.$res['certidao_cidade']; else $r_cidade='';
		if($busca_e_estado=='on') $r_estado=';'.$res['certidao_estado']; else $r_estado='';
		if($busca_e_forma=='on') $r_forma=';'.$res["forma_pagamento"]; else $r_forma='';
		if($busca_e_cpf=='on') $r_cpf=';'.$res["cpf"].' .'; else $r_cpf='';
		if($busca_e_devedor=='on') $r_devedor=';'.$res["certidao_devedor"]; else $r_devedor='';
			
		$linha_arq = '#'.$res['id_pedido'].'/'.$res['ordem'].$r_inicio.$r_prazo.$r_data_atividade.';'.$res['certidao_cpf'].' .;'.$res['certidao_matricula'].$res['certidao_cnpj'].' .'.$r_nome.$r_devedor.$r_forma.$r_cpf.$r_atendimento.$r_responsavel.$r_servico.$r_cidade.$r_estado.$r_atividade.$r_status.$r_agenda.$r_valor.$r_departamento.$outra_franquia;
		$myArr = explode(';',$linha_arq);
		$excel->writeLine($myArr);
	}
}
header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);
#Colocar aqui o script para download do arquivo
?>