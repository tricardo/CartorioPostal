<?php
/**
 * classe de controle de fluxo
 * as requisições feitas devem chamar as classes dessa hierarquia e executar um de seus métodos
 * por um arquivo .htacces as requisições são tratadas, e um valor requisicao define a classe a ser instanciada
 * padrão: url http://base/<requisicao>/<acao>
 * padrão: valor 'acao' é o método executado na classe
 * os métodos devem receber e tratar os valores enviados via GET e/ou POST
 * as requisições são enviadas para os arquivos no diretório /requisicoes que devem instanciar as classes em controle
 * 
 * @author Caio M Nardi
 * @since 28/10/2008
 * 
 * @abstract 
 */
abstract class Control{

	public function __construct(){ }
	
	/**
	 * validação de requisições, caso o método não tenha sido implementado
	 *
	 * @param String $metodo
	 * @param Array $arg2
	 */
	public function __call($metodo, $arg2){
		throw new ExceptionList("Essa ação '$metodo' não foi implementada!");
	}

        public function redir($modulo,$ac,$valores=array(),$msg=''){
            include('../base/variaveis.php');
            header('Location: '.$urlBase.'/'.$modulo.'/'.$ac.'/'.$valores['valor']);
        }
}
?>