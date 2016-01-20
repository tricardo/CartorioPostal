<?php

/**
 * recebe a data yyyy-mm-dd e retorna dd/mm/yyyy
 *
 * @param String $date
 * @return String
 */
function formatDate($date){
	$nDate = ereg_replace('([0-9]{4})-([0-9]{2})-([0-9]{2})','\\3/\\2/\\1',$date);
	return $nDate;
}

function formataDataNascimento($date){
	$nDate = ereg_replace('(0000)-([0-9]{2})-([0-9]{2})','\\3/\\2',$date);
	if($nDate==$date){
		$nDate = ereg_replace('([0-9]{4})-([0-9]{2})-([0-9]{2})','\\3/\\2/\\1',$date);
	}
	return $nDate;	
}

/**
 * recebe a data dd/mm/yyyy e retorna a data no formato yyyy-mm-dd
 *
 * @param String $date
 * @return String
 */
function formatDBDate($date){	
	$nData = ereg_replace('([0-9]{2})/([0-9]{2})/([0-9]{4})','\\3-\\2-\\1',$date);
	if($date==$nData) $nData = ereg_replace('([0-9]{2})/([0-9]{2})','0000-\\2-\\1',$date);
	if($nData==$date) throw new FormException("Data inválida");
	return $nData;
}

/**
 * remove .'s, /'s e -'s do cpf digitado
 *
 * @param String $cpf
 * @return int
 */
function formatDBCPF($cpf){
	return str_replace("-","",str_replace("/","", str_replace(".","",$cpf)));
}

/**
 * recebe um valor com "," para separar as casas decimais e troca por ponto
 */
function formataDBValor($valor){
	return str_replace(",",".",$valor);
}

/**
 * recebe um valor com formato qualquer, e retona com 2 casas decimais, e "," para separar
 */
function formataValor($valor){
    return number_format($valor,2,',','');
}

?>
