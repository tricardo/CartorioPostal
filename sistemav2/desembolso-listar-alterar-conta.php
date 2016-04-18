<?php

if(isset($_SESSION) AND isset($_SESSION['desembolso']) AND is_array($_SESSION['desembolso']) AND
       count($_SESSION['desembolso']) > 0){
    $arr  = array();
    $financeiro  = array();
    $pedido = array();
    for($i = 0; $i < count($_SESSION['desembolso']); $i++){
        $items = explode(';',$_SESSION['desembolso'][$i]);
        $id_financeiro  = $items[0];
        $id_pedido_item = $items[1];
        $id_pedido      = $items[2];
        $ordem          = $items[3];
        $financeiro[] = $id_financeiro;
        $pedido[] = '#'.$id_pedido.'/'.$ordem;
    }
    if(count($financeiro) > 0 AND isset($p->financeiro_nossa_conta) AND strlen($p->financeiro_nossa_conta) > 0){
        $dt = $financeiroDAO->atualizaConta2($financeiro,$p->financeiro_nossa_conta,$controle_id_empresa);
	if($dt <> 0){
            $big_msg_box = 'Registros atualizados com sucesso!';
            $_SESSION['desembolso'] = array();
	} else {
            $big_msg_box = 'Os registros não foram atualizados:<br><br>'.implode(', ',$pedido);
	}
    } else {
        $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo uma Conta para Alterar os pedidos!';
    }
} else {
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para Alterar a Conta!';
}