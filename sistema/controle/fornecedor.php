<?php require('header.php'); ?>
<div id="topo"><?php
$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','busca');
pt_register('GET','submit');
pt_register('GET','pagina');
?>
<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />
Fornecedor</h1>
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
			value="<?= $busca ?>" size="30" /> <input type="submit" name="submit"
			class="button_busca" value="Buscar" /></div>
		</form>
		<div style="clear: both"><br />
		<a href="fornecedor_add.php">
		<h3><img src="../images/botao_add.png" border="0" /> Adicionar novo
		registro</h3>
		</a></div>
		<?php
		#if($submit!='') {

			$fornecedorDAO = new FornecedorDAO();
			$fornecedores = $fornecedorDAO->busca($busca,$controle_id_empresa,$pagina);
			$p_valor = "";
			?> <br />
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="9" class="barra_busca"><?php $fornecedorDAO->QTDPagina();?></td>
			</tr>
			<tr>
				<td class="result_menu"><b>Razão</b></td>
				<td class="result_menu"><b>Fantasia</b></td>
				<td align="center" width="40" class="result_menu"><b>Editar</b></td>
			</tr>

			<?
			foreach($fornecedores as $f){
				$p_valor .= '
		<tr>
		<td class="result_celula">'.$f->razao. '</a></td>
		<td class="result_celula">' . $f->fantasia. '</td>
		<td class="result_celula" align="center"><a href="fornecedor_edit.php?id=' .$f->id_fornecedor. '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
		</tr>';
			}
			echo $p_valor;
			?>
			<tr>
				<td colspan="9" class="barra_busca"><?php $fornecedorDAO->QTDPagina(); ?>
				</td>
			</tr>
			<?php #} ?>
		</table>
		</td>
	</tr>
</table>
</div>
			<?php
			require('footer.php');
			?>

