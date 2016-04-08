<?php

class EmpresaMensagemDAO extends Database{

	public function __construct(){
		$this->table = 'vsites_empresa_mensagem';
		parent::__construct();
		$this->maximo=50;
	}

	/**
	 * insere uma mensagem para uma empresa
	 */
	public function inserir($m){
		$this->fields = array('id_empresa','id_usuario','mensagem','data','anexo');
		$this->values = array('id_empresa'=>$m->id_empresa,
								'id_usuario'=>$m->id_usuario,
								'mensagem'=>$m->mensagem,
								'anexo'=>$m->anexo,
								'data'=>date('Y-m-d H:i:s'));
		return $this->insert();
	}

	public function listar($id_empresa, $busca="", $pagina=1){
		$this->sql = "SELECT count(0) as total
					FROM vsites_empresa_mensagem m 
					INNER JOIN vsites_user_empresa emp ON m.id_empresa=emp.id_empresa
					INNER JOIN vsites_user_usuario u ON m.id_usuario = u.id_usuario 
					WHERE m.id_empresa = ? ";
		$this->values = array($id_empresa);
		if($busca!=""){
			$this->sql.="(emp.nome like ? or emp.email like ? or emp.empresa like ?)";
			$this->values[] = "%$busca%";
			$this->values[] = "%$busca%";
			$this->values[] = "%$busca%";
		}
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$this->link = 'busca='.$busca.'&id_empresa='.$id_empresa;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT emp.id_empresa, fantasia, u.nome as autor, date_format(m.data,'%d/%m/%Y %H:%i') as data,m.mensagem, m.anexo, m.id_mensagem
					FROM vsites_empresa_mensagem m 
					INNER JOIN vsites_user_empresa emp ON m.id_empresa=emp.id_empresa
					INNER JOIN vsites_user_usuario u ON m.id_usuario = u.id_usuario 
					WHERE m.id_empresa = ? ";
		$this->values = array($id_empresa);
		if($busca!=""){
			$this->sql.=" AND (emp.nome like ? or emp.email like ? or emp.empresa like ?)";
			$this->values[] = "%$busca%";
			$this->values[] = "%$busca%";
			$this->values[] = "%$busca%";
		}
		$this->sql .= " ORDER BY m.data DESC LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}

}

?>