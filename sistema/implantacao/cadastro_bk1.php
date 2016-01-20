<? 
$royalties = new RoyaltieFixoDAO(); $c->total_mes = 18;
if(isset($c->submit)){
	$empresaDAO = new EmpresaDAO();
	$error = "";
	$errors = array();
    $error = "<b>Ocorreram os seguintes erros:</b><ul>";
	
	$readonly = !(in_array('1', $id_departamento_p) || in_array('17', $id_departamento_p));
	$emp = $empresaDAO->selectPorId($c->id_empresa);
	if (!$readonly) {
		$c->inicio = invert($c->inicio,'-','SQL');
	}
	$c->adendo_data = ($c->adendo_data != '') ? invert($c->adendo_data, '-', 'SQL') : '';
	$c->inauguracao_data = ($c->inauguracao_data != '') ? invert($c->inauguracao_data, '-', 'SQL') : '';
	$c->validade_contrato = ($c->validade_contrato != '') ? invert($c->validade_contrato, '-', 'SQL') : '';
	$c->data_cof = ($c->data_cof != '') ? invert($c->data_cof, '-', 'SQL') : '';
	$c->aditivo = ($c->aditivo != '') ? invert($c->aditivo, '-', 'SQL') : '';
	$c->precontrato = ($c->precontrato != '') ? invert($c->precontrato, '-', 'SQL') : '';
	
	if ($c->royalties == "" || $c->cpf == "" || $c->nome == "" || $c->email == "" || $c->fantasia == "" || 
		$c->empresa == "" || $c->tel == "" || $c->email == "" || $c->endereco == "" || $c->cidade == "" || 
		$c->estado == "" || $c->bairro == "" || $c->cep == "" || ($c->adendo == 1 && $c->adendo_data == '')) {
		if ($c->royalties == "")
			$errors['royalties'] = 1;
		if ($c->cpf == "")
			$errors['cpf'] = 1;
		if ($c->nome == "")
			$errors['nome'] = 1;
		if ($c->email == "")
			$errors['email'] = 1;
		if ($c->empresa == "")
			$errors['empresa'] = 1;
		if ($c->fantasia == "")
			$errors['fantasia'] = 1;
		if ($c->tel == "")
			$errors['tel'] = 1;
		if ($c->endereco == "")
			$errors['endereco'] = 1;
		if ($c->bairro == "")
			$errors['bairro'] = 1;
		if ($c->cidade == "")
			$errors['cidade'] = 1;
		if ($c->estado == "")
			$errors['estado'] = 1;
		if ($c->cep == "")
			$errors['cep'] = 1;
		if (($c->adendo == 1 && $c->adendo_data == ''))
			$errors['adendo_data'] = 1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}
	 $valida = validaEMAIL($c->email);
	if ($valida == 'false') {
		$errors['email'] = 1;
		$error.="<li><b>E-mail Inválido, digite corretamente.</b></li>";
	}

	if ($c->status=='Ativo' and $c->inicio=='') {
		$errors['inicio'] = 1;
		$error.="<li><b>Preencha o campo início antes de ativar a franquia</b></li>";
	}
	
	if ($c->tipo == 'cpf') {
		$valida = validaCPF($c->cpf);
		if ($valida == 'false') {
			$errors['cpf'] = 1;
			$error.="<li><b>CPF Inválido, digite corretamente.</b></li>";
		}
	} else {
		$valida = validaCNPJ($c->cpf);
		if ($valida == 'false') {
			$errors['cpf'] = 1;
			$error.="<li><b>CNPJ Inválido, digite corretamente.</b></li>";
		}
	}
	$emp = $c;	
	if (count($errors) == 0) {
		if($c->id_empresa > 0){
			$empresaDAO->atualizar($emp);
			$roy = $royalties->listar_franquia($c->id_empresa);
			if(count($roy) > 0){
				$royalties->atualizar($c);
			} else {
				$royalties->inserir($c);
			}
			$titulo = 'Mensagem da página web';
			$msg = 'Registro atualizado com sucesso!';
			$pagina = 'franquias_editar.php?id='.$c->id_empresa;
			$funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
			echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
		} else {
			$empresaDAO = new EmpresaDAO();
			$empresaDAO->inserir($emp);
			$titulo = 'Adicionar empresa';
			$perg   = 'Novo registro adicionado com sucesso!\nAdicionar outro?';
			$resp1  = 'franquias_editar.php?id=0';
			$resp2  = 'franquias-listar.php';
			$funcJs = "openConfirmBox('".$titulo."','".$perg."','".$resp1."','".$resp2."');";
			echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
		}
	} else {
		echo "<script>
			document.getElementById('errors').style.display = 'block';
			document.getElementById('errors').innerHTML = '<div class=\"erro\">".$error."</div><br />';
		</script>";
	}
}

