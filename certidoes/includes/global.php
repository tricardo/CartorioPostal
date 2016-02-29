<?
function ValidarStr($str){
	$str = str_replace("'", "''", $str);
	$str = str_replace('"', '""', $str);
	$str = str_replace('&lt;', '', $str);
	$str = str_replace('&gt;', '', $str);
	$str = str_replace('<', '', $str);
	$str = str_replace('>', '', $str);
	$str = str_replace('/', '', $str);
	$str = str_replace("\\", '', $str);
	$str = str_replace("%", '', $str);
	return $str;
}
function pt_register(){
	$num_args = func_num_args();
	$vars = array();
	if($num_args >= 2){
		$method = strtoupper(func_get_arg(0));
		if(($method != 'SESSION') && ($method != 'GET') && ($method != 'POST') && ($method != 'SERVER') && ($method != 'COOKIE') && ($method != 'ENV')){
			die('The first argument of pt_register must be one of the following: GET, POST, SESSION, SERVER, COOKIE, or ENV');
		}
		
		$varname = "_{$method}";
		global ${$varname};
		for($i = 1; $i < $num_args; $i++){
			$parameter = func_get_arg($i);
			if(isset(${$varname}[$parameter])){
				global $$parameter;
				$$parameter = str_replace("\'","´",${$varname}[$parameter]);
				$$parameter = str_replace("'","\'",${$varname}[$parameter]);
			}
		}
	}else{
		die('You must specify at least two arguments');
	}
}
?>