<? require('header.php'); ?>
<div id="topo"><?php 
$permissao = verifica_permissao('Pontos de Vendas',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','busca');
pt_register('GET','id_empresa');
pt_register('GET','pagina');

$pontosDeVendasDAO = new PontosDeVendasDAO();
$pontosDeVendas = $pontosDeVendasDAO->busca($controle_id_empresa,$busca,$pagina);
?>
<h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" />
Pontos de Vendas</h1>
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
			class="button_busca" value=" Buscar " /></div>
		</form>
		<br />

		<a href="pontosdevendas_add.php">
		<h3><img src="../images/botao_add.png" border="0" /> Adicionar novo
		registro</h3>
		</a> <br />
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="9" class="barra_busca"><? $pontosDeVendasDAO->QTDPagina(); ?>
				</td>
			</tr>
			<tr>
				<td class="result_menu"><b>Código</b></td>
				<td class="result_menu"><b>Respons&aacute;vel</b></td>
				<td class="result_menu"><b>Empresa</b></td>
				<td align="center" width="80" class="result_menu"><b>Status</b></td>
				<td align="center" width="80" class="result_menu"><b>Editar</b></td>
				<!-- <td align="center" width="80" class="result_menu"><strong>Deletar</strong></td> -->
			</tr>
			<?php
			$v_valor = '';
			foreach($pontosDeVendas as $pDeVenda){
				$v_valor .= '<tr><td class="result_celula">'.$pDeVenda->id_ponto.'</a></td>';
				$v_valor .= '<td class="result_celula">'.$pDeVenda->nome.'</a></td>';
				$v_valor .= '<td class="result_celula">'.$pDeVenda->empresa.'</td>';
				$v_valor .= '<td class="result_celula" align="center">'.$pDeVenda->status.'</td>';
				$v_valor .= '<td class="result_celula" align="center"><a href="pontosdevendas_edit.php?id='.$pDeVenda->id_ponto. '">
		<img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>';
				$v_valor .= '</tr>';
			}
			echo $v_valor;
			?>
			<tr>
				<td colspan="9" class="barra_busca"><? $pontosDeVendasDAO->QTDPagina(); ?>
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

