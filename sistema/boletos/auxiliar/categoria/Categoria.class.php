<?php

class Categoria extends Entity{

	public $id;
	public $nome;
	public $idSupCategoria;
	
	public function __get($param){ return $this->$param; }
	public function __set($param, $valor){ $this->$param = $valor; }

	public function valida($acao){
		$erros = new ExceptionList();
		if($this->nome=="") $erros->addErro("O nome é obrigatório");
		
		if(sizeof($erros->getErros())>0) throw $erros;
	}

	public function __toString(){
		return $this->nome;
	}
	
	
}
?>