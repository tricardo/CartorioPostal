<?php
class Telefone extends Entity {
	protected $id;	protected $ddd;	protected $numero;	protected $ramal;	protected $idTipoTelefone;	protected $obs;
	/**	 * get padr�o	 * @param string $attribute	 * @return unknown	 */	public function __get($atributo){		return $this->$atributo;	}
	/**	* set padr�o	*	* @param string $attribute	* @param unknown_type $value	*/	public function __set($atributo, $valor){		$this->$atributo = $valor;	}	public function getFormatNumero(){		return ereg_replace('^([0-9]{4})([0-9]{4})','\1-\2',$this->numero);	}
	public function valida($n=0){		$erros = new FormException();		$num = ($n!=0)?"do ".$n."� tel":"";		if($this->ddd=="")		$erros->addError("O DDD ".$num." n�o foi preenchido");		if($this->numero=="")		$erros->addError("O n� $num n�o foi preenchido");		if($this->idTipoTelefone=="")		$erros->addError("O tipo $num n�o foi preenchido");		if(sizeof($erros->getErrors())>0)		throw $erros;	}
}
?>