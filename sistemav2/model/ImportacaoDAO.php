<?php
class ImportacaoDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_pedido_imp';
	}

	public function inserirPedidoImp($p){
		$campos = '';
		$p->protocolo = trim($p->protocolo);
		$p->resultado = trim($p->resultado);
		$p->custas = trim($p->custas);
		$p->motivo = trim($p->motivo);
		if($p->protocolo<>'1'){
			$campos .= "certidao_protocolo='".$p->protocolo."'";
		}
		
		if($p->resultado<>''){
			if($campos<>'') $campos .=',';
			$campos .= "certidao_resultado='".$p->resultado."'";
		}
		
		if($p->custas<>''){
			if($campos<>'') $campos .=',';
			$campos .= "custas='".$p->custas."'";
		}
		
		if($p->motivo<>''){
			if($campos<>'') $campos .=',';
			$campos .= "motivo_atraso='".$p->motivo."'";
		}
		
		if($campos<>'') {
			$this->sql = "update vsites_pedido_item set ".$campos."
							where id_pedido=? and ordem=? and (id_empresa_atend=? or id_empresa_resp=?)";
			$this->values = array($p->id_pedido,$p->ordem,$p->id_empresa,$p->id_empresa);
			$this->update();
			$update = $this->getAffectedRows();
		}
		
		$this->fields = array('id_pedido','ordem','id_usuario','id_empresa',
							'protocolo','resultado','custas','motivo','erro');
		$this->values = array('id_pedido'=>$p->id_pedido,'ordem'=>$p->ordem,'id_usuario'=>$p->id_usuario,'id_empresa'=>$p->id_empresa
		,'protocolo'=>$p->protocolo,'resultado'=>$p->resultado,'custas'=>$p->custas,'motivo'=>$p->motivo,'erro'=>$update);
		$id = $this->insert();
		
		return $id;
	}
	
}
?>