$empresaDAO = new EmpresaDAO();
$emp = $empresaDAO->selectPorId($c->id_empresa); ?>
<label>Status</label>
	<select name="status" class="form_estilo" <?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?>>
		<option value="Ativo" <?=($emp->status=='Ativo')?'selected="selected"':''?>>Ativo</option>
		<option value="Cancelado"  <?=($emp->status=='Cancelado')?'selected="selected"':''?>>Cancelado</option>
		<option value="Implantação" <?=($emp->status=='Implantação')?'selected="selected"':''?>>Implantação</option>
		<option value="Inativo" <?=($emp->status=='Inativo')?'selected="selected"':''?>>Inativo</option>
	</select>
	
<label>Tipo Franquia:</label>
	<select onchange="franquia_master(this.value)" name="franquia_tipo" class="form_estilo" <?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?>>
		<option value="1" <?=($emp->franquia_tipo==1)?'selected="selected"':''?>>Master</option>
		<option value="2" <?=($emp->franquia_tipo==2)?'selected="selected"':''?>>Unitária</option>
		<option value="3" <?=($emp->franquia_tipo==3)?'selected="selected"':''?>>Sub Franquia</option>
	</select><br />
	
<?if($emp->franquia_tipo != 1){?>
<label id="lb_id_recursivo">Master:</label>
	<select style="width:562px" name="id_recursivo" id="id_recursivo" class="form_estilo" <?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?>>
		<option value="0"></option>
		<?$dt = $franquia->listar(4,$c);
		foreach ($dt as $f) { ?>
				<option value="<?=$f->id_empresa?>" <?=($f->id_empresa==$emp->id_recursivo)?'selected="selected"':''?>><?=$f->fantasia?></option>
		<? } ?>
	</select><br id="br_id_recursivo" />
<? } ?>

<label>Empresa:</label>
<input type="text" name="empresa" value="<?= $emp->empresa ?>" style="margin-left:1px;width:542px" class="form_estilo 
	<?= (isset($errors['empresa'])) ? 'form_estilo_erro' : ''; ?>"><font color="#FF0000">*</font><br />
	
<label>Unidade:</label>
<input type="text" name="fantasia"
value="<?= $emp->fantasia ?>" style="margin-left:1px;width:542px" class="form_estilo 
<?= (isset($errors['fantasia'])) ? 'form_estilo_erro' : ''; ?>"><font color="#FF0000">*</font><br />

<label>Nome</label>
<input type="text" name="nome" value="<?= $emp->nome ?>" style="margin-left:1px;width:542px"
class="form_estilo <?= (isset($errors['nome'])) ? 'form_estilo_erro' : ''; ?>" /><font color="#FF0000">*</font><br />

<label>CPF/CNPJ:</label>
<div style="float: left">
<? if ($emp->tipo == '')
	$emp->tipo = 'cpf'; ?>
	<select name="tipo" class="form_estilo" style="width:62px;">
		<option value="cpf" <?=($emp->tipo == 'cpf')?'selected="selected"':''?>>CPF</option>
		<option value="cnpj" <?=($emp->tipo == 'cnpj')?'selected="selected"':''?>>CNPJ</option>
	</select>
</div>
<div id="cpf" style="float: left"><input type="text" name="cpf" value="<?= $emp->cpf ?>" style="width: 150px"
	onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');"
	class="form_estilo <?= (isset($errors['cpf'])) ? 'form_estilo_erro' : ''; ?>" />
</div>
<font color="#FF0000">*</font>

<label>RG/IE:</label>
<input type="text" name="rg" value="<?= $emp->rg ?>" style="margin-left:1px;width:200px" class="form_estilo" /><br />

<label>Telefone:</label>
<input type="text" name="tel" value="<?= $emp->tel ?>"
	style="width: 130px" onKeyUp="masc_numeros(this,'(##) ####-####');"
class="form_estilo  <?= (isset($errors['tel'])) ? 'form_estilo_erro' : ''; ?>" />
<font style="float:left;color:#FF0000;margin-right:5px">*</font> 
<input type="text" name="ramal" value="<?= $emp->ramal ?>" style="width:71px"
	onkeyup="masc_numeros(this,'####');" class="form_estilo" />

