<?php
class TransmissaoDAO extends Database{
	public function __construct(){
		$this->table = "transmissao";
		parent::__construct();
	}

	/**
	 *lista todos os transmissaoes cadastrados
	 *
	 * @return Transmissao[]
	 */

	public function listar(){
		$this->sql = "SELECT * FROM transmissao ORDER BY descricao";
		$this->values =	array();
		$this->fields = array();
		return parent::fetch();
	}
}
?>
