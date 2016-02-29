<?
ini_set('allow_url_fopen','on');

class ApiGoogleDAO extends Database {
		
	public function Coordenadas($c){
		$output = $c->output;;
		$api    = 'ABQIAAAAiPpCLqL4m3fqUIAOMSQiFhQ8QZj1Dx6_C4H5amaN-KZqBDG7AxRM8IrIY-U62JoHMPi7yngpHPeVLA'; #http://www.cartoriopostal.com.br
		$url    = urlencode(utf8_encode($c->url));
		$url    = 'http://maps.google.com/maps/geo?q='.$url.'&output='.$output.'&sensor=true_or_false&key=ABQIAAAAi-3nuTBxPHSWIpNFR_PNiRQ8QZj1Dx6_C4H5amaN-KZqBDG7AxT31Vu4oQawdx3WeXMLFRy2IBE4KQ';
		
		#echo $url.'<br>';
		
		$pagina = file_get_contents($url);   
		$xml = new SimpleXMLElement($pagina);
		$retorno = array(0,0,0);
		if($xml->Response->Status->code == 200){
			$retorno = $xml->Response->Placemark->Point->coordinates;
			$result  = explode(',',$retorno);
			$retorno = array($result[1], $result[0], $xml->Response->Status->code); #longitude, latitude, erro
		}
		return $retorno;		
	}
	
