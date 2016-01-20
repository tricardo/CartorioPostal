<?php
class Servico extends Entity{
	
	protected $id_departamento;
	protected $status;
	protected $site;
	protected $descricao;
	protected $campos;
	
	public function __construct(){
		$this->campos = array();
	}
	
	public function __toString(){ return $this->descricao; }
	
	public function __get($atr){ return $this->$atr; }
	public function __set($atr,$var){ return $this->$atr=$var; }
	
	public function addCampo($campo){ $this->campos[]=$campo; }
//	public function getId_departamento(){ return $this->id_departamento; }
//	public function getStatus(){ return $this->status; }
//	public function getSite(){ return $this->site; }
//	public function getDescricao(){ return $this->descricao; }
//	public function getCampos(){ return $this->campos; }
//	
//	public function setId_departamento($id_departamento){ $this->id_departamento = $id_departamento; }
//	public function setStatus($status){ $this->status=$status; }
//	public function setSite($site){ $this->site=$site; }
//	public function setDescricao($descricao){$this->descricao=$descricao; }
//	public function setCampos($campos){ $this->campos=$campos; }
}
?>