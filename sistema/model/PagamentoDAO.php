<?php
class PagamentoDAO extends Database{

	public function inserir($p){
		$this->table = 'vsites_fin_pagamento';

		$regimeDAO = new RegimeDAO();
		$regime = $regimeDAO->buscaPorId($p->id_regime);
		$p->ir = $p->valor/100*$regime->ir;

		if((float)($regime->margem)<(float)($p->valor)){
			$p->pis = (float)($p->valor)/100*(float)($p->regime->pis);
			$p->cofins = (float)($p->valor)/100*(float)($p->regime->cofins);
		}

		$p->pis = number_format($p->pis,2,".","");
		$p->ir = number_format($p->ir,2,".","");
		$p->cofins = number_format($p->cofins,2,".","");


		if($p->qt_parcelas<>'' and $p->qt_parcelas!=0){
			$this->fields = array("id_holding","id_compra","id_planoconta","id_forma_pagamento","id_fornecedor"
			,"id_banco","agencia","conta"
			,"favorecido","valor","qt_parcelas"
			,"dt_vencimento","parcela","id_parent"
			,"descricao"
			,"id_empresa","data","id_departamento"
			,"nota","id_regime","cnpj","valor_ir","valor_pis","valor_cofins","fisico");

			for($i=1; $i<=$p->qt_parcelas; $i++){
				if($i>1) $p->dt_vencimento = date("Y-m-d",strtotime("+1 month", strtotime(date($p->dt_vencimento))));
				$this->values = array("id_holding"=>$p->id_holding,"id_compra"=>$p->id_compra,"id_planoconta"=>$p->id_planoconta, "id_forma_pagamento"=>$p->id_forma_pagamento, "id_fornecedor"=>$p->id_fornecedor
				,"id_banco"=>$p->id_banco, "agencia"=>$p->agencia, "conta"=>$p->conta
				,"favorecido"=>$p->favorecido, "valor"=>$p->valor, "qt_parcelas"=>$p->qt_parcelas
				,"dt_vencimento"=>$p->dt_vencimento, "parcela"=>$i, "id_parent"=>$p->id_pagamento
				,"descricao"=>$p->descricao
				,"id_empresa"=>$p->id_empresa,"data"=>date("Y-m-d"),"id_departamento"=>$p->id_departamento
				,"nota"=>$p->nota,"id_regime"=>$p->id_regime,"cnpj"=>$p->cnpj,"valor_ir"=>$p->valor_ir,"valor_pis"=>$p->valor_pis,"valor_cofins"=>$p->valor_cofins,"fisico"=>$p->fisico);
				if($p->id_pagamento=='') $p->id_pagamento = $this->insert(); else $this->insert();
			}
		} else {
			$this->fields = array("id_holding","id_compra","id_planoconta","id_forma_pagamento","id_fornecedor"
			,"id_banco","agencia","conta"
			,"favorecido","valor","qt_parcelas"
			,"dt_vencimento"
			,"descricao"
			,"id_empresa","data","id_departamento"
			,"nota","id_regime","cnpj","valor_ir","valor_pis","valor_cofins","fisico");

			$this->values = array("id_holding"=>$p->id_holding,"id_compra"=>$p->id_compra,"id_planoconta"=>$p->id_planoconta, "id_forma_pagamento"=>$p->id_forma_pagamento, "id_fornecedor"=>$p->id_fornecedor
			,"id_banco"=>$p->id_banco, "agencia"=>$p->agencia, "conta"=>$p->conta
			,"favorecido"=>$p->favorecido, "valor"=>$p->valor, "qt_parcelas"=>$p->qt_parcelas
			,"dt_vencimento"=>$p->dt_vencimento
			,"descricao"=>$p->descricao
			,"id_empresa"=>$p->id_empresa,"data"=>date("Y-m-d"),"id_departamento"=>$p->id_departamento
			,"nota"=>$p->nota,"id_regime"=>$p->id_regime,"cnpj"=>$p->cnpj,"valor_ir"=>$p->valor_ir,"valor_pis"=>$p->valor_pis,"valor_cofins"=>$p->valor_cofins,"fisico"=>$p->fisico);
			$p->id_pagamento = $this->insert();		
		}
			

		return $p;
	}
	
	public function buscaPorCompra($id_compra,$id_empresa){
		$this->sql = 'SELECT * FROM vsites_fin_pagamento WHERE id_compra = ? ';
		$this->values = array($id_compra);
		$ret = $this->fetch();
		return $ret[0];
	}