	public function CalcularRaio($p1lat, $p1lon, $p2lat, $p2lon){
		$a = 6378137;
    	$b = 6356752.3142;
    	$f = 1/298.257223563;
		$L = deg2rad($p2lon - $p1lon);
		$U1 = atan((1-$f) * tan(deg2rad($p1lat)));
		$U2 = atan((1-$f) * tan(deg2rad($p2lat)));
		$sinU1 = sin($U1);
		$cosU1 = cos($U1);
		$sinU2 = sin($U2);
		$cosU2 = cos($U2);
		$lambda = $L;
        $lambdaP = 2 * pi();
    	$iterLimit = 20;

		while (abs ($lambda - $lambdaP) > 1e-12 && --$iterLimit > 0) {
			$sinLambda = sin($lambda);
			$cosLambda = cos($lambda);
			$sinSigma = sqrt(($cosU2 * $sinLambda) * ($cosU2 * $sinLambda) +
			($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda) * ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda));
			if ($sinSigma==0) {
				return 0;
			}
			$cosSigma = $sinU1 * $sinU2 + $cosU1 * $cosU2 * $cosLambda;
			$sigma = atan2($sinSigma, $cosSigma);
			$alpha = asin($cosU1 * $cosU2 * $sinLambda / $sinSigma);
			$cosSqAlpha = cos($alpha) * cos($alpha);
			$cos2SigmaM = $cosSigma - 2 * $sinU1 * $sinU2 / $cosSqAlpha;
			$C = $f / 16 * $cosSqAlpha * (4 + $f * (4 - 3 * $cosSqAlpha));
			$lambdaP = $lambda;
			$lambda = $L + (1 - $C) * $f * sin($alpha) *
			($sigma + $C * $sinSigma * ($cos2SigmaM + $C * $cosSigma * (-1 + 2 * $cos2SigmaM * $cos2SigmaM)));
		}
		if ($iterLimit==0) {
			return null;
		}
		$uSq = $cosSqAlpha * ($a * $a - $b * $b) / ($b * $b);
		$A = 1 + $uSq / 16384 * (4096 + $uSq * (-768 + $uSq * (320 - 175 * $uSq)));
		$B = $uSq / 1024 * (256 + $uSq * (-128 + $uSq * (74 - 47 * $uSq)));
		$deltaSigma = $B * $sinSigma * ($cos2SigmaM + $B / 4 * ($cosSigma * (-1 + 2 * $cos2SigmaM * $cos2SigmaM) -
		$B / 6 * $cos2SigmaM * (-3 + 4 * $sinSigma * $sinSigma) * (-3 + 4 * $cos2SigmaM * $cos2SigmaM)));
		$s = $b * $A * ($sigma - $deltaSigma);
		return round($s, 3);
	}
	
	public function LimpaEndereco($str){
		$str = strtolower($str);
		$str = str_replace(" ", '+', $str);
		$str = str_replace("'", '', $str);
		$str = str_replace('"', '', $str);
		$str = str_replace('/', '', $str);
		$str = str_replace('*', '', $str);
		$str = str_replace('-', '', $str);
		$str = str_replace('.', '', $str);
		$str = str_replace(',', '', $str);
		$str = str_replace('[', '', $str);
		$str = str_replace(']', '', $str);
		$str = str_replace('{', '', $str);
		$str = str_replace('}', '', $str);
		$str = str_replace('?', '', $str);
		$str = str_replace('!', '', $str);
		$str = str_replace('@', '', $str);
		$str = str_replace('#', '', $str);
		$str = str_replace('$', '', $str);
		$str = str_replace('%', '', $str);
		$str = str_replace('&', '', $str);
		$str = str_replace('(', '', $str);
		$str = str_replace(')', '', $str);
		$str = str_replace('=', '', $str);
		$str = str_replace('\\', '', $str);
		$str = str_replace('|', '', $str);
		$str = str_replace('~', '', $str);
		$str = str_replace('^', '', $str);
		$str = str_replace('`', '', $str);
		$str = str_replace('ã', 'a', $str);
		$str = str_replace('ä', 'a', $str);
		$str = str_replace('â', 'a', $str);
		$str = str_replace('á', 'a', $str);
		$str = str_replace('à', 'a', $str);
		$str = str_replace('ë', 'e', $str);
		$str = str_replace('ê', 'e', $str);
		$str = str_replace('é', 'e', $str);
		$str = str_replace('è', 'e', $str);
		$str = str_replace('ï', 'i', $str);
		$str = str_replace('í', 'i', $str);
		$str = str_replace('ì', 'i', $str);
		$str = str_replace('î', 'i', $str);
		$str = str_replace('õ', 'o', $str);
		$str = str_replace('ó', 'o', $str);
		$str = str_replace('ò', 'o', $str);
		$str = str_replace('ö', 'o', $str);
		$str = str_replace('ô', 'o', $str);
		$str = str_replace('ú', 'u', $str);
		$str = str_replace('ù', 'u', $str);
		$str = str_replace('û', 'u', $str);
		$str = str_replace('ü', 'u', $str);
		$str = str_replace('ç', 'c', $str);
		$str = str_replace("av ", 'avenida ', $str);
		$str = str_replace("av. ", 'avenida ', $str);
		$str = str_replace("dr ", 'doutor ', $str);
		$str = str_replace("dr. ", 'doutor ', $str);
		$str = str_replace("jd ", 'jardim ', $str);
		$str = str_replace("jd. ", 'jardim ', $str);
		return $str;
	}
	
	public function verificaRegiao($p){

		$c = new stdClass();
		$f = new stdClass();

		
		$c->endereco = (strlen($p->endereco) > 0 && strlen($url) > 0) ? $url .= ', '.$p->endereco : $url .= $p->endereco;
		$c->numero   = (strlen($p->numero) > 0) ? $url .= ', '.$p->numero : '';
		//$c->bairro   = (strlen($p->bairro) > 0 && strlen($url) > 0) ? $url .= ', '.$p->bairro : $url .= $p->bairro;
		$c->cidade   = (strlen($p->cidade) > 0 && strlen($url) > 0) ? $url .= ', '.$p->cidade : $url .= $p->cidade;
		$c->estado   = (strlen($p->estado) > 0 && strlen($url) > 0) ? $url .= ', '.$p->estado : $url .= $p->estado;
		//$c->cep      = (strlen($p->cep) > 0 && strlen($url) > 0) ? $url .= ', '.$p->cep : $url .= $p->cep;
		
		//$url="Avenida Doutor Silva Melo, 132, São Paulo, SP, 04675-010";
		$f->url = $this->LimpaEndereco($url);#urlencode(
		$f->output = 'xml';
		
		$localizacao = $this->Coordenadas($f);
		$latitude2  = $localizacao[0];
		$longitude2 = $localizacao[1];	
		
		$this->sql = "SELECT ue.id_empresa, uu.id_usuario, fr.latitude, fr.longitude, fr.distancia, ue.fantasia from vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_franquia_regiao as fr where fr.cep_i='00000-000' and fr.id_empresa=ue.id_empresa and ue.status='Ativo' and ue.id_empresa = uu.id_empresa and uu.departamento_s like '6,%' group by ue.id_empresa";
		$r = $this->fetch();
		foreach($r as $ret){
			#pega as informções da base de dados
			$latitude1  = $ret->latitude;
			$longitude1 = $ret->longitude;
			$distancia1 = $ret->distancia;
			
			#pega as informações da api

			$distancia2 = $this->CalcularRaio($latitude1, $longitude1, $latitude2, $longitude2);
			#echo 'Latitude X Longitude -> Cartório Postal: '.$latitude1.' X '.$longitude1;
			//echo '<br />Latitude X Longitude -> '.$f->url.': '.$latitude2.' X '.$longitude2;
			#echo '<br />Distância é maior que o centro do raio?<br />';
			//echo 'Franquia : '.$ret->fantasia.' Distancia do centro: '.round($distancia1,2).' Distancia do solicitante: '.round($distancia2,2).'<br>';
			echo 'teste';
			if(round($distancia1,2) >= round($distancia2,2)){
				#echo 'Não. A distância é de: '. round($distancia2,2) . ' m<br>';
				return $ret;
			}			
		}
		
	}
	
}
?>