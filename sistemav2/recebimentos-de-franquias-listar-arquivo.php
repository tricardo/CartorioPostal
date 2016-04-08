<?php
require("includes.php");

require('includes/dias_uteis.php');
require("includes/geraexcel/excelwriter.inc.php");

$financeiroDAO = new FinanceiroDAO();


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

$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca_autorizacao = isset($c->busca_autorizacao) ? $c->busca_autorizacao : '';
$c->busca_data_i = isset($c->busca_data_i) ? $c->busca_data_i : date('01/m/Y', strtotime('-1 years', strtotime(date('Y-m-15'))));
$c->busca_data_f = isset($c->busca_data_f) ? $c->busca_data_f : date('01/m/Y');
$c->busca_id_departamento = isset($c->busca_id_departamento) ? $c->busca_id_departamento : '';
$c->busca_id_status = isset($c->busca_id_status) ? $c->busca_id_status : '';
$c->busca_id_empresa = isset($c->busca_id_empresa) ? $c->busca_id_empresa : '';
$c->busca_id_pedido = isset($c->busca_id_pedido) ? $c->busca_id_pedido : '';
$c->busca_ord = isset($c->busca_ord) ? $c->busca_ord : '';
$c->busca_ordenar = isset($c->busca_ordenar) ? $c->busca_ordenar : '';

$busca = new stdClass();
$busca->busca_autorizacao=$c->busca_autorizacao;
$busca->busca_data_i=$c->busca_data_i;
$busca->busca_data_f=$c->busca_data_f;
$busca->busca_id_departamento=$c->busca_id_departamento;
$busca->busca_id_status=$c->busca_id_status;
$busca->busca_id_empresa=$c->busca_id_empresa;
$busca->busca_id_pedido=$c->busca_id_pedido;
$busca->busca_ord=$c->busca_ord;
$busca->busca_ordenar=$c->busca_ordenar;

$financeiro_valor = 'Valor das Custas/Hon.';

$linha_arq = '#Ordem;Franquia;Custas/Hon.;Valor Recebido;Departamento;Servico;Atividade;Responsavel;';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

define('NO_PAGINACAO',1);
$cont = 0;
foreach($financeiroDAO->buscaRecebimentoF($busca, $controle_id_empresa, $c->pagina) AS $dt){
    $res = ObjToArray($dt);
    $cont++;
    $financeiro_valor 	= $res["financeiro_valor"];
    $financeiro_valor_f = $res["financeiro_valor_f"];
    $comissao			= number_format((float)($res["valor"])/100*14,2,".",",");
    $financeiro_valor   = number_format($financeiro_valor,2,".",",");
    $financeiro_valor_f = number_format($financeiro_valor_f,2,".",",");

    $financeiro_valor_f_total      		= (float)($financeiro_valor_f_total)+(float)($financeiro_valor_f);
    $financeiro_valor_total = (float)($financeiro_valor_total)+(float)($financeiro_valor);
    $comissao_total = (float)($comissao_total)+(float)($comissao);
    $financeiro_valor_f_num    = $financeiro_valor_f;
    $comissao            		= 'R$ '.$comissao;
    $financeiro_valor_f            		= 'R$ '.$financeiro_valor_f;
    $financeiro_valor 		= 'R$ '.$financeiro_valor;
    $financeiro_valor = $financeiro_valor;

    $linha_arq = '#'.$res['id_pedido'].'/'.$res['ordem'].';'.$res['fantasia'].';'.$financeiro_valor.';'.$financeiro_valor_f.';'.$res['departamento'].';'.$res['servico'].';'.$res['atividade'].';'.$res['responsavel'];
    $myArr = explode(';',$linha_arq);
    $excel->writeLine($myArr);
}

header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);