<?
require('header.php');
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
pt_register('POST','submit');
$protestoDAO = new ProtestoDAO();

if ($submit) {//check for errors
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','id_protesto');
	pt_register('POST','id_protesto_rem');
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

	$data_emissao 		= invert($data_emissao,'-','SQL');
	$data_vencimento 	= invert($data_vencimento,'-','SQL');
	$data_protocolo 	= invert($data_protocolo,'-','SQL');
	$data_ocorrencia 	= invert($data_ocorrencia,'-','SQL');

	$devedor = new stdClass();
	$devedor->id_protesto_rem = $id_protesto_rem;
	$devedor->tit_num = $tit_num;
	$devedor->nosso_numero = $nosso_numero;
	$devedor->data_emissao = $data_emissao;
	$devedor->data_vencimento = $data_vencimento;
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
	$devedor->data_ocorrencia = $data_ocorrencia;
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
	$devedor->tipo_cam = $tipo_cam;
	$devedor->comp_irr = $comp_irr;
	$devedor->motivo_falencia = $motivo_falencia;
	$devedor->especie = $especie;
	$devedor->parcela_contrato = $parcela_contrato;
	$devedor->id_usuario = $controle_id_usuario;

	if ($errors!=1) {
		$protestoDAO->atualizaDevedor($devedor,$controle_id_empresa);
		$done = 1;
	}
	?>
<table border="0">
	<tr>
		<td valign="top"><?
		if ($errors) {
			echo $error;
		}
		if ($done) {
		//alterado 01/04/2011
		$titulo = 'Mensagem da página web';
		$msg    = 'Registro editado com sucesso!';
		$pagina = 'protesto_rem.php?id='.$id_protesto;
		$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
		}?></td>
	</tr>
</table>
		<?
}
if (!$done) {
	$id				= $_GET["id"];
	$devedor = $protestoDAO->buscaDevedorPorId($id,$controle_id_empresa);
}
?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

		<form enctype="multipart/form-data" action="" method="post"
			name="protesto_add"><input type="hidden" name="id_protesto"
			value="<?= $devedor->id_protesto ?>" />
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados do Título</td>
			</tr>
			<tr>
				<td width="100">
				<div align="right"><strong>N. Título: </strong></div>
				</td>
				<td width="243"><input type="text" name="tit_num"
					value="<?=$devedor->tit_num ?>" maxlength="11" style="width: 200px"
					class="form_estilo" /></td>
				<td width="70">
				<div align="right"><strong>Endosso: </strong></div>
				</td>
				<td width="219"><select name="tipo_endosso" class="form_estilo"
					style="width: 150px">
					<option value=""
					<? if($devedor->tipo_endosso=='') echo ' selected '; ?>>Sem
					Endosso</option>
					<option value="T"
					<? if($devedor->tipo_endosso=='T') echo ' selected '; ?>>Endosso
					Translativo</option>
					<option value="M"
					<? if($devedor->tipo_endosso=='M') echo ' selected '; ?>>Endosso
					Mandato</option>
				</select></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Emissão: </strong></div>
				</td>
				<td><input type="text" name="data_emissao"
					value="<?=invert($devedor->data_emissao,'/','PHP') ?>"
					onKeyUp="masc_numeros(this,'##/##/####');" style="width: 200px"
					class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Vencimento: </strong></div>
				</td>
				<td><input type="text" name="data_vencimento"
					value="<?=invert($devedor->data_vencimento,'/','PHP') ?>"
					onKeyUp="masc_numeros(this,'##/##/####');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Valor: </strong></div>
				</td>
				<td><input type="text" name="valor" value="<?=$devedor->valor ?>"
					onKeyUp="masc_numeros(this,'##############');" style="width: 200px"
					class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Saldo: </strong></div>
				</td>
				<td><input type="text" name="saldo" value="<?=$devedor->saldo ?>"
					onKeyUp="masc_numeros(this,'##############');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Aceite: </strong></div>
				</td>
				<td><select name="aceite" class="form_estilo" style="width: 200px">
					<option value="A"
					<? if($devedor->aceite=='A') echo ' selected '; ?>>Aceitos</option>
					<option value="N"
					<? if($devedor->aceite=='N') echo ' selected '; ?>>Não Aceitos</option>
				</select></td>
				<td>
				<div align="right"><strong>Praça: </strong></div>
				</td>
				<td><input type="text" name="praca_pagamento"
					value="<?=$devedor->praca_pagamento ?>" maxlength="20"
					style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Espécie: </strong></div>
				</td>
				<td><input type="text" name="especie"
					value="<?=$devedor->especie ?>" maxlength="3" style="width: 200px"
					class="form_estilo" /></td>
				<td colspan="2">
				<div align="left"><strong>Qtde de Devedores ou Endereços: </strong>
				<input type="text" name="dev_num" value="<?=$devedor->dev_num ?>"
					onKeyUp="masc_numeros(this,'#');" style="width: 45px"
					class="form_estilo" /></div>				
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Nosso Número: </strong></div>
				</td>
				<td><input type="text" name="nosso_numero" value="<?= $devedor->nosso_numero ?>"
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
					value="<?=$devedor->dev_nome ?>" maxlength="45"
					style="width: 470px" class="form_estilo"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tipo: </strong></div>
				</td>
				<td>
				<div style="float: left"><? if($devedor->tipo=='') $devedor->tipo='cpf'; ?>
				<select name="tipo" style="width: 55px; float: left"
					class="form_estilo">
					<option value="cpf"
					<? if($devedor->tipo=='cpf') echo 'selected="selected"'; ?>>CPF</option>
					<option value="cnpj"
					<? if($devedor->tipo=='cnpj') echo 'selected="selected"'; ?>>CNPJ</option>
				</select>
				<div id="cpf" style="float: left"></div>
				<div id="carrega_dados" style="visibility: hidden; float: left"></div>
				<script type="text/javascript">
                carrega_cpf('<?=$devedor->tipo ?>', '<?=$devedor->cpf ?>'); 
            </script></div>

				</td>
				<td>
				<div align="right"><strong>Outro Doc.:</strong></div>
				</td>
				<td><input type="text" name="outro_doc" style="width: 150px"
					value="<?=$devedor->outro_doc ?>" maxlength="11"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Cep: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="dev_cep"
					value="<?=$devedor->dev_cep ?>"
					onKeyUp="masc_numeros(this,'#####-###');" style="width: 200px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endereço: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="dev_endereco"
					value="<?=$devedor->dev_endereco ?>" maxlength="45"
					style="width: 470px" class="form_estilo"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input type="text" name="dev_bairro" style="width: 200px"
					value="<?=$devedor->dev_bairro ?>" maxlength="20"
					class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Cidade:</strong></div>
				</td>
				<td><input type="text" name="dev_cidade" style="width: 150px"
					value="<?=$devedor->dev_cidade ?>" maxlength="20"
					class="form_estilo" /></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="dev_estado" style="width: 50px"
					value="<?=$devedor->dev_estado ?>" maxlength="2"
					class="form_estilo" maxlength="2" /></td>
				<td>
				<div align="right"></div>
				</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td colspan="4" class="tabela_tit">Cart&oacute;rio</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>N&uacute;mero:</strong></div>
				</td>
				<td><input type="text" name="num" value="<?= $devedor->num ?>"
					onKeyUp="masc_numeros(this,'##');" style="width: 50px"
					class="form_estilo" /> <strong>Protocolo: <input type="text"
					name="num_pro" value="<?=$devedor->num_pro ?>" maxlength="10"
					style="width: 100px" class="form_estilo" /> </strong></td>
				<td>
				<div align="right"><strong>Data do P.:</strong></div>
				</td>
				<td><input type="text" name="data_protocolo" style="width: 150px"
					value="<?=invert($devedor->data_protocolo,'/','PHP')?>"
					onKeyUp="masc_numeros(this,'##/##/####');" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Custas: </strong></div>
				</td>
				<td><input type="text" name="custas" value="<?=$devedor->custas ?>"
					onKeyUp="masc_numeros(this,'##########');" style="width: 200px"
					class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Custa do Cart. dist.: </strong></div>
				</td>
				<td><input type="text" name="custas_cart"
					value="<?=$devedor->custas_cart ?>"
					onKeyUp="masc_numeros(this,'##########');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Declaração do Portador: </strong></div>
				</td>
				<td><input type="text" name="decla_portador"
					value="<?=$devedor->decla_portador ?>" style="width: 200px"
					maxlength="1" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Ocorr&ecirc;ncia.: </strong></div>
				</td>
				<td><input type="text" name="data_ocorrencia"
					value="<?=invert($devedor->data_ocorrencia,'/','PHP');?>"
					onKeyUp="masc_numeros(this,'##/##/####');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tipo da Ocorr.: </strong></div>
				</td>
				<td><input type="text" name="oco_tipo"
					value="<?=$devedor->oco_tipo ?>" style="width: 200px" maxlength="1"
					class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Registro de Distr.: </strong></div>
				</td>
				<td><input type="text" name="registro_distr"
					value="<?=$devedor->registro_distr ?>"
					onKeyUp="masc_numeros(this,'######');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Cod. de Irregularidade: </strong></div>
				</td>
				<td><input type="text" name="cod_irr"
					value="<?=$devedor->cod_irr ?>" style="width: 200px" maxlength="2"
					class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Complemento Irregularidade: </strong></div>
				</td>
				<td><input type="text" name="comp_irr"
					value="<?=$devedor->comp_irr ?>" maxlength="8" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tipo de Cambio:</strong></div>
				</td>
				<td><input type="text" name="tipo_cam"
					value="<?=$devedor->tipo_cam ?>" maxlength="1" style="width: 200px"
					class="form_estilo" /></td>
				<td>
				<div align="right"><strong>N. Operação do Banco: </strong></div>
				</td>
				<td><input type="text" name="oper_banco"
					value="<?=$devedor->oper_banco ?>"
					onKeyUp="masc_numeros(this,'#####');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>N. Contrato do Banco:</strong></div>
				</td>
				<td><input type="text" name="contrato_banco"
					value="<?=$devedor->contrato_banco ?>"
					onKeyUp="masc_numeros(this,'###############');"
					style="width: 200px" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>N. Parcela do Contrato: </strong></div>
				</td>
				<td><input type="text" name="parcela_contrato"
					value="<?=$devedor->parcela_contrato ?>"
					onKeyUp="masc_numeros(this,'###');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td></td>
				<td>
				<div class="form_estilo" style="width: 200px"><input type="checkbox"
					name="motivo_falencia"
					<? if($devedor->motivo_falencia=='on') echo 'checked="checked"'; ?> />
				<strong>Motivo de Falência</strong></div>
				</td>
				<td>
				<div align="right"><strong>Custa de Gravação: </strong></div>
				</td>
				<td><input type="text" name="custas_gravacao"
					value="<?=$devedor->custas_gravacao ?>"
					onKeyUp="masc_numeros(this,'##########');" style="width: 150px"
					class="form_estilo" /></td>
			</tr>

			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Atualizar" class="button_busca" />&nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.protesto_add.action='protesto_rem.php?id=<?=$devedor->id_protesto?>'"
					class="button_busca" /> <input type="hidden" name="id_protesto_rem"
					value="<?= $id ?>" /></div>
				</td>
			</tr>
		</table>
		<div id="resgata_endereco"></div>
		</form>
		</td>
	</tr>
</table>
</div>
<?php
require('footer.php');
?>
