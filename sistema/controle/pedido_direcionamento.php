<?
require('header.php');
require('../includes/dias_uteis.php');
$permissao = verifica_permissao('Direcionamento',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

pt_register('GET','busca_submit');
if($busca_submit<>''){
	pt_register('GET','busca_ordenar');
	pt_register('GET','busca_ord');
	pt_register('GET','busca_id_usuario_op');
	pt_register('GET','busca_id_status');
	pt_register('GET','busca_id_servico');
	pt_register('GET','busca_data_i');
	pt_register('GET','busca_data_f');
	pt_register('GET','busca_jadirecionados');
	pt_register('GET','busca_ordem');

	pt_register('GET','busca_e_inicio');
	pt_register('GET','busca_e_prazo');
	pt_register('GET','busca_e_data_atividade');
	pt_register('GET','busca_e_servico');
	pt_register('GET','busca_e_cidade');
	pt_register('GET','busca_e_estado');
	pt_register('GET','busca_e_status');
	pt_register('GET','busca_e_atividade');
	pt_register('GET','busca_e_responsavel');
	pt_register('GET','busca_e_atendimento');
	pt_register('GET','busca_e_devedor');
	pt_register('GET','estado_dir');
	if($estado_dir[0]!='Todos'){
		for($i=0;$i<count($estado_dir);$i++){
			$estado_dir2.="'".$estado_dir[$i]."',";
		}
	}

	setcookie ("p_busca_e_inicio", $busca_e_inicio);
	setcookie ("p_busca_e_prazo", $busca_e_prazo);
	setcookie ("p_busca_e_data_atividade", $busca_e_data_atividade);
	setcookie ("p_busca_e_servico", $busca_e_servico);
	setcookie ("p_busca_e_cidade", $busca_e_cidade);
	setcookie ("p_busca_e_estado", $busca_e_estado);
	setcookie ("p_busca_e_status", $busca_e_status);
	setcookie ("p_busca_e_atividade", $busca_e_atividade);
	setcookie ("p_busca_e_responsavel", $busca_e_responsavel);
	setcookie ("p_busca_e_atendimento", $busca_e_atendimento);
	setcookie ("p_busca_e_devedor", $busca_e_devedor);
	setcookie ("estado_dir", $estado_dir2);
} else {
	$busca_e_inicio   		= $_COOKIE['p_busca_e_inicio'];
	$busca_e_prazo   		= $_COOKIE['p_busca_e_prazo'];
	$busca_e_data_atividade 	= $_COOKIE['p_busca_e_data_atividade'];
	$busca_e_servico   		= $_COOKIE['p_busca_e_servico'];
	$busca_e_cidade  		= $_COOKIE['p_busca_e_cidade'];
	$busca_e_estado   		= $_COOKIE['p_busca_e_estado'];
	$busca_e_status   		= $_COOKIE['p_busca_e_status'];
	$busca_e_atividade   	= $_COOKIE['p_busca_e_atividade'];
	$busca_e_responsavel   	= $_COOKIE['p_busca_e_responsavel'];
	$busca_e_atendimento   	= $_COOKIE['p_busca_e_atendimento'];
	$busca_e_devedor	   		= $_COOKIE['p_busca_e_devedor'];
	$estado_dir2		   		= str_replace('\\','',$_COOKIE['estado_dir']);
}

if($busca_e_prazo<>'') $busca_e_prazo=''; else $busca_e_prazo='on';
if($busca_e_data_atividade<>'') $busca_e_data_atividade=''; else $busca_e_data_atividade='on';
if($busca_e_inicio<>'') $busca_e_inicio=''; else $busca_e_inicio='on';
if($busca_e_servico<>'') $busca_e_servico=''; else $busca_e_servico='on';
if($busca_e_cidade<>'') $busca_e_cidade=''; else $busca_e_cidade='on';
if($busca_e_estado<>'') $busca_e_estado=''; else $busca_e_estado='on';
if($busca_e_status<>'') $busca_e_status=''; else $busca_e_status='on';
if($busca_e_atividade<>'') $busca_e_atividade=''; else $busca_e_atividade='on';
if($busca_e_responsavel<>'') $busca_e_responsavel=''; else $busca_e_responsavel='on';
if($busca_e_atendimento<>'') $busca_e_atendimento=''; else $busca_e_atendimento='on';
if($busca_e_devedor<>'') $busca_e_devedor=''; else $busca_e_devedor='on';

if($busca_id_status=='') $busca_id_status='3';

$busca_data_i = ($busca_data_i <> '')? invert($busca_data_i,'-','SQL') : date('Y-m-d',strtotime("-1 year"));
$busca_data_f = ($busca_data_f <> '')? invert($busca_data_f,'-','SQL') : date('Y-m-d');

$busca = new stdClass();
$busca->busca_ord = $busca_ord;
$busca->busca_ordenar = $busca_ordenar;
$busca->estado_dir2 = $estado_dir2;
$busca->busca_data_i = $busca_data_i;
$busca->busca_data_f = $busca_data_f;
$busca->busca_id_usuario_op = $busca_id_usuario_op;
$busca->busca_jadirecionados = $busca_jadirecionados;
$busca->busca_id_status = $busca_id_status;
$busca->busca_id_servico = $busca_id_servico;
$busca->busca_ordem = $busca_ordem;
$busca->id_empresa = $controle_id_empresa;
$busca->busca_departamentos = explode(',',$controle_id_departamento_s);
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" />
Direcionamento de Ordens</h1>
<hr class="tit" />
<br />
</div>
<div id="meio"><?php 
$pedidoDAO = new PedidoDAO();
$atividadeDAO = new AtividadeDAO();
pt_register('POST','submit');
if($_SESSION['monitoramento_id_empresa']){
	if($_SESSION['monitoramento_id_empresa'] == 1){
		$inc_status_obs = "[".$_SESSION['monitoramento_nome']."] - ";
	}
} else {
	$inc_status_obs = "[".$controle_id_usuario.' : '.$controle_nome."] - ";
}
if ($submit) {//check for errors
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','id_usuario');

	$usuarioDAO = new UsuarioDAO();
	$u = $usuarioDAO->selectPorId($id_usuario);
	$resp_nome = $u->nome;

	$financeiroDAO = new FinanceiroDAO();

	$p_id_pedido_item = explode(',',$_COOKIE["dir_id_pedido_item"]);

	foreach($p_id_pedido_item  as $id_pedido_item){
		$cont_seg++;
		$pedidoItem = $pedidoDAO->buscaPorId($id_pedido_item, $controle_id_empresa);
		if($pedidoItem!=null and ($pedidoItem->operacional=='0000-00-00' and $pedidoItem->id_empresa_resp==$controle_id_empresa or $pedidoItem->id_empresa==$controle_id_empresa and $pedidoItem->id_empresa_resp=='0' or $pedidoItem->operacional<>'0000-00-00' and $pedidoItem->id_empresa_resp!=$controle_id_empresa and $pedidoItem->id_empresa_resp!='')){

			$pedidoItem->id_atividade = 191;
			$pedidoItem->id_usuario_op =$id_usuario;
			$pedidoItem->id_pedido_item =$id_pedido_item;
			$pedidoDAO->atualizaPedidoItemStatus($pedidoItem);
			$atividadeDAO->inserir(191,$inc_status_obs.' Atribuir para '.$resp_nome,$controle_id_usuario,$id_pedido_item);
		}
	}

	unset( $_COOKIE['p_id_pedido_item'] );
	unset( $_COOKIE['dir_id_pedido_item'] );
	unset( $_COOKIE['p_id_pedido'] );
	#unset( $_COOKIE['dir_id_pedido'] );
	echo "
	<script>
		eraseCookie('p_id_pedido_item');
		eraseCookie('p_id_pedido');
		eraseCookie('dir_id_pedido_item');
		
	</script>
	";
}
pt_register('POST','submit_empresa');
if ($submit_empresa) {//check for errors
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b>";
	pt_register('POST','id_empresa_resp');

	$empresaDAO = new EmpresaDAO();
	$emp = $empresaDAO->selectPorId($id_empresa_resp);
	if($emp->status!='Ativo' || $emp->id_empresa==$id_empresa_res || $emp==null) {
		$errors = 1;
		$error .= '<li>A franquia selecionada não está disponível para aceitar pedido!</li>';
	}
	$resp_nome = $emp->fantasia;

	if($errors!=1){
		$p_id_pedido_item = explode(',',$_COOKIE["dir_id_pedido_item"]);
		$errors='';
		$error='';

		$financeiroDAO = new FinanceiroDAO();
		array_pop($p_id_pedido_item);
		foreach($p_id_pedido_item  as $id_pedido_item){
			$contaDesembolso = $financeiroDAO->contaDesembolsos($id_pedido_item);
			if($contaDesembolso->total==0) {
				$errors = 1;
				$error .= '<li><b>Antes de direcionar é preciso pedir o desembolso com as custas e honorários da franquia. ['.$pedidoItem->id_pedido.'/'.$pedidoItem->ordem.']</b></li>';
			}

			$pedidoItem = $pedidoDAO->buscaPorId($id_pedido_item, $controle_id_empresa);
			if($pedidoItem->id_empresa_resp<>0) {
				$errors = 1;
				$error .= '<li><b>Você não pode direcionar esse pedido para outra franquia, porque já está direcionado['.$pedidoItem->id_pedido.'/'.$pedidoItem->ordem.']</b></li>';
			}

			//			#verifica se já foi concluído
			if($pedidoItem->operacional!='0000-00-00' and $pedidoItem->operacional<>'') {
				$errors = 1;
				$error .= '<li><b>Esse pedido já foi concluído pelo operacional e não pode ser direcionado.['.$id_pedido_item.']</b></li>';
			}

			if($errors!=1){
				$pedidoItem->id_atividade = 206;
				$pedidoItem->id_status = 19;
				$pedidoItem->id_usuario_op2 = $pedidoItem->id_usuario_op;
				$pedidoItem->id_usuario_op ='';
				$pedidoItem->id_empresa_resp= $id_empresa_resp;
				$pedidoItem->id_pedido_item= $id_pedido_item;

				$pedidoDAO->atualizaPedidoItemStatus($pedidoItem,true);
				$atividadeDAO->inserir(191,$inc_status_obs.' Atribuir para '.$resp_nome,$controle_id_usuario,$id_pedido_item);
			}
		}
	}
	
	unset( $_COOKIE['p_id_pedido_item'] );
	unset( $_COOKIE['dir_id_pedido_item'] );
	unset( $_COOKIE['p_id_pedido'] );
	#unset( $_COOKIE['dir_id_pedido'] );
	echo "
	<script>
		eraseCookie('p_id_pedido_item');
		eraseCookie('p_id_pedido');
		eraseCookie('dir_id_pedido_item');
	</script>
	";	
	
}

pt_register('POST','submit_empresa_recusa');
if ($submit_empresa_recusa) {//check for errors
	$errors = 0 ;
	$error .= "<b>Ocorreram os seguintes erros:</b>";

	$p_id_pedido_item = explode(',',$_COOKIE["dir_id_pedido_item"]);

	foreach($p_id_pedido_item  as $id_pedido_item){
		$cont_seg++;
		$pedidoItem = $pedidoDAO->buscaPorId($id_pedido_item, $controle_id_empresa);
		if($pedidoItem!=null){

			$id_usuario_op2=$res['id_usuario_op2'];
			#verifica se já foi concluído
			if($pedidoItem->operacional<>'0000-00-00') {
				$errors = 1;
				$error .= '<li>Esse pedido já foi executado e não pode ser devolvido.</li>';
			}
			if($pedidoItem->id_empresa_resp=='0') {
				$errors = 1;
				$error .= '<li>Você não pode devolver esse pedido porque ele já é seu.</li>';
			}

			if($errors!=1){
				$pedidoItem->id_atividade = 191;
				$pedidoItem->id_status = 3;
				$pedidoItem->id_usuario_op =$id_usuario_op2;
				$pedidoItem->id_usuario_op2 = '';
				$pedidoItem->id_empresa_resp= '0';
				$pedidoItem->id_pedido_item= $id_pedido_item;

				$pedidoDAO->atualizaPedidoItemStatus($pedidoItem);
				$atividadeDAO->inserir(191,$inc_status_obs.' Pedido devolvido para Franquia',$controle_id_usuario,$id_pedido_item);
			}
		}
	}

	unset( $_COOKIE['p_id_pedido_item'] );
	unset( $_COOKIE['dir_id_pedido_item'] );
	unset( $_COOKIE['p_id_pedido'] );

	echo "
	<script>
		eraseCookie('p_id_pedido_item');
		eraseCookie('p_id_pedido');
		eraseCookie('dir_id_pedido_item');
	</script>
	";	

}
?>

<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<form name="buscador" action="" method="get"
			ENCTYPE="multipart/form-data" style="clear: both">
		<div style="float: left"><img src="../images/lupa.png" alt="busca" />
		</div>
		<div style="float: left; width: 305px; text-align: right"><label
			style="width: 100px; font-weight: bold; padding-top: 5px; float: left">Status:
		</label> <select name="busca_id_status"
			style="width: 200px; float: left" class="form_estilo">
			<option value="Todos">Todos</option>
			<?php
			$statusDAO = new StatusDAO();
			$status = $statusDAO->listarDirecionamento();
			$p_valor = '';
			foreach($status as $s){
				$p_valor .= '<option value="'.$s->id_status.'"';
				if($busca_id_status==$s->id_status) $p_valor .=  ' selected="selected" ';
				$p_valor .=  ' >'.$s->status.'</option>';
			}
			echo $p_valor;
			?>
		</select> <br />
		<label
			style="width: 100px; font-weight: bold; padding-top: 5px; float: left">Servico:
		</label> <select name="busca_id_servico"
			style="width: 200px; float: left" class="form_estilo">
			<option value="">Todos</option>
			<?php
			$servicoDAO = new ServicoDAO();
			$servicos = $servicoDAO->lista();
			$p_valor = '';
			foreach($servicos as $s){
				$p_valor .= '<option value="'.$s->id_servico.'"';
				if($busca_id_servico==$s->id_servico) $p_valor .= ' selected="selected" ';
				$p_valor .= ' >'.$s->descricao.'</option>';
			}
			echo $p_valor;
			?>
		</select> <br />
		<label
			style="width: 100px; font-weight: bold; padding-top: 5px; float: left">Entre:
		</label> <input type="text" name="busca_data_i"
			value="<? if($busca_data_i <> '') echo invert($busca_data_i,'/','PHP'); ?>"
			style="width: 90px; float: left"
			onKeyUp="masc_numeros(this,'##/##/####');" class="form_estilo" /> <label
			style="width: 20px; font-weight: bold; padding-top: 5px; float: left">e</label>
		<input type="text" name="busca_data_f"
			onKeyUp="masc_numeros(this,'##/##/####');"
			value="<?  if($busca_data_f <> '') echo invert($busca_data_f,'/','PHP'); ?>"
			style="width: 80px; float: left" class="form_estilo" /> <label
			style="width: 100px; font-weight: bold; padding-top: 5px; float: left">Responsável:
		</label> <select name="busca_id_usuario_op"
			style="width: 200px; float: left" class="form_estilo">
			<option value="Todos"
			<? if($busca_id_usuario_op=='') echo ' selected="selected" '; ?>>Todos</option>
			<?php
			$usuarioDAO = new UsuarioDAO();
			$usuarios = $usuarioDAO->listarAtivos($controle_id_empresa);
			$p_valor = '';
			foreach($usuarios as $us){
				$p_valor .= '<option value="'.$us->id_usuario.'"';
				if($busca_id_usuario_op==$us->id_usuario) $p_valor.= ' selected="selected" ';
				$p_valor.=  ' >'.$us->nome.'</option>';
			}
			echo $p_valor;
			?>
		</select> <label
			style="width: 100px; font-weight: bold; padding-top: 5px; float: left">Ordem:
		</label> <input type="text" name="busca_ordem"
			value="<?= $busca_ordem ?>" style="width: 200px; float: left"
			class="form_estilo" /> <label
			style="width: 100px; font-weight: bold; padding-top: 5px; float: left">Ordenar
		Por: </label> <select name="busca_ordenar"
			style="width: 150px; float: left" class="form_estilo">
			<option value=""
			<? if($busca_ordenar=='') echo ' selected="selected" '; ?>></option>
			<option value="Ordem"
			<? if($busca_ordenar=='Ordem') echo ' selected="selected" '; ?>>Ordem</option>
			<option value="Documento de"
			<? if($busca_ordenar=='Documento de') echo ' selected="selected" '; ?>>Documento
			de</option>
			<option value="Data"
			<? if($busca_ordenar=='Data') echo ' selected="selected" '; ?>>Data</option>
			<option value="Departamento"
			<? if($busca_ordenar=='Departamento') echo ' selected="selected" '; ?>>Departamento</option>
			<option value="Serviço"
			<? if($busca_ordenar=='Serviço') echo ' selected="selected" '; ?>>Serviço</option>
			<option value="Cidade"
			<? if($busca_ordenar=='Cidade') echo ' selected="selected" '; ?>>Cidade</option>
			<option value="Estado"
			<? if($busca_ordenar=='Estado') echo ' selected="selected" '; ?>>Estado</option>
			<option value="Prazo"
			<? if($busca_ordenar=='Prazo') echo ' selected="selected" '; ?>>Prazo</option>
			<option value="Agenda"
			<? if($busca_ordenar=='Agenda') echo ' selected="selected" '; ?>>Agenda</option>
			<option value="Data Atividade"
			<? if($busca_ordenar=='Data Atividade') echo ' selected="selected" '; ?>>Data
			Atividade</option>
		</select> <select name="busca_ord"
			style="width: 50px; padding-top: 5px; float: left"
			class="form_estilo">
			<option value=""
			<? if($busca_ord=='') echo ' selected="selected" '; ?>>Cres</option>
			<option value="Decr"
			<? if($busca_ord=='Decr') echo ' selected="selected" '; ?>>Decr</option>
		</select><br>

		<input type="checkbox" name="busca_jadirecionados"
		<? if($busca_jadirecionados=='on') echo ' checked '; ?> /> Já
		direcionados<br>
		<input type="submit" name="busca_submit" class="button_busca"
			value=" Buscar " /></div>
		<div style="float: left; width: 150px; text-align: right"><b><a
			href="#"
			onclick="if(document.getElementById('selecionar_campos').style.visibility=='hidden') document.getElementById('selecionar_campos').style.visibility='visible'; else document.getElementById('selecionar_campos').style.visibility='hidden';">Selecionar
		colunas</a></b><br>
		<div
			style="width: 150px; float: left; text-align: left; height: 140px; visibility: hidden; overflow: scroll"
			class="form_estilo" id="selecionar_campos"><input type="checkbox"
			name="busca_e_todos"
			onclick="if(this.checked==1) { selecionar_campos('direcionamento'); } else{ deselecionar_campos('direcionamento'); }" />Todos
		<br>
		<input type="checkbox" name="busca_e_inicio"
		<? if($busca_e_inicio=='') echo 'checked' ?> />Início <br>
		<input type="checkbox" name="busca_e_prazo"
		<? if($busca_e_prazo=='') echo 'checked' ?> />Prazo <br>
		<input type="checkbox" name="busca_e_data_atividade"
		<? if($busca_e_data_atividade=='') echo 'checked' ?> />Data Status <br>
		<input type="checkbox" name="busca_e_servico"
		<? if($busca_e_servico=='') echo 'checked' ?> />Serviço <br>
		<input type="checkbox" name="busca_e_cidade"
		<? if($busca_e_cidade=='') echo 'checked' ?> />Cidade <br>
		<input type="checkbox" name="busca_e_estado"
		<? if($busca_e_estado=='') echo 'checked' ?> />Estado <br>
		<input type="checkbox" name="busca_e_status"
		<? if($busca_e_status=='') echo 'checked' ?> />Status <br>
		<input type="checkbox" name="busca_e_atividade"
		<? if($busca_e_atividade=='') echo 'checked' ?> />Atividade <br>
		<input type="checkbox" name="busca_e_responsavel"
		<? if($busca_e_responsavel=='') echo 'checked' ?> />Responsável <br>
		<input type="checkbox" name="busca_e_atendimento"
		<? if($busca_e_atendimento=='') echo 'checked' ?> />Atendimento <br>
		<input type="checkbox" name="busca_e_devedor"
		<? if($busca_e_devedor=='') echo 'checked' ?> />Devedor</div>
		</div>
		<?php if($controle_id_empresa=='1'){ ?>
		<div
			style="float: left; width: 150px; text-align: right; margin-left: 5px">
		<b><a href="#"
			onclick="if(document.getElementById('selecionar_estados').style.visibility=='hidden') document.getElementById('selecionar_estados').style.visibility='visible'; else document.getElementById('selecionar_estados').style.visibility='hidden';">Selecionar
		Estados</a></b><br>
		<select multiple="multiple" name="estado_dir[]"
			id="selecionar_estados"
			style="width: 150px; float: left; text-align: left; height: 140px; visibility: hidden;">
			<option value="Todos">Todos</option>
			<option value="AC">AC</option>
			<option value="AL">AL</option>
			<option value="AM">AM</option>
			<option value="AP">AP</option>
			<option value="BA">BA</option>
			<option value="CE">CE</option>
			<option value="DF">DF</option>
			<option value="ES">ES</option>
			<option value="GO">GO</option>
			<option value="MA">MA</option>
			<option value="MG">MG</option>
			<option value="MS">MS</option>
			<option value="MT">MT</option>
			<option value="PA">PA</option>
			<option value="PB">PB</option>
			<option value="PE">PE</option>
			<option value="PI">PI</option>
			<option value="PR">PR</option>
			<option value="RJ">RJ</option>
			<option value="RN">RN</option>
			<option value="RO">RO</option>
			<option value="RR">RR</option>
			<option value="RS">RS</option>
			<option value="SC">SC</option>
			<option value="SE">SE</option>
			<option value="SP">SP</option>
			<option value="TO">TO</option>
		</select></div>
		<?php } ?></form>


		<form name="f1" action="" method="post" ENCTYPE="multipart/form-data"
			style="clear: both"><br />
		<div style="position: absolute; width: 500px; left: 50px; top: 275px">
		<label
			style="width: 130px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Direcionar
		para funcionário: </label> <select name="id_usuario"
			style="width: 200px; float: left" class="form_estilo">
			<option value=""></option>
			<?php	$p_valor='';
			$usuarios = $usuarioDAO->listarAtivos($controle_id_empresa);
			foreach($usuarios as $u){
				$departamento_p = explode(',',$u->departamento_p);
				foreach($departamento_p as $dep){
					if(in_array($dep,$departamento_s) and $dep<>''){
						$p_valor .= '<option value="'.$u->id_usuario.'"';
						if($id_usuario==$u->id_usuario) $p_valor .= ' selected="selected" ';
						$p_valor .= ' >'.$u->nome.'</option>';
						break;
					}
				}
			}
			echo $p_valor;
			?>
		</select> <input type="submit" name="submit" class="button_busca"
			onclick="document.f1.target='_self'; document.f1.action=''"
			value=" Direcionar " style="float: left" /><br>
		<br>
		<div style="clear: both"><input type="submit" name="submit_acao"
			class="button_busca"
			onclick="document.f1.target='_blank'; document.f1.action='pedido.php'"
			style="float: left" value=" Alterar Status " /> <input type="submit"
			name="submit_exporta" class="button_busca"
			onclick="document.f1.target='_blank'; document.f1.action='gera_exporta.php'"
			style="float: left" value=" Exportar " /> <input type="submit"
			name="submit_exporta_txt"
			onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_txt.php'"
			class="button_busca" value=" Exporta TXT " /> <? if($controle_id_empresa=='1'){ ?>
		<input type="submit" name="submit_exporta_2"
			onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_todos.php'"
			class="button_busca" value=" Exportar Todos " /> <? } ?></div>
		</div>
		<?
		#$_SESSION['monitoramento_nome'] $_SESSION['monitoramento_id_empresa'] $_SESSION['monitoramento_id_usuario']
		$exibe = 0;
		if($_SESSION['monitoramento_id_empresa']){
			if($_SESSION['monitoramento_id_empresa'] == 1){
				$exibe = 1;
			}
		} elseif($controle_id_empresa == 1){
			$exibe = 1;
		}
		if($exibe == 1){?>
		<div style="position: absolute; left: 480px; top: 275px"><label
			style="width: 130px; font-weight: bold; padding-top: 5px; float: left; clear: left; text-align: right">Direcionar para Franquia: </label> <select name="id_empresa_resp"
			style="width: 200px; float: left" class="form_estilo">
			<option value=""></option>
			<?php
			$p_valor='';
			$empresaDAO = new EmpresaDAO();
			$empresas = $empresaDAO->listarDiff($controle_id_empresa);
			foreach($empresas as $emp){
				$p_valor .= '<option value="'.$emp->id_empresa.'"';
				if($id_empresa==$emp->id_empresa) $p_valor .= ' selected="selected" ';
				$p_valor .= ' >'.$emp->fantasia.'</option>';
			}
			echo $p_valor;
			?>
		</select> <br>
		<input type="submit" name="submit_empresa" class="button_busca"	style="float: left" value=" Direcionar " />
		<!-- 
		 <input type="submit"
			name="submit_empresa_recusa" class="button_busca" style="float: left"
			value=" Devolver " />
		 -->
			</div>
		<?}?>
		<br>
		<br>
		<br>
		<br>
		<?
		if($errors==1) {
			echo '<ul class="erro">'.$error.'</ul>';
		}

		$p_valor = '';

		pt_register('GET','pagina');
			unset( $_COOKIE['p_id_pedido_item'] );
			unset( $_COOKIE['dir_id_pedido_item'] );
			unset( $_COOKIE['p_id_pedido'] );
			#unset( $_COOKIE['dir_id_pedido'] );
			echo "
			<script>
				eraseCookie('p_id_pedido_item');
				eraseCookie('p_id_pedido');
				eraseCookie('dir_id_pedido_item');
			</script>
			";
		$pedidoDAO = new PedidoDAO();
		$pedidos = $pedidoDAO->buscaDirecionamento($busca,$pagina);
		$hoje = date('Y-m-d H:i:s');

		?>
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="18" class="barra_busca"><?
				$pedidoDAO->QTDPagina();
				?></td>
			</tr>
			<?
			$p_valor .= '
	<tr>
   	<td align="center" width="20" class="result_menu"><input type="checkbox" name="todos" onclick="if(this.checked==1) { selecionar_tudo_cache(\'dir_id_pedido_item\'); selecionar_tudo_cache(\'p_id_pedido_item\'); selecionar_tudo(); } else { deselecionar_tudo_cache(\'dir_id_pedido_item\'); deselecionar_tudo_cache(\'p_id_pedido_item\'); deselecionar_tudo(); }"></td>
    <td align="center" width="30" class="result_menu"><b>Editar</b></td>	
	<td align="center" width="50" class="result_menu"><b>Ordem</b></td>
	<td class="result_menu"><b>Documento de</b></td>';
			if($busca_e_devedor=='') 		$p_valor .=  '<td class="result_menu"><b>Devedor</b></td>';
			if($busca_e_inicio=='') 		$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Início</b></td>';
			if($busca_e_prazo=='') 			$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Prazo</b></td>';
			if($busca_e_data_atividade=='') $p_valor .=  '<td align="center" width="50" class="result_menu"><b>Data Status</b></td>';
			if($busca_e_status=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Status</b></td>';
			if($busca_e_atividade=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Atividade</b></td>';
			if($busca_e_servico=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Serviço</b></td>';
			if($busca_e_cidade=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Cidade</b></td>';
			if($busca_e_estado=='') 		$p_valor .=  '<td align="center" width="40" class="result_menu"><b>UF</b></td>';
			if($busca_e_responsavel=='') 	$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Responsável</b></td>';
			if($busca_e_atendimento=='') 	$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Atendimento</b></td>';
			$p_valor .=  '</tr>';


			$p_id_pedido_item = explode(',',$_COOKIE["dir_id_pedido_item"]);
			foreach($pedidos as $p){

				if($p->empresa_resp<>'') $empresa_resp	= ' - <b>'.$p->empresa_resp.'</b>';
				else $empresa_resp = "";
				$atendente   = $p->atendente;
				$id_atividade = $p->id_atividade;
				$data_atividade = $p->data_atividade;
				$responsavel = $p->responsavel;
				$id_departamento_resp = $p->id_departamento_resp;

				$nome = $p->certidao_nome.$p->certidao_nome_proprietario;
				if($nome=='') $nome = $p->certidao_matricula;

				if($p->empresa_resp<>'' and $p->id_empresa_resp!=$controle_id_empresa) $class = '_franqueado'; else
				if($p->empresa_resp<>'' and $p->id_empresa_resp==$controle_id_empresa) $class = '_franquia'; else
				$class='';
				if(in_array($p->id_pedido_item,$p_id_pedido_item)==1) $item_checked = ' checked '; else $item_checked = '';
				$p_valor .= '<tr>
		<td class="result_celula'.$class.'" align="center">
	    <input type="hidden" name="acao_pedido_' . $cont .'" value="' . $p->id_pedido . '/'.$p->ordem .'"/>
        <input type="checkbox" name="acao_sel_' . $cont .'" value="' . $p->id_pedido_item .'" onclick="if(this.checked==true) { createCookie(\'dir_id_pedido_item\',\''.$p->id_pedido_item.',\',\'1\',\'1\'); createCookie(\'p_id_pedido_item\',\''.$p->id_pedido_item.',\',\'1\',\'1\'); createCookie(\'p_id_pedido\',\'#'.$p->id_pedido.'/'.$p->ordem.',\',\'1\',\'1\'); } else { eraseCookieItem(\'dir_id_pedido_item\',\''.$p->id_pedido_item.'\'); eraseCookieItem(\'p_id_pedido_item\',\''.$p->id_pedido_item.'\'); eraseCookieItem(\'dir_id_pedido\',\'#'.$p->id_pedido.'/'.$p->ordem.'\'); eraseCookieItem(\'p_id_pedido\',\'#'.$p->id_pedido.'/'.$p->ordem.'\'); }" '.$item_checked.' />
		</td>
        <td class="result_celula'.$class.'" align="center"><a href="pedido_edit.php?id=' . $p->id_pedido . '&ordem=' . $p->ordem . '" target="_blank"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
		<td class="result_celula'.$class.'" align="center">#' . $p->id_pedido . '/'.$p->ordem.'</a></td>
		<td class="result_celula'.$class.'">' . $nome.' </td>';

				if($busca_e_devedor=='') $p_valor .= '<td class="result_celula'.$class.'">' . $p->certidao_devedor.'</td>';
				if($busca_e_inicio=='') $p_valor .= '<td class="result_celula'.$class.' result_celula'.$erro_restricao.'" align="center" nowrap>' . invert($p->inicio,'/','PHP') . '</td>';
				if($busca_e_prazo=='') $p_valor .= '<td class="result_celula'.$class.' result_celula'.$erro_atraso.'" align="center" nowrap>' . invert($p->data_prazo,'/','PHP').'</td>';
				if($busca_e_data_atividade=='') $p_valor .= '<td class="result_celula'.$class.'" nowrap>' . invert($p->data_atividade,'/','PHP') . '</td>';
				if($busca_e_status=='') $p_valor .= '<td class="result_celula'.$class.'" nowrap>' . $p->status . '</td>';
				if($busca_e_atividade=='') $p_valor .= '<td class="result_celula'.$class.'" nowrap>' . $p->atividade . '</td>';
				if($busca_e_servico=='') $p_valor .= '<td class="result_celula'.$class.'" nowrap>' . $p->desc_servico . '</td>';
				if($busca_e_cidade=='') $p_valor .= '<td class="result_celula'.$class.'" align="center" nowrap>' . $p->certidao_cidade . '</td>';
				if($busca_e_estado=='') $p_valor .= '<td class="result_celula'.$class.'" align="center" nowrap>' . $p->certidao_estado . '</td>';
				if($busca_e_responsavel=='') $p_valor .= '<td class="result_celula'.$class.'" nowrap>' . $responsavel .$empresa_dir . '</td>';
				if($busca_e_atendimento=='') $p_valor .= '<td class="result_celula'.$class.'" align="center">' . $atendente .$empresa_resp.'</td>';
				$p_valor .= '</tr>';


			}
			echo $p_valor;
			?>
			<tr>
				<td colspan="18" class="barra_busca"><?php $pedidoDAO->QTDPagina(); ?>
				</td>
			</tr>
		</table>
		</form>
		<br>
		<br>
		<table width="400" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="2" class="result_menu"><strong>Legenda</strong></td>
			</tr>
			<tr>
				<td class="result_celula_franquia" width="10">&nbsp;</td>
				<td class="result_celula">Serviço direcionado para outra Franquia</td>
			</tr>
			<tr>
				<td class="result_celula_franqueado" width="10">&nbsp;</td>
				<td class="result_celula" nowrap="nowrap">Serviço que veio de outra
				Franquia</td>
			</tr>
			<tr>
				<td class="result_celula_restricao" width="10">&nbsp;</td>
				<td class="result_celula" nowrap="nowrap">Cliente com restrição</td>
			</tr>
			<tr>
				<td class="result_celula_erro" width="10">&nbsp;</td>
				<td class="result_celula" nowrap="nowrap">Serviço finalizado após o
				prazo</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>
			<?php
			require('footer.php');
			?>