<?php

if(isset($_SESSION['direcionamento_site']) AND count($_SESSION['direcionamento_site']) > 0){
        $arr  = array();        
        $pedido = array();
        $pedido_e= array();
        $ok     = '';
        $erro   = '';
        $cont_seg = 0;
        for($i = 0; $i < count($_SESSION['direcionamento_site']); $i++){
            $cont_seg++;
            $items = explode(';',$_SESSION['direcionamento_site'][$i]);
            $id_pedido_item = $items[0];
            $id_pedido      = $items[1];
            $ordem          = $items[2];

            $pedidoDAO->duplicidadeSite($controle_id_usuario,$id_pedido_item);
            if($ok == ''){ $ok = 'Pedido Marcado como Duplicidade para:<br><br>'; }
            $pedido[] = '#'.$id_pedido.'/'.$ordem; 
        }
        $big_msg_box = '';
        $big_msg_box .= strlen($ok) > 0 ? $ok.implode(',',$pedido).'<br><br><br>' : '';
        $big_msg_box .= strlen($erro) > 0 ? $erro.implode(',',$pedido_e) : '';
        $_SESSION['direcionamento_site'] = array();
        if(count($arr) > 0){
            for($i = 0; $i < count($arr); $i++){
                $_SESSION['direcionamento_site'][] = $arr[$i];
            }                            
        }
} else {
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para para Aplicar a Duplicidade!';
}
