<?
require('header.php');
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

$departamentoDAO = new DepartamentoDAO();
$financeiroDAO = new FinanceiroDAO();
$contaDAO = new ContaDAO();
$atividadeDAO = new AtividadeDAO();

pt_register('GET','busca_id_departamento');
pt_register('GET','busca_nossa_conta');
pt_register('GET','busca_id_pedido');
pt_register('GET','busca_ordem');
pt_register('GET','busca_data_i');
pt_register('GET','busca_data_f');
pt_register('GET','busca_autorizacao');
pt_register('GET','busca_forma');

if ($busca_data_i=='') $busca_data_i = date('d/m/Y'). ' 00:00:00';
if ($busca_data_f=='') $busca_data_f = date('d/m/Y'). ' 23:59:59';

if($busca_autorizacao=='') $busca_autorizacao = 0;

$busca->busca_id_departamento = $busca_id_departamento;
$busca->busca_nossa_conta 	= $busca_nossa_conta;
$busca->busca_id_pedido = $busca_id_pedido;
$busca->busca_ordem = $busca_ordem;
$busca->busca_data_i = $busca_data_i;
$busca->busca_data_f = $busca_data_f;
$busca->busca_autorizacao = $busca_autorizacao;
$busca->busca_forma = $busca_forma;

?>
<div id="topo">
	<h1 class="tit"><img src="../images/tit/tit_desembolso.png" alt="Título" />Desembolso</h1>
	<a href="#" class="topo">topo</a>
	<hr class="tit" />
</div>
<div id="meio">
<?
#retorno de depósito
pt_register('POST','submit_retorno');
if ($submit_retorno) {
	$ext = explode(',',$_COOKIE['p_id_pedido']);
	$ext_num = count ($ext)-1;
	?>
	<form enctype="multipart/form-data" action="" method="post" name="pedido_add">
	<table width="100%" cellpadding="4" cellspacing="1"	class="result_tabela">
		<tr>
			<td colspan="4" class="tabela_tit">Ordens Selecionadas</td>
		</tr>
		<tr>
			<td width="150" valign="top">
			<div align="right"><strong>Ordens Selecionadas: </strong></div>
			</td>
			<td width="532" colspan="3"><?= str_replace(',',' - ',$_COOKIE['p_id_pedido']); ?>
			<br>
			<br>
			<b>Foram selecionados <?= $ext_num ?> pedidos.</b></td>
		</tr>
		<tr>
			<td colspan="4">
			<div align="center">
				<input type="submit" name="submit_retorno_aplica" value=" Confirmar " class="button_busca" />&nbsp; 
				<input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_add.action='financeiro2.php'" class="button_busca" />
			</div>
			</td>
		</tr>
	</table>
	</form>
</div>
<? 
	require('footer.php');
	exit;
}

#envia para expedição executar
pt_register('POST','submit_expedicao');
if ($submit_expedicao) {
	$ext = explode(',',$_COOKIE['p_id_pedido']);
	$ext_num = count ($ext)-1;
?>
	<form enctype="multipart/form-data" action="" method="post"	name="pedido_add">
	<table width="100%" cellpadding="4" cellspacing="1"	class="result_tabela">
		<tr>
			<td colspan="4" class="tabela_tit">Ordens Selecionadas para enviar a expedição</td>
		</tr>
		<tr>
			<td width="150" valign="top">
				<div align="right"><strong>Ordens Selecionadas: </strong></div>
			</td>
			<td width="532" colspan="3"><?= str_replace(',',' - ',$_COOKIE['p_id_pedido']); ?>
			<br>
			<br>
			<b>Foram selecionados <?= $ext_num ?> pedidos.</b></td>
		</tr>
		<tr>
			<td colspan="4">
			<div align="center">
				<input type="submit" name="submit_expedicao_aplica" value=" Confirmar "	class="button_busca" />&nbsp; 
				<input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_add.action='financeiro2.php'"	class="button_busca" /></div>
			</td>
		</tr>
	</table>
	</form>
</div>
<? 
	require('footer.php');
	exit;
}

