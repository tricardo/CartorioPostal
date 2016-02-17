<?
require('header.php');
$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$empresaDAO = new EmpresaDAO();
$departamentoDAO = new DepartamentoDAO();
pt_register('GET','busca');
pt_register('GET','id_empresa');
pt_register('GET','id_departamento');
pt_register('GET','pagina');

$id_empresa = ($controle_id_empresa==1)?$id_empresa:$controle_id_empresa;

$usuarioDAO = new UsuarioDAO();
$usuarios = $usuarioDAO->busca($id_empresa,$busca,$pagina,$id_departamento,($controle_id_empresa==1));
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_usuario.png" alt="Título" />
Usuários</h1>
<a href="#" class="topo">topo</a>
<hr class="tit" />
</div>
<div id="meio">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">

		<form name="buscador" action="" method="get"
			ENCTYPE="multipart/form-data">
		<div style="float: left"><img src="../images/lupa.png" alt="busca" />
		</div>
		<div><input type="text" class="form_estilo" name="busca"
			value="<?= $busca ?>" size="30" /> <? if($controle_id_empresa==1){ ?>
		<select name="id_empresa" style="width: 470px" class="form_estilo">
			<option value=""
			<? if($id_empresa=='') echo 'selected="selected"'; ?>></option>
			<? $empresas = $empresaDAO->listarTodas();
			$p_valor = '';
			foreach($empresas as $emp){
				$p_valor .= '<option value="'.$emp->id_empresa.'" ';
				$p_valor .= ($id_empresa==$emp->id_empresa)?' selected="selected"':'';
				$p_valor .= '>'.str_ireplace('Cartório Postal - ','',$emp->fantasia).'</option>';
			}
			echo $p_valor;
			}?>
		</select> <select name="id_departamento" class="form_estilo">
			<option value=""></option>
			<? $departamentos = $departamentoDAO->listar();
			$p_valor = '';
			foreach($departamentos as $dep){
				$p_valor .= '<option value="'.$dep->id_departamento.'" ';
				$p_valor .= ($id_departamento==$dep->id_departamento)?' selected="selected"':'';
				$p_valor .= '>'.$dep->departamento.'</option>';
			}
			echo $p_valor;
			?>
		</select> <input type="submit" name="submit" class="button_busca"
			value=" Buscar " /></div>
		</form>
		<br />
		<? if($controle_id_empresa==1){ ?> <a href="usuario_add.php">
		<h3><img src="../images/botao_add.png" border="0" /> Adicionar novo
		registro</h3>
		</a> <? } ?> <br />
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="9" class="barra_busca"><? $usuarioDAO->QTDPagina(); ?>
				</td>
			</tr>
			<tr>
				<td class="result_menu"><b>Nome - Email</b></td>
				<td class="result_menu"><b>Empresa</b></td>
				<td align="center" width="80" class="result_menu"><b>Status</b></td>
				<td align="center" width="80" class="result_menu"><b>Departamentos</b></td>
				<td align="center" width="80" class="result_menu"><b>Editar</b></td>
				<td align="center" width="80" class="result_menu"><b>Enviar Senha</b></td>
                <td align="center" width="80" class="result_menu"><b>Excluir</b></td>
			</tr>

			<?php
			$p_valor = '';
			foreach($usuarios as $usuario){
				echo  '
	<tr><td class="result_celula">'.$usuario->nome.' - '.$usuario->email.'</a></td>
	<td class="result_celula">' .str_replace('Cartório Postal - ','',$usuario->fantasia).'</td>
	<td class="result_celula" align="center" nowrap>' .$usuario->status.'</td>
	<td class="result_celula" align="center" nowrap><a href="usuario_departamento.php?id='.$usuario->id_usuario.'"><img src="../images/botao_editar.png" title="Editar Departamento" border="0"/></a></td>
	<td class="result_celula" align="center"><a href="usuario_edit.php?id='.$usuario->id_usuario.'"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
	<td class="result_celula" align="center" nowrap><a href="envia_senha_usuario.php?id='.$usuario->id_usuario.'"><img src="../images/botao_enviasenha.png" title="Enviar Senha" border="0"/></a></td>
	<td class="result_celula" align="center" nowrap><a href="usuario_delete.php?id='.$usuario->id_usuario.'" onclick="return confirm(\'Deseja excluir o registro?\')"><img src="../images/botao_delete.png" title="Excluir" border="0"/></a></td>
	</tr>';
			}
			echo $p_valor;
			?>
			<tr>
				<td colspan="9" class="barra_busca"><? $usuarioDAO->QTDPagina(); ?>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>
			<?php require('footer.php');?>