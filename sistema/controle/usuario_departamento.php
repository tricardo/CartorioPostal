<? require('header.php'); ?>
<div id="topo"><? 
$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

pt_register('GET','id');
$usuarioDAO = new UsuarioDAO();
$departamentoDAO = new DepartamentoDAO();
$u = $usuarioDAO->selectPorId($id);
if(($u->id_empresa != $controle_id_empresa && $controle_id_empresa!=1) || ($u->nome=='Monitoramento' && $controle_id_empresa!=1)){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$nome = $u->nome;
?>
<h1 class="tit"><img src="../images/tit/tit_usuario.png" alt="Título" />
Departamentos de <?= $nome ?></h1>
<hr class="tit" />
</div>
<div id="meio"><?
pt_register('POST','submit');
if ($submit and $_SESSION['controle_teste'] == '') {//check for errors
	$departamento_s = '';
	$departamento_p = '';
	pt_register('POST','id');
	$lista = $departamentoDAO->listarDptoUser($u->id_empresa);
	
	foreach($lista as $l){
		$cont_seg++;
		$id_departamento=$l->id_departamento;
		pt_register('POST','pertence_'.$id_departamento);
		pt_register('POST','supervisor_'.$id_departamento);
		if(${'pertence_'.$id_departamento}=='on'){ $departamento_p .= $id_departamento.','; }
		if(${'supervisor_'.$id_departamento}=='on'){ $departamento_s .= $id_departamento.','; }
	}

	$sql_update = "update vsites_user_usuario set departamento_p = '".$departamento_p."', departamento_s = '".$departamento_s."'  where id_usuario='$id'";
	$update = $objQuery->SQLQuery($sql_update);
	$u->departamento_p=$departamento_p;
	$u->departamento_s=$departamento_s;
		//alterado 01/04/2011
		$titulo = 'Mensagem da página web';
		$msg    = 'Registro editado com sucesso!';
		$pagina = '';
		$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
}


$departamento_p = explode(',',$u->departamento_p);
$departamento_s = explode(',',$u->departamento_s);
?>


<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" name="usuario_edit"
			method="post">
		<table width="650" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td class="result_menu"><b>Departamento</b></td>
				<td class="result_menu" align="center" width="80"><b>Pertence</b></td>
				<td class="result_menu" align="center" width="80"><b>Supervisor</b></td>
			</tr>
			<?
			$cont_seg=0;
			$cont_sub=0;
			$lista = $departamentoDAO->listarDptoUser($u->id_empresa);

			foreach($lista as $l){
				?>
			<tr>
				<td class="result_celula" nowrap><?= $l->departamento ?></td>
				<td class="result_celula" align="center" nowrap>
					<input	type="checkbox" name="pertence_<?= $l->id_departamento ?>"	id="pertence_<?= $l->id_departamento ?>"
					<? if(in_array($l->id_departamento, $departamento_p)) echo ' checked="checked"';  ?> />
				</td>
				<td class="result_celula" align="center" nowrap><input
					type="checkbox" name="supervisor_<?= $l->id_departamento ?>"
					<? if(in_array($l->id_departamento, $departamento_s)) echo ' checked="checked"';  ?>
					onclick="copia_permissao(this.checked,<?= $l->id_departamento ?>);" />
				</td>
			</tr>
			<? } ?>
			<tr>
				<td colspan="4">
				<div align="center">
					<input type="submit" name="submit" value=" Atualizar " class="button_busca" /> &nbsp; 
					<input type="submit" name="cancelar" value="Cancelar" onclick="document.usuario_edit.action='usuario.php'" class="button_busca" /> 
					<input type="hidden" name="id" value="<?= $id ?>" /></div>
				</td>
			</tr>
		</table>
		</form>
		</blockquote>
		</td>
	</tr>
</table>
</div>
<?php
	require('footer.php');
?>