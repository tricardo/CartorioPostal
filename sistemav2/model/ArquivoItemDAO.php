<?php
class ArquivoItemDAO extends Database{
	
	public function __construct(){
		$this->table = 'vsites_arquivo_item';
		parent::__construct();
	}
        
        function log_importado($c){
            $this->sql = "SELECT ai.* from vsites_arquivo_item as ai where id_arquivo = ? and dup=? and erro=''";
            $this->values = array($c->id_arquivo, $c->dup);
            return $this->fetch();
        }

	#atualiza pedido item com número da duplicidade
	public function atualiza($aItem){
		$this->sql = "update vsites_arquivo_item set id_pedido_dup=?, ordem_dup=? where id_arquivo_item=?";
		$this->values = array($aItem->id_pedido,$aItem->ordem,$aItem->id_arquivo_item);
		$this->exec();
	}
	
	#atualiza pedido item com número da duplicidade
	# $aItem->nome
	# $aItem->cpf
	# $aItem->cidade
	# $aItem->estado
	# $aItem->erro
	public function atualizaArquivoItem($aItem,$retItem,$id_arquivo,$id_arquivo_item,$id_usuario,$id_empresa){
		#atualiza com os novos dados
		$this->sql = "update vsites_arquivo_item set certidao_nome=?, certidao_cpf=?, certidao_cidade=?, certidao_estado=?, erro=? where id_arquivo_item=?";
		$this->values = array($aItem->nome,$aItem->cpf,$aItem->cidade,$aItem->estado,$aItem->erro,$id_arquivo_item);
		$this->exec();

		#verifica duplicidade
		if($aItem->erro==''){
			$enc_dupli = date('Y-m-d');
			$this->sql = "select pi.id_pedido, pi.ordem from vsites_pedido as p, vsites_pedido_item as pi
			where 
			p.id_conveniado='".$retItem->id_conveniado."' and
			p.id_pedido=pi.id_pedido and pi.id_status!='14' and 
			pi.id_servico='".$retItem->id_servico."' and
			(pi.encerramento='0000-00-00 00:00:00' or pi.encerramento>=DATE_SUB('".$enc_dupli." 00:00:00',INTERVAL 3 MONTH)) and
			pi.certidao_nome='".$aItem->nome."' and 
			pi.certidao_cidade='".$aItem->cidade."' and  
			pi.certidao_estado='".$aItem->estado."' and
			((replace(replace(replace(pi.certidao_cpf,'-',''),'.',''),'/',''))='".$aItem->cpf."' and pi.certidao_cpf!='' or 
			(replace(replace(replace(pi.certidao_cnpj,'-',''),'.',''),'/',''))='".$aItem->cpf."' and pi.certidao_cnpj!='') limit 1";
			$this->values = array();
			$num_dup = $this->fetch();
			
			if($num_dup[0]->id_pedido<>''){
				$this->sql = "update vsites_arquivo_item as ai
				set ai.dup='1', ai.ordem_dup='".$num_dup[0]->ordem."', ai.id_pedido_dup='".$num_dup[0]->id_pedido."'
				where ai.id_arquivo_item=? and ai.erro='' and ai.dup='0'";
				$this->values = array($id_arquivo_item);
				$this->exec();
			}
		}
		if($num_dup[0]->id_pedido=='' and $aItem->erro==""){
			$certidao_cpf = $aItem->cpf;
			$this->sql = "select ai.id_pedido_dup
			from vsites_arquivo_item as ai where 
			ai.id_arquivo = ? and ai.erro='' and ai.dup='0' limit 1";
			$this->values = array($id_arquivo);
			$ret = $this->fetch();
			
			$this->sql = "select pi.id_servico, pi.id_servico_var, pi.id_servico_departamento, pi.urgente, pi.dias, pi.valor, pi.id_pedido 
			from vsites_pedido_item as pi where 
			pi.id_pedido=? limit 1";
			$this->values = array($ret[0]->id_pedido_dup);
			$ret = $this->fetch();

			$p->id_servico = $ret[0]->id_servico;
			$p->id_servico_var = $ret[0]->id_servico_var;
			$p->id_servico_departamento = $ret[0]->id_servico_departamento;
			$p->urgente = $ret[0]->urgente;
			$p->dias = $ret[0]->dias;
			$p->valor = $ret[0]->valor;

			$p->certidao_devedor_cpf = $retItem->certidao_devedor_cpf;
			$p->certidao_devedor 	 = $retItem->certidao_devedor;
			$p->certidao_nome 		 = $aItem->nome;
			$p->certidao_rg 		 = $retItem->certidao_rg;
			$p->certidao_conjuge 	 = $retItem->certidao_conjuge;
			$p->certidao_cidade 	 = $aItem->cidade;
			$p->certidao_estado 	 = $aItem->estado;
			
			#valida documento
			$valida_cpf = validaCPF($aItem->cpf);
				
			if($valida_cpf=='false'){				
				$p->certidao_cnpj=$aItem->cpf;
				$p->certidao_cpf = '';
			} else {
				$p->certidao_cnpj= '';
				$p->certidao_cpf = $aItem->cpf;
			}
			
			$p->id_usuario = $id_usuario;
			$p->id_empresa_atend = $id_empresa;
			$p->obs = '';
			
			$pedidoDAO = new PedidoDAO();
			$ordem = $pedidoDAO->inserir_item($p,$ret[0]->id_pedido);
			
			$this->sql = "update vsites_arquivo_item set id_pedido_dup=?, ordem_dup=? where id_arquivo_item=?";
			$this->values = array($ret[0]->id_pedido,$ordem,$id_arquivo_item);
			$this->exec();
			return $ret[0]->id_pedido.'/'.$ordem;
		}
		return '';
	}
	
