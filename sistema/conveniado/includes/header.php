<?= '<?xml version="1.0" encoding="iso-8859-1"?>' . " \n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistecart</title>
<? $useragent = $_SERVER['HTTP_USER_AGENT'];
 
if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'IE';
} elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Opera';
} elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Firefox';
} elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Chrome';
} elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Safari';
} else {
    // browser not recognized!
    $browser_version = 0;
    $browser= 'other';
}

echo '<link rel="stylesheet" href="css/style.css" type="text/css" />' . "\n";
if($browser == "IE"){
    //echo '<link rel="stylesheet" href="css/style.css" type="text/css" />' . "\n";
} else { 
	//echo '<link rel="stylesheet" href="css/style_ie.css" type="text/css" />' . "\n";
}?>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript" language="javascript"></script>
<script src="js/maskedinput.js" type="text/javascript"></script>
<script	src="js/js.js" language="javascript" type="text/javascript"></script>
</head>
<body onload="CarregaPagina('<?=$pagina?>');">