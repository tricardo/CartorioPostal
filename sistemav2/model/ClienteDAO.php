<?php
class ClienteDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_user_cliente';
	}

	public function listarPorEmpresa($id_empresa){
		$this->sql = "SELECT uc.id_cliente, uc.nome
                    from vsites_user_cliente as uc, vsites_user_usuario as uu 
                    where uc.id_usuario=uu.id_usuario and 
                    uu.id_empresa=? and uc.conveniado='Sim' order by uc.nome";
		$this->values = array($id_empresa);
		return $this->fetch();
	}

	public function listarConveniadoAtivo($id_empresa){
		$this->sql = "SELECT uc.id_cliente, uc.nome
                    from vsites_user_cliente as uc, vsites_user_usuario as uu 
                    where uc.id_usuario=uu.id_usuario and 
                    uu.id_empresa=? and uc.conveniado='Sim' and uc.status='Ativo' order by uc.nome";
		$this->values = array($id_empresa);
		return $this->fetch();
	}
	
	public function listaConveniadoArquivo($id_empresa){
		$this->sql = "SELECT uc.* from vsites_user_cliente as uc, vsites_user_usuario as uu 
			where uc.status='Ativo' and uc.conveniado='Sim' and uc.id_usuario=uu.id_usuario and uu.id_empresa=?
			 and (uc.id_cliente='49117' or uc.id_cliente='52045') order by uc.nome";
		$this->values = array($id_empresa);
		return $this->fetch();
	}

	public function busca($busca="", $id_empresa, $pagina=1){
		$this->values = array();
		$where = " WHERE uc.id_usuario=uu.id_usuario AND uu.id_empresa=? ";
		$this->values[]=$id_empresa;
		if($busca<>""){
			$where .= " AND (uc.nome like ? or uc.email like ? or uc.contato like ? or uc.cpf like ? or uc.status = ?) ";
			$this->values[]="%$busca%";
			$this->values[]="%$busca%";
			$this->values[]="%$busca%";
			$this->values[]="%$busca%";
			$this->values[]="%$busca%";
		}
		$this->sql = "SELECT count(0) as total FROM vsites_user_cliente as uc, vsites_user_usuario as uu ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$this->link = 'busca='.$busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT uc.* FROM vsites_user_cliente as uc, vsites_user_usuario as uu ".$where." ORDER BY uc.status, uc.nome ASC "
		." LIMIT ".$this->getInicio().", ".$this->maximo;
                #echo $this->sql;
                #echo $id_empresa;
		return $this->fetch();
	}

	/**
	 * retorna a quantidade de conveniados do cliente
	 *
	 * @param int $id_cliente
	 */
	public function contaConveniados($id_cliente){
		$this->sql = "SELECT count(0) as total FROM vsites_user_conveniado as uc where id_cliente=?";
		$this->values = array($id_cliente);
		$cont = $this->fetch();
		return $cont[0]->total;
	}

	/**
	 * verifica se esse cpf/cnpj j� foi cadastrado nessa empresa
	 *
	 * @param int $cpf
	 * @param int $id_empresa
	 */
	public function verificaCPF($cpf,$id_empresa){
		$this->sql = "SELECT count(0) as total
						FROM vsites_user_cliente c INNER JOIN vsites_user_usuario u ON c.id_usuario=u.id_usuario
						WHERE c.cpf = ? AND u.id_empresa = ?";
		$this->values = array($cpf,$id_empresa);
		$cont = $this->fetch();
		return $cont[0]->total;
	}

	/**
	 * verifica se o cliente pertence a essa empresa
	 * @param $id
	 * @param $id_empresa
	 */
	public function verificaId($id,$id_empresa){
		$this->sql = "SELECT count(0) as total
						FROM vsites_user_cliente c INNER JOIN vsites_user_usuario u ON c.id_usuario=u.id_usuario
						WHERE c.id_cliente = ? AND u.id_empresa = ?";
		$this->values = array($id,$id_empresa);
		$cont = $this->fetch();
		return $cont[0]->total;
	}

	/**
	 * insere um cliente no BD
	 * @param unknown_type $c
	 */
	public function inserir($c){
		$data = date('Y-m-d');
		$this->fields = array('id_pacote','id_usuario','id_usuario_com','restricao'
		,'nome','tel','email','tel2'
		,'site','rg','cpf','endereco'
		,'cidade','estado','bairro','cep'
		,'complemento','numero','tipo','fax'
		,'ramal2','outros','ramal','retem_iss'
		,'status','conveniado','im','data');
		$this->values = array('id_pacote'=>$c->id_pacote,'id_usuario'=>$c->id_usuario,'id_usuario_com'=>$c->id_usuario_com,'restricao'=>$c->restricao
		,'nome'=>$c->nome,'tel'=>$c->tel,'email'=>$c->email,'tel2'=>$c->tel2
		,'site'=>$c->site,'rg'=>$c->rg,'cpf'=>$c->cpf,'endereco'=>$c->endereco
		,'cidade'=>$c->cidade,'estado'=>$c->estado,'bairro'=>$c->bairro,'cep'=>$c->cep
		,'complemento'=>$c->complemento,'numero'=>$c->numero,'tipo'=>$c->tipo,'fax'=>$c->fax
		,'ramal2'=>$c->ramal2,'outros'=>$c->outros,'ramal'=>$c->ramal,'retem_iss'=>$c->retem_iss
		,'status'=>$c->status,'conveniado'=>$c->conveniado,'im'=>$c->im,'data'=>$data);
		return $this->insert();
	}

	public function atualizar($c){
		$this->sql = "UPDATE vsites_user_cliente
					SET id_usuario_com=?, restricao=?, nome=?, tel=?,
						email=?,tel2=?,site=?,cpf=?,
						rg=?,endereco=?,cidade=?,estado=?,
						bairro=?, cep=?, complemento=?, numero=?,
						tipo=?, fax=?, ramal2=?, outros=?, 
						ramal=?, retem_iss=?, status=?, conveniado=?,
						id_pacote=?,im=? 
					WHERE id_cliente=?";
		$this->values = array(
		$c->id_usuario_com,$c->restricao,$c->nome,$c->tel,
		$c->email,$c->tel2,$c->site,$c->cpf,
		$c->rg,$c->endereco,$c->cidade,$c->estado,
		$c->bairro,$c->cep,$c->complemento,$c->numero,
		$c->tipo,$c->fax,$c->ramal2,$c->outros,
		$c->ramal,$c->retem_iss,$c->status,$c->conveniado,
		$c->id_pacote,$c->im,
		$c->id_cliente);
		$this->exec();
	}

	/**
	 * busca um cliente pelo id
	 *
	 * @param $id_cliente
	 */
	public function selectPorId($id_cliente){
		$this->sql = "SELECT * from vsites_user_cliente as uc where id_cliente=?";
		$this->values = array($id_cliente);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function buscaClienteCRM($id_cliente){
		$this->sql    = 'SELECT * FROM vsites_user_cliente_crm WHERE id_cliente=?';
		$this->values = array($id_cliente);
		$ret = $this->fetch();
		return count($ret) > 0 ? $ret[0] : array();
	}
	
	public function insereClienteCRM($c){
		$this->sql    = 'INSERT INTO vsites_user_cliente_crm 
			(id_cliente, data_contrato_i,data_contrato_f,data_aniversario, ultimo_contato)
			VALUES (?,?,?,?,?)';
		$this->values = array($c->id_cliente, $c->data_contrato_i,$c->data_contrato_f,$c->data_aniversario, $c->ultimo_contato);
		$this->exec();
	}
	
	public function alteraClienteCRM($c){
		$this->sql    = 'UPDATE vsites_user_cliente_crm SET data_contrato_i=?, data_contrato_f=?, data_aniversario=?, ultimo_contato=? WHERE id_cliente=?';
		$this->values = array($c->data_contrato_i,$c->data_contrato_f,$c->data_aniversario, $c->ultimo_contato, $c->id_cliente);

		$this->exec();
	}

        public function buscaAnexosCli($id,$id_empresa){
		$this->sql = 'SELECT ca.* FROM vsites_user_cliente_anexo as ca WHERE ca.id_cliente=? and ca.id_empresa=?';
		$this->values = array($id,$id_empresa);
		return $this->fetch();
	}

        public function inserirAnexo($anexo){
		$this->sql = "INSERT INTO vsites_user_cliente_anexo (id_cliente,anexo,descricao,id_empresa) 
			VALUES (?,?,?,?)";
		$this->values = array($anexo->id_cliente,$anexo->anexo,$anexo->descricao,$anexo->id_empresa);
		$this->exec();
	}
	
	public function excluirAnexo($id,$id_empresa){
		$this->sql = 'DELETE FROM vsites_user_cliente_anexo WHERE id_cliente_anexo = ? and id_empresa=?';
		$this->values = array($id,$id_empresa);
		$this->exec();
	}
        
}

?>