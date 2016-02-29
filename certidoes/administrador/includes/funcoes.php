<?
ini_set('date.timezone', 'America/Sao_Paulo');
function limpa_url($url){
	$url=str_replace('á', 'a', $url);
	$url=str_replace('à', 'a', $url);
	$url=str_replace('À', 'A', $url);
	$url=str_replace('Á', 'A', $url);
	$url=str_replace('ã', 'a', $url);
	$url=str_replace('Ã', 'A', $url);
	$url=str_replace('Â', 'A', $url);
	$url=str_replace('â', 'a', $url);
	$url=str_replace('é', 'e', $url);
	$url=str_replace('è', 'e', $url);
	$url=str_replace('È', 'E', $url);
	$url=str_replace('É', 'E', $url);
	$url=str_replace('ê', 'e', $url);
	$url=str_replace('Ê', 'E', $url);
	$url=str_replace('Ë', 'E', $url);
	$url=str_replace('ë', 'e', $url);
	$url=str_replace('í', 'i', $url);
	$url=str_replace('ì', 'i', $url);
	$url=str_replace('Ì', 'I', $url);
	$url=str_replace('Í', 'I', $url);
	$url=str_replace('î', 'i', $url);
	$url=str_replace('Î', 'I', $url);
	$url=str_replace('ï', 'i', $url);
	$url=str_replace('Ï', 'I', $url);
	$url=str_replace('ó', 'o', $url);
	$url=str_replace('ò', 'o', $url);
	$url=str_replace('Ò', 'O', $url);
	$url=str_replace('Ó', 'O', $url);
	$url=str_replace('õ', 'o', $url);
	$url=str_replace('Õ', 'O', $url);
	$url=str_replace('Ô', 'O', $url);
	$url=str_replace('ô', 'o', $url);
	$url=str_replace('ö', 'o', $url);
	$url=str_replace('Ö', 'O', $url);
	$url=str_replace('ú', 'u', $url);
	$url=str_replace('ù', 'u', $url);
	$url=str_replace('Ù', 'U', $url);
	$url=str_replace('Ú', 'U', $url);
	$url=str_replace('û', 'u', $url);
	$url=str_replace('Û', 'U', $url);
	$url=str_replace('ü', 'u', $url);
	$url=str_replace('Ü', 'U', $url);
	$url=str_replace('~', '', $url);
	$url=str_replace('^', '', $url);
	$url=str_replace('´', '', $url);
	$url=str_replace('`', '', $url);
	$url=str_replace('"', '', $url);
	$url=str_replace("'", '', $url);
	$url=str_replace('!', '', $url);
	$url=str_replace('@', '', $url);
	$url=str_replace(']', '', $url);
	$url=str_replace('[', '', $url);
	$url=str_replace('}', '', $url);
	$url=str_replace('{', '', $url);
	$url=str_replace('ç', 'c', $url);
	$url=str_replace('Ç', 'C', $url);
	$url=str_replace(',', '', $url);
	$url=str_replace('.', '', $url);
	$url=str_replace('>', '', $url);
	$url=str_replace('<', '', $url);
	$url=str_replace(';', '', $url);
	$url=str_replace(':', '', $url);
	$url=str_replace('?', '', $url);
	$url=str_replace('/', '', $url);
	$url=str_replace("\\", '', $url);
	$url=str_replace('|', '', $url);
	$url=str_replace('#', '', $url);
	$url=str_replace('$', '', $url);
	$url=str_replace('%', '', $url);
	$url=str_replace('¨', '', $url);
	$url=str_replace('&', '', $url);
	$url=str_replace('*', '', $url);
	$url=str_replace('(', '', $url);
	$url=str_replace(')', '', $url);
	$url=str_replace('-', '', $url);
	$url=str_replace('_', '', $url);
	$url=str_replace('=', '', $url);
	$url=str_replace('+', '', $url);
	$url=str_replace(' ', '', $url);
	return $url;
}
function diasemana($data){
	$ano = substr("$data", 0, 4);
	$mes = substr("$data", 5, -3);
	$dia = substr("$data", 8, 9);
	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
	return $diasemana;
}
function invert($datainv,$sep, $tipo){//recebe a data e o separador
	if($tipo!='SQL'){
		$ano=substr("$datainv",0, 4);
		$mes=substr("$datainv",5, 2);
		$dia=substr("$datainv",8, 2);
		$datainv="$dia$sep$mes$sep$ano";
	}else{
		$ano=substr("$datainv",6, 4);
		$mes=substr("$datainv",3, 2);
		$dia=substr("$datainv",0, 2);
		$datainv=$ano.'-'.$mes.'-'.$dia;
	}
	return $datainv;
}
#verifica permissao
function verifica_permissao($area, $id_permissao_p, $id_permissao_s){//recebe a data e o separador
	$id_permissao_p = explode(',',$id_permissao_p);
	$id_permissao_s = explode(',',$id_permissao_s);

	//-----------------------------Módulos principais-----------------------------//

	//Pemissão Administrador
	if($area=='cadastro_permissao'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p)) return 'TRUE';
	}
	if($area=='lista_permissao'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_permissao'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_keyword'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p)) return 'TRUE';
	}
	if($area=='lista_keyword'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_keyword'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p)) return 'TRUE';
	}

	//Pemissão Diretor
	if($area=='diretor'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('2', $id_permissao_s) or in_array('2', $id_permissao_p)) return 'TRUE';
	}
	if($area=='permissao_ativo'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('2', $id_permissao_s)) return 'TRUE';
	}
	if($area=='cadastro_usuarios'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('2', $id_permissao_s)) return 'TRUE';
	}
	if($area=='lista_usuario'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('2', $id_permissao_s) or in_array('2', $id_permissao_p)) return 'TRUE';
	}
	if($area=='usuario_permissao'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('2', $id_permissao_s)) return 'TRUE';
	}
	if($area=='enviar_senha'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('2', $id_permissao_s)) return 'TRUE';
	}
	if($area=='editar_usuario'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('2', $id_permissao_s)) return 'TRUE';
	}

	//Pemissão Recursos Humanos
	if($area=='rh'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('3', $id_permissao_s) or in_array('3', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_area_pretendida'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('3', $id_permissao_s)) return 'TRUE';
	}
	if($area=='lista_area_pretendida'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('3', $id_permissao_s) or in_array('3', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_area_pretendida'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('3', $id_permissao_s) or in_array('3', $id_permissao_p)) return 'TRUE';
	}
	if($area=='lista_candidatos'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('3', $id_permissao_s) or in_array('3', $id_permissao_p)) return 'TRUE';
	}

	//Pemissão Notícias
	if($area=='news'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('4', $id_permissao_s) or in_array('4', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_news'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p)  or in_array('4', $id_permissao_s)) return 'TRUE';
	}
	if($area=='lista_news'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('4', $id_permissao_s) or in_array('4', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_news'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('4', $id_permissao_s) or in_array('4', $id_permissao_p)) return 'TRUE';
	}

	//Pemissão Galeria de Fotos
	if($area=='galeria_imagens'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('5', $id_permissao_s) or in_array('5', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_categoria_imagens'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('5', $id_permissao_s)) return 'TRUE';
	}
	if($area=='lista_categoria_imagens'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('5', $id_permissao_s) or in_array('5', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_categoria_imagens'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('5', $id_permissao_s) or in_array('5', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_imagens'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('5', $id_permissao_s)) return 'TRUE';
	}
	if($area=='lista_imagens'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('5', $id_permissao_s) or in_array('5', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_imagens'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('5', $id_permissao_s) or in_array('5', $id_permissao_p)) return 'TRUE';
	}
	if($area=='lista_fachada'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('5', $id_permissao_s) or in_array('5', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_fachada'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('5', $id_permissao_s) or in_array('5', $id_permissao_p)) return 'TRUE';
	}

	//Pemissão Galeria de Vídeos
	if($area=='galeria_videos'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('6', $id_permissao_s) or in_array('6', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_categoria_videos'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('6', $id_permissao_s)) return 'TRUE';
	}
	if($area=='lista_categoria_videos'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('6', $id_permissao_s) or in_array('6', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_categoria_videos'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('6', $id_permissao_s) or in_array('6', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_videos'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('6', $id_permissao_s)) return 'TRUE';
	}
	if($area=='lista_videos'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('6', $id_permissao_s) or in_array('6', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_videos'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('6', $id_permissao_s) or in_array('6', $id_permissao_p)) return 'TRUE';
	}

	//Pemissão Contato
	if($area=='contato'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('7', $id_permissao_s) or in_array('7', $id_permissao_p)) return 'TRUE';
	}
	if($area=='lista_contato'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('7', $id_permissao_s) or in_array('7', $id_permissao_p)) return 'TRUE';
	}

	//Pemissão Comentários
	if($area=='comentario'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('8', $id_permissao_s) or in_array('8', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_comentario'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('8', $id_permissao_s)) return 'TRUE';
	}
	if($area=='lista_comentario'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('8', $id_permissao_s) or in_array('8', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_comentario'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('8', $id_permissao_s)) return 'TRUE';
	}
	
	//Treinadores
	if($area=='treinadores'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('9', $id_permissao_s) or in_array('9', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_treinadores'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('9', $id_permissao_s) or in_array('9', $id_permissao_p)) return 'TRUE';
	}
	if($area=='lista_treinadores'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('9', $id_permissao_s) or in_array('9', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_treinadores'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('9', $id_permissao_s) or in_array('9', $id_permissao_p)) return 'TRUE';
	}
	
	//Pemissão Unidades
	if($area=='unidades'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('10', $id_permissao_s) or in_array('10', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_unidades'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('10', $id_permissao_s) or in_array('10', $id_permissao_p)) return 'TRUE';
	}
	if($area=='lista_unidades'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('10', $id_permissao_s) or in_array('10', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_unidades'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('10', $id_permissao_s) or in_array('10', $id_permissao_p)) return 'TRUE';
	}
	
	//Pemissão Depoimento
	if($area=='depoimento'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('11', $id_permissao_s) or in_array('11', $id_permissao_p)) return 'TRUE';
	}
	if($area=='lista_depoimento'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('11', $id_permissao_s) or in_array('11', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_depoimento'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('11', $id_permissao_s)) return 'TRUE';
	}
	
	//Pemissão Hotsite
	if($area=='hotsite'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('12', $id_permissao_s) or in_array('12', $id_permissao_p)) return 'TRUE';
	}
	if($area=='cadastro_hotsite'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('12', $id_permissao_s)) return 'TRUE';
	}
	if($area=='lista_hotsite'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('12', $id_permissao_s) or in_array('12', $id_permissao_p)) return 'TRUE';
	}
	if($area=='editar_hotsite'){
		if(in_array('1', $id_permissao_s) or in_array('1', $id_permissao_p) or in_array('12', $id_permissao_s)) return 'TRUE';
	}

	//-----------------------------Módulos adicionais-----------------------------//

	return 'FALSE';
}

// VERIFICA CPF
function validaCPF($cpf){
	$soma = 0;
	$cpf = str_replace('.', '', $cpf);
	$cpf = str_replace('-', '', $cpf);
	$cpf = str_replace('/', '', $cpf);
		if (strlen($cpf) <> 11 or $cpf=='11111111111' or $cpf=='22222222222' or $cpf=='33333333333' or $cpf=='44444444444' or $cpf=='55555555555' or $cpf=='66666666666' or $cpf=='77777777777' or $cpf=='88888888888' or $cpf=='99999999999'){
			$valida = 'false';
			return $valida;
		}
	// Verifica 1º digito  
	//PEGA O DIGITO VERIFIACADOR
	$dv_informado = substr($cpf, 9,2);
	for($i=0; $i<=8; $i++){
		$digito[$i] = substr($cpf, $i,1);
	}

	//CALCULA O VALOR DO 10º DIGITO DE VERIFICAÇÂO
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

	//CALCULA O VALOR DO 11º DIGITO DE VERIFICAÇÃO
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

	//VERIFICA SE O DV CALCULADO É IGUAL AO INFORMADO
	$dv = $digito[9] * 10 + $digito[10];
	$dv_informado = $dv_informado*1;
	if($dv != $dv_informado)
		$valida = 'false';
	else
		$valida = 'true';
		return $valida;
}

function validaEMAIL($email){
	$mail_correcto = 0; 
		//verifico umas coisas
		if((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
			if((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))){
			//vejo se tem caracter.
				if(substr_count($email,".")>= 1){
				//obtenho a terminação do dominio
					$term_dom = substr(strrchr ($email, '.'),1);
					//verifico que a terminação do dominio seja correcta
					if(strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
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
	if ($mail_correcto)
		return 'true';
	else
		return 'false';
}

// VERFICA CNPJ
function validaCNPJ($cnpj){
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

#soma data
function SomarData($data, $dias, $meses, $ano){
	//passe a data no formato dd/mm/yyyy
	$data = explode("/", $data);
	$newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses,
	$data[0] + $dias, $data[2] + $ano) );
	return $newData;
}
#fim soma data

function somar_dias_uteis($str_data,$int_qtd_dias_somar = 7){
	// Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
	// Transforma para DATE - aaaa-mm-dd
	$str_data = substr($str_data,0,10);
	// Se a data estiver no formato brasileiro: dd/mm/aaaa
	// Converte-a para o padrão americano: aaaa-mm-dd
	if( preg_match("@/@",$str_data) == 1 ){
		$str_data = implode("-", array_reverse(explode("/",$str_data)));
	}
	$array_data = explode('-', $str_data);
	$count_days = 0;
	$int_qtd_dias_uteis = 0;
	while( $int_qtd_dias_uteis < $int_qtd_dias_somar ){
		$count_days++;
		if( ( $dias_da_semana = gmdate('w', strtotime('+'.$count_days.' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6' ){
			$int_qtd_dias_uteis++;
		}
	}
	return gmdate('d/m/Y',strtotime('+'.$count_days.' day',strtotime($str_data)));
}

#dias uteis
function dias_uteis($datainicial,$datafinal=null){
	if(!isset($datainicial)) return false;
	if(!isset($datafinal)) $datafinal=date('d/m/Y');
	$segundos_datainicial = strtotime(preg_replace("#(\d{2})/(\d{2})/(\d{4})#","$3/$2/$1",$datainicial));
	$segundos_datafinal = strtotime(preg_replace("#(\d{2})/(\d{2})/(\d{4})#","$3/$2/$1",$datafinal));
	$dias = abs(floor(floor(($segundos_datafinal-$segundos_datainicial)/3600)/24 ) );
	$uteis=0;
	for($i=1;$i<=$dias;$i++){
		$diai = $segundos_datainicial+($i*3600*24);
		$w = date('w',$diai);
		if ($w==0){
		//echo date('d/m/Y',$diai)." ? Domingo<br />";
		}elseif($w==6){
			//echo date('d/m/Y',$diai)." ? Sábado<br />";
		}else{
			//echo date('d/m/Y',$diai)." ? dia útil<br />";
			$uteis++;
		}
	}
return $uteis;
}

function RemoveAcentos($Msg){
	$a = array(
	'|[ÂÀÁÄÃ]|'=>'A',
	'|[âãàáä]|'=>'a',
	'|[ÊÈÉË]|'=>'E',
	'|[êèéë]|'=>'e',
	'|[ÎÍÌÏ]|'=>'I',
	'|[îíìï]|'=>'i',
	'|[ÔÕÒÓÖ]|'=>'O',
	'|[ôõòóö]|'=>'o',
	'|[ÛÙÚÜ]|'=>'U',
	'|[ûúùü]|'=>'u',
	'|ç|'=>'c',
	'|Ç|'=>'C');
	// Tira o acento pela chave do array
	return preg_replace(array_keys($a), array_values($a), $Msg);
}
?>