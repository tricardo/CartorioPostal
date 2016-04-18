<?php if(isset($_SESSION['cobranca']) AND count($_SESSION['cobranca']) > 0){ 
    pt_register('POST', 'dias');
    pt_register('POST', 'status_obs');
    pt_register('POST', 'id_atividade');
    pt_register('POST', 'id_status');
    
    switch($acao_direcionamento){
            case 'acompanhar': $texto = 'Atividade Acompanhar'; break;
            case 'notificar':  $texto = 'Atividade Notificar'; break;
            case 'notificado':  $texto = 'Atividade Notificado'; break;
            case 'apoio_juridico':  $texto = 'Atividade Apoio Jurídico'; break;
            case 'efetuado':  $texto = 'Atividade Efetuado'; break;
        }
    
    $arr  = array();        
    $pedido = array();
    $pedido_e= array();
    $ok     = '';
    $erro   = '';
    $cont_seg = 0;
    for($i = 0; $i < count($_SESSION['cobranca']); $i++){
        if(strlen($_SESSION['cobranca'][$i]) > 0){
            $cont_seg++;
            $items = explode(';',$_SESSION['cobranca'][$i]);
            $id_pedido_item = $items[0];
            $id_pedido      = $items[1];
            $ordem          = $items[2];
            
            $p_verifica = array('erro'=>'');
            if ($id_atividade != 119){
                $p_verifica = $atividadeverificaDAO->AtividadeVerifica($controle_id_empresa, $id_atividade, '', $departamento_p, $departamento_s, $id_pedido_item);
            }
            if ($p_verifica['error'] == '') {
                $pe = $pedidoDAO->selectPedidoItemPorId($id_pedido_item);
                $dias = ($id_atividade == 120 && $pe->id_status == 11) ? 10 : $dias;

                $atividadeDAO->inserir($id_atividade, $status_obs, $controle_id_usuario, $id_pedido_item, $dias);
                $p = new stdClass();
                $p->id_atividade = $id_atividade;
                $p->id_status = $id_status;
                $p->id_pedido_item = $id_pedido_item;
                $p->dias = $dias;
                $p->data_atividade = date("Y-m-d H:i:s");
                $pedidoDAO->atualizaPedidoItemStatus($p);

                if($ok == ''){ $ok = $texto.' com sucesso para:<br><br>'; }
                $pedido[] = '#'.$id_pedido.'/'.$ordem;
            } else {
                if($erro == ''){ $erro = 'Erro na '.$texto.' para:<br><br>'; }
                $arr[] = $_SESSION['direcionamento'][$i];
                $pedido_e[] = '#'.$id_pedido.'/'.$ordem. ' - '.$p_verifica['error'];
            }
           
        }
    }
    $big_msg_box = '';
    $big_msg_box .= strlen($ok) > 0 ? $ok.implode(',',$pedido).'<br><br><br>' : '';
    $big_msg_box .= strlen($erro) > 0 ? $erro.implode(',',$pedido_e) : '';
    $_SESSION['cobranca'] = array();
    if(count($arr) > 0){
        for($i = 0; $i < count($arr); $i++){
            $_SESSION['cobranca'][] = $arr[$i];
        }                            
    }
    
    
} else {
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para Direcionar para um Colaborador!';
}