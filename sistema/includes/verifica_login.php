<?
	$sql = "select email from vsites_user_usuario where email='$email'";
	$result = $objQuery->SQLQuery($sql);
	$num = mysql_num_rows($result);
	if ($num<>'0') {
		$errors = 1; 
		$error .= "<li><b>Esse email j&aacute; est&aacute; cadastrado no sistema</b></li>";
	}
	$sql = "select email from vsites_user_conveniado where email='$email'";
	$result = $objQuery->SQLQuery($sql);
	$num = mysql_num_rows($result);
	if ($num<>'0') {
		$errors = 1; 
		$error .= "<li><b>Esse email j&aacute; est&aacute; cadastrado no sistema</b></li>";
	}

?>
