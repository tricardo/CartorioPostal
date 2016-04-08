<?php

class CartorioDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_cartorio';
	}

	/**
	 * lista as atribuições de cartórios
	 */
	public function listaAtribuicoes(){
		$this->sql = 'SELECT * from vsites_cartorio_atribuicoes as ca order by atribuicao';
		$this->values = array();

                $cachediaCLASS = new CacheDiaCLASS();
                $filename = 'CartorioDAO-listarAtribuicoes.csv';
                if(!$cachediaCLASS->VerificaCache($filename)){
                    $ret = $this->fetch();
                    $campos = "id_atribuicao;atribuicao";
                    $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
                } else {
                    $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
                }
                return $ret;
	}

	/**
	 * lista os estados que tem registro na tabela cartório
	 */
	public function listaEstados(){
		$this->sql = "SELECT distinct estado from vsites_cartorio as c where estado!='' order by estado";
		$this->values = array();
                
                $cachediaCLASS = new CacheDiaCLASS();
                $filename = 'CartorioDAO-listarEstados.csv';
                if(!$cachediaCLASS->VerificaCache($filename)){
                    $ret = $this->fetch();
                    $campos = "estado";
                    $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
                } else {
                    $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
                }
                return $ret;
	}

	/**
	 * busca os cartórios pela atribuição, estado e cidade
	 * @param int $atribuicao
	 * @param String $estado
	 * @param String $cidade
	 * @param int $pagina
	 */
	public function buscar($atribuicao,$estado,$cidade,$pagina=1){
		$this->values = array();
		$where = " WHERE 1=1 ";
		if($estado<>''){$where .= " and c.estado=?"; $this->values[]=$estado;}
		if($cidade<>''){$where .= " and c.cidade=?"; $this->values[]=$cidade; }
		if($atribuicao<>''){$where .= " and c.atribuicao=?"; $this->values[] = $atribuicao; }
			

		$this->sql = "SELECT count(0) as total
						FROM vsites_cartorio as c ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;


		$url_busca = '';
                $url_busca.= strlen($estado) > 0 ? 'estado='.$estado.'&' : '';
                $url_busca.= strlen($cidade) > 0 ? 'cidade='.$cidade.'&' : '';
                $url_busca.= strlen($atribuicao) > 0 ? 'atribuicao='.$atribuicao : '';
		$this->link = $url_busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$where.=" ORDER BY c.nome ASC";
		$this->sql = "SELECT c.*, ca.atribuicao as atrib FROM
						vsites_cartorio as c 
						LEFT JOIN vsites_cartorio_atribuicoes as ca ON ca.id_atribuicao=c.atribuicao ".$where
		." LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}

	/**
	 * insere um registro na tabela de cartório
	 * @param unknown_type $c
	 */
	public function inserir($c){
		$this->fields = array('nome','fantasia','tipo','cpf',
							'rg','endereco','numero','complemento',
							'bairro','cidade','estado','cep',
							'distrito','comarca','contato','tel',
							'ramal','cel','fax','email',
							'site','id_banco','cod_banco','agencia',
							'conta','favorecido','data','atualizacao',
							'status','tel2','ramal2','obs',
							'valor_busca','valor_certidao','atribuicao',);
		$this->values  = array('nome'=>$c->nome,'fantasia'=>$c->fantasia,'tipo'=>$c->tipo,'cpf'=>$c->cpf,
								'rg'=>$c->rg,'endereco'=>$c->endereco,'numero'=>$c->numero,'complemento'=>$c->complemento,
								'bairro'=>$c->bairro,'cidade'=>$c->cidade,'estado'=>$c->estado,'cep'=>$c->cep,
								'distrito'=>$c->distrito,'comarca'=>$c->comarca,'contato'=>$c->contato,'tel'=>$c->tel,
								'ramal'=>$c->ramal,'cel'=>$c->cel,'fax'=>$c->fax,'email'=>$c->email,
								'site'=>$c->site,'id_banco'=>$c->id_banco,'cod_banco'=>$c->cod_banco,'agencia'=>$c->agencia,
								'conta'=>$c->conta,'favorecido'=>$c->favorecido,'data'=>date('Y-m-d H:i:s'),'atualizacao'=>date('Y-m-d H:i:s'),
								'status'=>$c->status,'tel2'=>$c->tel2,'ramal2'=>$c->ramal2,'obs'=>$c->obs,
								'valor_busca'=>$c->valor_busca,'valor_certidao'=>$c->valor_certidao,'atribuicao'=>$c->atribuicao,'distrito'=>$c->distrito);
		return $this->insert();
	}

	public function atualizar($c){
		$this->sql = "UPDATE vsites_cartorio
					SET nome=?, fantasia=?, tipo=?, cpf=?,
					rg=?, endereco=?, numero=?, complemento=?,
					bairro=?,cidade=?,estado=?,cep=?,
					distrito=?, comarca=?, contato=?,tel=?,
					ramal=?,cel=?,fax=?,email=?,
					site=?,id_banco=?,cod_banco=?,agencia=?,
					conta=?,favorecido=?,atualizacao=?,
					status=?,tel2=?,ramal2=?,obs=?,
					valor_busca=?,valor_certidao=?,atribuicao=?,distrito=?,id_banco=?,
					id_usuario_edit=?, ftipo=?, id_empresa=?
					WHERE id_cartorio=?";
		$this->values  = array($c->nome,$c->fantasia,$c->tipo,$c->cpf,
		$c->rg,$c->endereco,$c->numero,$c->complemento,
		$c->id_banco,$c->cidade,$c->estado,$c->cep,
		$c->distrito,$c->comarca,$c->contato,$c->tel,
		$c->ramal,$c->cel,$c->fax,$c->email,
		$c->site,$c->banco,$c->cod_banco,$c->agencia,
		$c->conta,$c->favorecido,date('Y-m-d H:i:s'),
		$c->status,$c->tel2,$c->ramal2,$c->obs,
		$c->valor_busca,$c->valor_certidao,$c->atribuicao,$c->distrito,$c->id_banco,
		$c->id_usuario_edit, $c->ftipo, $c->id_franquia, $c->id_cartorio);
		$this->exec();
	}

	/**
	 * seleciona um registro do cartório
	 * @param int $id
	 */
	public function selectPorId($id){
		$this->sql = "SELECT * FROM ".$this->table.' WHERE id_cartorio = ?';
		$this->values = array($id);
		$return = $this->fetch();
		return $return[0];
	}
        
        public function selectPorIdEmpresa($id,$empresa){
		$this->sql = "SELECT * FROM ".$this->table.' WHERE id_cartorio = ? AND (id_empresa = ? OR id_empresa = 0)';
		$this->values = array($id, $empresa);
		$return = $this->fetch();
		return count($return) > 0 ? $return[0] : array();
	}
	
	public function selectPorIdPedidoItem($id_pedido_item){
		$this->sql = "SELECT c.* from vsites_cartorio as c, vsites_pedido_cartorio as pc 
			where c.id_cartorio = pc.cartorio_cartorio and pc.id_pedido_item=? and pc.desconsiderar!='Sim'";
		$this->values = array($id_pedido_item);
		$return = $this->fetch();
		return $return[0];		
	}
        
	public function selectCartorio2Via($busca_cartorios_itens){
		$this->sql = "SELECT distinct pc.cartorio_cartorio, c.nome from
			vsites_pedido_cartorio as pc, vsites_cartorio_atribuicoes as ca, vsites_cartorio as c where
   			pc.desconsiderar='' and
			pc.cartorio_atribuicao = ca.id_atribuicao and
			pc.cartorio_cartorio = c.id_cartorio
                        " . $busca_cartorios_itens . "
			order by pc.id_pedido_cartorio desc";
		$this->values = array();
		return $this->fetch();
	}        
        
        public function carregar_cartorio_cidade($atribuicao = '', $estado = ''){
            global $controle_id_empresa;
            $cachediaCLASS = new CacheDiaCLASS();
            $filename = 'CartorioDAO-carregar-cartorio-cidade-'.$controle_id_empresa.'-'.$estado;
            $filename .= strlen($atribuicao) > 0 ? '-'.$atribuicao : '';
            $filename .= '.csv';
            #if(!$cachediaCLASS->VerificaCache($filename)){
                $this->sql = "SELECT distinct c.cidade AS cidade FROM vsites_cartorio as c WHERE c.estado = ? order by c.cidade";
                $this->values = array($estado);
                if(strlen($atribuicao) > 0){
                    $this->sql .= " and atribuicao = ? and status='Ativo'";    
                    $this->values[] = $atribuicao;
                }
                $ret = $this->fetch();
	#	$campos = "cidade";
	#	$cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
        #    } else {
        #        $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        #    }
            return $ret;
        }
}

?>