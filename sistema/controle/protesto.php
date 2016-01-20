<?
require('header.php');
$permissao = verifica_permissao('Protesto',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

pt_register('GET','busca');
pt_register('GET','pagina');

$protestoDAO = new ProtestoDAO();
$protestos = $protestoDAO->busca($busca,$controle_id_empresa,$pagina);
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_protesto.png" alt="Título" />Protestos</h1>
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

		<a href="protesto_add.php">
		<h3><img src="../images/botao_add.png" border="0" /> Adicionar novo
		registro</h3>
		</a> <br />
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="9" class="barra_busca"><?
				$protestoDAO->QTDPagina();
				?></td>
			</tr>
			<tr>
				<td align="center" width="80" class="result_menu"><b>Cod. Protesto</b></td>
				<td align="left" class="result_menu"><b>Portador</b></td>
				<td align="center" width="80" class="result_menu"><b>Movimento</b></td>
				<td align="center" width="80" class="result_menu"><b>Devedores</b></td>
				<td align="center" width="80" class="result_menu"><b>Gerar</b></td>
				<td align="center" width="80" class="result_menu"><b>Editar</b></td>
			</tr>

			<?php
			$p_valor='';

			foreach($protestos as $protesto){
				$p_valor.='<tr><td class="result_celula">'.$protesto->id_protesto. '</a></td>';
				$p_valor.='<td class="result_celula" align="left">'.$protesto->portador.' -'.$protesto->portador_nome.'</a></td>';
				$p_valor.='<td class="result_celula" align="center">' . invert($protesto->data_movimento,'/','PHP') . '</a></td>';
				$p_valor.='<td class="result_celula" align="center"><a href="protesto_rem.php?id=' . $protesto->id_protesto . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>';
				$p_valor.='<td class="result_celula" align="center"><a href="gera_protesto_rem.php?id=' . $protesto->id_protesto . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>';
				$p_valor.='<td class="result_celula" align="center"><a href="protesto_edit.php?id=' . $protesto->id_protesto . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>';
				$p_valor.='</tr>';
			}
			echo $p_valor;
			?>
			<tr>
				<td colspan="9" class="barra_busca"><?
				$protestoDAO->QTDPagina();
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

