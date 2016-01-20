<?php

class ServicoDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_servico';
	}

	/**
	 * retorna uma lista de serviços, por empresa
	 * departament,alguma string para busca e página
	 *
	 * @param int $controle_id_empresa
	 * @param int $id_departamento
	 * @param String $busca
	 * @param int $pagina
	 */
	public function busca($controle_id_empresa,$id_departamento='', $busca='',$id_servico='', $pagina=1){
		$this->values = array();
		$where = " WHERE
					s.status = 'Ativo' AND
					s.id_servico = sv.id_servico  AND
					s.id_departamento = sd.id_servico_departamento AND"; 
		if($id_departamento!=''){
			$where.=" sd.id_servico_departamento=? AND ";
			$this->values[] = $id_departamento;
		}
		if($id_servico!=''){
			$where.=" s.id_servico = ? AND ";
			$this->values[]=$id_servico;
		}
		if($busca!=""){
			$where.=" (sv.variacao like ? or s.descricao like ? or s.status like ?)";
			$this->values[]=''.$busca.'%';
			$this->values[]=''.$busca.'%';
			$this->values[]=''.$busca.'%';
		}
		$where.=" 1=1 ORDER BY s.descricao, sv.variacao ASC";
		$this->sql = "SELECT count(0) as total FROM vsites_servico as s, vsites_servico_var as sv, vsites_servico_departamento as sd ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$this->link = 'busca='.$busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT s.*,sv.valor_$controle_id_empresa as valor, sv.dias_$controle_id_empresa as dias, sv.id_servico_var, sv.variacao, sd.departamento
						FROM 
					vsites_servico as s, vsites_servico_var as sv, vsites_servico_departamento as sd ".$where
		." LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}

	/**
	 * lista os serviços de um departamento
	 * @param int $id_departamento
	 */
	public function listaPorDepartamento($id_departamento=null){
		if($id_departamento!=null){
			$cachediaCLASS = new CacheDiaCLASS();
			$filename = 'ServicoDAO-listaPorDepartamento-'.$id_departamento.'.csv';
			
			if(!$cachediaCLASS->VerificaCache($filename)){
				$this->sql = "SELECT id_servico, dias, status, descricao, id_departamento, site, franqueadora FROM vsites_servico WHERE id_departamento = ? AND status='Ativo' ORDER BY descricao";
				$this->values = array($id_departamento);
				$ret = $this->fetch();
				$campos = "id_servico;dias;status;descricao;id_departamento;site;franqueadora";
				$geracsv = $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
			} else {
				$ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
			}
			return $ret;
		}else
		return array();
	}

	public function inserir($s){
		$this->table = 'vsites_servico';
		$this->fields = array('id_departamento','status','site','descricao');
		$this->values = array('id_departamento'=>$s->id_departamento
		,'status'=>$s->status
		,'site'=>$s->site
		,'descricao'=>$s->descricao);
		$s->id_servico = $this->insert();

		$this->table = 'vsites_servico_campo';
		$this->fields = array('id_servico',
								'campo','nome',
								'tipo','largura',
								'site','ordenacao');
		foreach($s->campos as $campo){
			$campo->id_servico=$s->id_servico;
			$this->values = array('id_servico'=>$campo->id_servico,
									'campo'=>$campo->campo,'nome'=>$campo->nome,
									'tipo'=>$campo->tipo,'largura'=>$campo->largura,
									'site'=>$campo->site,'ordenacao'=>$campo->ordenacao);
			$campo->id = $this->insert();
		}
	}

	/**
	 * lista os campos de um serviço ordenados
	 * @param int $id_servico
	 */
	public function listaCampos($id_servico){
		$this->sql = 'SELECT id_servico_campo,id_servico,campo,tipo,nome,obrigatorio FROM
					vsites_servico_campo as sc WHERE id_servico=? ORDER BY ordenacao';
		$this->values = array($id_servico);
		return $this->fetch();
	}

	/**
	 * lista os serviços ativos
	 */
	public function listaAtivos(){
		$cachediaCLASS = new CacheDiaCLASS();
		$filename = 'ServicoDAO-listaAtivos.csv';
		$verifica = $cachediaCLASS->VerificaCache($filename);
		
		if($verifica==false) {
			$this->sql = "SELECT * FROM vsites_servico as s WHERE status='Ativo' ORDER BY descricao";
			$this->values = array();
			$ret = $this->fetch();
			$campos = "id_servico;descricao";
			$geracsv = $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);		
		} else {
			$ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
		}
		return $ret;
	}

	/**
	 * lista todos os serviços
	 */
	public function lista(){
		$cachediaCLASS = new CacheDiaCLASS();
		$filename = 'ServicoDAO-lista.csv';
		$verifica = $cachediaCLASS->VerificaCache($filename);
		
		if($verifica==false) {
			$this->sql = "SELECT descricao, id_servico from vsites_servico as s order by descricao";
			$this->values = array();
			$ret = $this->fetch();
			$campos = "id_servico;descricao";
			$geracsv = $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);		
		} else {
			$ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
		}
		return $ret;
	}

	/**
	 * lista variacoes do servico
	 * @param int $id_servico
	 */
	public function listaVariacao($id_servico){
		$this->sql = "SELECT * FROM vsites_servico_var as sv WHERE id_servico =? order by variacao";
		$this->values = array($id_servico);
		return $this->fetch();
	}

	/**
	 * verifica se avariacao é válida
	 */
	public function verificaServicoVar($id_servico_var){
		$this->sql = "SELECT COUNT(0) as total FROM vsites_servico_var as sv WHERE sv.id_servico_var=? ";
		$this->values = array($id_servico_var);
		$cont = $this->fetch();
		return $cont[0];
	}

	/**
	 * lista os estados
	 */
	public function listaEstados(){
		$cachediaCLASS = new CacheDiaCLASS();
		$filename = 'ServicoDAO-Estados.csv';
		$verifica = $cachediaCLASS->VerificaCache($filename);
		
		if($verifica==false) {
			$this->sql = "SELECT * FROM vsites_estado as e ORDER BY estado";
			$this->values = array();
			$ret = $this->fetch();
			$campos = "id_estado;estado";
			$geracsv = $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);		
		} else {
			$ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
		}
		return $ret;
	}

	/**
	 * lista as cidades
	 */
	public function listaCidades($estado){
		$cachediaCLASS = new CacheDiaCLASS();
		$filename = 'ServicoDAO-Cidade'.$estado.'.csv';
		$verifica = $cachediaCLASS->VerificaCache($filename);
		
		if($verifica==false) {
			$this->sql = "SELECT * FROM vsites_cidades as c where estado=? ORDER BY cidade";
			$this->values = array($estado);
			$ret = $this->fetch();
			$campos = "id_cidade;cidade;estado";
			$geracsv = $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);		
		} else {
			$ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
		}
		return $ret;
	}

	public function selectPorId($id_servico){
		$this->sql = "SELECT id_servico,descricao from vsites_servico as s where id_servico=? order by descricao";
		$this->values = array($id_servico);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	#Atualizado 11/05/2011 - Rafael
	public function carregarCombo(){
		$this->sql = "SELECT descricao, id_servico FROM vsites_servico as s ORDER BY descricao";
		$this->values = array();
		$ret = $this->fetch();
		return $ret;
	}
}

?>