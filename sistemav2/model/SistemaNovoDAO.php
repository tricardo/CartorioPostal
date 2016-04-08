<?php
class SistemaNovoDAO extends DatabaseNovo{
		
	function uf(){
		$this->sql = "select ue.id_empresa, ue.id_estado, e.cidade from v_empresa as ue inner join vsites_user_empresa as e on e.id_empresa = ue.id_empresa";
		return $this->fetch();
	}
	
	function cidade($id, $str){
		$this->sql = "select id_cidade from v_sis_cidade where id_estado = ".$id." and trim(cidade) like'%".trim($str)."%'";
		return $this->fetch();
	}
	
	function emp_cidade($id1, $id2){
		$this->sql = "update v_empresa SET id_cidade = ? where id_empresa = ?";
		$this->values = array($id2, $id1);
		$this->exec();
	}

}
