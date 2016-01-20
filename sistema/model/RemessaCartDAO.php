<?php
class RemessaCartDAO extends Database{
	
	public function selectPorId($id_remessa,$id_empresa){
		$this->sql = "SELECT rc.* from vsites_remessa_cart as rc, vsites_user_usuario as uu 
			where rc.id_remessa_cart=? and rc.id_usuario=uu.id_usuario and uu.id_empresa=? 
			order by rc.data desc";
		$this->values = array($id_remessa,$id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function selectNotificacoes($id_cliente){
		$this->sql = "SELECT pi.* from vsites_pedido_item as pi, vsites_pedido as p where
		p.id_conveniado=? and
		p.id_pedido = pi.id_pedido and
		pi.id_status  = '4' and
		pi.id_servico= '17' and
		pi.rem='0'
		order by pi.id_pedido_item";
		$this->values = array($id_cliente);
		return $this->fetch();
	}	
	
	public function updateNotificacoesRem($id_cliente){
		$this->sql = "update vsites_pedido_item as pi, vsites_pedido as p
						set pi.rem='1' where
						p.id_conveniado=? and
						p.id_pedido = pi.id_pedido and
						pi.id_status = '4'";
		$this->values = array($id_cliente);
		return $this->fetch();
	}	
}
?>