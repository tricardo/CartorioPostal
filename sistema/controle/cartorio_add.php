<? require('header.php');
$permissao = verifica_permissao('Cartorio',$controle_id_departamento_p,$controle_id_departamento_s);
#permissao apenas para a Rosana e para a Mine
if($permissao=='FALSE' or $controle_id_empresa!=1){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

$cartorioDAO = new CartorioDAO();

?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_cartorio.png" alt="Título" />Cartório</h1>
<hr class="tit" />
</div>
<div id="meio"><?
pt_register('POST','submit');
if ($submit) {//check for errors
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','nome');
	pt_register('POST','fantasia');
	pt_register('POST','tipo');
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

	$cartorio = new stdClass();
	$cartorio->nome = trim($nome);
	$cartorio->fantasia = trim($fantasia);
	$cartorio->tipo = $tipo;
	$cartorio->cpf = trim($cpf);
	$cartorio->rg = $rg;
	$cartorio->endereco = $endereco;
	$cartorio->numero = $numero;
	$cartorio->complemento = $complemento;
	$cartorio->bairro = $bairro;
	$cartorio->cidade = $cidade;
	$cartorio->estado = $estado;
	$cartorio->cep = $cep;
	$cartorio->distrito = $distrito;
	$cartorio->comarca = $comarca;
	$cartorio->contato = $contato;
	$cartorio->tel = $tel;
	$cartorio->ramal = $ramal;
	$cartorio->cel = $cel;
	$cartorio->fax = $fax;
	$cartorio->email = $email;
	$cartorio->site = $site;
	$cartorio->banco = $banco;
	$cartorio->cod_banco = $cod_banco;
	$cartorio->agencia = $agencia;
	$cartorio->conta = $conta;
	$cartorio->favorecido = $favorecido;
	$cartorio->status = $status;
	$cartorio->obs = $obs;
	$cartorio->valor_busca = $valor_busca;
	$cartorio->valor_certidao = $valor_certidao;
	$cartorio->tel2 = $tel2;
	$cartorio->ramal2 = $ramal2;
	$cartorio->atribuicao = $atribuicao;

	$cartorioverificaDAO=new CartorioVerificaDAO();
	$errors = $cartorioverificaDAO->verificaAtualizacao($cartorio);

	if($errors['error']=="") {
		$id = $cartorioDAO->inserir($cartorio);
		$done=1;
	}
	else {
		echo '<div class="erro"><ul>'.$errors['error'].'</ul></div>';
	}
	if ($done) {
		//alterado 01/04/2011
		$titulo = 'Novo registro adicionado com sucesso!';
		$msg    = 'Registro editado com sucesso!';
		$pagina = "cartorio.php";
		$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
}
?> <?	if (!$done) { ?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"
			name="cartorio_add">
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
					<? if($status=='Ativo') echo 'selected="selected"'; ?>>Ativo</option>
					<option value="Inativo"
					<? if($status=='Inativo') echo 'selected="selected"'; ?>>Inativo</option>
					<option value="Cancelado"
					<? if($status=='Cancelado') echo 'selected="selected"'; ?>>Cancelado</option>
				</select></td>
				<td width="70"></td>
				<td width="219"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome" value="<?= $nome ?>"
					style="width: 470px"
					class="form_estilo <?=($errors['nome'])?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Fantasia: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="fantasia"
					value="<?= $fantasia ?>" style="width: 470px"
					class="form_estilo <?=($errors['fantasia'])?'form_estilo_erro':''; ?>">
				<font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CNPJ: </strong></div>
				</td>
				<td><input type="hidden" name="tipo" value="cnpj" />
				<div id="cpf" style="float: left"><input type="text" name="cpf"
					value="<?= $cpf ?>" style="width: 150px"
					onKeyUp="masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=(isset($errors['cpf']))?'form_estilo_erro':''; ?>" /></div>
				</td>
				<td>
				<div align="right"><strong>IE: </strong></div>
				</td>
				<td><input type="text" name="rg" value="<?= $rg ?>"
					style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Contato: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="contato"
					value="<?= $contato ?>" style="width: 470px" class="form_estilo"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel / Ramal: </strong></div>
				</td>
				<td><input type="text" name="tel" value="<?= $tel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /> - <input type="text" name="ramal"
					value="<?= $ramal ?>" style="width: 50px" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Cel: </strong></div>
				</td>
				<td><input type="text" name="cel" value="<?= $cel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel / Ramal:</strong></div>
				</td>
				<td><input type="text" name="tel2" value="<?= $tel2 ?>"
					style="width: 150px" onkeyup="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /> - <input type="text" name="ramal2"
					value="<?= $ramal2 ?>" style="width: 50px" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Fax: </strong></div>
				</td>
				<td><input type="text" name="fax" value="<?= $fax ?>"
					style="width: 150px" onkeyup="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Email: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="email"
					value="<?= $email ?>" style="width: 470px"
					class="form_estilo <?=($errors['email'])?'form_estilo_erro':''; ?>" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Site: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="site" value="<?= $site ?>"
					style="width: 470px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Comarca: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="comarca"
					value="<?= $comarca ?>" style="width: 470px" class="form_estilo"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Distrito: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="distrito"
					value="<?= $distrito ?>" style="width: 470px" class="form_estilo"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Atribuição: </strong></div>
				</td>
				<td colspan="3"><select name="atribuicao" class="form_estilo"
					style="width: 150px">
					<?
					$atribuicoes = $cartorioDAO->listaAtribuicoes();
					$p_valor;
					foreach($atribuicoes as $atr){
						$p_valor .= '<option value="'.$atr->id_atribuicao.'" ';
						$p_valor .= ($atribuicao==$atr->id_atribuicao)?' selected="selected"':'';
						$p_valor .=  '>'.$atr->atribuicao.'</option>';
					}
					echo $p_valor;
					?>
				</select></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Valor da Busca: </strong></div>
				</td>
				<td><input type="text" name="valor_busca" style="width: 200px"
					value="<?= $valor_busca ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Valor da Certidão:</strong></div>
				</td>
				<td><input type="text" name="valor_certidao" style="width: 150px"
					value="<?= $valor_certidao ?>" class="form_estilo" /></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="cep" style="width: 150px"
					value="<?= $cep ?>"
					class="form_estilo <?=($errors['cep'])?'form_estilo_erro':''; ?>"
					onKeyUp="masc_numeros(this,'#####-###');" /> <font color="#FF0000">*</font>
				<input type="button" name="consultar2" value="Consultar"
					class="button_busca"
					onclick="carrega_endedeco(cep.value, 'cartorio_add');" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco"
					value="<?= $endereco ?>" style="width: 350px"
					class="form_estilo <?=($errors['endereco'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font> <strong>N&deg;</strong> <input type="text"
					name="numero" style="width: 95px" value="<?= $numero ?>"
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
					class="form_estilo <?=($errors['bairro'])?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font>
			
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" style="width: 200px"
					value="<?= $cidade ?>"
					class="form_estilo <?=($errors['cidade'])?'form_estilo_erro':''; ?>" />
				<font color="#FF0000">*</font> <input type="hidden" name="id"
					value="<?= $id ?>" /></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?= $estado ?>"
					class="form_estilo <?=($errors['estado'])?'form_estilo_erro':''; ?>"
					maxlength="2" /><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Dados Bancários</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Banco: </strong></div>
				</td>
				<td><input type="text" name="banco" style="width: 200px"
					value="<?= $banco ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Código:</strong></div>
				</td>
				<td><input type="text" name="cod_banco" style="width: 150px"
					value="<?= $cod_banco ?>" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Agência: </strong></div>
				</td>
				<td><input type="text" name="agencia" style="width: 200px"
					value="<?= $agencia ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>C/C:</strong></div>
				</td>
				<td><input type="text" name="conta" style="width: 150px"
					value="<?= $conta ?>" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Favorecido: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="favorecido"
					style="width: 470px" value="<?= $favorecido ?>" class="form_estilo" /></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Observações</td>
			</tr>
			<tr>
				<td valign="top">
				<div align="right"><strong>Obs: </strong></div>
				</td>
				<td colspan="3"><textarea name="obs" class="form_estilo"
					style="width: 470px; height: 150px"><?= $obs ?></textarea></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Adicionar" class="button_busca" />&nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.cartorio_add.action='cartorio.php'"
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
}
require('footer.php');
?>
