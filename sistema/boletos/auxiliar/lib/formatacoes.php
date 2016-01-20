<?php

/**
 * recebe a data yyyy-mm-dd e retorna dd/mm/yyyy
 *
 * @param String $date
 * @return String
 */
function formataData($date) {
    return ereg_replace('([0-9]{4})-([0-9]{2})-([0-9]{2})','\\3/\\2/\\1',$date);
}

/**
 * recebe a data dd/mm/yyyy e retorna a data no formato yyyy-mm-dd
 *
 * @param String $date
 * @return String
 */
function formataDataBD($date) {
    $nData = ereg_replace('([0-9]{2})/([0-9]{2})/([0-9]{4})','\\3-\\2-\\1',$date);
    if($date==$nData) $nData = ereg_replace('([0-9]{2})/([0-9]{2})','0000-\\2-\\1',$date);
    if($nData==$date && $date!='') throw new ExceptionList("Data inválida");
    return $nData;
}

/**
 * remove .'s, /'s e -'s do cpf digitado
 *
 * @param String $cpf
 * @return int
 */
function formatDBCPF($cpf) {
    $return = str_replace("-","",str_replace("/","", str_replace(".","",$cpf)));
    return $return;
}
?>