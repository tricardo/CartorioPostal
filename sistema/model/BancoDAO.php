<?php
class BancoDAO extends Database{
	
	public function listar(){
		$this->sql = "SELECT * FROM vsites_banco as b WHERE status='Ativo' ORDER BY banco";
		$this->values = array();
		return $this->fetch();
	}

}

?>