#altera conta de saida do dinheiro
pt_register('POST','submit_financeiro_altera_form');
if($submit_financeiro_altera_form){
	$pedidoDAO = new PedidoDAO();
	$contas = $contaDAO->listarConta($controle_id_empresa);
?>
	<form method="post" action="">
	<table width="700" style="margin:auto" cellpadding="4" cellspacing="1"	class="result_tabela">
	<tr>
		<td colspan="4" class="tabela_tit">Ordens Selecionadas para alterar a conta de onde saiu o(s) valor(es)</td>
	</tr>
	<tr>
		<td width="150" valign="top">
		<div align="right"><strong>Ordens Selecionadas: </strong></div>
		</td>
		<td width="532" colspan="3"><?= str_replace(',',' - ',$_COOKIE['p_id_pedido']); ?>
		</td>
	</tr>
	<tr>
		<td colspan="4">
		<div align="center">
			<?php 
			while($cont<=50){
				$cont++;
				pt_register('POST','acao_'.$cont);
				pt_register('POST','acao_financeiro_'.$cont);
				pt_register('POST','acao_sel_'.$cont);
				pt_register('POST','acao_pedido_'.$cont);
				
				if(${'acao_sel_'.$cont}==''){
					continue;
				}
				echo '<input type="hidden" name="ids_financeiro[]" value="'.${'acao_financeiro_'.$cont}.'"/>';
			}
			?>
			<label><b>Conta:</b></label>
			<select name="conta" class="form_estilo" style="width:150px">
				<?php foreach($contas as $c){?>
					<option value="<?php echo $c->sigla ?>"><?php echo $c->sigla?></option>
				<?php }?>				
			</select>
			<br/>
			<input type="submit" value=" Alterar " class="button_busca" name="submit_financeiro_altera"/>
			<input type="submit" name="cancelar" value="Cancelar"	class="button_busca" />
			
		</div>
		</td>
	</tr>
	</table>
	</form>
</div>
<?php 
	require('footer.php');
	exit;
}
?>

<form name="buscador" action="" method="get" ENCTYPE="multipart/form-data">
<div class="busca1">
	<label>Situação:</label> 
	<select name="busca_autorizacao" style="width: 200px; float: left" class="form_estilo">
		<option value="0" <? if($busca_autorizacao=='' or $busca_autorizacao==0) echo 'selected="select"'; ?>>Desembolso Pendente</option>
		<option value="1" <? if($busca_autorizacao==1) echo 'selected="select"'; ?>>Desembolso Aprovado</option>
		<option value="2" <? if($busca_autorizacao==2) echo 'selected="select"'; ?>>Desembolso Reprovado</option>
		<option value="3" <? if($busca_autorizacao==3) echo "selected"; ?>>Em Andamento</option>
		<option value="4" <? if($busca_autorizacao==4) echo "selected"; ?>>Em Execução</option>
	</select>

	<label >Forma:</label> 
	<select name="busca_forma" style="width: 200px; float: left" class="form_estilo">
		<option value="" <? if($busca_forma=='') echo 'selected="select"'; ?>></option>
		<?
		$p_valor = "";
		$fin = $financeiroDAO->listarForma();
		foreach($fin as $f){
			$p_valor .='<option value="'.$f->forma_2.'" ';
			if($busca_forma==$f->forma_2) $p_valor .= ' selected ';
			$p_valor .='>'.$f->forma.'</option>';
		}
		echo $p_valor;
		?>
		<option value="_" <? if($busca_forma=='_') echo 'selected="select"'; ?>>Todos (exceto depósito e boleto)</option>
	</select>

	<label>Departamento:</label> 
	<select name="busca_id_departamento" style="width: 200px; float: left" class="form_estilo">
		<option value="" <? if($busca_id_departamento=='') echo ' selected="selected" '; ?>>Todos</option>
		<?
			$p_valor = '';
			$var = $departamentoDAO->listarDptoOrdem();
			foreach($var as $s){
				$p_valor .= '<option value="'.$s->id_servico_departamento.'"';
				if($busca_id_departamento==$s->id_servico_departamento) $p_valor .= ' selected="selected" ';
				$p_valor .=  ' >'.$s->departamento.'</option>';
			}
			echo $p_valor;
		?>
	</select>

	<label>Banco:</label> 
	<select name="busca_nossa_conta" style="width:200px; float: left" class="form_estilo">
		<option value="" <? if($busca_nossa_conta=='') echo ' selected="selected" '; ?>>Todos</option>
		<?
			$p_valor = "";
			$lista = $contaDAO->listarConta($controle_id_empresa);
			$p_valor = '';
			foreach($lista as $l){
				$p_valor .= '<option value="'.$l->sigla.'"';
				if($l->sigla==$busca_nossa_conta) $p_valor .= 'selected="select"'; 
				$p_valor .= '>'.$l->sigla.'</option>';
			}
			echo $p_valor;
		?>
	</select>
	<label>&nbsp;</label> 
