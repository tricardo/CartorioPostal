<?php
/**
 * validação de cpf
 *
 * @param unknown_type $cpf
 * @return unknown
 */
function validaCPF($cpf) {
	$nulos = array("12345678909","11111111111","22222222222","33333333333",
               "44444444444","55555555555","66666666666","77777777777",
               "88888888888","99999999999","00000000000");
	/* Retira todos os caracteres que nao sejam 0-9 */
	$cpf = ereg_replace("[^0-9]", "", $cpf);

	/*Retorna falso se houver letras no cpf */
	if (!(ereg("[0-9]",$cpf)))
	return 0;

	/* Retorna falso se o cpf for nulo */
	if( in_array($cpf, $nulos) )
	return 0;

	/*Calcula o penúltimo dígito verificador*/
	$acum=0;
	for($i=0; $i<9; $i++) {
		$acum+= $cpf[$i]*(10-$i);
	}

	$x=$acum % 11;
	$acum = ($x>1) ? (11 - $x) : 0;
	/* Retorna falso se o digito calculado eh diferente do passado na string */
	if ($acum != $cpf[9]){
		return 0;
	}
	/*Calcula o último dígito verificador*/
	$acum=0;
	for ($i=0; $i<10; $i++){
		$acum+= $cpf[$i]*(11-$i);
	}

	$x=$acum % 11;
	$acum = ($x > 1) ? (11-$x) : 0;
	/* Retorna falso se o digito calculado eh diferente do passado na string */
	if ( $acum != $cpf[10]){
		return 0;
	}
	/* Retorna verdadeiro se o cpf eh valido */
	return 1;
}

/**
 * validação de cnpj
 * @param String $cnpj
 * @return boolean
 */
function validaCNPJ($cnpj) { 
    if (strlen($cnpj) <> 18) return 0; 
    $soma1 = ($cnpj[0] * 5) + 

    ($cnpj[1] * 4) + 
    ($cnpj[3] * 3) + 
    ($cnpj[4] * 2) + 
    ($cnpj[5] * 9) + 
    ($cnpj[7] * 8) + 
    ($cnpj[8] * 7) + 
    ($cnpj[9] * 6) + 
    ($cnpj[11] * 5) + 
    ($cnpj[12] * 4) + 
    ($cnpj[13] * 3) + 
    ($cnpj[14] * 2); 
    $resto = $soma1 % 11; 
    $digito1 = $resto < 2 ? 0 : 11 - $resto; 
    $soma2 = ($cnpj[0] * 6) + 

    ($cnpj[1] * 5) + 
    ($cnpj[3] * 4) + 
    ($cnpj[4] * 3) + 
    ($cnpj[5] * 2) + 
    ($cnpj[7] * 9) + 
    ($cnpj[8] * 8) + 
    ($cnpj[9] * 7) + 
    ($cnpj[11] * 6) + 
    ($cnpj[12] * 5) + 
    ($cnpj[13] * 4) + 
    ($cnpj[14] * 3) + 
    ($cnpj[16] * 2); 
    $resto = $soma2 % 11; 
    $digito2 = $resto < 2 ? 0 : 11 - $resto; 
    return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2)); 
} 


/**
 * verifica se a variável de sessão 'usuario' está setada
 *
 * @return bool
 */
function login(){
	return isset($_SESSION['usuario']);
}
?>