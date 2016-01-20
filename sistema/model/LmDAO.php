<?php
class LmDAO extends Database{
	
	public function __construct(){
		parent::__construct();
		$this->table = 'm_user_lm';
		$this->maximo=50;
	}
	
	/**
	 * retorna a lista de todos os usuários
	 */
	public function listarTodasLM(){
		$this->sql = "SELECT id_lm, nome FROM m_user_lm as ul where id_parent = '0' or id_parent is NULL ORDER BY nome";
		$this->values = array();
		return $this->fetch();
	}
	
	public function busca($id_lm='', $busca='',$status='',$pagina=1){
		$this->values = array();
		
		$where = " WHERE 1=1 "; 

		if($id_lm<>''){
			$where .= " AND ul.id_lm=? ";
			$this->values[] = $id_lm;
		}
		if($busca<>''){
			$where .= " AND (ul.nome like ? or ul.email like ? or ul.cpf = ?) ";
			$this->values[] = $busca.'%';
			$this->values[] = $busca.'%';
			$this->values[] = $busca;
		}
		if($status<>''){
			$where .= " AND ul.status = ? ";
			$this->values[] = $status;
		}		
		
		$where .= " ORDER BY ul.nome ASC";
		
		$this->sql = "SELECT count(0) as total FROM m_user_lm as ul ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		
		$this->link = 'busca='.$busca.'&id_lm='.$id_lm.'&status='.$status;
		$this->pagina = ($pagina==NULL)?1:$pagina;
				
		$this->sql = "SELECT ul.nome,ul.email, ul.id_lm, ul.id_parent, ul.status
			 	FROM m_user_lm as ul 
				".$where." LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}
	
	/**
	 * insere um LM no BD
	 * @param Usuario $lm
	 */
	public function inserir($lm){
		$this->fields = array('nome','tel','email','id_usuario'
								,'rg','cpf','endereco','cidade',
								'estado','bairro','cep','complemento'
								,'numero','tipo','fax','ramal'
								,'status');
		$this->values = array('nome'=>$lm->nome,'tel'=>$lm->tel,'email'=>$lm->email,'id_usuario'=>$lm->id_usuario
						,'rg'=>$lm->rg,'cpf'=>$lm->cpf,'endereco'=>$lm->endereco,'cidade'=>$lm->cidade
						,'estado'=>$lm->estado,'bairro'=>$lm->bairro,'cep'=>$lm->cep,'complemento'=>$lm->complemento
						,'numero'=>$lm->numero,'tipo'=>$lm->tipo,'fax'=>$lm->fax,'ramal'=>$lm->ramal
						,'status'=>'Pendente');
		return $this->insert();
	}
	
	/**
	 * atualizar um LM no BD pelo email
	 * @param Usuario $l
	 */
	public function atualizar($l){
		$this->sql = "UPDATE m_user_lm 
					SET nome=?, tel=?,cpf=?,rg=?,
					endereco=?,cidade=?,estado=?,bairro=?,
					cep=?, complemento=?, numero=?,tipo=?,
					fax=?, ramal=? , status=? 
					WHERE id_lm=?";
		$this->values = array(
			$l->nome,$l->tel,$l->cpf,$l->rg,
			$l->endereco,$l->cidade,$l->estado,$l->bairro,
			$l->cep,$l->complemento,$l->numero,$l->tipo,
			$l->fax,$l->ramal,$l->status,$l->id_lm);
		$this->exec();
	}
	
	/**
	 * busca um lm pelo id
	 * 
	 * @param $id_lm
	 */

	public function selectPorId($id_lm){
		$this->sql = "SELECT ul.* from m_user_lm as ul where ul.id_lm=?";
		$this->values = array($id_lm);
		$ret = $this->fetch();
		return $ret[0];
	}
}

?>