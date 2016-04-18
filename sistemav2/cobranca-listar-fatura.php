<?php
require("includes.php");

pt_register('GET', 'id_fatura');


if(isset($id_fatura) AND $id_fatura > 0){
    $contaDAO = new ContaDAO();
    $dt = $contaDAO->selectBoletosBradFat($id_fatura,$controle_id_empresa);
    if(count($dt) > 0){
        foreach($dt as $b_id){
            $id = $b_id->id_conta_fatura;
            $b = $contaDAO->selectBoletosBradPorId($b_id->id_conta_fatura,'1');
            require( "boletos/gerabradescobrad.php" );
        }
    }    
}
