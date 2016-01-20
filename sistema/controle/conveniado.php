<?
require('header.php');
$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','busca_submit');
pt_register('GET','pagina');

if($busca_submit<>''){
	pt_register('GET','id_cliente');
	pt_register('GET','busca');
	$_SESSION['conv_id_cliente'] 	= $id_cliente;
	$_SESSION['conv_busca'] 		= $busca;
} else {
	$id_cliente = $_SESSION['conv_id_cliente'];
	$busca 		= $_SESSION['conv_busca'];
}
$conveniadoDAO = new ConveniadoDAO();
$clienteDAO = new ClienteDAO();
$conveniados = $conveniadoDAO->busca($busca,$controle_id_empresa,$id_cliente,$pagina);
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_conveniado.png" alt="Título" />
Conveniados</h1>
<a href="#" class="topo">topo</a> <br />
<hr class="tit" />
</div>
<div id="meio">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">

		<form name="buscador" action="" method="get" ENCTYPE="multipart/form-data">
		<div style="float: left"><img src="../images/lupa.png" alt="busca" />
		</div>

		<label style="width: 50px; font-weight: bold; text-align: right; padding-top: 5px; float: left">Busca:</label>
		<input type="text" class="form_estilo" name="busca"
			value="<?= $busca ?>" style="width: 200px; float: left" /> <select
			name="id_cliente" style="width: 300px; float: left"
			class="form_estilo">
			<option value=""></option>
			<?
			$clientes = $clienteDAO->listarPorEmpresa($controle_id_empresa);
			foreach($clientes as $c){
				echo '<option value="'.$c->id_cliente.'"';
				if($id_cliente==$c->id_cliente) echo ' selected="selected" ';
				echo ' >'.$c->nome.'</option>';
			}
			?>
		</select> <input type="submit" name="busca_submit"
			class="button_busca" value=" Buscar " /></form>
		<br />

		<a href="conveniado_add.php?id_cliente=<?php echo $id_cliente?>">
		<h3><img src="../images/botao_add.png" border="0" /> Adicionar novo
		registro</h3>
		</a> <br />
		<table cellpadding="4" cellspacing="1" class="result_tabela">
			<tr>
				<td colspan="9" class="barra_busca">
				<?$conveniadoDAO->QTDPagina();?>
				</td>
			</tr>
			<tr>
				<td class="result_menu"><b>Cliente</b></td>
				<td class="result_menu"><b>Nome</b></td>
				<td align="center" width="80" class="result_menu"><b>Status</b></td>
				<td align="center" width="80" class="result_menu"><b>Editar</b></td>
				<td align="center" width="80" class="result_menu"><b>Enviar Senha</b></td>
			</tr>

			<?php 
			foreach($conveniados as $c){
				$conveniado = 'Sim';
				$id_cliente = $c->id_cliente;

				echo '<tr><td class="result_celula">' . $c->empresa . '</a></td>';
				echo '<td class="result_celula">' . $c->nome . '</a></td>';
				echo '<td class="result_celula" align="center">' . $c->status . '</a></td>';
				echo '<td class="result_celula" align="center"><a href="conveniado_edit.php?id=' . $c->id_conveniado . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>';
				echo '<td class="result_celula" align="center" nowrap><a href="envia_senha_conveniado.php?id='.$c->id_conveniado.'"><img src="../images/botao_enviasenha.png" title="Enviar Senha" border="0"/></a></td>';
				echo '</tr>';
			}

			?>
			<tr>
				<td colspan="9" class="barra_busca">
			<?$conveniadoDAO->QTDPagina();?>
			</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>
		<?php
		require('footer.php');
		?>