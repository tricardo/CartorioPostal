<?php
/**
 * classe singleton para conex�o com banco de dados.
 * faz com que seja criada apenas uma conex�o com o banco, permitindo o uso de transa��es, mesmo com classes 'DAO's diferentes
 *
 */
class PDOSingleton {
	private static $carregada;	private static $con;
	private function __construct(){ 		self::$carreada=false;	}

	/**	 * se n�o existe, cria uma conex�o com o bd	 *	 * @param String $urlCon	 * @param String $user	 * @param String $pass	 * @return PDO	 */	public function getInstance($urlCon=null, $user=null, $pass=null){		if (FALSE == self::$carregada) {			if (NULL == self::$con)				self::$con = new PDO($urlCon, $user, $pass);			self::$carregada = TRUE;			return self::$con;		}		return self::$con;	}
}
?>