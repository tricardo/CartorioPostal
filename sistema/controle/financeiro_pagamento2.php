<?require('header.php');

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);
$atividadeDAO = new AtividadeDAO();
$statusDAO = new StatusDAO();
$usuarioDAO = new UsuarioDAO();
$financeiroDAO = new FinanceiroDAO();
$contaDAO = new ContaDAO();
$pedidoDAO = new PedidoDAO();
$departamentoDAO = new DepartamentoDAO();
$atividadeverificaDAO = new AtividadeVerificaDAO();
$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','busca_submit');
if($busca_submit<>''){
	pt_register('GET','busca_id_fatura');	
	pt_register('GET','busca_id_status');	
	pt_register('GET','busca_id_atividade');	
	pt_register('GET','busca_forma_pagamento');	
	pt_register('GET','busca_autorizacao');	
	pt_register('GET','busca_id_pedido');	
	pt_register('GET','busca_ordenar');	
	pt_register('GET','busca');	
	pt_register('GET','busca_id_departamento');	
	pt_register('GET','busca_origem');	
	pt_register('GET','busca_data_i_a');	
	pt_register('GET','busca_data_f_a');	
	pt_register('GET','busca_data_i');	
	pt_register('GET','busca_data_f');	
	pt_register('GET','busca_data_ci');	
	pt_register('GET','busca_data_cf');	
	pt_register('GET','busca_data_recebido_i');	
	pt_register('GET','busca_data_recebido_f');	
	pt_register('GET','busca_forma');	
	pt_register('GET','busca_ord');	
	pt_register('GET','busca_id_pacote');	
	pt_register('GET','busca_e_cidade');	
	pt_register('GET','busca_e_estado');	
	pt_register('GET','busca_e_inicio');	
	pt_register('GET','busca_e_prazo');	
	pt_register('GET','busca_e_agenda');	
	pt_register('GET','busca_e_data_atividade');	
	pt_register('GET','busca_e_departamento');	
	pt_register('GET','busca_e_servico');	
	pt_register('GET','busca_e_status');	
	pt_register('GET','busca_e_atividade');	
	pt_register('GET','busca_e_responsavel');	
	pt_register('GET','busca_e_atendimento');	
	pt_register('GET','busca_e_devedor');	
	pt_register('GET','busca_e_forma');	
	pt_register('GET','busca_e_origem');	
	pt_register('GET','busca_e_cpf');	
	pt_register('GET','busca_e_nome');	
	pt_register('GET','busca_id_usuario');	
	pt_register('GET','busca_contato');
	$_SESSION['f_busca_contato'] 			= $busca_contato;	
	$_SESSION['f_busca_id_status'] 			= $busca_id_status;	
	$_SESSION['f_busca_id_atividade'] 		= $busca_id_atividade;	
	$_SESSION['f_busca_forma_pagamento'] 	= $busca_forma_pagamento;	
	$_SESSION['f_busca_autorizacao'] 		= $busca_autorizacao;	
	$_SESSION['f_busca_id_pedido']			= $busca_id_pedido;	
	$_SESSION['f_busca_ordenar'] 			= $busca_ordenar;	
	$_SESSION['f_busca_ord'] 				= $busca_ord;	
	$_SESSION['f_busca'] 					= $busca;	
	$_SESSION['f_busca_id_departamento'] 	= $busca_id_departamento;	
	$_SESSION['p_busca_origem'] 			= $busca_origem;	
	$_SESSION['f_busca_data_i_a'] 			= $busca_data_i_a;	
	$_SESSION['f_busca_data_f_a'] 			= $busca_data_f_a;	
	$_SESSION['f_busca_data_i']   			= $busca_data_i;	
	$_SESSION['f_busca_data_f']   			= $busca_data_f;	
	$_SESSION['f_busca_id_pacote']   		= $busca_id_pacote;	
	setcookie ("f_busca_e_inicio", $busca_e_inicio);	
	setcookie ("f_busca_e_prazo", $busca_e_prazo);	
	setcookie ("f_busca_e_agenda", $busca_e_agenda);	
	setcookie ("f_busca_e_data_atividade", $busca_e_data_atividade);	
	setcookie ("f_busca_e_forma", $busca_e_forma);	
	setcookie ("f_busca_e_departamento", $busca_e_departamento);	
	setcookie ("f_busca_e_servico", $busca_e_servico);	
	setcookie ("f_busca_e_status", $busca_e_status);	
	setcookie ("f_busca_e_atividade", $busca_e_atividade);	
	setcookie ("f_busca_e_responsavel", $busca_e_responsavel);	
	setcookie ("f_busca_e_atendimento", $busca_e_atendimento);	
	setcookie ("f_busca_e_devedor", $busca_e_devedor);	
	setcookie ("f_busca_e_cpf", $busca_e_cpf);	
	setcookie ("f_busca_e_nome", $busca_e_nome);	
	setcookie ("f_busca_e_origem", $busca_e_origem);	
	setcookie ("f_busca_e_cidade", $busca_e_cidade);	
	setcookie ("f_busca_e_estado", $busca_e_estado);
} else {
	$busca_id_status         	= $_SESSION['f_busca_id_status'];
	$busca_id_atividade      	= $_SESSION['f_busca_id_atividade'];
	$busca_contato		    	= $_SESSION['f_busca_contato'];
	$busca_forma_pagamento   	= $_SESSION['f_busca_forma_pagamento'];
	$busca_autorizacao       	= $_SESSION['f_busca_autorizacao'];
	$busca_id_pedido         	= $_SESSION['f_busca_id_pedido'];
	$busca_ordenar           	= $_SESSION['f_busca_ordenar'];
	$busca                   	= $_SESSION['f_busca'];
	$busca_origem				= $_SESSION['p_busca_origem'] ;
	$busca_id_departamento   	= $_SESSION['f_busca_id_departamento'];
	$busca_data_i_a          	= $_SESSION['f_busca_data_i_a'];
	$busca_data_f_a          	= $_SESSION['f_busca_data_f_a'];
	$busca_data_i            	= $_SESSION['f_busca_data_i'];
	$busca_data_f            	= $_SESSION['f_busca_data_f'];
	$busca_data_ci           	= $_SESSION['f_busca_data_ci'];
	$busca_data_cf           	= $_SESSION['f_busca_data_cf'];	
	$busca_id_pacote         	= $_SESSION['f_busca_id_pacote'];	
	$busca_e_inicio   			= $_COOKIE['f_busca_e_inicio'] ;	
	$busca_e_prazo   			= $_COOKIE['f_busca_e_prazo'] ;	
	$busca_e_agenda   			= $_COOKIE['f_busca_e_agenda'] ;	
	$busca_e_data_atividade 	= $_COOKIE['f_busca_e_data_atividade'] ;	
	$busca_e_forma   			= $_COOKIE['f_busca_e_forma'] ;	
	$busca_e_departamento   	= $_COOKIE['f_busca_e_departamento'] ;	
	$busca_e_servico   			= $_COOKIE['f_busca_e_servico'] ;	
	$busca_e_status   			= $_COOKIE['f_busca_e_status'] ;	
	$busca_e_atividade   		= $_COOKIE['f_busca_e_atividade'] ;	
	$busca_e_responsavel   		= $_COOKIE['f_busca_e_responsavel'] ;	
	$busca_e_atendimento   		= $_COOKIE['f_busca_e_atendimento'] ;	
	$busca_e_devedor	   		= $_COOKIE['f_busca_e_devedor'] ;	
	$busca_e_cpf		   		= $_COOKIE['f_busca_e_cpf'];	
	$busca_e_nome	   			= $_COOKIE['f_busca_e_nome'];	
	$busca_e_origem	   			= $_COOKIE['f_busca_e_origem'];	
	$busca_e_cidade  			= $_COOKIE['f_busca_e_cidade'] ;	
	$busca_e_estado   			= $_COOKIE['f_busca_e_estado'] ;
}

