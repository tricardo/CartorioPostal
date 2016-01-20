<?php
class PontosDeVendasDAO extends Database {
	
	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_pontosdevendas';
		$this->maximo=50;
	}
	
	public function busca($id_empresa, $busca='',$pagina=1){
		$this->values = array();
		$where = " WHERE id_empresa=?"; 
		$this->values[]=$id_empresa; 
		if($busca!=''){
			$where.=" AND (pv.nome like ? or pv.email like ? or pv.empresa like ?)";
			$this->values[] = '%'.$busca.'%';
			$this->values[] = '%'.$busca.'%';
			$this->values[] = '%'.$busca.'%';
		}		
		$this->sql = "SELECT count(0) as total 
						FROM vsites_pontosdevendas as pv ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		
		$where.=" ORDER BY pv.empresa ASC";
		$this->link = 'busca='.$busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;
				
		$this->sql = "SELECT pv.* 
					FROM vsites_pontosdevendas as pv ".$where
					." LIMIT ".$this->getInicio().", ".$this->maximo; 
		return $this->fetch();
	}
	
	public function selectPorId($id,$id_empresa){
		$this->sql = "SELECT vp.*, vuu.nome as nome_comissionado, vuu.id_usuario 
					FROM vsites_pontosdevendas as vp LEFT JOIN vsites_user_usuario as vuu on vp.id_usuario=vuu.id_usuario
					WHERE vp.id_ponto=? and vp.id_empresa=?";
		$this->values = array($id,$id_empresa);
		$ret =  $this->fetch();
		return $ret[0];
	}
	
	public function atualizar($pVenda,$id_empresa){
		$this->sql = "UPDATE vsites_pontosdevendas SET 
			id_usuario=?, nome=?, cel=?, tel=?, 
			email=?, endereco=?, cidade=?, estado=?, 
			bairro=?, cep=?, empresa=?, cpf=?, 
			rg=?, tipo=?, complemento=?, numero=?,
			ramal=?, status=?,empresa=?
		where id_ponto=? and id_empresa=?";
		$this->values = array($pVenda->id_usuario,$pVenda->nome,$pVenda->cel,$pVenda->tel,
							$pVenda->email,$pVenda->endereco,$pVenda->cidade,$pVenda->estado,
							$pVenda->bairro,$pVenda->cep,$pVenda->empresa,$pVenda->cpf,
							$pVenda->rg,$pVenda->tipo,$pVenda->complemento,$pVenda->numero,
							$pVenda->ramal,$pVenda->status,$pVenda->empresa,
							$pVenda->id_ponto,$id_empresa);
		$this->exec();
	}
	
	public function inserir($pVenda){
		$this->fields = array('id_usuario','id_empresa','nome','cel','tel',
								'email','endereco','bairro','cidade',
								'estado','cep','data','cpf', 
								'rg', 'empresa','tipo','complemento', 
								'numero','ramal','status');
		$this->values = array('id_usuario'=>$pVenda->id_usuario,
								'id_empresa'=>$pVenda->id_empresa,
								'nome'=>$pVenda->nome,
								'cel'=>$pVenda->cel,
								'tel'=>$pVenda->tel,
								'email'=>$pVenda->email,
								'endereco'=>$pVenda->endereco,
								'bairro'=>$pVenda->bairro,
								'cidade'=>$pVenda->cidade,
								'estado'=>$pVenda->estado,
								'cep'=>$pVenda->cep,
								'data'=>date("Y-m-d"),
								'cpf'=>$pVenda->cpf,
								'rg'=>$pVenda->rg, 
								'empresa'=>$pVenda->empresa, 
								'tipo'=>$pVenda->tipo, 
								'complemento'=>$pVenda->complemento, 
								'numero'=>$pVenda->numero, 
								'ramal'=>$pVenda->ramal, 
								'status'=>$pVenda->status);
		return $this->insert();
	}
}
?>