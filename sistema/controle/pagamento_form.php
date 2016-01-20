<?php

pt_register("POST", "submit_inserir");
pt_register("POST", "submit_atualizar");
pt_register("POST", "submit_pagamento");
pt_register("GET", "id_pagamento");

$fornecedorDAO = new FornecedorDAO();
$financeiroDAO = new FinanceiroDAO();
$pagamentoDAO = new PagamentoDAO();
$bancoDAO = new BancoDAO();
$contaDAO = new ContaDAO();
$regimeDAO = new RegimeDAO();
$departamentoDAO = new DepartamentoDAO();
if($id_pagamento<>''){
	$p = $pagamentoDAO->buscaPorId($id_pagamento,$controle_id_empresa);
	$p->dt_pagamento_old = $p->dt_pagamento;
}
if($submit_inserir || $submit_atualizar || $submit_financeiro_pagamento){
	
	pt_register("POST", "id_holding");

	pt_register("POST", "nota");
	pt_register("POST", "id_regime");
	pt_register("POST", "id_planoconta");
	pt_register("POST", "cnpj");
	pt_register("POST", "valor_ir");
	pt_register("POST", "valor_pis");
	pt_register("POST", "valor_cofins");
	pt_register("POST", "fisico");
	
	pt_register("POST", "id_forma_pagamento");
	pt_register("POST", "id_fornecedor");
	pt_register("POST", "descricao");
	pt_register("POST", "id_banco");
	pt_register("POST", "agencia");
	pt_register("POST", "conta");
	pt_register("POST", "favorecido");
	pt_register("POST", "valor");
	pt_register("POST", "qt_parcelas");
	pt_register("POST", "parcela");
	pt_register("POST", "dt_vencimento");
	pt_register("POST", "dt_pagamento");
	pt_register("POST", "cod_barras");
	pt_register("POST", "vlr_multa");
	pt_register("POST", "desconto");
	pt_register("POST", "valor_pg");
	pt_register("POST", "id_departamento");
	pt_register("POST", "id_conta");
	
	$p->nota=$nota;
	$p->id_holding=$id_holding;
	$p->id_regime=$id_regime;
	$p->cnpj=$cnpj;
	$p->valor_ir=$valor_ir;
	$p->valor_pis=$valor_pis;
	$p->valor_cofins=$valor_cofins;
	$p->id_pagamento = $id_pagamento;
	$p->parcela = $parcela;
	$p->id_empresa = $controle_id_empresa;
	$p->id_forma_pagamento = $id_forma_pagamento;
	$p->descricao = $descricao;
	$p->id_fornecedor = $id_fornecedor;
	$p->id_banco = $id_banco;
	$p->agencia = $agencia;
	$p->conta = $conta;
	$p->favorecido = $favorecido;
	$p->valor = $valor;
	$p->qt_parcelas = $qt_parcelas;
	$p->fisico = $fisico;

	if($dt_vencimento!='' && $dt_vencimento!='//')
		$p->dt_vencimento = invert($dt_vencimento,'-','SQL');
	if($dt_pagamento!='' && $dt_pagamento!='//')
		$p->dt_pagamento = invert($dt_pagamento,'-','SQL');

	$p->cod_barras = $cod_barras;
	$p->vlr_multa = str_replace(',','.',$vlr_multa);
	$p->desconto = str_replace(',','.',$desconto);
	$p->valor_pg = str_replace(',','.',$valor_pg);
	$p->id_departamento = $id_departamento;
	$p->id_planoconta = $id_planoconta;
	$p->id_conta = $id_conta;
}

