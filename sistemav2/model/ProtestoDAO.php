<?php

class ProtestoDAO extends Database{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function busca($busca="",$id_empresa, $pagina){
		$where = " WHERE (p.portador like ? or p.portador_nome like ?) AND p.id_usuario = uu.id_usuario AND uu.id_empresa=? order by p.data_movimento ASC";
		$this->values = array("$busca%","$busca%",$id_empresa);
		
		$this->sql = "SELECT count(0) as total FROM vsites_protesto as p, vsites_user_usuario as uu ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		
		$this->link = 'busca='.$busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;
		
		$this->sql = "SELECT p.* FROM vsites_protesto as p, vsites_user_usuario as uu ".$where;
		return $this->fetch();
	}
	
	public function inserir($protesto,$id_empresa){
		$this->sql ="SELECT sequencia
						FROM vsites_protesto as p, vsites_user_usuario as uu WHERE
						p.id_usuario = uu.id_usuario and uu.id_empresa = ? and
                                                p.portador = '".$protesto->portador."'
                                                ORDER BY p.id_protesto DESC";
		$this->values = array($id_empresa);
		$seq = $this->fetch();
		$seq = $seq[0];
		if($seq->sequencia<>'' and $seq->sequencia<>0)
			$protesto->sequencia = $seq->sequencia;
		$protesto->sequencia++;
		$this->table = 'vsites_protesto';
		$this->fields = array("sequencia","portador","portador_nome",
							"data_movimento","cedente_agencia","cedente_nome",
							"sacado_documento","sacado_nome","sacado_cep",
							"sacado_endereco","sacado_estado","sacado_cidade",
							"nosso_numero","tipo_moeda","agencia_centralizadora",
							"id_usuario","data_cadastro","ibge_cidade");
		$this->values = array("sequencia"=>$protesto->sequencia,"portador"=>$protesto->portador,"portador_nome"=>$protesto->portador_nome,
							"data_movimento"=>$protesto->data_movimento,"cedente_agencia"=>$protesto->cedente_agencia,"cedente_nome"=>$protesto->cedente_nome,
							"sacado_documento"=>$protesto->sacado_documento,"sacado_nome"=>$protesto->sacado_nome,"sacado_cep"=>$protesto->sacado_cep,
							"sacado_endereco"=>$protesto->sacado_endereco,"sacado_estado"=>$protesto->sacado_estado,"sacado_cidade"=>$protesto->sacado_cidade,
							"nosso_numero"=>$protesto->nosso_numero,"tipo_moeda"=>$protesto->tipo_moeda,"agencia_centralizadora"=>$protesto->agencia_centralizadora,
							"id_usuario"=>$protesto->id_usuario,"data_cadastro"=>date("Y-m-d H:i:s"),"ibge_cidade"=>$protesto->ibge_cidade);
		return $this->insert();
	}
	
	public function buscaPorId($id,$id_empresa){
			$this->sql = "SELECT p.* FROM vsites_protesto as p, vsites_user_usuario as uu 
							WHERE p.id_protesto=? AND p.id_usuario=uu.id_usuario AND uu.id_empresa =?";
			$this->values = array($id,$id_empresa);
			$ret = $this->fetch();
			return $ret[0];
	}
	
	public function atualizar($p,$id_empresa){
		$this->sql = "UPDATE vsites_protesto as p, vsites_user_usuario as uu SET 
						portador_nome=?,portador=?,data_movimento=?,
						cedente_nome=?, cedente_agencia=?, sacado_documento=?,
						sacado_nome=?, sacado_cep=?, sacado_endereco=?,
						sacado_estado=?, sacado_cidade=?, nosso_numero=?,
						tipo_moeda=?, agencia_centralizadora=?, atualizacao=NOW(), ibge_cidade=?
		 			WHERE p.id_protesto=? AND p.id_usuario=uu.id_usuario AND uu.id_empresa=?";
		$this->values = array($p->portador_nome,$p->portador,$p->data_movimento,
							$p->cedente_nome,$p->cedente_agencia,$p->sacado_documento,
							$p->sacado_nome,$p->sacado_cep,$p->sacado_endereco,
							$p->sacado_estado,$p->sacado_cidade,$p->nosso_numero,
							$p->tipo_moeda,$p->agencia_centralizadora,$p->ibge_cidade,
						$p->id_protesto,$id_empresa);
		$this->exec();
	}
        
