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
   
	$busca_classificacao   	= $_SESSION['f_busca_classificacao'];
   
  
   //Escreve o nome dos campos de uma tabela
			$financeiro_valor = 'Valor das Custas/Hon.';

   $linha_arq = '#Ordem;Franquia;Custas/Hon.;Valor Recebido;Departamento;Servico;Atividade;Responsavel;';
   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	
  
	$campo = $_SESSION['pedido_campo'];
	$condicao = $_SESSION['pedido_condicao'];
	
	$sql_todos = $objQuery->SQLQuery("select ".$campo." ".str_replace('?',$controle_id_empresa,$condicao));
	while($res = mysql_fetch_array($sql_todos)){
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
    #Colocar aqui o script para download do arquivo
?>