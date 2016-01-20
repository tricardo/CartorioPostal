<?
@ini_set("memory_limit",'500M');
set_time_limit(1500);
require('header.php');

$permissao = verifica_permissao('Pedido Add',$controle_id_departamento_p,$controle_id_departamento_s);
?>
<div id="topo"><?
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','cpf');
pt_register('GET','tipo');
?>
<h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" />
Pedido</h1>
<hr class="tit" />
</div>

<div id="meio"><?
pt_register('POST','submit');
pt_register('POST','id_servico');
$empresaDAO = new EmpresaDAO();
$pedidoDAO = new PedidoDAO();
$servicosDAO = new ServicoDAO();
$servicocampos = $servicosDAO->listaCampos($id_servico);

if ($submit) {//check for errors
	$errors=array();
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','nome');
	pt_register('POST','origem');
	pt_register('POST','id_ponto');
	pt_register('POST','id_pacote');
	pt_register('POST','retem_iss');
	pt_register('POST','urgente');
	pt_register('POST','restricao');
	pt_register('POST','id_conveniado');
	$id_cliente=$id_conveniado;
	pt_register('POST','tel2');
	pt_register('POST','tel');
	pt_register('POST','ramal2');
	pt_register('POST','ramal');
	pt_register('POST','fax');
	pt_register('POST','outros');
	pt_register('POST','email');
	pt_register('POST','cpf');
	pt_register('POST','rg');
	pt_register('POST','tipo');
	pt_register('POST','complemento');
	pt_register('POST','numero');
	pt_register('POST','endereco');
	pt_register('POST','bairro');
	pt_register('POST','cidade');
	pt_register('POST','estado');
	pt_register('POST','cep');
	pt_register('POST','omesmo');
	pt_register('POST','controle_cliente');
	pt_register('POST','complemento_f');
	pt_register('POST','numero_f');
	pt_register('POST','endereco_f');
	pt_register('POST','bairro_f');
	pt_register('POST','cidade_f');
	pt_register('POST','estado_f');
	pt_register('POST','cep_f');
	pt_register('POST','forma_pagamento');
	pt_register('POST','dados_bancarios');
	pt_register('POST','id_servico');
	pt_register('POST','id_servico_departamento');
	pt_register('POST','id_servico_var');
	pt_register('POST','valor');
	pt_register('POST','dias');
	pt_register('POST','obs');
	pt_register('POST','contato');
	pt_register('POST','contato_rg');
	pt_register('POST','retirada');
	pt_register('POST','file_import_name_imp');

	$p = new stdClass();
	$p->id_usuario=$controle_id_usuario;
	$p->id_empresa_atend=$controle_id_empresa;
	$p->nome=$nome;
	$p->origem=$origem;
	$p->id_ponto=$id_ponto;
	$p->id_pacote=$id_pacote;
	$p->retem_iss=$retem_iss;
	$p->urgente=$urgente;
	$p->restricao=$restricao;
	$p->id_conveniado=$id_conveniado;
	$p->id_cliente=$id_cliente;
	$p->tel2=$tel2;
	$p->tel=$tel;
	$p->ramal2=$ramal2;
	$p->ramal=$ramal;
	$p->fax=$fax;
	$p->outros=$outros;
	$p->email=$email;
	$p->cpf=$cpf;
	$p->rg=$rg;
	$p->tipo=$tipo;
	$p->complemento=$complemento;
	$p->numero=$numero;
	$p->endereco=$endereco;
	$p->bairro=$bairro;
	$p->cidade=$cidade;
	$p->estado=$estado;
	$p->cep=$cep;
	$p->omesmo=$omesmo;
	$p->controle_cliente=$controle_cliente;
	$p->complemento_f=$complemento_f;
	$p->numero_f=$numero_f;
	$p->endereco_f=$endereco_f;
	$p->bairro_f=$bairro_f;
	$p->cidade_f=$cidade_f;
	$p->estado_f=$estado_f;
	$p->cep_f=$cep_f;
	$p->forma_pagamento=$forma_pagamento;
	$p->dados_bancarios=$dados_bancarios;
	$p->id_servico=$id_servico;
	$p->id_servico_departamento=$id_servico_departamento;
	$p->id_servico_var=$id_servico_var;
	$p->valor=$valor;
	$p->dias=$dias;
	$p->obs=$obs;
	$p->contato=$contato;
	$p->contato_rg=$contato_rg;
	$p->retirada=$retirada;

	foreach($servicocampos as $servicocampo){
		pt_register('POST',$servicocampo->campo);
		$p->{$servicocampo->campo}=${$servicocampo->campo};
	}


	if($cpf=="" || $dias==""|| $cep==""|| $origem=="" || $forma_pagamento=="" || $numero=="" || $endereco=="" || $cidade=="" || $estado=="" || $bairro=="" || $nome=="" ||
	$id_servico=="" || $id_servico_var=="" || $id_servico_var=="0" || $id_servico_departamento=="" || !is_numeric($id_servico) || !is_numeric($id_servico_var)){
		if($dias=="")      								$errors['dias']=1;
		if($cep=="")      								$errors['cep']=1;
		if($cpf=="")      								$errors['cpf']=1;
		if($forma_pagamento=="")    					$errors['forma_pagamento']=1;
		if($numero=="")      							$errors['numero']=1;
		if($endereco=="")      							$errors['endereco']=1;
		if($cidade=="")      							$errors['cidade']=1;
		if($estado=="")      							$errors['estado']=1;
		if($bairro=="")      							$errors['bairro']=1;
		if($nome=="")     								$errors['nome']=1;
		if($origem=="")      							$errors['origem']=1;
		if($id_servico=="" or $id_servico=="0")  		$errors['id_servico']=1;
		if(!is_numeric($id_servico))  		$errors['id_servico']=2;
		if($id_servico_var=="" or $id_servico_var=="0") $errors['id_servico_var']=1;
		if(!is_numeric($id_servico_var))  		$errors['id_servico_var']=2;
		if($id_servico_departamento=="")      			$errors['id_servico_departamento']=1;

		$error .= "<li><b>Os campos com * são obrigatórios.</b></li>";
	}

	if($valor=="" or $valor=="0"){
		$errors['valor']=1;
		$error.="<li><b>O campo \"valor\" precisa ser preenchido.</b></li>";
	}

	if($origem!="Ponto de Venda"){
		$id_ponto = '';
	} else {
		if($id_ponto==''){
			$errors['id_ponto']=1;
			$error.="<li><b>Selecione o Ponto de Venda.</b></li>";
		}
	}

	if($email<>''){
		$valida = validaEMAIL($email);
		if($valida=='false'){
			$errors['email']=1;
			$error.="<li><b>E-mail Inválido, digite corretamente.</b></li>";
		}
	}

	if($tipo=='cpf'){
		$valida = validaCPF($cpf);
		if($valida=='false'){
			$errors['cpf']=1;
			$error.="<li><b>CPF Inválido, digite corretamente.</b></li>";
		}
	} else {
		$valida = validaCNPJ($cpf);
		if($valida=='false' and $controle_id_pais==32){
			$errors['cpf']=1;
			$error.="<li><b>CNPJ Inválido, digite corretamente.</b></li>";
		}
	}
	
	
	if(isset($certidao_estado)){
	
		$servicover = new ServicoVerificaDAO();
		$srv = $servicover->verUFCid(1, $id_servico, $certidao_cidade, $certidao_estado);
		if(strlen($srv[2]) + strlen($srv[3]) > 0){
			$errors['certidao_estado'] = $srv[0]; $errors['certidao_cidade'] = $srv[1];
			$error.=$srv[2].$srv[3];
		}
	}

	#verifica regiao da franquia
	if($cidade!='São Paulo' and $origem!='Correios'){
		$res_regiao = $pedidoDAO->verificaRegiao($p);
		if ($res_regiao->id_pais==32 and (($p->id_cliente=='' and $controle_id_empresa==1 and $res_regiao->id_empresa<>'' or $controle_id_empresa!=1) and $p->origem!='Balcão' and $controle_id_empresa!=$res_regiao->id_empresa and $p->cpf!='02.905.424/0001-20' and $_SESSION['controle_teste'] == '' or 
			$controle_id_empresa=='1' and $res_regiao->id_empresa<>'' and $p->tipo=='cpf' and $_SESSION['controle_teste'] == '' and $p->origem!='Balcão')){
				$error .= '<li><b>Essa faixa de cep pertence a seguinte franquia: '.$res_regiao->fantasia.'</b></li>';
				$errors['cep']=1;
		}
	} else {
		$res_regiao = $empresaDAO->selectPorId($controle_id_empresa);
		if($res_regiao->cidade!='São Paulo' and $origem!='Correios'){
			$error .= '<li><b>Essa faixa de cep pertence a outra franquia</b></li>';
			$errors['cep']=1;
		}
	}

	#verifica servico
	$res_servico = $servicosDAO->verificaServicoVar($p->id_servico_var);
	if ($res_servico->total=='0'){
		$error .= '<li><b>Variação inválida, selecione novamente</b></li>';
		$errors['id_servico_var']=1;
	}

	$file_import = isset($_FILES["file_import"]) ? $_FILES["file_import"] : FALSE;
	// Formulário postado... executa as ações
	if($file_import['name']<>''){
		$error_image = valida_upload_txt($file_import);
		if ($error_image){
			$error .= $error_image;
			$errors['import']=1;
		}
	}
	
	if (count($errors)<1) {

		#verifica duplicidade
		$duplicidade = $pedidoDAO->verificaDuplicidade($p);
		$p->duplicidade = $duplicidade;

		$verificacliente = $pedidoDAO->verificaCliente($p);
		echo $verificacliente;
		
		if($file_import['name']<>'' or $file_import_name_imp<>''){
			if($file_import['name']<>''){
				$file_path = "./remessa/";
				// Pega extensão do file_import
				preg_match("/\.(txt|rem){1}$/i", $file_import["name"], $ext);
				// Gera um nome único para a imagem
				$imagem_nome = $controle_id_usuario.'_'.md5(uniqid(time())) . "." . $ext[1];
				// Caminho de onde a imagem ficará
				$imagem_dir = $file_path.$imagem_nome;
				// Faz o upload da imagem
				move_uploaded_file($file_import["tmp_name"], $imagem_dir);
				$file_import_name = $imagem_nome;
			} else {
				$file_import_name = $file_import_name_imp;
			}
			require("pedido_import.php");
		} else {
			$cadastrar_pedido = $pedidoDAO->inserir($p);
			$done=1;
		}
	}
	if ($errors) {
		echo '<div class="erro">'.$error.'</div>';
	}
	if ($done) {
		//alterado 01/04/2011
		$titulo = 'Adicionar Pedido';
		if($p->duplicidade<>0){
			$msg    = 'Possivelmente esse pedido foi cadastrado em duplicidade, faça uma busca no sistema para verifica';
			$pagina = '';
			$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
			echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
		}
		$titulo = 'Adicionar novo Serviço';
		$perg   = 'Registro adicionado com sucesso!\nO número da ordem é: '.$cadastrar_pedido.' '.$importados .'\n\nDeseja Adicionar outro serviço?';
		$resp1  = 'pedido_add_servico.php?id='.str_replace('/1','',str_replace('#','',$cadastrar_pedido)).'&ordem=1';
		$resp2  = 'pedido.php';
		$funcJs = "openConfirmBox('".$titulo."','".$perg."','".$resp1."','".$resp2."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
}

if (!$done) {
	$clienteDAO = new ClienteDAO();
	$financeiroDAO = new FinanceiroDAO();
	$sDepartamentoDAO = new ServicoDepartamentoDAO();
	?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<form enctype="multipart/form-data" action="" method="post"
			name="pedido_add"><? if($ERRO_ARQ){ ?>
		<div
			style="width: 1110px; clear: both; position: relative; height: auto"><?= $ERRO_ARQ ?></div>
			<? } ?>
		<div style="clear: both">
		<table class="tabela">


			<tr>
				<td colspan="4" class="tabela_tit">Selecionar por Conveniado</td>
			</tr>
			<tr>
				<td width="150">
				<div align="right"><strong>Conveniado: </strong></div>
				</td>
				<td colspan="3"><select name="id_cliente" id="id_cliente"
					style="width: 493px" class="form_estilo"
					onfocus="if(this.value==''){carrega_cliente_conv(this.value);}"
					onchange="carrega_contato('',this.value);">
					<option value=""></option>
				</select></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Contato: </strong></div>
				</td>
				<td colspan="3" style="width: 510px"><select name="id_contato"
					id="id_conveniado_input" style="width: 493px" class="form_estilo"
					onchange="carrega_cliente_id(this.value,id_cliente.value,'pedido_add');">
				</select></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Dados do Solicitante</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CPF/CNPJ: </strong></div>
				</td>
				<td>
				<div style="float: left"><? if($tipo=='') $tipo='cpf'; ?> <select
					name="tipo"
					class="form_estilo <?=($errors['cpf'])?'form_estilo_erro':''; ?>">
					<option value="cpf"
					<? if($tipo=='cpf') echo 'selected="selected"'; ?>>CPF</option>
					<option value="cnpj"
					<? if($tipo=='cnpj') echo 'selected="selected"'; ?>>CNPJ</option>
				</select></div>
				<div id="cpf" style="float: left"><input type="text" name="cpf"
					value="<?= $cpf ?>" style="width: 140px"
					onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=($errors['cpf'])?'form_estilo_erro':''; ?>" />
				</div>
				<font color="#FF0000">*</font></td>
				<td colspan="2"><input type="button" class="button_busca" style="height: 18px; text-align: center; vertical-align: middle" name="Consultar" value="Consultar" onclick="carrega_cliente('pedido_add',cpf.value); id_conveniado.value=''" />
				&nbsp; <b>ID Conveniado: </b><input name="id_conveniado" type="text" readonly="readonly" class="form_estilo_r" style="width: 70px" value="<?= $p->id_conveniado ?>"></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome" value="<?= $nome ?>"
					style="width: 493px"
					class="form_estilo <?=($errors['nome'])?'form_estilo_erro':''; ?>"><font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>RG/IE:</strong></div>
				</td>
				<td style="width: 220px"><input type="text" name="rg"
					value="<?= $rg ?>" style="width: 150px" class="form_estilo" /></td>
				<td style="width: 115px">
				<div align="right"><strong>Retem ISS</strong></div>
				</td>
				<td style="width: 200px">
				<div style="width: 150px" class="form_estilo"><input type="checkbox"
				<? if($retem_iss=='on') echo 'checked="checked"'; ?>
					name="retem_iss" /> <strong>Retem ISS</strong></div>
				</td>

			</tr>
			<tr>
				<td>
				<div align="right"><strong>Contato: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="contato"
					value="<?= $contato ?>" style="width: 493px"
					class="form_estilo <?=($errors['contato'])?'form_estilo_erro':''; ?>"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>RG do Contato:</strong></div>
				</td>
				<td><input type="text" name="contato_rg" value="<?= $contato_rg ?>"
					style="width: 150px" class="form_estilo" /></td>

				<td>
				<div align="right"><strong>Origem:</strong></div>
				</td>
				<td><select name="origem" style="width: 150px"
					class="form_estilo <?=($errors['origem'])?'form_estilo_erro':''; ?>"
					onchange="javascript:if(this.value=='Ponto de Venda'){ 
       							document.getElementById('id_ponto').style.visibility='visible'; 
       							carrega_pontodevenda(this.value);
       						} 
       						else if(this.value=='Correios'){ 
       							document.getElementById('tr_dados_bancarios').style.visibility='visible';
       							document.getElementById('id_ponto').style.visibility='hidden'; 
       							id_ponto.value=''; 
       						}
       						else {
       							document.getElementById('id_ponto').style.visibility='hidden'; 
       							id_ponto.value=''; 
       							document.getElementById('tr_dados_bancarios').style.visibility='hidden'; dados_bancarios.value=null;
       						}">
					<option value=""></option>
					<?
					$p_valor = "";
					$origens = $pedidoDAO->listarOrigem();
					foreach($origens as $o){
						$p_valor .= '<option value="'.$o->origem.'"';
						if($origem==$o->origem) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.$o->origem.'</option>';
					}
					echo $p_valor;
					?>
				</select><font color="#FF0000">*</font></td>
			</tr>
			<tr id="tr_dados_bancarios" style="<? if($origem!='Correio') echo "visibility:hidden";?>">
				<td></td>

				<td align="right" colspan="2"><strong>N DEPOSITO /BOLETO/V.POSTAL:</strong></td>
				<td><input type="text" name="dados_bancarios" id="dados_bancarios"
					class="form_estilo" style="width: 150px"
					value="<?php echo $dados_bancarios ?>" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Pacote:</strong></div>
				</td>
				<td><select name="id_pacote" style="width: 150px"
					class="form_estilo">
					<option value=""
					<? if($id_pacote=='') echo ' selected="selected" '; ?>>Sem Pacote</option>
					<?
					$p_valor = "";
					$pacote = $financeiroDAO->listarPacote();
					foreach($pacote as $pacote){
						$p_valor .= '<option value="'.$pacote->id_pacote.'"';
						if($id_pacote==$pacote->id_pacote) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.$pacote->pacote.'</option>';
					}
					echo $p_valor;
					?>
				</select></td>
				<td></td>
				<td><select name="id_ponto" id="id_ponto" style="width:150px; <? if($origem!='Ponto de Venda') echo "visibility:hidden;";?> " class="form_estilo">
				</select></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Urgente:</strong></div>
				</td>
				<td>
				<div style="width: 150px" class="form_estilo"><input type="checkbox"
				<? if($urgente=='on') echo 'checked="checked"'; ?> name="urgente" />
				<strong>Urgente</strong></div>
				</td>
				<td></td>
				<td>
				<div style="width: 150px" class="form_estilo"><input type="checkbox"
				<? if($retirada=='on') echo 'checked="checked"'; ?> name="retirada" />
				<strong>Retirar no Balcão</strong></div>
				</td>

			</tr>


			<tr>
				<td>
				<div align="right"><strong>Tem Restrição:</strong></div>
				</td>
				<td>
				<div style="width: 150px" class="form_estilo"><input type="checkbox"
				<? if($restricao=='on') echo 'checked="checked"'; ?>
					name="restricao" /> <strong>Tem restrição</strong></div>
				</td>
				<td>
				<div align="right"><strong>Forma Pagamento:</strong></div>
				</td>
				<td><select name="forma_pagamento" style="width: 150px"
					class="form_estilo <?=($errors['forma_pagamento'])?'form_estilo_erro':''; ?>">
					<option value=""></option>
					<?
					$p_valor = "";
					$formapagamentos = $financeiroDAO->listarFormaPagamento();
					foreach($formapagamentos as $formapagamento){
						$p_valor .= '<option value="'.$formapagamento->forma_pagamento.'"';
						if($forma_pagamento==$formapagamento->forma_pagamento) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.$formapagamento->forma_pagamento.'</option>';
					}
					echo $p_valor;
					?>
				</select> <font color="#FF0000">*</font></td>

			</tr>


			<tr>
				<td>
				<div align="right"><strong>Tel: </strong></div>
				</td>
				<td><input type="text" name="tel" value="<?= $tel ?>"
					style="width: 150px" onKeyUp="if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /> - <input type="text" name="ramal"
					value="<?= $ramal ?>" style="width: 50px"
					onkeyup="masc_numeros(this,'####');" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Fax: </strong></div>
				</td>
				<td><input type="text" name="fax" value="<?= $fax ?>"
					style="width: 150px" onKeyUp="if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel: </strong></div>
				</td>
				<td><input type="text" name="tel2" value="<?= $tel2 ?>"
					style="width: 150px" onKeyUp="if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /> - <input type="text" name="ramal2"
					value="<?= $ramal2 ?>" style="width: 50px"
					onkeyup="masc_numeros(this,'####');" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Outros: </strong></div>
				</td>
				<td><input type="text" name="outros" value="<?= $outros ?>"
					style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Email: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="email"
					value="<?= $email ?>" style="width: 493px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço Comercial ou Residêncial</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3">
				<div style="float: left"><input type="text" name="cep"
					style="width: 150px" value="<?= $cep ?>"
					class="form_estilo <?=($errors['cep'])?'form_estilo_erro':''; ?>"
					onKeyUp="if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'#####-###');" /> <font color="#FF0000">*</font>
				<input type="button" name="consultar2" value="Consultar"
					class="button_busca"
					onclick="carrega_endedeco(cep.value, 'pedido_add');" /></div>
				<div style="width: 224px; float: left; margin-left: 5px"
					class="form_estilo">&nbsp;&nbsp;<input type="checkbox"
					<? if($omesmo=='on') echo 'checked="checked"'; ?>
					onchange="javascript:faturar_mesmoendereco(this.checked);"
					name="omesmo" /> <strong>Faturar para o mesmo endereço</strong></div>
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endereço: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco"
					value="<?= $endereco ?>" style="width: 373px"
					class="form_estilo <?=($errors['endereco'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font> <strong>N&deg;</strong> <input type="text"
					name="numero" style="width: 92px" value="<?= $numero ?>"
					class="form_estilo <?=($errors['numero'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Complemento: </strong></div>
				</td>
				<td><input type="text" name="complemento" style="width: 200px"
					value="<?= $complemento ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input type="text" name="bairro" style="width: 150px"
					value="<?= $bairro ?>"
					class="form_estilo <?=($errors['bairro'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" style="width: 200px"
					value="<?= $cidade ?>"
					class="form_estilo <?=($errors['cidade'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?= $estado ?>"
					class="form_estilo <?=($errors['estado'])?'form_estilo_erro':''; ?>"
					maxlength="2" /><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço de Faturamento</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="cep_f" style="width: 150px"
					value="<?= $cep_f ?>" class="form_estilo"
					onKeyUp="if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'#####-###');" /> <input type="button"
					name="consultar3" value="Consultar" class="button_busca"
					onclick="carrega_endedeco2(cep_f.value, 'pedido_add');" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco_f"
					value="<?= $endereco_f ?>" style="width: 373px" class="form_estilo" />
				&nbsp;&nbsp;<strong>N&deg;</strong> <input type="text"
					name="numero_f" style="width: 92px" value="<?= $numero_f ?>"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Complemento: </strong></div>
				</td>
				<td><input type="text" name="complemento_f" style="width: 200px"
					value="<?= $complemento_f ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input type="text" name="bairro_f" style="width: 150px"
					value="<?= $bairro_f ?>" class="form_estilo" /></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade_f" style="width: 200px"
					value="<?= $cidade_f ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado_f" style="width: 150px"
					value="<?= $estado_f ?>" class="form_estilo" maxlength="2" /></td>
			</tr>

			<tr>
				<td colspan="4" class="tabela_tit">Dados da Expedição do Documento</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Departamento: </strong></div>
				</td>
				<td colspan="3"><select name="id_servico_departamento"
					id="id_servico_departamento" style="width: 493px"
					class="form_estilo <?=($errors['id_servico_departamento'])?'form_estilo_erro':''; ?>"
					onfocus="carrega_departamento(this.value);"
					onchange="carrega_servico(this.value,''); carrega_servico_var('','');">
					<option value="<?= $p->id_servico_departamento ?>">
					<? 	
					#carrega departamento
					$res_departamento = $sDepartamentoDAO->listaPorId($p->id_servico_departamento);
					echo $res_departamento->departamento;
					?></option>
				</select> <font color="#FF0000">*</font></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Serviço: </strong></div>
				</td>
				<td colspan="3"><select name="id_servico" style="width: 493px" id="id_servico" class="form_estilo <?=($errors['id_servico'])?'form_estilo_erro':''; ?>"
					onchange="carrega_servico_var(this.value,''); carrega_campo_r(this.value,'','');">
					<option value=""></option>
				</select> <font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Variação: </strong></div>
				</td>
				<td colspan="3"><select name="id_servico_var" id="id_servico_var"
					style="width: 493px"
					class="form_estilo <?=($errors['id_servico_var'])?'form_estilo_erro':''; ?>" onchange="carrega_servico_valor(this.value,'pedido_add');">
				</select> <font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Prazo em dias úteis: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="dias" style="width: 150px"
					value="<?= $dias ?>" onKeyUp="masc_numeros(this,'###');"
					class="form_estilo <?=($errors['dias'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font> &nbsp;&nbsp;&nbsp;&nbsp;<strong>Valor:</strong>
				<input type="text" name="valor" style="width: 150px"
					value="<?= $valor ?>" id="valor"
					onkeyup="moeda(event.keyCode,this.value,'valor');"
					class="form_estilo <?=($errors['valor'])?'form_estilo_erro':''; ?>" />
				Formato ####.##</td>
			</tr>

			<?
			$permissao = verifica_permissao('Pedido Import',$controle_id_departamento_p,$controle_id_departamento_s);
			if($permissao == 'TRUE' and ($controle_id_empresa=='1' or $controle_id_empresa=='20' or $controle_id_empresa=='6' or $controle_id_empresa=='192')){
				?>
			<tr>
				<td>
				<div align="right"><strong>Importar do arquivo: </strong></div>
				</td>
				<td colspan="3"><input type="file" name="file_import"
					style="width: 200px" value="<?= $file_import ?>"
					class="form_estilo" /> Apenas para (Notificação, Imóveis e Detran)
				</td>
			</tr>
			<? } ?>
			<tr>
				<td colspan="4" class="tabela_tit">Dados do Documento</td>
			</tr>
		</table>
		<div id="carrega_campos_input">
		<table class="tabela">
		<?
		$p_valor = "";
		foreach($servicocampos as $servicocampo){

			$p_valor .= '<tr>
              <td width="150"> <div align="right"><strong>'. $servicocampo->nome .': </strong></div></td>
              <td colspan="3" width="543">';
            if($servicocampo->campo!='certidao_estado' and $servicocampo->campo!='certidao_cidade'){
				$p_valor .= '<input type="'. $servicocampo->tipo .'" name="'. $servicocampo->campo .'" value="'. ${$servicocampo->campo}.'" style="width:500px"';
				if($servicocampo->mascara<>''){
					$p_valor .= ' onKeyUp="masc_numeros(this,\''.$servicocampo->mascara.'\');"';
				}
				$p_valor .= ' class="form_estilo'.(($errors[$servicocampo->campo])?' form_estilo_erro':'').'"/>';
			} else {
				if($servicocampo->campo=='certidao_estado')	$java_script = ' onchange="carrega_cidade2(\'\');" ';
				else 
					if($servicocampo->campo=='certidao_cidade') $java_script = ' onfocus="carrega_cidade2(certidao_estado.value);" id="carrega_cidade_campo" '; 
					else $java_script = '';

				$p_valor .= '<select name="'. $servicocampo->campo .'" style="width:500px" '.$java_script.' class="form_estilo'.(($errors[$servicocampo->campo])?' form_estilo_erro':'').'">
								<option value="'. ${$servicocampo->campo} .'">'. ${$servicocampo->campo} .'</option>';

				if(${$servicocampo->campo}<>''){
					$p_valor .= '<option value=""></option>';
				}
				if($servicocampo->campo=='certidao_estado'){
					$servicocampo_sel = $servicosDAO->listaEstados();
					foreach($servicocampo_sel as $scs){
						$p_valor .= '<option value="'. $scs->estado .'">'.$scs->estado.'</option>';
					}				
				} else {
					if(${$servicocampo->campo}<>''){
						$servicocampo_sel = $servicosDAO->listaCidades($certidao_estado);
						foreach($servicocampo_sel as $scs){
							$p_valor .= '<option value="'. $scs->cidade .'">'.$scs->cidade.'</option>';
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
				<td colspan="3" width="543"><input type="text"
					name="controle_cliente" value="<?=$controle_cliente ?>"
					style="width: 493px" class="form_estilo" /></td>
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
				<td colspan="3" width="543"><textarea name="obs" class="form_estilo"
					style="width: 493px; height: 100px"><?= $obs ?></textarea></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Adicionar" class="button_busca" />&nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.pedido_add.action='pedido.php'"
					class="button_busca" /></div>
				</td>
			</tr>
		</table>
		<script type="text/javascript">
				<? if($id_cliente<>'') { ?>
				carrega_contato('<?= $id_conveniado ?>','<?= $id_cliente ?>');
				<? } ?>
				carrega_servico('<?= $id_servico_departamento ?>','<?= $id_servico ?>');
				carrega_servico_var('<?= $id_servico ?>','<?= $id_servico_var ?>');
				<? 
					if($p->omesmo=='on') echo " faturar_mesmoendereco(1); ";
				?>

			</script>
		<div id="carrega_dados"></div>
		<div id="resgata_endereco"></div>
		<div id="carrega_valor"></div>
		</div>

		</form>
		</td>
	</tr>
</table>
</div>
<?php
}
require('footer.php');
?>