        public function buscaDevedoresRem($id_protesto){
            $this->sql = "SELECT pr.* from vsites_protesto_rem as pr where
			pr.id_protesto = ? order by pr.id_protesto_rem";
            $this->values = array($id_protesto);
            return $this->fetch();	
        }

	public function buscaDevedores($busca="",$id_protesto,$id_empresa,$pagina){
		$where = " WHERE (pr.dev_nome like ?) AND pr.id_protesto = ? AND pr.id_usuario=uu.id_usuario and uu.id_empresa=? 
					ORDER BY pr.id_protesto_rem";
		$this->values = array("$busca%",$id_protesto,$id_empresa);
		
		$this->sql = "SELECT count(0) as total FROM vsites_protesto_rem as pr, vsites_user_usuario as uu ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		$this->link = 'busca='.$busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;
		
		$this->sql = "SELECT pr.* FROM vsites_protesto_rem as pr, vsites_user_usuario as uu ".$where;
		return $this->fetch();		
	}
	
	public function inserirDevedor($d){
		$this->table = 'vsites_protesto_rem';
		$this->fields = array ('id_protesto','tit_num','data_emissao',
			  					'data_vencimento','valor','saldo', 
			  					'praca_pagamento','tipo_endosso','aceite', 
			  					'dev_num','dev_nome','tipo',
			  					'cpf','outro_doc','dev_endereco', 
			  					'dev_cep','dev_cidade','dev_estado', 
			  					'num','num_pro','oco_tipo',
			  					'data_protocolo','custas','decla_portador',
			  					'data_ocorrencia','cod_irr','dev_bairro',
			  					'custas_cart','registro_distr','custas_gravacao',
			  					'oper_banco','contrato_banco','parcela_contrato',
			  					'tipo_cam','comp_irr','motivo_falencia',
			  					'especie','data','id_usuario','nosso_numero'); 
		$this->values = array('id_protesto'=>$d->id_protesto,'tit_num'=>$d->tit_num,'data_emissao'=>$d->data_emissao,
				'data_vencimento'=>$d->data_vencimento,'valor'=>$d->valor,'saldo'=>$d->saldo,
				'praca_pagamento'=>$d->praca_pagamento,'tipo_endosso'=>$d->tipo_endosso,'aceite'=>$d->aceite,
				'dev_num'=>$d->dev_num,'dev_nome'=>$d->dev_nome,'tipo'=>$d->tipo,
				'cpf'=>$d->cpf,'outro_doc'=>$d->outro_doc,'dev_endereco'=>$d->dev_endereco,
				'dev_cep'=>$d->dev_cep,'dev_cidade'=>$d->dev_cidade,'dev_estado'=>$d->dev_estado,
				'num'=>$d->num,'num_pro'=>$d->num_pro,'oco_tipo'=>$d->oco_tipo,
				'data_protocolo'=>$d->data_protocolo,'custas'=>$d->custas,'decla_portador'=>$d->decla_portador,
				'data_ocorrencia'=>$d->data_ocorrencia,'cod_irr'=>$d->cod_irr,'dev_bairro'=>$d->dev_bairro,
				'custas_cart'=>$d->custas_cart,'registro_distr'=>$d->registro_distr,'custas_gravacao'=>$d->custas_gravacao,
				'oper_banco'=>$d->oper_banco,'contrato_banco'=>$d->contrato_banco,'parcela_contrato'=>$d->parcela_contrato,
				'tipo_cam'=>$d->tipo_cam,'comp_irr'=>$d->comp_irr,'motivo_falencia'=>$d->motivo_falencia,
				'especie'=>$d->especie,'data'=>date("Y-m-d H:s:i"),'id_usuario'=>$d->id_usuario,'nosso_numero'=>$d->nosso_numero);
		return $this->insert();
	}
	
	public function buscaDevedorPorId($id,$id_empresa){
		$this->sql = "SELECT pr.* FROM vsites_protesto_rem as pr,vsites_user_usuario as uu 
						WHERE pr.id_protesto_rem=? AND pr.id_usuario=uu.id_usuario AND uu.id_empresa=?";
		$this->values = array($id,$id_empresa);
		$ret =  $this->fetch();
		return $ret[0];
	}
        
