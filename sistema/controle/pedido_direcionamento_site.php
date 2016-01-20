<? require('header.php');?>
<div id="topo"><?
$permissao = verifica_permissao('Direcionamento_site',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$usuarioDAO = new UsuarioDAO();
$afiliadoDAO = new AfiliadoDAO();
$pedidoDAO = new PedidoDAO();

$onde='';
pt_register('GET','busca_id_pedido');
pt_register('GET','busca_ordem');
$busca = new stdClass();
$busca->id_pedido = $busca_id_pedido;
$busca->id_pedido = $busca_ordem;

$buscaObj = new stdClass();
$buscaObj->busca_ordenar = $busca;
$buscaObj->busca_ord = $busca_ord;
$buscaObj->busca_id_pedido = $busca_id_pedido;
$buscaObj->busca_ordem = $busca_ordem;
$buscaObj->id_empresa = $controle_id_empresa;

$afi = $afiliadoDAO->listarTodos();
foreach($afi as $l){
	$afiliado[$l->id_afiliado]=$l->nome;
}
pt_register('POST','submit');
pt_register('POST','submit_franquia');
pt_register('POST','submit_duplicidade');
pt_register('POST','id_pedido_itens');

$errors=0;
$error="<b>Ocorreram os seguintes erros:</b><ul>";
if(!is_array($id_pedido_itens) || count($id_pedido_itens)==0){
    $error.='<li>Selecione pelo menos uma ordem.</li>';
    $errors++;
}
	
if ($submit) {//check for errors
	$sub=true;
	pt_register('POST','id_usuario');
    if($id_usuario==''){
    	$error.='<li>Selecione um usuário.</li>';
    	$errors++;
    }
    if($errors==0){
	    foreach($id_pedido_itens as $id_pedido_item){
	    	$pedidoDAO->direcionaSite($id_pedido_item, $id_usuario, $controle_id_usuario);
	    }
    }
}
else if ($submit_franquia) {//check for errors
	$sub=true;
	pt_register('POST','id_usuario_franquia');
    if($id_usuario_franquia==''){
    	$error.='<li>Selecione uma franquia.</li>';
    	$errors++;
    }
    if($errors==0){
	    foreach($id_pedido_itens as $id_pedido_item){
	    	try{
		    	$pedidoDAO->verificaDirecionaSiteFranquia($controle_id_empresa,$id_pedido_item);
				
		    	$pedidoDAO->direcionaSite($id_pedido_item, $id_usuario_franquia, null, true);
	    		die('Pedido transferido com sucesso!<br>');
	    	} catch(Exception $e){
	    		echo '<div class="erro"><b>Esse pedido não pode ser transferido<br>'.$e->getMessage().'</b></div>';
	    		die();
	    	}
	    }
    }
}
else if ($submit_duplicidade) {//check for errors
	$sub=true;
	if($errors==0){
		foreach($id_pedido_itens as $id_pedido_item){
			$pedidoDAO->duplicidadeSite($controle_id_usuario,$id_pedido_item);
		}
	}
}
$error.='</ul>';
?>
<h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" />
Direcionamento de Ordens</h1>
<hr class="tit" />
<br />
</div>
<div id="meio">
<?php 
if($errors>0 && $sub){
	echo '<div class="erro"><b>'.$error.'</b></div>';
}
?>
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<form name="buscador" action="" method="get"
			ENCTYPE="multipart/form-data">
		<div style="float: left"><img src="../images/lupa.png" alt="busca" />
		</div>

		<div style="float: left; width: 420px; text-align: right">
		<div
			style="text-align: left; width: 420px; font-weight: bold; padding-top: 5px; float: left; clear: both">Caso
		queira redirecionar uma ordem, realize a busca</div>
		<label
			style="width: 70px; font-weight: bold; padding-top: 5px; float: left;">Ordem:
		</label> <input type="text" name="busca_id_pedido"
			value="<?= $busca_id_pedido ?>" style="width: 90px; float: left"
			class="form_estilo" />  <input type="submit" name="busca_submit"
			class="button_busca" value=" Buscar " /></div>

		</form>

		<form name="f1" action="pedido_direcionamento_site.php" method="post" ENCTYPE="multipart/form-data" style="clear: both"><br />
		<label style="width: 130px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Direcionar para: </label>
			<select name="id_usuario" style="width: 200px" class="form_estilo">
			<option value=""></option>
			<?php	$p_valor='';
			$usuarios = $usuarioDAO->listarAtivos($controle_id_empresa);
			foreach($usuarios as $u){
				$departamento_p = explode(',',$u->departamento_p);
				foreach($departamento_p as $dep){
					if(in_array($dep,$departamento_s) and $dep<>''){
						$p_valor .= '<option value="'.$u->id_usuario.'"';
						if($id_usuario==$u->id_usuario) $p_valor .= ' selected="selected" ';
						$p_valor .= ' >'.$u->nome.'</option>';
						break;
					}
				}
			}
			echo $p_valor;
			?>
		</select> <input type="submit" name="submit" class="button_busca"
			value=" Direcionar Para Funcionário" />
		<? if($controle_id_empresa=='1'){ ?>
			<select name="id_usuario_franquia" style="width: 200px" class="form_estilo">
			<option value=""></option>
			<?php
			$p_valor='';
			$empresaDAO = new EmpresaDAO();
			$empresas = $empresaDAO->listarAtendenteEmpresa($controle_id_empresa);
			#$dir = explode('/', $_SERVER['SCRIPT_FILENAME']);
			include('/home/cartorio/public_html/certidoes/model/roylties-a-pagar.php');
			foreach($empresas as $emp){
				if($controle_id_empresa != 1){
					if(!in_array($emp->id_empresa, $arr)){
						$p_valor .= '<option value="'.$emp->id_usuario.'"';
						if($id_usuario_franquia==$emp->id_usuario) $p_valor .= ' selected="selected" ';
						$p_valor .= ' >'.$emp->fantasia.'</option>';
					}
				} else {
					$p_valor .= '<option value="'.$emp->id_usuario.'"';
						if($id_usuario_franquia==$emp->id_usuario) $p_valor .= ' selected="selected" ';
						$p_valor .= ' >'.$emp->fantasia.'</option>';
				}
			}
			echo $p_valor;
			?>
			</select>
			<input type="submit" name="submit_franquia" class="button_busca" value=" Franquia " /> 
		<? } ?> <br>
		<br />
		<div style="clear: both; padding: 5px"><input type="submit"
			name="submit_duplicidade" class="button_busca" value=" Duplicidade " />
		</div>
		<?php 
		$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
		$pedidos = $pedidoDAO->buscaDirecionamentoSite($buscaObj,$pagina);
		$p_valor='';
		$hoje = date('Y-m-d H:i:s');

		?>
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="18" class="barra_busca"><?php $pedidoDAO->QTDPagina(); ?>
				</td>
			</tr>
			<tr>
				<td align="center" width="20" class="result_menu"><input type="checkbox" name="todos" onclick="if(this.checked==1) selecionar_tudo(); else deselecionar_tudo()"></td>
				<td align="center" width="80" class="result_menu"><b>Ordem</b></td>
				<td class="result_menu"><b>Data</b></td>
				<td class="result_menu"><b>Solicitante</b></td>
				<td class="result_menu"><b>Região</b></td>
				<td class="result_menu"><b>Documento de</b></td>
				<td class="result_menu"><b>E-mail</b></td>
				<td class="result_menu"><b>Serviço</b></td>
				<td class="result_menu"><b>Cidade</b></td>
				<td class="result_menu" width="40"><b>Estado</b></td>
				<td align="center" width="80" class="result_menu"><b>Atendente</b></td>
				<td align="center" width="80" class="result_menu"><b>Afiliado</b></td>
			</tr>

			<?php
			foreach($pedidos as $p){
				$id_pedido_item  = $res["id_pedido_item"];
				$id_afiliado  	= $res["id_afiliado"];

				$p_valor .= '
					<tr><td class="result_celula" align="center">
					<input type="checkbox" name="id_pedido_itens[]" value="' .$p->id_pedido_item . '">
			        </td>
					<td class="result_celula" align="center">#' . $p->id_pedido . '/'.$p->ordem.'</a></td>
					<td class="result_celula">' . invert($p->data,'/','PHP').'</td>
					<td class="result_celula">' . $p->cpf.' - '.$p->nome.'</td>
					<td class="result_celula">'.$p->cidade.'-'.$p->estado.'</td>
					<td class="result_celula">' . $p->certidao_nome.'</td>
					<td class="result_celula">' . $p->email . '</td>
					<td class="result_celula">' . $p->desc_servico . '</td>
					<td class="result_celula">' . $p->certidao_cidade .'</td>
					<td class="result_celula">' . $p->certidao_estado.'</td>
					<td class="result_celula" align="center">' . $p->atendente . '</td>
					<td class="result_celula" align="center">' . $afiliado[$p->id_afiliado] . '</td>
					</tr>';
			}
			echo $p_valor;
			?>
			<tr>
				<td colspan="18" class="barra_busca"><?php $pedidoDAO->QTDPagina(); ?>
				</td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>
</div>
<?php
	require('footer.php');
?>
