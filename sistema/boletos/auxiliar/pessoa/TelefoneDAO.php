<?php
class TelefoneDAO extends Database {
	
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * insere v�rios telefones de uma mesma pessoa
	 * 
	 * @param  int $idPessoa
	 * @param Telefone[] $telefones
	 */
	public function inserirTelefones($idPessoa, $telefones){
		$this->sql = "INSERT INTO telefone 
				(idPessoa, ddd, numero, ramal,obs,idTipoTelefone) values ";
		$this->values = array();
		foreach($telefones as $telefone){
			if(count($this->values)>0) $this->sql.=",";
			$primeiro=false;
			$this->values[]=$idPessoa;
			$this->values[]=$telefone->ddd;
			$this->values[]=$telefone->numero;
			$this->values[]=$telefone->ramal;
			$this->values[]=$telefone->obs;
			$this->values[]=$telefone->idTipoTelefone;
			$this->sql.=" (?,?,?,?,?,?)";
		}
		if(count($this->values)>0)
		$this->exec();
	}

	/**
	 * atualiza os telefones passados como par�metro e insere os que n�o foram inseridos
	 *
	 * @param int $idPessoa
	 * @param Telefone[] $telefones
	 */
	public function atualizarTelefones($idPessoa, $telefones){
		$inserir=array();
		foreach($telefones as $telefone){
			if($telefone->id!=null){
				$this->sql = "UPDATE telefone SET ddd=?, numero=?, obs=?, idTipoTelefone=?, ramal=?
								WHERE idPessoa=? AND id=?";
				$this->values=array($telefone->ddd,$telefone->numero,$telefone->obs,$telefone->idTipoTelefone,$telefone->ramal,$idPessoa,$telefone->id);
				$this->exec();
			}else $inserir[]=$telefone;
		}
		if(sizeof($inserir)>0)
		$this->inserirTelefones($idPessoa,$inserir);
	}
	
	public function apagarTelefones($idPessoa, $ids){
		if(count($ids)<1 || $ids[0]==""){
			return;
		}
		$this->sql = "DELETE FROM telefone WHERE idPessoa=? AND id IN(";
		$this->sql .= implode(",",$ids);
		$this->sql.=" )";
		$this->values=array($idPessoa);
		$this->exec();
	}
	
	public function listaPorPessoa($idPessoa){
		$this->sql = "SELECT * FROM telefone WHERE idPessoa=?";
		$this->values =array($idPessoa);
		
		return $this->fetch("Telefone");
	}

	public function listarTipos(){
//		$this->sql = "SELECT * FROM tipotelefone";
//		$this->values = array();
//		return $this->fetch();
		$tipo1->id = 1;
		$tipo2->id = 1;
		
		return array($tipo2,$tipo2);
	}

}
?>