        public function gerar_protesto_rem($id_protesto, $id_empresa){
            $this->sql = "SELECT p.*, count(pr.id_protesto_rem) as qtdd, p.sequencia,
                            (select COUNT(pr_tit.id_protesto) from vsites_protesto_rem as pr_tit where pr_tit.id_protesto=p.id_protesto and pr_tit.dev_num=1 group by pr_tit.id_protesto) as qtdd_tit,
                            (select COUNT(pr_tit.id_protesto) from vsites_protesto_rem as pr_tit where pr_tit.id_protesto=p.id_protesto and (pr_tit.especie='DMI' or pr_tit.especie='DRI' or pr_tit.especie='CBI') group by pr_tit.id_protesto) as qtdd_especie,
                            (select COUNT(pr_tit.id_protesto) from vsites_protesto_rem as pr_tit where pr_tit.id_protesto=p.id_protesto and pr_tit.especie!='DMI' and pr_tit.especie!='DRI' and pr_tit.especie!='CBI' group by pr_tit.id_protesto) as qtdd_n_especie
			from vsites_protesto as p, vsites_protesto_rem as pr, vsites_user_usuario as uu where
                            p.id_protesto = ? and 
                            p.id_usuario = uu.id_usuario and 
                            uu.id_empresa = ? and 
                            p.id_protesto = pr.id_protesto 
                                group by pr.id_protesto";
            $this->values = array($id_protesto, $id_empresa);
            $ret = $this->fetch();
            return count($ret) > 0 ? $ret[0] : array();
        }
	
	public function atualizaDevedor($d,$id_empresa){
		$this->sql = "UPDATE vsites_protesto_rem as pr, vsites_user_usuario as uu SET 
				pr.tit_num=?, pr.data_emissao=?, pr.data_vencimento=?, 
				pr.valor=?, pr.saldo=?, pr.praca_pagamento=?,
				pr.tipo_endosso=?, pr.aceite=?, pr.dev_num=?,
				pr.dev_nome=?, pr.tipo=?, pr.cpf=?,
				pr.outro_doc=?, pr.dev_endereco=?, pr.dev_cep=?,
				pr.dev_cidade=?, pr.dev_estado=?, pr.num=?,
				pr.num_pro=?, pr.oco_tipo=?, pr.data_protocolo=?,
				pr.custas=?, pr.decla_portador=?, pr.data_ocorrencia=?,
				pr.cod_irr=?, pr.dev_bairro=?, pr.custas_cart=?,
				pr.registro_distr=?, pr.custas_gravacao=?, pr.contrato_banco=?,
				pr.oper_banco=?, pr.parcela_contrato=?, pr.tipo_cam=?,
				pr.comp_irr=?, pr.motivo_falencia=?, pr.especie=?,
				pr.data_ocorrencia=?, pr.nosso_numero=?
			WHERE
				pr.id_protesto_rem=? AND pr.id_usuario=uu.id_usuario AND uu.id_empresa=?";
		$this->values = array ($d->tit_num,$d->data_emissao,$d->data_vencimento,
						$d->valor,$d->saldo,$d->praca_pagamento,
						$d->tipo_endosso,$d->aceite,$d->dev_num,
						$d->dev_nome,$d->tipo,$d->cpf,
						$d->outro_doc,$d->dev_endereco,$d->dev_cep,
						$d->dev_cidade,$d->dev_estado,$d->num,
						$d->num_pro,$d->oco_tipo,$d->data_protocolo,
						$d->custas,$d->decla_portador,$d->data_ocorrencia,
						$d->cod_irr,$d->dev_bairro,$d->custas_cart,
						$d->registro_distr,$d->custas_gravacao,$d->contrato_banco,
						$d->oper_banco,$d->parcela_contrato,$d->tipo_cam,
						$d->comp_irr,$d->motivo_falencia,$d->especie,
						$d->data_ocorrencia,$d->nosso_numero,
						$d->id_protesto_rem,$id_empresa);					
		$this->exec();
	}
        
        
}
?>