<?
require('header.php');
$permissao = verifica_permissao('Cartorio',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' and $controle_id_usuario!='22' and $controle_id_usuario!='184' ){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

pt_register('GET','busca_submit');
pt_register('GET','pagina');
$cartorioDAO = new CartorioDAO();

if($busca_submit<>''){
	pt_register('GET','cidade');
	pt_register('GET','estado');
	pt_register('GET','atribuicao');
	$_SESSION['cart_busca'] 		= $busca;
	$_SESSION['cart_estado'] 		= $estado;
	$_SESSION['cart_cidade'] 		= $cidade;
	$_SESSION['cart_atribuicao']	= $atribuicao;
} else {
	$estado = $_SESSION['cart_estado'];
	$cidade = $_SESSION['cart_cidade'];
	$atribuicao = $_SESSION['cart_atribuicao'];
}
$cartorios = $cartorioDAO->buscar($atribuicao,$estado,$cidade,$pagina);
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_cartorio.png" alt="Título" />Cartórios</h1>
<a href="#" class="topo">topo</a> <br />
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
		<div><label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Busca</label>

		<select name="atribuicao" class="form_estilo"
			style="width: 150px; float: left">
			<option value=""></option>
			<? $atribuicoes = $cartorioDAO->listaAtribuicoes();
			$p_valor='';
			foreach($atribuicoes as $atr){
				$p_valor.=  '<option value="'.$atr->id_atribuicao.'" ';
				$p_valor.=($atribuicao==$atr->id_atribuicao)?' selected="selected"':'';
				$p_valor.='>'.$atr->atribuicao.'</option>';
			}
			echo $p_valor;
			?>
		</select> <select name="estado" style="width: 50px"
			class="form_estilo"
			onchange="carrega_cartorio_cidade(this.value,atribuicao.value)">
			<option value=""></option>
			<?$estados = $cartorioDAO->listaEstados();
			$p_valor='';
			foreach($estados as $uf){
				$p_valor.='<option value="'.$uf->estado.'" ';
				$p_valor.=($estado==$uf->estado)?' selected ':'';
				$p_valor.= '>'.$uf->estado.'</option>';
			}
			echo $p_valor;
			?>
		</select> <select name="cidade" id="cartorio_cidade"
			style="width: 150px" class="form_estilo">
		</select> <script>
				carrega_cartorio_cidade('<?= $estado ?>','<?= $atribuicao ?>');
			</script> <input type="submit" name="busca_submit"
			class="button_busca" value=" Buscar " /></div>
		</form>
		<br />
		<?
		#permissao apenas para a Rosana e para a Mine
		if($controle_id_usuario=='22' or $controle_id_usuario=='184' or $controle_id_empresa=='1'){ ?>
		<a href="cartorio_add.php">
		<h3><img src="../images/botao_add.png" border="0" /> Adicionar novo registro</h3>
		</a> <br />
		<? } ?>
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="9" class="barra_busca"><? $cartorioDAO->QTDPagina(); ?>
				</td>
			</tr>
			<tr>
				<td class="result_menu"><b>Cart&oacute;rio</b></td>
				<td align="center" width="80" class="result_menu"><b>Atribuição</b></td>
				<td align="center" width="80" class="result_menu"><b>Comarca</b></td>
				<td align="center" width="80" class="result_menu"><b>Distrito</b></td>
				<td align="center" width="80" class="result_menu"><b>Cidade</b></td>
				<td align="center" width="80" class="result_menu"><b>Estado</b></td>
				<td align="center" width="80" class="result_menu"><b>Status</b></td>
				<td align="center" width="80" class="result_menu"><b>Editar</b></td>
				<!-- <td align="center" width="80" class="result_menu"><strong>Deletar</strong></td> -->
			</tr>
			<?php
			$p_valor='';
			foreach($cartorios as $c){
				$p_valor.= '<tr><td class="result_celula">' .$c->nome. '</a></td>';
				$p_valor.= '<td class="result_celula" align="center">' . $c->atrib . '</a></td>';
				$p_valor.= '<td class="result_celula" align="center">' . $c->comarca . '</a></td>';
				$p_valor.= '<td class="result_celula" align="center">' . $c->distrito . '</a></td>';
				$p_valor.= '<td class="result_celula" align="center">' . $c->cidade . '</a></td>';
				$p_valor.= '<td class="result_celula" align="center">' . $c->estado . '</a></td>';
				$p_valor.= '<td class="result_celula" align="center">' . $c->status . '</td>';
				$p_valor.= '<td class="result_celula" align="center"><a href="cartorio_edit.php?id=' . $c->id_cartorio . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>';
				$p_valor.= '</tr>';
			}
			echo $p_valor;
			?>
			<tr>
				<td colspan="9" class="barra_busca"><? $cartorioDAO->QTDPagina(); ?>
				</td>
			</tr>
		</table>

</table>
</div>
			<?php
			require('footer.php');
			?>

