<?php
/**
 * profissoes
 * 
 */
class Profissao{

	public $id;
	public $descricao;
	public $dtProfissional;

	public function __get($atr){ 
		return $this->$atr; 
	}
	public function __set($atr, $var){ $this->$atr = $var; }
	
	public function __toString(){
		return $this->descricao;
	}
	
	public function valida(){
		if($this->profissao==""){
			$errors = new FormException();
			$errors->addError("O nome é obrigatório");
			throw $errors;
		}
	}
}

?>