if($busca_e_prazo<>'') $busca_e_prazo=''; 
else $busca_e_prazo='on';

if($busca_e_inicio<>'') $busca_e_inicio=''; 
else $busca_e_inicio='on';

if($busca_e_agenda<>'') $busca_e_agenda=''; 
else $busca_e_agenda='on';

if($busca_e_data_atividade<>'') $busca_e_data_atividade=''; 
else $busca_e_data_atividade='on';

if($busca_e_departamento<>'') $busca_e_departamento=''; 
else $busca_e_departamento='on';

if($busca_e_servico<>'') $busca_e_servico=''; 
else $busca_e_servico='on';

if($busca_e_status<>'') $busca_e_status=''; 
else $busca_e_status='on';

if($busca_e_atividade<>'') $busca_e_atividade=''; 
else $busca_e_atividade='on';

if($busca_e_responsavel<>'') $busca_e_responsavel=''; 
else $busca_e_responsavel='on';

if($busca_e_atendimento<>'') $busca_e_atendimento=''; 
else $busca_e_atendimento='on';

if($busca_e_devedor<>'') $busca_e_devedor=''; 
else $busca_e_devedor='on';

if($busca_e_cpf<>'') $busca_e_cpf=''; 
else $busca_e_cpf='on';

if($busca_e_nome<>'') $busca_e_nome=''; 
else $busca_e_nome='on';

if($busca_e_forma<>'') $busca_e_forma=''; 
else $busca_e_forma='on';

if($busca_e_cidade<>'') $busca_e_cidade=''; 
else $busca_e_cidade='on';

if($busca_e_estado<>'') $busca_e_estado=''; 
else $busca_e_estado='on';

if($busca_e_origem<>'') $busca_e_origem=''; else 
$busca_e_origem='on';

if($busca_data_i <> '') $busca_data_i = invert($busca_data_i,'-','SQL'); 
else $busca_data_i = date('2009-m-d');

if($busca_data_f <> '') $busca_data_f = invert($busca_data_f,'-','SQL'); 
else $busca_data_f = date('Y-m-d');