<label>Celular:</label>
<input type="text" name="cel" value="<?= $emp->cel ?>"
style="margin-left:1px;width:200px;" onKeyUp="masc_numeros(this,'(##) ####-####');" class="form_estilo" /><br />

<label>E-mail</label>
<input type="text" <?=(strlen($emp->email) > 0 && $permissao_admin != 'TRUE')?'disabled="disabled"':''?> 
value="sigla do e-mail" class="form_estilo" style="width:130px;text-align:center"
onfocus="javascript:if(this.value == 'sigla do e-mail'){ this.value = ''; };" 
onblur="javascript:if(this.value == ''){ this.value = 'sigla do e-mail'; f_cpmail(); };" 
onkeyup="f_cpmail()" id="sigla" />
<input type="text" name="email" id="email" value="<?= $emp->email ?>" style="width:405px" 
	class="form_estilo  <?= (isset($errors['email'])) ? 'form_estilo_erro' : ''; ?>"
	<?=($permissao_admin == 'TRUE') ? '' : 'readonly="readonly"'?>	/>
	<font style="float:left;color:#FF0000;margin-right:5px">*</font><br /><br />
	
<div class="frq_title">Endereço</div>

<label>CEP:</label>
<input type="text" name="cep" style="width: 150px" value="<?= $emp->cep ?>"
class="form_estilo  <?= (isset($errors['cep'])) ? 'form_estilo_erro' : ''; ?>"
onKeyUp="masc_numeros(this,'#####-###');" /> <font color="#FF0000">*</font>
<input type="button" name="consultar2" value="Consultar" class="button_busca"
onclick="carrega_endedeco(cep.value, 'form1');" />
<span id="resgata_endereco"></span><br />

<label>Endereço:</label>
<input type="text" name="endereco" value="<?= $emp->endereco ?>" style="width: 400px" 
class="form_estilo <?= (isset($errors['endereco'])) ? 'form_estilo_erro' : ''; ?>" />
<font style="float:left;color:#FF0000;margin-right:5px">*</font> 

<label style="width:auto">N&deg;:</label> 
<input type="text" name="numero" style="width:105px" value="<?= $emp->numero ?>" class="form_estilo" /><br />

<label>Bairro:</label>
<input type="text" name="bairro" value="<?= $emp->bairro ?>" style="width: 219px" 
class="form_estilo <?= (isset($errors['bairro'])) ? 'form_estilo_erro' : ''; ?>" />
<font style="float:left;color:#FF0000;margin-right:5px">*</font>

<label>Complemento:</label>
<input type="text" name="complemento" value="<?= $emp->complemento ?>" class="form_estilo" style="width: 191px" /><br />

<label>Cidade:</label>
<input type="text" name="cidade" style="width: 219px" value="<?= $emp->cidade ?>"
class="form_estilo <?= (isset($errors['cidade'])) ? 'form_estilo_erro' : ''; ?>" />
<font style="float:left;color:#FF0000;margin-right:5px">*</font>
<input type="hidden" name="id" value="<?= $id ?>" />

<label>Estado:</label>
<input type="text" name="estado" style="width: 191px" value="<?= $emp->estado ?>"
class="form_estilo <?= (isset($errors['estado'])) ? 'form_estilo_erro' : ''; ?>"
maxlength="2" /><font style="float:left;color:#FF0000;margin-right:5px">*</font><br /><br />

<div class="frq_title">Dados Bancários</div>

<label>Banco:</label>
<select name="id_banco" class="form_estilo" style="width:562px">
	<option></option>
	<? $bancoDAO = new BancoDAO();
    $bancos = $bancoDAO->listar();
	foreach ($bancos as $banco) { ?>
	<option value="<?= $banco->id_banco; ?>"
			<?= ($emp->id_banco == $banco->id_banco) ? 'selected="selected"' : '' ?>>
		<?= $banco->banco; ?></option>
	<? } ?>
</select><br />

<label>Agência:</label>
<input type="text" name="agencia" style="margin-left:1px;" value="<?= $emp->agencia ?>" class="form_estilo" maxlength="15" />

<label>Conta:</label>
<input type="text" name="conta" style="width:200px;margin-left:1px" value="<?= $emp->conta ?>" class="form_estilo" maxlength="15" /><br />

<label>Favorecido:</label>
<input type="text" name="favorecido" style="width:543px" value="<?= $emp->favorecido ?>" class="form_estilo" maxlength="45" /><br /><br />

