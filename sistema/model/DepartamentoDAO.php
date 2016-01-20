<?php
class DepartamentoDAO extends Database{

	public function __construct(){
		$this->table = 'vsites_departamento';
		parent::__construct();
	}

	/**
	 * retorna uma lista com os departamentos com serviços
	 */
	public function listar($ids=null){
		$this->sql = "SELECT * from vsites_departamento as d where id_departamento!=1 ";
		if($ids==null)
			$this->values = array();
		else{
			$i=0;
			$this->sql.=' and ( ';
			foreach($ids as $id){
				if($i>0) $this->sql.=' OR ';
				$this->sql.=' id_departamento =? ';
				$this->values[]=$id;
				$i++;
			}
			 $this->sql.=' ) ';

		}
		$this->sql.=' ORDER BY departamento';
		return $this->fetch();
	}
	
	public function selectPorId($id_departamento){
		$this->sql = "SELECT departamento from vsites_servico_departamento as sd where id_servico_departamento=? order by departamento";
		$this->values = array($id_departamento);
		$ret = $this->fetch();
		return $ret[0];
	}

	public function listarDptoOrdem(){
		$cachediaCLASS = new CacheDiaCLASS();
		$filename = 'DepartamentoDAO-listarDptoOrdem.csv';
		$verifica = $cachediaCLASS->VerificaCache($filename);
		
		if($verifica==false) {
			$this->sql = "SELECT * from vsites_servico_departamento as sd where ordem='Sim' order by departamento";
			$this->values = array();
			$ret = $this->fetch();
			$campos = "id_servico_departamento;departamento";
			$geracsv = $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);		
		} else {
			$ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
		}
		return $ret;	
	}

	public function listarDptoUser($id_empresa){
		if($id_empresa!='1') $onde  = " and franqueadora!='1' "; else $onde = "";		
		$this->sql = "SELECT * from vsites_departamento where id_departamento != '1' ".$onde." order by departamento";
		$this->values = array();
		$ret = $this->fetch();
		
		return $ret;	
	}
	
	#Atualizado 11/05/2011 - Rafael
	public function carregarCombo(){
		$this->sql = "SELECT * FROM vsites_servico_departamento AS sd WHERE ordem='Sim' ORDER BY departamento";
		$this->values = array();
		$ret = $this->fetch();
		return $ret;
	}
}