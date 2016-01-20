<?
require('header.php');
$permissao = verifica_permissao('Parceiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />Parceiro</h1>
<hr class="tit" />
<br />
</div>
<div id="meio"><?
pt_register('POST','submit');
$clienteDAO = new ParceiroDAO();
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
	pt_register('POST','comissao');
	pt_register('POST','observacao');

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
	$c->comissao=$comissao;
	$c->retem_iss=$retem_iss;
	$c->restricao=$restricao;
	$c->ramal=$ramal;
	$c->conveniado=$conveniado;
	$c->observacao=$observacao;
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
	} 
	/*else {
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
	}*/
	if (count($errors)<1) {
		$clienteDAO->inserir($c, $controle_id_empresa);
		$done = 1;
		//alterado 01/04/2011
		$titulo = 'Mensagem da página web';
		$msg    = 'Novo registro adicionado com sucesso!';
		$pagina = 'parceiro.php';
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
			<input type="hidden" value="0" id="id_usuario_com" name="id_usuario_com" />
			<input type="hidden" value="0" id="conveniado" name="conveniado" />
			<input type="hidden" value="0" id="id_pacote" name="id_pacote" />
		<table width="650" border="0" class="tabela">
			
			<tr>
				<td colspan="4" class="tabela_tit">Dados do parceiro</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Status:</strong></div>
				</td>
				<td width="243"><select name="status" class="form_estilo"
					style="width: 150px">
					<option value="1"
					<? if($status==1) echo 'selected="selected"'; ?>>Ativo</option>
					<option value="0"
					<? if($status==0) echo 'selected="selected"'; ?>>Inativo</option>
				</select></td>
				<td width="70"></td>
				</td>
				<td width="219"></td>
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
				<td><strong>Comissão</strong></td>
				<td><input type="text" name="comissao" value="<?= $comissao ?>"
					style="width: 150px" class="form_estilo <?=($errors['comissao'])?'form_estilo_erro':''; ?>"><font
					color="#FF0000">*</font></td>
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
				<td align="right"><strong>Observação:</strong></td>
				<td colspan="3"><textarea name="observacao" class="form_estilo" style="width:470px; height:100px"><?= $c->observacao ?></textarea></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Adicionar" class="button_busca" /> &nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.cliente_edit.action='parceiro.php'"
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
