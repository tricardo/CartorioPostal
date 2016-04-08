<?php
class CompraDAO extends Database{

	public function inserir($c){
		$this->table = 'vsites_fin_compra';
		$this->fields = array(
			'id_empresa',
			'id_departamento',
			'id_usuario',
			'produto',
			'descricao',
			'quantidade',
			'motivo',
			'observacao',
			'data',
			'status'
			);
			$this->values = array(
			'id_empresa'=>$c->id_empresa,
			'id_departamento'=>$c->id_departamento,
			'id_usuario'=>$c->id_usuario,
			'produto'=>$c->produto,
			'descricao'=>$c->descricao,
			'quantidade'=>$c->quantidade,
			'motivo'=>$c->motivo,
			'observacao'=>$c->observacao,
			'data'=>date("Y-m-d H:i:s"),
			'status'=>$c->status
			);

			$this->insert();
	}

	public function busca($busca,$id_empresa,$pagina){
		$this->values = array();
		$where = " WHERE c.id_empresa=? ";
		$this->values[]=$id_empresa;
		if($busca->busca<>""){
			$where .= " AND (produto like ? or descricao like ? or motivo like ? ) ";
			$this->values[]="$busca->busca%";
			$this->values[]="$busca->busca%";
			$this->values[]="$busca->busca%";
		}
		if($busca->id_departamento!=""){
			$where .= " AND c.id_departamento = ?";
			$this->values[]=$busca->id_departamento;
		}
		if($busca->status!=''){
			$where .= " AND c.status = ?";
			$this->values[]=$busca->status;
		}

		$this->sql = "SELECT count(0) as total FROM vsites_fin_compra c
		INNER JOIN vsites_user_usuario u ON u.id_usuario =  c.id_usuario 
		INNER JOIN vsites_departamento d ON d.id_departamento = c.id_departamento ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$this->link = 'busca='.$busca->busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT c.*,d.departamento,u.nome as solicitante FROM vsites_fin_compra c
		INNER JOIN vsites_user_usuario u ON u.id_usuario = c.id_usuario 
		INNER JOIN vsites_departamento d ON d.id_departamento = c.id_departamento ".$where." ORDER BY c.data"
		." LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}

	public function buscaPorId($id,$id_empresa){
		$this->sql = "SELECT c.*,d.departamento,u.nome as solicitante FROM vsites_fin_compra c
		INNER JOIN vsites_user_usuario u ON u.id_usuario =  c.id_usuario 
		INNER JOIN vsites_departamento d ON d.id_departamento = c.id_departamento WHERE c.id_compra = ? and c.id_empresa=?";
		$this->values = array($id,$id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function atualizaStatus($c, $status, $id_empresa=null){
		if($status=='Reprovada'){
                    $this->sql = 'SELECT COUNT(0) as total, dt_vencimento FROM vsites_fin_pagamento as p WHERE id_compra = ? and id_empresa=?';
                    $this->values = array($c->id_compra,$id_empresa);
                    $ret = $this->fetch();
                    $pag = $ret[0];
                    if(strtotime($pag->dt_vencimento) < strtotime("-15 day") and $pag->total!=0){
                            throw new Exception("O pagamento já está cadastrado há mais de 15 dias");
                    }else{
                            $this->sql = 'DELETE FROM vsites_fin_parcela WHERE id_pagamento=? and id_empresa=?';
                            $this->values = array($pag->id_pagamento,$id_empresa);
                            $this->exec();
                            $this->sql = 'DELETE FROM vsites_fin_pagamento WHERE id_pagamento=? and id_empresa=?';
                            $this->exec();
                    }
		}
		
		$this->sql = 'UPDATE vsites_fin_compra SET status=? WHERE id_compra = ?';
		$this->values = array($status,$c->id_compra);
		if($id_empresa!=null){			
			$this->sql.=' and id_empresa=?';
			$this->values[] = $id_empresa;
		}
		$this->exec();
	}
}