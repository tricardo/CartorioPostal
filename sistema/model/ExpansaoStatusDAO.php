<?php
class ExpansaoStatusDAO extends Database{
	//Status
	public function listaStatus(){
		$this->sql = "SELECT id_status,
		status FROM site_ficha_cadastro_status
		WHERE ativo =1
		ORDER BY status";
		$this->values = array();
		return $this->fetch();
	}
	
	public function buscaStatus($id){
		$this->sql = "SELECT * FROM site_ficha_cadastro_status WHERE id_status =?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function buscaRelStatus($id){
		$this->sql = "
					SELECT s.id_status, s.status
					FROM site_ficha_cadastro_rel_status AS r
					INNER JOIN site_ficha_cadastro_status AS s ON r.id_status_rel = s.id_status
					WHERE r.id_status =? ORDER BY s.status
		";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret;
	}
	
	public function insereHistorico($lista){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_historico (
					id_ficha, id_user_alt, id_status, data_reuniao, data_inclusao, observacao
					)
					VALUES (?, ?, ?, ?, ?, ?)
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}	
	
	public function buscaHistorico($id){
		$this->sql = "
					SELECT s.id_status, s.status, h.data_reuniao, h.data_inclusao, h.id_user_alt, h.observacao
					FROM site_ficha_cadastro_historico AS h
					INNER JOIN site_ficha_cadastro_status AS s
					ON h.id_status = s.id_status
					WHERE id_ficha =?
					ORDER BY data_inclusao DESC
		";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret;
	}
}
?>