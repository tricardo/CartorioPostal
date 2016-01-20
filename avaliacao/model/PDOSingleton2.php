<?php
class PDOSingleton2 {
    private static $carregada2;
    private static $con2;

    private function __construct() { self::$carreada2=false; }
    
    public function getInstance($urlCon=null, $user=null, $pass=null) {
        if (FALSE == self::$carregada2) {
	    if (NULL == self::$con2) self::$con2 = new PDO($urlCon, $user, $pass);
	        self::$carregada2 = TRUE;
		return self::$con2;
		}
	return self::$con2;
    }
 }
 ?>