</div>
<div class="busca2">
	<label>Entre:</label>
	<input type="text" name="busca_data_i" value="<?= $busca_data_i ?>" style="width: 200px; float: left" class="form_estilo" />
	<label>e</label>
	<input type="text" name="busca_data_f" value="<?= $busca_data_f ?>"	style="width: 200px; float: left" class="form_estilo" />
	<label>Ordem:</label>
	<input type="text" name="busca_id_pedido" value="<?= $busca_id_pedido ?>" style="width: 90px; float: left"	class="form_estilo" />
	<strong style="width: 65px; float: left; text-align:right; margin-top:5px">Serviço:</strong>
	<input type="text" name="busca_ordem" value="<?= $busca_ordem ?>" style="width: 40px; float: left" class="form_estilo" />
	<label></label>
	<input type="submit" name="submit" class="button_busca" onclick="document.buscador.target='_self'; document.buscador.action=''" value=" Buscar " /> 
	<input type="submit" name="submit_lista" value="Listar"	onclick="document.buscador.target='_blank'; document.buscador.action='gera_desembolso_lista2.php'"	class="button_busca" />
</div>
</form>


<form name="f1" action="" method="post" ENCTYPE="multipart/form-data">

<div style="clear: both; padding: 5px">
<? 
if($busca_autorizacao=='0') {
	echo '<input type="submit" name="submit_financeiro_aprovar" class="button_busca" value=" Aprovar " />
			<input type="submit" name="submit_financeiro_reprovar" class="button_busca" value=" Reprovar " />';
} else {
	if($busca_autorizacao==3){
		echo '<input type="submit" name="submit_expedicao" class="button_busca" value="Em Execução" />
					<input type="submit" name="submit_retorno" class="button_busca" value="Efetuado" />';
	} else {
		if($busca_autorizacao==4){
			echo '<input type="submit" name="submit_conferido" class="button_busca" value="Conferido" />';
		}
	}
}
echo '&nbsp;<input type="submit" name="submit_financeiro_altera_form" class="button_busca" value=" Alterar Conta " />';
?>
</div>
<?

#aplica retorno de depósito
pt_register('POST','submit_retorno_aplica');
if ($submit_retorno_aplica) {
	$des_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['des_id_pedido_item'].'##'));
	$des_id_pedido = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido'].'##'));
	$des_id_fin = explode (',',str_replace(',##','',$_COOKIE['des_id_fin'].'##'));
	$atividadeverificaDAO = new AtividadeVerificaDAO();

	$cont=0;
	foreach ($des_id_pedido_item as $chave => $id_pedido_item) {
		$valida = valida_numero($id_pedido_item);
		if($valida!='TRUE'){
			echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
			exit;
		}

		unset ($p_verifica);
		$p_verifica = $atividadeverificaDAO->AtividadeVerifica($controle_id_empresa,'155','.',$departamento_p,$departamento_s,$id_pedido_item);

		if($p_verifica['error']==''){			
			$done = $financeiroDAO->retornoDeposito($id_pedido_item,$des_id_fin[$cont],$controle_id_usuario);
			echo '<ul class="sucesso"><li><b>Pedido '.$des_id_pedido[$cont].':</b> Retorno do depósito efetuado</li></ul>';
		} else {
			echo '<ul class="erro"><li><b>Pedido '.$des_id_pedido[$cont].':</b></li> '.$p_verifica['error'].'</ul><br>';
		}
		$cont++;
	}
	echo "<br><br>
	<script>
		eraseCookie('des_id_pedido_item');
		eraseCookie('p_id_pedido');
		eraseCookie('des_id_fin');
	</script>
	";
	unset( $_COOKIE['des_id_pedido_item']);
	unset( $_COOKIE['p_id_pedido'] );
	unset( $_COOKIE['des_id_fin'] );
}



