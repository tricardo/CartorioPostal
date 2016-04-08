<?php
class AnexoVerificaDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_pedido_anexo';
	}

	/**
	 * verifica permissão de anexar no pedido
	 * @param int $id_empresa
	 * @param array $departamento_p
	 * @param array $departamento_s
	 * @param int $id_pedido_item
	 */

	public function AnexoVerifica($id_empresa,$departamento_p,$departamento_s,$id_pedido_item){
		$errors=array();
		$pedidoverificaDAO = new PedidoVerificaDAO();
		$pedido_ane = $pedidoverificaDAO->verificaPermissaoAnexo($id_pedido_item,$id_empresa);

		if(in_array($pedido_ane->id_departamento_resp,$departamento_p)!=1 and in_array('2',$departamento_p)!=1 and in_array('6',$departamento_p)!=1 and in_array('1',$departamento_p)!=1 and in_array('10',$departamento_p)!=1 and in_array('19',$departamento_p)!=1){
			$errors['error'] .= '<li><b>Você não tem permissão para realizar essa operação, esse pedido pertence a outro departamento.</b></li>';
		}

		return $errors;
	}

	public function AnexoVerificaImp($id_empresa,$departamento_p,$id_pedido,$ordem){
		$errors=array();
		$this->sql = "SELECT sd.id_departamento_resp, pi.id_pedido_item from vsites_pedido_item as pi, vsites_servico_departamento as sd where 
		pi.id_pedido=? and
		pi.ordem=? and
		(pi.id_empresa_atend=? or pi.id_empresa_resp=?) and
		pi.id_servico_departamento = sd.id_servico_departamento limit 1";
		$this->values = array($id_pedido,$ordem,$id_empresa,$id_empresa);
		$ret = $this->fetch();

		if($ret[0]->id_departamento_resp!=$departamento_p or $ret[0]->id_pedido_item==''){
			$ret[0]->error .= '<li><b>Você não tem permissão para realizar essa operação, esse pedido pertence a outro departamento.</b></li>';
		}

		return $ret[0];
	}
	
	/**
	 * verifica permissão de deletar anexo
	 * @param int $id_empresa
	 * @param int $id_usuario
	 * @param int $id_pedido_anexo
	 * @param array $departamento_p
	 * @param array $departamento_s
	 * @param int $id_pedido_item
	 */

	public function AnexoVerificaDeleta($id_empresa,$id_usuario,$id_pedido_anexo,$departamento_p,$departamento_s,$id_pedido_item){
		$p_verifica=array();

		if(in_array('6',$departamento_p)==1){
			$atendimento_deleta = " and id_usuario=".$id_usuario;
		} else{
			$atendimento_deleta = '';
		}

		$this->sql = "select COUNT(0) as total, anexo from vsites_pedido_anexo as pa where id_pedido_item=? and id_pedido_anexo=? ".$atendimento_deleta." group by id_pedido_anexo";
		$this->values = array($id_pedido_item,$id_pedido_anexo);
		$ret = $this->fetch();
		$p_verifica['anexo'] = $ret[0]->anexo;
		if($ret[0]->total==0) {
			$p_verifica['error'] .= '<li><b>Você não tem permissão deletar esse anexo</b></li>';
		}

		$pedidoverificaDAO = new PedidoVerificaDAO();
		$pedido_ane = $pedidoverificaDAO->verificaPermissaoAnexo($id_pedido_item,$id_empresa);

		if(in_array($pedido_ane->id_departamento_resp,$departamento_p)!=1 and in_array('2',$departamento_p)!=1 and in_array('6',$departamento_p)!=1 and in_array('1',$departamento_p)!=1 and in_array('10',$departamento_p)!=1){
			$p_verifica['error'] .= '<li><b>Você não tem permissão para realizar essa operação, esse pedido pertence a outro departamento.</b></li>';
		}

		if($pedido_ane->operacional=='0000-00-00' and $pedido_ane->id_empresa_resp!='0' and $pedido_ane->id_empresa_resp!=$id_empresa){
			$p_verifica['error'] .= '<li><b>Você não tem permissão para realizar essa operação, porque outra franquia foi selecionada para executar o serviço.</b></li>';
		}

		if($pedido_ane->operacional<>'0000-00-00' and $pedido_ane->id_empresa_resp!='0' and $pedido_ane->id_empresa_resp==$id_empresa and $id_empresa!='1'){
			$p_verifica['error'] .= '<li><b>Esse pedido já foi concluído por sua unidade e foi liberado para a franquia responsável pelo cadastro.</b></li>';
		}
		return $p_verifica;
	}

}
?>