if($busca_data_ci <> '') $busca_data_ci = invert($busca_data_ci,'-','SQL');
if($busca_data_cf <> '') $busca_data_cf = invert($busca_data_cf,'-','SQL');
if($busca_data_i_a <> '') $busca_data_i_a = invert($busca_data_i_a,'-','SQL'); else $busca_data_i_a = date('2009-m-d');
if($busca_data_f_a <> '') $busca_data_f_a = invert($busca_data_f_a,'-','SQL'); else $busca_data_f_a = date('Y-m-d');
if($busca_autorizacao=='') $busca_autorizacao='À Receber';
if(in_array('1',$departamento_p)!=1 and $busca_id_usuario_op=='' and (in_array('3',$departamento_p)==1 or in_array('4',$departamento_p)==1 or in_array('5',$departamento_p)==1 or in_array('8',$departamento_p)==1 or in_array('9',$departamento_p)==1 or in_array('11',$departamento_p)==1 or in_array('12',$departamento_p)==1))
{ $busca_id_usuario_op = $controle_id_usuario; }
$buscap = new stdClass();
$buscap->busca_ord=$busca_ord;
$buscap->busca_ordenar=$busca_ordenar;
$buscap->busca_id_fatura=$busca_id_fatura;
$buscap->busca_data_i=$busca_data_i;
$buscap->busca_data_f=$busca_data_f;
$buscap->busca_data_ci=$busca_data_ci;
$buscap->busca_data_cf=$busca_data_cf;
$buscap->busca_data_i_a=$busca_data_i_a;
$buscap->busca_data_f_a=$busca_data_f_a;
$buscap->busca_id_pedido=$busca_id_pedido;
$buscap->busca_autorizacao=$busca_autorizacao;
$buscap->busca_id_status=$busca_id_status;
$buscap->busca_id_usuario_op=$busca_id_usuario_op;
$buscap->busca_id_departamento=$busca_id_departamento;
$buscap->busca_origem=$busca_origem;
$buscap->busca_id_atividade=$busca_id_atividade;
$buscap->busca_forma_pagamento=$busca_forma_pagamento;
$buscap->busca_contato=$busca_contato;
$buscap->busca_id_usuario=$busca_id_usuario;
$buscap->busca=$busca;
$buscap->busca_id_pacote=$busca_id_pacote;

?>
<div id="topo">	
	<h1 class="tit"><img src="../images/tit/tit_recebimento.png" alt="Título" />Recebimentos de Clientes</h1><a href="#" class="topo">topo</a>
	<hr class="tit" />
</div>
<div id="meio">
<?
pt_register('POST','submit_financeiro_reprovar');
if ($submit_financeiro_reprovar<>'') {	require('../includes/financeiro_reprovar.php'); }

pt_register('POST','submit_financeiro_receber');
if ($submit_financeiro_receber<>'') {	
	require('../includes/financeiro_aprovar.php');
} 

pt_register('POST','submit_financeiro_aprovar_valor');
if ($submit_financeiro_aprovar_valor<>'') {	
	require('../includes/financeiro_aprovar_aplica.php');
}

pt_register('POST','submit_faturar');
if ($submit_faturar<>'') {	
	require('../includes/financeiro_faturar.php');
}