<div class="frq_title">Dados Operacionais</div>

<label>Assinatura da COF:</label>
<input type="text" name="data_cof" value="<?= ($emp->data_cof != '') ? invert($emp->data_cof, '/', 'PHP') : ''; ?>" 
style="width:219px" onkeyup="masc_numeros(this,'##/##/####');" 
class="form_estilo  <?= (isset($errors['data_cof'])) ? 'form_estilo_erro' : ''; ?>"/>

<label for="adendo">Adendo HSBC:</label>
<div style="width:17px; text-align:center; float:left; padding:1px;margin-left:-1px;">
	<input type="checkbox" class="form_estilo" id="adendo" name="adendo" value="1" <?= ($emp->adendo) ? 'checked="checked"' : '' ?>/>
</div>
<input type="text" name="adendo_data" value="<?= ($emp->adendo_data != '') ? invert($emp->adendo_data, '/', 'PHP') : ''; ?>" 
style="width: 183px" onkeyup="masc_numeros(this,'##/##/####');"	class="form_estilo  <?= (isset($errors['adendo_data'])) ? 'form_estilo_erro' : ''; ?>" 
id="adendo_data"/>
<span id="obrig"><font color="#FF0000">*</font></span><br />

<label>Início de Contrato:</label>
<input type="text" name="inauguracao_data" value="<?= ($emp->inauguracao_data != '') ? invert($emp->inauguracao_data, '/', 'PHP') : ''; ?>" 
onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?= (isset($errors['inauguracao_data'])) ? 'form_estilo_erro' : ''; ?>" 
id="inauguracao_data" />

<label>Final de Contrato:</label>
<input type="text" name="validade_contrato" value="<?= ($emp->validade_contrato != '') ? invert($emp->validade_contrato, '/', 'PHP') : ''; ?>" 
style="width: 202px" onkeyup="masc_numeros(this,'##/##/####');" 
class="form_estilo  <?= (isset($errors['validade_contrato'])) ? 'form_estilo_erro' : ''; ?>" /><br />

<label>Pré-Contrato:</label>
<input type="text" name="precontrato" value="<?= ($emp->precontrato != '') ? invert($emp->precontrato, '/', 'PHP') : ''; ?>" 
onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?= (isset($errors['precontrato'])) ? 'form_estilo_erro' : ''; ?>" id="inauguracao_data"/>

<label>Aditivo de Royalty:</label>
<input type="text" name="aditivo" value="<?= ($emp->aditivo != '') ? invert($emp->aditivo, '/', 'PHP') : ''; ?>" 
style="width: 202px" onkeyup="masc_numeros(this,'##/##/####');" 
class="form_estilo  <?= (isset($errors['aditivo'])) ? 'form_estilo_erro' : ''; ?>"/><br />

<label>Exclusividade:</label>
<input type="text" name="exclusividade" value="<?= $emp->exclusividade; ?>" style="width: 150px" 
onkeyup="masc_numeros(this,'##');"	class="form_estilo  <?= (isset($errors['exclusividade'])) ? 'form_estilo_erro' : ''; ?>"/>(meses)<br />

<label>Notificação (Data,Motivo):</label>
<textarea name="notificacao" style="width:539px; height:100px" class="form_estilo"><?= $emp->notificacao; ?></textarea><br /><br />

<div class="frq_title">Informações Complementares</div>

<label>Liberação do Sistema:</label>
<input type="text" name="inicio" value="<?= ($emp->inicio != '') ? invert($emp->inicio, '/', 'PHP') : ''; ?>" 
style="width:150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo" <?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?> />
                               
<strong style="float:left; margin-right:8px">&nbsp;&nbsp;&nbsp;Royalties:</strong>
<input type="text" id="royalties" name="royalties"	value="<?=($emp->royalties == '') ? 0 : $emp->royalties ?>" style="width: 50px" 
onkeyup="moeda(event.keyCode,this.value,'royalties'); $('#royfixo').html(this.value); $('#royfixo2').html(this.value);" 
class="form_estilo <?= (isset($errors['royalties'])) ? 'form_estilo_erro' : ''; ?>" <?= ($readonly) ? 'readonly="readonly"' : ''; ?>
<?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?> />
<span style="float:left; margin-right:8px" >%</span>

<strong style="float:left; margin-right:8px">Deduzir Impostos de:</strong>
<input type="text" name="imposto" value="<?=($emp->imposto == '') ? 0 : $emp->imposto ?>" id="imposto" style="width: 50px" 
onkeyup="moeda(event.keyCode,this.value,'imposto');" class="form_estilo" <?= ($readonly) ? 'readonly="readonly"' : ''; ?>
<?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?> />
<span style="float:left">%</span><br />

