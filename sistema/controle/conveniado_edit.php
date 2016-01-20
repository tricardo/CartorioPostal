<?
require('header.php');
$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$clienteDAO = new ClienteDAO();
$usuarioDAO = new UsuarioDAO();
$conveniadoDAO = new ConveniadoDAO();
pt_register('GET','id');

?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_conveniado.png" alt="Título" />
Conveniados</h1>
<hr class="tit" />
<br />
</div>
<div id="meio"><?
pt_register('POST','submit');
if ($submit) {//check for errors
	$error="";
	pt_register('POST','id');
	$errors=array();
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','id_cliente');
	pt_register('POST','nome');
	pt_register('POST','cel');
	pt_register('POST','tel');
	pt_register('POST','email');
	pt_register('POST','old_email');
	pt_register('POST','endereco');
	pt_register('POST','bairro');
	pt_register('POST','cidade');
	pt_register('POST','estado');
	pt_register('POST','cep');
	pt_register('POST','complemento');
	pt_register('POST','numero');
	pt_register('POST','cpf');
	pt_register('POST','rg');
	pt_register('POST','tipo');
	pt_register('POST','status');
	pt_register('POST','fax');
	pt_register('POST','telcel');
	pt_register('POST','outros');
	pt_register('POST','status');
	pt_register('POST','ramal');
	pt_register('POST','faturamento');
	pt_register('POST','contato');
	pt_register('POST','id_usuario_com');

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
	$conveniado->id_conveniado = $id;

	if($cpf=="" || $nome=="" || $cep==""){
		if($cpf=="") $errors['cpf']=1;
		if($nome=="") $errors['nome']=1;
		if($tel=="") $errors['tel']=1;
		if($cep=="") $errors['cep']=1;
		if($id_cliente=="") $errors['id_cliente']=1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}
	if($email<>""){
		$valida = validaEMAIL($email);
		if($valida=='false'){
			$errors['email']=1;
			$error.="<li><b>E-mail Inválido, digite corretamente.</b></li>";
		}
	}

	if(!validaTel($tel)){
		$errors['tel']=1;
		$error.="<li><b>O telefone é inválido.</b></li>";
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

	if($email!=$old_email and $email!=''){
		require('../includes/verifica_login.php');
	}

	if (count($errors)==0) {
		$conveniadoDAO->atualizar($conveniado);
		$done = 1;
	}
	
		if (count($errors)) {?>
			<div class="erro"><?=$error; ?></div>
		<? }
		if ($done && $conveniado->status=='Ativo') {
			?> <script>
			if(confirm('Registro editado com sucesso!\nEnviar login e senha por email?')){
				window.location="envia_senha_conveniado.php?id=<?= $id ?>";
			}else{
				window.location="conveniado.php";
			}
			</script> <?
		}
		elseif($done && $conveniado->status!='Ativo'){ ?>
		 	<script>
			alert('Registro editado com sucesso!');
			window.location="conveniado.php";
			</script>
		<?php }
}
if (!$done && !count($errors)) {
	$conveniado = $conveniadoDAO->selectPorId($id,$controle_id_empresa);
}
?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"
			name="conveniado_edit" id="conveniado_edit">
		<table width="650" border="0" class="tabela">
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
						if($conveniado->id_usuario_com==$f->id_usuario) $p_valor.=' selected="select" ';
						$p_valor.='>'.$f->nome.'</option>';
					}
					echo $p_valor;
					?>
				</select></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Dados do conveniado</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Status: </strong></div>
				</td>
				<td width="243"><select name="status" class="form_estilo"
					style="width: 150px">
					<option value="Ativo"
					<? if($conveniado->status=='Ativo') echo 'selected="selected"'; ?>>Ativo</option>
					<option value="Inativo"
					<? if($conveniado->status=='Inativo') echo 'selected="selected"'; ?>>Inativo</option>
					<option value="Cancelado"
					<? if($conveniado->status=='Cancelado') echo 'selected="selected"'; ?>>Cancelado</option>
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
				<div align="right" style=" <? if ($conveniado->conveniado=="" or $conveniado->conveniado=="Não") echo 'visibility:hidden;'; ?> " id="conveniado_e"><strong>Empresa:
				</strong></div>
				</td>
				<td colspan="3"><select name="id_cliente" style="width: 470px;"
					class="form_estilo">
					<?
					$clientes = $clienteDAO->listarPorEmpresa($controle_id_empresa);
					foreach($clientes as $cliente){
						echo '<option value="'.$cliente->id_cliente.'" ';
						if($conveniado->id_cliente==$cliente->id_cliente) echo ' selected="selected"';
						echo '>'.$cliente->nome.'</option>';
					}
					?>
				</select></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome"
					value="<?= $conveniado->nome ?>" style="width: 470px"
					class="form_estilo <?=($errors['nome'])?'form_estilo_erro':''; ?>"><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Contato: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="contato"
					value="<?= $conveniado->contato ?>" style="width: 470px"
					class="form_estilo"><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CPF/CNPJ: </strong></div>
				</td>
				<td>
				<div style="float: left"><? if($conveniado->tipo=='') $conveniado->tipo='cpf'; ?>
				<select name="tipo" class="form_estilo">
					<option value="cpf"
					<? if($conveniado->tipo=='cpf') echo 'selected="selected"'; ?>>CPF</option>
					<option value="cnpj"
					<? if($conveniado->tipo=='cnpj') echo 'selected="selected"'; ?>>CNPJ</option>
				</select></div>
				<div id="cpf" style="float: left"><input type="text" name="cpf"
					value="<?=$conveniado->cpf ?>" style="width: 150px"
					onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=($errors['cpf'])?'form_estilo_erro':''; ?>" /></div>
				<font color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>RG/IE: </strong></div>
				</td>
				<td><input type="text" name="rg" value="<?= $conveniado->rg ?>"
					style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel: </strong></div>
				</td>
				<td><input type="text" name="tel" value="<?= $conveniado->tel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo <?=($errors['tel'])?'form_estilo_erro':''; ?>" /> - <input type="text" name="ramal"
					value="<?= $conveniado->ramal ?>" style="width: 50px"
					onkeyup="masc_numeros(this,'####');" class="form_estilo" /><font color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>Fax: </strong></div>
				</td>
				<td><input type="text" name="fax" value="<?= $conveniado->fax ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel/Cel: </strong></div>
				</td>
				<td><input type="text" name="telcel"
					value="<?= $conveniado->telcel ?>" style="width: 150px"
					onKeyUp="masc_numeros(this,'(##) ####-####');" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Outros: </strong></div>
				</td>
				<td><input type="text" name="outros"
					value="<?= $conveniado->outros ?>" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Email: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="email"
					value="<?= $conveniado->email ?>" style="width: 470px"
					class="form_estilo  <?=($errors['email'])?'form_estilo_erro':''; ?>" /> <input type="hidden" name="old_email"
					value="<?= $conveniado->email ?>" /></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço de Entrega</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3">
				<div style="float: left"><input type="text" name="cep"
					style="width: 150px" value="<?= $conveniado->cep ?>"
					class="form_estilo <?=($errors['cep'])?'form_estilo_erro':''; ?>" onKeyUp="masc_numeros(this,'#####-###');" /> <font
					color="#FF0000">*</font> <input type="button" name="consultar2"
					value="Consultar" class="button_busca"
					onclick="carrega_endedeco(cep.value, 'conveniado_edit');" /></div>
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco"
					value="<?= $conveniado->endereco ?>" style="width: 350px"
					class="form_estilo" /> <strong>N&deg;</strong> <input type="text"
					name="numero" style="width: 95px"
					value="<?= $conveniado->numero ?>" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Complemento: </strong></div>
				</td>
				<td><input type="text" name="complemento" style="width: 200px"
					value="<?= $conveniado->complemento ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input type="text" name="bairro" style="width: 150px"
					value="<?= $conveniado->bairro ?>" class="form_estilo" /></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" style="width: 200px"
					value="<?= $conveniado->cidade ?>" class="form_estilo" /> <input
					type="hidden" name="id" value="<?= $id ?>" /></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?= $conveniado->estado ?>" class="form_estilo"
					maxlength="2" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"></div>
				</td>
				<td colspan="3">
				<div style="width: 300px; float: left" class="form_estilo"><input
					type="checkbox"
					<? if($conveniado->faturamento=='on') echo 'checked="checked"'; ?>
					name="faturamento" /> <strong>Faturar para o mesmo endereço</strong></div>
				</td>
			</tr>
			<tr>

				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Atualizar" class="button_busca" /> &nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.conveniado_edit.action='conveniado.php'"
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
