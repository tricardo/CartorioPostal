<?
	function limpa_url( $url ){
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

function diasemana($data) {
	$ano =  substr("$data", 0, 4);
	$mes =  substr("$data", 5, -3);
	$dia =  substr("$data", 8, 9);

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
	function verifica_permissao($area, $id_departamento_saf){//recebe a data e o separador
	$id_departamento_saf = explode(',',$id_departamento_saf);
	
		if($area=='FTP'){
			if(in_array('5', $id_departamento_saf) or in_array('6', $id_departamento_saf)) return 'TRUE';
		}	

		if($area=='USUARIOS'){
			if(in_array('6', $id_departamento_saf) or in_array('35', $id_departamento_saf)) return 'TRUE';
		}
		
		if($area=='COMUNICADO'){
			if(in_array('1', $id_departamento_saf) or in_array('35', $id_departamento_saf)) return 'TRUE';
		}	

		if($area=='CHAT'){
			if(in_array('1', $id_departamento_saf) or in_array('17', $id_departamento_saf) or in_array('16', $id_departamento_saf) or in_array('15', $id_departamento_saf) or in_array('14', $id_departamento_saf) or in_array('13', $id_departamento_saf) or in_array('12', $id_departamento_saf) or in_array('11', $id_departamento_saf) or in_array('10', $id_departamento_saf) or in_array('9', $id_departamento_saf) or in_array('8', $id_departamento_saf) or in_array('7', $id_departamento_saf) or in_array('2', $id_departamento_saf)) return 'TRUE';
		}			

		if($area=='HELPDESK'){
			if(in_array('3', $id_departamento_saf) or in_array('4', $id_departamento_saf) or in_array('18', $id_departamento_saf) or in_array('19', $id_departamento_saf) or in_array('20', $id_departamento_saf) or in_array('21', $id_departamento_saf) or in_array('22', $id_departamento_saf) or in_array('23', $id_departamento_saf) or in_array('24', $id_departamento_saf) or in_array('25', $id_departamento_saf) or in_array('26', $id_departamento_saf) or in_array('27', $id_departamento_saf) or in_array('28', $id_departamento_saf)) return 'TRUE';
		}			

		if($area=='FORUM'){
			if(in_array('29', $id_departamento_saf)) return 'TRUE';
		}			

		if($area=='NEWS'){
			if(in_array('30', $id_departamento_saf)) return 'TRUE';
		}
		
		if($area=='EXPANSAO'){
			if(in_array('34', $id_departamento_saf)) return 'TRUE';
		}		

		return 'FALSE';	
	}

   // VERIFICA CPF
   function validaCPF($cpf) {

      $soma = 0;
      $cpf = str_replace('.', '', $cpf);
	  $cpf = str_replace('-', '', $cpf);
	  $cpf = str_replace('/', '', $cpf);
      if (strlen($cpf) <> 11 or $cpf=='11111111111' or $cpf=='22222222222' or $cpf=='33333333333' or $cpf=='44444444444' or $cpf=='55555555555' or $cpf=='66666666666' or $cpf=='77777777777' or $cpf=='88888888888' or $cpf=='99999999999' or $cpf=='00000000000'){
		 $valida = 'false';
         return $valida;
      }
      // Verifica 1º digito  
	  
   //PEGA O DIGITO VERIFIACADOR
   $dv_informado = substr($cpf, 9,2);

   for($i=0; $i<=8; $i++) {
    $digito[$i] = substr($cpf, $i,1);
   }

   //CALCULA O VALOR DO 10º DIGITO DE VERIFICAÇÂO
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

   //CALCULA O VALOR DO 11º DIGITO DE VERIFICAÇÃO
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

  //VERIFICA SE O DV CALCULADO É IGUAL AO INFORMADO
  $dv = $digito[9] * 10 + $digito[10];
  $dv_informado = $dv_informado*1;
  if ($dv != $dv_informado)
   $valida = 'false';
  else
   $valida = 'true';
	return $valida;
    
   }
   
   
	function validaEMAIL($email){ 
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
	
	if ($mail_correcto) 
	   return 'true'; 
	else 
	   return 'false';   
	}    
   
   
   // VERFICA CNPJ
   function validaCNPJ($cnpj) {
      $cnpj = str_replace('.', '', $cnpj);
	  $cnpj = str_replace('-', '', $cnpj);
	  $cnpj = str_replace('/', '', $cnpj);   
      if (strlen($cnpj) <> 14)
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
      
      if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
         return 'true';
      }
      else {
         return 'false';
      }
   } 

   function valida_upload_img($arquivo, $config) {
		// Verifica se o mime-type do arquivo é de imagem
		$error='';
		if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
		{
				$error.="<li><b>Arquivo em formato inválido! A imagem deve ser jpg, jpeg, 
				bmp, gif ou png. Envie outro arquivo.</b></li>";	
		}
		else
		{
			// Verifica tamanho do arquivo
			if($arquivo["size"] > $config["tamanho"])
			{
				$error.="<li><b>Arquivo em tamanho muito grande! 
			A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. 
			Envie outro arquivo.</b></li>";		
			}
			
			// Para verificar as dimensões da imagem
			$tamanhos = getimagesize($arquivo["tmp_name"]);
			
			// Verifica largura
			if($tamanhos[0] > $config["largura"])
			{
				$error.="<li><b>Largura da imagem não deve 
					ultrapassar " . $config["largura"] . " pixels.</b></li>";			
			}
	
			// Verifica altura
			if($tamanhos[1] > $config["altura"])
			{
				$error.="<li><b>Altura da imagem não deve 
					ultrapassar " . $config["altura"] . " pixels.</b></li>";		
			}
		}  
		return $error; 
   }   
   
   function valida_upload_pdf($arquivo, $config) {
		// Verifica se o mime-type do arquivo é de imagem
		$error='';
		if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp|pdf)$", $arquivo["type"]) and !eregi("^application\/(pdf)$", $arquivo["type"]))
		{
				$error.="<li><b>Arquivo em formato inválido! A imagem deve ser jpg, jpeg, 
				bmp, gif, pdf ou png. Envie outro arquivo.</b></li>";	
		}
		return $error; 
   }      
   
   function valida_upload_csv($arquivo, $config) {
		// Verifica se o mime-type do arquivo é de imagem
		$error='';
		if(!eregi(".csv$", $arquivo["type"]))
		{
				$error.="<li><b>Arquivo em formato inválido! O arquivo precisa ser CSV. Envie outro arquivo.</b></li>";
		}
		return $error;
   }

   function valida_upload_txt($arquivo) {
		// Verifica se o mime-type do arquivo é de imagem
		$error='';
		if(!eregi("text/plain$", $arquivo["type"]))
		{
				$error.="<li><b>Arquivo em formato inválido! O arquivo precisa ser REM ou TXT. Envie outro arquivo.</b></li>";
		}
		return $error;
   }
   
   function valida_upload($arquivo) {
		// Verifica se o mime-type do arquivo é de imagem
		$error='';
		$arquivo["type"];
		#echo $arquivo["type"];
		if(!eregi(".csv$", $arquivo["type"]) and !eregi("^image\/(pjpeg|jpeg|png|gif|bmp|zip)$", $arquivo["type"]) and !eregi("^application\/(pdf|msword|x-zip-compressed|zip|rar|vnd.ms-excel|vnd.openxmlformats-officedocument.spreadsheetml.sheet|vnd.ms-powerpoint|osd|x-www-form-urlencoded)$", $arquivo["type"]))
		{
				$error.="<li><b>Arquivo em formato inválido! O arquivo precisa ser pdf|doc|docx|zip|xls|xlsx|ppt|pps|pptx|osd|pjpeg|jpeg|png|gif|bmp|csv. Envie outro arquivo.</b>[".$arquivo["type"]."]</li>";
		}
		return $error;
   }   
   
