<?
$error="";
$errors=0;
$error="<b>Ocorreram os seguintes erros:</b><ul>";
pt_register('POST','id_empresa_resp');
$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['dir_id_pedido_item'].'##'));
$p_id_pedido = explode (',',str_replace(',##','',$_COOKIE['dir_id_pedido'].'##'));
$cont=0;
$empresaDAO = new EmpresaDAO();
$res = $empresaDAO->validaDirecionamento($controle_id_empresa,$id_empresa_resp);
if($res->fantasia=='') {
	$errors = 1;
	$error .= '<li>A franquia selecionada não está disponível para aceitar pedido</li>';
}
$resp_nome = $res->fantasia;
if($_SESSION['monitoramento_id_empresa']){
	if($_SESSION['monitoramento_id_empresa'] == 1){
		$inc_status_obs = "[".$_SESSION['monitoramento_nome']."] - ";
	}
} else {
	$inc_status_obs = "[".$controle_id_usuario.' : '.$controle_nome."] - ";
}

foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
	$errors='';
	$error='';
	$valida = valida_numero($id_pedido_item);
	if($valida!='TRUE'){
		echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
		exit;
	}
        $pedidoverificaDAO = new PedidoVerificaDAO();
        $res = $pedidoverificaDAO->verificaDirFranquia($controle_id_empresa,$id_pedido_item);
	if($res->id_usuario_op2==0 || $res->id_usuario_op2=='')
            $id_usuario_op = $res->id_usuario_op;
	else
            $id_usuario_op = $res->id_usuario_op2;

    $financeiroDAO = new FinanceiroDAO();
    $res_fin = $financeiroDAO->contaDesembolsos($id_pedido_item);
	if($res_fin->total=='0') {
		$errors = 1;
		$error .= '<li>Antes de direcionar é preciso pedir o desembolso com as custas e honorários da franquia.</li>';
	}
	if($res->id_pedido_item==''){
		$errors = 1;
		$error .= '<li>Você não pode direcionar esse pedido para outra franquia</li>';	
	}
	if($res->id_empresa_resp!='0') {
		$errors = 1;
		$error .= '<li>Você não pode direcionar esse pedido para outra franquia, porque já está direcionado</li>';
	}

		
	#verifica se já foi concluído
	if($res->operacional<>'0000-00-00' and $res->operacional<>'') {
		$errors = 1;
		$error .= '<li>Esse pedido já foi concluído e não pode ser direcionado.</li>';
	}
	if($errors!=1){
                $atividadeDAO = new AtividadeDAO();
                $atividadeDAO->direcionaFranquia2($id_empresa_resp,$controle_id_usuario,$id_pedido_item,$id_usuario_op,$resp_nome,$inc_status_obs);
		echo '<ul><li><b>Pedido '.$p_id_pedido[$cont].':</b> Pedido direcionado com sucesso</li></ul><br>';
	} else {
		echo '<ul class="erro"><li><b>Pedido '.$p_id_pedido[$cont].':</b></li> '.$error.'</ul><br>';
	}
	$cont++;
}
echo '<a href="pedido.php">Clique aqui para voltar</a>';
?>
</td>
</tr>
</table>
</div>
<? #fim da alteração de status
echo "
	<script>
		eraseCookie('atividade_id_pedido_item');
		eraseCookie('atividade_id_pedido');
	</script>
	";
unset( $_COOKIE['atividade_id_pedido_item'] );
unset( $_COOKIE['atividade_id_pedido'] );

require('footer.php');
exit;
?>