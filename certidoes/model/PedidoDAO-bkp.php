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
		
		# se for de uma região com direcionamento proporcional
		if($p->id_usuario==1 and str_replace('Ã','a',str_replace('ã','a',strtolower($p->cidade)))=='sao paulo' and ($p->estado=='SP' or $p->estado=='') and $p->id_afiliado==''){
			//$apigoogleDAO = new ApiGoogleDAO();
			$localizacao = $this->verificaRegiao($p);

			if($localizacao->id_usuario<>''){
				$p->id_usuario = $localizacao->id_usuario;
				$p->id_empresa_atend = $localizacao->id_empresa;
			}
		}
		$_SESSION['p_id_empresa_atend']=$p->id_empresa_atend;
		$_SESSION['p_id_usuario']=$p->id_usuario;		
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
		
		#07/08/2013 - RAFAEL
		#pega o numero do id_empresa_id
		#pega o id empresa cdt
		$id_empresa_dir = 0;
		if(isset($p->certidao_cidade) && isset($p->certidao_estado)){
			if(strlen($p->certidao_cidade) > 0 && strlen($p->certidao_estado) > 0){
				$id_empresa_dir = $this->listaCDT($p->certidao_cidade, $p->certidao_estado, $id_pedido, $p->id_empresa_atend);
				$id_empresa_dir = ($id_empresa_dir == '') ? 0 : $id_empresa_dir;
			}
		}
		#07/08/2013 - RAFAEL
		
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
		$this->fields[]='id_empresa_atend';
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
		$this->values['id_empresa_atend']=$p->id_empresa_atend;
		$this->values['id_servico']=$p->id_servico;
		$this->values['valor']=((int)$p->valor<>0)?$p->valor:'100.00';
		$this->values['dias']=((int)$p->valor<>0)?$p->dias:'10';
		$this->values['obs']=$p->obs;
		$this->values['id_servico_var']=$p->id_servico_var;
		$this->values['id_servico_departamento']=$p->id_servico_departamento;
		$this->values['duplicidade']=$p->duplicidade;

		foreach($servicocampos as $servicocampo){
			$this->fields[]=$servicocampo->campo;
			$this->values[$servicocampo->campo]=$p->{$servicocampo->campo};
		}
		
		#07/08/2013 - RAFAEL
		$this->fields[]='id_empresa_dir';
		$this->values['id_empresa_dir']=$id_empresa_dir;
		#07/08/2013 - RAFAEL
		
		$id_pedido_item = $this->insert();

        $this->table = 'vsites_pedido_fin';

        $this->fields = array();
        $this->values = array();
        $this->fields[] = 'id_pedido_item';
        $this->fields[] = 'id_pedido';
        $this->fields[] = 'ordem';

        $this->values['id_pedido_item'] = $id_pedido_item;
        $this->values['id_pedido'] = $id_pedido;
        $this->values['ordem'] = $ordem;
        $this->insert();

		
		$atividadeDAO = new AtividadeDAO();
		$atividade = $atividadeDAO->inserir('172','',$p->id_usuario,$id_pedido_item);
		return $ordem;
	}	
	
	
	/**
     * verifica vez do CDT
     * @param int $id_empresa
     * cópia da função em PedidoDAO.php do Sistema
     */
    public function listaCDT($cidade, $estado, $id_pedido, $id_empresa) {
        $cidade = strtolower(trim($cidade));
        $estado = strtolower(trim($estado));
        $empresaDAO = new EmpresaDAO();
        $emp = $empresaDAO->selectPorId($id_empresa);

        $emp->cidade = strtolower(trim($emp->cidade));
        $emp->estado = strtolower(trim($emp->estado));

        if ($emp->cidade == $cidade and $emp->estado == $estado or $emp->cidade == 'são paulo' and $emp->estado == 'sp' and ($cidade == 'são paulo' or $cidade == 'sao paulo')) {
            return $id_empresa;
        }

        #verifica se algum pedido da ordem já foi direcionado
        $this->sql = "SELECT pi.id_empresa_dir
						FROM vsites_pedido_item as pi
						WHERE pi.id_pedido=? and pi.id_empresa_dir!=0 and pi.certidao_cidade = ? AND pi.certidao_estado = ? LIMIT 1";
						
						
        $this->values = array($id_pedido, $cidade, $estado);
        $ret = $this->fetch();
        if ($ret[0]->id_empresa_dir <> '') {
            return $ret[0]->id_empresa_dir;
        }

        #verifica se tem rodizio
        $this->sql = "SELECT fr.id_empresa
						FROM vsites_franquia_regiao as fr, vsites_user_empresa as ue 
						WHERE fr.cidade = ? AND fr.estado = ? and fr.cdt='0' and fr.id_empresa!='1' and ue.id_empresa=fr.id_empresa and ue.status='Ativo'  ORDER by fr.id_empresa LIMIT 1";
        $this->values = array($cidade, $estado);
        $ret = $this->fetch();

            #caso não seja de são paulo e não haja direcionamento para fazer precisa zerar o contador e tentar novamente
            if ($ret[0]->id_empresa == 0 or $ret[0]->id_empresa == '') {
                #zera cdt
                $this->sql = 'update vsites_franquia_regiao set cdt=0 WHERE cidade = ? AND estado = ?';
                $this->values = array($cidade, $estado);
                $this->exec();

                #seleciona o proximo
                $this->sql = "SELECT fr.id_empresa
								FROM vsites_franquia_regiao as fr INNER JOIN vsites_user_empresa as ue ON ue.id_empresa=fr.id_empresa
								WHERE fr.cidade = ? AND fr.estado = ? and fr.cdt='0' and fr.id_empresa!='1' and ue.status='Ativo' ORDER by fr.id_empresa LIMIT 1";
                $this->values = array($cidade, $estado);
                $ret = $this->fetch();
                
                #atualiza direcionamento
                $this->sql = 'update vsites_franquia_regiao set cdt=cdt+1 WHERE cidade = ? AND estado = ? and id_empresa=?';
                $this->values = array($cidade, $estado, $ret[0]->id_empresa);
                $this->exec();
            } else {
                $this->sql = 'update vsites_franquia_regiao set cdt=cdt+1 WHERE cidade = ? AND estado = ? and id_empresa=?';
                $this->values = array($cidade, $estado, $ret[0]->id_empresa);
                $this->exec();
            }
        //}
        
        #mesmo depois de tudo se não encontrar empresa direciona para a matriz
        if ($ret[0]->id_empresa == '')
            $ret[0]->id_empresa = 1;
        return $ret[0]->id_empresa;
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
	public function selectEmpresaCEP($cep,$pais='Brazil'){
	
		if($pais=='Brazil'){
			#verifica direcionamento e rodizio exceto são paulo
			$this->sql = "SELECT ue.id_empresa, uu.id_usuario from 
				vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_franquia_regiao as fr where 
					replace(fr.cep_i,'-','') <= replace('".$cep."','-','') and replace(fr.cep_f,'-','') >= replace('".$cep."','-','') and 
					fr.cep_i!='00000-000' and fr.cep_i!='' and 
					fr.cdt_site=0 and
					fr.id_empresa=ue.id_empresa and ue.status='Ativo' and 
					ue.id_empresa = uu.id_empresa and uu.departamento_s like '6,%' limit 1";
			$ret = $this->fetch();
			
			#caso não encontre empresa para direcionar, zera o rodizio exceto são paulo
			if($ret[0]->id_empresa=='' and $cep!='00000-000' and $cep!=''){
				$this->sql = "update vsites_franquia_regiao set cdt_site=0 where 
					replace(cep_i,'-','') <= replace('".$cep."','-','') and replace(cep_f,'-','') >= replace('".$cep."','-','') and 
					cep_i!='00000-000' and cep_i!='' and 
					cdt_site>=1";
				$this->exec();
				#refaz a seleção do rodizio
				$this->sql = "SELECT ue.id_empresa, uu.id_usuario from 
					vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_franquia_regiao as fr where 
						replace(fr.cep_i,'-','') <= replace('".$cep."','-','') and replace(fr.cep_f,'-','') >= replace('".$cep."','-','') and 
						fr.cep_i!='00000-000' and fr.cep_i!='' and 
						fr.cdt_site=0 and
						fr.id_empresa=ue.id_empresa and ue.status='Ativo' and 
						ue.id_empresa = uu.id_empresa and uu.departamento_s like '6,%' limit 1";
				$ret = $this->fetch();
			}
			
			#if  encontrar a empresa adiciona o CDT, caso não atribui para a franqueadora
			if($ret[0]->id_empresa<>''){
				$this->sql = "update vsites_franquia_regiao set cdt_site=1 where 
				id_empresa='".$ret[0]->id_empresa."' and 
				replace(cep_i,'-','') <= replace('".$cep."','-','') and replace(cep_f,'-','') >= replace('".$cep."','-','') and 
				cep_i!='00000-000' and cep_i!='' and 
				cdt_site=0";
				$this->exec();
			} else {
				$ret[0]->id_empresa=1;
				$ret[0]->id_usuario=1;
			}
		}else{
			$pais = strtolower($pais);
			switch($pais){
				case 'England':
					$id_empresa=1;
					break;
				case 'Belgium':
					$id_empresa=274;
					break;
				case 'United Kingdom':
					$id_empresa=288;
					break;
				case 'United States':
					$id_empresa=408;
					break;
				default:
					$id_empresa=1;
					
			}
			$this->sql = "SELECT ue.id_empresa, uu.id_usuario from 
				vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_franquia_regiao as fr where 
					ue.id_empresa='".$id_empresa."' and
					fr.id_empresa=ue.id_empresa and ue.status='Ativo' and 
					ue.id_empresa = uu.id_empresa and uu.departamento_s like '6,%' limit 1";
			$ret = $this->fetch();			
		}
		return $ret[0];
	}

	/**
	* Verifica a empresa que atende o afiliado
	* @param String $id_atiliado
	*/
	public function selectAfiliado($id_afiliado){
		$this->sql = "SELECT ue.id_empresa, uu.id_usuario from vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_afiliado as a where a.id_afiliado='".$id_afiliado."' and a.id_empresa=ue.id_empresa and ue.status='Ativo' and ue.id_empresa = uu.id_empresa and uu.departamento_s like '6,%'";
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
		#$this->sql = "SELECT s.id_servico, s.descricao, desc_site, s.servico_desc FROM vsites_servico as s WHERE s.status='Ativo' and site = '1' ORDER BY s.desc_site, s.descricao";
		$this->sql = "SELECT s.id_servico, s.descricao, desc_site, s.servico_desc FROM vsites_servico as s WHERE s.status='Ativo' and site = '1' ORDER BY s.descricao";
		return $this->fetch();
	}

	/**
	* Lista serviços menu
	*/
	public function selectServicosSiteMenu(){
		#$this->sql = "SELECT s.id_servico, s.descricao, s.desc_site FROM vsites_servico as s WHERE s.status='Ativo' and site = 1 and site_menu=1 ORDER BY s.desc_site, s.descricao";
		$this->sql = "SELECT s.id_servico, s.descricao, s.desc_site FROM vsites_servico as s WHERE s.status='Ativo' and site = 1 and site_menu=1 ORDER BY s.descricao";
		return $this->fetch();
	}

	/**
	* Lista estados
	*/
	public function selectEstados(){
		$this->sql = "SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado";
		return $this->fetch();
	}

	//public function selectAfiliado($id_afiliado){
	//	$this->sql = "SELECT * FROM  vsites_afiliado as a where id_afiliado='".$id_afiliado."' limit 1";
	//	$ret = $this->fetch();
	//	return $ret[0];
	//}
	
	public function verificaRegiao($p){
		#quando for são paulo o cep é 00000-000
		$this->sql = "SELECT ue.id_empresa, uu.id_usuario from 
		vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_franquia_regiao as fr where 
			fr.cep_i='00000-000' and 
			fr.cdt_site=0 and 
			fr.id_empresa=ue.id_empresa and 
			ue.status='Ativo' and 
			ue.id_empresa = uu.id_empresa and 
			uu.status='Ativo' and 
			uu.departamento_s like '6,%' limit 1";
		$r = $this->fetch();
		#caso resultado seja vazio, vai zerar o rodizio e selecionar novamente a empresa
		if($r[0]->id_empresa==''){
			$this->sql = "update vsites_franquia_regiao set cdt_site=0 where cep_i='00000-000' and cdt_site>=1";
			$this->exec();

			$this->sql = "SELECT ue.id_empresa, uu.id_usuario from vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_franquia_regiao as fr where fr.cep_i='00000-000' and cdt_site=0 and fr.id_empresa=ue.id_empresa and ue.status='Ativo' and ue.id_empresa = uu.id_empresa and uu.status='Ativo' and uu.departamento_s like '6,%' limit 1";
			$r = $this->fetch();
		}
		#if  encontrar a empresa adiciona o CDT, caso não atribui o 1
		if($r[0]->id_empresa<>''){
			$this->sql = "update vsites_franquia_regiao set cdt_site=1 where id_empresa='".$r[0]->id_empresa."' and cep_i='00000-000' and cdt_site=0";
			$this->exec();
		} else {
			$r[0]->id_empresa=1;
			$r[0]->id_usuario=1;
		}
		return $r[0];
		
	}
	
}
?>
