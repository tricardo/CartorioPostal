<?php
class ParceiroDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_afiliado2';
	}

	public function listarPorEmpresa($id_empresa){
		$this->sql = "SELECT uc.id_afiliado, uc.nome
                    from vsites_afiliado2 as uc, vsites_user_usuario as uu 
                    where uc.id_usuario=uu.id_usuario and 
                    uu.id_empresa=? and uc.conveniado='Sim' order by uc.nome";
		$this->values = array($id_empresa);
		return $this->fetch();
	}

	public function listarConveniadoAtivo($id_empresa){
		$this->sql = "SELECT uc.id_afiliado, uc.nome
                    from vsites_afiliado2 as uc, vsites_user_usuario as uu 
                    where uc.id_usuario=uu.id_usuario and 
                    uu.id_empresa=? and uc.conveniado='Sim' and uc.status='Ativo' order by uc.nome";
		$this->values = array($id_empresa);
		return $this->fetch();
	}
	
	public function listaConveniadoArquivo($id_empresa){
		$this->sql = "SELECT uc.* from vsites_afiliado2 as uc, vsites_user_usuario as uu 
			where uc.status='Ativo' and uc.conveniado='Sim' and uc.id_usuario=uu.id_usuario and uu.id_empresa=?
			 and (uc.id_afiliado='49117' or uc.id_afiliado='52045') order by uc.nome";
		$this->values = array($id_empresa);
		return $this->fetch();
	}

	public function busca($busca="", $id_empresa, $pagina=1){
		$this->values = array();
		$where = " WHERE uc.id_empresa=? ";
		$this->values[]=$id_empresa;
		if($busca<>""){
			$where .= " AND (uc.nome like ? or uc.email like ? or uc.contato like ? or uc.cpf like ? or uc.status = ?) ";
			$this->values[]="%$busca%";
			$this->values[]="%$busca%";
			$this->values[]="%$busca%";
			$this->values[]="%$busca%";
			$this->values[]="%$busca%";
		}
		$this->sql = "SELECT count(0) as total FROM vsites_afiliado2 as uc ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$this->link = 'busca='.$busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT uc.* FROM vsites_afiliado2 as uc  ".$where." ORDER BY uc.status, uc.nome ASC "
		." LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}

	/**
	 * retorna a quantidade de conveniados do cliente
	 *
	 * @param int $id_afiliado
	 */
	public function contaConveniados($id_afiliado){
		$this->sql = "SELECT count(0) as total FROM vsites_user_conveniado as uc where id_afiliado=?";
		$this->values = array($id_afiliado);
		$cont = $this->fetch();
		return $cont[0]->total;
	}

	/**
	 * verifica se esse cpf/cnpj já foi cadastrado nessa empresa
	 *
	 * @param int $cpf
	 * @param int $id_empresa
	 */
	public function verificaCPF($cpf,$id_empresa){
		$this->sql = "SELECT count(0) as total
						FROM vsites_afiliado2 c INNER JOIN vsites_user_usuario u ON c.id_usuario=u.id_usuario
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
						FROM vsites_afiliado2 c INNER JOIN vsites_user_usuario u ON c.id_usuario=u.id_usuario
						WHERE c.id_afiliado = ? AND u.id_empresa = ?";
		$this->values = array($id,$id_empresa);
		$cont = $this->fetch();
		return $cont[0]->total;
	}

	/**
	 * insere um cliente no BD
	 * @param unknown_type $c
	 */
	public function inserir($c, $empresa){
		$data = date('Y-m-d');
		$this->fields = array('id_pacote','id_usuario','id_usuario_com','restricao'
		,'nome','tel','email','tel2'
		,'site','rg','cpf','endereco'
		,'cidade','estado','bairro','cep'
		,'complemento','numero','tipo','fax'
		,'ramal2','outros','ramal','retem_iss'
		,'status','conveniado','im','data','comissao','id_empresa','observacao');
		$this->values = array('id_pacote'=>0,'id_usuario'=>0,'id_usuario_com'=>0,'restricao'=>0
		,'nome'=>$c->nome,'tel'=>$c->tel,'email'=>$c->email,'tel2'=>$c->tel2
		,'site'=>$c->site,'rg'=>$c->rg,'cpf'=>$c->cpf,'endereco'=>$c->endereco
		,'cidade'=>$c->cidade,'estado'=>$c->estado,'bairro'=>$c->bairro,'cep'=>$c->cep
		,'complemento'=>$c->complemento,'numero'=>$c->numero,'tipo'=>$c->tipo,'fax'=>$c->fax
		,'ramal2'=>$c->ramal2,'outros'=>$c->outros,'ramal'=>$c->ramal,'retem_iss'=>0
		,'status'=>$c->status,'conveniado'=>$c->conveniado,'im'=>$c->im,'data'=>$data,'comissao'=>$c->comissao, 'id_empresa'=>$empresa,
		'observacao'=>$c->observacao);
		return $this->insert();
	}

	public function atualizar($c,$empresa){
		$this->sql = "UPDATE vsites_afiliado2
					SET nome=?, tel=?,
						email=?,tel2=?,site=?,cpf=?,
						rg=?,endereco=?,cidade=?,estado=?,
						bairro=?, cep=?, complemento=?, numero=?,
						tipo=?, fax=?, ramal2=?, outros=?, 
						ramal=?, status=?,
						im=?,comissao=?,observacao=? 
					WHERE id_afiliado=? AND id_empresa=?";
		$this->values = array(
		$c->nome,$c->tel,
		$c->email,$c->tel2,$c->site,$c->cpf,
		$c->rg,$c->endereco,$c->cidade,$c->estado,
		$c->bairro,$c->cep,$c->complemento,$c->numero,
		$c->tipo,$c->fax,$c->ramal2,$c->outros,
		$c->ramal,$c->status,
		$c->im,$c->comissao,$c->observacao,
		$c->id_afiliado,$empresa);
		$this->exec();
	}

	/**
	 * busca um cliente pelo id
	 *
	 * @param $id_afiliado
	 */
	public function selectPorId($id_afiliado){
		$this->sql = "SELECT * from vsites_afiliado2 as uc where id_afiliado=?";
		$this->values = array($id_afiliado);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function buscaClienteCRM($id_afiliado){
		$this->sql    = 'SELECT * FROM vsites_afiliado2_crm WHERE id_afiliado=?';
		$this->values = array($id_afiliado);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function insereClienteCRM($c){
		$this->sql    = 'INSERT INTO vsites_afiliado2_crm 
			(id_afiliado, data_contrato_i,data_contrato_f,data_aniversario, ultimo_contato)
			VALUES (?,?,?,?,?)';
		$this->values = array($c->id_afiliado, $c->data_contrato_i,$c->data_contrato_f,$c->data_aniversario, $c->ultimo_contato);
		$this->exec();
	}
	
	public function alteraClienteCRM($c){
		$this->sql    = 'UPDATE vsites_afiliado2_crm SET data_contrato_i=?, data_contrato_f=?, data_aniversario=?, ultimo_contato=? WHERE id_afiliado=?';
		$this->values = array($c->data_contrato_i,$c->data_contrato_f,$c->data_aniversario, $c->ultimo_contato, $c->id_afiliado);

		$this->exec();
	}

        public function buscaAnexosCli($id,$id_empresa){
		$this->sql = 'SELECT ca.* FROM vsites_afiliado2_anexo as ca WHERE ca.id_afiliado=? and ca.id_empresa=?';
		$this->values = array($id,$id_empresa);
		return $this->fetch();
	}

        public function inserirAnexo($anexo){
		$this->sql = "INSERT INTO vsites_afiliado2_anexo (id_afiliado,anexo,descricao,id_empresa) 
			VALUES (?,?,?,?)";
		$this->values = array($anexo->id_afiliado,$anexo->anexo,$anexo->descricao,$anexo->id_empresa);
		$this->exec();
	}
	
	public function excluirAnexo($id,$id_empresa){
		$this->sql = 'DELETE FROM vsites_afiliado2_anexo WHERE id_afiliado_anexo = ? and id_empresa=?';
		$this->values = array($id,$id_empresa);
		$this->exec();
	}
        
}

?>
