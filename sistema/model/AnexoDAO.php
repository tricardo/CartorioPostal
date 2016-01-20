<?php
class AnexoDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_pedido_anexo';
	}

	/**
	 * lista nome dos anexo
	 */
	public function listaAnexoNome(){
		$this->sql = "SELECT anexo_nome from vsites_anexo_nome as an where status='Ativo' order by anexo_nome";
		$this->values = array();
		return $this->fetch();
	}

	public function selectPorId($id){
		$this->sql = "select anexo from vsites_empresa_mensagem as m where m.id_mensagem=?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	/**
	 * lista atividades do pedido_item BD
	 * @param Int $id_pedido_item
	 */

	public function listaAnexoPedido($id_pedido_item){
		$this->sql = "SELECT * from vsites_pedido_anexo as pa where id_pedido_item=? order by data desc";
		$this->values = array($id_pedido_item);
		return $this->fetch();
	}
	
	public function listaAnexoPedidoNome($id_pedido_item,$nome){
		$this->sql = "select id_pedido_item from vsites_pedido_anexo as pa where
						anexo_nome=? and
						id_pedido_item=?";
		$this->values = array($nome,$id_pedido_item);
		return $this->fetch();
	}
	
	public function inserir($anexo){
		$this->table = 'vsites_pedido_anexo';
		$this->fields = array('anexo','anexo_nome','id_pedido_item','id_usuario');
		$this->values = array('anexo'=>$anexo->anexo,'anexo_nome'=>$anexo->anexo_nome,'id_pedido_item'=>$anexo->id_pedido_item,'id_usuario'=>$anexo->id_usuario);
		$this->insert();
	}
	
	public function verifica($anexo_nome,$id_pedido_item){
		$this->sql = "select count(0) as total from vsites_pedido_anexo as pa where
					anexo_nome=? and id_pedido_item=?";
		$this->values = array($anexo_nome,$id_pedido_item);
		$ret = $this->fetch();
		return $ret[0]->total;
	}
	
	public function anexosErrados(){
		$this->sql = "SELECT pa.*,pi.id_pedido, pi.ordem, sd.departamento, uu.nome as usuario FROM vsites_pedido_anexo as pa, vsites_pedido_item as pi, vsites_servico_departamento sd, vsites_user_usuario as uu, vsites_pedido as p where pa.data>='2010-07-21 00:00:00' and pa.id_pedido_item=pi.id_pedido_item and pa.id_usuario=uu.id_usuario and uu.id_empresa=1 and pi.id_pedido=p.id_pedido and p.nome like '%hsbc%' and pi.id_servico_departamento=sd.id_servico_departamento order by pi.id_pedido, pi.ordem ASC";
		$this->values = array();
		return $this->fetch();
	}
	
	public function anexosSemErrados(){
		$this->sql 	= "select * from (
	SELECT pa.count_anexo, pi.id_pedido, pi.ordem, pi.departamento, pi.usuario, date_format(pi.operacional,'%d-%m-%Y') as operacional, pi.nome FROM 
		(select pi.id_pedido_item, pi.id_pedido, pi.ordem, pi.id_servico, d.departamento, uu.nome as usuario, pi.operacional, p.nome from 
			vsites_pedido_item as pi, vsites_pedido as p, vsites_servico_departamento as d, vsites_user_usuario as uu where 
			(pi.id_status='10' or pi.id_status='8') and pi.inicio>='2010-07-01 00:00:00' and 
			pi.id_pedido=p.id_pedido and p.nome like '%HSBC%' and pi.id_servico_departamento=d.id_servico_departamento and 
			uu.id_usuario=pi.id_usuario_op) as pi
				LEFT JOIN 
				(select COUNT(0) as count_anexo, pa.id_pedido_item from vsites_pedido_anexo as pa group by pa.id_pedido_item) as pa 
					ON pa.id_pedido_item=pi.id_pedido_item) as pi
				where pi.count_anexo is NULL or pi.count_anexo='0'";
		$this->values = array();
		return $this->fetch();
	}
	
	public function ListaAnexosConveniado($lista){
		$this->sql = "SELECT anexo_nome 
				FROM vsites_pedido_anexo AS pa 
				WHERE pa.id_pedido_item = ?
				AND (pa.anexo_nome='Certidгo' 
				OR pa.anexo_nome='Declaraзгo de Busca' 
				OR pa.anexo_nome='Declaraзгo de Busca de Imуveis' 
				OR pa.anexo_nome='Instrumento de Protesto' 
				OR pa.anexo_nome='Documento do Cliente')";
		$arr = array_values($lista);
		$this->values = $arr;
		return $this->fetch();
	}
	
	public function AlterarResultado($c){	
		$this->sql = "UPDATE vsites_pedido_item SET certidao_resultado = ? WHERE id_pedido_item =?";
		$this->values = array($c->certidao_resultado, $c->id_pedido_item);
		$this->exec();
	}
}
?>