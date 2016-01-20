<? require('header.php');
$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' and $controle_id_empresa!='1'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" />Franquia</h1>
<hr class="tit" />
</div>
<div id="meio">
<?
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
	pt_register('POST','fantasia');
	pt_register('POST','tipo');
	pt_register('POST','complemento');
	pt_register('POST','numero');
	pt_register('POST','ramal');
	pt_register('POST','status');
	pt_register('POST','franquia');
	pt_register('POST','imposto');
	pt_register('POST','royalties');
	pt_register('POST','adendo');
	pt_register('POST','adendo_data');
	pt_register('POST','inauguracao_data');
	pt_register('POST','validade_contrato');
	pt_register('POST','data_cof');
	pt_register('POST','exclusividade');
	pt_register('POST','notificacao');
	pt_register('POST','precontrato');
	pt_register('POST','aditivo');
	
	pt_register('POST','id_banco');
	pt_register('POST','agencia');
	pt_register('POST','conta');
	pt_register('POST','favorecido');


	if($royalties=="" || $cpf=="" || $nome=="" || $email=="" || $empresa=="" || $fantasia=="" || $tel=="" || $email==""
	|| $endereco=="" || $cidade=="" || $estado=="" || $bairro==""){
		if($royalties=="") $errors['royalties']=1;
		if($cpf=="") $errors['cpf']=1;
		if($nome=="") $errors['nome']=1;
		if($email=="") $errors['email']=1;
		if($empresa=="") $errors['empresa']=1;
		if($fantasia=="") $errors['fantasia']=1;
		if($tel=="") $errors['tel']=1;
		if($endereco=="") $errors['endereco']=1;
		if($bairro=="") $errors['bairro']=1;
		if($cidade=="") $errors['cidade']=1;
		if($estado=="") $errors['estado']=1;
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
		$emp = new stdClass();
		$emp->fantasia = $fantasia;
		$emp->imposto = $imposto;
		$emp->royalties = $royalties;
		$emp->nome = $nome;
		$emp->cel = $cel;
		$emp->tel = $tel;
		$emp->email = $email;
		$emp->endereco = $endereco;
		$emp->bairro = $bairro;
		$emp->cidade = $cidade;
		$emp->estado = $estado;
		$emp->cep = $cep;
		$emp->data = $data;
		$emp->cpf = $cpf;
		$emp->rg = $rg;
		$emp->empresa = $empresa;
		$emp->tipo = $tipo;
		$emp->complemento = $complemento;
		$emp->numero = $numero;
		$emp->ramal = $ramal;
		$emp->status = $status;
		$emp->franquia = $franquia;
		
		$emp->adendo_data = ($adendo_data!='')?invert($adendo_data,'-','SQL'):'';
		$emp->adendo = $adendo;
		$emp->inauguracao_data = ($inauguracao_data!='')?invert($inauguracao_data,'-','SQL'):'';;
		$emp->validade_contrato = ($validade_contrato!='')?invert($validade_contrato,'-','SQL'):'';
		$emp->data_cof = ($data_cof!='')?invert($data_cof,'-','SQL'):'';
		$emp->aditivo = ($aditivo!='')?invert($aditivo,'-','SQL'):'';
		$emp->precontrato = ($precontrato!='')?invert($precontrato,'-','SQL'):'';

		$emp->exclusividade = $exclusividade;
		$emp->notificacao = $notificacao;

		$emp->id_banco = trim($id_banco);
		$emp->agencia = trim($agencia);
		$emp->conta = trim($conta);
		$emp->favorecido = trim($favorecido);

		$empresaDAO = new EmpresaDAO();
		$id = $empresaDAO->inserir($emp);
		$done=1;
	}
	if (count($errors)) {?>
<div class="erro">
	<?php echo $error;?>
</div>
	<?}
	if ($done) {
		//alterado 01/04/2011
		$titulo = 'Adicionar empresa';
		$perg   = 'Novo registro adicionado com sucesso!\nAdicionar outro?';
		$resp1  = 'empresa_add.php';
		$resp2  = 'empresa.php';
		$funcJs = "openConfirmBox('".$titulo."','".$perg."','".$resp1."','".$resp2."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
}else $royalties=5.0;
if(!$done){
	$bancoDAO = new BancoDAO();
	$bancos = $bancoDAO->listar();
	?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"	name="empresa_add">
		<table border="0" style="text-align: left" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados da Franquia</td>
			</tr>
			<tr>
				<td width="110">
					<div align="right"><strong>Status:</strong></div>
				</td>
				<td width="243">
				<select name="status" class="form_estilo" style="width: 150px">
					<option value="Ativo"
					<? if($status=='Ativo') echo 'selected="selected"'; ?>>Ativo</option>
					<option value="Inativo"
					<? if($status=='Inativo') echo 'selected="selected"'; ?>>Inativo</option>
					<option value="Cancelado"
					<? if($status=='Cancelado') echo 'selected="selected"'; ?>>Cancelado</option>
				</select></td>
				<td width="109">
				<div align="right"><strong>Franquia:</strong></div>
				</td>
				<td width="210"><input type="radio" name="franquia"
				<? if($franquia=='Sim' or $franquia=='') echo 'checked="checked"'; ?>
					value="Sim" /> Sim <input type="radio" name="franquia" value="Não"
					<? if($franquia=='Não') echo 'checked="checked"'; ?> /> N&atilde;o
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Royalties:</strong></div>
				</td>
				<td colspan="3">
					<input type="text" id="royalties" name="royalties"	value="<?= $royalties ?>" style="width: 50px" onkeyup="moeda(event.keyCode,this.value,'royalties');" class="form_estilo <?=(isset($errors['royalties']))?'form_estilo_erro':''; ?>"> 
					Formato ##.##
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Empresa: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="empresa" value="<?= $empresa ?>" style="width: 512px" class="form_estilo <?=(isset($errors['empresa']))?'form_estilo_erro':''; ?>"><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Unidade: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="fantasia"
					value="<?= $fantasia ?>" style="width: 512px" class="form_estilo <?=(isset($errors['fantasia']))?'form_estilo_erro':''; ?>"><font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Responsável: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome" value="<?= $nome ?>"
					style="width: 512px"
					class="form_estilo <?=(isset($errors['nome']))?'form_estilo_erro':''; ?>" />
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
					value="<?= $cpf ?>" style="width: 150px"
					onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=(isset($errors['cpf']))?'form_estilo_erro':''; ?>" />
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
				<div align="right"><strong>Tel / Ramal: </strong></div>
				</td>
				<td>
				<input type="text" name="tel" value="<?= $tel ?>" style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');" class="form_estilo <?=(isset($errors['tel']))?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font><input type="text" name="ramal"
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
					value="<?= $email ?>" style="width: 512px"
					class="form_estilo <?=(isset($errors['email']))?'form_estilo_erro':''; ?>" />
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
					class="form_estilo <?=(isset($errors['cep']))?'form_estilo_erro':''; ?>"
					onKeyUp="masc_numeros(this,'#####-###');" /> <font color="#FF0000">*</font>
				<input type="button" name="consultar2" value="Consultar"
					class="button_busca"
					onclick="carrega_endedeco(cep.value, 'empresa_add');" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco"
					value="<?= $endereco ?>" style="width: 390px"
					class="form_estilo <?=(isset($errors['endereco']))?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font> <strong>N&deg;</strong> <input
					type="text" name="numero" style="width: 87px"
					value="<?= $numero ?>" class="form_estilo" /></td>
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
					class="form_estilo  <?=(isset($errors['bairro']))?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" style="width: 200px"
					value="<?= $cidade ?>"
					class="form_estilo  <?=(isset($errors['cidade']))?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?= $estado ?>"
					class="form_estilo  <?=(isset($errors['estado']))?'form_estilo_erro':''; ?>"
					maxlength="2" /><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Dados Bancários</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>Banco: </strong></div>
				</td>
				<td colspan="3">
				<select name="id_banco" class="form_estilo" style="width:509px">
					<option></option>
					<?php foreach($bancos as $banco){ ?>
					<option value="<?=$banco->id_banco;?>"
					<?=($id_banco==$banco->id_banco)?'selected="selected"':''?>><?=$banco->banco; ?></option>
					<?php }?>
				</select>
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Agência:</strong></div>
				</td>
				<td><input type="text" name="agencia" style="width: 150px"
					value="<?= $agencia ?>" class="form_estilo" maxlength="15" /></td>
				<td>
				<div align="right"><strong>Conta:</strong></div>
				</td>
				<td>
					<input type="text" name="conta" style="width: 150px" value="<?= $conta ?>" class="form_estilo" maxlength="15" />
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Favorecido:</strong></div>
				</td>
				<td  colspan="3"><input type="text" name="favorecido" style="width: 512px" value="<?= $favorecido ?>" class="form_estilo" maxlength="45" /></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Dados Operacionais</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Assinatura da COF:</strong></div>
				</td>
				<td>
					<input type="text" name="data_cof" value="<?=($emp->data_cof!='')?invert($emp->data_cof,'/','PHP'):''; ?>" style="width:150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?=(isset($errors['data_cof']))?'form_estilo_erro':''; ?>"/>
				</td>
				
				<td>
					<div align="right"><strong><label for="adendo">Adendo HSBC: </label></strong></div>
				</td>
				<td>
					<div style="width:17px; text-align:center; float:left; padding:1px;">
						<input type="checkbox" class="form_estilo" id="adendo" name="adendo" value="1" <?=($emp->adendo)?'checked="checked"':''?>/>
					</div>
					<input type="text" name="adendo_data" value="<?=($emp->adendo_data!='')?invert($emp->adendo_data,'/','PHP'):''; ?>" style="width: 131px" onkeyup="masc_numeros(this,'##/##/####');"	class="form_estilo  <?=(isset($errors['adendo_data']))?'form_estilo_erro':''; ?>" id="adendo_data"/>
					<span id="obrig"><font color="#FF0000">*</font></span>
				</td>
			</tr>
			
			<tr>
				<td>
					<div align="right"><strong>Início do Contrato:</strong></div>
				</td>
				<td>
					<input type="text" name="inauguracao_data" value="<?=($emp->inauguracao_data!='')?invert($emp->inauguracao_data,'/','PHP'):''; ?>" style="width:150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?=(isset($errors['inauguracao_data']))?'form_estilo_erro':''; ?>" id="inauguracao_data"/>
				</td>
				<td>
					<div align="right"><strong>Final do Contrato:</strong></div>
				</td>
				<td>
					<input type="text" name="validade_contrato" value="<?=($emp->validade_contrato!='')?invert($emp->validade_contrato,'/','PHP'):''; ?>" style="width: 150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?=(isset($errors['validade_contrato']))?'form_estilo_erro':''; ?>"/>
				</td>
			</tr>

			<tr>
				<td>
					<div align="right"><strong>Pré-Contrato:</strong></div>
				</td>
				<td>
					<input type="text" name="precontrato" value="<?=($emp->precontrato!='')?invert($emp->precontrato,'/','PHP'):''; ?>" style="width:150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?=(isset($errors['precontrato']))?'form_estilo_erro':''; ?>" id="inauguracao_data"/>
				</td>
				<td>
					<div align="right"><strong>Aditivo de Royalty:</strong></div>
				</td>
				<td>
					<input type="text" name="aditivo" value="<?=($emp->aditivo!='')?invert($emp->aditivo,'/','PHP'):''; ?>" style="width: 150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?=(isset($errors['aditivo']))?'form_estilo_erro':''; ?>"/>
				</td>
			</tr>

			<tr>
				<td>
					<div align="right"><strong>Exclusividade:</strong></div>
				</td>
				<td colspan="3">
					<input type="text" name="exclusividade" value="<?= $emp->exclusividade; ?>" style="width: 150px" onkeyup="masc_numeros(this,'##');"	class="form_estilo  <?=(isset($errors['exclusividade']))?'form_estilo_erro':''; ?>"/>(meses)
				</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>Notificação (Data,Motivo):</strong></div>
				</td>
				<td colspan="3">
					<textarea name="notificacao" style="width:512px; height:100px" class="form_estilo"><?= $emp->notificacao; ?></textarea>
				</td>
			</tr>

			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Adicionar" class="button_busca" />&nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.empresa_add.action='empresa.php'"
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
<script>
$(document).ready(function() {
	function toggleAdendo(){
	   if(($('#adendo').is(':checked'))){
		   $('#adendo_data').attr('readonly','');
		   $('#adendo_data').focus();
		   $('#obrig').show();
	   }else{
		   $('#adendo_data').attr('value','');
		   $('#adendo_data').attr('readonly','readonly');
		   $('#obrig').hide();
	   }
	}
	toggleAdendo();
   $('#adendo').change(function(){	toggleAdendo();});
});
</script>
					<? }
					require('footer.php'); ?>