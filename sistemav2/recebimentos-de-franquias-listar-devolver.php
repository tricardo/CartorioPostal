<?php

 
if(isset($_SESSION) AND isset($_SESSION['fi_franquia']) AND is_array($_SESSION['fi_franquia']) AND
    count($_SESSION['fi_franquia']) > 0){
    $arr  = array();        
    $pedido = array();
    $pedido_e= array();
    $ok     = '';
    $erro   = '';
    
    for($i = 0; $i < count($_SESSION['fi_franquia']); $i++){
        if(isset($_SESSION['fi_franquia'][$i]) AND strlen($_SESSION['fi_franquia'][$i]) > 0){
            $items = explode(';',$_SESSION['fi_franquia'][$i]);
            if(count($items) == 2 AND strlen($items[0]) > 0 AND strlen($items[1]) > 0){
                $ret = $financeiroverificaDAO->verificaRecusaPedido($items[0], $items[1], $controle_id_empresa);
                if ($ret->id_pedido_item <> '' and $ret->id_pedido_item <> 0) {
                    $erros = 0;
                    $id_usuario_op2 = $ret->id_usuario_op2;

                    if ($ret->operacional <> '0000-00-00') {
                        if($erro == ''){ $erro = 'Recebimento Não Devolvido para:<br><br>'; }
                        $arr[] = $_SESSION['fi_franquia'][$i];
                        $pedido_e[] = '#'.$ret->id_pedido.'/'.$ret->ordem.' já foi executado e não pode ser devolvido!<br>';
                        $erros++;
                    }
                    
                    if ($erros == 0 AND ($ret->id_empresa_resp == '0' or $ret->id_empresa_resp != $controle_id_empresa)) {
                        if($erro == ''){ $erro = 'Recebimento Não Devolvido para:<br><br>'; }
                        $arr[] = $_SESSION['fi_franquia'][$i];
                        $pedido_e[] = 'Você não pode devolver o pedido #'.$ret->id_pedido.'/'.$ret->ordem.' porque ele já é seu!<br>';
                        $erros++;
                    }
                    
                    if($erros == 0){
                        if($ok == ''){ $ok = 'Recebimento Devolvido para:<br><br>'; }
                        $pedido[] = '#'.$ret->id_pedido.'/'.$ret->ordem;
                        
                        $pedidoItem = new stdClass();
                        $pedidoItem->id_atividade = 191;
                        $pedidoItem->id_status = 3;
                        $pedidoItem->id_usuario_op = $id_usuario_op2;
                        $pedidoItem->id_usuario_op2 = '';
                        $pedidoItem->id_empresa_resp = '0';
                        $pedidoItem->id_pedido_item = $ret->id_pedido_item;
                        $pedidoDAO->atualizaPedidoItemStatus($pedidoItem);
                        
                        $atividadeDAO->inserir(191, 'Pedido devolvido para Franquia', $controle_id_usuario, $pedidoItem->id_pedido_item);
                    }
                }
                
            }
        }
    }
    $big_msg_box = '';
    $big_msg_box .= strlen($ok) > 0 ? $ok.implode(',',$pedido).'<br><br><br>' : '';
    $big_msg_box .= strlen($erro) > 0 ? $erro.implode('',$pedido_e) : '';
    $_SESSION['fi_franquia'] = array();
    if(count($arr) > 0){
        for($i = 0; $i < count($arr); $i++){
            $_SESSION['fi_franquia'][] = $arr[$i];
        }                            
    }
    
} else {
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para Devolver!';
}