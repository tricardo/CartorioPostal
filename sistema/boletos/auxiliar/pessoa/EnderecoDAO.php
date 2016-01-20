<?php
class EnderecoDAO extends Database {
	
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * insere v�rios endereços de uma mesma pessoa
	 * 
	 * @param  int $idPessoa
	 * @param Endereco[] $enderecos
	 */
	public function inserirEnderecos($idPessoa, $enderecos){
		
		$this->sql = "INSERT INTO endereco 
				(idPessoa, tipo, endereco, numero, compl,cep,bairro,cidade,uf ) values ";
		$this->sql.=" (?,?,?,?,?,?,?,?,?) ";
		
		foreach($enderecos as $e){		
			$this->values = array();
			$this->values[]=$idPessoa;
			$this->values[]=$e->tipo;
			$this->values[]=$e->endereco;
			$this->values[]=$e->numero;
			$this->values[]=$e->compl;
			$this->values[]=$e->cep;
			$this->values[]=$e->bairro;
			$this->values[]=$e->cidade;
			$this->values[]=$e->uf;
			$this->exec();
		}
	}

	/**
	 * atualiza os enderecos passados como par�metro e insere os que n�o foram inseridos
	 *
	 * @param int $idPessoa
	 * @param Endereco[] $telefones
	 */
	public function atualizarEnderecos($idPessoa, $enderecos){
		$inserir=array();
		foreach($enderecos as $e){
			
			$e->idPessoa=$idPessoa;
			if(count($this->busca($e))>0){
				$this->sql = "UPDATE endereco SET endereco=?, numero=?, compl=?, cep=?, bairro=?,cidade=?,uf=?
								WHERE idPessoa=? AND tipo=?";
				$this->values=array($e->endereco,$e->numero,$e->compl,$e->cep,$e->bairro,$e->cidade,$e->uf,$idPessoa,$e->tipo);
				$this->exec();
			}else $inserir[]=$e;
		}
		if(sizeof($inserir)>0)
		$this->inserirEnderecos($idPessoa,$inserir);
	}
	
	public function listaPorPessoa($idPessoa){
		$this->sql = "SELECT * FROM endereco WHERE idPessoa=?";
		$this->values =array($idPessoa);
		$enderecos = $this->fetch("Endereco");
		foreach($enderecos as $e)
		$enderecos_r[$e->tipo]=$e;
		return $enderecos_r;
	}

	public function busca(Endereco $e){
		$this->sql = "SELECT idPessoa,tipo FROM endereco WHERE idPessoa=? and tipo = ? ";
		$this->values = array($e->idPessoa,$e->tipo);
		return $this->fetch("Endereco");
	}
}
?>