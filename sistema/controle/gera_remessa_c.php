<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require('../includes/dias_uteis.php');
require("../includes/geraexcel/excelwriter.inc.php");
	$error="";
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('GET','id_arquivo');
	$arquivoDiretorio = "./exporta/".$controle_id_usuario.".xls";
	$nomeArquivo = $controle_id_usuario.".xls";

    $excel=new ExcelWriter($arquivoDiretorio);

    if($excel==false){
        echo $excel->error;
		exit;
   }
   //Escreve o nome dos campos de uma tabela
   $linha_arq = 'Pedidos Importados';

   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	

   $linha_arq = 'CPF;Nome;Cidade;UF;Protocolo';

   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	

	$sql = $objQuery->SQLQuery("SELECT ai.* from vsites_arquivo_item as ai where id_arquivo = '".$id_arquivo."' and dup='0' and erro=''");
	while($res = mysql_fetch_array($sql)){
		$linha_arq = $res['certidao_cpf'].';'.$res['certidao_nome'].';'.$res['certidao_cidade'].';'.$res['certidao_estado'].';#'.$res['id_pedido_dup'].'/'.$res['ordem_dup'];
		$myArr = explode(';',$linha_arq);
		$excel->writeLine($myArr);
	}

   $linha_arq = ' ';

   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	

   $linha_arq = 'Duplicidades';

   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	

   $linha_arq = 'CPF;Nome;Cidade;UF;Protocolo';

   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	

	$sql = $objQuery->SQLQuery("SELECT ai.* from vsites_arquivo_item as ai where id_arquivo = '".$id_arquivo."' and dup='1' and erro=''");
	while($res = mysql_fetch_array($sql)){
		$linha_arq = $res['certidao_cpf'].';'.$res['certidao_nome'].';'.$res['certidao_cidade'].';'.$res['certidao_estado'].';#'.$res['id_pedido_dup'].'/'.$res['ordem_dup'];
		$myArr = explode(';',$linha_arq);
		$excel->writeLine($myArr);
	}
    
    header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
	header("Content-Length: ".filesize($arquivoDiretorio));
	readfile($arquivoDiretorio);
?>