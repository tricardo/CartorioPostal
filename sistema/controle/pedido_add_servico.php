<? require('header.php');
$permissao = verifica_permissao('Pedido Add',$controle_id_departamento_p,$controle_id_departamento_s);
?>
<div id="topo"><?
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','id');
pt_register('GET','ordem');
$id_pedido=$id;


if($ordem=='') $ordem='1';
$pedidoDAO = new PedidoDAO();
$servicosDAO = new ServicoDAO();
?>
<h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" />
Pedido #<?= $id_pedido ?>&nbsp;&nbsp;&nbsp; <a href="pedido.php"> Buscar Pedidos</a></h1>
<hr class="tit" />
<br />
</div>
<div id="meio"><?
$p = $pedidoDAO->selectPorId($id_pedido,$ordem,$controle_id_empresa);

if($p->id_pedido_item==''){
	echo 'Você não tem permissão de alterar essa ordem';
	exit;
}

pt_register('POST','submit_servico');
if ($submit_servico) {
	$errors=array();
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','obs');
	pt_register('POST','urgente');
	pt_register('POST','id_servico');
	pt_register('POST','id_servico_var');
	pt_register('POST','valor');
	pt_register('POST','dias');
	pt_register('POST','cpf');
	pt_register('POST','controle_cliente');
	pt_register('POST','id_servico_departamento');

	$p->cpf=$cpf;
	$p->id_usuario=$controle_id_usuario;
	$p->id_empresa_atend=$controle_id_empresa;
	$p->urgente=$urgente;
	$p->controle_cliente=$controle_cliente;
	$p->id_servico=$id_servico;
	$p->id_servico_departamento=$id_servico_departamento;
	$p->id_servico_var=$id_servico_var;
	$p->valor=$valor;
	$p->dias=$dias;
	$p->obs=$obs;

	$servicocampos = $servicosDAO->listaCampos($id_servico);
	foreach($servicocampos as $servicocampo){
		pt_register('POST',$servicocampo->campo);
		$p->{$servicocampo->campo}=${$servicocampo->campo};
	}

	if($dias=="" || $id_servico=="" || $id_servico_var==""  || $id_servico_var=="0" || $id_servico_departamento==""){
		if($dias=="")      										$errors['dias']=1;
		if($id_servico=="")      								$errors['id_servico']=1;
		if($id_servico_var=="")      							$errors['id_servico_var']=1;
		if($id_servico_var=="0")      							$errors['id_servico_var']=1;
		if($id_servico_departamento=="")      					$errors['id_servico_departamento']=1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}

	if($valor=="" or $valor=="0"){
		$errors['valor']=1;
		$error.="<li><b>O campo \"valor\" precisa ser preenchido.</b></li>";
	}
	
	if(isset($certidao_estado)){
		$servicover = new ServicoVerificaDAO();
		$srv = $servicover->verUFCid(1, $id_servico, $certidao_cidade, $certidao_estado);
		if(strlen($srv[2]) + strlen($srv[3]) > 0){
			$errors['certidao_estado'] = $srv[0]; $errors['certidao_cidade'] = $srv[1];
			$error.=$srv[2].$srv[3];
		}
	}

	#verifica servico
	$res_servico = $servicosDAO->verificaServicoVar($id_servico_var);
	if ($res_servico->total=='0'){
		$error .= '<li><b>Variação inválida, selecione novamente</b></li>';
		$errors['id_servico_var']=1;
	}

	if (count($errors)<1) {
		#verifica duplicidade
		$duplicidade = $pedidoDAO->verificaDuplicidade($p);
		$p->duplicidade = $duplicidade;
		
		$nova_ordem = $pedidoDAO->inserir_item($p,$id_pedido);
		$cadastrar_pedido = $id_pedido.'/'.$nova_ordem;
		$done=1;
	}

	if ($errors) {
		echo '<div class="erro">'.$error.'</div>';
	}

	if ($done) {		
		if($p->duplicidade<>0){ 
			//alterado 01/04/2011
			$titulo = 'Mensagem da página web';
			$msg    = 'Possivelmente esse pedido foi cadastrado em duplicidade, faça uma busca no sistema para verificar';
			$pagina = '';
			$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
			echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
		}
		//alterado 28/09/2011
		$titulo = 'Adicionar Outro Serviço';
		$perg   = 'Registro adicionado com sucesso!\nO número da ordem é: '.$cadastrar_pedido.' \n\nDeseja Adicionar outro serviço?';
		$resp1  = 'pedido_add_servico.php?id='.$id_pedido.'&ordem='.$nova_ordem;
		$resp2  = 'pedido.php';

		$funcJs = "openConfirmBox('".$titulo."','".$perg."','".$resp1."','".$resp2."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
}
if (!$done) {


	if($p->id_conveniado<>'') $p->conveniado = 'Conveniado'; else $p->conveniado = 'Não Conveniado';
	?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<div id="carrega_ordem_input"><!-- abas -->
		<div style="position:relative; margin:auto; width:690px" id="container-hotsite">
		<ul>
			<li><a href="#aba0">Dados do serviço</a></li>
			<li><a href="#aba1" onclick="if(document.p_solicitante.solicitante.value==''){ carrega_solicitante('<?= $id_pedido ?>','<?= $ordem ?>'); }">Solicitante</a></li>
		</ul>
		<div id="aba0" style="position: relative; width:690px; margin: auto">
		<form enctype="multipart/form-data" action="" method="post"	name="pedido_add">
		<table class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados da Expedição do Documento</td>
			</tr>

			<tr>
				<td width="150">
				<div align="right"><strong>Departamento: </strong></div>
				</td>
				<td width="540" colspan="3"><select name="id_servico_departamento"
					id="id_servico_departamento" style="width: 500px"
					class="form_estilo <?=($errors['id_servico_departamento'])?'form_estilo_erro':''; ?>"
					onfocus="carrega_departamento(this.value);"
					; onchange="carrega_servico(this.value,''); carrega_servico_var('','');">
					<option value="<?= $p->id_servico_departamento ?>"><?= $p->departamento ?></option>
				</select><font color="#FF0000">*</font></td>
			</tr>


			<tr>
				<td>
				<div align="right"><strong>Serviço: </strong></div>
				</td>
				<td colspan="3"><select name="id_servico" style="width: 500px"
					id="id_servico"
					class="form_estilo <?=($errors['id_servico'])?'form_estilo_erro':''; ?>"
					onchange="carrega_servico_var(this.value,''); carrega_campo_r(this.value,'<?= $id_pedido ?>','<?= $ordem ?>');">
					<option value=""></option>
				</select> <font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Variação: </strong></div>
				</td>

				<td colspan="3"><select name="id_servico_var" id="id_servico_var"
					style="width: 500px"
					class="form_estilo <?=($errors['id_servico_var'])?'form_estilo_erro':''; ?>"
					onchange="carrega_servico_valor(this.value,'pedido_add');">
				</select> <font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Prazo em dias úteis: </strong></div>
				</td>
				<td colspan="3">
				<div style="float: left"><input type="text" name="dias"
					style="width: 50px" value="<?= $p->dias ?>"
					onKeyUp="masc_numeros(this,'###');"
					class="form_estilo <?=($errors['dias'])?'form_estilo_erro':''; ?>" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Valor:</strong>
				<input type="text" name="valor" style="width: 150px"
					value="<?= $p->valor ?>" id="valor"
					onkeyup="moeda(event.keyCode,this.value,'valor');"
					class="form_estilo <?=($errors['valor'])?'form_estilo_erro':''; ?>" />
				Formato ####.## &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
				<div style="width: 110px; float: left" class="form_estilo"><input
					type="checkbox"
					<? if($p->urgente=='on') echo 'checked="checked"'; ?>
					name="urgente" /> <strong>Urgente</strong></div>

				</td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Dados do Documento</td>
			</tr>
		</table>
		<div id="carrega_campos_input">

		<table class="tabela">

		<?
		$p_valor = "";
		$servicocampos = $servicosDAO->listaCampos($p->id_servico);
		foreach($servicocampos as $servicocampo){

			$p_valor .= '<tr>
              <td width="150"> <div align="right"><strong>'. $servicocampo->nome .': </strong></div></td>
              <td colspan="3" width="543">';
            if($servicocampo->campo!='certidao_estado' and $servicocampo->campo!='certidao_cidade'){
				$p_valor .= '<input type="'. $servicocampo->tipo .'" name="'. $servicocampo->campo .'" value="'. $p->{$servicocampo->campo}.'" style="width:500px"';
				if($servicocampo->mascara<>''){
					$p_valor .= ' onKeyUp="masc_numeros(this,\''.$servicocampo->mascara.'\');"';
				}
				$p_valor .= ' class="form_estilo'.(($errors[$servicocampo->campo])?' form_estilo_erro':'').'"/>';
			} else {
				if($servicocampo->campo=='certidao_estado')	$java_script = ' onchange="carrega_cidade2(\'\');" ';
				else 
					if($servicocampo->campo=='certidao_cidade') $java_script = ' onfocus="carrega_cidade3(certidao_estado.value,this.value);"  id="carrega_cidade_campo" '; 
					else $java_script = '';

				$p_valor .= '<select name="'. $servicocampo->campo .'" style="width:500px" '.$java_script.' class="form_estilo'.(($errors[$servicocampo->campo])?' form_estilo_erro':'').'">
								<option value="'. $p->{$servicocampo->campo} .'" selected>'. $p->{$servicocampo->campo} .'</option>';
				if($p->{$servicocampo->campo}<>'') $p_valor .= '<option value=""></option>';
	            if($servicocampo->campo=='certidao_estado'){
					$servicocampo_sel = $servicosDAO->listaEstados();
					foreach($servicocampo_sel as $scs){
						$p_valor .= '<option value="'. $scs->estado .'">'.$scs->estado.'</option>';
					}
				} else {
					
					if(${$servicocampo->campo}<>''){
						$servicocampo_sel = $servicosDAO->listaCidades(${$servicocampo->campo});
						#if($controle_id_usuario == 3148){
						if($servicocampo_sel != ''){
							foreach($servicocampo_sel as $scs){
								$p_valor .= '<option value="'. $scs->cidade .'">'.$scs->cidade.'</option>';
							}
						}
					}
				}

				$p_valor .= '</select>';
			}
			$p_valor .= ($servicocampo->obrigatorio)?'<font color="#F00">*</font>':'';
			$p_valor .= ' </td>
            </tr>';
			$cont++;
		}
		echo $p_valor;
		?>
			<tr>
				<td width="150">
				<div align="right"><strong>CONTROLE DO CLIENTE: </strong></div>
				</td>
				<td colspan="3" width="540"><input type="text"
					name="controle_cliente" value="<?=$p->controle_cliente ?>"
					style="width: 500px" class="form_estilo" /></td>
			</tr>
		</table>


		</div>
		<table class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Observações</td>
			</tr>
			<tr>
				<td width="150" valign="top">
				<div align="right"><strong>Obs: </strong></div>
				</td>
				<td width="540" colspan="3"><textarea name="obs" class="form_estilo"
					style="width: 500px; height: 100px"><?= $p->obs ?></textarea></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit_servico"
					value="Adicionar" class="button_busca" /> &nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.pedido_add.action='pedido.php'"
					class="button_busca" /></div>
				</td>
			</tr>
		</table>

		<script type="text/javascript">
				carrega_servico('<?= $p->id_servico_departamento ?>','<?= $p->id_servico ?>');
				carrega_servico_var('<?= $p->id_servico ?>','<?= $p->id_servico_var ?>');
        </script> 
		<input type="hidden" name="cpf" value="<?= $p->cpf ?>" /> <input type="hidden" name="id" value="<?= $p->id_pedido ?>" /></form>
		</div>
		<div id="aba1" style="position:relative; margin:auto">
		<div id="carrega_solic">
		<form name="p_solicitante" id="p_solicitante">
			<input type="hidden" name="solicitante" value="">
		</form>
		</div>
		</div>

		<!-- Fim aba --></div>
		<div id="carrega_valor"></div>
		</form>
		
		</blockquote>
		</td>
	</tr>
</table>
		<? } ?></div>
		<?php

		require('footer.php');
		?>