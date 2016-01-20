<?php

class ServicoDAO extends Database{

	public function listar(){
		$this->sql = 'SELECT s.*,d.departamento FROM vsites_servico s
						LEFT JOIN vsites_servico_departamento d ON s.id_departamento=d.id_servico_departamento
						ORDER BY departamento,descricao';
		$this->values = array();
		return $this->fetch('Servico');
	}

	/**
	 * retorna uma lista com os departamentos com servi�os
	 */
	public function listarDepartamentos(){
		$this->sql = "SELECT * from vsites_servico_departamento as sd where ordem='Sim' order by departamento";
		$this->values = array();
		return $this->fetch();
	}

	/**
	 * lista os servi�os de um departamento
	 * @param int $id_departamento
	 */
	public function listaPorDepartamento($id_departamento=null){
		if($id_departamento!=null){
			$this->sql = "SELECT * FROM vsites_servico WHERE id_departamento = ? AND status='Ativo' ORDER BY descricao";
			$this->values = array($id_departamento);
			return $this->fetch('Servico');
		}else
		return array();
	}

	public function inserir(Servico $s){
		$this->table = 'vsites_servico';
		$this->fields = array('id_departamento','status','site','descricao','desc_site','servico_desc','site_menu');
		$this->values = array('id_departamento'=>$s->id_departamento
		,'status'=>$s->status
		,'site'=>$s->site
		,'descricao'=>$s->descricao
		,'desc_site'=>$s->desc_site
		,'servico_desc'=>$s->servico_desc
		,'site_menu'=>$s->site_menu);
		$s->id_servico = $this->insert();

		foreach($s->campos as $campo){
			$campo->id_servico=$s->id_servico;
			$this->inserirCampo($campo);
		}
		return $s->id_servico;
	}

	public function inserirCampo($campo){
		$this->table = 'vsites_servico_campo';
		$this->fields = array('id_servico',
								'campo','nome',
								'tipo','largura',
								'site','ordenacao');
		$this->values = array('id_servico'=>$campo->id_servico,
									'campo'=>$campo->campo,'nome'=>$campo->nome,
									'tipo'=>$campo->tipo,'largura'=>$campo->largura,
									'site'=>$campo->site,'ordenacao'=>$campo->ordenacao);
		$campo->id = $this->insert();
	}

	public function atualizar(Servico $s){
		$this->sql = 'UPDATE vsites_servico SET dias=?, status=?, descricao=?, site=?,desc_site=?,servico_desc=?,site_menu=? WHERE id_servico=?';
		$this->values = array($s->dias,$s->status,$s->descricao,$s->site,$s->desc_site,$s->servico_desc,$s->site_menu,$s->id_servico);
		$this->exec();
		$this->log();
		foreach($s->campos as $campo){
			if($campo->id_servico_campo!=''){
				$this->sql = 'UPDATE vsites_servico_campo SET campo=?,tipo=?,nome=?,valor=?,largura=?,mascara=?,site=?,ordenacao=?,obrigatorio=?
						WHERE id_servico_campo=?';
				$this->values = array($campo->campo,$campo->tipo,$campo->nome,
				$campo->valor,$campo->largura,$campo->mascara,
				$campo->site,$campo->ordenacao,$campo->obrigatorio,$campo->id_servico_campo);
				$this->exec();
				$this->log();
			}else{
				$this->inserirCampo($campo);
			}
		}

		$this->sql = 'DELETE FROM vsites_servico_campo WHERE id_servico_campo = ? AND id_servico=?';
		foreach($s->remCampos as $campo){
			$this->values = array($campo,$s->id_servico);
			$this->exec();
			$this->log();
		}
	}

	/**
	 * lista os campos de um servi�o ordenados
	 * @param int $id_servico
	 */
	public function listarCamposPorServico($id_servico){
		$this->sql = 'SELECT * FROM
					vsites_servico_campo WHERE id_servico=? ORDER BY ordenacao';
		$this->values = array($id_servico);
		return $this->fetch();
	}
	
	/**
	 * lista os campos de um serviço para atualização da ordem estado/cidade
	 * @param int $id_servico
	 */
	public function listarCamposUF($id_servico){
		$this->sql = 'SELECT id_servico_campo,campo,ordenacao FROM
					vsites_servico_campo WHERE id_servico=? 
					and (campo=? or campo=?)
					ORDER BY campo DESC';
		$this->values = array($id_servico,'certidao_cidade','certidao_estado');
		return $this->fetch();
	}

	public function atzOrdenacao($campo){
		$this->sql = 'UPDATE vsites_servico_campo SET ordenacao=? WHERE id_servico_campo=?';
		$this->values = array($campo->ordenacao,$campo->id_servico_campo);
		$this->exec();
	}
	
	public function listarCampos(){
		$this->sql = "SHOW COLUMNS FROM vsites_pedido_item where
						Field <> 'id_pedido_item' AND
						Field <> 'id_usuario_op' AND
						Field <> 'id_usuario_op2' AND
						Field <> 'id_empresa_resp' AND
						Field <> 'id_pedido' AND
						Field <> 'ordem_a' AND
						Field <> 'id_pedido_a' AND
						Field <> 'data' AND
						Field <> 'atendimento' AND
						Field <> 'inicio' AND
						Field <> 'encerramento' AND
						Field <> 'operacional' AND
						Field <> 'id_usuario' AND
						Field <> 'id_servico' AND
						Field <> 'id_usuario_var' AND
						Field <> 'id_servico_var' AND
						Field <> 'id_servico_departamento' AND
						Field <> 'id_atividade' AND
						Field <> 'id_status' AND
						Field <> 'data_i' AND
						Field <> 'status_hora' AND
						Field <> 'valor' AND
						Field <> 'dias' AND
						Field <> 'data_atividade' AND
						Field <> 'data_status' AND
						Field <> 'obs' AND
						Field <> 'ordem'";
		$this->values = array();
		return $this->fetch();
	}

	/**
	 * busca um seriço pelo id, e retorna com seus campos
	 * @param int $id_servico
	 */
	public function selectPorId($id_servico){
		$this->sql = 'SELECT * From vsites_servico WHERE id_servico=?';
		$this->values = array($id_servico);
		$servico = $this->fetch();
		$servico = $servico[0];
		$servico->campos = $this->listarCamposPorServico($id_servico);
		return $servico;
	}
}

?>