pt_register('POST','submit_faturar_aplica');
if ($submit_faturar_aplica<>'') {	
	require('../includes/financeiro_faturar_aplica.php');
}
pt_register('GET','submit_faturar_fecha');
if ($submit_faturar_fecha<>'') {	
	require('../includes/financeiro_faturar_fecha.php');
}
pt_register('GET','submit_faturar_limpa');
if ($submit_faturar_limpa<>'') {	
	unset( $_SESSION['fat_pedido'] );
	unset( $_SESSION['fat_cpf'] );
	unset( $_SESSION['fat_acao'] );
}?>
<form name="buscador" action="" method="get" ENCTYPE="multipart/form-data">
<div class="busca1">	
	<label>Buscar:</label> 	
	<input type="text" class="form_estilo" name="busca"	value="<?= $busca ?>" style="width: 200px; float: left" />	
	<? if($controle_id_empresa==1){ ?>	
	<label>Fatura:</label> 	
	<input type="text" class="form_estilo" name="busca_id_fatura" value="<?= $busca_id_fatura ?>" style="width: 200px; float: left" />	
	<? } ?>	
	<label>Situação:</label> 	
	<select name="busca_autorizacao" style="width: 200px; float: left" class="form_estilo">		
		<option value="À Receber" <? if($busca_autorizacao=='' or $busca_autorizacao=='À Receber') echo 'selected="select"'; ?>>À Receber</option>
		<option value="Recebido" <? if($busca_autorizacao=='Recebido') echo 'selected="select"'; ?>>Recebido</option>
	</select>
	<label>Status:</label>
 	<select name="busca_id_status" style="width: 200px; float: left" class="form_estilo">
	<option value="Todos">Todos</option>
	<?
		$p_valor = '';		
		$var = $statusDAO->listarTodos();		
		foreach($var as $s){			
			$p_valor .= '<option value="'.$s->id_status.'"';			
			if($busca_id_status==$s->id_status) $p_valor .= ' selected="selected" ';			
			$p_valor .=  ' >'.$s->status.'</option>';		
		}
		echo $p_valor;
	?>	
	</select> 
	<label>Forma:</label> 	
	<select name="busca_forma_pagamento" style="width: 200px; float: left" class="form_estilo">		
		<option value=""></option>		
		<?		
		$p_valor = '';		
		$var = $financeiroDAO->listarFormaPagamento();		
		foreach($var as $s){			
			$p_valor .= '<option value="'.$s->forma_pagamento.'"';			
			if($busca_forma_pagamento==$s->forma_pagamento) $p_valor .= ' selected="selected" ';			
			$p_valor .=  ' >'.$s->forma_pagamento.'</option>';	
		}		
		echo $p_valor;
		?>	
	</select>
	
	<label>Atividade:</label>
	<select name="busca_id_atividade" style="width: 200px; float: left" class="form_estilo">
		<option value="" <? if($busca_id_atividade=='') echo ' selected="selected" '; ?>>Todos</option>
		<?	
		$p_valor = '';
		$var = $atividadeDAO->listaAtividadesTodas();		
		foreach($var as $s){			
			$p_valor .= '<option value="'.$s->id_atividade.'"';			
			if($busca_id_atividade==$s->id_atividade) $p_valor .= ' selected="selected" ';			
			$p_valor .=  ' >'.$s->atividade.'</option>';
		}		
		echo $p_valor;		
		?>
	</select>
	
	<label>Pacote:</label> 	
	<select name="busca_id_pacote" style="width: 200px; float: left" class="form_estilo">		
		<option value="" <? if($busca_id_pacote=='') echo ' selected="selected" '; ?>>Sem Pacote</option>		
		<?	
		$p_valor = '';		
		$var = $financeiroDAO->listarPacote();		
		foreach($var as $s){			
			$p_valor .= '<option value="'.$s->id_pacote.'"';			
			if($busca_id_pacote==$s->id_pacote) $p_valor .= ' selected="selected" ';
			$p_valor .=  ' >'.$s->pacote.'</option>';		
		}
		echo $p_valor;		
		?>	
	</select>	
	<label>Ordenar Por: </label>
	<select name="busca_ordenar" style="width: 150px; float: left" class="form_estilo">		
		<option value="" <? if($busca_ordenar=='') echo ' selected="selected" '; ?>></option>		
		<option value="Ordem" <? if($busca_ordenar=='Ordem') echo ' selected="selected" '; ?>>Ordem</option>		
		<option value="Documento de" <? if($busca_ordenar=='Documento de') echo ' selected="selected" '; ?>>Documento de</option>		
		<option value="Devedor" <? if($busca_ordenar=='Devedor') echo ' selected="selected" '; ?>>Devedor</option>		
		<option value="Data" <? if($busca_ordenar=='Data') echo ' selected="selected" '; ?>>Data</option>		
		<option value="Departamento" <? if($busca_ordenar=='Departamento') echo ' selected="selected" '; ?>>Departamento</option>		
		<option value="Serviço" <? if($busca_ordenar=='Serviço') echo ' selected="selected" '; ?>>Serviço</option>		
		<option value="Cidade" <? if($busca_ordenar=='Cidade') echo ' selected="selected" '; ?>>Cidade</option>		
		<option value="Prazo" <? if($busca_ordenar=='Prazo') echo ' selected="selected" '; ?>>Prazo</option>		
		<option value="Agenda" <? if($busca_ordenar=='Agenda') echo ' selected="selected" '; ?>>Agenda</option>		
		<option value="Data Status"	<? if($busca_ordenar=='Data Status') echo ' selected="selected" '; ?>>Data Status</option>	
	</select> 	
	
	<select name="busca_ord" style="width: 50px; padding-top: 5px; float: left" class="form_estilo">		
		<option value="" <? if($busca_ord=='') echo ' selected="selected" '; ?>>Cres</option>		
		<option value="Decr" <? if($busca_ord=='Decr') echo ' selected="selected" '; ?>>Decr</option>	
	</select>
</div>

