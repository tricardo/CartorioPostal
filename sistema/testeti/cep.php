<?
function simple_curl($url, $post = array(), $get = array()){
	$url = explode('?',$url,2);
	if(count($url)===2){
		$temp_get = array();
		parse_str($url[1],$temp_get);
		$get = array_merge($get,$temp_get);
	}
	$ch = curl_init($url[0]."?".http_build_query($get));
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	return curl_exec ($ch);
}

$html = simple_curl('http://www.buscacep.correios.com.br/servicos/dnec/consultaLogradouroAction.do', array(
	'relaxation'=>utf8_decode('rua jose bonifacio'),
	'Metodo'=>'listaLogradouro',
	'TipoConsulta'=>'relaxation',
	'StartRow'=>1,
	'EndRow'=>100
));

print_r($html);
?>
