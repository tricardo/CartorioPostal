<?php
require("includes.php");

pt_register('GET','rel');
pt_register('GET','pg');
pt_register('GET','id_relatorio');

switch($rel){
    
    
    default:

        if(verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
            && verifica_permissao('Rel_comercial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
            && verifica_permissao('Supervisor Atendimento',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
            && verifica_permissao('Supervisor Financeiro',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
            ){
                if($rel=='royalties'){
                    if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE'){
                        header('location:pagina-erro.php');
                        exit;
                    }
                }else {
                    header('location:pagina-erro.php');
                    exit;
                }
        }

        $relatorioDAO = new RelatorioDAO();
        $relatorio = $relatorioDAO->selectPorId($id_relatorio);
        if($controle_id_empresa != $relatorio->id_empresa && $controle_id_empresa!=1){
            header('location:pagina-erro.php');
            exit;
        }if(!is_file($relatorio->arquivo)){
            header('location:pagina-erro.php?erro=1');
            exit;
        }

        $relatorio->arquivo = str_replace('../','',$relatorio->arquivo);
        if(file_exists('../sistema/'.$relatorio->arquivo)){
            $relatorio->arquivo = '../sistema/'.$relatorio->arquivo;
        }
        
        header ("Content-type: octet/stream");
        header ("Content-disposition: attachment; filename=exporta/".$relatorio->arquivo.";");
        header("Content-Length: ".filesize($relatorio->arquivo));
        readfile($relatorio->arquivo);
        
}