<div class="busca2">	
	<label>Origem:</label> 	
	<select name="busca_origem" style="width: 200px; float: left" class="form_estilo">		
		<option value="">Todos</option>		
		<?
		$lista = $pedidoDAO->listarOrigem();		
		foreach($lista as $l){			
			echo '<option value="'.$l->origem.'"';			
			if($busca_origem==$l->origem) echo ' selected="selected" ';			
			echo ' >'.$l->origem.'</option>';		
		}
		?>	
	</select> 	

	<label>Departamento: </label> 	
	<select name="busca_id_departamento" style="width: 200px; float: left" class="form_estilo">
		<option value=""<? if($busca_id_departamento=='') echo ' selected="selected" '; ?>>Todos</option>		
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
	<label>Atendente: </label>        
	<select name="busca_id_usuario" style="width:200px" class="form_estilo">            
		<option value="" <? if($busca_id_usuario=='') echo ' selected="selected" '; ?>>Todos</option>            
		<?php				
		$p_valor_combo = '';				
		$var = $usuarioDAO->listarAtendentes($controle_id_empresa);				
		foreach($var as $s){					
			$p_valor_combo .= '<option value="'.$s->id_usuario.'"';					
			if($busca_id_usuario==$s->id_usuario) $p_valor_combo .= ' selected="selected" ';					
			$p_valor_combo .=  ' >'.$s->nome.'</option>';				
		}				
		echo $p_valor_combo;            
		?>		
	</select>	
	<? if($controle_id_empresa=='1'){ ?>		
	<label>Contato HSBC: </label>		
	<select name="busca_contato" style="width: 200px; float: left" class="form_estilo">			
		<option value="" <? if($busca_contato=='') echo ' selected="selected" '; ?>>Todos</option>			
		<?	$p_valor = '';			
		$var = $financeiroDAO->listarConveniadoHSBC();			
		foreach($var as $s){				
			$p_valor .= '<option value="'.$s->nome.'"';				
			if($busca_contato==$s->nome) $p_valor .= ' selected="selected" ';				
			$p_valor .=  ' >'.$s->nome.'</option>';			
		}				
		echo $p_valor;			
		?>
	</select>	
	<? } ?>	
	<label>Aberto Entre: </label> 	
	<input type="text" name="busca_data_i" value="<? if($busca_data_i <> '') echo invert($busca_data_i,'/','PHP'); ?>" style="width: 90px; float: left" class="form_estilo" /> 	
	<strong	style="width: 10px; font-weight: bold; padding-top: 5px; float: left">e</strong>	
	<input type="text" name="busca_data_f" value="<?  if($busca_data_f <> '') echo invert($busca_data_f,'/','PHP'); ?>"	style="width: 90px; float: left" class="form_estilo" /> 		
	
	<label>Alterado Entre: </label> 	
	<input style="width: 90px; float: left" type="text" name="busca_data_i_a" value="<? if($busca_data_i_a <> '') echo invert($busca_data_i_a,'/','PHP').' '.substr($busca_data_i_a,11, 8); ?>" class="form_estilo" /> 	
	<strong	style="width: 10px; font-weight: bold; padding-top: 5px; float: left">e</strong>	
	<input style="width: 90px; float: left" type="text" name="busca_data_f_a" value="<?  if($busca_data_f_a <> '') echo invert($busca_data_f_a,'/','PHP').' '.substr($busca_data_f_a,11, 8); ?>" class="form_estilo" />		
	<label>Concl. Entre: </label> 	
	<input type="text" name="busca_data_ci" value="<? if($busca_data_ci <> '') echo invert($busca_data_ci,'/','PHP'); ?>" style="width: 90px; float: left" class="form_estilo" /> 	
	<strong	style="width: 10px; font-weight: bold; padding-top: 5px; float: left">e</strong>	
	<input type="text" name="busca_data_cf" value="<?  if($busca_data_cf <> '') echo invert($busca_data_cf,'/','PHP'); ?>" style="width: 90px; float: left" class="form_estilo" />	 	
	
	<label>Ordem:</label> 	
	<input type="text" name="busca_id_pedido" value="<?= $busca_id_pedido ?>" style="width: 90px; float: left" class="form_estilo" /> 	
	<input type="submit" name="busca_submit" class="button_busca" value=" Buscar " /></div><div class="busca_campos">	
	<div class="form_estilo" id="selecionar_campos">		
		<input type="checkbox" name="busca_e_nome" <? if($busca_e_nome=='') echo 'checked' ?> />Documento de <br>		
		<input type="checkbox" name="busca_e_cpf"<? if($busca_e_cpf=='') echo 'checked' ?> />CPF/CNPJ <br>		
		<input type="checkbox" name="busca_e_inicio"<? if($busca_e_inicio=='') echo 'checked' ?> />Início <br>		
		<input type="checkbox" name="busca_e_prazo"<? if($busca_e_prazo=='') echo 'checked' ?> />Prazo <br>		
		<input type="checkbox" name="busca_e_agenda"<? if($busca_e_agenda=='') echo 'checked' ?> />Agenda <br>		
		<input type="checkbox" name="busca_e_data_atividade"<? if($busca_e_data_atividade=='') echo 'checked' ?> />Data do Status <br>		
		<input type="checkbox" name="busca_e_departamento"<? if($busca_e_departamento=='') echo 'checked' ?> />Departamento <br>		
		<input type="checkbox" name="busca_e_servico"<? if($busca_e_servico=='') echo 'checked' ?> />Serviço <br>		
		<input type="checkbox" name="busca_e_cidade"<? if($busca_e_cidade=='') echo 'checked' ?> />Cidade <br>		
		<input type="checkbox" name="busca_e_estado"<? if($busca_e_estado=='') echo 'checked' ?> />Estado <br>		
		<input type="checkbox" name="busca_e_status"<? if($busca_e_status=='') echo 'checked' ?> />Status <br>		
		<input type="checkbox" name="busca_e_atividade"<? if($busca_e_atividade=='') echo 'checked' ?> />Atividade <br>	
		<input type="checkbox" name="busca_e_atendimento"<? if($busca_e_atendimento=='') echo 'checked' ?> />Atendimento <br>		
		<input type="checkbox" name="busca_e_devedor"<? if($busca_e_devedor=='') echo 'checked' ?> />Devedor <br>		
		<input type="checkbox" name="busca_e_forma"<? if($busca_e_forma=='') echo 'checked' ?> />Forma de Pagamento <br>		
		<input type="checkbox" name="busca_e_origem" <? if($busca_e_origem=='') echo 'checked' ?> />Origem	
	</div>
	</div>
	<? if($_SESSION['fat_cpf']<>''){ ?>
		<div class="busca_fatura">	
			<b><a href="#" onclick="if(document.getElementById('selecionar_fatura').style.visibility=='hidden') document.getElementById('selecionar_fatura').style.visibility='visible'; else document.getElementById('selecionar_fatura').style.visibility='hidden';">
				Seleção de Faturamento
			</a></b>
			<br/>	
			<div class="form_estilo" style="visibility:hidden" id="selecionar_fatura">
			<?	echo '<input type="submit" name="submit_faturar_fecha" value="Concluir" class="button_busca"> CPF:'.$_SESSION['fat_cpf'].'';
			echo '<input type="submit" name="submit_faturar_limpa" value="Limpar" class="button_busca">';
			$lista = $_SESSION['fat_pedido'];
			$p_valor = '<ul><li><b>Ordem</b></li><li><b>Honorário</b></li><li><b>Custas</b></li>';			
			foreach($lista as $l){				
				if($l->id_pedido=='') break;				
				$p_valor .= '<li>'.$l->id_pedido.'</li><li>R$ '.$l->valor.'</li><li>R$ '.$l->custa.'</li>';			
			}			
			echo $p_valor.'</ul>';		
			?>	
			</div>
		</div>
	<? } ?>
