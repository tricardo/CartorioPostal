<?
require('header.php');

$permissao = verifica_permissao('Conta',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','busca');
pt_register('GET','pagina');
$contaDAO = new ContaDAO();
$contas = $contaDAO->listar($controle_id_empresa, $busca, $pagina);

?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_conta.png" alt="Título" />
Contas</h1>
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
			class="button_busca" value=" Buscar " /></div>
		</form>
		<br />

		<a href="conta_add.php">
		<h3><img src="../images/botao_add.png" border="0" /> Adicionar novo
		registro</h3>
		</a> <br />
		<table cellpadding="4" cellspacing="1" class="result_tabela">
			<tr>
				<td class="result_menu"><b>Nome</b></td>
				<td class="result_menu"><b>Sigla</b></td>
				<td align="center" width="80" class="result_menu"><b>Agência</b></td>
				<td align="center" class="result_menu"><b>Conta</b></td>
				<td align="center" class="result_menu" width="80"><b>Status</b></td>
				<td align="center" width="80" class="result_menu"><b>Editar</b></td>
			</tr>

			<?php
			foreach($contas as $conta){  ?>
			<tr>
				<td class="result_celula"><?=$conta->banco ?></td>
				<td class="result_celula"><?=$conta->sigla ?></td>
				<td class="result_celula"><?=$conta->agencia?></td>
				<td class="result_celula"><?=$conta->conta?></td>
				<td class="result_celula"><?=$conta->status?></td>
				<td class="result_celula" align="center"><a
					href="conta_edit.php?id=<?=$conta->id_conta; ?>"><img
					src="../images/botao_editar.png" title="Editar" border="0" /></a></td>
					<?php } ?>
				<tr>
					<td colspan="9" class="barra_busca"><?
					$contaDAO->QTDPagina();
					?></td>
				</tr>
		
		</table>
		</td>
	</tr>
</table>
</div>
					<?php
					require('footer.php');
					?>