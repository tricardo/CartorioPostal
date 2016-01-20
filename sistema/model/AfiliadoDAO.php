<?php
class AfiliadoDAO extends Database{
	
	public function listarTodos(){
		$this->sql = 'SELECT * FROM vsites_afiliado ';
		$this->values = array();
		return $this->fetch();
	}
	
	public function selectPorId($id_afialiado){
		$this->sql = 'SELECT * FROM vsites_afiliado WHERE id_afiliado=?';
		$this->values = array($id_afialiado);
		$ret = $this->fetch();
		return $ret[0];
	}
}
?>