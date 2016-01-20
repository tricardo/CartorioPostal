<?php

class ServicoDepartamentoDAO extends Database{
	
	public function __construct(){
		$this->table = 'vsites_servico_departamento';
		parent::__construct();
	}
	
	
	/**
	 * retorna uma lista com os departamentos com serviços
	 */
	public function listar(){
		$this->sql = "SELECT * from vsites_servico_departamento as sd where ordem='Sim' order by departamento";
		$this->values = array();
		return $this->fetch();
	}

	/**
	 * retorna uma lista com os departamentos com operacoes
	 */
	public function listarDptoMsg(){
		$this->sql = "SELECT * from vsites_servico_departamento as sd order by departamento";
		$this->values = array();
		return $this->fetch();
	}
	
	/**
	 * verifica se o servico é valido
	 */
	public function listaPorId($id_servico_departamento){
		$this->sql = "SELECT departamento FROM vsites_servico_departamento as sd WHERE sd.id_servico_departamento=? ";
		$this->values = array($id_servico_departamento);
		$cont = $this->fetch();
		return $cont[0];
	}
	
}

?>