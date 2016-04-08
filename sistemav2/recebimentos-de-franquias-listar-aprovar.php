<?php
$erro = 0; 

if(!$_SESSION['fi_franquia'] AND $erro == 0){
    $error++;
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para Aprovar!';
} elseif(count($_SESSION['fi_franquia']) == 0 AND $erro == 0) {
    $error++;
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos um Pedido para Aprovar!';
}

if($p->financeiro_nossa_conta=="" AND $erro == 0){
    $erro++;
    $big_msg_box = "Erro!<br><br>O campo Conta é obrigatório!";
}

if($p->financeiro_forma=="" AND $erro == 0){
    $erro++;
    $big_msg_box = "Erro!<br><br>O campo Forma é obrigatório!";
}

if($p->financeiro_data_p=="" AND $erro == 0){
    $erro++;
    $big_msg_box = "Erro!<br><br>O campo Data de Rec. é obrigatório!";
} elseif(!valida_data($p->financeiro_data_p, 'DD/MM/AAAA')){
    $erro++;
    $big_msg_box = "Erro!<br><br>Informe uma data válida no campo Data Rec.!";
}

if(($p->financeiro_valor_ff=="" OR $p->financeiro_valor_ff == '0.00') AND $erro == 0){
    $erro++;
    $big_msg_box = "Erro!<br><br>O campo valor é obrigatório!";
}

if($erro == 0){
    $arr  = array();        
    $pedido = array();
    $pedido_e= array();
    $ok     = '';
    $erro   = '';
    if(isset($_SESSION) AND isset($_SESSION['fi_franquia']) AND is_array($_SESSION['fi_franquia']) AND
        count($_SESSION['fi_franquia']) > 0){
        for($i = 0; $i < count($_SESSION['fi_franquia']); $i++){
            if(isset($_SESSION['fi_franquia'][$i]) AND strlen($_SESSION['fi_franquia'][$i]) > 0){
                $items = explode(';',$_SESSION['fi_franquia'][$i]);
                if(count($items) == 2 AND strlen($items[0]) > 0 AND strlen($items[1]) > 0){ 
                    $ret = $financeiroverificaDAO->verificaAprovaPedido($items[0], $controle_id_empresa);
                    
                    if(count($ret) > 0){
                        $financeiro_valor = $ret->financeiro_valor;
                        $valor_rec = $ret->valor_rec;
                        
                        if ($ret->id_pedido_item <> '') {
                            $financeiro_valor = 0;
                            $valor_rec = 0;
                            $financeiro_valor_f = 0;
                            $financeiro_valor_ff = 0;
                            
                            $id_pedido_item_ant = $ret->id_pedido_item;
                            $financeiro_valor = $financeiro_valor - $valor_rec;
                            if ($financeiro_valor < $financeiro_valor_ff and $financeiro_valor > 0) {
                                $financeiro_valor_ff = (float) ($financeiro_valor_ff) - (float) ($financeiro_valor);
                                $financeiro_valor_f = (float) ($financeiro_valor);
                            } else {
                                if ($financeiro_valor_ff > 0 and $financeiro_valor > 0) {
                                    $financeiro_valor_f = $financeiro_valor_ff;
                                    $financeiro_valor_ff = 0;
                                } else {
                                    $financeiro_valor_f = 0;
                                }
                            }
                            $f = new stdClass();
                            $f->financeiro_descricao = $p->financeiro_descricao;
                            $f->financeiro_forma = $p->financeiro_forma;
                            $f->financeiro_classificacao = $p->financeiro_classificacao;
                            $f->financeiro_valor_f = $financeiro_valor_f;
                            $f->financeiro_identificacao = $p->financeiro_identificacao;
                            $f->financeiro_nossa_conta = $p->financeiro_nossa_conta;
                            $f->financeiro_data_p = invert($p->financeiro_data_p, '-', 'SQL');
                            $f->financeiro_valor_ff = $financeiro_valor_ff;

                            $done = $financeiroDAO->aprovaRecebimentoF($ret->id_pedido_item, $items[0], $controle_id_usuario, $controle_id_empresa, $f, $ret, '');
                            $id_financeiro_ant = $items[0];
                            #print_r($ret);
                            if ($financeiro_valor_ff == 0){
                                if($erro == ''){ $erro = 'Recebimento Não Aprovado para:<br><br>'; }
                                $arr[] = $_SESSION['fi_franquia'][$i];
                                $pedido_e[] = '#'.$ret->id_pedido.'/'.$ret->ordem;
                            } else {
                                if($ok == ''){ $ok = 'Recebimento Aprovado para:<br><br>'; }
                                $pedido[] = '#'.$ret->id_pedido.'/'.$ret->ordem;
                            }
                        }
                    }   
                }
            }
        }
        
        if ($financeiro_valor_ff > 0 and $financeiro_valor_ff != '') {
            $f->financeiro_valor_f = $financeiro_valor_ff;
            $done = $financeiroDAO->aprovaRecebimentoF($id_pedido_item_ant, $id_financeiro_ant, $controle_id_usuario, $controle_id_empresa, '');
        }
        
        
        $big_msg_box = '';
        $big_msg_box .= strlen($ok) > 0 ? $ok.implode(',',$pedido).'<br><br><br>' : '';
        $big_msg_box .= strlen($erro) > 0 ? $erro.implode('',$pedido_e) : ',';
        $_SESSION['fi_franquia'] = array();
        if(count($arr) > 0){
            for($i = 0; $i < count($arr); $i++){
                $_SESSION['fi_franquia'][] = $arr[$i];
            }                            
        }
    }
 }