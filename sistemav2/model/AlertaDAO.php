<?php
class AlertaDAO extends Database {
	
	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_alerta';
	}
	
	public function limpa(){
		$this->sql = 'DELETE FROM vsites_alerta';
		$this->exec();
	}
	
	public function inserir($alerta){
		$this->fields = array('id_empresa','alerta','data','total');
		$this->values = array('id_empresa'=>$alerta->id_empresa
			,'alerta'=>$alerta->alerta
			,'data'=>$alerta->data,
			'total'=>$alerta->total);
		$this->insert();
	}
	
	public function consulta($data){
		$this->sql = 'SELECT count(0) as total,pi.id_status,id_empresa,st.status as alerta 
						FROM vsites_pedido_item pi
						INNER JOIN vsites_user_usuario uu on uu.id_usuario = pi.id_usuario
						INNER JOIN vsites_status st on st.id_status = pi.id_status
						WHERE pi.data <= ? and pi.id_status in (12,16,1,2,11)
						GROUP BY id_empresa,id_status';
		$this->values = array($data);
		return $this->fetch();
	}
	
}