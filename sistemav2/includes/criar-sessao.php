<?php
ob_start();
session_start();

require("funcoes.php");
require("global.inc.php");
require_once('classQuery.php');

pt_register('POST','acao');
pt_register('POST','id');
pt_register('POST','sessao');
pt_register('POST','js');



if(isset($_POST['listar_sessao'])){
    if(!isset($_SESSION[$sessao])){
        $_SESSION[$sessao] = array();
    }
    $valor = (count($_SESSION[$sessao]) > 0) ? implode(',', $_SESSION[$sessao]) : '0';
    echo '<input type="hidden" id="show_box_ret_msg" value="'.$valor.'">';
    exit;
} 




$arr = array('expansao','desembolso','direcionamento','rec_pedido',
    'direcionamento_site','cobranca','royalties','fi_franquia');

for($i = 0; $i < count($arr); $i++){
    if($arr[$i] != $sessao){
        if(isset($_SESSION[$arr[$i]])){
            $_SESSION[$arr[$i]] = array();
            #print_r($_SESSION[$arr[$i]]);
        }
    }
}
if($sessao != 'zera_sessao'){
    $_SESSION[$sessao] = (!isset($_SESSION[$sessao])) ? array() : $_SESSION[$sessao];
    if($acao == 0){
        if(in_array($id, $_SESSION[$sessao])){
            unset($_SESSION[$sessao][array_search($id, $_SESSION[$sessao])]);
        }
        if(count($_SESSION[$sessao]) > 0){
            $arr1 = array();
            foreach($_SESSION[$sessao] AS $f){
                $arr1[] = $f;
            }
            $_SESSION[$sessao] = $arr1;
        } else {
            $_SESSION[$sessao] = array();
        }
    } else {
        if(!in_array($id, $_SESSION[$sessao])){
            $_SESSION[$sessao][] = $id;
        }
    }
}
#print_r($_SESSION[$sessao]);

