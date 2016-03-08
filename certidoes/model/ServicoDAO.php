<?php

class ServicoDAO extends Database{
	
	/**
	 * lista os campos de um serviчo ordenados
	 * @param int $id_servico
	 */
	public function listaCamposSite($id_servico){
		$this->sql = 'SELECT id_servico_campo,id_servico,campo,tipo,nome,obrigatorio FROM
					vsites_servico_campo as sc WHERE id_servico=? and site=1 ORDER BY ordenacao';
		$this->values = array($id_servico);
		return $this->fetch();
	}

	/**
	 * lista os serviчos ativos
	 */
	public function listaAtivos(){
		$this->sql = "SELECT * FROM vsites_servico as s WHERE status='Ativo' ORDER BY descricao";
		$this->values = array($id_departamento);
		return $this->fetch();
	}

	/**
	 * lista variacoes do servico para o site
	 * @param int $id_servico
	 */
	public function listaVariacao($id_servico){
		$this->sql = "SELECT * FROM vsites_servico_var as sv WHERE id_servico = '".$id_servico."' AND variacao not like '%urgente%' and variacao not like '%custas%' ORDER BY variacao";
		$this->values = array($id_servico);
		return $this->fetch();
	}
	
	/**
	 * verifica se a variacao щ vсlida
	 */
	public function verificaServicoVar($id_servico_var){
		$this->sql = "SELECT (1) as total, sv.variacao, sv.id_servico_var FROM vsites_servico_var as sv WHERE sv.id_servico_var=? limit 1";
		$this->values = array($id_servico_var);
		$cont = $this->fetch();
		return $cont[0];
	}

	/**
	 * lista os estados
	 */
	public function listaEstados(){
		$this->sql = "SELECT id_estado,estado FROM vsites_estado as e ORDER BY estado";
		$this->values = array();
		return $this->fetch();
	}

	/**
	 * lista as cidades
	 */
        public function listaCidades($estado){
		$this->sql = "SELECT id_cidade,cidade,estado FROM vsites_cidades as c where estado=? ORDER BY cidade";
		$this->values = array($estado);
		return $this->fetch();
	}

	public function listaBairros($estado,$cidade){
		$this->sql = "SELECT id_bairro,bairro FROM vsites_bairro as c where estado=? and cidade=? ORDER BY cidade";
		$this->values = array($estado,$cidade);
		return $this->fetch();
	}

	public function listaBairrosFranquia($estado,$cidade){
		$this->sql = "SELECT ue.bairro, fr.apelido FROM vsites_franquia_regiao as fr, vsites_user_empresa as ue where fr.estado=? and fr.cidade=? and fr.id_empresa=ue.id_empresa AND ue.status in ('Ativo', 'Renovaчуo') ORDER BY ue.id_empresa";
		$this->values = array($estado,$cidade);
		return $this->fetch();
	}

        public function listaRegiaoNorte($estado){
		$this->sql = "SELECT id_cidade,cidade,estado FROM vsites_cidades as c where c.estado in('AC','AM','AP','RO','RR','PA','TO') GROUP BY c.estado ORDER BY estado ASC";
		$this->values = array($estado);
		return $this->fetch();
	}
        
         public function listaRegiaoNordeste($estado){
		$this->sql = "SELECT id_cidade,cidade,estado FROM vsites_cidades as c where c.estado in('MA','PI','CE','RN','PB','PE','AL','SE','BA') GROUP BY c.estado ORDER BY estado ASC";
		$this->values = array($estado);
		return $this->fetch();
	}
        
         public function listaRegiaoCentroOeste($estado){
		$this->sql = "SELECT id_cidade,cidade,estado FROM vsites_cidades as c where c.estado in('MT','GO','DF','MS') GROUP BY c.estado ORDER BY estado ASC";
		$this->values = array($estado);
		return $this->fetch();
	}
        
        public function listaRegiaoSudeste($estado){
		$this->sql = "SELECT id_cidade,cidade,estado FROM vsites_cidades as c where c.estado in('SP','MG','RJ','ES') GROUP BY c.estado ORDER BY estado ASC";
		$this->values = array($estado);
		return $this->fetch();
	}
        
        public function listaRegiaoSul($estado){
		$this->sql = "SELECT id_cidade,cidade,estado FROM vsites_cidades as c where c.estado in('PR','SC','RS') GROUP BY c.estado ORDER BY estado ASC";
		$this->values = array($estado);
		return $this->fetch();
	}
	
	public function listaExterior($estado){
		$this->sql = "SELECT id_cidade,cidade,estado FROM vsites_cidades as c where c.estado not in('AC','AM','AP','RO','RR','PA','TO','MA','PI','CE','RN','PB','PE','AL','SE','BA','MT','GO','DF','MS','SP','MG','RJ','ES','PR','SC','RS') GROUP BY c.estado ORDER BY estado ASC";
		$this->values = array($estado);
		return $this->fetch();
	}
}

?>