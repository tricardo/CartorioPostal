<?php
require("includes.php");

pt_register('GET','id');
if(isset($id)){
    $contaDAO = new ContaDAO();
    $b_id_fat = $contaDAO->selectBoletosBradFat($id,$controle_id_empresa);
    
    foreach($b_id_fat as $b_id){
	$id = $b_id->id_conta_fatura;
	$b = $contaDAO->selectBoletosBradPorId($id,'1');

	require( "boletos/gerabradescobrad.php" );
    }
}