<?php
class PDOSingleton {
	private static $carregada;
	private static $con;

	private function __construct() { self::$carreada=false; }

	public function getInstance($urlCon=null, $user=null, $pass=null) {
		if (FALSE == self::$carregada) {
			if (NULL == self::$con) self::$con = new PDO($urlCon, $user, $pass);
			self::$carregada = TRUE;
			return self::$con;
		}
		return self::$con;
	}
}
?>
