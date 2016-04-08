<?php
require("includes.php");
require('includes/dias_uteis.php');
require("includes/geraexcel/excelwriter.inc.php");



$error="";
$errors=0;
$error="<b>Ocorreram os seguintes erros:</b><ul>";

$arquivoDiretorio = "./exporta/".md5($controle_id_usuario.date('YmdHis')).".xls";
$nomeArquivo = $controle_id_usuario.".xls";

$excel=new ExcelWriter($arquivoDiretorio);

if($excel==false){
	echo $excel->error;
	exit;
}

$financeiroDAO = new FinanceiroDAO();

$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$link = '';
$link .= '?pagina='.$c->pagina;
$c->busca_data_i = isset($c->busca_data_i) ? $c->busca_data_i : date('d/m/Y', strtotime('-5 years', strtotime(date('Y-m-d H:i:s'))));
$c->busca_data_f = isset($c->busca_data_f) ? $c->busca_data_f : date('d/m/Y');
$c->busca_data_i_a = isset($c->busca_data_i_a) ? $c->busca_data_i_a : date('d/m/Y', strtotime('-5 years', strtotime(date('Y-m-d H:i:s'))));
$c->busca_data_f_a = isset($c->busca_data_f_a) ? $c->busca_data_f_a : date('d/m/Y');
$c->busca_data_i_f = isset($c->busca_data_i_f) ? $c->busca_data_i_f : '';
$c->busca_data_f_f = isset($c->busca_data_f_f) ? $c->busca_data_f_f : '';
$c->busca_data_ci = isset($c->busca_data_ci) ? $c->busca_data_ci : '';
$c->busca_data_cf = isset($c->busca_data_cf) ? $c->busca_data_cf : '';


$arr_c = array('busca','busca_id_fatura','busca_autorizacao','busca_id_status','busca_forma_pagamento',
    'busca_id_atividade','busca_id_pacote','busca_origem','busca_id_departamento',
    'busca_id_usuario','busca_data_i','busca_data_f','busca_id_pedido','busca_ordenar','busca_ord',
    'busca_data_i_a','busca_data_f_a','busca_data_i_f','busca_data_f_f','busca_data_ci','busca_data_cf');
for($i = 0; $i < count($arr_c); $i++){
    $c->$arr_c[$i] = isset($c->$arr_c[$i]) ? $c->$arr_c[$i] : '';
    $link .= strlen($c->$arr_c[$i]) > 0 ? '&'.$c->$arr_c[$i].'='.$c->$arr_c[$i] : '';
}

$arr_c = array('busca_e_nome','busca_e_cpf','busca_e_inicio','busca_e_prazo','busca_e_agenda','busca_e_data_atividade',
    'busca_e_departamento','busca_e_servico','busca_e_cidade','busca_e_estado','busca_e_status',
    'busca_e_atividade','busca_e_atendimento','busca_e_devedor','busca_e_forma','busca_e_origem','busca_e_conclu');
for($i = 0; $i < count($arr_c); $i++){
    $c->$arr_c[$i] = isset($c->$arr_c[$i]) ? 1 : '';
    $link .= strlen($c->$arr_c[$i]) > 0 ? '&'.$c->$arr_c[$i].'=1' : '';
}

$busca_e_inicio   		= $c->busca_e_inicio;
$busca_e_conclu   		= $c->busca_e_conclu;
$busca_e_prazo   		= $c->busca_e_prazo;
$busca_e_agenda   		= $c->busca_e_agenda;
$busca_e_data_atividade 	= $c->busca_e_data_atividade;
$busca_e_valor   		= $c->busca_e_valor;
$busca_e_custas   		= $c->busca_e_custas;
$busca_e_rateio   		= $c->busca_e_rateio;
$busca_e_sedex   		= $c->busca_e_sedex;
$busca_e_departamento   	= $c->busca_e_departamento;
$busca_e_servico   		= $c->busca_e_servico;
$busca_e_status   		= $c->busca_e_status;
$busca_e_atividade   	= $c->busca_e_atividade;
$busca_e_responsavel   	= $c->busca_e_responsavel;
$busca_e_atendimento   	= $c->busca_e_atendimento;
$busca_e_forma   		= $c->busca_e_forma;
$busca_e_cpf   			= $c->busca_e_cpf;
$busca_e_cidade   		= $c->busca_e_cidade;
$busca_e_estado			= $c->busca_e_estado;
$busca_e_nome   			= $c->busca_e_nome;
$busca_e_devedor   		= $c->busca_e_devedor;


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

 
if($busca_e_inicio==1) $r_inicio=';Abertura';
if($busca_e_prazo==1) $r_prazo=';Prazo';
if($busca_e_conclu==1) $r_conclu=';Concluído Oper.';
if($busca_e_status==1) $r_status=';Status';
if($busca_e_data_atividade==1) $r_data_atividade=';Data Status';
if($busca_e_atendimento==1) $r_atendimento=';Atendimento';
if($busca_e_responsavel==1) $r_responsavel=';Responsável';
if($busca_e_servico==1) $r_servico=';Serviço';
if($busca_e_atividade==1) $r_atividade=';Atividade';
if($busca_e_agenda==1) $r_agenda=';Agenda';
if($busca_e_departamento==1) $r_departamento=';Departamento';
if($busca_e_valor==1) $r_valor=';Valor';
if($busca_e_custas==1) $r_custas=';Custas';
if($busca_e_rateio==1) $r_rateio=';Rateio';
if($busca_e_sedex==1) $r_sedex=';Sedex';
if($busca_e_forma==1) $r_forma=';Forma de Pagamento';
if($busca_e_cidade==1) $r_cidade=';Cidade';
if($busca_e_estado==1) $r_estado=';Estado';
if($busca_e_nome==1) $r_nome=';Nome';
if($busca_e_cpf==1) $r_cpf=';CPF/CNPJ Requerente';
if($busca_e_devedor==1) $r_devedor=';Devedor';
 
