<?php

if($_POST){
        
    $arr = array('id_conta','id_fatura','id_nota','tipo','cpf','sacado','endereco','bairro','cep',
        'cidade','estados','vencimento','valor','juros_mora','ocorrencia','instrucao1','mensagem1',
        'instrucao2','mensagem2','emissao_papeleta','especie','aceite');
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    
    
    $arr1 = array('tipo','cpf','sacado','endereco','cep','vencimento','valor','ocorrencia',
        'emissao_papeleta','especie','aceite');
    for($i = 0; $i < count($arr1); $i++){
        pt_register('POST', $arr1[$i]);
        if($$arr1[$i] == ""){
            $errors++;
            $campos.= $arr1[$i].';';
            $big_msg_box.= "Preencha o campo ".$arr1[$i]."!<br>";
        }
    }
    
    if($errors == 0 AND ($instrucao1==6 and $instrucao2<5)){
        $msgbox.= "O campo instrução 2 não pode ser menor que 5!<br>";
    }
    
    if($errors == 0 AND invert($vencimento,'-','SQL')<date('Y-m-d')){
        $errors++;
        $campos.= 'vencimento;';
        $msgbox.= "A data de vencimento não pode ser inferior ao dia de hoje!<br>";   
    }
    
    if($errors == 0){
        $verifica = $validacaoCLASS->invertData($vencimento);
        if($verifica==false){
            $errors++;
            $campos.= 'vencimento;';
            $msgbox.= "Vencimento inválido!<br>"; 
        } else {
            $vencimento=$verifica;
        }
    }
    
    if($id_fatura<>'' AND $errors == 0){
        $verifica_fatura = $contaDAO->verificaFatura($controle_id_empresa, $id_fatura);
        if($verifica_fatura==0 or $verifica_fatura==''){
            $errors++;
            $campos.= 'id_fatura;';
            $msgbox.= "Número de Fatura inválido!<br>"; 
        }
    }
    
    if($errors == 0){
        $p->tipo='1';
        $p->ocorrencia='1';
        $p->emissao_papeleta='2';
        $p->especie='12';
        $p->aceite='N';
        $p->tipo=$tipo;
        $p->cpf=$cpf;
        $p->id_nota=$id_nota;
        $p->id_fatura=$id_fatura;
        $p->id_conta=$id_conta;
        $p->separador=$separador;
        $p->sacado=$sacado;
        $p->endereco=$endereco;
        $p->bairro=$bairro;
        $p->cidade=$cidade;
        $p->estado=$estado;
        $p->cep=$cep;
        $p->vencimento=$vencimento;
        $p->valor=$valor;
        $p->juros_mora=$juros_mora;
        $p->ocorrencia=$ocorrencia;
        $p->instrucao1=$instrucao1;
        $p->instrucao2=$instrucao2;
        $p->mensagem1=$mensagem1;
        $p->mensagem2=$mensagem2;
        $p->emissao_papeleta=$emissao_papeleta;
        $p->especie=$especie;
        $p->aceite=$aceite;
        
        $contaDAO->inserirBoletoBrad($p,$controle_id_empresa,$controle_id_usuario);
        $big_msg_box = 'Ok!<br><br>Boleto Cadastrado com sucesso!';
    } else {
        $big_msg_box = strlen($errors) > 0  ? 'Erro!<br><br>'.$big_msg_box : '';
    }
}