<?php
if(isset($_SESSION['direcionamento']) AND count($_SESSION['direcionamento']) > 0){
    if(isset($c->id_empresa_resp) AND $c->id_empresa_resp > 0){
        $emp = $empresaDAO->selectPorId($c->id_empresa_resp);
        if($emp->status!='Ativo' OR $emp->id_empresa==$controle_id_empresa OR count($emp)==0) {
            $big_msg_box = 'Erro!<br><br>A Unidade selecionada não está disponível para aceitar pedidos!';
	} else {
            $resp_nome = $emp->fantasia;
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
                $erro_linha = 0;
                
                $contaDesembolso = $financeiroDAO->contaDesembolsos($id_pedido_item);
                if($contaDesembolso->total==0) {
                    $arr[] = $_SESSION['direcionamento'][$i];
                    $pedido_e[] = 'Solicitar o desembolso com as custas e honorários da franquia para #'.$id_pedido.'/'.$ordem.'!';
                    $erro_linha++;
                }
                
                $pedidoItem = $pedidoDAO->buscaPorId($id_pedido_item, $controle_id_empresa);
                if($pedidoItem->id_empresa_resp<>0) {
                    $arr[] = $_SESSION['direcionamento'][$i];
                    $pedido_e[] = '#'.$pid_pedido.'/'.$ordem.' já está direcionado para outra unidade!';
                    $erro_linha++;
                }
                
                if($pedidoItem->operacional!='0000-00-00' and $pedidoItem->operacional<>'') {
                    $arr[] = $_SESSION['direcionamento'][$i];
                    $pedido_e[] = '#'.$pid_pedido.'/'.$ordem.' já foi concluído pelo operacional e não pode ser direcionado!';
                    $erro_linha++;
                }

                if($erro_linha == 0){
                    if($ok == ''){ $ok = 'Direcionamento com sucesso para:<br><br>'; }
                    $pedido[] = '#'.$id_pedido.'/'.$ordem;
                    
                    $pedidoItem->id_atividade = 206;
                    $pedidoItem->id_status = 19;
                    $pedidoItem->id_usuario_op2 = $pedidoItem->id_usuario_op;
                    $pedidoItem->id_usuario_op ='';
                    $pedidoItem->id_empresa_resp= $c->id_empresa_resp;
                    $pedidoItem->id_pedido_item= $id_pedido_item;

                    $pedidoDAO->atualizaPedidoItemStatus($pedidoItem,true);
                    $atividadeDAO->inserir(191,$inc_status_obs.' Atribuir para '.$resp_nome,$controle_id_usuario,$id_pedido_item);
                } else {
                    if($erro == ''){ $erro = 'Erro no Direcionamento para:<br><br>'; }
                }		
            }
            $big_msg_box = '';
            $big_msg_box .= strlen($ok) > 0 ? $ok.implode(',',$pedido).'<br><br><br>' : '';
            $big_msg_box .= strlen($erro) > 0 ? $erro.implode('<br>',$pedido_e) : '';
            $_SESSION['direcionamento'] = array();
            if(count($arr) > 0){
                for($i = 0; $i < count($arr); $i++){
                    $_SESSION['direcionamento'][] = $arr[$i];
                }                            
            }
        }
    } else {
        $big_msg_box = 'Erro!<br><br>Você deve selecionar uma Unidade para Direcionar!';
    }
} else {
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para Direcionar para um Colaborador!';
}