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
if($controle_id_empresa==1) 
    $a = $pedidoDAO->buscaPorId($id_pedido_item,0);
else
    $a = $pedidoDAO->buscaPorId($id_pedido_item,$controle_id_empresa);


if($a->id_pedido_item==''){
	echo 'Você não tem permissão de alterar esse pedido';
	exit;
}

?>
<script>
JT_init();
</script>
<form action="#aba2" method="post" name="p_atividade" id="p_atividade"
	enctype="multipart/form-data"><input type="hidden" name="p_atividade"
	value="1">
<table width="800" class="tabela">
	<tr>
		<td colspan="4" class="tabela_tit">
			Nova Atividade
			<span class="formInfo"><a href="../help/pedido_edit_2.php?id_status=<?= $a->id_status ?>&width=500" class="jTip" id="help_ativ" name="Ajuda - Passo-a-Passo:">?</a></span>		
		</td>
	</tr>
	<tr>
		<td width="150">
		<div align="right"><strong>Atividade: </strong></div>
		</td>
		<td colspan="3"><select name="id_atividade" style="width: 315px"
			class="form_estilo">
			<option value=""></option>
			<?
			$ativs = $atividadeDAO->listaAtividades($controle_atividade);
			$p_valor = "";
			foreach($ativs as $ati){
				if($ati->id_atividade == 205 && $controle_id_empresa == 1){
					if(in_array(2, $departamento_p) || $controle_id_usuario == 1){
						$p_valor .= '<option value="'.$ati->id_atividade.'" >'.$ati->atividade.'</option>';
					}
				} else {
					$p_valor .= '<option value="'.$ati->id_atividade.'" >'.$ati->atividade.'</option>';
				}
			}
			echo $p_valor;
			?>
		</select> <font color="#FF0000">*</font> <strong>Dias: </strong> <input
			type="text" name="status_dias" value="" style="width: 50px"
			onKeyUp="masc_numeros(this,'###');buscaData(this);"
			class="form_estilo" id="dias_atividade" /> <b>Hora: </b> <input
			type="text" name="status_hora" value="" style="width: 50px"
			onKeyUp="masc_numeros(this,'##:##');" class="form_estilo" /><br />
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Data</strong></td>
		<td><input id="data_posdias" class="form_estilo" readonly="readonly" />
		</td>
	</tr>

	<tr>
		<td width="150" valign="top">
		<div align="right"><strong>Obs: </strong></div>
		</td>
		<td width="532" colspan="3"><textarea name="status_obs"
			class="form_estilo" style="width: 500px; height: 100px"></textarea></td>
	</tr>
	<tr>
		<td colspan="4">
		<div align="center"><input type="submit" name="submit_status"
			value=" Enviar " class="button_busca" /></div>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="tabela_tit">Histórico de Atividades</td>
	</tr>
	<tr>
		<td colspan="4" width="800"><?
		$p_valor = '
				<div class="form_estilo_r" style="width:130px; font-weight:bold; float:left">Data</div>
				<div class="form_estilo_r" style="width:130px; font-weight:bold; float:left">Agenda</div>
				<div class="form_estilo_r" style="width:130px; font-weight:bold; float:left">Atividade</div>
				<div class="form_estilo_r" style="width:130px; font-weight:bold; float:left">Nome</div>
				<div class="form_estilo_r" style="width:200px; font-weight:bold; float:left">Obs</div><br />';
		$ativs = $atividadeDAO->listaAtividadesPedido($id_pedido_item);
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
		?></td>
	</tr>
	<tr>
		<td colspan="4" id="carrega_log_ativ">
		<a href="javascript:void();" onclick="carrega_atividade_log('<?=$id_pedido_item?>')">Veja mais</a>
		</td>
	</tr>
	
</table>
</form>
