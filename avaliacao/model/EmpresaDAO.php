<?php
class EmpresaDAO extends Database{

	public function listaEmpresaSite($estado,$cidade){
		$this->sql = "SELECT ue.* FROM vsites_user_empresa as ue LEFT JOIN vsites_franquia_regiao as fr ON fr.id_empresa=ue.id_empresa WHERE fr.estado=? AND replace(fr.cidade,' ','')=? AND ue.status='Ativo' OR ue.id_empresa=1 ORDER BY ue.id_empresa desc LIMIT 1";
		$this->values = array($estado,$cidade);
		$ret = $this->fetch();
		return $ret[0];
	}	

	public function listaEmpresa($estado,$cidade){
		$this->sql = "SELECT ue.* FROM vsites_user_empresa as ue LEFT JOIN vsites_franquia_regiao as fr ON fr.id_empresa=ue.id_empresa WHERE fr.estado=? AND fr.cidade=? AND ue.status='Ativo' OR ue.id_empresa=1 ORDER BY ue.id_empresa desc LIMIT 1";
		$this->values = array($estado,$cidade);
		$ret = $this->fetch();
		return $ret[0];
	}	

	public function listaEmpresaCidade($id_empresa){
		$this->sql = "SELECT fr.* FROM vsites_franquia_regiao as fr WHERE fr.id_empresa=? group by fr.estado, fr.cidade ORDER BY fr.estado, fr.cidade";
		$this->values = array($id_empresa);
		return $this->fetch();
	}	

	public function listaEmpresas(){
		$this->sql = "SELECT ue.* FROM vsites_user_empresa as ue WHERE ue.status='Ativo' ORDER BY ue.id_empresa";
		$this->values = array();
		return $this->fetch();
	}	
}

?>