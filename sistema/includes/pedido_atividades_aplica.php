<?
$atividadeDAO = new AtividadeDAO();
$atividadeverificaDAO = new AtividadeVerificaDAO();
pt_register('POST', 'acao_id_atividade');
pt_register('POST', 'status_obs');
pt_register('POST', 'status_dias');
pt_register('POST', 'status_hora');
$p_id_pedido_item = explode(',', str_replace(',##', '', $_COOKIE['atividade_id_pedido_item'] . '##'));
$p_id_pedido = explode(',', str_replace(',##', '', $_COOKIE['atividade_id_pedido'] . '##'));
$cont = 0;

$s->status_obs = $status_obs;
if($_SESSION['monitoramento_id_empresa']){
	if($_SESSION['monitoramento_id_empresa'] == 1){
		$s->status_obs = "[".$_SESSION['monitoramento_nome']."] ".((strlen($s->status_obs) > 0) ? '- '.$s->status_obs : '');
	}
} else {
	$s->status_obs = "[".$controle_id_usuario.' : '.$controle_nome."] ".((strlen($s->status_obs) > 0) ? '- '.$s->status_obs : '');
}
$s->status_dias = $status_dias;
$s->status_hora = $status_hora;

foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
    $valida = valida_numero($id_pedido_item);
    if ($valida != 'TRUE') {
        echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
        exit;
    }

    unset($p_verifica);
    $p_verifica = $atividadeverificaDAO->AtividadeVerifica($controle_id_empresa, $acao_id_atividade, $s->status_obs, $departamento_p, $departamento_s, $id_pedido_item);

    if ($p_verifica['error'] == '') {
        $done = $atividadeDAO->inserirAtividade($acao_id_atividade, $s, $controle_id_usuario, $id_pedido_item);
        echo '<ul class="sucesso"><li><b>Pedido ' . $p_id_pedido[$cont] . ':</b> Atividade atualizada com sucesso</li></ul>';
    } else {
        echo '<ul class="erro"><li><b>Pedido ' . $p_id_pedido[$cont] . ':</b></li> ' . $p_verifica['error'] . '</ul><br>';
    }
    $cont++;
}
echo '<a href="pedido.php">Clique aqui para voltar</a>';
?>
</td>
</tr>
</table>  
</div>
<?
#fim da alteração de status
echo "
	<script>
		eraseCookie('atividade_id_pedido_item');
		eraseCookie('atividade_id_pedido');
	</script>
	";
unset($_COOKIE['atividade_id_pedido_item']);
unset($_COOKIE['atividade_id_pedido']);

require('footer.php');
exit;
?>