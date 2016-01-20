<?
require('header.php');
$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />
Cliente</h1>
<hr class="tit" />
<br />
</div>
<div id="meio"><?
pt_register('POST','submit');
$clienteDAO = new ClienteDAO();
$pacoteDAO = new PacoteDAO();
$usuarioDAO = new UsuarioDAO();
if ($submit) {//check for errors
	$error="";
	pt_register('POST','id');
	$errors=array();
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','nome');
	pt_register('POST','tel2');
	pt_register('POST','tel');
	pt_register('POST','email');
	pt_register('POST','endereco');
	pt_register('POST','bairro');
	pt_register('POST','cidade');
	pt_register('POST','estado');
	pt_register('POST','cep');
	pt_register('POST','complemento');
	pt_register('POST','numero');
	pt_register('POST','cpf');
	pt_register('POST','rg');
	pt_register('POST','im');
	pt_register('POST','tipo');
	pt_register('POST','status');
	pt_register('POST','fax');
	pt_register('POST','ramal2');
	pt_register('POST','outros');
	pt_register('POST','site');
	pt_register('POST','status');
	pt_register('POST','retem_iss');
	pt_register('POST','restricao');
	pt_register('POST','ramal');
	pt_register('POST','conveniado');
	pt_register('POST','id_usuario_com');
	pt_register('POST','id_pacote');

	$c = new stdClass();
	$c->nome=$nome;
	$c->tel2=$tel2;
	$c->tel=$tel;
	$c->email=$email;
	$c->endereco=$endereco;
	$c->bairro=$bairro;
	$c->cidade=$cidade;
	$c->estado=$estado;
	$c->cep=$cep;
	$c->complemento=$complemento;
	$c->numero=$numero;
	$c->cpf=$cpf;
	$c->rg=$rg;
	$c->im=$im;
	$c->tipo=$tipo;
	$c->status=$status;
	$c->fax=$fax;
	$c->ramal2=$ramal2;
	$c->outros=$outros;
	$c->site=$site;
	$c->status=$status;
	$c->retem_iss=$retem_iss;
	$c->restricao=$restricao;
	$c->ramal=$ramal;
	$c->conveniado=$conveniado;
	if($c->conveniado=='Não')
	$c->id_usuario_com=$id_usuario_com;
	else
	$c->id_usuario_com=null;
	$c->id_usuario=$controle_id_usuario;
	$c->id_pacote=$id_pacote;

	if($nome=="" || $tel=="" || $cep=="" || $endereco=="" || $numero=="" || $cidade=="" || $bairro=="" || $estado=="" ){
		if($nome=="") $errors['nome']=1;
		if($tel=="") $errors['tel']=1;
		if($cep=="") $errors['cep']=1;
		if($endereco=="") $errors['endereco']=1;
		if($numero=="") $errors['numero']=1;
		if($cidade=="") $errors['cidade']=1;
		if($bairro=="") $errors['bairro']=1;
		if($estado=="") $errors['estado']=1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}


	if(!validaTel($tel)){
		$errors['tel']=1;
		$error.="<li><b>O telefone é inválido.</b></li>";
	}

	#if($email!="" && validaEMAIL($email)=='false'){
	#	$errors['email']=1;
	#	$error.="<li><b>E-mail Inválido, digite corretamente.</b></li>";
	#}

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
	if($cpf!='' && $cpf!='00.000.000/0000-00' && $cpf!='000.000.000-00'){
		$n = $clienteDAO->verificaCPF($cpf,$controle_id_empresa);
		if($n>0){
			$errors['cpf']=1;
			$error.="<li><b>CPF/CNPJ já utilizado</b></li>";
		}
	}
	if (count($errors)<1) {
		$clienteDAO->inserir($c);
		$done = 1;
		//alterado 01/04/2011
		$titulo = 'Mensagem da página web';
		$msg    = 'Novo registro adicionado com sucesso!';
		$pagina = 'cliente.php';
		$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
	if ($errors) {
		echo '<div class="erro">'.$error.'</div>';
	}
}
if (!$done) { 

#<script type="text/javascript">
#function showHideConv(conveniado){
	#if(conveniado){
	#	document.getElementById('comissionado_func').style.display = "none";
	#	document.getElementById('comissionado_titulo').style.display = "none";
	#}else{
	#	document.getElementById('comissionado_func').style.display = "";
	#	document.getElementById('comissionado_titulo').style.display = "";
	#}
#}
#</script>
?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">

	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"
			name="cliente_edit" id="cliente_edit">
		<table width="650" border="0" class="tabela">
			<tr id="comissionado_titulo">
				<td colspan="4" class="tabela_tit">Prospecção por:</td>
			</tr>
			<tr id="comissionado_func">
				<td>
				<div align="right"><strong>Colaborador: </strong></div>
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
				<td colspan="4" class="tabela_tit">Dados do cliente</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Conveniado: </strong></div>
				</td>
				<td width="243">
				<div style="width: 150px" class="form_estilo"><input type="radio"
					name="conveniado" value="Sim" onclick="showHideConv(1);"
					<? if($conveniado=='Sim') echo 'checked="checked"'; ?>>Sim <input
					type="radio" name="conveniado" value="Não"
					onclick="showHideConv(0);"
					<? if($conveniado=='Não' or $c->conveniado=='') echo 'checked="checked"'; ?>>Não
				</div>
				</td>
				<td width="70"></td>
				<td width="219">
				<div style="width: 150px" class="form_estilo"><input type="checkbox"
				<? if($restricao=='on') echo 'checked="checked"'; ?>
					name="restricao" /> <strong>Tem restrição</strong></div>
				</td>
			</tr>
			<tr>
				<td>
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
				<td width="70">
				<div align="right"></div>
				</td>
				<td width="219">
				<div style="width: 150px" class="form_estilo"><input type="checkbox"
				<? if($retem_iss=='on') echo 'checked="checked"'; ?>
					name="retem_iss" /> <strong>Retem ISS</strong></div>
				</td>
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
					value="<?=$cpf ?>" style="width: 150px"
					onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=($errors['cpf'])?'form_estilo_erro':''; ?>" />
				</div>
				<font color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>RG/IE: </strong></div>
				</td>
				<td><input type="text" name="rg" value="<?= $rg ?>"
					style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>IM: </strong></div>
				</td>
				<td><input type="text" name="im" value="<?= $im ?>"
					style="width: 150px" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Pacote: </strong></div>
				</td>
				<td><select name="id_pacote" style="width: 150px;"
					class="form_estilo">
					<option value=""
					<? if($id_pacote=='') echo ' selected="selected" '; ?>>Sem Pacote</option>
					<?
					$pacotes = $pacoteDAO->listar();
					$p_valor='';
					foreach($pacotes as $pacote){
						$p_valor .= '<option value="'.$pacote->id_pacote.'"';
						if($id_pacote==$pacote->id_pacote)$p_valor.= ' selected="selected" ';
						$p_valor.=' >'.$pacote->pacote.'</option>';
					}
					echo $p_valor;
					?>
				</select></td>
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
				<div align="right"><strong>Tel: </strong></div>
				</td>
				<td><input type="text" name="tel2" value="<?= $tel2 ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /> - <input type="text" name="ramal2"
					value="<?= $ramal2 ?>" style="width: 50px"
					onkeyup="masc_numeros(this,'####');" class="form_estilo" /></td>
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
					class="form_estilo <?=($errors['email'])?'form_estilo_erro':''; ?>" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Site: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="site" value="<?= $site ?>"
					style="width: 470px" class="form_estilo" /></td>
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
					onclick="carrega_endedeco(cep.value, 'cliente_edit');" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco"
					value="<?= $endereco ?>" style="width: 350px"
					class="form_estilo <?=($errors['endereco'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font> <strong>N&deg;</strong> <input type="text"
					name="numero" style="width: 95px" value="<?= $numero ?>"
					class="form_estilo <?=($errors['numero'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
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
					value="<?= $bairro ?>"
					class="form_estilo  <?=($errors['bairro'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" style="width: 200px"
					value="<?= $cidade ?>"
					class="form_estilo  <?=($errors['cidade'])?'form_estilo_erro':''; ?>" />
				<input type="hidden" name="id" value="<?= $id ?>" /><font
					color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?= $estado ?>"
					class="form_estilo  <?=($errors['estado'])?'form_estilo_erro':''; ?>"
					maxlength="2" /><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Adicionar" class="button_busca" /> &nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.cliente_edit.action='cliente.php'"
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
<script>showHideConv(<?=($c->conveniado=='Sim')?1:0?>);</script>
<?php }
require('footer.php');
?>