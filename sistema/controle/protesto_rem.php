<?
require('header.php');
$permissao = verifica_permissao('Protesto',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','id');
pt_register('GET','busca');
pt_register('GET','estado');
$protestoDAO = new ProtestoDAO();
$devedores = $protestoDAO->buscaDevedores($busca,$id,$controle_id_empresa,$pagina);
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_protesto.png" alt="Título" />Protestos
(Devedores)</h1>
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
			value="<?= $busca ?>" size="30" /> <input type="hidden" name="id"
			value="<?= $id ?>" /> <input type="submit" name="submit"
			class="button_busca" value=" Buscar " /> <input type="submit"
			name="limpar" class="button_busca" onclick="busca.value='';"
			value=" Mostrar Todos " /></div>
		</form>
		<br />

		<a href="protesto_rem_add.php?id=<?= $id ?>">
		<h3><img src="../images/botao_add.png" border="0" /> Adicionar novo
		registro</h3>
		</a> <br />
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="9" class="barra_busca"><? $protestoDAO->QTDPagina(); ?>
				</td>
			</tr>
			<tr>
				<td align="center" width="80" class="result_menu"><b>Cod. Protesto</b></td>
				<td align="center" width="80" class="result_menu"><b>Sequência</b></td>
				<td align="left" class="result_menu"><b>Devedor</b></td>
				<td align="center" width="80" class="result_menu"><b>Editar</b></td>
			</tr>
			<?php
			$p_valor='';
			foreach($devedores as $devedor){
				$cont++;
				$p_valor.= '<tr><td class="result_celula">' . $id . '</a></td>';
				$p_valor.= '<td class="result_celula" align="center">' . $cont .'</a></td>';
				$p_valor.= '<td class="result_celula" align="left">' . $devedor->dev_nome . '</a></td>';
				$p_valor.= '<td class="result_celula" align="center"><a href="protesto_rem_edit.php?id=' . $devedor->id_protesto_rem . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>';
				$p_valor.= '</tr>';
			}
			echo $p_valor;
			?>
			<tr>
				<td colspan="9" class="barra_busca"><? $protestoDAO->QTDPagina(); ?>
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