#soma data
function SomarData($data, $dias, $meses, $ano)
{
  //passe a data no formato dd/mm/yyyy 
   $data = explode("/", $data);
   $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses,
  $data[0] + $dias, $data[2] + $ano) );
   return $newData;
}   
#fim soma data

   
# Gera Thumbnails
function thumbMaker($imagem, $aprox, $destino)
{
    if (!file_exists($imagem))
    {
        echo "<center><h3>Imagem não encontrada.</h3></center>";
        return false;
    }

    // verifica se está executando sob windows ou unix-like, para a
    // aplicação do separador de diretórios correto.
       $barra= "/";

    // obtém a extensão pelo mime-type
    $ext= getExt($imagem);
    if (!$ext)
    {
       echo "<center><h3>Tipo inválido</h3></center>";
       return false;
    }
    // separa o nome do arquivo do(s) diretório(s)
    $dir_arq= explode($barra, $imagem);

      
    // monta o nome do arquivo a ser gerado (thumbnail). O sizeof abaixo obtém o número de itens
    // no array, dessa forma podemos pegar somente o nome do arquivo, não importando em que
    // diretório está.
    $i= sizeof($dir_arq) - 1; // pega o nome do arquivo, sem os diretórios
    $arquivo_miniatura= $destino.$barra."mini_".$dir_arq[$i];
      
    // imagem de origem
    if ($ext == "png")
        $img_origem= imagecreatefrompng($imagem);
    elseif ($ext == "jpg")
        $img_origem= imagecreatefromjpeg($imagem);
      
    // obtém as dimensões da imagem original
    $origem_x= ImagesX($img_origem);
    $origem_y= ImagesY($img_origem);
      
    $x= $origem_x;
    $y= $origem_y;
      
    // Aqui é feito um cálculo para aproximar o tamanho da imagem ao valor passado em $aprox.
    // Não importa se a foto for grande ou pequena, o thumb de todas elas será mais ou menos do
    // mesmo tamanho.
    if ($x >= $y)
    {
        if ($x > $aprox)
        {      
            $x1= (int)($x * ($aprox/$x));    
            $y1= (int)($y * ($aprox/$x));
        }
        // incluido o else abaixo. Caso a imagem seja menor do que
        // deve ser aproximado, mantém tamanho original para o thumb.
        else
        {
            $x1= $x;
            $y1= $y;
        }
    }
    else
    {
        if ($y > $aprox)
        {
            $x1= (int)($x * ($aprox/$y));
            $y1= (int)($y * ($aprox/$y));
        }
        // incluido o else abaixo. Caso a imagem seja menor do que
        // deve ser aproximado, mantém tamanho original para o thumb.
        else
        {
            $x1= $x;
            $y1= $y;
        }
    }
    $x= $x1;
    $y= $y1;

    // cria a imagem do thumbnail
    $img_final = ImageCreateTrueColor($x, $y);
    ImageCopyResampled($img_final, $img_origem, 0, 0, 0, 0, $x+1, $y+1, $origem_x, $origem_y);
      
    // o arquivo é gravado
    if ($ext == "png")
        imagepng($img_final, $arquivo_miniatura);
    elseif ($ext == "jpg")
        imagejpeg($img_final, $arquivo_miniatura);
      
    // a memória usada para tudo isso é liberada.
    ImageDestroy($img_origem);
    ImageDestroy($img_final);
    
    return true;
}

