<? require('header.php');
$permissao = verifica_permissao('Pontos de Vendas',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" />
Pontos de Vendas</h1>
<hr class="tit" />
<br />
</div>
<div id="meio"><?
$pontosDeVendasDAO = new PontosDeVendasDAO();
pt_register('POST','submit');
if ($submit) {//check for errors
	$errors=array();
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
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
	$pVenda->status='Ativo';
	$pVenda->id_usuario=$id_usuario;
	$pVenda->id_empresa=$controle_id_empresa;

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
		$id = $pontosDeVendasDAO->inserir($pVenda);		
		$done = 1;
		
//		$query="insert into vsites_pontosdevendas (id_usuario,nome,cel,tel,email,endereco,bairro,cidade,estado,cep,data, cpf, rg, empresa, tipo, complemento, numero, ramal, status) values ('".$controle_id_usuario."','".$nome."','".$cel."','".$tel."','".$email."','".$endereco."','".$bairro."','".$cidade."','".$estado."','".$cep."',NOW(),'".$cpf."','".$rg."','".$empresa."','".$tipo."','".$complemento."','".$numero."','".$ramal."','Ativo')";
//		$result = $objQuery->SQLQuery($query);
//		$id = $objQuery->ID;
//		$done=1;
	}
	else {
		echo '<div class="erro">'.$error.'</div>';
	}
	
	if ($done) {?>
		<script type="text/javascript">
			alert('Registro adicionado com sucesso!');
			window.location = 'pontosdevendas.php';		
		</script>
	<? exit;
	}

}
if (!$done){
?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"
			name="empresa_add">
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Comissionado</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Funcionário: </strong></div>
				</td>
				<td colspan="3"><select name="id_usuario" style="width: 470px"
					class="form_estilo">
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
				<td>
				<div align="right"><strong>Empresa: </strong></div>
				</td>
				<td colspan="3">
				<input type="text" name="empresa" value="<?= $empresa ?>" style="width: 470px" class="form_estilo <?=($errors['empresa'])?'form_estilo_erro':''; ?>"> <font color="#FF0000">*</font>
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Respons&aacute;vel: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome" value="<?= $nome ?>"
					style="width: 470px" class="form_estilo <?=($errors['nome'])?'form_estilo_erro':''; ?>" /> <font color="#FF0000">*</font></td>
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
				<div id="cpf" style="float: left">
				<input type="text" name="cpf" value="<?=$pVenda->cpf ?>"
					style="width: 150px"
					onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=($errors['cpf'])?'form_estilo_erro':''; ?>" /> 
				</div>
				
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
					class="form_estilo <?=($errors['tel'])?'form_estilo_erro':''; ?>" /> - <input type="text" name="ramal"
					value="<?= $ramal ?>" style="width: 50px"
					onkeyup="masc_numeros(this,'####');" class="form_estilo" /><font color="#FF0000">*</font></td>
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
					value="<?= $email ?>" style="width: 470px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="cep" style="width: 150px"
					value="<?= $cep ?>" class="form_estilo"
					onKeyUp="masc_numeros(this,'#####-###');" /> 
				<input type="button" name="consultar2" value="Consultar"
					class="button_busca"
					onclick="carrega_endedeco(cep.value, 'empresa_add');" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco"
					value="<?= $endereco ?>" style="width: 350px" class="form_estilo <?=($errors['endereco'])?'form_estilo_erro':''; ?>" /><font color="#FF0000">*</font>
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
					value="<?= $bairro ?>" class="form_estilo <?=($errors['bairro'])?'form_estilo_erro':''; ?>" /><font color="#FF0000">*</font></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" style="width: 200px"
					value="<?= $cidade ?>" class="form_estilo <?=($errors['cidade'])?'form_estilo_erro':''; ?>" /><font color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?= $estado ?>" class="form_estilo <?=($errors['estado'])?'form_estilo_erro':''; ?>" maxlength="2" /><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Adicionar" class="button_busca" />&nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.empresa_add.action='pontosdevendas.php'"
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
