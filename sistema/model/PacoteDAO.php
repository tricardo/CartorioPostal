<?php
class PacoteDAO extends Database{


	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_pacotes';
	}

	/**
	 * lista todos os pacotes ativos
	 */
	public function listar(){
		$this->sql = "SELECT * from vsites_pacotes as p where status='Ativo' order by pacote";
		$this->values = array();
		return $this->fetch();
	}
}

?>