<?php
class PedidoDAO extends Database{
	
	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_pedido';
	}


	/**
	 * verifica cadastro do cliente e da insert caso negativo
	 * @param array $p
	 */
	public function verificaCliente($p){	
	
		$this->sql = "SELECT count(0) as total from vsites_user_cliente as uc where cpf=?";
		$this->values = array($p->cpf);

		$cont = $this->fetch();
		$total = $cont[0]->total;
		
		if($total=='0' and $p->id_cliente==''){
			$clienteDAO = new ClienteDAO();
			$p->status='Ativo';
			$p->conveniado='Não';
			$p->site='';
			$p->im='';
			$p->id_usuario_com='';
			$clienteDAO->inserir($p);
			return '<br><br>Usuário Adicionado como cliente<br><br>';
		}
		
		return '';
	}
		
	/**
	* insere um pedido e pedido no BD
	* @param unknown_type $p
	*/
	public function inserir($p){
		$p->data = date('Y-m-d H:m:s'); 
		
		$this->fields = array('id_pacote','retirada','nome','id_conveniado',
							'id_ponto','email','cpf','rg',
							'tipo','cidade','data','pagamento',
							'id_usuario','origem','endereco',
							'numero','complemento','bairro','cep',
							'estado','tel','tel2','ramal',
							'ramal2','fax','outros','retem_iss',
							'restricao','forma_pagamento','dados_bancarios',
							'omesmo','endereco_f','numero_f','complemento_f',
							'bairro_f','cep_f','estado_f','cidade_f','id_afiliado','site','ip');
		$this->values = array('id_pacote'=>$p->id_pacote,'retirada'=>$p->retirada,'nome'=>$p->nome,'id_conveniado'=>$p->id_conveniado
						,'id_ponto'=>$p->id_ponto,'email'=>$p->email,'cpf'=>$p->cpf,'rg'=>$p->rg
						,'tipo'=>$p->tipo,'cidade'=>$p->cidade,'data'=>$p->data,'pagamento'=>$p->pagamento
						,'id_usuario'=>$p->id_usuario,'origem'=>$p->origem,'endereco'=>$p->endereco
						,'numero'=>$p->numero,'complemento'=>$p->complemento,'bairro'=>$p->bairro,'cep'=>$p->cep
						,'estado'=>$p->estado,'tel'=>$p->tel,'tel2'=>$p->tel2,'ramal'=>$p->ramal
						,'ramal2'=>$p->ramal2,'fax'=>$p->fax,'outros'=>$p->outros,'retem_iss'=>$p->retem_iss
						,'restricao'=>$p->restricao,'forma_pagamento'=>$p->forma_pagamento,'dados_bancarios'=>$p->dados_bancarios
						,'omesmo'=>$p->omesmo,'endereco_f'=>$p->endereco_f,'numero_f'=>$p->numero_f,'complemento_f'=>$p->complemento_f
						,'bairro_f'=>$p->bairro_f,'cep_f'=>$p->cep_f,'estado_f'=>$p->estado_f,'cidade_f'=>$p->cidade_f,'id_afiliado'=>$p->id_afiliado,'site'=>1,'ip'=>$p->ip);
		$id_pedido = $this->insert();

		$ordem = $this->inserir_item($p,$id_pedido);
		return '#'.$id_pedido.'/'.$ordem;
	}

	/**
	* insere um pedido, pedido_item e pedido_status no BD
	* @param unknown_type $p
	* @param int $id_pedido
	*/
	public function inserir_item($p,$id_pedido){
		
		unset($this->fields);
		unset($this->values);
		$this->table = 'vsites_pedido_item';
 
		$data = date('Y-m-d H:m:s'); 
		$servicosDAO = new ServicoDAO();
		$servicocampos = $servicosDAO->listaCamposSite($p->id_servico);

		#gera o numero da ordem
		$contaordem = $this->contaOrdens($id_pedido);
		$ordem = (int)($contaordem->total)+1;
		
		
		$this->fields = array();
		$this->values = array();
		$this->fields[]='controle_cliente';
		$this->fields[]='data_atividade';
		$this->fields[]='id_atividade';
		$this->fields[]='id_status';
		$this->fields[]='urgente';
		$this->fields[]='ordem';
		$this->fields[]='id_pedido';
		$this->fields[]='data';
		$this->fields[]='id_usuario';
		$this->fields[]='id_servico';
		$this->fields[]='valor';
		$this->fields[]='dias';
		$this->fields[]='obs';
		$this->fields[]='id_servico_var';
		$this->fields[]='id_servico_departamento';
		$this->fields[]='duplicidade';
		
		$this->values['controle_cliente']=$p->controle_cliente;
		$this->values['data_atividade']=$data;
		$this->values['id_atividade']='0';
		$this->values['id_status']='0';
		$this->values['urgente']=$p->urgente;
		$this->values['ordem']=$ordem;
		$this->values['id_pedido']=$id_pedido;
		$this->values['data']=$data;
		$this->values['id_usuario']=$p->id_usuario;
		$this->values['id_servico']=$p->id_servico;
		$this->values['valor']=$p->valor;
		$this->values['dias']=$p->dias;
		$this->values['obs']=$p->obs;
		$this->values['id_servico_var']=$p->id_servico_var;
		$this->values['id_servico_departamento']=$p->id_servico_departamento;
		$this->values['duplicidade']=$p->duplicidade;

		foreach($servicocampos as $servicocampo){
			$this->fields[]=$servicocampo->campo;
			$this->values[$servicocampo->campo]=$p->{$servicocampo->campo};
		}
		
		$id_pedido_item = $this->insert();

		$atividadeDAO = new AtividadeDAO();
		$atividade = $atividadeDAO->inserir('172','',$p->id_usuario,$id_pedido_item);
		return $ordem;
	}	

	/**
	* contabiliza a quantidade de servicos no pedido
	* @param int $id_pedido
	*/
	
	public function contaOrdens($id_pedido){
		$this->sql = "SELECT COUNT(0) as total, SUM(valor) as valor from vsites_pedido_item as pi where id_pedido=?";
		$this->values = array($id_pedido);
		$cont = $this->fetch();
		return $cont[0];
	}

	

	/**
	* Verifica a empresa que atende a região
	* @param String $cep
	*/
	public function selectEmpresaCEP($cep){
		$this->sql = "SELECT ue.id_empresa, uu.id_usuario from vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_franquia_regiao as fr where replace(fr.cep_i,'-','') <= replace('".$cep."','-','') and replace(fr.cep_f,'-','') >= replace('".$cep."','-','') and fr.id_empresa=ue.id_empresa and ue.status='Ativo' and ue.id_empresa = uu.id_empresa and uu.departamento_s like '6,%'";
		$ret = $this->fetch();
		return $ret[0];
	}

	/**
	* Verifica departamento responsavel
	* @param int $id_servico
	*/
	public function selectDepartamentoResp($id_servico_var){
		$this->sql = "SELECT sv.*, s.id_departamento from vsites_servico_var as sv, vsites_servico as s where sv.id_servico_var=? and sv.id_servico=s.id_servico";
		$this->values = array($id_servico_var);
		$ret = $this->fetch();
		return $ret[0];
	}

	/**
	* Lista serviços
	*/
	public function selectServicosSite(){
		$this->sql = "SELECT s.id_servico, s.descricao, desc_site, s.servico_desc FROM vsites_servico as s WHERE s.status='Ativo' and site = '1' ORDER BY s.desc_site, s.descricao";
		return $this->fetch();
	}

	/**
	* Lista serviços menu
	*/
	public function selectServicosSiteMenu(){
		$this->sql = "SELECT s.id_servico, s.descricao, s.desc_site FROM vsites_servico as s WHERE s.status='Ativo' and site = 1 and site_menu=1 ORDER BY s.desc_site, s.descricao";
		return $this->fetch();
	}

	/**
	* Lista estados
	*/
	public function selectEstados(){
		$this->sql = "SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado";
		return $this->fetch();
	}
	
}
?>