<?php require('header.php'); ?>
<div id="topo">
<?php
$permissao = verifica_permissao('Supervisor',$controle_id_departamento_p,$controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','busca');
pt_register('GET','id_departamento');
pt_register('GET','status');
pt_register('GET','pagina');
pt_register('GET','submit');


$departamentoDAO = new DepartamentoDAO();
$id_departamentos = explode(',',$controle_id_departamento_s);
if($perm_comp=='TRUE')
	$departamentos = $departamentoDAO->listar();
else
	$departamentos = $departamentoDAO->listar($id_departamentos);

?>
<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />Solicitações de compra</h1>
<a href="#" class="topo">topo</a>
<hr class="tit" />
</div>
<div id="meio">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<form name="buscador" action="" method="get"
			ENCTYPE="multipart/form-data">
		<div>
			<label style="width: 100px; font-weight: bold; padding-top: 5px; float: left; text-align:right">Buscar:</label> 
			<input type="text" class="form_estilo" name="busca" value="<?= $busca ?>" style="width:150px" />
		</div>
		<div>
			<label style="width: 100px; font-weight: bold; padding-top: 5px; float: left; text-align:right">Departamento:
			</label> 
			<select name="id_departamento" class="form_estilo" style="width:150px">
				<?
					if($perm_comp == 'TRUE'){
						echo '<option value=""></option>';
					}
					$p_valor ='';
					foreach($departamentos as $dep){
						$p_valor .= '<option value="'.$dep->id_departamento.'"';
						if($dep->id_departamento==$id_departamento) $p_valor .= ' selected="selected" ';
						$p_valor .= '>';
						$p_valor .= $dep->departamento.'</option>';
					} 
					echo $p_valor;
				?>
			</select>
		</div>
		
		<div>
			<label style="width: 100px; font-weight: bold; padding-top: 5px; float: left; text-align:right">Status:
			</label> 
			<select name="status" class="form_estilo" style="width:150px">
				<option value=""></option>
				<option <?php if($status=='Em Aberto')echo 'selected="selected"'?>>Em Aberto</option>
				<option <?php if($status=='Cotação')echo 'selected="selected"'?>>Iniciar Cotação</option>
				<option <?php if($status=='Concluída')echo 'selected="selected"'?>>Concluída</option>
			</select>
		</div>
		
		<input type="submit" name="submit" class="button_busca" value="Buscar" />
		</form>
		<div style="clear: both"><br />
		<a href="compra_add.php">
		<h3><img src="../images/botao_add.png" border="0" /> Adicionar novo registro</h3>
		</a></div>
		<?php
		if($submit=='Buscar') {
			$b->busca = $busca;
			if(in_array($id_departamento,$id_departamentos))
				$b->id_departamento=$id_departamento;
			else
				$b->id_departamento=$id_departamentos[0];	
			$b->status = $status;
			$compraDAO = new CompraDAO();
			$compras = $compraDAO->busca($b,$controle_id_empresa,$pagina);
			?> <br />
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="9" class="barra_busca"><?php $compraDAO->QTDPagina();?></td>
			</tr>
			<tr>
				<td align="center" width="40" class="result_menu"><b>Editar</b></td>
				<td class="result_menu"><b>Produto</b></td>
				<td class="result_menu"><b>Departamento</b></td>
				<td class="result_menu"><b>Solicitante</b></td>
				<td class="result_menu"><b>Status</b></td>
				<td class="result_menu" width="40"><b>Quantidade</b></td>
			</tr>

			<?
			$p_valor = "";
			foreach($compras as $c){
				$p_valor .= '<tr>
								<td class="result_celula" align="center"><a href="compra_edit.php?id_compra=' .$c->id_compra. '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
								<td class="result_celula">' . $c->produto . '</a></td>
								<td class="result_celula">' . $c->departamento. '</td>
								<td class="result_celula">' . $c->solicitante. '</td>
								<td class="result_celula">' . $c->status. '</td>
								<td class="result_celula" align="right">' . $c->quantidade. '</td>
							</tr>';
			}
			echo $p_valor;
			?>
			<tr>
				<td colspan="9" class="barra_busca"><?php $compraDAO->QTDPagina(); ?></td>
			</tr>
			<?php } ?>
		</table>
		</td>
	</tr>
</table>
</div>
			<?php
			require('footer.php');
			?>

