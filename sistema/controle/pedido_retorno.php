<? 
@ini_set("memory_limit",'500M');
set_time_limit(1000);
require('header.php');
 
$permissao = verifica_permissao('Pedido Import Cart',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
	
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" /> Retorno de Arquivos do Cartório</h1>
    <hr class="tit"/>
</div>
<div id="meio">
<?
pt_register('POST','submit');
if ($submit) {//check for errors
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	$file_import = isset($_FILES["file_import"]) ? $_FILES["file_import"] : FALSE;
	// Formulário postado... executa as ações
	if($file_import['name']<>''){  
		$error_image = valida_upload_txt($file_import);
		if ($error_image){
			$error .= $error_image;
			$errors=1;
		}
	} else {
		$error .= 'Selecione o arquivo de importação.';
		$errors=1;
	}
	
	if($errors!=1) {
		if($file_import['name']<>''){
			$file_path = "./retorno/";
			// Pega extensão do file_import
			preg_match("/\.(txt|ret){1}$/i", $file_import["name"], $ext);
			// Gera um nome único para a imagem
			$imagem_nome = str_replace('.ret','',$file_import["name"]).$controle_id_usuario.'_'.md5(uniqid(time())) . "." . $ext[1];
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem
			move_uploaded_file($file_import["tmp_name"], $imagem_dir);
			$file_import_name = $imagem_nome;
		} else {
			$file_import_name = $file_import_name_imp;
		}
		require("pedido_import_retorno.php");
	}
}


	?>
    <table border="0">
		<tr>
        	<td valign="top">
	<?
	if ($errors) {
		echo $error.'<br><br>';
		
	}
	if ($done) {
		?><h3>Arquivo importado com sucesso!</h3>
		<h3>As ordens em vermelho não foram atualizadas: <?= $ordens ?></h3>
	<?
	}
	?> 
    		</td>
    	</tr>
    </table>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">
		
<form enctype="multipart/form-data" action="" method="post" name="pedido_add">
<div style="clear:both">
    <table width="800" class="tabela">
	<tr>
		<td colspan="4" class="tabela_tit"> Selecionar arquivo</td>
	</tr>
    <tr>
        <td> <div align="right"><strong>Selecione o arquivo: </strong></div></td>
		<td colspan="3">
			<input type="file" name="file_import" style="width:200px" value="<?= $file_import ?>" class="form_estilo"/>
			Opção disponível apenas para Notificação	
		</td>
    </tr>
    <tr>
        <td colspan="4">
			<div align="center">
				<input type="submit" name="submit" value="Importar" class="button_busca" />
            </div>
		</td>
    </tr>

    </table>
</div>
</form>
     </td>
</tr>
</table>
</div>
<?php 
require('footer.php');
?>