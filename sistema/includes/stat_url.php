<?
	$stat_urlanterior = $_SERVER['HTTP_REFERER'];
	$stat_urloficial  = 'alphatem.com.br';
	$stat_urlatual    = $_SESSION['stat_urlatual'];
	$pos 		  = strpos($stat_urlanterior, $stat_urloficial);
	$stat_data	  = date('d-m-y g:i a');
	$stat_ip	  = getenv("REMOTE_ADDR");
	if($pos=='' and $stat_urlanterior<>''){
		$_SESSION['stat_urlatual']=$stat_urlanterior;
		$_SESSION['stat_ip']=$stat_ip;
		$_SESSION['stat_data']=$stat_data;
	}
?>