<?
require('header.php');
$permissao = verifica_permissao('Conta',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>

<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_conta.png" alt="Título" />
Conta</h1>
<hr class="tit" />
</div>

<div id="meio"><?
pt_register('POST','submit');
if ($submit) {//check for errors
	$error="";
	pt_register('POST','id');
	$errors=array();
	$error="<b>Ocorreram os seguintes erros:</b><ul>";

	pt_register('POST','conta');
	pt_register('POST','agencia');
	pt_register('POST','status');
	pt_register('POST','id_banco');
	pt_register('POST','sigla');

	$con = new stdClass();
	$con->id_conta = $id;
	$con->conta = $conta;
	$con->agencia = $agencia;
	$con->status = $status;
	$con->sigla = $sigla;
	$con->id_banco = $id_banco;

	if($con->id_banco=='' || $con->conta=='' || $con->agencia=='' || $con->status=='' || $con->sigla==''){
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
		if($con->id_banco=='') $errors['id_banco']=1;
		if($con->conta=='') $errors['conta']=1;
		if($con->agencia=='') $errors['agencia']=1;
		if($con->status=='') $errors['status']=1;
		if($con->sigla=='') $errors['sigla']=1;
	}
	if (count($errors)==0) {
		$contaDAO = new ContaDAO();
		$contaDAO->atualizar($con);
		$done = 1;
	}
	?> <?if (count($errors)>0) { ?>
<div class="erro"><?=$error;?></div>
	<?}if ($done) { ?> <script type="text/javascript">
		alert('Registro atualizado com sucesso!');
		window.location = 'conta.php';
		</script> <? } ?> <?
}
if (!$done && !count($error)) {
	$contaDAO = new ContaDAO();
	$id				= $_GET["id"];
	$conta = $contaDAO->selectPorId($id,$controle_id_empresa);

}elseif(count($error)>0){
	$conta = $con;
}

$bancoDAO = new BancoDAO();
$bancos = $bancoDAO->listar();
?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" name="conta_edit"
			method="post">
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados da Conta</td>
			</tr>
			<tr>
				<td width="100">
				<div align="right"><strong>Status:</strong></div>
				</td>
				<td width="243"><select name="status" class="form_estilo"
					style="width: 150px">
					<option value="Ativo"
					<? if($conta->status=='Ativo') echo 'selected="selected"'; ?>>Ativo</option>
					<option value="Inativo"
					<? if($conta->status=='Inativo') echo 'selected="selected"'; ?>>Inativo</option>
					<option value="Cancelado"
					<? if($conta->status=='Cancelado') echo 'selected="selected"'; ?>>Cancelado</option>
				</select></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Banco: </strong></div>
				</td>
				<td colspan="3"><select name="id_banco"
					class="form_estilo <?=(isset($errors['id_banco']))?'form_estilo_erro':''; ?>">
					<option></option>
					<?php foreach($bancos as $banco){ ?>
					<option value="<?=$banco->id_banco;?>"
					<?=($conta->id_banco==$banco->id_banco)?'selected="selected"':''?>>
						<?=$banco->banco; ?></option>
					<?php }?>
				</select> <font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Sigla:</strong></div>
				</td>
				<td colspan="3"><input type="text" name="sigla" readonly
					value="<?=$conta->sigla?>" style="width: 150px"
					class="form_estilo_r <?=($errors['sigla'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Agência: </strong></div>
				</td>
				<td><input type="text" name="agencia" value="<?=$conta->agencia ?>"
					style="width: 150px"
					class="form_estilo <?=($errors['agencia'])?'form_estilo_erro':''; ?>">
				<font color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>Conta: </strong></div>
				</td>
				<td width="219"><input type="text" name="conta"
					value="<?=$conta->conta ?>" style="width: 150px"
					class="form_estilo <?=($errors['conta'])?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="hidden" name="id"
					value="<?=$conta->id_conta ?>" /> <input type="submit"
					name="submit" value="Atualizar" class="button_busca" />&nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.conta_edit.action='conta.php'"
					class="button_busca" /></div>
				</td>
			</tr>
		</table>
		</form>
		</blockquote>
		</td>
	</tr>
</table>
</div>
						<?php require('footer.php'); ?>