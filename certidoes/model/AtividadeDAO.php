<?php
class AtividadeDAO extends Database{
	
	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_pedido_status';
	}
	
	/**
	 * insere atividade no pedido_item
	 * @param int $id_atividade
	 * @param string $status_obs
	 * @param int $id_usuario
	 * @param int $id_pedido_item
	 */
	public function inserir($id_atividade = '172',$status_obs = '',$id_usuario,$id_pedido_item){
		$data_i = date('Y-m-d H:m:s');

		$this->fields = array('id_atividade','status_obs','data_i','id_usuario','id_pedido_item');
		$this->values = array('id_atividade'=>$id_atividade,'status_obs'=>$status_obs,
								'data_i'=>$data_i,'id_usuario'=>$id_usuario,
								'id_pedido_item'=>$id_pedido_item);
		$this->insert();
		return 1;
	}
	
	/**
	* lista atividade no BD
	* @param Int $id_atividade
	*/
	public function selecionaPorID($id_atividade){
		$this->sql = "SELECT * from vsites_atividades as a where id_atividade='".$id_atividade."'";
		$this->values = array($id_atividade);
		$ret = $this->fetch();
		return $ret[0];
	}
		
}
?>