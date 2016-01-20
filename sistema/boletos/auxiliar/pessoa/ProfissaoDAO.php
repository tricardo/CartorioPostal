<?php
class ProfissaoDAO extends Database{
	
	public function __construct(){
		$this->table = "profissao";
		parent::__construct();
	}
	
	
	/**
	 *lista todas as profissoes cadastradas
	 *
	 * @return Profissoes[]
	 */
	public function listar(){
		$this->sql = "SELECT * FROM profissao ORDER BY descricao";
		$this->values =	array();
		$this->fields = array();
		return parent::fetch("Profissao");
	}
	
	
	/**
	 *lista todas as profissoes cadastradas
	 *
	 * @return Profissoes[]
	 */
	public function inserir(Profissao $profissao){
		$this->sql = "INSERT INTO profissao (profissao, dtProfissional) VALUES (?,?)";
		$this->values =	array($profissao->profissao,$profissao->dtProfissao);
		$this->exec();
	}
}
?>
