<?php
class ImpressoDAO extends Database{
	
	
	public function buscaPorId($id_impresso){
		$this->sql = "SELECT * from vsites_impresso as i where id_impresso=?";
		$this->values = array($id_impresso);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function buscaPorTipoImpresso($tipo_impresso){
		$this->sql = "SELECT * from vsites_impresso as i where tipo_impresso=?";
		$this->values = array($tipo_impresso);
		$ret  = $this->fetch();
		return $ret[0];
	}

	public function buscaPorDpto($dpto){
		$this->sql = "SELECT * from vsites_impresso as i where departamento = ? order by tipo_impresso";
		$this->values = array($dpto);
		return $this->fetch();
	}
}

?>