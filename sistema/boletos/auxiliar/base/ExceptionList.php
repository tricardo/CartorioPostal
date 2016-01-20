<?php
/**
 * classe de controle de Exceptions para n�o enviar apenas um erro
 * tem um array com mensagens de erro
 *
 */
class ExceptionList extends Exception{
	
	private $erros;
	
	/**
	 * define a mensagem, chama o construtor de parent e coloca a mensagem no array
	 *
	 * @param String $firstMessage
	 */
	public function __construct($firstMessage=null){
		$this->errors=array();
		parent::__construct($firstMessage);
		if($firstMessage!=null)
		$this->addErro($firstMessage);
	}

	/**
	 * adiciona um erro no array
	 *
	 * @param String $erro
	 */
	public function addErro($erro){
		$this->erros[]=$erro;
		$this->message =$erro;
	}

	/**
	 * retorna o array de erros
	 *
	 * @return String[]
	 */
	public function getErros(){
		return $this->erros;
	}

}
?>