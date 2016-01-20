<?php
class ValidacaoCLASS extends Database{
	
	public function __construct(){
		parent::__construct();
	}

	/**
	* valida email
	* @param string $email
	*/
	public function validaEmail($email){
	   $mail_correcto = 0;
	   //verifico umas coisas
	   if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
		  if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
			 //vejo se tem caracter .
			 if (substr_count($email,".")>= 1){
				//obtenho a terminação do dominio
				$term_dom = substr(strrchr ($email, '.'),1);
				//verifico que a terminação do dominio seja correcta
				 if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
					//verifico que o de antes do dominio seja correcto
					$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
					$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
					if ($caracter_ult != "@" && $caracter_ult != "."){
					   $mail_correcto = 1;
					}
				 }
			  }
		   }
		}
		if ($mail_correcto) return $email;
		else return false;
	}

	/**
	* valida email
	* @param string $email
	*/
	public function validaLogin($email){
		$valida = $this->validaEmail($email);
		if($valida==false){
			return false;
		}
		$redeloginDAO = new RedeLoginDAO();
		$valida = $redeloginDAO->ValidaLogin($email);
		if($valida->total==0) return $email;
		else return false;
	}
	
   // VERFICA CNPJ
	public function validaCNPJ($cnpj_real) {
	  $cnpj = $cnpj_real;
      $cnpj = str_replace('.', '', $cnpj);
	  $cnpj = str_replace('-', '', $cnpj);
	  $cnpj = str_replace('/', '', $cnpj);   
      if (strlen($cnpj) <> 14)
         return false;

      $soma = 0;
      
      $soma += ($cnpj[0] * 5);
      $soma += ($cnpj[1] * 4);
      $soma += ($cnpj[2] * 3);
      $soma += ($cnpj[3] * 2);
      $soma += ($cnpj[4] * 9); 
      $soma += ($cnpj[5] * 8);
      $soma += ($cnpj[6] * 7);
      $soma += ($cnpj[7] * 6);
      $soma += ($cnpj[8] * 5);
      $soma += ($cnpj[9] * 4);
      $soma += ($cnpj[10] * 3);
      $soma += ($cnpj[11] * 2); 

      $d1 = $soma % 11; 
      $d1 = $d1 < 2 ? 0 : 11 - $d1; 

      $soma = 0;
      $soma += ($cnpj[0] * 6); 
      $soma += ($cnpj[1] * 5);
      $soma += ($cnpj[2] * 4);
      $soma += ($cnpj[3] * 3);
      $soma += ($cnpj[4] * 2);
      $soma += ($cnpj[5] * 9);
      $soma += ($cnpj[6] * 8);
      $soma += ($cnpj[7] * 7);
      $soma += ($cnpj[8] * 6);
      $soma += ($cnpj[9] * 5);
      $soma += ($cnpj[10] * 4);
      $soma += ($cnpj[11] * 3);
      $soma += ($cnpj[12] * 2); 
      
      
      $d2 = $soma % 11; 
      $d2 = $d2 < 2 ? 0 : 11 - $d2; 
      
      if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
         return $cnpj_real;
      }
      else {
         return false;
      }
   } 
	
	// VERIFICA CPF
	public function validaCPF($cpf_real) {
		$soma = 0;
		$cpf = $cpf_real;
		$cpf = str_replace('.', '', $cpf);
		$cpf = str_replace('-', '', $cpf);
		$cpf = str_replace('/', '', $cpf);
		if (strlen($cpf) <> 11 or $cpf=='11111111111' or $cpf=='22222222222' or $cpf=='33333333333' or $cpf=='44444444444' or $cpf=='55555555555' or $cpf=='66666666666' or $cpf=='77777777777' or $cpf=='88888888888' or $cpf=='99999999999'){
			$valida = false;
			return $valida;
		}
		// Verifica 1? digito

		//PEGA O DIGITO VERIFIACADOR
		$dv_informado = substr($cpf, 9,2);

		for($i=0; $i<=8; $i++) {
			$digito[$i] = substr($cpf, $i,1);
		}

		//CALCULA O VALOR DO 10? DIGITO DE VERIFICA??O
		$posicao = 10;
		$soma = 0;

		for($i=0; $i<=8; $i++) {
			$soma = $soma + $digito[$i] * $posicao;
			$posicao = $posicao - 1;
		}

		$digito[9] = $soma % 11;

		if($digito[9] < 2) {
			$digito[9] = 0;
		}
		else {
			$digito[9] = 11 - $digito[9];
		}

		//CALCULA O VALOR DO 11? DIGITO DE VERIFICA??O
		$posicao = 11;
		$soma = 0;

		for ($i=0; $i<=9; $i++) {
			$soma = $soma + $digito[$i] * $posicao;
			$posicao = $posicao - 1;
		}

		$digito[10] = $soma % 11;

		if ($digito[10] < 2) {
			$digito[10] = 0;
		}
		else {
			$digito[10] = 11 - $digito[10];
		}

		//VERIFICA SE O DV CALCULADO ? IGUAL AO INFORMADO
		$dv = $digito[9] * 10 + $digito[10];
		$dv_informado = $dv_informado*1;
		if ($dv != $dv_informado)
		$valida = false;
		else
		$valida = $cpf_real;
		return $valida;

	}

	// VERIFICA CPF
	public function validaCPFCNPJ($documento) {
		if(strlen(str_replace('/','',str_replace('.','',str_replace('-','',$documento))))==11) return $this->validaCPF($documento); 
		else  return $this->validaCNPJ($documento); 
	}
	
	function invertData($datainv){//recebe a data e o separador
		$sep = '-';
		if($datainv<>''){
			$ano=substr("$datainv",6, 4);
			$mes=substr("$datainv",3, 2);
			$dia=substr("$datainv",0, 2);
			$datainv=$ano.'-'.$mes.'-'.$dia;
		}
		return $datainv;
	}
	
}
?>