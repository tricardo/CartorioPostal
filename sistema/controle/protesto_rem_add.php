<? require('header.php');
$permissao = verifica_permissao('Protesto',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_protesto.png" alt="Título" />
Protesto (Devedor)</h1>
<hr class="tit" />
<br />
</div>
<div id="meio"><?
pt_register('GET','id');
if($id == ''){
	echo '<br><br><strong>Sequencia Incorreta, volte para a página inicial e repita a operação</strong>';
	exit;
}
pt_register('POST','submit');
if ($submit) {//check for errors
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','id_protesto');
	pt_register('POST','tit_num');
	pt_register('POST','nosso_numero');
	pt_register('POST','data_emissao');
	pt_register('POST','data_vencimento');
	pt_register('POST','valor');
	pt_register('POST','saldo');
	pt_register('POST','praca_pagamento');
	pt_register('POST','tipo_endosso');
	pt_register('POST','aceite');
	pt_register('POST','dev_num');
	pt_register('POST','dev_nome');
	pt_register('POST','tipo');
	pt_register('POST','cpf');
	pt_register('POST','outro_doc');
	pt_register('POST','dev_endereco');
	pt_register('POST','dev_cep');
	pt_register('POST','dev_cidade');
	pt_register('POST','dev_estado');
	pt_register('POST','num');
	pt_register('POST','num_pro');
	pt_register('POST','oco_tipo');
	pt_register('POST','data_protocolo');
	pt_register('POST','custas');
	pt_register('POST','decla_portador');
	pt_register('POST','data_ocorrencia');
	pt_register('POST','cod_irr');
	pt_register('POST','dev_bairro');
	pt_register('POST','custas_cart');
	pt_register('POST','registro_distr');
	pt_register('POST','custas_gravacao');
	pt_register('POST','contrato_banco');
	pt_register('POST','oper_banco');
	pt_register('POST','parcela_contrato');
	pt_register('POST','tipo_cam');
	pt_register('POST','comp_irr');
	pt_register('POST','motivo_falencia');
	pt_register('POST','especie');

	if($errors!=1) {
		$data_emissao 		= invert($data_emissao,'-','SQL');
		$data_vencimento 	= invert($data_vencimento,'-','SQL');
		$data_protocolo 	= invert($data_protocolo,'-','SQL');
		$data_ocorrencia 	= invert($data_ocorrencia,'-','SQL');

		$devedor = new stdClass();
		$devedor->id_protesto = $id_protesto;
		$devedor->tit_num = $tit_num;
		$devedor->nosso_numero = $nosso_numero;
		$devedor->data_emissao = $data_emissao;
		$devedor->data_vencimento = $data_vencimento;
		$devedor->data_ocorrencia = $data_ocorrencia;
		$devedor->valor = $valor;
		$devedor->saldo = $saldo;
		$devedor->praca_pagamento = $praca_pagamento;
		$devedor->tipo_endosso = $tipo_endosso;
		$devedor->aceite = $aceite;
		$devedor->dev_num = $dev_num;
		$devedor->dev_nome = $dev_nome;
		$devedor->tipo = $tipo;
		$devedor->cpf = $cpf;
		$devedor->outro_doc = $outro_doc;
		$devedor->dev_endereco = $dev_endereco;
		$devedor->dev_cep = $dev_cep;
		$devedor->dev_estado = $dev_estado;
		$devedor->dev_cidade = $dev_cidade;
		$devedor->num  = $num;
		$devedor->num_pro  = $num_pro;
		$devedor->oco_tipo  = $oco_tipo;
		$devedor->data_protocolo = $data_protocolo;
		$devedor->custas = $custas;
		$devedor->decla_portador = $decla_portador;
		$devedor->decla_ocorrencia = $decla_ocorrencia;
		$devedor->cod_irr = $cod_irr;
		$devedor->dev_bairro = $dev_bairro;
		$devedor->custas_cart = $custas_cart;
		$devedor->registro_distr = $registro_distr;
		$devedor->custas_gravacao = $custas_gravacao;
		$devedor->oper_banco = $oper_banco;
		$devedor->contrato_banco = $contrato_banco;
		$devedor->parcela_contrato = $parcela_contrato;
		$devedor->tipo_cam = $tipo_cam;
		$devedor->comp_irr = $comp_irr;
		$devedor->motivo_falencia = $motivo_falencia;
		$devedor->especie = $especie;
		$devedor->id_usuario = $controle_id_usuario;

		$protestoDAO  = new ProtestoDAO();
		$protestoDAO->inserirDevedor($devedor);

		$done=1;
	}
	if ($errors) { ?>
<div class="erro"><?php echo $error; ?></div>
	<?}
	if ($done) {
		//alterado 01/04/2011
		$titulo = 'Adicionar Protesto';
		$perg   = 'Novo registro adicionado com sucesso!\nAdicionar outro?';
		$resp1  = 'protesto_rem_add.php?id='.$id;
		$resp2  = 'protesto_rem.php?id='.$id;
		$funcJs = "openConfirmBox('".$titulo."','".$perg."','".$resp1."','".$resp2."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
}
?> <?	if (!$done) { ?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"
			name="protesto_add">
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados do Título</td>
			</tr>
			<tr>
				<td width="100">
				<div align="right"><strong>N. Título: </strong></div>
				</td>
				<td width="243"><input type="text" name="tit_num"
					value="<?= $tit_num ?>" maxlength="11" style="width: 200px"
					class="form_estilo" /></td>
				<td width="70">
				<div align="right"><strong>Endosso: </strong></div>
				</td>
				<td width="219"><select name="tipo_endosso" class="form_estilo"
					style="width: 150px">
					<option value="" <? if($tipo_endosso=='') echo ' selected '; ?>>Sem
					Endosso</option>
					<option value="T" <? if($tipo_endosso=='T') echo ' selected '; ?>>Endosso
					Translativo</option>
					<option value="M" <? if($tipo_endosso=='M') echo ' selected '; ?>>Endosso
					Mandato</option>
				</select></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Emissão: </strong></div>
				</td>
				<td><input type="text" name="data_emissao"
					value="<?= $data_emissao ?>"
					onKeyUp="masc_numeros(this,'##/##/####');" style="width: 200px"
					class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Vencimento: </strong></div>
				</td>
				<td><input type="text" name="data_vencimento"
					value="<?= $data_vencimento ?>"
					onKeyUp="masc_numeros(this,'##/##/####');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Valor: </strong></div>
				</td>
				<td><input type="text" name="valor" value="<?= $valor ?>"
					style="width: 200px" onKeyUp="masc_numeros(this,'##############');"
					class="form_estilo" />(Digitar as casas decimais)</td>
				<td>
				<div align="right"><strong>Saldo: </strong></div>
				</td>
				<td><input type="text" name="saldo" value="<?= $saldo ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'##############');"
					class="form_estilo" />(Digitar as casas decimais)</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Aceite: </strong></div>
				</td>
				<td><select name="aceite" class="form_estilo" style="width: 200px">
					<option value="A" <? if($aceite=='A') echo ' selected '; ?>>Aceitos</option>
					<option value="N" <? if($aceite=='N') echo ' selected '; ?>>Não
					Aceitos</option>
				</select></td>
				<td>
				<div align="right"><strong>Praça: </strong></div>
				</td>
				<td><input type="text" name="praca_pagamento"
					value="<?= $praca_pagamento ?>" maxlength="20" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Espécie: </strong></div>
				</td>
				<td><input type="text" name="especie" value="<?= $especie ?>"
					maxlength="3" style="width: 200px" class="form_estilo" /></td>
				<td colspan="2">
				<div align="left"><strong>Qtdd de Devedores ou Endereços: </strong>
				<input type="text" name="dev_num" value="<?= $dev_num ?>"
					onKeyUp="masc_numeros(this,'#');" style="width: 45px"
					class="form_estilo" />
				
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Nosso Número: </strong></div>
				</td>
				<td><input type="text" name="nosso_numero" value="<?= $nosso_numero ?>"
					maxlength="15" style="width: 200px" class="form_estilo" /></td>
				<td colspan="2">				
				</td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Devedor</td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="dev_nome"
					value="<?= $dev_nome ?>" maxlength="45" style="width: 470px"
					class="form_estilo"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tipo: </strong></div>
				</td>
				<td>
				<div style="float: left"><? if($tipo=='') $tipo='cpf'; ?> <select
					name="tipo" style="width: 55px; float: left" class="form_estilo">
					<option value="cpf"
					<? if($tipo=='cpf') echo 'selected="selected"'; ?>>CPF</option>
					<option value="cnpj"
					<? if($tipo=='cnpj') echo 'selected="selected"'; ?>>CNPJ</option>
				</select>
				<div id="cpf" style="float: left"></div>
				<div id="carrega_dados" style="visibility: hidden; float: left"></div>
				<script type="text/javascript">
                carrega_cpf('<?= $tipo ?>', '<?= $cpf ?>'); 
            </script></div>

				</td>
				<td>
				<div align="right"><strong>Outro Doc.:</strong></div>
				</td>
				<td><input type="text" name="outro_doc" style="width: 150px"
					value="<?= $outro_doc ?>" maxlength="11" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Cep: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="dev_cep"
					value="<?= $dev_cep ?>" onKeyUp="masc_numeros(this,'#####-###');"
					style="width: 200px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endereço: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="dev_endereco"
					value="<?= $dev_endereco ?>" maxlength="45" style="width: 470px"
					class="form_estilo"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input type="text" name="dev_bairro" style="width: 200px"
					value="<?= $dev_bairro ?>" maxlength="20" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Cidade:</strong></div>
				</td>
				<td><input type="text" name="dev_cidade" style="width: 150px"
					value="<?= $dev_cidade ?>" maxlength="20" class="form_estilo" /></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="dev_estado" style="width: 50px"
					value="<?= $dev_estado ?>" maxlength="2" class="form_estilo"
					maxlength="2" /></td>
				<td>
				<div align="right"></div>
				</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td colspan="4" class="tabela_tit">Cartório</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Número:</strong></div>
				</td>
				<td><input type="text" name="num" value="<?= $num ?>"
					onKeyUp="masc_numeros(this,'##');" style="width: 50px"
					class="form_estilo" /> <strong>Protocolo: <input type="text"
					name="num_pro" value="<?= $num_pro ?>" maxlength="10"
					style="width: 100px" class="form_estilo" /> </strong></td>
				<td>
				<div align="right"><strong>Data do P.:</strong></div>
				</td>
				<td><input type="text" name="data_protocolo" style="width: 150px"
					value="<?= $data_protocolo ?>"
					onKeyUp="masc_numeros(this,'##/##/####');" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Custas: </strong></div>
				</td>
				<td><input type="text" name="custas" value="<?= $custas ?>"
					style="width: 200px" onKeyUp="masc_numeros(this,'##########');"
					class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Custa do Cart. dist.: </strong></div>
				</td>
				<td><input type="text" name="custas_cart"
					value="<?= $custas_cart ?>" style="width: 150px"
					onKeyUp="masc_numeros(this,'##########');" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Declaração do Portador: </strong></div>
				</td>
				<td><input type="text" name="decla_portador"
					value="<?= $decla_portador ?>" maxlength="1" style="width: 200px"
					maxlength="1" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Ocorrência.: </strong></div>
				</td>
				<td><input type="text" name="data_ocorrencia"
					value="<?= $data_ocorrencia ?>"
					onKeyUp="masc_numeros(this,'##/##/####');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tipo da Ocorr.: </strong></div>
				</td>
				<td><input type="text" name="oco_tipo" value="<?= $oco_tipo ?>"
					maxlength="1" style="width: 200px" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Registro de Distr.: </strong></div>
				</td>
				<td><input type="text" name="registro_distr"
					value="<?= $registro_distr ?>"
					onKeyUp="masc_numeros(this,'######');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Cod. de Irregularidade: </strong></div>
				</td>
				<td><input type="text" name="cod_irr" value="<?= $cod_irr ?>"
					style="width: 200px" maxlength="2" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Complemento Irregularidade: </strong></div>
				</td>
				<td><input type="text" name="comp_irr" value="<?= $comp_irr ?>"
					maxlength="8" style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tipo de Cambio:</strong></div>
				</td>
				<td><input type="text" name="tipo_cam" value="<?= $tipo_cam ?>"
					style="width: 200px" maxlength="1" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>N. Operação do Banco: </strong></div>
				</td>
				<td><input type="text" name="oper_banco" value="<?= $oper_banco ?>"
					onKeyUp="masc_numeros(this,'#####');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>N. Contrato do Banco:</strong></div>
				</td>
				<td><input type="text" name="contrato_banco"
					value="<?= $contrato_banco ?>"
					onKeyUp="masc_numeros(this,'###############');"
					style="width: 200px" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>N. Parcela do Contrato: </strong></div>
				</td>
				<td><input type="text" name="parcela_contrato"
					value="<?= $parcela_contrato ?>"
					onKeyUp="masc_numeros(this,'###');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td></td>
				<td>
				<div class="form_estilo" style="width: 200px"><input type="checkbox"
					name="motivo_falencia"
					<? if($motivo_falencia=='on') echo 'checked="checked"'; ?> /> <strong>Motivo
				de Falência</strong></div>
				</td>
				<td>
				<div align="right"><strong>Custa de Gravação: </strong></div>
				</td>
				<td><input type="text" name="custas_gravacao"
					value="<?= $custas_gravacao ?>"
					onKeyUp="masc_numeros(this,'##########');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>

			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Adicionar" class="button_busca" />&nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.protesto_add.action='protesto_rem.php?id=<?=$id?>'"
					class="button_busca" /> <input type="hidden" name="id_protesto"
					value="<?= $id ?>" /></div>
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
