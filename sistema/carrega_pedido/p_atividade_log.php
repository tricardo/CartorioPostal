<?
if($controle_id_usuario==""){
	header("Content-Type: text/html; charset=ISO-8859-1",true);

	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );
	pt_register('GET','id_pedido_item');
	$departamento_s = explode(',' ,$controle_id_departamento_s);
	$departamento_p = explode(',' ,$controle_id_departamento_p);
	$pedidoDAO = new PedidoDAO();
}
#verifica se o usuário não está tentando burlar a url
$atividadeDAO = new AtividadeDAO();
$a = $pedidoDAO->buscaPorId($id_pedido_item,$controle_id_empresa);
if($a->id_pedido_item==''){
	echo 'Você não tem permissão de alterar esse pedido';
	exit;
}

$p_valor = '
		<div class="form_estilo_r" style="width:130px; font-weight:bold; float:left">Data</div>
		<div class="form_estilo_r" style="width:130px; font-weight:bold; float:left">Agenda</div>
		<div class="form_estilo_r" style="width:130px; font-weight:bold; float:left">Atividade</div>
		<div class="form_estilo_r" style="width:130px; font-weight:bold; float:left">Nome</div>
		<div class="form_estilo_r" style="width:200px; font-weight:bold; float:left">Obs</div><br />';
$ativs = $atividadeDAO->listaAtividadesPedidoLog($id_pedido_item);
foreach($ativs as $ati){
	if($ati->status_dias<>0 or $ati->status_hora!='00:00:00') {
		$data_agenda = somar_dias_uteis($ati->data_i,$ati->status_dias);
		$data_agenda = invert($data_agenda,'/','PHP').' '.$ati->status_hora;
	}else{
		$data_agenda='';
	}
	$status_obs_ativ = str_replace("'",'',str_replace('"','',substr($ati->status_obs,0,27)));
	$nome_ativ = str_replace("'",'',str_replace('"','',substr($ati->nome,0,27)));
	$p_valor .= '
			<div style="width:130px; float:left; clear:left" class="form_estilo_r"/>'.invert($ati->data_i,'/','PHP').' '.substr($ati->data_i,11, 8).'</div>
			<div style="width:130px; float:left" class="form_estilo_r"/>'.$data_agenda.'</div>
			<div style="width:130px; float:left" class="form_estilo_r"/>'.substr($ati->atividade,0,15).'</div>
			<div style="width:130px; float:left" class="form_estilo_r"/>'.substr($nome_ativ,0,15).'</div>
			<div style="width:200px; float:left" class="form_estilo_r"/>'.$status_obs_ativ.'</div>
			<input type="button" name="Ler_'.$ati->id_pedido_status.'" value="Ler" onclick="carrega_pedido_status(\''. $ati->id_pedido_status .'\'); $(\'#windowMensagem\').show();" class="button_busca" style="width:35px; float:left;" ><br />';
}
echo $p_valor;
?>