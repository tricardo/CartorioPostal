<?php
/**
 * marcas de veículos
 * 
 */
class Endereco{

	private $idPessoa;
	private $tipo;
	
	private $endereco;
	private $complemento;
	private $numero;
	private $cep;
	private $bairro;
	private $cidade;
	private $UF;
	

	public function __get($atr){ return $this->$atr; }
	public function __set($atr, $var){ $this->$atr = $var; }

	public function __toString(){
		return $this->nome;
	}

}

?>