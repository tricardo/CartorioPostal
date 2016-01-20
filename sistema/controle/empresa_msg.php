<?
require('header.php');
$permissao = verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" />
Franquia</h1>
<hr class="tit" />
</div>
<div id="meio"><?
pt_register('POST','submit');
$empresaMensagemDAO = new EmpresaMensagemDAO();

if ($submit) {
	pt_register('POST','mensagem');
	pt_register('POST','id_empresa');

	#upload de imagens
	$config = array();
	// Tamanho máximo do file_anexo (em bytes)
	$config["tamanho"] = 999999;
	// Largura máxima (pixels)
	$config["largura"] = 1024;
	// Altura máxima (pixels)
	$config["altura"]  = 1024;
	// Upload do Anexo
	$file_anexo = isset($_FILES["file_anexo"]) ? $_FILES["file_anexo"] : FALSE;
	// Formulário postado... executa as ações
	if($file_anexo['name']<>''){
		$error = valida_upload_pdf($file_anexo, $config);
		if ($error){
			$errors['anexo']=1;
		}
	}
	#fim do upload foto

	$m = new stdClass();
	$m->mensagem = $mensagem;
	$m->id_empresa = $id_empresa;
	$m->id_usuario = $controle_id_usuario;

	if($m->mensagem==""){
		$errors['mensagem']=1;
		$error='<li>Digite a mensagem</li>';
	}

	if(count($errors)==0) {
		$file_path = "../anexos_franquia/";
		if($file_anexo['name']){
			// Pega extensão do file_anexo
			preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $file_anexo["name"], $ext);
			// Gera um nome único para a imagem
			$imagem_nome = $controle_id_usuario.$id_empresa.md5(uniqid(time())) . "." . $ext[1];
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem
			move_uploaded_file($file_anexo["tmp_name"], $imagem_dir);
			$m->anexo = $imagem_nome;
		}

		$empresaMensagemDAO->inserir($m);
		//alterado 01/04/2011
		$titulo = 'Mensagem da página web';
		$msg    = 'Registro inserido com sucesso!';
		$pagina = 'franquias-listar.php';
		$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
		} else { ?>
		<div class="erro"><ul><?php echo $error;?></ul></div>
		<?php	}
}

if (!$submit) {
	pt_register('GET','id_empresa');
	pt_register('GET','pagina');
	pt_register('GET','busca');
	$mensagens = $empresaMensagemDAO->listar($id_empresa,$busca,$pagina);
	$empresaDAO = new EmpresaDAO();

	$empresa = $empresaDAO->selectPorId($id_empresa);
	?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" name="empresa_edit" method="post">
		<table width="407" border="0" style="text-align: left" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit"><?php echo $empresa->fantasia?></td>
			</tr>
			<tr>
				<td><b>Digite a Mensagem: </b> <textarea name="mensagem"
					class="form_estilo" style="width: 500px; height: 100px"></textarea>
				<input type="hidden" name="id_empresa"
					value="<?php echo $id_empresa ?>" /> <b>Selecione um documento
				(opcional): </b> <input type="file" class="form_estilo"
					name="file_anexo" /></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Atualizar" class="button_busca" /> &nbsp; <input
					type="submit" name="cancelar" value="Voltar"
					onclick="document.empresa_edit.action='franquias-listar.php?'"
					class="button_busca" /></div>
				</td>
			</tr>
		</table>
		</form>
		</blockquote>
		</td>
	</tr>
</table>
<table width="100%" cellpadding="4" cellspacing="1"
	class="result_tabela">
	<tr>
		<td class="result_menu" colspan="4"><b>Mensagens</b></td>
	</tr>
	<tr>
		<td class="result_menu" width="100"><b>Data</b></td>
		<td class="result_menu" width="100"><b>Anexo</b></td>
		<td class="result_menu" width="100"><b>Autor</b></td>
		<td class="result_menu"><b>Mensagem</b></td>
	</tr>
	<?php
	$p_valor = '';
	foreach($mensagens as $m){
		if($m->anexo<>''){
			$anexo = '<a href="download_anexo_emp.php?id='.$m->id_mensagem.'" target="_blank"><img src="../images/botao_print.png" title="Anexo" border="0"/></a>';
		} else {
			$anexo = '-';
		}
		$p_valor .= '<tr>
			<td class="result_celula">'. $m->data .'</td>
			<td class="result_celula">'.$anexo.'</td>
			<td class="result_celula">'. $m->autor.'</td>
			<td class="result_celula">'. str_replace("\r\n", "<br/>",$m->mensagem) .'</td>
		</tr>';
	}
	echo $p_valor;
	?>
	<tr>
		<td colspan="4" class="barra_busca"><?php $empresaMensagemDAO->QTDPagina(); ?></td>
	</tr>
</table>
</div>
	<?php require('footer.php');
}
?>