<?php
class FichaDAO extends Database{
	public function site_ficha_cadastro($c){
		$ret = array();
		switch($c->acao){
			case 1:
				$whr = ' AND c.id_status<>18 AND c.id_usuario>0';
				if($c->consultor){ $whr .= ' AND c.id_usuario='.$c->consultor; }
				if($c->id_status){ if($c->id_status > 0){ $whr .= ' AND c.id_status='.$c->id_status; }}
				if(strlen($c->nome) > 0){ $whr .= " AND c.nome LIKE '".$c->nome."%' ";  }
				if(strlen($c->uf) > 0){ $whr .= " AND c.estado_interesse = '".$c->uf."'"; }
				if(strlen($c->cidade) > 0){ $whr .= " AND c.cidade_interesse = '".$c->cidade."'"; }
				if($c->mes > 0){ $whr .= " AND MONTH(c.data) = '".$c->mes."'"; }
				if($c->ano > 0){ $whr .= " AND YEAR(c.data) = '".$c->ano."'"; }
				if($c->id_usuario != 1){ $whr .= ' AND c.id_status<>20'; }
				
				$this->sql = "SELECT c.id_ficha, c.nome, c.email, c.tel_res, c.estado_interesse, c.cidade_interesse, c.data, s.status,
					c.id_usuario FROM site_ficha_cadastro AS c
					INNER JOIN site_ficha_cadastro_status AS s ON c.id_status = s.id_status
					WHERE 1=1 ".$whr." ORDER BY c.id_ficha DESC LIMIT ". $c->lim1.','.$c->lim2;
				$ret[1] = $this->fetch();
				
				$this->sql = "SELECT count(c.id_ficha) AS Total FROM site_ficha_cadastro AS c
					INNER JOIN site_ficha_cadastro_status AS s ON c.id_status = s.id_status
					WHERE 1=1 ".$whr;
				$ret[0] = $this->fetch();
				
				return $ret;
			break;
			default:
				$this->sql = "SELECT c.id_ficha, c.nome, c.email, c.tel_res, c.estado_interesse, c.cidade_interesse, c.data, s.status,
					c.id_usuario FROM site_ficha_cadastro AS c
					INNER JOIN site_ficha_cadastro_status AS s ON c.id_status = s.id_status
					WHERE c.id_status<>18 AND c.id_usuario=0 ".$whr." ORDER BY c.id_ficha DESC";
				$ret[1] = $this->fetch();
				
				$this->sql = "SELECT count(c.id_ficha) AS Total FROM site_ficha_cadastro AS c
					INNER JOIN site_ficha_cadastro_status AS s ON c.id_status = s.id_status
					WHERE c.id_status<>18 AND c.id_usuario=0 ".$whr;
				$ret[0] = $this->fetch();
				
				return $ret;
		}
	}
	
	public function direcionaUsuario($id_ficha, $id_usuario){
		$this->sql= "UPDATE site_ficha_cadastro SET id_usuario=? WHERE id_ficha =?";	
		$this->values = array($id_usuario, $id_ficha);
		$this->exec();
	}
	
	public function ListarUF($c){
		if($c->consultor){ $whr .= ' AND c.id_usuario='.$c->consultor; }
		$this->sql = "SELECT c.estado_interesse 
			FROM site_ficha_cadastro AS c 
			WHERE length(c.estado_interesse) > 0 ". $whr ."
			GROUP BY c.estado_interesse
			ORDER BY c.estado_interesse";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret;
	}
	
	public function ListarCidade($c){
		if($c->consultor){ $whr .= ' AND c.id_usuario='.$c->consultor; }
		$this->sql = "SELECT c.cidade_interesse
		FROM site_ficha_cadastro AS c
		WHERE length( c.cidade_interesse ) >0 ".$whr."
		GROUP BY c.cidade_interesse
		ORDER BY c.cidade_interesse";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret;
	}
	
	public function buscaIDFicha($id){
		$this->sql = "SELECT c.id_ficha, c.id_usuario FROM site_ficha_cadastro AS c WHERE c.id_ficha=?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function ListarAno($c){
		if($c->consultor){ $whr .= ' AND c.id_usuario='.$c->consultor; }
		$this->sql = "SELECT YEAR(c.data) AS data
		FROM site_ficha_cadastro AS c
		WHERE length( c.data ) >0 ".$whr." AND c.id_status<>18 AND c.id_usuario>0
		GROUP BY YEAR(c.data)
		ORDER BY c.data";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret;
	}
	public function listaOperadora(){
		$this->sql = "SELECT * FROM site_operadora as op ORDER BY op.id_operadora";
		$this->values = array();
		return $this->fetch();
	}
}
?>