	#lista os ultimos 100 arquivos importados contando os erros
	public function listaRemessaC($id_empresa){
		$this->sql = "SELECT uc.nome, a.data, a.id_arquivo, SUM(CASE WHEN aa.erro<> '' THEN 1 ELSE 0 END) as erros from vsites_arquivo as a, vsites_arquivo_item as aa, vsites_user_cliente as uc where a.id_empresa=? and a.id_arquivo=aa.id_arquivo and a.id_conveniado=uc.id_cliente group by id_arquivo order by a.data desc LIMIT 100";
		$this->values = array($id_empresa);
		return $this->fetch();		
	}	

	#retorna erros do arquivo importado
	public function listaRemessaCPorID($id_arquivo,$id_empresa){
		$this->sql = "SELECT ai.* from vsites_arquivo_item as ai, vsites_arquivo as a where a.id_arquivo=? and a.id_empresa=? and a.id_arquivo=ai.id_arquivo and ai.erro<>'' order by a.data desc";
		$this->values = array($id_arquivo,$id_empresa);
		return $this->fetch();		
	}	

	#seleciona arquivo item por id
	public function listaRemessaCPorIDItem($id_arquivo_item,$id_empresa){
		$this->sql = "SELECT ai.*, a.id_conveniado, a.id_servico from vsites_arquivo_item as ai, vsites_arquivo as a where ai.id_arquivo_item=? and ai.id_empresa=? and ai.erro<>'' and ai.id_arquivo=a.id_arquivo limit 1";
		$this->values = array($id_arquivo_item,$id_empresa);
		$ret = $this->fetch();
		return count($ret) > 0 ? $ret[0] : array();
	}	

	#inclui arquivo
	public function inserirArquivo($id_empresa,$id_usuario,$id_cliente,$arquivo,$id_servico){
		$this->table = 'vsites_arquivo';
		$this->fields = array('id_empresa','id_conveniado','arquivo','id_usuario','id_servico','data','status');
		$this->values = array('id_empresa'=>$id_empresa,'id_conveniado'=>$id_cliente,
								'arquivo'=>$arquivo,'id_usuario'=>$id_usuario,
								'id_servico'=>$id_servico,'data'=>date('Y-m-d H:i:s'),'status'=>'Pendente');								
		return $this->insert();
	}	

	#inclui arquivo item
	public function inserirArquivoObito($id_empresa,$id_arquivo,$r){	
		$this->table = 'vsites_arquivo_item';
		$this->fields = array('id_empresa','id_arquivo','certidao_nome','certidao_mae','certidao_data_obito','certidao_livro','certidao_folha','certidao_termo',
		'certidao_cartorio','certidao_cidade','certidao_estado','erro');
		$this->values = array('id_empresa'=>$id_empresa,'id_arquivo'=>$id_arquivo,'certidao_nome'=>$r->nome,'certidao_mae'=>$r->mae,'certidao_data_obito'=>$r->data_obito
		,'certidao_livro'=>$r->livro,'certidao_folha'=>$r->folha,'certidao_termo'=>$r->termo,
		'certidao_cartorio'=>$r->cartorio,'certidao_cidade'=>$r->cidade,'certidao_estado'=>$r->estado,'erro'=>$r->erro);
		return $this->insert();
	}	

