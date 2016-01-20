<?
if($controle_id_usuario==""){
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );
	pt_register('GET','id_pedido_item');
	$departamento_s = explode(',' ,$controle_id_departamento_s);
	$departamento_p = explode(',' ,$controle_id_departamento_p);
	$pedidoDAO = new PedidoDAO();
	$cartorioDAO = new CartorioDAO();
}
$a = $pedidoDAO->buscaPorId($id_pedido_item,$controle_id_empresa);
?>
	<form action="#aba4" method="post" name="p_cartorio" id="p_cartorio" enctype="multipart/form-data">
		<input type="hidden" name="p_cartorio" value="1">
		<table width="800" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Novo Cartório</td>
			</tr>
			<tr>
				<td width="150">
					<div align="right"><strong>Atribuição: </strong></div>
				</td>
				<td colspan="3">
					<select name="cartorio_atribuicao" style="width: 150px" onchange="carrega_cartorio_cidade(cartorio_estado.value,this.value); carrega_cartorio_cartorio('','','');" class="form_estilo">
						<?
							$p_valor = "";
							$ca = $cartorioDAO->listaAtribuicoes();
							foreach($ca as $c){
								$p_valor .= '<option value="'.$c->id_atribuicao.'" >'.$c->atribuicao.'</option>';
							}
							echo $p_valor;
						?>
					</select> 
					<strong>Estado: </strong> 
					<select name="cartorio_estado" style="width:150px" class="form_estilo" onchange="carrega_cartorio_cidade(this.value,cartorio_atribuicao.value); carrega_cartorio_cartorio('','','');">
						<option value=""></option>
						<?
							$p_valor = "";
							$ca = $cartorioDAO->listaEstados();
							foreach($ca as $c){
								$p_valor .= '<option value="'.$c->estado.'" ';
								if($c->estado==$a->certidao_estado) $p_valor .= ' selected="selected" ';
								$p_valor .= '>'.$c->estado.'</option>';
							}
							echo $p_valor;
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="150">
					<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td colspan="3">
					<select name="cartorio_cidade" id="cartorio_cidade" style="width: 500px" class="form_estilo" onchange="carrega_cartorio_cartorio(cartorio_estado.value,cartorio_atribuicao.value,this.value)">
					</select> <font color="#FF0000">*</font>
				</td>
			</tr>
			<tr>
				<td width="150">
				<div align="right"><strong>Cartório: </strong></div>
				</td>
				<td colspan="3"><select name="cartorio_cartorio" id="cartorio_cartorio" style="width: 500px" class="form_estilo<? if($errors['cartorio']<>'') echo '_erro' ?>">
				</select> <font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit_cartorio"
					value=" Cadastro " class="button_busca" />&nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.pedido_add.action='pedido.php'"
					class="button_busca" />&nbsp; <input type="button"
					class="button_busca" name="submit_cartorio_ver" value="Ver"
					onclick="carrega_cartorio(cartorio_cartorio.value); $('#windowMensagem').show();" />

				</div>
				</td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Cartórios Selecionados</td>
			</tr>
			<tr>
				<td colspan="4">
				<?
				$p_valor = '<div class="form_estilo_r" style="width:110px; font-weight:bold; float:left">Atribuição</div>
				<div class="form_estilo_r" style="width:30px; font-weight:bold; float:left">UF</div>
				<div class="form_estilo_r" style="width:110px; font-weight:bold; float:left">Cidade</div>
				<div class="form_estilo_r" style="width:250px; font-weight:bold; float:left">Cartório</div>
				<div class="form_estilo_r" style="width:100px; font-weight:bold; float:left">Desconsiderar?</div>
				<div class="form_estilo_r" style="width:160px; font-weight:bold; float:left">Ação</div>';

				$sql = $objQuery->SQLQuery("SELECT pc.*, ca.atribuicao, c.nome from
			vsites_pedido_cartorio as pc, vsites_cartorio_atribuicoes as ca, vsites_cartorio as c where 
			pc.id_pedido_item='".$id_pedido_item."' and			
			pc.cartorio_atribuicao = ca.id_atribuicao and
			pc.cartorio_cartorio = c.id_cartorio
			order by id_pedido_cartorio desc");
				while($res = mysql_fetch_array($sql)){
					$p_valor .= '
                <div class="form_estilo_r" style="width:110px; font-weight:bold; float:left">'.$res['atribuicao'].'</div>
				<div class="form_estilo_r" style="width:30px; font-weight:bold; float:left">'.$res['cartorio_estado'].'</div>
				<div class="form_estilo_r" style="width:110px; font-weight:bold; float:left">'.$res['cartorio_cidade'].'</div>
				<div class="form_estilo_r" style="width:250px; font-weight:bold; float:left">'.$res['nome'].'</div>
				<div class="form_estilo_r" style="width:100px; font-weight:bold; float:left">'.$res['desconsiderar'].'</div>
                <div style="width:160px; height:22px; float:left">
					<input type="button" class="button_busca" name="submit_cartorio_ver" style="width:50px" value="Ver" onclick="carrega_pedido_cartorio(\''. $res['id_pedido_cartorio'] .'\'); $(\'#windowMensagem\').show();" />
					<input type="submit" class="button_busca" name="submit_cartorio_deleta" value="Desconsiderar '.$res['id_pedido_cartorio'].'" />
				</div>';
				}
				echo $p_valor;
				?></td>
			</tr>
		</table>
		<script>
			carrega_cartorio_cidade(document.p_cartorio.cartorio_estado.value,document.p_cartorio.cartorio_atribuicao.value);
		</script>
	</form>