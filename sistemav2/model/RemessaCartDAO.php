<?php
class RemessaCartDAO extends Database{
	
	public function selectPorId($id_remessa,$id_empresa){
		$this->sql = "SELECT rc.* from vsites_remessa_cart as rc, vsites_user_usuario as uu 
			where rc.id_remessa_cart=? and rc.id_usuario=uu.id_usuario and uu.id_empresa=? 
			order by rc.data desc";
		$this->values = array($id_remessa,$id_empresa);
		$ret = $this->fetch();
		return count($ret) > 0 ? $ret[0] : array();
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
        
        public function listartodasRemessas(){
            global $controle_id_empresa;
            $this->sql = "SELECT rc.* from vsites_remessa_cart as rc, vsites_user_usuario as uu where rc.id_usuario=uu.id_usuario and uu.id_empresa='".$controle_id_empresa."' order by rc.data desc limit 50";            return $this->fetch();
        }
        
         public function listartodasRetorno(){
            global $controle_id_empresa;
            $this->sql = "SELECT r.* from vsites_retorno as r, vsites_user_usuario as uu where r.id_usuario=uu.id_usuario and uu.id_empresa='".$controle_id_empresa."' order by r.data desc limit 50";
            return $this->fetch();
        }
        
        public function remessaCliente($id_cliente){
            $this->sql = "SELECT c.* from vsites_user_cliente as c where c.id_cliente=?";
            $this->values=array($id_cliente);
            return $this->fetch();
        }
        
        public function remessaPedido($id_cliente){
            $this->sql = "SELECT pi.* from
                vsites_user_usuario as u, vsites_pedido_item as pi, vsites_pedido as p where
                p.id_conveniado=? and
                p.id_pedido = pi.id_pedido and
                pi.id_servico= '17' and
                pi.id_status  = '4' and
                pi.id_usuario=u.id_usuario and
                pi.rem='0'
                order by pi.id_pedido_item";
            $this->values = array($id_cliente);
            return $this->fetch();
        }
        
        public function inserir($id_cliente, $controle_id_usuario, $nomeArquivo){
            $this->sql = "insert into vsites_remessa_cart (id_cliente,id_usuario,arquivo,data)
                            values('".$id_cliente."','".$controle_id_usuario."','".$nomeArquivo."',NOW())";
            $this->exec();
        }
        
        public function editarPedidoRem($id_cliente){
            $this->sql = "update vsites_pedido_item as pi, vsites_pedido as p
            set pi.rem='1' where
            p.id_conveniado='".$id_cliente."' and
            p.id_pedido = pi.id_pedido and
            pi.id_status = '4' and
            pi.id_servico='17'";
            $this->exec();
        }
        
        public function retorno49117($id_cliente, $controle_id_empresa, $onde){
            $this->sql = "SELECT pi.id_pedido, pi.ordem, pi.certidao_numero_not, pi.certidao_protocolo, pi.certidao_data_protocolo, pi.certidao_ocorrencia, pi.certidao_data_ocorrencia, pi.certidao_registro, pi.certidao_data_registro, pi.certidao_numero_ar  from
            vsites_user_usuario as u, vsites_pedido_item as pi, vsites_pedido as p where
			p.id_conveniado='".$id_cliente."' and
			p.id_pedido = pi.id_pedido and
			pi.id_usuario=u.id_usuario and
			pi.id_status!='14' and
			u.id_empresa='".$controle_id_empresa."'
			".$onde."
            order by pi.id_pedido_item";
            return $this->fetch();
        }
        
        public function retorno52045($id_cliente, $controle_id_empresa, $onde){
            $this->sql = "SELECT pi.id_pedido, pi.ordem, pi.certidao_numero_not, pi.certidao_protocolo, pi.certidao_data_protocolo, pi.certidao_ocorrencia, pi.certidao_data_ocorrencia, pi.certidao_registro, pi.certidao_data_registro, pi.certidao_numero_ar  from
            vsites_user_usuario as u, vsites_pedido_item as pi, vsites_pedido as p where
			p.id_conveniado='".$id_cliente."' and
			p.id_pedido = pi.id_pedido and
			pi.id_usuario=u.id_usuario and
			pi.id_status!='14' and
			u.id_empresa='".$controle_id_empresa."'
			".$onde."
            order by pi.id_pedido_item";
            return $this->fetch();
        }
        
        
}
?>