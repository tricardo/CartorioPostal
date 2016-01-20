<? require('header.php'); ?>
<div id="topo"><?
$departamento_s = explode(',' ,$controle_id_departamento_s);
$permissao = verifica_permissao('Pontos de Vendas',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" />
Pontos de Vendas</h1>
<hr class="tit" />
<br />
</div>
<div id="meio"><?
$pontosDeVendasDAO = new PontosDeVendasDAO();
pt_register('POST','submit');
if ($submit) {//check for errors
	$error="";
	$errors=array();
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('GET','id');
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
	pt_register('POST','empresa');
	pt_register('POST','tipo');
	pt_register('POST','complemento');
	pt_register('POST','numero');
	pt_register('POST','ramal');
	pt_register('POST','status');
	pt_register('POST','id_usuario');

	$pVenda = new stdClass();
	$pVenda->id_ponto=$id;
	$pVenda->nome=$nome;
	$pVenda->cel=$cel;
	$pVenda->tel=$tel;
	$pVenda->email=$email;
	$pVenda->endereco=$endereco;
	$pVenda->bairro=$bairro;
	$pVenda->cidade=$cidade;
	$pVenda->estado=$estado;
	$pVenda->cep=$cep;
	$pVenda->cpf=$cpf;
	$pVenda->rg=$rg;
	$pVenda->empresa=$empresa;
	$pVenda->tipo=$tipo;
	$pVenda->complemento=$complemento;
	$pVenda->numero=$numero;
	$pVenda->ramal=$ramal;
	$pVenda->status=$status;
	$pVenda->id_usuario=$id_usuario;
	
	if($nome=="" || $empresa=="" || $tel=="" || $endereco=="" || $cidade=="" || $bairro=="" || $estado==""){
		if($nome=="")$errors['nome']=1;
		if($empresa=="")$errors['empresa']=1;
		if($tel=="")$errors['tel']=1;
		if($endereco=="")$errors['endereco']=1;
		if($cidade=="")$errors['cidade']=1;
		if($bairro=="")$errors['bairro']=1;
		if($estado=="")$errors['estado']=1;
		
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}

	if($tipo=='cpf' && $cpf!=''){
		if(validaCPF($cpf)=='false'){
			$errors['cpf']=1;
			$error.="<li><b>CPF Inválido, digite corretamente.</b></li>";
		}
	} elseif($tipo=='cnpj' && $cpf!='') {
		if(validaCNPJ($cpf)=='false'){
			$errors['cpf']=1;
			$error.="<li><b>CNPJ Inválido, digite corretamente.</b></li>";
		}
	}

	if (count($errors)==0) {
		$pontosDeVendasDAO->atualizar($pVenda);		
		$done = 1;
	}

	if (count($errors)>0) {
		echo '<div class="erro">'.$error.'</div>';
	}
	elseif ($done) {?>
		<script type="text/javascript">
			alert('Registro atualizado com sucesso!');
			window.location = 'pontosdevendas.php';		
		</script>
	<? exit;
	}
}
if (!$done && count($errors)<1){
	pt_register('GET','id');
	$pVenda = $pontosDeVendasDAO->selectPorId($id,$controle_id_empresa);
	if($pVenda->id_empresa==''){
		echo 'Você não tem permissão para alterar esse cadastro!';
		exit;
	}
}
?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" name="empresa_edit"
			method="post">
		<table width="650" border="0" style="text-align: left" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Comissionado</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Funcionário: </strong></div>
				</td>
				<td colspan="3">
					<select name="id_usuario" style="width: 470px" class="form_estilo">
					<option></option>
					<?
					$usuarioDAO = new UsuarioDAO();
					$usuarios = $usuarioDAO->listarPorDepartamentoEmpresa($controle_id_empresa,14);
					$v_valor = '';
					foreach($usuarios as $usuario){
						$v_valor.= '<option value="'.$usuario->id_usuario.'"';
						$v_valor .= ($pVenda->id_usuario==$usuario->id_usuario)?' selected="select" ':'';
						$v_valor.= '>'.$usuario->nome.'</option>';
					}
					echo $v_valor;
					?>
				</select></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Dados da Empresa</td>
			</tr>
			<tr>
				<td width="100">
				<div align="right"><strong>Status:</strong></div>
				</td>
				<td width="243"><select name="status" class="form_estilo"
					style="width: 150px">
					<option value="Ativo"
					<? if($pVenda->status=='Ativo') echo 'selected="selected"'; ?>>Ativo</option>
					<option value="Inativo"
					<? if($pVenda->status=='Inativo') echo 'selected="selected"'; ?>>Inativo</option>
					<option value="Cancelado"
					<? if($pVenda->status=='Cancelado') echo 'selected="selected"'; ?>>Cancelado</option>
				</select></td>
				<td width="70"></td>
				<td width="219"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Empresa: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="empresa"
					value="<?=$pVenda->empresa ?>" style="width: 470px" class="form_estilo <?=($errors['empresa'])?'form_estilo_erro':''; ?>"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome" value="<?=$pVenda->nome ?>"
					style="width: 470px" class="form_estilo <?=($errors['nome'])?'form_estilo_erro':''; ?>" /> <font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CPF/CNPJ: </strong></div>
				</td>
				<td>
				<div style="float: left"><? if($pVenda->tipo=='') $pVenda->tipo='cpf'; ?> <select
					name="tipo" onchange="carrega_cpf(this.value, '');"
					class="form_estilo">
					<option value="cpf"
					<? if($pVenda->tipo=='cpf') echo 'selected="selected"'; ?>>CPF</option>
					<option value="cnpj"
					<? if($pVenda->tipo=='cnpj') echo 'selected="selected"'; ?>>CNPJ</option>
				</select></div>
				<div id="cpf" style="float: left">
				<input type="text" name="cpf" value="<?=$pVenda->cpf ?>"
					style="width: 150px"
					onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=($errors['cpf'])?'form_estilo_erro':''; ?>" /> 
				</div></td>
				<td width="70">
				<div align="right"><strong>RG/IE: </strong></div>
				</td>
				<td width="219"><input type="text" name="rg" value="<?= $pVenda->rg ?>" style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel: </strong></div>
				</td>
				<td><input type="text" name="tel" value="<?= $pVenda->tel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo <?=($errors['tel'])?'form_estilo_erro':''; ?>" />
					<input type="text" name="ramal"
					value="<?=$pVenda->ramal ?>" style="width: 50px"
					onkeyup="masc_numeros(this,'####');" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Cel: </strong></div>
				</td>
				<td><input type="text" name="cel" value="<?=$pVenda->cel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Email: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="email"
					value="<?=$pVenda->email ?>" style="width: 470px"
					class="form_estilo <?=($errors['email'])?'form_estilo_erro':''; ?>" /></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="cep" style="width: 150px"
					value="<?=$pVenda->cep ?>" class="form_estilo"
					onKeyUp="masc_numeros(this,'#####-###');" /> <font color="#FF0000">*</font>
				<input type="button" name="consultar2" value="Consultar"
					class="button_busca"
					onclick="carrega_endedeco(cep.value, 'empresa_edit');" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco"
					value="<?=$pVenda->endereco ?>" style="width: 350px" class="form_estilo <?=($errors['endereco'])?'form_estilo_erro':''; ?>" />
				<strong>N&deg;</strong> <input type="text" name="numero"
					style="width: 95px" value="<?=$pVenda->numero ?>" class="form_estilo " /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Complemento: </strong></div>
				</td>
				<td><input type="text" name="complemento" style="width: 200px"
					value="<?=$pVenda->complemento ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input type="text" name="bairro" style="width: 150px"
					value="<?=$pVenda->bairro ?>" class="form_estilo <?=($errors['bairro'])?'form_estilo_erro':''; ?>" /></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" style="width: 200px"
					value="<?=$pVenda->cidade ?>" class="form_estilo <?=($errors['cidade'])?'form_estilo_erro':''; ?>" /> <input type="hidden"
					name="id" value="<?=$pVenda->id ?>" /></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?=$pVenda->estado ?>" class="form_estilo <?=($errors['estado'])?'form_estilo_erro':''; ?>" maxlength="2" /></td>
			</tr>

			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Atualizar" class="button_busca" /> &nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.empresa_edit.action='pontosdevendas.php'"
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
<?php require('footer.php');?>