if($submit_inserir){
	$error='<ul>';
	if($p->id_planoconta=="" || $p->favorecido=="" || $p->id_regime=="" || $p->id_forma_pagamento=="" || $p->descricao=="" || $p->id_fornecedor=="" || 
		$p->dt_vencimento=="" || $p->valor==""){
		if($p->id_planoconta == "") $errors['id_planoconta']=1;
		if($p->descricao == "") $errors['descricao']=1;
		if($p->id_fornecedor == "") $errors['id_fornecedor']=1;
		if($p->dt_vencimento == "") $errors['dt_vencimento']=1;
		if($p->valor == "") $errors['valor']=1;
		if($p->id_forma_pagamento == "") $errors['id_forma_pagamento']=1;
		if($p->id_regime == "") $errors['id_regime']=1;
		if($p->favorecido == "") $errors['favorecido']=1;

		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}
	$error.='</ul>';

	if(count($errors)==0){
		try{
			$error = $pagamentoDAO->inserir($p);
			//alterado 01/04/2011
			$titulo = 'Adicionar Solicitação';
			$perg   = 'Inserir outra solicitação?';
			$resp1  = 'pagamento_add.php';
			$resp2  = 'pagamento.php';
			$funcJs = "openConfirmBox('".$titulo."','".$perg."','".$resp1."','".$resp2."');";
			echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
			
		}catch(Exception $e){
			$error = $e->getMessage();
			$errors['bd']=1;
		}
	}
}elseif($submit_atualizar){
	$error='<ul>';
	if($p->id_planoconta=="" || $p->favorecido=="" || $p->id_regime=="" || $p->id_forma_pagamento=="" || $p->descricao=="" || $p->id_fornecedor=="" || 
		$p->dt_vencimento=="" || $p->valor==""){
		if($p->id_planoconta == "") $errors['id_planoconta']=1;
		if($p->descricao == "") $errors['descricao']=1;
		if($p->id_fornecedor == "") $errors['id_fornecedor']=1;
		if($p->dt_vencimento == "") $errors['dt_vencimento']=1;
		if($p->valor == "") $errors['valor']=1;
		if($p->id_forma_pagamento == "") $errors['id_forma_pagamento']=1;
		if($p->id_regime == "") $errors['id_regime']=1;
		if($p->favorecido == "") $errors['favorecido']=1;

		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}

	$total_pago =(float)($valor)+(float)($vlr_multa)-(float)($desconto);
	if(($dt_pagamento=='00/00/0000' or strlen($dt_pagamento)<10) and $valor_pg!='0.00'){
		$errors['dt_pagamento']=1;
		$error.="<li><b>Preencha a data do pagamento</b></li>";	
	}

	if(($id_conta<>'' or $dt_pagamento!='00/00/0000') and ($valor_pg=='0.00' or  $valor_pg=='')){
		$errors['valor_pg']=1;
		$error.="<li><b>Preencha a valor pago</b></li>";	
	}

	#if($p->dt_pagamento!='0000-00-00' and ($p->dt_pagamento > date('Y-m-d') or $p->dt_pagamento <= date('Y-m-d',strtotime("-5 day")))){
	#	$errors['dt_pagamento']=1;
	#	$error.="<li><b>A data não pode ser inferior à ".date('d/m/Y',strtotime('-5 day'))." ou superior à data atual</b></li>";	
	#}

	if($id_conta=='' and $valor_pg!='0.00'){
		$errors['id_conta']=1;
		$error.="<li><b>Selecione a conta para debitar</b></li>";	
	}
	
	if(trim($valor_pg) != trim($total_pago) and $valor_pg!='0.00'){
		$errors['valor_pg']=1;
		$error.="<li><b>Valor pago incorreto: Valor Total + Multa/Juros - Desconto = R$ ".$total_pago."</b></li>";	
	}

	if($valor_pg=='' and $id_conta<>''){
		$errors['valor_pg']=1;
		$error.="<li><b>Preencha o valor que foi pago</b></li>";	
	}
	
	$error.='</ul>';

	if(count($errors)==0){
		$pagamentoDAO->atualizar($p);
		//alterado 01/04/2011
		$titulo = 'Atualizar registro';
		$msg    = 'Registro atualizado com sucesso!!!';
		$pagina = '';
		$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
}

if($p->id_pagamento=="") $submit="inserir"; else $submit="atualizar";

if(count($errors)>0){
	echo '<div class="erro">'.$error.'</div>';
} 
?>
<script	src="../js/compra_financeiro_form.js"></script>
<form enctype="multipart/form-data" action="#aba1" method="post" name="pagamento_form">
<table width="677" class="tabela">
	<tr>
		<td colspan="4" class="tabela_tit">Solicitação de Pagamento</td>
	</tr>
	<? if($controle_id_empresa==1){ ?>
	<tr>
		<td align="right"><strong>Holding:</strong></td>
		<td colspan="3">
			<select name="id_holding" id="id_holding" class="form_estilo" style="width:470px">
				<option value="">Sistecart</option>
				<?php 
				$holding = $pagamentoDAO->listaHolding();
				$p_valor = '';
				foreach($holding as $f){
					$p_valor .= '<option value="'.$f->id_holding.'" ';
					if($p->id_holding==$f->id_holding) $p_valor .= ' selected="selected"';
					$p_valor .= '>'. $f->holding .'</option>';
				}
				echo $p_valor;
				?>
			</select>
			<font color="#F00">*</font>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td align="right"><strong>Fornecedor:</strong></td>
		<td colspan="3">
			<select name="id_fornecedor" id="fornecedor" class="form_estilo <?=(isset($errors['id_fornecedor']))?'form_estilo_erro':''; ?>" onchange="carrega_fornecedor_contas(this.value)" style="width:470px">
				<option></option>
				<?php 
				$fornecedores = $fornecedorDAO->lista($controle_id_empresa);
				$p_valor = '';
				foreach($fornecedores as $f){
					$p_valor .= '<option value="'.$f->id_fornecedor.'" ';
					if($p->id_fornecedor==$f->id_fornecedor) $p_valor .= ' selected="selected"';
					$p_valor .= '>'. $f->fantasia .'</option>';
				} 
				echo $p_valor;
				?>
			</select>
			<font color="#F00">*</font>
		</td>
	</tr>
	<tr>
		<td width="100">
			<div align="right"><strong>Classificação:</strong></div>
		</td>
		<td colspan="3">
		<input type="text" name="conta_caixa" onkeyup="$('#id_planoconta option[value *= ' + this.value + ']:first').attr('selected', true); masc_numeros(this,'########');" style="width:100px" class="form_estilo"/>
		<select name="id_planoconta" id="id_planoconta" onchange="conta_caixa.value=this.value;" class="form_estilo <?=(isset($errors['id_planoconta']))?'form_estilo_erro':''; ?>" style="width:362px">
			<?
			$classificacao = $financeiroDAO->listarPlanoConta();
			$p_valor = '<option value=""></option>';
			foreach($classificacao as $f){
				$p_valor .= '<option value="'.$f->id_planoconta.'"';
				if($p->id_planoconta==$f->id_planoconta) $p_valor .= 'selected="selected"';
				$p_valor .= '>'.$f->descricao.'</option>';
			}
			echo $p_valor;
			?>
		</select>
		<font color="#F00">*</font>
		</td>	
	</tr>
	<tr>
		<td width="100">
			<div align="right"><strong>Forma:</strong></div>
		</td>
		<td>
				<select name="id_forma_pagamento" class="form_estilo <?=(isset($errors['id_forma_pagamento']))?'form_estilo_erro':''; ?>" 
				onchange="if($(this).val()=='4')$('.deposito').show(); else $('.deposito').hide();" style="width:150px">
			<?
					$forma = $financeiroDAO->listarFormaPagamentoCAP();
					$p_valor = '';
					foreach($forma as $f){
						$p_valor .= '<option value="'.$f->id_forma_pagamento.'" ';
						if($p->id_forma_pagamento==$f->id_forma_pagamento) $p_valor .= 'selected="selected"';
						$p_valor .= '>'.$f->forma_pagamento.'</option>';
					}
					echo $p_valor;
				?>
				</select></td>
					<td align="right"><strong>Centro de Custo:</strong></td>
					<td colspan="3"><select name="id_departamento" class="form_estilo  <?=(isset($errors['id_departamento']))?'form_estilo_erro':''; ?>" style="width:130px">
					<?php 
						$p_valor ='<option value="0"';
						if($p->id_departamento==0) $p_valor .= ' selected="selected"';
						$p_valor .= '>Rateio</option>';
						$departamentos_s = $departamentoDAO->listar();
						foreach($departamentos_s as $dep){
							$p_valor .='<option value="'.$dep->id_departamento.'"';
							if($dep->id_departamento==$p->id_departamento) $p_valor .= ' selected="selected"';
							$p_valor .= '>'. $dep->departamento.'</option>';
						 } 
						 echo $p_valor;
					 ?>
					</select></td>
				
			</tr>
			<tr>
				<td align="right"><strong>Descrição:</strong></td>
				<td colspan="3">
					<textarea name="descricao" class="form_estilo  <?=(isset($errors['descricao']))?'form_estilo_erro':''; ?>" style="height:50px;width:470px" ><?php echo $p->descricao ?></textarea>
					<font color="#F00">*</font>
				</td>
			</tr>
			<tr>
			</tr>
			<tr class="deposito">
				<td align="right"><strong>Banco:</strong></td>
				<td colspan="3"><select name="id_banco" id="id_banco"
					class="form_estilo  <?=(isset($errors['id_banco']))?'form_estilo_erro':''; ?>" style="width:470px">
					<option></option>
					<?php 
					$bancos = $bancoDAO->listar();
					foreach($bancos as $banco){ ?>
					<option value="<?=$banco->id_banco;?>"
					<?=($p->id_banco==$banco->id_banco)?'selected="selected"':''?>><?=$banco->banco; ?></option>
					<?php }?>
				</select></td>
			</tr>
			<tr class="deposito">
				<td align="right" width="100"><strong>Agência:</strong></td>
				<td width="230"><input type="text" id="agencia" name="agencia"
					value="<?php echo $p->agencia ?>"
					class="form_estilo  <?=(isset($errors['agencia']))?'form_estilo_erro':''; ?>" /></td>
				<td align="right"><strong>Conta:</strong></td>
				<td><input type="text" name="conta" id="conta"
					value="<?php echo $p->conta ?>" 
					class="form_estilo  <?=(isset($errors['conta']))?'form_estilo_erro':''; ?>" /></td>
			</tr>
			<tr>
				<td align="right"><strong>Favorecido:</strong></td>
				<td colspan="4"><input type="text" id="favorecido" name="favorecido"
					value="<?php echo $p->favorecido ?>" style="width:470px"
					class="form_estilo  <?=(isset($errors['favorecido']))?'form_estilo_erro':''; ?>"/>
					<font color="#F00">*</font>
				</td>
			</tr>
			
			<tr>
				<td align="right"><strong>CPF/CNPJ:</strong></td>
				<td><input type="text" id="cnpj" name="cnpj"
					value="<?php echo $p->cnpj ?>" style="width:150px" onKeyUp="masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo  <?=(isset($errors['cnpj']))?'form_estilo_erro':''; ?>"/>
				</td>
				<td width="100" align="right"><strong>Regime Trib.:</strong></td>
				<td>
					<select name="id_regime" id="id_regime" class="form_estilo <?=(isset($errors['id_regime']))?'form_estilo_erro':''; ?>" onchange="carrega_fornecedor_regime(this.value)" style="width:130px">
						<option></option>
						<?php 
						$regime = $regimeDAO->listar();
						$p_valor = '';
						foreach($regime as $f){
							$p_valor .= '<option value="'.$f->id_regime.'" ';
							if($p->id_regime==$f->id_regime) $p_valor .= ' selected="selected"';
							$p_valor .= '>'. $f->nome .'</option>';
						}
						echo $p_valor;
						?>
					</select>
					<font color="#F00">*</font></td>
			</tr>
			<tr>
				<td align="right"><strong>Nota:</strong></td>
				<td>
					<input type="text" name="nota" value="<?php echo $p->nota ?>" style="width:150px" class="form_estilo"/>
				</td>
				<td align="right"><strong>Doc. Físico:</strong></td>
				<td>
					<input type="checkbox" name="fisico" value="1" <?php if($p->fisico==1) echo 'checked' ?>/> Recebido
				</td>
			</tr>
			<tr>
				<td align="right" width="100"><strong>Valor Total:</strong></td>
				<td width="230"><input type="text" name="valor" id="fin_valor"
					value="<?php echo $p->valor ?>" onkeyup="moeda(event.keyCode,this.value,'fin_valor');"
					class="form_estilo  <?=(isset($errors['valor']))?'form_estilo_erro':''; ?>" /><font color="#F00">*</font> Forma ####.##</td>
				<td width="100" align="right"><strong>Vencimento:</strong></td>
				<td><input type="text" name="dt_vencimento" onKeyUp="masc_numeros(this,'##/##/####');"
					value="<?php echo invert($p->dt_vencimento,'/','PHP'); ?>"
					class="form_estilo  <?=(isset($errors['dt_vencimento']))?'form_estilo_erro':''; ?>"  style="width:130px"/><font color="#F00">*</font></td>
			</tr>
			<tr>
				<td align="right"><strong>IR:</strong></td>
				<td colspan="4">
					<input type="text" readonly name="valor_ir" value="<?php echo $p->valor_ir ?>" style="width:70px" class="form_estilo_r"/>
					<strong>PIS:</strong>
					<input type="text" readonly name="valor_pis" value="<?php echo $p->valor_pis ?>" style="width:70px" class="form_estilo_r"/>
					<strong>COFINS:</strong>
					<input type="text" readonly name="valor_cofins" value="<?php echo $p->valor_cofins ?>" style="width:70px" class="form_estilo_r"/>
					<input type="button" name="calcula" value="Calcular" class="button_busca" onclick="calcula_retem(valor.value,id_regime.value);"/>					
				</td>
			</tr>
			<? if($p->parcela<>'' or $id_pagamento==''){ ?>
				<tr>
					<? if($p->parcela<>'' and $id_pagamento<>''){
						echo '<td align="right"><strong>Parcelas:</strong></td>
						<td colspan="3">'.$p->parcela.' de '. $p->qt_parcelas.'
						<input type="hidden" name="qt_parcelas" value="'. $p->qt_parcelas .'" />
						<input type="hidden" name="parcela" value="'. $p->parcela .'" />';

					} else{
						if($id_pagamento==''){
						echo '<td align="right"><strong>Duplicar:</strong></td>
						<td colspan="3"><input type="text" name="qt_parcelas" onKeyUp="masc_numeros(this,\'###\');"
						value="'. $p->qt_parcelas .'" style="width:50px"
						class="form_estilo" /> 
						Informe a quantidade de vezes que quer duplicar essa conta
						';
						}
					}				
					?>
					</td>
				</tr>
			<? }
			if($id_pagamento<>''){
			?>
			<tr>
				<td colspan="4" class="tabela_tit">Dados sobre o pagamento</td>
			</tr>
			<tr>
				<td align="right"><strong>Cód. de Barras:</strong></td>
				<td colspan="3">
					<input type="text" name="cod_barras" value="<?php echo $p->cod_barras?>" style="width:470px" class="form_estilo  <?=(isset($errors['cod_barras']))?'form_estilo_erro':''; ?>"/>
				</td>
			</tr>

			<tr>
				<td align="right"><strong>Desconto de (R$):</strong></td>
				<td ><input type="text" name="desconto" value="<?php echo $p->desconto ?>" class="form_estilo <?=(isset($errors['desconto']))?'form_estilo_erro':''; ?>" /></td>
				<td align="right"><strong>Multa/Juros (R$):</strong></td>
				<td><input type="text" name="vlr_multa" value="<?php echo $p->vlr_multa ?>" class="form_estilo <?=(isset($errors['vlr_multa']))?'form_estilo_erro':''; ?>" /></td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td align="right"><strong>Total Pago(R$):</strong></td>
				<td><input type="text" name="valor_pg" value="<?php echo $p->valor_pg ?>" class="form_estilo <?=(isset($errors['valor_pg']))?'form_estilo_erro':''; ?>" /></td>
				<td align="right"><strong>Pago em:</strong></td>
				<td><input type="text" name="dt_pagamento" value="<?php echo invert($p->dt_pagamento,'/','PHP') ?>" class="form_estilo <?=(isset($errors['dt_pagamento']))?'form_estilo_erro':''; ?>" onKeyUp="masc_numeros(this,'##/##/####');"/></td>				
			</tr>
			<tr>
				<td align="right"><strong>Débitar:</strong></td>
				<td colspan="3">
					<select name="id_conta" class="form_estilo <?=(isset($errors['id_conta']))?'form_estilo_erro':''; ?>" style="width:470px">
						<option></option>
						<?php 
						$contas = $contaDAO->listarConta($controle_id_empresa);
						$p_valor = '';
						foreach($contas as $f){
							$p_valor .= '<option value="'.$f->id_conta.'" ';
							if($p->id_conta==$f->id_conta) $p_valor .= ' selected="selected"';
							$p_valor .= '>'. $f->sigla .'</option>';
						} 
						echo $p_valor;
						?>
					</select>
					<font color="#F00">*</font>
				</td>
			</tr>
			
			<? } ?>
			<tr>
				<td align="center" colspan="4">
				<? if($controle_depto_p[27]!=1){ ?>
					<input type="submit" class="button_busca" value="Enviar" name="submit_<?php echo $submit ?>">&nbsp;
				<? } ?>
					<input type="submit" class="button_busca" onclick="document.pagamento_form.action='pagamento.php';" value="Voltar" name="cancelar">
				</td>
			</tr>
		</table>
</form>
<script>
	<?
	if($p->id_forma_pagamento=='4') echo '$(\'.deposito\').show();'; else echo '$(\'.deposito\').hide();';
	?>
</script>
<div id="carrega_forn"></div>
<div id="carrega_retem"></div>