</form>

<form name="f1" action="" method="post" ENCTYPE="multipart/form-data">	
	<div style="postition:relative; clear: both; padding:40px 5px 5px 5px;">
		<input type="submit" name="submit_acao"	onclick="document.f1.target='_self'; document.f1.action='pedido.php'" class="button_busca" value=" Alterar Status " />&nbsp; 		
		<!-- <input type="submit" name="submit_financeiro_recibo" class="button_busca" value=" Recibo " onclick="document.f1.target='_blank'; document.f1.action='gera_recibo.php'" />&nbsp; -->		
		<input type="submit" name="submit_financeiro_receber" class="button_busca" value=" Aprovar " onclick="document.f1.target='_self'; document.f1.action=''" />&nbsp;
		<? if($busca_id_status==2){ ?>			
			<input type="submit" name="submit_financeiro_reprovar" class="button_busca" value=" Reprovar " onclick="document.f1.target='_self'; document.f1.action=''" />&nbsp; 		
		<? }
		if($controle_id_empresa==1){ ?>			
			<input type="submit" name="submit_faturar" class="button_busca" value=" Faturar " onclick="document.f1.target='_self'; document.f1.action=''" />&nbsp;
		<? } ?>		
		<input type="submit" name="submit_exporta" onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_f.php'" class="button_busca" value=" Exportar " /> 		
		<? if($controle_id_empresa=='1'){ ?>		
			<input type="submit" name="submit_exporta_2" onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_f_todos.php'" class="button_busca" value=" Exportar Todos " /> 		
		<? } ?>
	</div>
<?php

