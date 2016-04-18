<?php

 if(in_array('2',$departamento_p)==1){
     if(isset($_SESSION) AND isset($_SESSION['desembolso']) AND is_array($_SESSION['desembolso']) AND
            count($_SESSION['desembolso']) > 0){
        $arr  = array();        
        $pedido = array();
        $pedido_e= array();
        $ok     = '';
        $erro   = '';
        for($i = 0; $i < count($_SESSION['desembolso']); $i++){
            $items = explode(';',$_SESSION['desembolso'][$i]);
            $id_financeiro  = $items[0];
            $id_pedido_item = $items[1];
            $id_pedido      = $items[2];
            $ordem          = $items[3];
            $dt = $financeiroDAO->reprovaDesembolso($id_pedido_item,$id_financeiro,$controle_id_usuario,$controle_id_empresa);
            if($dt <> 0){
                if($ok == ''){ $ok = 'Desembolso Reprovado para:<br><br>'; }
                $pedido[] = '#'.$id_pedido.'/'.$ordem;
            } else {
                if($erro == ''){ $erro = 'Desembolso Não Reprovado para:<br><br>'; }
                $arr[] = $_SESSION['desembolso'][$i];
                $pedido_e[] = '#'.$id_pedido.'/'.$ordem;
            }
        }
        $big_msg_box = '';
        $big_msg_box .= strlen($ok) > 0 ? $ok.implode(',',$pedido).'<br><br><br>' : '';
        $big_msg_box .= strlen($erro) > 0 ? $erro.implode(',',$pedido_e) : '';
        $_SESSION['desembolso'] = array();
        if(count($arr) > 0){
            for($i = 0; $i < count($arr); $i++){
                $_SESSION['desembolso'][] = $arr[$i];
            }                            
        }
    } else {
        $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para Reprovar!';
    }     
} else {
    $big_msg_box = 'Erro!<br><br>Você não tem permissão para realizar essa operação!';
}