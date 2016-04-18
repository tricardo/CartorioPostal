<?php
if(isset($_SESSION['direcionamento']) AND count($_SESSION['direcionamento']) > 0){
    if(isset($c->id_usuario) AND $c->id_usuario > 0){
        $u = $usuarioDAO->selectPorId($c->id_usuario, $controle_id_empresa);
        if(count($u) > 0){
            $resp_nome = $u->nome;
            $arr  = array();        
            $pedido = array();
            $pedido_e= array();
            $ok     = '';
            $erro   = '';
            $cont_seg = 0;
            for($i = 0; $i < count($_SESSION['direcionamento']); $i++){
                $cont_seg++;
                $items = explode(';',$_SESSION['direcionamento'][$i]);
                $id_pedido_item = $items[0];
                $id_pedido      = $items[1];
                $ordem          = $items[2];
                
		$pedidoItem = $pedidoDAO->buscaPorId($id_pedido_item, $controle_id_empresa);
		if($pedidoItem!=null and ($pedidoItem->operacional=='0000-00-00' and $pedidoItem->id_empresa_resp==$controle_id_empresa or $pedidoItem->id_empresa==$controle_id_empresa and $pedidoItem->id_empresa_resp=='0' or $pedidoItem->operacional<>'0000-00-00' and $pedidoItem->id_empresa_resp!=$controle_id_empresa and $pedidoItem->id_empresa_resp!='')){
                    $pedidoItem->id_atividade = 191;
                    $pedidoItem->id_usuario_op =$c->id_usuario;
                    $pedidoItem->id_pedido_item =$id_pedido_item;
                    $pedidoDAO->atualizaPedidoItemStatus($pedidoItem);
                    $dt = $atividadeDAO->inserir(191,$inc_status_obs.' Atribuir para '.$resp_nome,$controle_id_usuario,$id_pedido_item);
                    if($ok == ''){ $ok = 'Direcionamento com sucesso para:<br><br>'; }
                    $pedido[] = '#'.$id_pedido.'/'.$ordem;
		} 
            }
            $big_msg_box = '';
            $big_msg_box .= strlen($ok) > 0 ? $ok.implode(',',$pedido).'<br><br><br>' : '';
            $big_msg_box .= strlen($erro) > 0 ? $erro.implode(',',$pedido_e) : '';
            $_SESSION['direcionamento'] = array();
            if(count($arr) > 0){
                for($i = 0; $i < count($arr); $i++){
                    $_SESSION['direcionamento'][] = $arr[$i];
                }                            
            }
        } else {
            $big_msg_box = 'Erro!<br><br>Você deve selecionar um Colaborador de sua Unidade para Direcionar!';
        }
    } else {
        $big_msg_box = 'Erro!<br><br>Você deve selecionar um Colaborador para Direcionar!';
    }
} else {
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para Direcionar para um Colaborador!';
}
