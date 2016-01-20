<?php
class RegimeDAO extends Database{
	
	
	public function listar(){
		$this->sql = 'SELECT * FROM vsites_fin_regime';
		$this->values = array();
		return $this->fetch();
	}
	
	public function buscaPorID($id){
		$this->sql = 'SELECT * FROM vsites_fin_regime as r where id_regime=? limit 1';
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}	
	
}