//Escreve o nome dos campos de uma tabela
$linha_arq = utf8_decode('#'.$r_inicio.$r_prazo.$r_data_atividade.';CPF;CNPJ'.$r_nome.$r_devedor.$r_forma.$r_cpf.$r_atendimento.$r_responsavel.$r_servico.$r_cidade.$r_estado.$r_atividade.$r_status.$r_agenda.';Valor'.$r_departamento);
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);
 
$sql_usuario_resp = " CASE WHEN pi.id_usuario_op != 0 THEN (SELECT uu_resp.nome from vsites_user_usuario as uu_resp where  uu_resp.id_usuario=pi.id_usuario_op) ELSE ('') END";

$sql_franquia = " CASE WHEN pi.id_empresa_resp <> '0' and pi.id_empresa_resp != '".$controle_id_empresa."' THEN (SELECT uf.fantasia from vsites_user_empresa as uf where  uf.id_empresa=pi.id_empresa_resp) ELSE
	CASE WHEN pi.id_empresa_resp <> '0' and pi.id_empresa_resp = '".$controle_id_empresa."' THEN (SELECT uf.fantasia from vsites_user_empresa as uf where  uf.id_empresa=uu.id_empresa) ELSE ('') END END";

$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido_item'].'##'));
$p_id_pedido = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido'].'##'));

$cont=0;

foreach ($_SESSION['rec_pedido'] as $id_pedido_item) {
    
	$valida = valida_numero($id_pedido_item);
	if($valida!='TRUE'){
		echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
		exit;
	}

	$cont++;
        $res = $financeiroDAO->exportar_arquivo('', '',2);
	if($res<>''){
            $res = ObjToArray(UTF_Encodes($res[0]));
            if($res["id_empresa_resp"]<>0 and $res["id_empresa_resp"]==$controle_id_empresa) $outra_franquia = (';'.$res['fantasia'].';'); else $outra_franquia = (';;'.$res['fantasia']);
            if($busca_e_inicio==1) $r_inicio=';'.invert($res['inicio'],'/','PHP'); else $r_inicio='';
            if($busca_e_prazo==1) $r_prazo=';'.invert($res["data_prazo"],'/','php'); else $r_prazo='';
            if($busca_e_status==1) $r_status=';'.$res["status"]; else $r_status='';
            if($busca_e_data_atividade==1) $r_data_atividade=';'.invert($res['data_atividade'],'/','PHP');  else $r_data_atividade='';
            if($busca_e_atendimento==1) $r_atendimento=';'.$res['atendente']; else $r_atendimento='';
            if($busca_e_responsavel==1) $r_responsavel=';'.$res['responsavel']; else $r_responsavel='';
            if($busca_e_servico==1) $r_servico=';'.$res['servico']; else $r_servico='';
            if($busca_e_atividade==1) $r_atividade=';'.$res['atividade']; else $r_atividade='';
            if($busca_e_agenda==1) $r_agenda=';'.invert($res['data_i'],'/','PHP'); else $r_agenda='';
            if($busca_e_departamento==1) $r_departamento=';'.$res['departamento']; else $r_departamento='';
            $r_valor=';'.$res["valor"];
            if($busca_e_nome==1) $r_nome=';'.$res["certidao_nome"]; else $r_nome='';
            if($busca_e_cidade==1) $r_cidade=';'.$res['certidao_cidade']; else $r_cidade='';
            if($busca_e_estado==1) $r_estado=';'.$res['certidao_estado']; else $r_estado='';
            if($busca_e_forma==1) $r_forma=';'.$res["forma_pagamento"]; else $r_forma='';
            if($busca_e_cpf==1) $r_cpf=';'.$res["cpf"].' .'; else $r_cpf='';
            if($busca_e_devedor==1) $r_devedor=';'.$res["certidao_devedor"]; else $r_devedor='';
                
            $linha_arq = ('#'.$res['id_pedido'].'/'.$res['ordem'].$r_inicio.$r_prazo.$r_data_atividade.';'.$res['certidao_cpf'].' .;'.$res['certidao_matricula'].$res['certidao_cnpj'].' .'.$r_nome.$r_devedor.$r_forma.$r_cpf.$r_atendimento.$r_responsavel.$r_servico.$r_cidade.$r_estado.$r_atividade.$r_status.$r_agenda.$r_valor.$r_departamento.$outra_franquia);
            #echo (($linha_arq));exit;
            $myArr = explode(';',utf8_decode($linha_arq));
            $excel->writeLine($myArr);
	}

}
header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);