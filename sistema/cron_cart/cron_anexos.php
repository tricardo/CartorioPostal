<?php
ini_set('max_execution_time', '0');
require("../model/Database.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
require("../includes/geraexcel/excelwriter.inc.php");

$anexoDAO = new AnexoDAO();
$pedidoDAO = new PedidoDAO();
$anexoverificaDAO = new AnexoVerificaDAO();

//Ordens de processos
$departamento_p = '5';
$diretorio = '../anexos_imp/scan_geral_processos/'; 
// abre o diretório
$ponteiro  = opendir($diretorio);
// monta os vetores com os itens encontrados na pasta
while ($nome_itens = readdir($ponteiro)) {
    $itens[] = $nome_itens;
}

// ordena o vetor de itens
sort($itens);
// percorre o vetor para fazer a separacao entre arquivos e pastas 
foreach ($itens as $listar) {
// retira "./" e "../" para que retorne apenas pastas e arquivos
   if ($listar!="." && $listar!=".."){ 

// checa se o tipo de arquivo encontrado é uma pasta
		if (is_dir($listar)) { 
// caso VERDADEIRO adiciona o item à variável de pastas
			$pastas[]=$listar; 
		} else{ 
// caso FALSO adiciona o item à variável de arquivos
			$arquivos[]=$listar;
		}
   }
}

// lista os arquivos se houverem
$p_valor = '';
if ($arquivos != "") {
	foreach($arquivos as $listar){
		$id_pedido = explode('-',str_replace('.pdf','',$listar));
		$verifica = $anexoverificaDAO->AnexoVerificaImp('1',$departamento_p,$id_pedido[0],$id_pedido[1]);
		if($verifica->error!=''){
			$error .= " Arquivo Processos: ".str_replace('.pdf','',$listar)." Erro ao anexar o documento verifique o número da ordem!<br>".$verifica->error.'<br>';
		} else {
			$file_path = "../anexosnovos/".date('m').''.date('Y').'/';

			$imagem_nome = '1'.$verifica->id_pedido_item.md5(uniqid(time())) . ".pdf";
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem
			copy($diretorio.$listar, $imagem_dir);
			
			$anexo->id_usuario=1;
			$anexo->id_pedido_item=$verifica->id_pedido_item;
			$anexo->anexo=$file_path.$imagem_nome;
			$anexo->anexo_nome='Certidão';
			
			$pedidoDAO->inserirAnexo($anexo);
			$p_valor .= " Arquivo: ".str_replace('.pdf','',$listar)." Arquivo anexado com sucesso!<br>";

			unlink($diretorio.$listar);
		}
	}
}
unset ($arquivos);
unset($itens);


//Ordens de imoveis
$departamento_p = '8';
$diretorio = '../anexos_imp/scan_geral_imoveis/'; 
// abre o diretório
$ponteiro  = opendir($diretorio);
// monta os vetores com os itens encontrados na pasta
while ($nome_itens = readdir($ponteiro)) {
    $itens[] = $nome_itens;
}

// ordena o vetor de itens
sort($itens);
// percorre o vetor para fazer a separacao entre arquivos e pastas 
foreach ($itens as $listar) {
// retira "./" e "../" para que retorne apenas pastas e arquivos
   if ($listar!="." && $listar!=".."){ 

// checa se o tipo de arquivo encontrado é uma pasta
		if (is_dir($listar)) { 
// caso VERDADEIRO adiciona o item à variável de pastas
			$pastas[]=$listar; 
		} else{ 
// caso FALSO adiciona o item à variável de arquivos
			$arquivos[]=$listar;
		}
   }
}

// lista os arquivos se houverem
$p_valor = '';
if ($arquivos != "") {
	foreach($arquivos as $listar){
		$id_pedido = explode('-',str_replace('.pdf','',$listar));
		$verifica = $anexoverificaDAO->AnexoVerificaImp('1',$departamento_p,$id_pedido[0],$id_pedido[1]);
		if($verifica->error!=''){
			$error .= " Arquivo Imóveis: ".str_replace('.pdf','',$listar)." Erro ao anexar o documento verifique o número da ordem!<br>".$verifica->error.'<br>';
		} else {
			$file_path = "../anexosnovos/".date('m').''.date('Y').'/';

			$imagem_nome = '1'.$verifica->id_pedido_item.md5(uniqid(time())) . ".pdf";
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem
			copy($diretorio.$listar, $imagem_dir);
			$anexo->id_usuario=1;
			$anexo->id_pedido_item=$verifica->id_pedido_item;
			$anexo->anexo=$file_path.$imagem_nome;
			$anexo->anexo_nome='Certidão';
			
			$pedidoDAO->inserirAnexo($anexo);

			$p_valor .= " Arquivo: ".str_replace('.pdf','',$listar)." Arquivo anexado com sucesso!<br>";
			unlink($diretorio.$listar);
		}

	}
}
unset ($arquivos);
unset($itens);



//Ordens de 2via
$departamento_p = '3';
$diretorio = '../anexos_imp/scan_geral_2via/'; 
// abre o diretório
$ponteiro  = opendir($diretorio);
// monta os vetores com os itens encontrados na pasta
while ($nome_itens = readdir($ponteiro)) {
    $itens[] = $nome_itens;
}

// ordena o vetor de itens
sort($itens);
// percorre o vetor para fazer a separacao entre arquivos e pastas 
foreach ($itens as $listar) {
// retira "./" e "../" para que retorne apenas pastas e arquivos
   if ($listar!="." && $listar!=".."){ 

// checa se o tipo de arquivo encontrado é uma pasta
		if (is_dir($listar)) { 
// caso VERDADEIRO adiciona o item à variável de pastas
			$pastas[]=$listar; 
		} else{ 
// caso FALSO adiciona o item à variável de arquivos
			$arquivos[]=$listar;
		}
   }
}

// lista os arquivos se houverem
$p_valor = '';
if ($arquivos != "") {
	foreach($arquivos as $listar){
		$id_pedido = explode('-',str_replace('.pdf','',$listar));
		$verifica = $anexoverificaDAO->AnexoVerificaImp('1',$departamento_p,$id_pedido[0],$id_pedido[1]);
		if($verifica->error!=''){
			$error .= " Arquivo 2via: ".str_replace('.pdf','',$listar)." Erro ao anexar o documento verifique o número da ordem!<br>".$verifica->error.'<br>';
		} else {
			$file_path = "../anexosnovos/".date('m').''.date('Y').'/';

			$imagem_nome = '1'.$verifica->id_pedido_item.md5(uniqid(time())) . ".pdf";
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem
			copy($diretorio.$listar, $imagem_dir);
			$anexo->id_usuario=1;
			$anexo->id_pedido_item=$verifica->id_pedido_item;
			$anexo->anexo=$file_path.$imagem_nome;
			$anexo->anexo_nome='Certidão';
			
			$pedidoDAO->inserirAnexo($anexo);

			$p_valor .= " Arquivo: ".str_replace('.pdf','',$listar)." Arquivo anexado com sucesso!<br>";
			unlink($diretorio.$listar);
		}

	}
}

unset($arquivos);
unset($itens);

// pega o endereço do diretório processos
//Ordens de processos
$departamento_p = '9';
$diretorio = '../anexos_imp/scan_geral_protesto/'; 
// abre o diretório
$ponteiro  = opendir($diretorio);
// monta os vetores com os itens encontrados na pasta
while ($nome_itens = readdir($ponteiro)) {
    $itens[] = $nome_itens;
}

// ordena o vetor de itens
sort($itens);
// percorre o vetor para fazer a separacao entre arquivos e pastas 
foreach ($itens as $listar) {
// retira "./" e "../" para que retorne apenas pastas e arquivos
   if ($listar!="." && $listar!=".."){ 

// checa se o tipo de arquivo encontrado é uma pasta
		if (is_dir($listar)) { 
// caso VERDADEIRO adiciona o item à variável de pastas
			$pastas[]=$listar; 
		} else{ 
// caso FALSO adiciona o item à variável de arquivos
			$arquivos[]=$listar;
			echo $listar.'1';
		}
   }
}

// lista os arquivos se houverem
$p_valor = '';
if ($arquivos != "") {
	foreach($arquivos as $listar){
		$id_pedido = explode('-',str_replace('.pdf','',$listar));
		$verifica = $anexoverificaDAO->AnexoVerificaImp('1',$departamento_p,$id_pedido[0],$id_pedido[1]);
		if($verifica->error!=''){
			$error .= " Arquivo Protesto: ".str_replace('.pdf','',$listar)." Erro ao anexar o documento verifique o número da ordem!<br>".$verifica->error.'<br>';
			unlink($diretorio.$listar);
		} else {
			$file_path = "../anexosnovos/".date('m').''.date('Y').'/';

			$imagem_nome = '1'.$verifica->id_pedido_item.md5(uniqid(time())) . ".pdf";
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem
			copy($diretorio.$listar, $imagem_dir);
			$anexo->id_usuario=1;
			$anexo->id_pedido_item=$verifica->id_pedido_item;
			$anexo->anexo=$file_path.$imagem_nome;
			$anexo->anexo_nome='Certidão';
			
			$pedidoDAO->inserirAnexo($anexo);

			$p_valor .= " Arquivo: ".str_replace('.pdf','',$listar)." Arquivo anexado com sucesso!<br>";
			unlink($diretorio.$listar);
		}

	}
}


if($error<>''){

	//error_reporting(0);
	set_time_limit(0);
	require("../includes/maladireta/config.inc.php");
	require("../includes/maladireta/class.Email.php");
	error_reporting(1);
		
		
	$Sender = "Site <ti@cartoriopostal.com.br>";
	$Recipiant = 'emilia.silva@cartoriopostal.com.br';
	$Cc = 'ti@cartoriopostal.com.br';
	$Bcc = '';
	$Subject = 'Erros ao anexar documentos';
	$html = 'Prezado(a) Operacional,<br><br>

	Ocorreram os seguintes erros ao importar os arquivos.<br><br>

	'.$error.'
	Att,<br>
	Equipe Cartório Postal<br>
	';			
	//** you can still specify custom headers as long as you use the constant
	//** 'EmailNewLine' to separate multiple headers.
		
	$CustomHeaders= '';
		
	//** create the new email message. All constructor parameters are optional and
	//** can be set later using the appropriate property.
		
	$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
	$message->Cc = $Cc;
	$message->Bcc = $Bcc;
	// $text=$row[5];
	// $html=$row[5];
	//$content=$content;

	$message->SetHtmlContent($html);
		
	$pathToServerFile ="attachments/$at[1]/$at[2]";        //** attach this very PHP script.
	$serverFileMimeType = 'multipart/mixed';  //** this PHP file is plain text.
		
	//** attach the given file to be sent with this message. ANy number of
	//** attachments can be associated with an email message.
		
	//** NOTE: If the file path does not exist or cannot be read by PHP the file
	//** will not be sent with the email message.
	$message->Send();
}
echo $error;
echo '</pre>';
?>