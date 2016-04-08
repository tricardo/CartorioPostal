<?php
require("includes/verifica_logado_controle.inc-ajax.php"); 
if($_POST){
    
    pt_register('POST','valor');
    pt_register('POST','dias');
    pt_register('POST','id_serv');
    
    $valor = isset($valor) ? (strlen($valor) == 0 ? 0 : $valor) : 0;
    $dias = isset($dias) ? (strlen($dias) == 0 ? 0 : $dias) : 0;
    $id_servico_var = isset($id_serv) ? (strlen($id_serv) == 0 ? 0 : $id_serv) : 0;
    
    $servicoDAO = new ServicoDAO();
    $servicoDAO->editarServico($controle_id_empresa, $valor, $dias, $id_serv);
    
    
    echo "<script>ShowBox('Mensagem!<br><br>Serviço atualizado com sucesso!');</script>";
    
}