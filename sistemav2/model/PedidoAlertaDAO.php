<?php
/**
 * tabela pata guardar os alertas enviados
 * @author caio.nardi
 *
 */
class PedidoAlertaDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_pedido_alerta';
	}

	public function inserir($pa){
		$this->fields = array('id_pedido','ordem','status','data','email');
		$this->values = array('id_pedido'=>$pa->id_pedido,
								'ordem'=>$pa->ordem,
								'status'=>$pa->status,
								'data'=>date("Y-m-d H:i:s"),
								'email'=>$pa->email);
		return $this->insert();
	}
}
?>