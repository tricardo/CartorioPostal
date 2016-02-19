<? require('header.php'); ?>
<div id="topo">
<h1 class="tit"><img src="../images/tit_pessoa.png" alt="Título" />
Colaboradores</h1>
<hr class="tit" />

<?
$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
$permissao_expansao = verifica_permissao('Franchising_Expansão', $controle_id_departamento_p, $controle_id_departamento_s);

if(($permissao == 'FALSE' || $controle_id_empresa!=1) and  $permissao_expansao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?></div>
<div id="meio"><?
pt_register('POST','submit');
$errors=array();
if ($submit) {//check for errors
	$error = '<b>Ocorreram os seguintes erros:</b><ul>';
	pt_register('POST','senha');
	pt_register('POST','nome');
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
	pt_register('POST','id_empresa');
	pt_register('POST','tipo');
	pt_register('POST','complemento');
	pt_register('POST','numero');
	pt_register('POST','ramal');
	pt_register('POST','status');

	$u = new stdClass();
	$u->nome = $nome;
	$u->cel = $cel;
	$u->tel = $tel;
	$u->email = $email;
	$u->endereco = $endereco;
	$u->bairro = $bairro;
	$u->cidade = $cidade;
	$u->estado = $estado;
	$u->cep = $cep;
	$u->cpf = $cpf;
	$u->rg = $rg;
	$u->id_empresa = $id_empresa;
	$u->old_login = $old_login;
	$u->tipo = $tipo;
	$u->complemento = $complemento;
	$u->numero = $numero;
	$u->ramal = $ramal;
	$u->status = $status;

	require('../includes/verifica_login.php');

	if($id_empresa=="" || $cpf=="" || $nome=="" || $email=="" || $cep==""){
		$errors=array();
		if($id_empresa=="") $errors['id_empresa']=1;
		if($cpf=="") $errors['cpf']=1;
		if($nome=="") $errors['nome']=1;
		if($email=="") $errors['email']=1;
		if($cep=="") $errors['cep']=1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}
	$valida = validaEMAIL($email);
	if($valida=='false'){
		$errors['email']=1;
		$error.="<li><b>E-mail Inválido, digite corretamente.</b></li>";
	}

	if($tipo=='cpf'){
		$valida = validaCPF($cpf);
		if($valida=='false'){
			$errors['cpf']=1;
			$error.="<li><b>CPF Inválido, digite corretamente.</b></li>";
		}
	} else {
		$valida = validaCNPJ($cpf);
		if($valida=='false'){
			$errors['cpf']=1;
			$error.="<li><b>CNPJ Inválido, digite corretamente.</b></li>";
		}
	}

	if(count($errors)==0) {
		$tamanho = 6;$caracteres = "abcdefghijkmnpqrstuvwxyz23456789"; 	srand((double)microtime()*1000000);
		for($i=0; $i<$tamanho; $i++){
			$senha .= $caracteres[rand()%strlen($caracteres)];
		}
		$u->senha = $senha;
		$usuarioDAO = new UsuarioDAO();
		$id = $usuarioDAO->inserir($u);
		$done=1;
		//alterado 01/04/2011
		$titulo = 'Adicionar Usuário';
		$perg   = 'Novo registro adicionado com sucesso!\nEnviar Login e senha por e-mail?';
		$resp1  = 'envia_senha_usuario.php?id='.$id;
		$resp2  = 'usuario.php';
		$funcJs = "openConfirmBox('".$titulo."','".$perg."','".$resp1."','".$resp2."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
	else{ ?>
<div class="erro"><?=$error ?></div>
	<? }
}
if (!$done) {
	$empresaDAO = new EmpresaDAO();
	?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"
			name="usuario_add">
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados do Usu&aacute;rio</td>
			</tr>
			<tr>
				<td width="100">
				<div align="right"><strong>Status:</strong></div>
				</td>
				<td width="243"><select name="status" class="form_estilo"
					style="width: 150px">
					<option value="Ativo"
					<? if($status=='Ativo') echo 'selected="selected"'; ?>>Ativo</option>
					<option value="Inativo"
					<? if($status=='Inativo') echo 'selected="selected"'; ?>>Inativo</option>
					<option value="Cancelado"
					<? if($status=='Cancelado') echo 'selected="selected"'; ?>>Cancelado</option>
				</select></td>
				<td width="70"></td>
				<td width="219"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Empresa: </strong></div>
				</td>
				<td colspan="3"><select name="id_empresa" style="width: 470px"
					class="form_estilo <?=($errors['id_empresa'])?'form_estilo_erro':''; ?>">
					<option value=""
					<? if($u->id_empresa=='') echo 'selected="selected"'; ?>></option>
					<? $empresas = $empresaDAO->listarTodas();
					$p_valor = '';
					foreach($empresas as $emp){
						$p_valor .= '<option value="'.$emp->id_empresa.'" ';
						$p_valor .= ($id_empresa==$emp->id_empresa)?' selected="selected"':'';
						$p_valor .= '>'.$emp->fantasia.'</option>';
					}
					echo $p_valor;
					?>
				</select><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome" value="<?= $nome ?>"
					style="width: 470px"
					class="form_estilo <?=($errors['nome'])?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CPF/CNPJ: </strong></div>
				</td>
				<td>
				<div style="float: left"><? if($tipo=='') $tipo='cpf'; ?> <select
					name="tipo" class="form_estilo">
					<option value="cpf"
					<? if($tipo=='cpf') echo 'selected="selected"'; ?>>CPF</option>
					<option value="cnpj"
					<? if($tipo=='cnpj') echo 'selected="selected"'; ?>>CNPJ</option>
				</select></div>
				<div id="cpf" style="float: left"><input type="text" name="cpf"
					value="<?=$u->cpf ?>" style="width: 150px"
					onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=($errors['cpf'])?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font></div>
				</td>
				<td>
				<div align="right"><strong>RG/IE: </strong></div>
				</td>
				<td><input type="text" name="rg" value="<?= $rg ?>"
					style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel / Ramal: </strong></div>
				</td>
				<td><input type="text" name="tel" value="<?= $tel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /> - <input type="text" name="ramal"
					value="<?= $ramal ?>" style="width: 50px"
					onkeyup="masc_numeros(this,'####');" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Cel: </strong></div>
				</td>
				<td><input type="text" name="cel" value="<?= $cel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Email: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="email"
					value="<?= $email ?>" style="width: 470px"
					class="form_estilo  <?=($errors['email'])?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="cep" style="width: 150px"
					value="<?= $cep ?>"
					class="form_estilo  <?=($errors['cep'])?'form_estilo_erro':''; ?>"
					onKeyUp="masc_numeros(this,'#####-###');" /> <font color="#FF0000">*</font>
				<input type="button" name="consultar2" value="Consultar"
					class="button_busca"
					onclick="carrega_endedeco(cep.value, 'usuario_add');" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco"
					value="<?= $endereco ?>" style="width: 350px" class="form_estilo" />
				<strong>N&deg;</strong> <input type="text" name="numero"
					style="width: 95px" value="<?= $numero ?>" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Complemento: </strong></div>
				</td>
				<td><input type="text" name="complemento" style="width: 200px"
					value="<?= $complemento ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input type="text" name="bairro" style="width: 150px"
					value="<?= $bairro ?>" class="form_estilo" /></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" style="width: 200px"
					value="<?= $cidade ?>" class="form_estilo" /> <input type="hidden"
					name="id" value="<?= $id ?>" /> <input type="hidden"
					name="old_login" value="<?= $login ?>" /></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?= $estado ?>" class="form_estilo" maxlength="2" /></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Adicionar" class="button_busca" />&nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.usuario_add.action='usuario.php'"
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
}
require('footer.php');
?>