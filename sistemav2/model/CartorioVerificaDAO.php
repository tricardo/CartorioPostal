<?php

class CartorioVerificaDAO extends Database{
	
	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_cartorio';
	}
	
	/**
	 * lista as atribuições de cartórios
	 * @param Cartorio $c
	 */
	public function verificaAtualizacao($c){
		$errors = array();
		if($c->fantasia=="" || $c->nome=="" || $c->cep=="" || 
			$c->endereco=="" || $c->numero=="" || $c->bairro=="" || 
			$c->cidade=="" || $c->estado==""){
				
			$errors['error']="<li><b>Os campos com * são obrigatórios.</b></li>";
			if($c->fantasia=="") $errors['fantasia']=1;
			if($c->nome=="") $errors['nome']=1;
			if($c->cep=="") $errors['cep']=1;
			if($c->endereco=="") $errors['endereco']=1;
			if($c->numero=="") $errors['numero']=1;
			if($c->bairro=="") $errors['bairro']=1;
			if($c->cidade=="") $errors['cidade']=1;
			if($c->estado=="") $errors['estado']=1;
		}
		if($c->email<>""){
			$valida = validaEMAIL($c->email);
			if($valida=='false'){
				$errors['email']=1;
				$errors['error'].="<li><b>E-mail Inválido, digite corretamente.</b></li>";
			}
		}
		if($c->cpf!=""){
			if(validaCNPJ($c->cpf)=='false'){
				$errors['cpf']=1;
				$errors['error'].="<li><b>CNPJ Inválido, digite corretamente.</b></li>";
			}
		}	
		return $errors;
	}
}
?>