	public function buscaPorId($id_pagamento,$id_empresa){
		$this->sql = 'SELECT p.* FROM vsites_fin_pagamento p WHERE p.id_pagamento = ? AND id_empresa=?';
		$this->values = array($id_pagamento,$id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function busca($busca,$id_empresa,$pagina){
		$url_busca = $_SERVER['REQUEST_URI'];
		$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
		$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
	
		$this->values = array();
		$where = " WHERE p.id_empresa=? and fp.id_forma_pagamento = p.id_forma_pagamento ";
		$this->values[]=$id_empresa;
		if($busca->busca<>""){
			$where .= " AND (p.id_pagamento = ? or p.descricao like ? or p.favorecido like ? ) ";
			$this->values[]=$busca->busca;
			$this->values[]=$busca->busca."%";
			$this->values[]=$busca->busca."%";
		}
		if($busca->id_departamento!=""){
			$where .= " AND p.id_departamento = ?";
			$this->values[]=$busca->id_departamento;
		}
		if($busca->id_forma_pagamento!=""){
			$where .= " AND p.id_forma_pagamento = ?";
			$this->values[]=$busca->id_forma_pagamento;
		}
		switch($busca->situacao){
			case 'À Pagar':
				$where .= " AND (p.valor_pg < (p.valor+p.vlr_multa-p.desconto) or p.valor_pg='0.00')";
			break;
			case 'Pagas':
				$where .= " AND p.valor_pg >= (p.valor+p.vlr_multa-p.desconto) ";
			break;
			case '':
				$where .= " ";
			break;
		}
		if($busca->data_i != ""){
			$where .= " AND p.dt_vencimento >= ? ";
			$this->values[]=$busca->data_i;
		}
		if($busca->data_f != ""){
			$where .= " AND p.dt_vencimento <= ? ";
			$this->values[]=$busca->data_f;
		}
		$this->sql = "SELECT count(0) as total, SUM(p.desconto) as desconto, SUM(p.vlr_multa) as vlr_multa, SUM(p.valor_pg) as valor_pg, SUM(p.valor) as valor ";

		$cond= "FROM vsites_fin_pagamento p
		LEFT JOIN vsites_departamento d ON d.id_departamento = p.id_departamento,
		vsites_forma_pagamento fp ".$where;
		$this->sql.=$cond;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		$this->link = $url_busca;
		$this->result = $cont;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT p.favorecido, p.desconto, p.fisico, p.vlr_multa, fp.forma_pagamento, p.valor_pg,p.id_pagamento,p.id_compra,p.descricao,p.data,p.id_forma_pagamento,p.parcela, p.qt_parcelas,d.departamento,p.valor, p.dt_vencimento $cond 
		ORDER BY p.dt_vencimento ";
		
		$_SESSION['pgto_sql']= $this->sql;
		$_SESSION['pgto_values']= $this->values;

		$this->sql .= " LIMIT ".$this->getInicio().", ".$this->maximo;
		
		return $this->fetch();
	}
	
	public function atualizar($p){
		$this->sql = 'UPDATE vsites_fin_pagamento SET id_holding=?, id_forma_pagamento=?,id_planoconta=?,
		id_banco=?,agencia=?,conta=?,id_conta=?,
		favorecido=?, valor=?,
		dt_vencimento=?,descricao=?,valor_pg=?,desconto=?,vlr_multa=?,cod_barras=?,dt_pagamento=?,
		valor_ir=?,valor_pis=?,valor_cofins=?,nota=?,id_regime=?,cnpj=?,fisico=?
		WHERE id_pagamento=? and id_empresa=?';

		$this->values = array($p->id_holding,$p->id_forma_pagamento,$p->id_planoconta,
		$p->id_banco,$p->agencia, $p->conta, $p->id_conta,
		$p->favorecido, $p->valor, 
		$p->dt_vencimento,$p->descricao,$p->valor_pg,$p->desconto,$p->vlr_multa,$p->cod_barras,$p->dt_pagamento,
		$p->valor_ir,$p->valor_pis,$p->valor_cofins,$p->nota,$p->id_regime,$p->cnpj,$p->fisico,
		$p->id_pagamento, $p->id_empresa);
		$this->exec();	
	}
		
	public function adicionarAnexo($anexo, $id_pagamento,$id_empresa){
		$this->table = 'vsites_fin_pagamento_anexo';
		$this->fields = array("id_empresa","id_pagamento","anexo");
		$this->values = array("id_empresa"=>$id_empresa,"id_pagamento"=>$id_pagamento,"anexo"=>$anexo);
		return $this->insert();		
	}

	public function BuscaAnexoPorID($id_pagamento_anexo,$id_pagamento,$id_empresa){
		$this->sql = 'SELECT * FROM vsites_fin_pagamento_anexo as pa where id_pagamento_anexo=? and id_pagamento=? and id_empresa=? limit 1';
		$this->values = array($id_pagamento_anexo,$id_pagamento,$id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}

	public function DeletaAnexo($id_pagamento_anexo,$id_pagamento,$id_empresa){
		$this->sql = 'delete FROM vsites_fin_pagamento_anexo where id_pagamento_anexo=? and id_pagamento=? and id_empresa=?';
		$this->values = array($id_pagamento_anexo,$id_pagamento,$id_empresa);
		return $this->exec();
	}

	public function deletaPagamento($id_pagamento,$id_empresa){
		$this->sql = 'delete FROM vsites_fin_pagamento where id_pagamento=? and id_empresa=?';
		$this->values = array($id_pagamento,$id_empresa);
		$done = $this->exec();

		$lista = $this->listaAnexo($id_pagamento,$id_empresa);
		foreach($lista as $l){
			if(file_exists($l->anexo))	unlink($l->anexo);
		}
		$this->sql = 'delete FROM vsites_fin_pagamento_anexo where id_pagamento=? and id_empresa=?';
		$this->values = array($id_pagamento,$id_empresa);
		$this->exec();
		return $done;
	}

	
	public function listaAnexo($id_pagamento,$id_empresa){
		$this->sql = 'SELECT * FROM vsites_fin_pagamento_anexo as pa where id_pagamento=? and id_empresa=?';
		$this->values = array($id_pagamento,$id_empresa);
		return $this->fetch();
	}

	public function listaHolding(){
		$this->sql = 'SELECT * FROM vsites_holding as h order by holding';
		$this->values = array();
		return $this->fetch();
	}
	
	public function result(){
		return $this->result[0];
	}
	
	public function execSession($sessao){
		$this->sql = $_SESSION[$sessao.'_sql'].' limit 3000';
		$this->values = $_SESSION[$sessao.'_values'];
		return $this->fetch();
	}
}