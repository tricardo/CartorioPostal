<?php

class ServicoDAO extends Database{
	
	/**
	 * lista os campos de um serviço ordenados
	 * @param int $id_servico
	 */
	public function listaCamposSite($id_servico){
		$this->sql = 'SELECT id_servico_campo,id_servico,campo,tipo,nome,obrigatorio FROM
					vsites_servico_campo as sc WHERE id_servico=? and site=1 ORDER BY ordenacao';
		$this->values = array($id_servico);
		return $this->fetch();
	}

	/**
	 * lista os serviços ativos
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
	 * verifica se a variacao é válida
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
	
}

?>