pt_register('POST','submit_expedicao_aplica');
if ($submit_expedicao_aplica) {
	$des_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['des_id_pedido_item'].'##'));
	$des_id_pedido = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido'].'##'));
	$des_id_fin = explode (',',str_replace(',##','',$_COOKIE['des_id_fin'].'##'));
	$atividadeverificaDAO = new AtividadeVerificaDAO();

	$cont=0;
	foreach ($des_id_pedido_item as $chave => $id_pedido_item) {
		$valida = valida_numero($id_pedido_item);
		if($valida!='TRUE'){
			echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
			exit;
		}

		unset ($p_verifica);
		$p_verifica = $atividadeverificaDAO->AtividadeVerifica($controle_id_empresa,'213','.',$departamento_p,$departamento_s,$id_pedido_item);

		if($p_verifica['error']==''){
			$done = $financeiroDAO->enviaExpedicao($id_pedido_item,$des_id_fin[$cont],$controle_id_usuario);
			echo '<ul class="sucesso"><li><b>Pedido '.$des_id_pedido[$cont].':</b> Dinheiro Entregue a expedição</li></ul>';
		} else {
			echo '<ul class="erro"><li><b>Pedido '.$des_id_pedido[$cont].':</b></li> '.$p_verifica['error'].'</ul><br>';
		}
		$cont++;
	}

	echo "<br><br>
	<script>
		eraseCookie('des_id_pedido_item');
		eraseCookie('p_id_pedido');
		eraseCookie('des_id_fin');
	</script>
	";
	unset( $_COOKIE['des_id_pedido_item'] );
	unset( $_COOKIE['p_id_pedido'] );
	unset( $_COOKIE['des_id_fin'] );
}

#conferencia do troco
pt_register('POST','submit_conferido');
if ($submit_conferido) {
	$des_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['des_id_pedido_item'].'##'));
	$des_id_pedido = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido'].'##'));
	$des_id_fin = explode (',',str_replace(',##','',$_COOKIE['des_id_fin'].'##'));
	$cont=0;
	foreach ($des_id_pedido_item as $chave => $id_pedido_item) {
		$done = $financeiroDAO->trocoConferido($id_pedido_item,$des_id_fin[$cont],$controle_id_empresa);
		if($done<>0){
			echo '<ul class="sucesso"><li><b>Pedido '.$des_id_pedido[$cont].':</b> Troco Conferido</li></ul>';
		} else {
			echo '<ul class="erro"><li><b>Pedido '.$des_id_pedido[$cont].':</b></li> O registro não pode ser alterado!</ul><br>';
		}
		$cont++;
	}

	echo "<br><br>
	<script>
		eraseCookie('des_id_pedido_item');
		eraseCookie('p_id_pedido');
		eraseCookie('des_id_fin');
	</script>
	";
	unset( $_COOKIE['des_id_pedido_item'] );
	unset( $_COOKIE['p_id_pedido'] );
	unset( $_COOKIE['des_id_fin'] );

}

