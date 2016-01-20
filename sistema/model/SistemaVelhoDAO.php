<?php
class SistemaVelhoDAO extends Database{
		
	function uf(){
		$this->sql = "select estado from vsites_user_empresa";
		return $this->fetch();
	}
	
}