	#inclui arquivo item
	public function inserirArquivoImoveisDetran($id_empresa,$id_arquivo,$r){	
		$this->table = 'vsites_arquivo_item';
		$this->fields = array('id_empresa','id_arquivo','certidao_devedor_cpf','certidao_devedor','certidao_cpf','certidao_nome','certidao_rg',
		'certidao_conjuge','certidao_cidade','certidao_estado','erro');
		$this->values = array('id_empresa'=>$id_empresa,'id_arquivo'=>$id_arquivo,'certidao_devedor_cpf'=>$r->devedor_cpf,'certidao_devedor'=>$r->devedor,'certidao_cpf'=>$r->cpf
		,'certidao_nome'=>$r->nome,'certidao_rg'=>$r->rg,'certidao_conjuge'=>$r->conjuge,'certidao_cidade'=>$r->cidade,'certidao_estado'=>$r->estado,'erro'=>$r->erro);
		return $this->insert();
	}	
	
	public function inserirArquivoImoveisMatriculaAtualizada($id_empresa,$id_arquivo,$r){
		$this->table = 'vsites_arquivo_item';
		$this->fields = array('id_empresa','id_arquivo','certidao_devedor_cpf','certidao_devedor','certidao_cpf','certidao_nome','certidao_rg',
		'certidao_conjuge','certidao_cidade','certidao_estado','certidao_matricula','certidao_cartorio','erro');
		$this->values = array('id_empresa'=>$id_empresa,'id_arquivo'=>$id_arquivo,'certidao_devedor_cpf'=>$r->devedor_cpf,
		'certidao_devedor'=>$r->devedor,'certidao_cpf'=>$r->cpf,'certidao_nome'=>$r->nome,'certidao_rg'=>$r->rg,
		'certidao_conjuge'=>$r->conjuge,'certidao_cidade'=>$r->cidade,'certidao_estado'=>$r->estado,
		'certidao_matricula'=>$r->matricula,'certidao_cartorio'=>$r->cartorio,'erro'=>$r->erro);
		return $this->insert();
	}

	#verifica duplicidades na importação do arquivo
	public function verificaDuplicidadeImoveisDetran($id_arquivo,$id_cliente,$id_servico){	
		$enc_dupli = date('Y-m-d');		
		$this->sql = "update vsites_arquivo_item as ai, (select * from vsites_arquivo_item as ai where ai.id_arquivo=?) as ai2 
		set ai.dup='1' where 
		ai.id_arquivo=? and 
		ai.certidao_nome = ai2.certidao_nome and 
		ai.certidao_cpf=ai2.certidao_cpf and 
		ai.certidao_cidade=ai2.certidao_cidade and 
		ai.certidao_estado=ai2.certidao_estado and 
		ai.id_arquivo_item!=ai2.id_arquivo_item and 
		ai.id_arquivo_item>ai2.id_arquivo_item";
		$this->values = array($id_arquivo,$id_arquivo);
		$num_dup = $this->exec();
		
		#somente para hsbc compara pelo servico imoveis, por isso deve importar primeiro o detran
		if($id_cliente=='635') $id_servico = '11';		
		#NOVO
		$this->sql = "select pi.id_pedido, pi.ordem, ai.id_arquivo_item from vsites_pedido as p, vsites_pedido_item as pi, vsites_arquivo_item as ai
		where 
		p.id_conveniado='".$id_cliente."' and
		p.id_pedido=pi.id_pedido and pi.id_status!='14' and 
		pi.id_servico='".$id_servico."' and
		(pi.encerramento='0000-00-00 00:00:00' or pi.encerramento>=DATE_SUB('".$enc_dupli." 00:00:00',INTERVAL 3 MONTH)) and
		ai.id_arquivo='".$id_arquivo."' and
		ai.dup='0' and ai.erro='' and
		pi.certidao_nome=ai.certidao_nome and 
		pi.certidao_cidade=ai.certidao_cidade and  
		pi.certidao_estado=ai.certidao_estado and
		((replace(replace(replace(pi.certidao_cpf,'-',''),'.',''),'/',''))=ai.certidao_cpf and pi.certidao_cpf!='' or 
		(replace(replace(replace(pi.certidao_cnpj,'-',''),'.',''),'/',''))=ai.certidao_cpf and pi.certidao_cnpj!='')";
		$this->values = array();
		$num_dup = $this->fetch();
		if(count($num_dup)<>0){
			foreach($num_dup as $l){
				$this->sql = "update vsites_arquivo_item as ai
				set ai.dup='1', ai.ordem_dup='".$l->ordem."', ai.id_pedido_dup='".$l->id_pedido."'
				where ai.id_arquivo_item='".$l->id_arquivo_item."' and ai.erro='' and ai.dup='0'";
				$this->values = array();
				$this->exec();
			}
		}
		#NOVO
	}
		
}

?>