// getExt - Verifica o mime-type da imagem e retorna a extensão do arquivo
function getExt($imagem)
{
    // isso é para obter o mime-type da imagem.
    $mime= getimagesize($imagem);

    if ($mime[2] == 2)
    {
       $ext= "jpg";
       return $ext;
    }
    else
    if ($mime[2] == 3)
    {
       $ext= "png";
       return $ext;
    }
    else
       return false;
}


function somar_dias_uteis($str_data,$int_qtd_dias_somar = 7) {

    // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00

    // Transforma para DATE - aaaa-mm-dd

    $str_data = substr($str_data,0,10);

    // Se a data estiver no formato brasileiro: dd/mm/aaaa

    // Converte-a para o padrão americano: aaaa-mm-dd

    if ( preg_match("@/@",$str_data) == 1 ) {

        $str_data = implode("-", array_reverse(explode("/",$str_data)));

    }

    $array_data = explode('-', $str_data);

    $count_days = 0;

    $int_qtd_dias_uteis = 0;

    while ( $int_qtd_dias_uteis < $int_qtd_dias_somar ) {

        $count_days++;

                if ( ( $dias_da_semana = gmdate('w', strtotime('+'.$count_days.' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6' ) {

            $int_qtd_dias_uteis++;

        }

    }

    return gmdate('d/m/Y',strtotime('+'.$count_days.' day',strtotime($str_data)));

}
#fim do gera thumbnails  

#dias uteis
function dias_uteis($datainicial,$datafinal=null){
  if (!isset($datainicial)) return false;
  if (!isset($datafinal)) $datafinal=date('d/m/Y');

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

function __autoload($classe) {
	$dir = preg_match('/^([A-Z][a-z]+)DAO/i', $classe, $result);
	if(is_file("../model/".$result[1]."DAO.php")) {
		require_once("../model/".$result[1]."DAO.php");
		return;
	} else {
		$dir = preg_match('/^([A-Z][a-z]+)CLASS/i', $classe, $result);
		if(is_file("../classes/".$result[1]."CLASS.php")) {
			require_once("../classes/".$result[1]."CLASS.php");
			return;
		}
	}
}
?>