<?php


if(isset($_SESSION) AND isset($_SESSION['desembolso']) AND is_array($_SESSION['desembolso']) AND
       count($_SESSION['desembolso']) > 0){
    $atividadeverificaDAO = new AtividadeVerificaDAO();
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
        $valida = valida_numero($id_pedido_item);
        if($valida=='TRUE'){
            $p_verifica = $atividadeverificaDAO->AtividadeVerifica($controle_id_empresa,'213','.',$departamento_p,$departamento_s,$id_pedido_item);
            if(!isset($p_verifica['error']) OR $p_verifica['error']==''){
                $financeiroDAO->enviaExpedicao($id_pedido_item,$id_financeiro,$controle_id_usuario);
                $pedido[] = '#'.$id_pedido.'/'.$ordem.' - entregue a expedição;<br>';
                if($ok == ''){ $ok = 'Desembolso Em Execução para:<br><br>'; }
            } else {
                if($erro == ''){ $erro = 'Problema na Execução do Desembolso para:<br><br>'; }
                $arr[] = $_SESSION['desembolso'][$i];
                $pedido_e[] = '#'.$id_pedido.'/'.$ordem.' - '.$p_verifica['error'].';<br>';
            }
        } 
    }
   $big_msg_box = '';
   $big_msg_box .= strlen($ok) > 0 ? $ok.implode('',$pedido).'<br><br><br>' : '';
   $big_msg_box .= strlen($erro) > 0 ? $erro.implode('',$pedido_e) : '';
   $_SESSION['desembolso'] = array();
   if(count($arr) > 0){
       for($i = 0; $i < count($arr); $i++){
           $_SESSION['desembolso'][] = $arr[$i];
       }                            
   }
} else {
   $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para Execução!';
}     
