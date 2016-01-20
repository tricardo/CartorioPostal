<?
require('header.php');
$permissao = verifica_permissao('Cartorio',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_cartorio.png" alt="Título" />
Cartório</h1>
<hr class="tit" />
<br />
</div>
<div id="meio"><?
$cartorioDAO = new CartorioDAO();
pt_register('POST','submit');
$done=0;
pt_register('GET','id');
if ($submit and $controle_id_empresa=='1') {//check for errors
	$errors=array();
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','nome');
	pt_register('POST','tipo');
	pt_register('POST','fantasia');
	pt_register('POST','ftipo');
	pt_register('POST','cpf');
	pt_register('POST','rg');
	pt_register('POST','endereco');
	pt_register('POST','numero');
	pt_register('POST','complemento');
	pt_register('POST','bairro');
	pt_register('POST','cidade');
	pt_register('POST','estado');
	pt_register('POST','cep');
	pt_register('POST','distrito');
	pt_register('POST','comarca');
	pt_register('POST','contato');
	pt_register('POST','tel');
	pt_register('POST','ramal');
	pt_register('POST','cel');
	pt_register('POST','fax');
	pt_register('POST','email');
	pt_register('POST','site');
	pt_register('POST','banco');
	pt_register('POST','cod_banco');
	pt_register('POST','agencia');
	pt_register('POST','conta');
	pt_register('POST','favorecido');
	pt_register('POST','status');
	pt_register('POST','obs');
	pt_register('POST','valor_busca');
	pt_register('POST','valor_certidao');
	pt_register('POST','tel2');
	pt_register('POST','ramal2');
	pt_register('POST','atribuicao');
	pt_register('POST','id_franquia');
	pt_register('POST','id_banco');
	pt_register('POST','franquia');
	
	$c = new stdClass();
	$c->id_cartorio = trim($id);
	$c->tipo = $tipo;
	$c->nome = trim($nome);
	$c->fantasia = trim($fantasia);
	$c->ftipo = $ftipo;
	$c->cpf = trim($cpf);
	$c->rg = $rg;
	$c->endereco = $endereco;
	$c->numero = $numero;
	$c->complemento = $complemento;
	$c->bairro = $bairro;
	$c->cidade = $cidade;
	$c->estado = $estado;
	$c->cep = $cep;
	$c->distrito = $distrito;
	$c->comarca = $comarca;
	$c->contato = $contato;
	$c->tel = $tel;
	$c->ramal = $ramal;
	$c->cel = $cel;
	$c->fax = $fax;
	$c->email = $email;
	$c->site = $site;
	$c->id_banco = $id_banco;
	$c->banco = $banco;
	$c->cod_banco = $cod_banco;
	$c->agencia = $agencia;
	$c->conta = $conta;
	$c->favorecido = $favorecido;
	$c->status = $status;
	$c->obs = $obs;
	$c->valor_busca = $valor_busca;
	$c->valor_certidao = $valor_certidao;
	$c->tel2 = $tel2;
	$c->ramal2 = $ramal2;
	$c->atribuicao = $atribuicao;
	$c->id_usuario_edit = $controle_id_usuario;
	$c->id_banco = $id_banco;
	if(strlen($franquia) == 0){
		$c->id_franquia = 0;
		$c->franquia = '';
	} else {
		$c->id_franquia = $id_franquia;
		$c->franquia = $franquia;
	}

	$cartorioverificaDAO=new CartorioVerificaDAO();
	$errors = $cartorioverificaDAO->verificaAtualizacao($c);
	if($errors['error']=="") {
		#print_r($c);
		#exit();
		$id = $cartorioDAO->atualizar($c);
		$done=1;
		//alterado 01/04/2011
		$titulo = 'Mensagem da página web';
		$msg    = 'Registro atualizado com sucesso!';
		$pagina = 'cartorio.php';
		$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	} else {
		echo '<div class="erro"><ul>'.$errors['error'].'</ul></div>';
	}
}
if (!$submit) {
	$c = $cartorioDAO->selectPorId($id);
	switch($c->id_empresa){
		case 0:
			$c->id_franquia = 0; 
			$c->franquia = '';
			break;
		case 1:
			$c->id_franquia = 1; 
			$c->franquia = 'Sistecart - Sistema de Cartório Certidões S/C Ltda';
			break;
		default:
			$empresaDAO = new EmpresaDAO();
			$e = $empresaDAO->selectPorId($c->id_empresa);
			$c->id_franquia = $c->id_empresa; 
			$c->franquia = $e->fantasia;
			break;
	}
}

if(!$c->id_franquia){ 
	$c->id_franquia = 0; 
	$c->franquia = '';
}
?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" name="cartorio_edit"
			method="post">
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados do Cartório</td>
			</tr>
			<tr>
				<td width="100">
				<div align="right"><strong>Status:</strong></div>
				</td>
				<td width="243"><select name="status" class="form_estilo"
					style="width: 150px">
					<option value="Ativo"
					<? if($c->status=='Ativo') echo 'selected="selected"'; ?>>Ativo</option>
					<option value="Inativo"
					<? if($c->status=='Inativo') echo 'selected="selected"'; ?>>Inativo</option>
					<option value="Cancelado"
					<? if($c->status=='Cancelado') echo 'selected="selected"'; ?>>Cancelado</option>
				</select></td>
				<td width="70">
					<div align="right"><strong>Tipo:</strong></div>
				</td>
				<td width="219"><select name="ftipo" class="form_estilo"
					style="width:150px">
						<option value="0" <? if($c->ftipo==0) echo 'selected="selected"'; ?>>Cartório</option>
						<option value="1" <? if($c->ftipo==1) echo 'selected="selected"'; ?>>Contato</option>
					</select></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome"
					value="<?=$c->nome ?>" style="width: 470px"
					class="form_estilo <?=(isset($errors['nome']))?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Fantasia: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="fantasia"
					value="<?=$c->fantasia ?>" style="width: 470px"
					class="form_estilo <?=(isset($errors['fantasia']))?'form_estilo_erro':''; ?>">
				<font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CNPJ: </strong></div>
				</td>
				<td><input type="hidden" name="tipo" value="cnpj" />
				<div id="cpf" style="float: left"><input type="text" name="cpf"
					value="<?=$c->cpf ?>" style="width: 150px"
					onKeyUp="masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=(isset($errors['cpf']))?'form_estilo_erro':''; ?>" /></div>
				</td>
				<td>
				<div align="right"><a name="endereco_click"></a><strong>IE: </strong></div>
				</td>
				<td><input type="text" name="rg" value="<?=$c->rg ?>"
					style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Contato: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="contato"
					value="<?=$c->contato ?>" style="width: 470px" class="form_estilo"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel / Ramal: </strong></div>
				</td>
				<td><input type="text" name="tel" value="<?=$c->tel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /> - <input type="text" name="ramal"
					value="<?=$c->ramal ?>" style="width: 50px" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Cel: </strong></div>
				</td>
				<td><input type="text" name="cel" value="<?=$c->cel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel / Ramal: </strong></div>
				</td>
				<td><input type="text" name="tel2" value="<?=$c->tel2 ?>"
					style="width: 150px" onkeyup="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /> - <input type="text" name="ramal2"
					value="<?=$c->ramal2 ?>" style="width: 50px" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Fax: </strong></div>
				</td>
				<td><input type="text" name="fax" value="<?=$c->fax ?>"
					style="width: 150px" onkeyup="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Email: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="email"
					value="<?=$c->email ?>" style="width: 470px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Site: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="site"
					value="<?=$c->site ?>" style="width: 470px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Comarca: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="comarca"
					value="<?=$c->comarca ?>" style="width: 470px" class="form_estilo"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Distrito: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="distrito"
					value="<?=$c->distrito ?>" style="width: 470px" class="form_estilo"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Atribuição: </strong></div>
				</td>
				<td colspan="3"><select name="atribuicao" class="form_estilo"
					style="width: 150px">
					<? $atribuicoes = $cartorioDAO->listaAtribuicoes();
					$p_valor='';
					foreach($atribuicoes as $atr){
						$p_valor.=  '<option value="'.$atr->id_atribuicao.'" ';
						$p_valor.=($c->atribuicao==$atr->id_atribuicao)?' selected="selected"':'';
						$p_valor.='>'.$atr->atribuicao.'</option>';
					}
					echo $p_valor;?>
				</select></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Valor da Busca: </strong></div>
				</td>
				<td><input type="text" name="valor_busca" style="width: 200px"
					value="<?=$c->valor_busca ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Valor da Certidão:</strong></div>
				</td>
				<td><input type="text" name="valor_certidao" style="width: 150px"
					value="<?=$c->valor_certidao ?>" class="form_estilo" /></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço</td>
			</tr>
			<tr>		
				<td colspan="4">
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td style="text-align:right; font-weight:bold" width="104">Busca CEP:&nbsp;</td>
							<td width="243">
								<input type="text" id="busca_cep" name="busca_cep" style="width:230px"
								class="form_estilo" 
								onKeyUp="masc_numeros(this,'#####-###');" />
							</td>
							<td colspan="2" width="70" style="text-align:right; font-weight:bold">
								<input type="button" name="consultar21" value="Consultar CEP"
								class="button_busca" onclick="busca_endereco(2);" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="4"><div id="resulta_pesquisa_busca_endereco" style="color:#0066FF; font-size:10px;"></div></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Franquia: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="franquia" id="franquia" value="<?=$c->franquia?>" 
				style="width: 470px" class="form_estilo" readonly="readonly" /><input type="hidden" 
				name="id_franquia" id="id_franquia" value="<?=$c->id_franquia ?>" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco" id="endereco"
					value="<?=$c->endereco ?>" style="width: 350px"
					class="form_estilo <?=(isset($errors['endereco']))?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font> <strong>N&deg;</strong> <input
					type="text" name="numero" style="width: 89px"
					value="<?=$c->numero ?>"
					class="form_estilo <?=(isset($errors['numero']))?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Complemento: </strong></div>
				</td>
				<td><input type="text" name="complemento" style="width: 200px"
					value="<?=$c->complemento ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input type="text" name="bairro" id="bairro" style="width: 150px"
					value="<?=$c->bairro ?>"
					class="form_estilo <?=(isset($errors['bairro']))?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>CEP: </strong></div>
				</td>
				<td><input type="text" name="cep" id="cep" style="width: 200px" value="<?=$c->cep ?>" 
					class="form_estilo <?=(isset($errors['cidade']))?'form_estilo_erro':''; ?>" 
					onKeyUp="masc_numeros(this,'#####-###');" /><font
					color="#FF0000">*</font></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" id="cidade" style="width: 200px"
					value="<?=$c->cidade ?>" readonly="readonly"
					class="form_estilo <?=(isset($errors['cidade']))?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font> <input type="hidden" name="id"
					value="<?=$c->id_cartorio ?>" /> <input type="hidden"
					name="old_login" value="<?=$c->login ?>" /></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" id="estado" style="width: 150px" readonly="readonly"
					value="<?=$c->estado ?>"
					class="form_estilo <?=(isset($errors['estado']))?'form_estilo_erro':''; ?>"
					maxlength="2" /><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Dados Bancários</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Banco: </strong></div>
				</td>
				<td>
					<select name="id_banco" style="width: 200px" class="form_estilo">
						<option value=""></option>
						<?
						$bancoDAO = new BancoDAO();
						$fin = $bancoDAO->listar();
						$p_valor = "";
						foreach($fin as $f){
							$p_valor .='<option value="'.$f->id_banco.'" ';
							if($c->id_banco==$f->id_banco) $p_valor .= ' selected ';
							$p_valor .='>'.$f->banco.'</option>';
						}
						echo $p_valor;
						?>
					</select>
				</td>
				<td>
				<div align="right"><strong>Código:</strong></div>
				</td>
				<td><input type="text" name="cod_banco" style="width: 150px"
					value="<?=$c->cod_banco ?>" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Agência: </strong></div>
				</td>
				<td><input type="text" name="agencia" style="width: 200px"
					value="<?=$c->agencia ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>C/C:</strong></div>
				</td>
				<td><input type="text" name="conta" style="width: 150px"
					value="<?=$c->conta ?>" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Favorecido: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="favorecido"
					style="width: 470px" value="<?=$c->favorecido ?>"
					class="form_estilo" /> <input type="hidden" name="id"
					value="<?=$c->id ?>" /></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Observações</td>
			</tr>
			<tr>
				<td valign="top">
				<div align="right"><strong>Obs: </strong></div>
				</td>
				<td colspan="3"><textarea name="obs" class="form_estilo"
					style="width: 470px; height: 150px"><?=$c->obs ?></textarea></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><? if($controle_id_empresa=='1'){ ?> <input
					type="submit" name="submit" value="Atualizar" class="button_busca" />&nbsp;
					<? } ?> <input type="submit" name="cancelar" value="Cancelar"
					onclick="document.cartorio_edit.action='cartorio.php'"
					class="button_busca" /></div>
				</td>
			</tr>
		</table>
		<div id="resgata_endereco"></div>
		</form>
		</blockquote>
		</td>
	</tr>
</table>
</div>
<?php

require('footer.php');
?>
