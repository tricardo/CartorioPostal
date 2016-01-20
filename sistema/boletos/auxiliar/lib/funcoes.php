<?php
/**
 * gera senha aleat�ria, com 5 d�gitos por padr�o
 *
 * @param int $quant
 * @return String
 */
function senhaAleatoria($quant=5){
	$caracteresAceitos = 'abcdxywzABCDZYWZ0123456789';
	$max = strlen($caracteresAceitos)-1;
	$senha = null;
	for($i=0; $i < $quant; $i++) {
		$senha .= $caracteresAceitos{mt_rand(0, $max)};
	}
	return $senha;
}

function is_mobile(){
	$mobile_browser = 0;
//	print_r($_SERVER['HTTP_USER_AGENT']);
	print_r($_SERVER['ALL_HTTP']);
	if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		return true;
	}
	if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or
	((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
		print_r($_SERVER['HTTP_ACCEPT']);
		return true;
	}
	$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
	$mobile_agents = array(
	    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
	    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
	    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
	    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
	    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
	    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
	    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
	    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
	    'wapr','webc','winw','winw','xda','xda-');

	if(in_array($mobile_ua,$mobile_agents)){
		$mobile_browser++;
	}if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0){
		$mobile_browser++;
	}
//	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0)
//		$mobile_browser=0;
	return (bool) $mobile_browser > 0;
}
?>