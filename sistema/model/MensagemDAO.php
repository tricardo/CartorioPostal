<?php
class MensagemDAO extends Database{
	
	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_mensagem';
	}
	
	/**
	 * insere uma mensagem no pedido_item
	 * @param int $id_pedido_item
	 * @param string $id_usuario
	 * @param string $de
	 * @param string $para
	 * @param string $mensagem
	 */
	public function inserir($id_pedido_item,$id_usuario,$de,$para,$mensagem){
		$data = date('Y-m-d h:m:s');
		$this->fields = array('de','para','mensagem','data','id_pedido_item','id_usuario');
		$this->values = array('de'=>$de,'para'=>$para,'mensagem'=>$mensagem,'data'=>$data,'id_pedido_item'=>$id_pedido_item,'id_usuario'=>$id_usuario);
		$this->insert();
		return 1;
	}

	/**
	* lista mensagem do pedido_item BD
	* @param Int $id_pedido_item
	*/
	public function listaMensagemPedido($id_pedido_item){
		$this->sql = "SELECT *  from vsites_mensagem as m where id_pedido_item=? order by data desc";
		$this->values = array($id_pedido_item);
		return $this->fetch();
	}
	
}
?>