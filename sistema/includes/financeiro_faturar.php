<?
setcookie ("fat_id_pedido_item", $_COOKIE['p_id_pedido_item']);

$cont=0;
$financeiro_divisao="";
$pedido_valor ="";

$im = str_replace(',',"','",str_replace(',##',"","'".htmlentities($_COOKIE['p_id_pedido_item'])."##")."'");

$lista = $financeiroDAO->listaPedidoIn2($im,$controle_id_empresa);

foreach($lista as $l){
	#fim da verificacao permissao
	$custa_l = $financeiroDAO->somaPedidoItemDesembolso($l->id_pedido_item,$controle_id_empresa);
	$pedido_valor .= '
		<tr>
            <td><label><strong>Pedido: </label></td>
            <td>
				#'.$l->id_pedido.'/'.$l->ordem.'
		    </td>
            <td><div align="right"><strong>Honorário: </strong></div></td>
            <td>
                <input type="text" class="form_estilo" name="fin_valor_'.$l->id_pedido_item.'" maxlength="10" value="'.$l->valor.'" id="fin_valor_'.$l->id_pedido_item.'"  onkeyup="moeda(event.keyCode,this.value,\'fin_valor_'.$l->id_pedido_item.'\');"  style="width:70px" />	
		    </td>
            <td><div align="right"><strong>Custas: </strong></div></td>
            <td>
                <input type="text" class="form_estilo" name="fin_custa_'.$l->id_pedido_item.'" maxlength="10" id="fin_custa_'.$l->id_pedido_item.'" value="'.$custa_l->total.'"  onkeyup="moeda(event.keyCode,this.value,\'fin_custa_'.$l->id_pedido_item.'\');"  style="width:70px" />
				Formato ####.##
		    </td>
            <td><div align="right"><strong>Recebido: </strong></div></td>
            <td>
                <input type="text" class="form_estilo_r" name="fin_rec_'.$l->id_pedido_item.'" maxlength="10" value="'.$l->valor_rec.'" style="width:70px" />
			</td>
		</tr>';
	$financeiro_divisao++;
	$cont++;
}

