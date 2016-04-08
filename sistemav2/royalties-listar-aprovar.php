<?php
$erro = 0;    

if(in_array('2',$departamento_p)!=1 AND $erro == 0){
    $erro++;
    $big_msg_box = 'Erro!<br><br>Você não tem permissão para realizar essa operação!';
}

if(!$_SESSION['royalties'] AND $erro == 0){
    $error++;
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos uma Cobrança para Aprovar!';
} elseif(count($_SESSION['royalties']) == 0 AND $erro == 0) {
    $error++;
    $big_msg_box = 'Erro!<br><br>Você deve selecionar pelo menos uma Cobrança para Aprovar!';
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

if($erro == 0){
    $arr  = array();        
    $pedido = array();
    $pedido_e= array();
    $ok     = '';
    $erro   = '';
    for($i = 0; $i < count($_SESSION['royalties']); $i++){
        if(isset($_SESSION['royalties'][$i]) AND strlen($_SESSION['royalties'][$i]) > 0){
            $cp_r = 'roy'.$_SESSION['royalties'][$i];
            $cp_f = 'fpp'.$_SESSION['royalties'][$i];
            if(isset($p->$cp_r) AND isset($p->$cp_f)){
                $dt = $financeiroDAO->RoyEmpresa($_SESSION['royalties'][$i]);
                if(count($dt) > 0){
                    $financeiro_valor = (float)$p->$cp_r + (float)$p->$cp_f;
                    if($financeiro_valor == ''){
                        if($erro == ''){ $erro = 'Royaltie Não Aprovado para:<br><br>'; }
                        $arr[] = $_SESSION['royaltie'][$i];
                        $pedido_e[] = "Erro!<br><br>O campo valor em ".utf8_encode($dt[0]->fantasia)." - ".$dt[0]->ref." é obrigatório!<br>";
                    } else {
                        if($ok == ''){ $ok = 'Royaltie Aprovado para:<br><br>'; }
                        $pedido[] = utf8_encode($dt[0]->fantasia)." - ".$dt[0]->ref.'<br>';
                        $f = new stdClass();
                        $f->financeiro_nossa_conta = $p->financeiro_nossa_conta;
                        $f->financeiro_forma = $p->financeiro_forma;
                        $f->financeiro_classificacao = $p->financeiro_classificacao;
                        $f->financeiro_identificacao = $p->financeiro_identificacao;
                        $f->financeiro_data_p =  invert($p->financeiro_data_p, '-', 'SQL');
                        $f->financeiro_descricao = $p->financeiro_descricao;
                        $f->roy_rec=$p->$cp_r;
			$f->fpp_rec=$p->$cp_f;
                        $f->financeiro_valor= $financeiro_valor;
			$f->id_empresa_f = $dt[0]->id_empresa;
                        
                        $financeiroDAO->inserirRecebimentoRoy($dt[0]->id_rel_royalties,$controle_id_empresa,$controle_id_usuario,$f);
                    }
                }
            }
        }
    }
    $big_msg_box = '';
    $big_msg_box .= strlen($ok) > 0 ? $ok.implode('',$pedido).'<br><br><br>' : '';
    $big_msg_box .= strlen($erro) > 0 ? $erro.implode('',$pedido_e) : '';
    $_SESSION['royalties'] = array();
    if(count($arr) > 0){
        for($i = 0; $i < count($arr); $i++){
            $_SESSION['royalties'][] = $arr[$i];
        }                            
    }
}
    