#aprovação do desembolso
pt_register('POST','submit_financeiro_edit');
if ($submit_financeiro_edit) {
	$errors = new stdClass();
	pt_register('POST','id_pedido_item');
	pt_register('POST','id_financeiro');
	pt_register('POST','financeiro_conferido');
	pt_register('POST','financeiro_nossa_conta');
	pt_register('POST','financeiro_classificacao');
	pt_register('POST','financeiro_banco');
	pt_register('POST','financeiro_agencia');
	pt_register('POST','financeiro_conta');
	pt_register('POST','financeiro_identificacao');
	pt_register('POST','financeiro_favorecido');
	pt_register('POST','financeiro_cpf');
	pt_register('POST','financeiro_descricao');
	pt_register('POST','financeiro_desembolsado');
	pt_register('POST','financeiro_troco');
	pt_register('POST','financeiro_valor');
	pt_register('POST','financeiro_rateio');
	pt_register('POST','financeiro_sedex');
	pt_register('POST','financeiro_forma');
	pt_register('POST','financeiro_autorizacao');
	pt_register('POST','financeiro_old_autorizacao');

	$f = new stdClass();
	$f->financeiro_nossa_conta=$financeiro_nossa_conta;
	$f->financeiro_classificacao=$financeiro_classificacao;
	$f->financeiro_banco=$financeiro_banco;
	$f->financeiro_conferido=$financeiro_conferido;
	$f->financeiro_agencia=$financeiro_agencia;
	$f->financeiro_conta=$financeiro_conta;
	$f->financeiro_identificacao=$financeiro_identificacao;
	$f->financeiro_favorecido=$financeiro_favorecido;
	$f->financeiro_cpf=$financeiro_cpf;
	$f->financeiro_descricao=$financeiro_descricao;
	$f->financeiro_desembolsado=$financeiro_desembolsado;
	$f->financeiro_troco=$financeiro_troco;
	$f->financeiro_valor=$financeiro_valor;
	$f->financeiro_rateio=$financeiro_rateio;
	$f->financeiro_sedex=$financeiro_sedex;
	$f->financeiro_forma=$financeiro_forma;
	$f->financeiro_autorizacao=$financeiro_autorizacao;
	$f->financeiro_old_autorizacao=$financeiro_old_autorizacao;

	$financeiroverificaDAO=new FinanceiroVerificaDAO();
	$errors = $financeiroverificaDAO->editar($id_pedido_item,$id_financeiro,$controle_id_empresa,$departamento_p,$departamento_s,$f);

	if($errors->error=='') {
		$financeiro_inDAO= new FinanceiroDAO();
		$done = $financeiro_inDAO->editarDesembolso($id_pedido_item,$id_financeiro,$controle_id_usuario,$f,$departamento_p);
		$alert_done .= "Desembolso atualizado com sucesso!";
	} else {
		echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>'.$errors->error.'</ul></div>';
	}
}


#aprova desembolso
pt_register('POST','submit_financeiro_aprovar');
if ($submit_financeiro_aprovar<>'') {

	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	if(in_array('2',$departamento_p)!=1){
		echo '<br><br><strong>Você não tem permissão para realizar essa operação.</strong>';
		exit;
	}

	$cont==0;

	while($cont<=50){
		$cont++;
		pt_register('POST','acao_'.$cont);
		pt_register('POST','acao_financeiro_'.$cont);
		pt_register('POST','acao_sel_'.$cont);
		pt_register('POST','acao_pedido_'.$cont);
		if(${'acao_sel_'.$cont}<>''){
			$done = $financeiroDAO->aprovaDesembolso(${'acao_'.$cont},${'acao_financeiro_'.$cont},$controle_id_usuario,$controle_id_empresa);
			if($done<>0){
				echo '<ul class="sucesso"><li><b>Pedido '.${'acao_pedido_'.$cont}.':</b> Desembolso aprovado</li></ul>';
			} else {
				echo '<ul class="erro"><li><b>Pedido '.$des_id_pedido[$cont].':</b></li> O registro não pode ser alterado!</ul><br>';
			}
		}
	}
}

#reprovar desembolso
pt_register('POST','submit_financeiro_reprovar');
if ($submit_financeiro_reprovar<>'') {
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	if(in_array('2',$departamento_p)!=1){
		echo '<br><br><strong>Você não tem permissão para realizar essa operação.</strong>';
		exit;
	}
	$cont==0;
	while($cont<=50){
		$cont++;
		pt_register('POST','acao_'.$cont);
		pt_register('POST','acao_sel_'.$cont);
		pt_register('POST','acao_pedido_'.$cont);
		pt_register('POST','acao_financeiro_'.$cont);
		if(${'acao_sel_'.$cont}<>''){
			$done = $financeiroDAO->reprovaDesembolso(${'acao_'.$cont},${'acao_financeiro_'.$cont},$controle_id_usuario,$controle_id_empresa);
			if($done<>0){
				echo '<ul class="sucesso"><li><b>Pedido '.${'acao_pedido_'.$cont}.':</b> Registro atualizado com sucesso</li></ul>';
			} else {
				echo '<ul class="erro"><li><b>Pedido '.$des_id_pedido[$cont].':</b></li> O registro não pode ser alterado!</ul><br>';
			}
		}
	}
}

#altera conta aplica
pt_register('POST','submit_financeiro_altera');
if($submit_financeiro_altera){
	pt_register('POST','ids_financeiro');
	pt_register('POST','conta');
			
	$done = $financeiroDAO->atualizaConta($ids_financeiro,$conta,$controle_id_empresa);
	if($done<>0){
		echo '<ul class="sucesso"><li>Registros atualizados com sucesso!</li></ul>';
	} else {
		echo '<ul class="erro"><li><b>Os registros não foram atualizados!</ul><br>';
	}
	
}
pt_register('GET','pagina');

