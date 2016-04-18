<?php
if(isset($_SESSION['direcionamento']) AND count($_SESSION['direcionamento']) > 0){
    if($_POST){
        pt_register('POST', 'acao_id_atividade');
        pt_register('POST', 'status_obs');
        pt_register('POST', 'status_dias');
        pt_register('POST', 'status_hora');

        $acao_id_atividade = isset($acao_id_atividade) ? $acao_id_atividade : 0;
        $status_obs = isset($status_obs) ? $status_obs : '';
        $status_dias = isset($status_dias) ? $status_dias : 0;
        $status_hora = isset($status_hora) ? $status_hora : '00:00';


        $s = new stdClass();
        $s->status_obs = $status_obs;
        if(isset($_SESSION['monitoramento_id_empresa']) AND $_SESSION['monitoramento_id_empresa'] == 1){
            $s->status_obs = "[".$_SESSION['monitoramento_nome']."] ".((strlen($s->status_obs) > 0) ? '- '.$s->status_obs : '');
        } elseif($controle_id_empresa == 1){
            $s->status_obs = "[".$controle_id_usuario.' : '.$controle_nome."] ".((strlen($s->status_obs) > 0) ? '- '.$s->status_obs : '');
        }
        $s->status_dias = $status_dias;
        $s->status_hora = $status_hora;
        
        $arr  = array();        
        $pedido = array();
        $pedido_e= array();
        $ok     = '';
        $erro   = '';
        
        
        for($i = 0; $i < count($_SESSION['direcionamento']); $i++){
            if($_SESSION['direcionamento'][$i] != ''){
                $items = explode(';',$_SESSION['direcionamento'][$i]);
                $id_pedido_item = $items[0];
                $id_pedido      = $items[1];
                $ordem          = $items[2];
                $dt = $atividadeverificaDAO->AtividadeVerifica($controle_id_empresa, 
                        $acao_id_atividade, $s->status_obs, $departamento_p, $departamento_s, $id_pedido_item);
                if (strlen($dt['error']) == 0) {
                    if($ok == ''){ $ok = 'Status Aprovado para:<br><br>'; }
                    $pedido[] = '#'.$id_pedido.'/'.$ordem;
                } else {
                    if($erro == ''){ $erro = 'Status Não Aprovado para:<br><br>'; }
                    $arr[] = $_SESSION['direcionamento'][$i];
                    $pedido_e[] = '#'.$id_pedido.'/'.$ordem.' - '.$dt['error'].'<br>';
                }
            }
        }
        $big_msg_box = '';
        $big_msg_box .= strlen($ok) > 0 ? $ok.implode(',',$pedido).'<br><br><br>' : '';
        $big_msg_box .= strlen($erro) > 0 ? $erro.implode('',$pedido_e) : '';
        
        $_SESSION['direcionamento'] = array();
        if(count($arr) > 0){
            for($i = 0; $i < count($arr); $i++){
                $_SESSION['direcionamento'][] = $arr[$i];
            }                            
        }
    }
} else {
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para Direcionar para um Colaborador!';
}