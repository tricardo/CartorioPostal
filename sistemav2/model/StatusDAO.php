<?php
class StatusDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_status';
		$this->maximo=50;
	}

	public function listar(){
		$this->sql = 'SELECT status, id_status from '.$this->table.' where id_status!=2 order by status';
		$this->values = array();
		return $this->fetch();
	}

	public function listarTodos(){
		$cachediaCLASS = new CacheDiaCLASS();
		$filename = 'StatusDAO-listarTodos.csv';
		$verifica = $cachediaCLASS->VerificaCache($filename);
		
		if($verifica==false) {
			$this->sql = 'SELECT status, id_status from '.$this->table.' order by status';
			$this->values = array();
			$ret = $this->fetch();
			$campos = "id_status;status";
			$geracsv = $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);		
		} else {
			$ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
		}
		return $ret;
	}
	
	public function listarDirecionamento(){
		$this->sql = "SELECT status, id_status from ".$this->table." as s where id_status IN ('3','4','6','7','12','13','15') order by status";
		$this->values = array();
		return $this->fetch();
	}
	
	#Atualizado 11/05/2011 - Rafael
	public function carregarCombo(){
		$this->sql = "SELECT DISTINCT status, id_status FROM vsites_status AS s WHERE id_status != '14' AND conv='1' ORDER BY status";
		$this->values = array();
		$ret = $this->fetch();
		return $ret;
	}
}
?>