$lista = $financeiroDAO->buscaDesembolso($busca,$controle_id_empresa,$pagina);
$cont=0;
?>
<b>Movimentação do Período</b><br> 
Solicitado: R$ <?= number_format($lista[0]->financeiro_valor_t,2,".","") ?>&nbsp;
Desembolsado: R$ <?= number_format($lista[0]->financeiro_desembolsado_t,2,".","") ?>&nbsp;
Troco: R$ <?= number_format($lista[0]->financeiro_troco_t,2,".","") ?>&nbsp;
<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
	<tr>
		<td colspan="18" class="barra_busca"><?  $financeiroDAO->QTDPagina(); ?></td>
	</tr>
	<tr>
		<td align="center" width="20" class="result_menu">
			<input type="checkbox" name="todos"	onclick="if(this.checked==true) { selecionar_tudo_des('des_id_pedido_item'); selecionar_tudo(); } else { deselecionar_tudo_des('des_id_pedido_item'); deselecionar_tudo(); }" />
		</td>
		<td align="center" width="60" class="result_menu"><b>Editar</b></td>
		<td align="center" width="50" class="result_menu"><b>Ordem</b></td>
		<td align="center" width="50" class="result_menu"><b>Forma</b></td>
		<td align="center" width="50" class="result_menu"><b>Desembolso</b></td>
		<td align="center" width="80" class="result_menu"><b>Desembolsado</b></td>
		<td align="center" width="80" class="result_menu"><b>Troco</b></td>
		<td align="center" width="50" class="result_menu"><b>Valor Recebido</b></td>
	</tr>
<?
echo "
<script>
	eraseCookie('des_id_pedido_item');
	eraseCookie('p_id_pedido');
	eraseCookie('des_id_fin');
</script>
";
unset( $_COOKIE['des_id_pedido_item'] );
unset( $_COOKIE['p_id_pedido'] );
unset( $_COOKIE['des_id_fin'] );

$p_id_pedido_item = explode(',',$_COOKIE["des_id_pedido_item"]);

