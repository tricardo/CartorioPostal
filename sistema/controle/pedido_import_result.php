<? 
@ini_set("memory_limit",'500M');
set_time_limit(1500);
require('header.php');

$permissao = verifica_permissao('Departamento',$controle_id_departamento_p,$controle_id_departamento_s);
?>
<div id="topo"><?
if($permissao == 'FALSE' or $controle_id_empresa!=1){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" />
Importação de Resultados</h1>
<hr class="tit" />
</div>

<div id="meio">
<?
$atividadeverificaDAO = new AtividadeVerificaDAO();
$pedidoDAO = new PedidoDAO();
$atividadeDAO = new AtividadeDAO();
$file_import = isset($_FILES["file_import"]) ? $_FILES["file_import"] : FALSE;
// Formulário postado... executa as ações
if($file_import['name']<>''){
	$error_image = valida_upload_txt($file_import);
	if ($error_image){
		$mail_mensagem .= '<li>Erro 1000 ao importar o arquivo, tente novamente!</li>';
		exit;
	}
	$file_path = "./exporta/";
	// Pega extensão do file_import
	preg_match("/\.(txt|rem){1}$/i", $file_import["name"], $ext);
	// Gera um nome único para a imagem
	$imagem_nome = $controle_id_usuario.'_'.md5(uniqid(time())) . "." . $ext[1];
	// Caminho de onde a imagem ficará
	$imagem_dir = $file_path.$imagem_nome;
	// Faz o upload da imagem
	move_uploaded_file($file_import["tmp_name"], $imagem_dir);
	$file_import_name = $imagem_nome;
} else {
	$mail_mensagem .= '<li>Erro 1001 ao importar o arquivo, tente novamente!</li>';
	exit;
}

#$file_import_name é definido no arquivo pedido_add.php
$fp = "./exporta/".$file_import_name;

#abre o arquivo
$handle = @fopen($fp, "r");

$importacaoDAO = new ImportacaoDAO();
#if o arquivo estiver errado finaliza
$linha_cont=0;
if($handle){
	while( ! feof($handle)){
		$linha_cont++;
		$buffer = fgets($handle, 4096);
		$buffer = str_replace ("'",'´',$buffer);
		$buffer = explode (";",$buffer);
		$qtdd_registros = count($buffer);

		if($qtdd_registros<4 or $qtdd_registros>5){
			if($qtdd_registros!=1)	$mail_mensagem .= '<li><b>LINHA '.$linha_cont.':</b> Quantidade de campos inválidos</li>';
		
			continue;
		} else {
			if($linha_cont>1){
				$id_pedido = explode('/',str_replace('#','',$buffer[0]));
				$p->id_pedido=$id_pedido[0];
				$p->ordem=$id_pedido[1];
				$p->id_usuario=$controle_id_usuario;
				$p->id_empresa=$controle_id_empresa;
				$p->protocolo=$buffer[1];
				$p->resultado=trim($buffer[2]);
				$p->custas=$buffer[3];
				$p->motivo=$buffer[4];
				if(!is_numeric($p->id_pedido) or !is_numeric($p->ordem)){
					$mail_mensagem .= '<li><b>LINHA '.$linha_cont.':</b><br> Número do pedido inválido ('.$p->id_pedido.'/'.$p->ordem.')</li>';
					continue;
				}
				$id_pedido_imp = $importacaoDAO->inserirPedidoImp($p);
				$res_oficio = $pedidoDAO->buscaPorIdOficio($p->id_pedido,$p->ordem,$controle_id_empresa);
				if(count($res_oficio)<>0){
					if($p->resultado=='Negativa' or $p->resultado=='Negativo' or $p->resultado=='Nada Consta' or $p->resultado=='Nada Constou'){
						$geraanexoCLASS = new GeraAnexoCLASS();
						$res_anexo = $geraanexoCLASS->geraProcessosDetran('Detran','Nada Constou','on',$controle_id_empresa,$controle_id_usuario,$p->id_pedido,$p->ordem,$res_oficio);
					}
					
					$p_verifica = $atividadeverificaDAO->AtividadeVerifica($controle_id_empresa,203,'.',explode(',',$controle_id_departamento_p),explode(',',$controle_id_departamento_s),$res_oficio->id_pedido_item);
					if($p_verifica['error']=='' and $res_oficio->id_status==4){
						$s->status_obs='.';
						$s->status_dias='';
						$s->status_hora='';
						$atividadeDAO->inserirAtividade(203,$s,$controle_id_usuario,$res_oficio->id_pedido_item);
						if($res_oficio->id_empresa_atend==$controle_id_empresa)
							$atividadeDAO->inserirAtividade(94,$s,$controle_id_usuario,$res_oficio->id_pedido_item);
						else 
							$atividadeDAO->inserirAtividade(205,$s,$controle_id_usuario,$res_oficio->id_pedido_item);
						$mail_mensagem_s .= '<li><b>Pedido '.$p->id_pedido.'/'.$p->ordem.':</b><br> Atividade atualizada com sucesso</li>';
						$cont_liberado++;
					} else {
						$mail_mensagem .= '<li><b>Pedido '.$p->id_pedido.'/'.$p->ordem.':</b><br> '.$p_verifica['error'];
						if($res_oficio->id_status==4){
							$mail_mensagem .= ' (O pedido já foi liberado para faturamento) ';
						}
						$mail_mensagem .= '</li>';
						$cont_erro++;
					}
				}
			}
		}
		if($linha_cont>=3000) {
			$mail_mensagem .= '<li>Foram importados os itens até a linha 3000</li>';
			break;
		}
		sleep(5);
	}
}

	//error_reporting(0);
	set_time_limit(0);
	require("../includes/maladireta/config.inc.php");
	require("../includes/maladireta/class.Email.php");
	error_reporting(1);
		
		
	$Sender = "Site <ti@cartoriopostal.com.br>";
	$Recipiant = 'emilia.silva@cartoriopostal.com.br';
	$Cc = 'ti@cartoriopostal.com.br';
	$Bcc = '';
	$Subject = 'Erros ao importar planilha';
	$html = 'Prezado(a) Operacional,<br><br>

	O Resultado da importação do arquivo foi:<br><br>
	Quantidade de liberados para faturamento: '.$cont_liberado.'<br>
	Mensagens de erro: '.$cont_erro.'<br>
	<ul>'.$mail_mensagem.'</ul><br><br>
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

echo '<h1><a href="pedido.php">Clique aqui para voltar</a></h1></div>';
require('footer.php');
?>