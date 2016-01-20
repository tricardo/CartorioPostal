<?php
class ConveniadoDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_user_conveniado';
	}

	/**
	 * faz busca dos conveniados
	 * @param String $busca
	 * @param int $id_cliente
	 * @param int $id_empresa
	 * @param int $pagina
	 */
	public function busca($busca,$id_empresa,$id_cliente='',$pagina=1){
		$this->values = array();
		$where = " FROM vsites_user_conveniado, vsites_user_cliente, vsites_user_usuario
					WHERE (vsites_user_conveniado.nome like ?)";
		$this->values[] = "%$busca%";
		if($id_cliente <> ''){
			$where .= " and vsites_user_conveniado.id_cliente=?";
			$this->values[]=$id_cliente;
		}
		$where.=" AND vsites_user_conveniado.id_cliente = vsites_user_cliente.id_cliente AND
				vsites_user_usuario.id_usuario = vsites_user_cliente.id_usuario AND
				vsites_user_usuario.id_empresa=?";
		$this->values[] = $id_empresa;

		$this->sql = "SELECT count(0) as total ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$this->link = 'busca='.$busca.'&id_conveniado='.$id_conveniado;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT vsites_user_conveniado.*, vsites_user_cliente.nome as empresa ".$where
		."ORDER BY vsites_user_conveniado.nome ASC
						 LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}

	public function inserir($c){
		$this->fields = array("contato","senha","nome",
								"tel","email","endereco",
								"bairro","cidade","estado",
								"cep","data","cpf",
								"rg","id_cliente","complemento",
								"numero","fax","telcel",
								"outros","tipo","status",
								"ramal","faturamento","id_usuario_com");
		$this->values = array("contato"=>$c->contato,"senha"=>$c->senha,"nome"=>$c->nome,
								"tel"=>$c->tel,"email"=>$c->email,"endereco"=>$c->endereco,
								"bairro"=>$c->bairo,"cidade"=>$c->cidade,"estado"=>$c->estado,
								"cep"=>$c->cep,"data"=>date("Y-m-d H:i:s"),"cpf"=>$c->cpf,
								"rg"=>$c->rg,"id_cliente"=>$c->id_cliente,"complemento"=>$c->complemento,
								"numero"=>$c->numero,"fax"=>$c->fax,"telcel"=>$c->telcel,
								"outros"=>$c->outros,"tipo"=>$c->tipo,"status"=>$c->status,
								"ramal"=>$c->ramal,"faturamento"=>$c->faturamento,"id_usuario_com"=>$c->id_usuario_com);
		return $this->insert();
	}

	public function selectPorId($id,$id_empresa=null){
		$this->sql = "SELECT uc.* FROM vsites_user_conveniado as uc, vsites_user_usuario as uu, vsites_user_cliente as c
						WHERE uc.id_conveniado=? and uc.id_cliente=c.id_cliente and 
							c.id_usuario=uu.id_usuario";
		$this->values = array($id);
		if($id_empresa!=null){
			$this->sql .=" and uu.id_empresa=?";
			$this->values[]=$id_empresa;
		}
		$ret = $this->fetch();
		return $ret[0];
	}

	public function atualizar($c){
		$this->sql = "UPDATE vsites_user_conveniado SET faturamento=?, contato=?, nome=?,
								tel=?, email=?, id_cliente=?,
								cpf=?, rg=?, endereco=?,
								cidade=?, estado=?, bairro=?,
								cep=?, complemento=?, numero=?,
								tipo=?, fax=?, telcel=?,
								outros=?,  ramal=?, status=?,id_usuario_com=? 
					WHERE id_conveniado=?";

		$this->values=array($c->faturamento,$c->contato,$c->nome,
		$c->tel,$c->email,$c->id_cliente,
		$c->cpf,$c->rg,$c->endereco,
		$c->cidade,$c->estado,$c->bairro,
		$c->cep,$c->complemento,$c->numero,
		$c->tipo,$c->fax,$c->telcel,
		$c->outros,$c->ramal,$c->status,$c->id_usuario_com,$c->id_conveniado);
		$this->exec();
	}
	
	public function atualizaSenha($c){
		$this->sql = "update vsites_user_conveniado set senha = ? WHERE id_conveniado = ?";
		$this->values = array($c->senha_new,$c->id_conveniado);
		$this->exec();
	}
}
?>