$p_valor='';
if($lista[0]->id_financeiro!='') {
	foreach($lista as $l){
		$cont++;
		$id_pedido_item = $l->id_pedido_item;
		$data_prazo     = invert($l->data_prazo,'/','PHP');
		$data_agenda    = invert($l->data_i,'/','PHP');
		$valor          = $l->valor;
		$rel            = $l->rel;
		if($rel=='1') $rel='Sim'; else $rel='Não';
		$financeiro_valor = $l->financeiro_valor;
		$financeiro_troco = $l->financeiro_troco;
		$financeiro_desembolsado = $l->financeiro_desembolsado;
		if($financeiro_troco=='')$financeiro_troco='0';
		if($financeiro_desembolsado=='')$financeiro_desembolsado='0';
		if($financeiro_valor>$valor) $erro_desembolso = "_erro";
		else $erro_desembolso = "";
		if($l->des2==1) $erro_desembolso2 = "_erro";
		else $erro_desembolso2 = "";

		if(in_array($l->id_pedido_item,$p_id_pedido_item)==1) $item_checked = ' checked '; else $item_checked = '';

		$valor_total      = (float)($valor_total)+(float)($l->valor);
		$financeiro_valor_total      = (float)($financeiro_valor_total)+(float)($financeiro_valor);
		$financeiro_troco_total      = (float)($financeiro_troco_total)+(float)($financeiro_troco);
		$financeiro_desembolsado_total      = (float)($financeiro_desembolsado_total)+(float)($financeiro_desembolsado);
		$valor            = 'R$ '.number_format($valor,2,".","");
		$financeiro_valor = 'R$ '.number_format($financeiro_valor,2,".","");
		$financeiro_troco = 'R$ '.number_format($financeiro_troco,2,".","");
		$financeiro_desembolsado = 'R$ '.number_format($financeiro_desembolsado,2,".","");

		$p_valor .= '<tr>
		<td class="result_celula" align="center" nowrap>
		<input type="hidden" name="acao_' . $cont .'" value="' . $l->id_pedido_item .'">
		<input type="hidden" name="acao_financeiro_' . $cont .'" value="' . $l->id_financeiro .'">
		<input type="hidden" name="acao_pedido_' . $cont .'" value="' . $l->id_pedido . '/'.$l->ordem .'">
		<input type="checkbox" name="acao_sel_' . $cont .'" value="'.$l->id_pedido_item.'" onclick="if(this.checked==true) { createCookie(\'des_id_pedido_item\',\''.$l->id_pedido_item.',\',\'1\',\'1\'); createCookie(\'p_id_pedido\',\'#'.$l->id_pedido.'/'.$l->ordem.',\',\'1\',\'1\'); createCookie(\'des_id_fin\',\''.$l->id_financeiro.',\',\'1\',\'1\'); } else {eraseCookieItem(\'des_id_pedido_item\',\''.$l->id_pedido_item.'\'); eraseCookieItem(\'p_id_pedido\',\'#'.$l->id_pedido.'/'.$l->ordem.'\'); eraseCookieItem(\'des_id_fin\',\''.$l->id_financeiro.'\'); }" '.$item_checked.'></td>
		<td class="result_celula" align="center"><a href="pedido_edit.php?id=' . $l->id_pedido . '&ordem=' . $l->ordem . '" target="_blank"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
		<td class="result_celula'.$erro_desembolso2.'" align="center" nowrap><a href="#" onclick="carrega_financeiro_edit_des(\''. $l->id_pedido_item .'\'); $(\'#windowMensagem\').show();">#' . $l->id_pedido . '/'.$l->ordem.'</a></td>
		<td class="result_celula" align="center" nowrap>' . $l->financeiro_forma . '</td>
		<td class="result_celula'.$erro_desembolso.'" align="right" nowrap><a href="#" onclick="carrega_financeiro_edit_d(\''. $l->id_pedido_item .'\',\''.$l->id_financeiro.'\'); $(\'#windowMensagem\').show();" >' . $financeiro_valor.'</a></td>
		<td class="result_celula" align="right" nowrap>' . $financeiro_desembolsado . '</td>
		<td class="result_celula" align="right" nowrap>' . $financeiro_troco . '</td>
		<td class="result_celula" align="right" nowrap>' . $valor . '</td>
		</tr>';
	}

	$valor_total            		= 'R$ '.number_format($valor_total,2,".","");
	$financeiro_valor_total     	= 'R$ '.number_format($financeiro_valor_total,2,".","");
	$financeiro_troco_total         = 'R$ '.number_format($financeiro_troco_total,2,".","");
	$financeiro_desembolsado_total  = 'R$ '.number_format($financeiro_desembolsado_total,2,".","");
	
	$p_valor .= '<tr>
	<td class="result_celula" align="center" nowrap>
    </td>
	<td class="result_celula" nowrap></td>
	<td class="result_celula" align="center" nowrap></td>
	<td class="result_celula" align="center" nowrap>Total</td>
	<td class="result_celula" align="right" nowrap>'.$financeiro_valor_total.'</td>
	<td class="result_celula" align="right" nowrap>'.$financeiro_desembolsado_total.'</td>
	<td class="result_celula" align="right" nowrap>'.$financeiro_troco_total.'</td>
	<td class="result_celula" align="right" nowrap>'.$valor_total.'</td>
    </tr>';

	echo $p_valor;
}
	?>
	<tr>
		<td colspan="18" class="barra_busca"><?	$financeiroDAO->QTDPagina(); ?></td>
	</tr>
</table>
</form>



<div id="windowMensagem">
<div id="windowMensagemTop">
<div id="windowMensagemTopContent"><img
	src="../images/icon/icon_mensagem.png" style="border: 0" /> Ação</div>
<img id="windowMensagemClose" src="../images/window_close.jpg"></div>
<div id="windowMensagemBottom">
<div id="windowMensagemBottomContent"></div>
</div>
<div id="windowMensagemContent">
<div id="carrega_mensagem_input"></div>

</div>
</div>
<script type="text/javascript">
$(document).ready(
	function()
	{
		$('#windowMensagemClose').bind(
			'click',
			function()
			{
				$('#windowMensagem').hide();
			}
		);
	}

);
</script>
</div>
<?php
	require('footer.php');
?>