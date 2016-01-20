<?php
class UsuarioLmDAO extends Database{
	
	public function __construct(){
		parent::__construct();
		$this->table = 'm_user_lm';
		$this->maximo=50;
	}
	
	/**
	 * retorna a lista de todos os usuários
	 */
	public function listar(){
		$this->sql = "SELECT * FROM m_user_lm ORDER BY nome";
		$this->values = array();
		return $this->fetch();
	}
	
	public function busca($busca='',$pagina=1){
		$this->values = array();
		
		$where = " WHERE uu.id_usuario !='1' "; 

		if($busca<>''){
			$where .= " AND (uu.nome like ? or uu.email like ?) ";
			$this->values[] = $busca.'%';
			$this->values[] = $busca.'%';
		}
		$where .= " ORDER BY uu.nome ASC";
		
		$this->sql = "SELECT count(0) as total FROM m_user_lm as uu ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		
		$this->link = 'busca='.$busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;
				
		$this->sql = "SELECT uu.id_lm,uu.nome,uu.email,uu.status
			 	FROM m_user_lm as uu 
				".$where." LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}
	
	/**
	 * insere um funcionário no BD
	 * @param Usuario $u
	 */
	public function inserir($u){
		$this->fields = array('senha','tipo','cpf','rg',
							'nome','cel','tel','fax',
							'email','endereco','complemento','numero',
							'cidade','estado','bairro','cep',
							'data','status','ramal');
		$this->values = array(
			'senha'=>$this->codificaSenha($u->email,$u->senha),'tipo'=>$u->tipo,'cpf'=>$u->cpf,'rg'=>$u->rg,
			'nome'=>$u->nome,'cel'=>$u->cel,'tel'=>$u->tel,'fax'=>$u->fax,
			'email'=>$u->email,'endereco'=>$u->endereco,'complemento'=>$u->complemento,'numero'=>$u->numero,
			'cidade'=>$u->cidade,'estado'=>$u->estado,'bairro'=>$u->bairro,'cep'=>$u->cep,
			'data'=>date("Y-m-d"),'status'=>$u->status,'ramal'=>$u->ramal);
		return $this->insert();
	}
	
	/**
	 * atualizar um usuário no BD pelo id
	 * @param Usuario $u
	 */
	public function atualizar($u){
		$this->sql = "update m_user_lm set 
					tipo=?, cpf = ?,rg = ?, 
					nome=?, cel=?, tel=?, fax=?,
					email=?, endereco=? ,complemento=?, numero=?,
					cidade = ? , estado = ? , bairro = ? , cep =?,
					status =?, ramal=? 
					where id_lm=?";
		$this->values = array(
			$u->tipo,$u->cpf,$u->rg,
			$u->nome,$u->cel,$u->tel,$u->fax,
			$u->email,$u->endereco,$u->complemento,$u->numero,
			$u->cidade,$u->estado,$u->bairro,$u->cep,
			$u->status,$u->ramal,
			$u->id_lm);
		$this->exec();
	}
	
	/**
	 * busca um usuário pelo email
	 * @param String $email
	 */
	public function selectPorEmail($email){
		$this->sql = "SELECT m_user_lm.* FROM vsites_user_usuario WHERE email=? ";
		$this->values = array($email);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	/**
	 * busca um usuário pelo ir
	 * @param int $id
	 */
	public function selectPorId($id){
		$this->sql = "SELECT u.* FROM m_user_lm u WHERE id_lm=?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];	
	}
	
	/**
	 * verifica a senha do usuário
	 *
	 * @param unknown_type $email
	 * @param unknown_type $senha
	 * @return boolean
	 */
	public function verificaSenha($email,$senha){
		$this->sql = "SELECT * from m_user_lm where email=? and senha=?";
		$this->values = array($email,$this->codificaSenha($email,$senha));
		return (count($this->fetch())>0);
	}
	
	/**
	 * atualiza a senha do usuário
	 * @param unknown_type $usuario
	 */
	public function atualizaSenha($u){
		$this->sql = "update m_user_lm set senha=? where id_lm=?";
		$this->values = array($this->codificaSenha($u->email,$u->senha),$u->id_lm);
		$this->exec();
	}
	
	public function codificaSenha($email,$senha){
		return md5($email.$senha);
	}
	
	/**
	 * lista os usuários de um departamento e uma empresa 
	 * 
	 * @param int $id_empresa
	 * @param int $id_departamento
	 */
	public function listarPorDepartamentoEmpresa($id_empresa, $id_departamento,$sup=false){
		$this->sql = "SELECT id_usuario, nome ,email
					FROM m_user_lm as uu 
					WHERE 
					id_empresa = ?";
		$this->values = array($id_empresa);
		if($sup){
			$this->sql.=" AND departamento_s LIKE ?";
			$this->values[] = '%'.$id_departamento.'%';
		}else{
			$this->sql.=" AND departamento_p LIKE ?";
			$this->values[] = '%'.$id_departamento.'%';
		}					
		$this->sql.=" ORDER BY nome";
		return $this->fetch();
	}
}

?>