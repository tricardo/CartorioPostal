<?php
class PessoaAcesso extends Acesso {
	/**Valida a a��o de cadastrar uma pessoa*/

	public function cadastrar(){ 
		$usuario = $_SESSION["usuario"];
		if($_GET["valor"]=="funcionario" && !$usuario->funcionarioAdm()){
			throw new AcessoException("Sem permissão para cadastrar funcionário ");
		}
	}

	/**Valida a op��o de inserir no banco uma pessoa
	 */

	public function insere(){
		$this->cadastrar();
	}

	public function atualizar(){
		$idPessoa = $_SESSION["usuario"]->id;
		$idAtz = $_POST["id"];
		$this->estaLogado();
		$usuario = $_SESSION["usuario"];
		if($idPessoa!=$idAtz && !$usuario->funcionarioAdm()){
			throw new AcessoException("Você não tem permissão para atualizar os dados dessa pessoa.");
		}
	}

	public function listar(){
		$usuario = $_SESSION["usuario"];
		if(!$usuario->funcionario)
			throw new AcessoException("Você não tem acesso para exibir esses dados\n");
	}

	public function entrar (){return true;}

	/**
	 * Valida a a��o de mostrar o detalhe do cadastro de uma pessoa.
	 * para vizualizar os dados de uma pessoa, o usu�rio logado, deve ser funcion�rio, administrador, ou ser a pr�pia pessoa
	 *
	 * @return boolean
	 */

	public function detalhe(){
		$this->estaLogado();
		$usuario = $_SESSION['usuario'];
		if($this->id==$usuario->id || $this->id=="" || $usuario->funcionarioAdm())
		   return true;
		throw new AcessoException("Você só tem permissao para visualizar os seus dados\n");

		return true;
	}

        public function ver(){
            $this->detalhe();
        }

	public function busca(){		
		$this->estaLogado();
	}

	public function buscar(){
		$this->busca();
	}
	
	public function buscarEmpresa(){
		$this->busca();
	}
	
	public function email(){
		$this->estaLogado();
	}

	public function enviarEmail(){ $this->estaLogado(); }

        public function novoTel(){}

        public function verificaCPF(){ }

        public function trocarSenha(){ $this->estaLogado(); }
}

s?>