if($_SESSION['fat_cpf']==''){
	$fat_fatura->cpf=$lista[0]->cpf;
	if($lista[0]->tipo=='cpf') $fat_fatura->tipo=1;
	else $fat_fatura->tipo=2;
	
	$fat_fatura->sacado=$lista[0]->nome;
	$fat_fatura->endereco=$lista[0]->endereco;
	$fat_fatura->bairro=$lista[0]->bairro;
	$fat_fatura->cidade=$lista[0]->cidade;
	$fat_fatura->estado=$lista[0]->estado;
	if($lista[0]->numero) $fat_fatura->endereco .= ','.trim($lista[0]->numero);
	if($lista[0]->complemento) $fat_fatura->endereco .= '-'.trim($lista[0]->complemento);
	$fat_fatura->cep=$lista[0]->cep;
	$fat_fatura->vencimento=date('d/m/Y',strtotime("+10 day"));;
	$fat_fatura->juros_mora='10';
	$fat_fatura->mensagem1='';
	$fat_fatura->mensagem2='';
	$fat_fatura->emissao_papeleta=2;
	$fat_fatura->especie=12;
	$fat_fatura->aceite='N';
}else{
	$fat_fatura = $_SESSION['fat_fatura'];
}
#alteração de status
?>
<form enctype="multipart/form-data" action="" method="POST" name="form_faturar" class="form_auto">
	<input type="hidden" name="financeiro_divisao" value="<?= $financeiro_divisao ?>"/>
	<table style="margin:auto; width:800px" cellpadding="4" cellspacing="1" class="result_tabela">
	<tr>
		<td colspan="8" class="tabela_tit">Faturar</td>
	</tr>
	<tr>
		<td colspan="7">
			<label>Fatura:</label>
			<select name="acao"  class="form_estilo" style=" width:250px; ">
				<option value="1" <? if($_SESSION['acao']=='1') echo 'selected="select"'; ?>>Fatura de Honorário + Custas</option>
				<option value="2" <? if($_SESSION['acao']=='2') echo 'selected="select"'; ?>>Fatura de Honorário - Custas</option>
				<option value="3" <? if($_SESSION['acao']=='3') echo 'selected="select"'; ?>>Fatura de Honorário</option>
				<option value="4" <? if($_SESSION['acao']=='4') echo 'selected="select"'; ?>>Fatura de Honorário + Recibo de Custas</option>
			</select>
			<label for="retem_imposto">Retenção: </label>
			<select name="retem_imposto" id="retem_imposto"  class="form_estilo" style=" width:200px; ">
				<option value="" 
				<? if($retem_imposto=='') echo 'selected="select"'; ?>>Não reter</option>
				<? if($fat_fatura->tipo==2){ ?>
					<option value="1.5" <? if($retem_imposto=='1.5') echo 'selected="select"'; ?>>1,5% Acima de R$ 666,67</option>
					<option value="6.15" <? if($retem_imposto=='6.15') echo 'selected="select"'; ?>>6,15% Acima de R$ 5000,01</option>
					<option value="4.8" <? if($retem_imposto=='4.8') echo 'selected="select"'; ?>>4,8% Até R$ 5000,00 para Governo</option>
					<option value="9.45" <? if($retem_imposto=='9.45') echo 'selected="select"'; ?>>9,45% Acima de R$ 5000,01 para Governo</option>
				<? } ?>
			</select>

			<label style="clear:both">CPF/CNPJ: </label>
			<input type="text" id="cpf" maxlength="20" name="cpf" readonly value="<?= $fat_fatura->cpf ?>" class="form_estilo_r" style=" width:140px; " />
			<div class="form_estilo" style="width:250px; margin-left:5px">
				<input type="radio" name="boleto" value="0" <? if($_SESSION['boleto']==0 or $_SESSION['boleto']=='') echo 'checked="checked"' ?>/> <b>Emitir Boleto</b>
				<input type="radio" name="boleto" value="1" <? if($_SESSION['boleto']==1) echo 'checked="checked"' ?>/> <b>Não Emitir Boleto</b>
			</div>

			<label style="clear:both">Nota Fiscal: </label>
			<input type="text" name="id_nota"  onKeyUp="masc_numeros(this,'##########');" value="<?= $fat_fatura->id_nota ?>"  class="form_estilo<? if($error->id_nota<>'') echo '_erro'; ?>"  style="width:110px;"/>
			<div class="asterisco">*</div>

			<label for="id_conta">Banco: </label>
			<select name="id_conta" id="id_conta"  class="form_estilo<? if($error->id_conta<>'') echo '_erro'; ?>" style=" width:110px; ">
			<?
			$lista = $contaDAO->listarContaBoleto($controle_id_empresa);
			$p_valor = '';
			foreach($lista as $l){
				$p_valor .= '<option value="'.$l->id_conta.'"';
				if($l->id_conta==$id_conta) $p_valor .= 'selected="select"';
				$p_valor .= '>'.$l->sigla.'</option>';
			}
			echo $p_valor;
			?>
			</select>
			<div class="asterisco">*</div>
			<input type="hidden" name="tipo" value="<?= $fat_fatura->tipo ?>">
			
			<label for="sacado" style="clear:both">Sacado: </label>
			<input type="text" id="sacado" maxlength="40" name="sacado" value="<?= $fat_fatura->sacado ?>"  class="form_estilo<? if($error->sacado<>'') echo '_erro'; ?>" style=" width:550px; " /><div class="asterisco">*</div>
			
			<label for="endereco">Endereço: </label>
			<input type="text" id="endereco" maxlength="40" name="endereco" value="<?= $fat_fatura->endereco ?>"  class="form_estilo<? if($error->endereco<>'') echo '_erro'; ?>" style=" width:550px; " /><div class="asterisco">*</div>
			
			<label for="endereco">Bairro: </label>
			<input type="text" id="bairro" maxlength="70" name="bairro" value="<?= $fat_fatura->bairro ?>"  class="form_estilo<? if($error->bairro<>'') echo '_erro'; ?>" style=" width:150px; " /><div class="asterisco"></div>

			<label for="endereco">Cidade: </label>
			<input type="text" id="cidade" maxlength="70" name="cidade" value="<?= $fat_fatura->cidade ?>"  class="form_estilo<? if($error->cidade<>'') echo '_erro'; ?>" style=" width:150px; " /><div class="asterisco"></div>

			<label for="endereco">Estado: </label>
			<input type="text" id="estado" maxlength="2" name="estado" value="<?= $fat_fatura->estado ?>"  class="form_estilo<? if($error->estado<>'') echo '_erro'; ?>" style=" width:40px;" />

			<label for="cep">CEP: </label>
			<input type="text" id="cep" maxlength="9" name="cep" value="<?= $fat_fatura->cep ?>"  onKeyUp="masc_numeros(this,'#####-###');" class="form_estilo<? if($error->cep<>'') echo '_erro'; ?>" style=" width:150px; " /><div class="asterisco">*</div>
			
			<label for="vencimento">Vencimento: </label>
			<input type="text" id="vencimento" maxlength="10" name="vencimento" value="<?= $fat_fatura->vencimento ?>"  onKeyUp="masc_numeros(this,'##/##/####');" class="form_estilo<? if($error->vencimento<>'') echo '_erro'; ?>" style="width:150px;" /><div class="asterisco">*</div>

			<label for="juros_mora">Mora diária: </label>
			<input type="text" id="juros_mora" maxlength="10" name="juros_mora" value="<?= $fat_fatura->juros_mora ?>" onKeyUp="masc_numeros(this,'##');"  onkeyup="moeda(event.keyCode,this.value,'juros_valor');" class="form_estilo<? if($error->juros_valor<>'') echo '_erro'; ?>" style=" width:40px; " />

			<label for="instrucao1">Instrução 1: </label>
			<select name="instrucao1" id="instrucao1" onchange="if(this.value==6) instrucao2.value=5; else instrucao2.value='';" class="form_estilo<? if($error->instrucao1<>'') echo '_erro'; ?>" style=" width:552px; ">
			<option value="" ></option>
			<option value="6"<? if($fat_fatura->instrucao1=='6') echo 'selected="select"'; ?>>Protestar</option>
			<option value="8"<? if($fat_fatura->instrucao1=='8') echo 'selected="select"'; ?>>Não cobrar juros de mora</option>
			<option value="9"<? if($fat_fatura->instrucao1=='9') echo 'selected="select"'; ?>>Não receber após o vencimento</option>
			<option value="11"<? if($fat_fatura->instrucao1=='11') echo 'selected="select"'; ?>>Não receber após o 8º dia do vencimento</option>
			<option value="12"<? if($fat_fatura->instrucao1=='12' or $fat_fatura->instrucao1=='') echo 'selected="select"'; ?>>Cobrar encargos após o 5º dia do vencimento</option>
			<option value="13"<? if($fat_fatura->instrucao1=='13') echo 'selected="select"'; ?>>Cobrar encargos após o 10º dia do vencimento</option>
			<option value="14"<? if($fat_fatura->instrucao1=='14') echo 'selected="select"'; ?>>Cobrar encargos após o 15º dia do vencimento</option>
			</select><div class="asterisco">&nbsp;</div>

			
			<label for="instrucao2">Instrução 2: </label>
			<input type="text" id="instrucao2" maxlength="2" name="instrucao2" value="<?= $fat_fatura->instrucao2 ?>"  onKeyUp="masc_numeros(this,'##');" class="form_estilo<? if($error->instrucao2<>'') echo '_erro'; ?>" style=" width:110px; " /><div class="asterisco">&nbsp;</div>
			
			<label for="mensagem1">Mensagem 1: </label>
			<input type="text" id="mensagem1" maxlength="12" name="mensagem1" value="<?= $fat_fatura->mensagem1 ?>"  class="form_estilo<? if($error->mensagem1<>'') echo '_erro'; ?>" style=" width:334px; " /><div class="asterisco">&nbsp;</div>
			
			<label for="mensagem2">Mensagem 2: </label>
			<input type="text" id="mensagem2" maxlength="60" name="mensagem2" value="<?= $fat_fatura->mensagem2 ?>"  class="form_estilo<? if($error->mensagem2<>'') echo '_erro'; ?>" style=" width:550px; " /><div class="asterisco">&nbsp;</div>
			
			<label for="emissao_papeleta">Emitir Papeleta: </label>
			<select name="emissao_papeleta" id="emissao_papeleta"  class="form_estilo<? if($error->emissao_papeleta<>'') echo '_erro'; ?>" style=" width:110px; ">
			<option value="1"<? if($fat_fatura->emissao_papeleta=='1') echo 'selected="select"'; ?>>Pelo Banco</option>
			<option value="2"<? if($fat_fatura->emissao_papeleta=='2' or $fat_fatura->emissao_papeleta=='') echo 'selected="select"'; ?>>Pela Empresa</option>
			</select><div class="asterisco">*</div>
			
			<label for="especie">Espécie: </label>
			<select name="especie" id="especie"  class="form_estilo<? if($error->especie<>'') echo '_erro'; ?>" style=" width:187px; ">
				<option value="1"<? if($fat_fatura->especie=='1') echo 'selected="select"'; ?>>Duplicata</option>
				<option value="2"<? if($fat_fatura->especie=='2') echo 'selected="select"'; ?>>Nota Promissória</option>
				<option value="3"<? if($fat_fatura->especie=='3') echo 'selected="select"'; ?>>Nota de Seguro</option>
				<option value="4"<? if($fat_fatura->especie=='4') echo 'selected="select"'; ?>>Cobrança Seriada</option>
				<option value="5"<? if($fat_fatura->especie=='5') echo 'selected="select"'; ?>>Recibo</option>
				<option value="10"<? if($fat_fatura->especie=='10') echo 'selected="select"'; ?>>Letras de Câmbio</option>
				<option value="11"<? if($fat_fatura->especie=='11') echo 'selected="select"'; ?>>Nota de Débito</option>
				<option value="12"<? if($fat_fatura->especie=='12' or $fat_fatura->especie=='') echo 'selected="select"'; ?>>Duplicata de Serv.</option>
				<option value="99"<? if($fat_fatura->especie=='99') echo 'selected="select"'; ?>>Outros</option>
			</select><div class="asterisco">*</div>

			<label for="aceite">Aceite: </label>
			<select name="aceite" id="aceite"  class="form_estilo<? if($error->aceite<>'') echo '_erro'; ?>" style=" width:50px; ">
			<option value="A"<? if($fat_fatura->aceite=='A') echo 'selected="select"'; ?>>A</option>
			<option value="N"<? if($fat_fatura->aceite=='N' or $fat_fatura->aceite=='') echo 'selected="select"'; ?>>N</option>
			</select><div class="asterisco">*</div>

		</td>
		<td style="width:100px">
		</td>
	</tr>
	<?= $pedido_valor ?>
	<tr>
		<td colspan="8">
		<center>
			<input type="submit" class="button_busca" name="submit_faturar_aplica" value="Guardar Valores" />&nbsp; 
			<input type="submit" name="cancelar" value="Cancelar" onclick="document.form_faturar.action='financeiro_pagamento.php'" class="button_busca" />
		</center>
		</td>
	</tr>
</table>
</form>
</div>
<?
	require('footer.php');
	exit;
?>