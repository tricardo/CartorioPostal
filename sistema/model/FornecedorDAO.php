<?php
class FornecedorDAO extends Database{

	public function inserir($f){
		$this->table = "vsites_fornecedor";
		$this->fields = array("razao","fantasia","cnpj","id_regime",
	    "ie","fax","cep",
	    "endereco","numero","complemento",
	    "bairro","cidade","estado",
	    "id_banco","agencia","conta",
	    "favorecido","contato1","tel1",
	    "ramal1","email1","contato2",
	    "tel2","ramal2","email2",
	    "descProduto","creditoCompra","id_empresa",
		"data");
		$this->values = array("razao"=>$f->razao,"fantasia"=>$f->fantasia,"cnpj"=>$f->cnpj,"id_regime"=>$f->id_regime,
	    "ie"=>$f->ie,"fax"=>$f->fax,"cep"=>$f->cep,
	    "endereco"=>$f->endereco,"numero"=>$f->numero,"complemento"=>$f->complemento,
	    "bairro"=>$f->bairro,"cidade"=>$f->cidade,"estado"=>$f->estado,
	    "id_banco"=>$f->id_banco,"agencia"=>$f->agencia,"conta"=>$f->conta,
	    "favorecido"=>$f->favorecido,"contato1"=>$f->contato1,"tel1"=>$f->tel1,
	    "ramal1"=>$f->ramal1,"email1"=>$f->email1,"contato2"=>$f->contato2,
	    "tel2"=>$f->tel2,"ramal2"=>$f->ramal2,"email2"=>$f->email2,
	    "descProduto"=>$f->descProduto,"creditoCompra"=>$f->creditoCompra,"id_empresa"=>$f->id_empresa,
		"data"=>date("Y-m-d H:i:s")
		);

		$f->id_fornecedor = $this->insert();
		return $f;
	}

	public function buscaPorId($id,$id_empresa){
		$this->sql = "SELECT f.*,b.banco FROM vsites_fornecedor f
		LEFT JOIN vsites_banco b ON f.id_banco=b.id_banco
		WHERE id_fornecedor = ? and id_empresa=?";
		$this->values = array($id,$id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}

	public function buscaAnexosForn($id,$id_empresa){
		$this->sql = 'SELECT * FROM vsites_fornecedor_anexo as fa INNER JOIN vsites_fornecedor as f ON f.id_fornecedor=fa.id_fornecedor WHERE f.id_fornecedor=? and f.id_empresa=?';
		$this->values = array($id,$id_empresa);
		return $this->fetch();
	}
	
	public function atualizar($f){
		$this->sql = "UPDATE vsites_fornecedor SET
		razao=?,fantasia=?,cnpj=?,id_regime=?,
		ie=?,fax=?,cep=?,
		endereco=?,numero=?,complemento=?,
		bairro=?,cidade=?, estado=?,
		id_banco=?,agencia=?,conta=?,
		favorecido=?,contato1=?,tel1=?,
		ramal1=?,email1=?,contato2=?,
		tel2=?,ramal2=?,email2=?,
		descProduto=?,creditoCompra=?
		WHERE id_fornecedor=? and id_empresa=?
		";

		$this->values = array(
		$f->razao,$f->fantasia,$f->cnpj,$f->id_regime,
		$f->ie,$f->fax,$f->cep,
		$f->endereco,$f->numero,$f->complemento,
		$f->bairro,$f->cidade,$f->estado,
		$f->id_banco,$f->agencia,$f->conta,
		$f->favorecido,$f->contato1,$f->tel1,
		$f->ramal1,$f->email1,$f->contato2,
		$f->tel2,$f->ramal2,$f->email2,
		$f->descProduto,$f->creditoCompra,
		$f->id_fornecedor,$f->id_empresa
		);
		$this->exec();
	}

	public function busca($busca,$id_empresa,$pagina){
		$this->values = array();
		$where = " WHERE id_empresa=? ";
		$this->values[]=$id_empresa;
		if($busca<>""){
			$where .= " AND (razao like ? or fantasia like ? or cnpj like ? or descProduto like ?) ";
			$this->values[]="$busca%";
			$this->values[]="$busca%";
			$this->values[]="$busca";
			$this->values[]="$busca%";
		}
		$this->sql = "SELECT count(0) as total FROM vsites_fornecedor as f ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$this->link = 'busca='.$busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT * FROM vsites_fornecedor as f ".$where." ORDER BY razao"
		." LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}

	public function lista($id_empresa){
		$this->sql = "SELECT * FROM vsites_fornecedor as f WHERE id_empresa=? ORDER BY fantasia";
		$this->values = array($id_empresa);
		return $this->fetch();
	}
	
	public function inserirAnexo($anexo){
		$this->sql = "INSERT INTO vsites_fornecedor_anexo (id_fornecedor,anexo,descricao) 
			VALUES (?,?,?)";
		$this->values = array($anexo->id_fornecedor,$anexo->anexo,$anexo->descricao);
		$this->exec();
	}
	
	public function buscaPorIdAnexo($id_forneceodor_anexo){
		$this->sql = 'SELECT id_fornecedor_anexo,anexo FROM vsites_fornecedor_anexo WHERE id_fornecedor_anexo = ?';
		$this->values = array($id_forneceodor_anexo);
		$ret = $this->fetch();
		return $ret[0];	
	}
	
	public function excluirAnexo($anexo){
		$this->sql = 'DELETE FROM vsites_fornecedor_anexo WHERE id_fornecedor_anexo = ?';
		$this->values = array($anexo->id_fornecedor_anexo);
		$this->exec();
	}
}