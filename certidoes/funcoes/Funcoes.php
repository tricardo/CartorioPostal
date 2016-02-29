<?
Class Funcoes{
	public function limparurl($e){
	$msg = $e;
		$a = array(
		'|[ÂÀÁÄÃ]|'=>'A',
		'|[âàáäã]|'=>'a',
		'|[ÊÈÉË]|'=>'E',
		'|[êèéë]|'=>'e',
		'|[ÎÌÍÏ]|'=>'I',
		'|[îìíï]|'=>'i',
		'|[ÔÒÓÖÕ]|'=>'O',
		'|[ôòóöõ]|'=>'o',
		'|[ÛÙÚÜ]|'=>'U',
		'|[ûùúü]|'=>'u',
		'|Ç|'=>'C',
		'|ç|'=>'c',
		'|[Ñ]|'=>'',
		'|ñ|'=>'',
		'|"|'=>'',
		"|'|"=>'',
		"|!|"=>'',
		"|@|"=>'',
		"|#|"=>'',
		"|$|"=>'',
		"|%|"=>'',
		"|¨|"=>'',
		"|&|"=>'',
		"|\(|"=>'',
		"|\)|"=>'',
		"|_|"=>'',
		"|=|"=>'',
		"|`|"=>'',
		"|´|"=>'',
		"|^|"=>'',
		"|~|"=>'',
		"|\[|"=>'',
		"|\]|"=>'',
		"|\{|"=>'',
		"|\}|"=>'',
		"|\<|"=>'',
		"|\>|"=>'',
		"|\,|"=>'',
		"|\.|"=>'',
		"|\:|"=>'',
		"|\;|"=>'',
		"|\?|"=>'',
		"|\*|"=>'',
		"|\-|"=>'',
		"|\+|"=>'',
		"|\||"=>'',
		"|<script>|"=>'script',
		"|<//script>|"=>'/script'
		);
		$msg = preg_replace(array_keys($a), array_values($a), $msg);
	return $msg;
	}

	public function invert($datainv, $sep, $tipo){
		if($tipo!='SQL'){
			$ano = substr ("datainv", 0, 4);
			$mes = substr ("datainv", 5, 2);
			$dia = substr ("datainv", 8, 2);
			$datainv="$dia$sep$mes$sep$ano";
		}else{
			$ano = substr ("datainv", 6, 4);
			$mes = substr ("datainv", 3, 2);
			$dia = substr ("datainv", 0, 2);
			$datainv=$ano.'-'.$mes.'-'.$dia;
		}
	return $datainv;
	}

	public function validarCPF($cpf){
		$soma = 0;
		$cpf = str_replace('.', '', $cpf);
		$cpf = str_replace('-', '', $cpf);
		$cpf = str_replace('/', '', $cpf);
		if (strlen($cpf) <> 11 or $cpf=='11111111111' or $cpf=='22222222222' or $cpf=='33333333333' or $cpf=='44444444444' or $cpf=='55555555555' or $cpf=='66666666666' or $cpf=='77777777777' or $cpf=='88888888888' or $cpf=='99999999999'){
			$valida = 'false';
			return $valida;
		}
		$dv_informado = substr($cpf, 9,2);
		for($i=0; $i<=8; $i++){
			$digito[$i] = substr($cpf, $i,1);
		}
		$posicao = 10;
		$soma = 0;
		for($i=0; $i<=8; $i++){
			$soma = $soma + $digito[$i] * $posicao;
			$posicao = $posicao - 1;
		}
		$digito[9] = $soma % 11;
		if($digito[9] < 2){
			$digito[9] = 0;
		}else{
			$digito[9] = 11 - $digito[9];
		}
		$posicao = 11;
		$soma = 0;
		for ($i=0; $i<=9; $i++){
			$soma = $soma + $digito[$i] * $posicao;
			$posicao = $posicao - 1;
		}
		$digito[10] = $soma % 11;
		if($digito[10] < 2){
			$digito[10] = 0;
		}else{
			$digito[10] = 11 - $digito[10];
		}
		$dv = $digito[9] * 10 + $digito[10];
		$dv_informado = $dv_informado*1;
		if($dv != $dv_informado)
			$valida = 'false';
		else
			$valida = 'true';
		return $valida;
	}

	public function validarCNPJ($cnpj){
		$cnpj = str_replace('.', '', $cnpj);
		$cnpj = str_replace('-', '', $cnpj);
		$cnpj = str_replace('/', '', $cnpj);
		if(strlen($cnpj) <> 14)
			return 'false';
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
			if($cnpj[12] == $d1 && $cnpj[13] == $d2){
				return 'true';
			}else{
				return 'false';
			}
	}

	public function validarEmail($email){
		$mail_correcto = 0;
		if((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
			if((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))){
				if(substr_count($email,".")>= 1){
					$term_dom = substr(strrchr ($email, '.'),1);
					if(strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
						$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
						$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
						if ($caracter_ult != "@" && $caracter_ult != "."){
							$mail_correcto = 1;
						}
					}
				}
			}
		}
		if($mail_correcto)
			return 'true';
		else
			return 'false';
	}

	public function data(){
		$dia = date('d');
		$mes = date('m');
		$ano = date('Y');
		$semana = date('w');
		$hora = date('H');
		if($hora < 12){
			$frase='Bom dia!';
		}else
		if($hora < 18){
			$frase='Boa tarde!';
		}else{
			$frase='Boa noite!';
		}
		switch($mes){
			case 1: $mes = "Janeiro"; break;
			case 2: $mes = "Fevereiro"; break;
			case 3: $mes = "Março"; break;
			case 4: $mes = "Abril"; break;
			case 5: $mes = "Maio"; break;
			case 6: $mes = "Junho"; break;
			case 7: $mes = "Julho"; break;
			case 8: $mes = "Agosto"; break;
			case 9: $mes = "Setembro"; break;
			case 10: $mes = "Outubro"; break;
			case 11: $mes = "Novembro"; break;
			case 12: $mes = "Dezembro"; break;
		}
		switch($semana){
			case 0: $semana = "Domingo"; break;
			case 1: $semana = "Segunda feira"; break;
			case 2: $semana = "Terça feira"; break;
			case 3: $semana = "Quarta feira"; break;
			case 4: $semana = "Quinta feira"; break;
			case 5: $semana = "Sexta feira"; break;
			case 6: $semana = "Sábado"; break;
		}
		echo $semana.', '.$dia.' de '.$mes.' de '.$ano;
	}
}
?>