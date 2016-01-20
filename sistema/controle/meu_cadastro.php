<?
include('header.php');
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit_pessoa.png" alt="Título" /> Meu
Cadastro</h1>
<hr class="tit" />
</div>
<div id="meio"><?
$usuarioDAO = new UsuarioDAO();

pt_register('POST','submit');
if ($submit and $_SESSION['controle_teste'] == '') {//check for errors
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";

	pt_register('POST','nome');
	pt_register('POST','empresa');
	pt_register('POST','cel');
	pt_register('POST','tel');
	pt_register('POST','email');
	pt_register('POST','endereco');
	pt_register('POST','bairro');
	pt_register('POST','cidade');
	pt_register('POST','estado');
	pt_register('POST','cep');
	pt_register('POST','cpf');
	pt_register('POST','rg');
	pt_register('POST','tipo');
	pt_register('POST','ramal');
	pt_register('POST','complemento');
	pt_register('POST','numero');

	$usuario = new stdClass();
	$usuario->nome = $nome;
	$usuario->cel = $cel;
	$usuario->tel = $tel;
	$usuario->email = $email;
	$usuario->endereco = $endereco;
	$usuario->bairro = $bairro;
	$usuario->cidade = $cidade;
	$usuario->estado = $estado;
	$usuario->cep = $cep;
	$usuario->cpf = $cpf;
	$usuario->rg = $rg;
	$usuario->tipo = $tipo;
	$usuario->ramal = $ramal;
	$usuario->complemento = $complemento;
	$usuario->numero = $numero;
	$usuario->email = $controle_login;
	$usuario->empresa = $empresa;

	$errors=array();
	if($nome=="" || $email || $cep ){
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
		if($nome=="") $errors['nome']=1;
		if($email=="") $errors['email']=1;
		if($cep=="") $errors['cep']=1;
	}

	if($tipo=='cpf'){
		if(!validaCPF($cpf)){
			$errors['cpf']=1;
			$error.="<li><b>CPF Inválido, digite corretamente.</b></li>";
		}
	}
	if($tipo=='cnpj'){
		if(!validaCNPJ($cpf)){
			$errors['cnpj']=1;
			$error.="<li><b>CNPJ Inválido, digite corretamente.</b></li>";
		}
	}
	if(count($errors)==0) {
		$usuarioDAO->atualizar($usuario);
		$done = '1';
	}else{ $error.='</ul>'; ?>
<div class="erro"><?=$error; ?></div>
	<? }
	if ($done) {
		//alterado 01/04/2011
		$titulo = 'Mensagem da página web';
		$msg    = 'Registro atualizado com sucesso!';
		$pagina = 'index.php';
		$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
}else{
	$usuario = $usuarioDAO->selectPorEmail($controle_login);
}
?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"
			name="usuario_edit">
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados de Cadastro</td>
			</tr>
			<tr>
				<td width="100">
				<div align="right"><strong>Empresa: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="empresa"
					value="<?=$usuario->empresa ?>" style="width: 470px"
					class="form_estilo_r" readonly="readonly" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome"
					value="<?=$usuario->nome ?>" style="width: 470px"
					class="form_estilo <?=(isset($errors['nome']))?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CPF/CNPJ: </strong></div>
				</td>
				<td width="243">
				<div style="float: left"><? if($tipo=='') $tipo='cpf'; ?> <select
					name="tipo" onchange="carrega_cpf(this.value, '');"
					class="form_estilo_r" disabled="disabled">
					<option value="cpf"
					<? if($usuario->tipo=='cpf') echo 'selected="selected"'; ?>>CPF</option>
					<option value="cnpj"
					<? if($usuario->tipo=='cnpj') echo 'selected="selected"'; ?>>CNPJ</option>
				</select></div>
				<div id="cpf" style="float: left"><input type="text" name="cpf"
					value="<?= $usuario->cpf ?>" style="width: 150px"
					readonly="readonly" class="form_estilo_r" /></div>
				<font color="#FF0000">*</font></td>
				<td width="70">
				<div align="right"><strong>RG/IE: </strong></div>
				</td>
				<td width="219"><input type="text" name="rg"
					value="<?= $usuario->rg ?>" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel: </strong></div>
				</td>
				<td><input type="text" name="tel" value="<?= $usuario->tel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /> - <input type="text" name="ramal"
					value="<?= $usuario->ramal ?>" style="width: 50px"
					onkeyup="masc_numeros(this,'####');" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Cel: </strong></div>
				</td>
				<td><input type="text" name="cel" value="<?=$usuario->cel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Email: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="email"
					value="<?=$usuario->email ?>" style="width: 470px"
					class="form_estilo_r" readonly="readonly" /> <font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="cep" style="width: 150px"
					value="<?=$usuario->cep ?>"
					class="form_estilo <?=(isset($errors['cep']))?'form_estilo_erro':''; ?>"
					onKeyUp="masc_numeros(this,'#####-###');"
					onblur="carrega_endedeco(this.value, 'usuario_edit');" /> <font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco"
					value="<?=$usuario->endereco ?>" style="width: 350px"
					class="form_estilo" /> <strong>N&deg;</strong> <input type="text"
					name="numero" style="width: 95px" value="<?=$usuario->numero ?>"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Complemento: </strong></div>
				</td>
				<td><input type="text" name="complemento" style="width: 200px"
					value="<?=$usuario->complemento ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input type="text" name="bairro" style="width: 150px"
					value="<?=$usuario->bairro ?>" class="form_estilo" /></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" style="width: 200px"
					value="<?=$usuario->cidade ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?=$usuario->estado ?>" class="form_estilo" maxlength="2" /></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center">&nbsp;</div>
				</td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Atualizar" class="button_busca" /> &nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.usuario_edit.action='usuario.php'"
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
					include('footer.php');
					?>