<?if($controle_id_usuario == 1 && $controle_id_empresa == 1){?>
	<input type="hidden" name="sem1" id="sem1" value="<?= $emp->sem1 ?>" />
	<input type="hidden" name="sem2" id="sem2" value="<?= $emp->sem2 ?>" />
	<input type="hidden" name="sem3" id="sem3" value="<?= $emp->sem3 ?>" />
	<input type="hidden" name="roy_min"  id="roy_min" value="<?= $emp->roy_min ?>" />
	<input type="hidden" name="roy_min2"  id="roy_min2" value="<?= $emp->roy_min2 ?>" />
	<?/*
	<label>Royalties Fixo por Semestre:</label>
	1° Sem.<input type="text" name="sem1" id="sem1" onkeyup="moeda(event.keyCode,this.value,'sem1');" value="<?= $emp->sem1 ?>" style="width:50px" class="form_estilo" <?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?> />
	2° Sem.<input type="text" name="sem2" id="sem2" onkeyup="moeda(event.keyCode,this.value,'sem2');" value="<?= $emp->sem2 ?>" style="width:50px" class="form_estilo" <?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?> />
	3° Sem.<input type="text" name="sem3" id="sem3" onkeyup="moeda(event.keyCode,this.value,'sem3');" value="<?= $emp->sem3 ?>" style="width:50px" class="form_estilo" <?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?> />
	Após 3° Semestre <b><span id="royfixo"><?= $emp->royalties ?></span>%</b><br />

	<label>Royalties Fixo:</label>
	<input type="text" name="roy_min"  id="roy_min" onkeyup="moeda(event.keyCode,this.value,'roy_min');" 
	value="<?= $emp->roy_min ?>" style="width:50px" class="form_estilo" <?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?> />
	Após 4 meses
	<input type="text" name="roy_min2"  id="roy_min2" onkeyup="moeda(event.keyCode,this.value,'roy_min2');" 
	value="<?= $emp->roy_min2 ?>" style="width:50px" class="form_estilo" <?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?> />
	Ou <b><span id="royfixo2"><?= $emp->royalties ?></span>%</b> (o que for maior) <br /><br />*/
}?>

<?if($c->id_empresa > 0){?>
	<label>Royalties Fixo:</label><br />
	<? $roy = $royalties->listar_franquia($c->id_empresa);
	if(count($roy) > 0){
		foreach ($roy as $f){
			for($i = 1; $i <= $c->total_mes; $i++){
				$mes = 'mes_'.$i;
				$c->$mes = $f->$mes;
			}
		}
	}
	for($i = 1; $i <= $c->total_mes; $i++){
		for($j = 1; $j <= 4; $j++){ 
			if($i <= $c->total_mes){ 
				$mes = 'mes_'.$i;
				$valor = (isset($c->$mes)) ? $c->$mes : '0.00';?>
			<label style="font-weight:normal"><?=$i?>° Mês</label> <input type="text" name="mes_<?=$i?>" id="mes_<?=$i?>" 
				onkeyup="moeda(event.keyCode,this.value,this.id);" value="<?=$valor?>" style="width:50px; margin:0" class="form_estilo" <?=($permissao_admin == 'TRUE') ? '' : 'disabled="disabled"'?> />
		<? $i++; }
		} echo '<br />'; $i--;
	} 
}?>
<div style="text-align:center;width:100%">
	<?if($c->id_empresa > 0){?>
		<input style="float:none;margin:0" type="button" name="submit" value="Atualizar" class="button_busca" onclick="franquia_editar(1,<?=$c->id_empresa?>)" />
		<input style="float:none;margin:0" type="button" name="cancelar" value="Cancelar" onclick="javascript:history.go(-1);" class="button_busca" />
	<input style="float:none;margin:0" type="button" name="mensagens" value="Mensagens" onclick="location.href='empresa_msg.php?id_empresa=<?php echo $emp->id_empresa ?>'" class="button_busca" />
	<? } else {?>	
		<input style="float:none;margin:0" type="button" name="submit" value="Cadastrar" class="button_busca" onclick="franquia_editar(1,<?=$c->id_empresa?>)" />
		<input style="float:none;margin:0" type="button" name="cancelar" value="Cancelar" onclick="javascript:history.go(-1);" class="button_busca" />
	<? } ?>
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