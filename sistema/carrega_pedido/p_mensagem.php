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
if($controle_id_empresa==1) 
    $a = $pedidoDAO->buscaPorId($id_pedido_item,0);
else
    $a = $pedidoDAO->buscaPorId($id_pedido_item,$controle_id_empresa);
if($a->id_pedido_item==''){
	echo 'Você não tem permissão de alterar esse pedido';
	exit;
}
$mensagemDAO = new MensagemDAO();
$sDepartamentoDAO = new ServicoDepartamentoDAO();
?>
	<form action="#aba3" method="post" name="p_mensagem" id="p_mensagem" enctype="multipart/form-data">
		<input type="hidden" name="p_mensagem" value="1">
		<table width="800" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Nova Mensagem</td>
			</tr>
			<tr>
				<td width="150">
					<div align="right"><strong>Para: </strong></div>
				</td>
				<td colspan="3">
					<select name="para" style="width: 500px" class="form_estilo<?=($errors['para'])?'_erro':''; ?>">
						<option value=""></option>
						<?
						$p_valor = '';
						$mensagem_dep = $sDepartamentoDAO->listarDptoMsg();
						foreach($mensagem_dep as $m_dep){
							$p_valor .= '<option value="'.$m_dep->departamento.'" >'.$m_dep->departamento.'</option>';
						}
						echo $p_valor;
						?>
					</select>
					<font color="#FF0000">*</font>
				</td>
			</tr>

			<tr>
				<td width="150" valign="top">
				<div align="right"><strong>Mensagem: </strong></div>
				</td>
				<td width="532" colspan="3">
					<textarea name="mensagem" class="form_estilo<?=($errors['mensagem'])?'_erro':''; ?>" style="width: 500px; height:100px"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<div align="center">
						<input type="submit" name="submit_mensagem" value=" Enviar " class="button_busca" />
					</div>
				</td>
			</tr>

			<tr>
				<td colspan="4" class="tabela_tit">Mensagens da Solicitação</td>
			</tr>
			<tr>
				<td colspan="4">
					<?
					$p_valor = '
					<div class="form_estilo_r" style="width:150px; font-weight:bold; float:left">Data</div>
					<div class="form_estilo_r" style="width:280px; font-weight:bold; float:left">De</div>
					<div class="form_estilo_r" style="width:280px; font-weight:bold; float:left">Para</div>';

					$mensagem = $mensagemDAO->listaMensagemPedido($id_pedido_item);
					foreach($mensagem as $m){
						if($m->situacao!='Sim') $situacao = 'form_estilo_nlido';
						else $situacao = 'form_estilo_lido';
						$p_valor .= '
						<div class="'.$situacao.'" style="width:150px; font-weight:bold; float:left">'.invert($m->data,'/','PHP'). ' '. substr($m->data,11, 8).'</div>
						<div class="'.$situacao.'" style="width:280px; font-weight:bold; float:left">'.$m->de.'</div>
						<div class="'.$situacao.'" style="width:280px; font-weight:bold; float:left">'.$m->para.'</div>
						<input type="button" name="Ler_'.$m->id_mensagem.'" value="Ler" onclick="carrega_mensagem(\''.$m->id_mensagem .'\'); $(\'#windowMensagem\').show();" class="button_busca" style="width:35px; float:left;" >';
					}
					echo $p_valor;
					?>
				</td>
			</tr>
		</table>
		<div style="text-align: left"><br />
		<table width="30%" cellpadding="4" cellspacing="1" class="result_tabela">
			<tr>
				<td colspan="2" class="result_menu"><strong>Legenda</strong></td>
			</tr>
			<tr>
				<td class="form_estilo_nlido" width="10">&nbsp;</td>
				<td class="result_celula">Mensagem não lida</td>
			</tr>
			<tr>
				<td class="form_estilo_lido" width="10">&nbsp;</td>
				<td class="result_celula" nowrap="nowrap">Mensagem lida</td>
			</tr>
		</table>
		</div>
	</form>