<?php
class PessoaJuridicaDAO extends PessoaDAO {


	public function __construct(){
		$this->table = "pessoajuridica";
		parent::__construct();
	}

	public function inserir(PessoaJuridica $pessoa){
//		echo "come�ando com P.Jur\n";
		$this->beginTrans();
		try{
			$pessoa->id = parent::inserirPessoa($pessoa);
			$this->table="pessoajuridica";
			
			$this->values = $pessoa->getValores();
			$this->fields = array_keys($pessoa->getValores());
				
			parent::insert();
		}catch(FormException $erro){
			$this->rollBack();
			throw $erro;
		}
		$this->commit();
		return $pessoa->id;
	}
	
	public function selectById($id){
		$this->values[] = $id;
		$this->sql="SELECT *
			 FROM pessoa p
			 INNER JOIN pessoajuridica pj ON pj.idPessoa=p.id
			 INNER JOIN relacao r ON r.idPessoa = p.id
			 WHERE id = ?";

		$pessoa = $this->fetch("PessoaJuridica");
		return $pessoa[0];
	}
	
	public function buscaCliente($id){
		$this->values=array($id);
		$this->sql="SELECT c.idPessoa, p.usuario FROM pessoajuridica pj
						INNER JOIN relacao c ON pj.idPessoa=c.idPessoa
						INNER JOIN pessoa p ON p.id=c.idPessoa
						WHERE c.idPessoa=?
						AND c.cliente = 1";
		return $this->fetch("PessoaJuridica");
	}
	
	public function valida(PessoaJuridica $pessoa,$acao){
		try{
			parent::valida($pessoa,$acao);
			$erros = new FormException();
		}catch(FormException $erros){ }
	
                $this->sql = "SELECT count(0) as num FROM pessoajuridica WHERE cnpj = ? ";
                $this->values=array();
                $this->values[]=$pessoa->cnpj;
                $result = $this->fetch();

                if($result[0]->num>0) $erros->addError("CNPJ já foi cadastrado");

		if(count($erros->getErrors())>0){
			throw $erros;
		}
	}
}
?>