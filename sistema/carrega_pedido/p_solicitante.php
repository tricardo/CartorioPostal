<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );
	pt_register('GET','id_pedido');
	pt_register('GET','ordem');
	$pedidoDAO = new PedidoDAO();
	$financeiroDAO = new FinanceiroDAO();
	$p = $pedidoDAO->selectPedidoPorId($id_pedido,$ordem,$controle_id_empresa);
	
	$departamento_s = explode(',' ,$controle_id_departamento_s);
	$departamento_p = explode(',' ,$controle_id_departamento_p);
	$pedidoverificaDAO = new PedidoVerificaDAO();
	$verifica = $pedidoverificaDAO->verificaAlteracaoSolicitante($departamento_p,$departamento_s,$p->id_status,$p->inicio);
	
	if($verifica==TRUE){
		$atualiza_solicitante='';
	}else{
		$atualiza_solicitante='Não';
	}

	if($p->id_empresa_resp<>'' and $p->id_empresa_resp==$controle_id_empresa){ 
		echo "<div>Somente o responsável pelo cadastro pode visualizar o solicitante!<br><br><br></div>";
	} 
	if($p->id_conveniado<>'0') {
		$conveniado = 'Conveniado'; 
	} else {
		$conveniado='Não Conveniado';
		$p->id_conveniado = '';
	}	
	?>
	<form action="#aba1" method="post" name="p_solicitante" id="p_solicitante" enctype="multipart/form-data">
	<input readonly readonly type="hidden" name="solicitante" value="1">
	<div style="<? if($p->id_empresa_resp<>'' and $p->id_empresa_resp==$controle_id_empresa) echo "visibility:'hidden'; display:none"; ?>">
	
	<table width="800" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Dados do Solicitante</td>
			</tr>
			<tr>
				<td style="width:150px">
				<div align="right"><strong>CPF/CNPJ: </strong></div>
				</td>
				<td style="width:225px">
				<div style="float: left">
				<select disabled name="tipo" class="form_estilo_r">
					<option value="cpf" <? if($p->tipo=='cpf') echo 'selected="selected"'; ?>>CPF</option>
					<option value="cnpj" <? if($p->tipo=='cnpj') echo 'selected="selected"'; ?>>CNPJ</option>
				</select>
				</div>
				<div id="cpf" style="float: left">
					<input readonly type="text" name="cpf" value="<?= $p->cpf ?>" style="width:140px" onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'##.###.###/####-##');" class="form_estilo_r"/>
				</div>
				</td>
				<td  style="width:120px">
					<input readonly	type="hidden" name="id_conveniado" value="<?= $p->id_conveniado ?>" />
				</td>
				<td style="width:305px">
					<input readonly type="text" name="conveniado" value="<?= $conveniado.'  '.$p->id_conveniado ?>" style="width:150px" class="form_estilo_r" />
				</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3">
					<input readonly type="text" name="nome" value="<?= $p->nome ?>" style="width: 500px" class="form_estilo_r">
					<font color="#FF0000">*</font>
				</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>RG/IE:</strong></div>
				</td>
				<td>
					<input readonly type="text" name="rg" value="<?= $p->rg ?>" style="width: 150px"  class="form_estilo_r"/>
				</td>
				<td>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>Contato: </strong></div>
				</td>
				<td colspan="3">
					<input readonly type="text" name="contato" value="<?= $p->contato ?>" style="width: 500px" class="form_estilo_r">
				</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>RG/IE do Contato:</strong></div>
				</td>
				<td>
					<input readonly type="text" name="contato_rg" value="<?= $p->contato_rg ?>" style="width: 150px"  class="form_estilo_r"/>
				</td>
				<td>
					<div align="right"><strong>Origem:</strong></div>
				</td>
				<td>
					<select  disabled name="origem" style="width: 150px" class="form_estilo_r" onchange="javascript:if(this.value=='Ponto de Venda'){ document.getElementById('id_ponto').style.visibility='visible'; carrega_pontodevenda(this.value);} else { document.getElementById('id_ponto').style.visibility='hidden'; id_ponto.value=''; }">
						<option value="<?= $p->origem ?>"><?= $p->origem ?></option>
					</select> 
					<font color="#FF0000">*</font>
				</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>Retem ISS</strong></div>
				</td>
				<td>
					<div style="width: 150px" class="form_estilo_r">
						<input  disabled type="checkbox" <? if($p->retem_iss=='on') echo 'checked="checked"'; ?> name="retem_iss" /> <strong>Retem ISS</strong>
					</div>
				</td>
				<td></td>
				<td>
					<select  disabled name="id_ponto" id="id_ponto" style="width:150px; <? if($p->origem!='Ponto de Venda') echo "visibility:hidden";?> " class="form_estilo_r">
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>Tem Restrição:</strong></div>
				</td>
				<td>
					<div style="width: 150px" class="form_estilo_r">
						<input  disabled type="checkbox" <? if($p->restricao=='on') echo 'checked="checked"'; ?> name="restricao" /> <strong>Tem restrição</strong>
					</div>
				</td>
				<td></td>
				<td>
					<div style="width: 150px" class="form_estilo_r">
						<input  disabled type="checkbox" <? if($p->retirada=='on') echo 'checked="checked"'; ?> name="retirada" />
						<strong>Retirar no Balcão</strong>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>Pacote:</strong></div>
				</td>
				<td>
					<select  disabled name="id_pacote" style="width: 150px" class="form_estilo_r">
						<option value="" <? if($p->id_pacote=='') echo ' selected="selected" '; ?>>Sem Pacote</option>
						<?
						$p_valor = "";
						$pacote = $financeiroDAO->listarPacote();
						foreach($pacote as $pacote){
							$p_valor .= '<option value="'.$pacote->id_pacote.'"';
							if($p->id_pacote==$pacote->id_pacote) $p_valor .= ' selected="selected" ';
							$p_valor .=  ' >'.$pacote->pacote.'</option>';
						}
						echo $p_valor;
						?>
					</select>
				</td>
				<td>
					<div align="right"><strong>Forma Pagamento:</strong></div>
				</td>
				<td>
					<select  disabled name="forma_pagamento" style="width: 150px" class="form_estilo_r ">
						<option value="<?= $p->forma_pagamento ?>"><?= $p->forma_pagamento ?></option>
					</select> 
					<font color="#FF0000">*</font>
				</td>
			</tr>
			<? if($p->forma_pagamento=='Depósito') { ?>
				<tr id="tr_dados_bancarios">
					<td></td>
					<td></td>
					<td align="right"><strong>Dados do Depósito:</strong></td>
					<td><input type="text" name="dados_bancarios" id="dados_bancarios" class="form_estilo_r" readonly style="width:150px" value="<?php echo $p->dados_bancarios?>"/></td>
				</tr>
			<? } ?>
			<tr>
				<td>
					<div align="right"><strong>Tel: </strong></div>
				</td>
				<td>
					<input readonly type="text" name="tel" value="<?= $p->tel ?>" style="width: 150px" onKeyUp="if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'(##) ####-####');"  class="form_estilo_r"/> - 
					<input readonly type="text" name="ramal" value="<?= $p->ramal ?>" style="width: 50px" onkeyup="masc_numeros(this,'####');"  class="form_estilo_r"/>
				</td>
				<td>
					<div align="right"><strong>Fax: </strong></div>
				</td>
				<td>
					<input readonly type="text" name="fax" value="<?= $p->fax ?>" style="width: 150px" onKeyUp="if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'(##) ####-####');"  class="form_estilo_r"/>
				</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>Tel/Cel: </strong></div>
				</td>
				<td>
					<input readonly type="text" name="tel2" value="<?= $p->tel2 ?>" style="width: 150px" onKeyUp="if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'(##) ####-####');"  class="form_estilo_r"/> - 
					<input readonly type="text" name="ramal2" value="<?= $p->ramal2 ?>" style="width: 50px" onkeyup="masc_numeros(this,'####');"  class="form_estilo_r"/></td>
				<td>
					<div align="right"><strong>Outros: </strong></div>
				</td>
				<td>
					<input readonly type="text" name="outros" value="<?= $p->outros ?>" style="width: 150px" class="form_estilo_r" />
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Email: </strong></div>
				</td>
				<td colspan="3">
					<input readonly type="text" name="email"	value="<?= $p->email ?>" style="width: 500px"  class="form_estilo_r"/>
				</td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço de Entrega</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3">
					<div style="float:left">
						<input readonly type="text" name="cep" style="width:150px" value="<?= $p->cep ?>" class="form_estilo_r" onKeyUp="if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'#####-###');" /> <font color="#FF0000">*</font>
					</div>
					<div style="width: 230px; float:left; margin-left:5px; ">
						<input  disabled	type="checkbox" <? if($p->omesmo=='on') echo 'checked="checked"'; ?> onchange="javascript:faturar_mesmoendereco_edit(this.checked);" name="omesmo" /> <strong>Faturar para o mesmo endereço</strong>
					</div>
					</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>Endereço: </strong></div>
				</td>
				<td colspan="3">
					<input readonly type="text" name="endereco" value="<?= $p->endereco ?>" style="width: 380px" class="form_estilo_r" /> 
					<strong>N&deg;</strong> 
					<input readonly type="text" name="numero" style="width:95px" value="<?= $p->numero ?>" class="form_estilo_r" /> <font color="#FF0000">*</font>
				</td>
			</tr>
			<tr>
				<td>
					<div align="right"><strong>Complemento: </strong></div>
				</td>
				<td>
					<input readonly type="text" name="complemento" style="width: 200px" value="<?= $p->complemento ?>"  class="form_estilo_r"/>
				</td>
				<td>
					<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td>
					<input readonly type="text" name="bairro" style="width: 150px" value="<?= $p->bairro ?>" class="form_estilo_r"/> <font color="#FF0000">*</font>
				</td>
			</tr>

			<tr>
				<td>
					<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td>
					<input readonly type="text" name="cidade" style="width: 200px" value="<?= $p->cidade ?>" class="form_estilo_r"/> <font color="#FF0000">*</font>
				</td>
				<td>
					<div align="right"><strong>Estado:</strong></div>
				</td>
				<td>
					<input readonly type="text" name="estado" style="width: 150px" value="<?= $p->estado ?>" class="form_estilo_r" maxlength="2" /> <font color="#FF0000">*</font>
				</td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endereço de Faturamento</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3">
				<div style="float: left">
					<input readonly type="text" name="cep_f" style="width: 150px" value="<?= $p->cep_f ?>"  onKeyUp="if(<?= $controle_id_pais ?>=='32')masc_numeros(this,'#####-###');" class="form_estilo_r" />
				</div>
				</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input readonly type="text" name="endereco_f" class="form_estilo_r" value="<?= $p->endereco_f ?>" style="width: 380px" /> <strong>N&deg;</strong> 
					<input readonly
					type="text" name="numero_f" style="width: 95px"
					value="<?= $p->numero_f ?>"  class="form_estilo_r" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Complemento: </strong></div>
				</td>
				<td><input readonly type="text" name="complemento_f" style="width: 200px"
					value="<?= $p->complemento_f ?>"  class="form_estilo_r" /></td>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input readonly type="text" name="bairro_f" style="width: 150px"
					value="<?= $p->bairro_f ?>"  class="form_estilo_r" /></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input readonly type="text" name="cidade_f" style="width: 200px"
					value="<?= $p->cidade_f ?>"  class="form_estilo_r" /> </td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input readonly type="text" name="estado_f" style="width: 150px"
					value="<?= $p->estado_f ?>"  class="form_estilo_r" maxlength="2" /></td>
			</tr>
		</table>
		</div>
		</form>
		<script type="text/javascript">
			<?
			if($p->origem=='Ponto de Venda') echo "carrega_pontodevenda('".$p->id_ponto."'); ";
			if($p->omesmo=='on') echo "faturar_mesmoendereco_edit('TRUE'); ";
			?>
		</script>