#recebido ou a receber
pt_register('GET','pagina');
if($pagina=='') {
	echo "
	<script>
		eraseCookie('p_id_pedido_item');
		eraseCookie('p_id_pedido');
	</script>
	";
	unset( $_COOKIE['p_id_pedido_item'] );
	unset( $_COOKIE['p_id_pedido'] );
}
$cont=0;
$buscapedido = $financeiroDAO->buscaRecebimento($buscap,$controle_id_empresa,$pagina);
echo '<b>Valor Total: </b> R$ '.$buscapedido[0]->valor_t.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Valor Recebido:</b> R$ '.$buscapedido[0]->valor_rec_t;
?>
<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">	
	<tr>
	<td colspan="23" class="barra_busca"><? $financeiroDAO->QTDPagina(); ?></td></tr>	<?
	$p_valor = '
	<tr>
		<td align="center" width="20" class="result_menu">			
		<input type="checkbox" name="todos" onclick="if(this.checked==1) { selecionar_tudo_cache(\'p_id_pedido_item\'); selecionar_tudo(); } else { deselecionar_tudo_cache(\'p_id_pedido_item\'); deselecionar_tudo(); }"></td>
		<td align="center" width="60" class="result_menu"><b>Editar</b></td>';	
	if($controle_id_empresa==1){		
		$p_valor .= '<td align="center" width="50" class="result_menu"><b>Novo Boleto</b></td>';	
	}
	$p_valor .= '		<td align="center" width="50" class="result_menu"><b>Ordem</b></td>
		<td class="result_menu"><b>Solicitante</b></td>
		';
	if($controle_id_empresa==1) 	$p_valor .=  '<td class="result_menu"><b>Fatura</b></td>';
	if($busca_e_cpf=='') 			$p_valor .=  '<td class="result_menu"><b>CNPJ/CPF</b></td>';
	if($busca_e_nome=='') 			$p_valor .=  '<td class="result_menu"><b>Documento de</b></td>';
	if($busca_e_devedor=='') 		$p_valor .=  '<td class="result_menu"><b>Devedor</b></td>';
	if($busca_e_inicio=='') 		$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Início</b></td>';
	if($busca_e_prazo=='') 			$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Prazo</b></td>';	if($busca_e_agenda=='') 		$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Agenda</b></td>';	if($busca_e_data_atividade=='') $p_valor .=  '<td align="center" width="50" class="result_menu"><b>Data Status</b></td>';	if($busca_e_forma=='') 			$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Forma</b></td>';	if($busca_e_origem=='') 		$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Origem</b></td>';	$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Valor</b></td>	<td align="center" width="50" class="result_menu"><b>Recebido</b></td>';
	if($busca_e_departamento=='')	$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Departamento</b></td>';	if($busca_e_servico=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Serviço</b></td>';	if($busca_e_atividade=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Atividade</b></td>';	if($busca_e_cidade=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Cidade</b></td>';	if($busca_e_estado=='') 		$p_valor .=  '<td align="center" width="40" class="result_menu"><b>UF</b></td>';	if($busca_e_status=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Status</b></td>';	
	#if($busca_e_responsavel=='') 	#$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Responsável</b></td>';	
	if($busca_e_atendimento=='') 	$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Atendimento</b></td>';	$p_valor .=  '</tr>';
	$p_id_pedido_item = explode(',',$_COOKIE["p_id_pedido_item"]);	
	foreach($buscapedido as $p){		
		if($p->id_pedido_item<>''){			
			$cont++;			
			$valor_total      = (float)($valor_total)+(float)($p->valor);
			$financeiro_valor_total      = (float)($financeiro_valor_total)+(float)($p->total);	
			if(in_array($p->id_pedido_item,$p_id_pedido_item)==1) $item_checked = ' checked '; else $item_checked = '';
			$p_valor .= '<tr>			
				<td class="result_celula" align="center" nowrap>				
				<input type="hidden" name="acao_' . $cont .'" value="' . $p->id_pedido_item .'"/>
				<input type="hidden" name="acao_pedido_' . $cont .'" value="' . $p->id_pedido . '/'.$p->ordem .'"/>
				<input type="checkbox" name="acao_sel_' . $cont .'" value="' . $p->id_pedido_item .'" onclick="if(this.checked==true) { createCookie(\'p_id_pedido_item\',\''.$p->id_pedido_item.',\',\'1\',\'1\'); createCookie(\'p_id_pedido\',\'#'.$p->id_pedido.'/'.$p->ordem.',\',\'1\',\'1\'); } else {eraseCookieItem(\'p_id_pedido_item\',\''.$p->id_pedido_item.'\'); eraseCookieItem(\'p_id_pedido\',\'#'.$p->id_pedido.'/'.$p->ordem.'\'); }" '.$item_checked.' />			
				</td>
				<td class="result_celula" align="center"><a href="pedido_edit.php?id=' . $p->id_pedido . '&ordem=' . $p->ordem . '" target="_blank">
					<img src="../images/botao_editar.png" title="Editar" border="0"/></a>
				</td>';			
			if($controle_id_empresa==1) {
				if($p->id_fatura<>0) $p_valor .=  '<td class="result_celula" align="center"><a href="financeiro_boleto_add.php?id_fatura=' . $p->id_fatura . '" target="_blank"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>'; 				
				else $p_valor .=  '<td class="result_celula" align="center">-</td>';
			}
			$p_valor .= '			<td class="result_celula" align="center" nowrap>#' . $p->id_pedido . '/'.$p->ordem.'</td>			
			<td class="result_celula" nowrap>' . $p->nome .'</td>';			
			if($controle_id_empresa==1) 	$p_valor .=  '<td class="result_celula"><a href="rel_baixar_boleto_fat.php?id='.$p->id_fatura.'">'.$p->id_fatura.'</a></td>';			
			if($busca_e_cpf=='') 			$p_valor .=  '<td class="result_celula" nowrap>' . str_replace('/','',str_replace('-','',str_replace('.','',$p->cpf))) .'</td>';			if($busca_e_nome=='') 			
			$p_valor .=  '<td class="result_celula" nowrap>' . $p->certidao_nome.'</td>';			
			if($busca_e_devedor=='') 		$p_valor .=  '<td class="result_celula" nowrap>' . $p->certidao_devedor.'</td>';			
			if($busca_e_inicio=='')			$p_valor .=  '<td class="result_celula" align="center" nowrap>' . invert($p->inicio,'/','PHP') . '</td>';
			if($busca_e_prazo=='') 			$p_valor .=  '<td class="result_celula" align="center" nowrap>' . invert($p->data_prazo,'/','PHP') . '</td>';
			if($busca_e_agenda=='') 		$p_valor .=  '<td class="result_celula" align="center" nowrap>' . invert($p->data_i,'/','PHP') . '</td>';			
			if($busca_e_data_atividade=='') $p_valor .=  '<td class="result_celula" align="center" nowrap>' . invert($p->data_atividade,'/','PHP') . '</td>';	
			if($busca_e_forma=='') 			$p_valor .=  '<td class="result_celula" align="center" nowrap>' . $p->forma_pagamento .'</td>';	
			if($busca_e_origem=='') 		$p_valor .=  '<td class="result_celula" align="center" nowrap> ' . $p->origem .'</td>';			
			$p_valor .=  '<td class="result_celula" align="right" nowrap>R$ ' . number_format($p->valor,2,".","") . '</td>			
			<td class="result_celula" align="right" nowrap>R$ ' . number_format($p->total,2,".","") . '</td>';			
			if($busca_e_departamento=='') 	$p_valor .=  '<td class="result_celula" nowrap>' . $p->departamento . '</td>';			
			if($busca_e_servico=='') 		$p_valor .=  '<td class="result_celula" nowrap>' . $p->servico . '</td>';			
			if($busca_e_cidade=='') 		$p_valor .= '<td class="result_celula'.$class.'" align="center" nowrap>' . $p->certidao_cidade . '</td>';
			if($busca_e_estado=='') 		$p_valor .= '<td class="result_celula'.$class.'" align="center" nowrap>' . $p->certidao_estado . '</td>';
			if($busca_e_atividade=='') 		$p_valor .=  '<td class="result_celula" nowrap>' . $p->atividade . '</td>';			
			if($busca_e_status=='') 		$p_valor .=  '<td class="result_celula" nowrap>' . $p->status . '</td>';
			#if($busca_e_responsavel=='') 	$p_valor .=  '<td class="result_celula" nowrap>' . $p->nome_resp . '</td>';			
			if($busca_e_atendimento=='') 	$p_valor .=  '<td class="result_celula" nowrap>' . $p->atendente . '</td>';			
			$p_valor .=  '</tr>';		
		}
	}
	$p_valor .= '<tr>	
		<td class="result_celula" align="center" nowrap></td>	
		<td class="result_celula" align="center"></td>    
		<td class="result_celula" align="center" nowrap></td>   
		<td class="result_celula" nowrap></td>';	
	if($controle_id_empresa==1){
		$p_valor .= '<td class="result_celula" nowrap></td>';
	}
	if($controle_id_empresa==1) 	$p_valor .=  '<td class="result_celula" nowrap></td>';
	$valor_total            = 'R$ '.number_format($valor_total,2,".",",");	
	$financeiro_valor_total            = 'R$ '.number_format($financeiro_valor_total,2,".",",");	
	if($busca_e_cpf=='') 			$p_valor .=  '<td class="result_celula" nowrap></td>';	
	if($busca_e_nome=='') 			$p_valor .=  '<td class="result_celula" nowrap></td>';	
	if($busca_e_devedor=='') 		$p_valor .=  '<td class="result_celula" nowrap></td>';	
	if($busca_e_inicio=='')			$p_valor .=  '<td class="result_celula" align="center" nowrap></td>';	
	if($busca_e_prazo=='') 			$p_valor .=  '<td class="result_celula" align="center" nowrap></td>';	
	if($busca_e_agenda=='') 		$p_valor .=  '<td class="result_celula" align="center" nowrap></td>';	
	if($busca_e_data_atividade=='') $p_valor .=  '<td class="result_celula" align="center" nowrap></td>';	
	if($busca_e_forma=='') 			$p_valor .=  '<td class="result_celula" align="center" nowrap></td>';	
	if($busca_e_origem=='')			$p_valor .=  '<td class="result_celula" align="center" nowrap></td>';	
	$p_valor .=  '<td class="result_celula" align="right" nowrap>'.$valor_total.'</td>	<td class="result_celula" align="right" nowrap>'.$financeiro_valor_total.'</td>';	if($busca_e_departamento=='') 	
	$p_valor .=  '<td class="result_celula" nowrap></td>';	
	if($busca_e_servico=='') $p_valor .=  '<td class="result_celula" nowrap></td>';	
	if($busca_e_cidade=='') 		$p_valor .=  '<td class="result_celula" nowrap></td>';	
	if($busca_e_estado=='') 		$p_valor .=  '<td class="result_celula" nowrap></td>';	
	if($busca_e_atividade=='') 		$p_valor .=  '<td class="result_celula" nowrap></td>';	
	if($busca_e_status=='') 		$p_valor .=  '<td class="result_celula" nowrap></td>';	
	if($busca_e_responsavel=='') 	$p_valor .=  '<td class="result_celula" nowrap></td>';	
	if($busca_e_atendimento=='') 	$p_valor .=  '<td class="result_celula" nowrap></td>';	
	$p_valor .=  '</tr>';	
	echo $p_valor;
?>	<tr>
		<td colspan="23" class="barra_busca">			
		<? $financeiroDAO->QTDPagina(); ?>		
		</td>
	</tr>
	</table>
	</form>	

	<div id="windowMensagem">		<div id="windowMensagemTop">			<div id="windowMensagemTopContent"><img src="../images/icon/icon_mensagem.png" style="border: 0" /> Ação</div>			<img id="windowMensagemClose" src="../images/window_close.jpg">		</div>		<div id="windowMensagemBottom">			<div id="windowMensagemBottomContent"></div>		</div>		<div id="windowMensagemContent">			<div id="carrega_mensagem_input"></div>		</div>	</div>	<script type="text/javascript">
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
</div><?php
require('footer.php');?>