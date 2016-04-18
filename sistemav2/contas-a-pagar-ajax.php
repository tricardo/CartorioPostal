<?php
require("includes/verifica_logado_controle.inc-ajax.php"); 

pt_register('POST','acao');
if(isset($acao)){
    switch($acao){
        case 1:
            pt_register('POST','id');
            if(isset($id)){
                $fornecedorDAO = new FornecedorDAO();
                $clientes = $fornecedorDAO->buscaPorId($id,$controle_id_empresa);
                if(count($clientes) > 0){
                    echo '<script>';
                    echo "$('#favorecido').val('".utf8_encode($clientes->fantasia)."');";
                    echo "$('#cnpj').val('".$clientes->cnpj."');";
                    echo '</script>';
                }
            }
            break;
            
    }
}
