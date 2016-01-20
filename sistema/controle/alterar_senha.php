<?
require('header.php');
require_once('../model/DatabaseEAD.php');
?>

<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_senha.png" alt="Título" />
Alterar Senha</h1>
<hr class="tit" />
</div>
<div id="meio"><?
pt_register('POST','submit');
$usuarioDAO = new UsuarioDAO();
if ($submit and $_SESSION['controle_teste'] == '') {//check for errors
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','senha_old');
	pt_register('POST','senha_new');
	pt_register('POST','senha_confirm');

	if($senha_new=="" || $senha_old=="" || $senha_confirm==""){
		$errors=1;
		$error.="<li><b>Todos os campos são obrigatórios.</b></li>";
	}
	if(!$usuarioDAO->verificaSenha($controle_login,$senha_old)){
		$errors=1;
		$error.="<li><b>A Senha atual não confere.</b></li>";
	}
	if($senha_new!=$senha_confirm){
		$errors=1;
		$error.="<li><b>A confirmação da nova senha não confere, digite novamente.</b></li>";
	}
	if($errors!=1) {
		$usuarioDAO->atualizaSenha($controle_login,$senha_new);
		$senha = $usuarioDAO->codificaSenha($controle_login,$senha_new);
		$_SESSION['controle_senha'] = $senha;                
                #atualiza no ead
                $usuario = $usuarioDAO->selectPorId($controle_id_usuario);
                $eadDAO = new EadDAO();
                $eadDAO->atualizaEad($usuario, $senha_new);                
                
		$done=1;
	}
	if ($errors) { $error.='</ul>'; ?>
<div class="erro"><?=$error;?></div>
	<?}elseif ($done) { 
		//alterado 01/04/2011
		$titulo = 'Mensagem da página web';
		$msg    = 'Senha alterada com sucesso!';
		$pagina = '';
		$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />'; 
	}
}
?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"
			name="alterar_senha">
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Alteração de Senha</td>
			</tr>
			<tr>
				<td width="206">
				<div align="right"><strong>Senha Atual: </strong></div>
				</td>
				<td width="198"><input type="password" name="senha_old"
					style="width: 150px" value="" class="form_estilo"> <font
					color="#FF0000">*</font>
				<div align="right"></div>
				</td>
			</tr>
			<tr>
				<td width="206">
				<div align="right"><strong>Nova Senha: </strong></div>
				</td>
				<td width="198"><input type="password" name="senha_new"
					style="width: 150px" value="" class="form_estilo"> <font
					color="#FF0000">*</font>
				<div align="right"></div>
				</td>
			</tr>
			<tr>
				<td width="206">
				<div align="right"><strong>Confirme a Nova senha: </strong></div>
				</td>
				<td width="198"><input type="password" name="senha_confirm"
					style="width: 150px" value="" class="form_estilo"> <font
					color="#FF0000">*</font>
				<div align="right"></div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<div align="center"><input type="submit" name="submit"
					value="Alterar" class="button_busca" /> &nbsp; <input type="submit"
					name="cancelar" value="Cancelar"
					onclick="document.alterar_senha.action='index.php'"
					class="button_busca" /></div>
				</td>
			</tr>
		</table>
		<div id="resgata_endereco"></div>
		</form>
		</blockquote>
		</td>
	</tr>
</table>
</div>
<?php

require('footer.php');
?>