<?
class MyBrowser{

	var $Name = "Unknown";
	var $Version = "Unknown";
	var $Platform = "Unknown";
	var $UserAgent = "Not reported";
	var $AOL = false;

	function browser( $selecao ){
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$bd['platform'] = "Unknown";
		$bd['browser'] = "Unknown";
		$bd['version'] = "Unknown";
		$this->UserAgent = $agent;


		if(eregi("win", $agent))
			$bd['platform'] = "Windows";
			elseif (eregi("mac", $agent))
				$bd['platform'] = "MacIntosh";
			elseif (eregi("linux", $agent))
				$bd['platform'] = "Linux";
			elseif (eregi("OS/2", $agent))
				$bd['platform'] = "OS/2";
			elseif (eregi("BeOS", $agent))
				$bd['platform'] = "BeOS";

			if (eregi("opera",$agent)){
				$val = stristr($agent, "opera");

				if (eregi("/", $val)){
					$val = explode("/",$val);
					$bd['browser'] = $val[0];
					$val = explode(" ",$val[1]);
					$bd['version'] = $val[0];
				}else{
					$val = explode(" ",stristr($val,"opera"));
					$bd['browser'] = $val[0];
					$bd['version'] = $val[1];
					}

			}elseif(eregi("webtv",$agent)){
				$val = explode("/",stristr($agent,"webtv"));
				$bd['browser'] = $val[0];
				$bd['version'] = $val[1];
        

			}elseif(eregi("microsoft internet explorer", $agent)){
				$bd['browser'] = "MSIE";
				$bd['version'] = "1.0";
				$var = stristr($agent, "/");

					if (ereg("308|425|426|474|0b1", $var)){
						$bd['version'] = "1.5";
					}

			}elseif(eregi("NetPositive", $agent)){
				$val = explode("/",stristr($agent,"NetPositive"));
				$bd['platform'] = "BeOS";
				$bd['browser'] = $val[0];
				$bd['version'] = $val[1];

			}elseif(eregi("msie",$agent) && !eregi("opera",$agent)){
				$val = explode(" ",stristr($agent,"msie"));
				$bd['browser'] = $val[0];
				$bd['version'] = $val[1];

			}elseif(eregi("mspie",$agent) || eregi('pocket', $agent)){
				$val = explode(" ",stristr($agent,"mspie"));
				$bd['browser'] = "MSPIE";
				$bd['platform'] = "WindowsCE";

				if (eregi("mspie", $agent))
				$bd['version'] = $val[1];
				else {
					$val = explode("/",$agent);
					$bd['version'] = $val[1];
				}

			}elseif(eregi("galeon",$agent)){
				$val = explode(" ",stristr($agent,"galeon"));
				$val = explode("/",$val[0]);
				$bd['browser'] = $val[0];
				$bd['version'] = $val[1];

			}elseif(eregi("Konqueror",$agent)){
				$val = explode(" ",stristr($agent,"Konqueror"));
				$val = explode("/",$val[0]);
				$bd['browser'] = $val[0];
				$bd['version'] = $val[1];

			}elseif(eregi("icab",$agent)){
				$val = explode(" ",stristr($agent,"icab"));
				$bd['browser'] = $val[0];
				$bd['version'] = $val[1];

			}elseif(eregi("omniweb",$agent)){
				$val = explode("/",stristr($agent,"omniweb"));
				$bd['browser'] = $val[0];
				$bd['version'] = $val[1];

			}elseif(eregi("Phoenix", $agent)){
				$bd['browser'] = "Phoenix";
				$val = explode("/", stristr($agent,"Phoenix/"));
				$bd['version'] = $val[1];

			}elseif(eregi("firebird", $agent)){
				$bd['browser']="Firebird";
				$val = stristr($agent, "Firebird");
				$val = explode("/",$val);
				$bd['version'] = $val[1];

			}elseif(eregi("Firefox", $agent)){
				$bd['browser']="Firefox";
				$val = stristr($agent, "Firefox");
				$val = explode("/",$val);
				$bd['version'] = $val[1];

			}elseif(eregi("mozilla",$agent) && 
				eregi("rv:[0-9].[0-9][a-b]",$agent) && !eregi("netscape",$agent)){
				$bd['browser'] = "Mozilla";
				$val = explode(" ",stristr($agent,"rv:"));
				eregi("rv:[0-9].[0-9][a-b]",$agent,$val);
				$bd['version'] = str_replace("rv:","",$val[0]);

			}elseif(eregi("mozilla",$agent) &&
				eregi("rv:[0-9]\.[0-9]",$agent) && !eregi("netscape",$agent)){
				$bd['browser'] = "Mozilla";
				$val = explode(" ",stristr($agent,"rv:"));
				eregi("rv:[0-9]\.[0-9]\.[0-9]",$agent,$val);
				$bd['version'] = str_replace("rv:","",$val[0]);

			}elseif(eregi("libwww", $agent)){

				if(eregi("amaya", $agent)){
					$val = explode("/",stristr($agent,"amaya"));
					$bd['browser'] = "Amaya";
					$val = explode(" ", $val[1]);
					$bd['version'] = $val[0];
				}else{
					$val = explode("/",$agent);
					$bd['browser'] = "Lynx";
					$bd['version'] = $val[1];
				}

			}elseif(eregi("safari", $agent)){
				$bd['browser'] = "Safari";
				$bd['version'] = "";

			}elseif(eregi("netscape",$agent)){
				$val = explode(" ",stristr($agent,"netscape"));
				$val = explode("/",$val[0]);
				$bd['browser'] = $val[0];
				$bd['version'] = $val[1];

			}elseif(eregi("mozilla",$agent) && !eregi("rv:[0-9]\.[0-9]\.[0-9]",$agent)){
				$val = explode(" ",stristr($agent,"mozilla"));
				$val = explode("/",$val[0]);
				$bd['browser'] = "Netscape";
				$bd['version'] = $val[1];
			}

		$bd['browser'] = ereg_replace("[^a-z,A-Z]", "", $bd['browser']);
		$bd['version'] = ereg_replace("[^0-9,.,a-z,A-Z]", "", $bd['version']);

		if(eregi("AOL", $agent)){
			$var = stristr($agent, "AOL");
			$var = explode(" ", $var);
			$bd['aol'] = ereg_replace("[^0-9,.,a-z,A-Z]", "", $var[1]);
		}

		$this->Name = $bd['browser'];
		$this->Version = $bd['version'];
		$this->Platform = $bd['platform'];
		$this->AOL = $bd['aol'];
		return $bd[$selecao];
	}
}
?>