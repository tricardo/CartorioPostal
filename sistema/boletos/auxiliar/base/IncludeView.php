<?php
class IncludeView{
	
	protected $arquivo;
	protected $controle;
	protected $acao;

        /**
         *
         * @param String $arquivo
         * @param String $controle
         * @param String $acao
         */
	public function __construct($arquivo,$controle,$acao){
		$this->arquivo = $arquivo;
		$this->controle = $controle;
		$this->acao = $acao;
	}	
	
	public function getInclude(){
		return $this->arquivo;
	}
	
	public function getAcao(){
		return $this->acao;
	}
	
	public function getSubmit(){
		return $GLOBALS['urlBase']."/".$this->controle.'/'.$this->acao;
	}
}
?>