<? require('header.php');
$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_conveniado.png" alt="Título" />
Conveniado</h1>
<hr class="tit" />
<br />
</div>
<div id="meio"><?
$clienteDAO = new ClienteDAO();
$conveniadoDAO = new ConveniadoDAO();
$usuarioDAO = new UsuarioDAO();
pt_register('POST','submit');
pt_register('GET','id_cliente');
if ($submit) {//check for errors
	$errors=array();
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','nome');
	pt_register('POST','id_cliente');
	pt_register('POST','contato');
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
	pt_register('POST','complemento');
	pt_register('POST','numero');
	pt_register('POST','fax');
	pt_register('POST','telcel');
	pt_register('POST','outros');
	pt_register('POST','ramal');
	pt_register('POST','status');
	pt_register('POST','tipo');
	pt_register('POST','faturamento');
	pt_register('POST','id_usuario_com');


	if($cpf=="" || $nome=="" || $cep=="" || $id_cliente=="" || $tel==""){
		if($cpf=="") $errors['cpf']=1;
		if($nome=="") $errors['nome']=1;
		if($cep=="") $errors['cep']=1;
		if($tel=="") $errors['tel']=1;
		if($id_cliente=="") $errors['id_cliente']=1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}

	if(!validaTel($tel)){
		$errors['tel']=1;
		$error.="<li><b>O telefone é inválido.</b></li>";
	}

	if($email<>''){
		$valida = validaEMAIL($email);
		if($valida=='false'){
			$errors['email']=1;
			$error.="<li><b>E-mail Inválido, digite corretamente.</b></li>";
		}
	}
	if($tipo=='cpf'){
		if(validaCPF($cpf)=='false'){
			$errors['cpf']=1;
			$error.="<li><b>CPF Inválido, digite corretamente.</b></li>";
		}
	} else {
		if(validaCNPJ($cpf)=='false'){
			$errors['cpf']=1;
			$error.="<li><b>CNPJ Inválido, digite corretamente.</b></li>";
		}
	}

	if($email<>''){
		require('../includes/verifica_login.php');
	}
	if(count($errors)==0) {

		$conveniado = new stdClass();
		$conveniado->nome = $nome;
		$conveniado->id_cliente = $id_cliente;
		$conveniado->contato = $contato;
		$conveniado->cel = $cel;
		$conveniado->tel = $tel;
		$conveniado->email = $email;
		$conveniado->endereco = $endereco;
		$conveniado->bairro = $bairro;
		$conveniado->cidade = $cidade;
		$conveniado->estado = $estado;
		$conveniado->cep = $cep;
		$conveniado->cpf = $cpf;
		$conveniado->rg = $rg;
		$conveniado->complemento = $complemento;
		$conveniado->numero = $numero;
		$conveniado->fax = $fax;
		$conveniado->telcel = $telcel;
		$conveniado->outros = $outros;
		$conveniado->ramal = $ramal;
		$conveniado->status = $status;
		$conveniado->tipo = $tipo;
		$conveniado->faturamento = $faturamento;
		$conveniado->id_usuario_com = $id_usuario_com;

		$id = $conveniadoDAO->inserir($conveniado);
		$done=1;
	}
	if (count($errors)) {?>
<div class="erro"><?php echo $error; ?></div>
	<?}
	if ($done) {
		//alterado 01/04/2011
		$titulo = 'Adicionar Conveniado';
		$perg   = 'Registro adicionado com sucesso!\nEnviar login e senha por email?';
		$resp1  = 'envia_senha_conveniado.php?id='.$id;
		$resp2  = 'conveniado.php';
		$funcJs = "openConfirmBox('".$titulo."','".$perg."','".$resp1."','".$resp2."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />'; 
	}
}
if (!$done) { ?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"
			name="conveniado_add">
		<table width="650" class="tabela">
			<tr id="comissionado_titulo">
				<td colspan="4" class="tabela_tit">Comissionado</td>
			</tr>
			<tr id="comissionado_func">
				<td>
				<div align="right"><strong>Funcionário: </strong></div>
				</td>
				<td colspan="3"><select name="id_usuario_com" style="width: 470px"
					class="form_estilo">
					<option value=""></option>
					<?
					$funcionarios = $usuarioDAO->listarPorDepartamentoEmpresa($controle_id_empresa,14);
					$p_valor='';
					foreach($funcionarios as $f){
						$p_valor.='<option value="'.$f->id_usuario.'"';
						if($id_usuario_com==$f->id_usuario) $p_valor.=' selected="select" ';
						$p_valor.='>'.$f->nome.'</option>';
					}
					echo $p_valor;
					?>
				</select></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Dados do Conveniado</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Status: </strong></div>
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
				<td></td>
				<td colspan="3"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Conveniado: </strong></div>
				</td>
				<td colspan="3"><select name="id_cliente" style="width: 470px;"
					class="form_estilo">
					<option value=""
					<? if($id_cliente=='') echo 'selected="selected"'; ?>></option>
					<?
					$clientes = $clienteDAO->listarPorEmpresa($controle_id_empresa);
					foreach($clientes as $cliente){
						echo '<option value="'.$cliente->id_cliente.'" ';
						if($id_cliente==$cliente->id_cliente) echo ' selected="selected"';
						echo '>'.$cliente->nome.'</option>';
					}
					?>
				</select></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome" value="<?= $nome ?>"
					style="width: 470px"
					class="form_estilo <?=($errors['nome'])?'form_estilo_erro':''; ?>"><font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Contato: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="contato"
					value="<?= $contato ?>" style="width: 470px" class="form_estilo"></td>
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
				<div id="cpf" style="float: left"></div>
				<input type="text" name="cpf" value="<?=$cpf ?>"
					style="width: 150px"
					onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=($errors['cpf'])?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>RG/IE: </strong></div>
				</td>
				<td><input type="text" name="rg" value="<?= $rg ?>"
					style="width: 150px" class="form_estilo" /></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Tel: </strong></div>
				</td>
				<td><input type="text" name="tel" value="<?= $tel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo <?=($errors['tel'])?'form_estilo_erro':''; ?>" />
				- <input type="text" name="ramal" value="<?= $ramal ?>"
					style="width: 50px" onkeyup="masc_numeros(this,'####');"
					class="form_estilo" /><font color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>Fax: </strong></div>
				</td>
				<td><input type="text" name="fax" value="<?= $fax ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel/Cel: </strong></div>
				</td>
				<td><input type="text" name="telcel" value="<?= $telcel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Outros: </strong></div>
				</td>
				<td><input type="text" name="outros" value="<?= $outros ?>"
					style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Email: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="email"
					value="<?= $email ?>" style="width: 470px"
					class="form_estilo <?=($errors['email'])?'form_estilo_erro':''; ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endere&ccedil;o de Entrega</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3">
				<div style="float: left"><input type="text" name="cep"
					style="width: 150px" value="<?= $cep ?>"
					class="form_estilo <?=($errors['cep'])?'form_estilo_erro':''; ?>"
					onKeyUp="masc_numeros(this,'#####-###');" /> <font color="#FF0000">*</font>
				<input type="button" name="consultar2" value="Consultar"
					class="button_busca"
					onclick="carrega_endedeco(cep.value, 'conveniado_add');" /></div>
				</td>
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
					value="<?= $cidade ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?= $estado ?>" class="form_estilo" maxlength="2" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"></div>
				</td>
				<td colspan="3">
				<div style="width: 300px; float: left" class="form_estilo"><input
					type="checkbox"
					<? if($faturamento=='on') echo 'checked="checked"'; ?>
					name="faturamento" /> <strong>Faturar para o mesmo endereço</strong></div>
				</td>
			</tr>

			<tr>

				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Adicionar" class="button_busca" /> &nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.conveniado_add.action='conveniado.php'"
					class="button_busca" /></div>
				</td>
			</tr>
		</table>
		<div id="resgata_endereco"></div>
		</form>
		<div id="map_canvas"
			style="width: 400px; height: 400px; position: relative; display: none"></div>
		</blockquote>
		</td>
	</tr>
</table>
</div>
					<?php
}
require('footer.php');
?>
