<?php
class RoyaltieFixoDAO extends Database {

	public function listar_franquia($id_empresa){
		$this->sql = "SELECT * FROM vsites_royaltie_fixo WHERE id_empresa = ?";
        $this->values = array($id_empresa);		
        return $this->fetch();
	}
	
	public function atualizar($c){
		$this->sql = "SELECT * FROM vsites_user_empresa WHERE id_empresa = ?";
        $this->values = array($c->id_empresa);
        $dt = $this->fetch();
		
		$valor = array();
		$SQL = "UPDATE vsites_royaltie_fixo SET ";
		for($i = 1; $i <= $c->total_mes; $i++){
			$SQL .= "mes_".$i."=?," ;
			$mes = 'mes_'.$i;
			$valor[] = $c->$mes;
		}
		$SQL .= "semestre=? WHERE id_empresa=?";
		$semestre = 0;
		if(count($dt) > 0){
			$semestre = (($dt[0]->sem1+$dt[0]->sem2+$dt[0]->sem3) > 0) ? 1 : 0;
		}
		$valor[] = $semestre;
		$valor[] = $c->id_empresa;
		$this->sql = $SQL;
		$this->values = $valor;
		$this->exec();
	}
	
	public function inserir($c){
		$this->sql = "SELECT * FROM vsites_user_empresa WHERE id_empresa = ?";
        $this->values = array($c->id_empresa);
        $dt = $this->fetch();
		
		$valor = array();
		$SQL = "INSERT INTO vsites_royaltie_fixo (";
		for($i = 1; $i <= $c->total_mes; $i++){
			$SQL .= "mes_".$i."," ;
			$mes = 'mes_'.$i;
			$valor[] = $c->$mes;
		}
		$SQL .= "id_empresa,semestre) VALUES (";
		for($i = 1; $i <= $c->total_mes; $i++){ $SQL .= "?,"; }
		$SQL .= "?,?)";
		$semestre = 0;
		if(count($dt) > 0){
			$semestre = (($dt[0]->sem1+$dt[0]->sem2+$dt[0]->sem3) > 0) ? 1 : 0;
		}
		$valor[] = $c->id_empresa;
		$valor[] = $semestre;
		$this->sql = $SQL;
		$this->values = $valor;
		$this->exec();
	}

}
?>