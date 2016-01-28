<?php
class RelatorioDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_relatorios';
		$this->maximo=50;
	}

	/**
	 * registra a gera��o de um relat�rio, com o id da empresa e o nome do arquivo (com o diret�rio)
	 *
	 * @param int $id_empresa
	 * @param String $arquivo
	 * @param String $rel
	 */
	public function registraRel($id_empresa,$arquivo,$rel){
		$this->sql = "INSERT INTO vsites_relatorios (id_empresa,arquivo,descricao,data_relatorio) VALUES (?, ?, ?, NOW())";
		$this->values = array($id_empresa,$arquivo,$rel);
		$this->exec();
	}

	/**
	 * registra a gera��o de um relat�rio do mes anterior, com o id da empresa e o nome do arquivo (com o diret�rio)
	 *
	 * @param int $id_empresa
	 * @param String $arquivo
	 * @param String $rel
	 */
	public function registraRelAnterior($id_empresa,$arquivo,$rel,$retorna=1){
		$retorna--;
		$data = date('Y-m-d',strtotime("-".$retorna." month, -".date('d')." day"));
		
		$this->table = 'vsites_relatorios';
		$this->fields = array("id_empresa","arquivo","descricao","data_relatorio");
		$this->values = array("id_empresa"=>$id_empresa,"arquivo"=>$arquivo,"descricao"=>$rel,"data_relatorio"=>$data);
		return $this->insert();
	}

	public function busca($id_empresa,$mes,$ano,$tipo,$pagina=1){
		$this->values = array();
		$this->link = 'mes='.$mes.'&ano='.$ano.'&relatorio='.$tipo.'&id_empresa='.$id_empresa;

		$where = " WHERE data_relatorio LIKE ? AND descricao = ?";
		$this->values[]=$ano.'-'.$mes.'%';
		$this->values[]=$tipo;
		if($id_empresa!=''){
			$this->values[]=$id_empresa;
			$where .=' AND r.id_empresa = ? ';
		}
		$this->sql = "SELECT count(0) as total
					FROM vsites_relatorios r 
					INNER JOIN vsites_user_empresa e ON e.id_empresa=r.id_empresa
					".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$where.=" ORDER BY id_relatorio DESC";
		$this->pagina = ($pagina==NULL)?1:$pagina;
		$this->sql = "SELECT r.*,e.fantasia as empresa
					FROM vsites_relatorios r 
					INNER JOIN vsites_user_empresa e ON e.id_empresa=r.id_empresa ".$where." LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}

	public function busca_roy($id_empresa,$mes,$ano,$pagina=1){
		$this->values = array();
		$this->link = 'mes='.$mes.'&ano='.$ano.'&id_empresa='.$id_empresa.'&submit=Buscar';

		$where = " WHERE r.data_relatorio LIKE ? AND r.descricao = 'royalties'";
		$this->values[]=$ano.'-'.$mes.'%';
		if($id_empresa!=''){
			$this->values[]=$id_empresa;
			$where .=' AND r.id_empresa = ? ';
		}
		$this->sql = "SELECT count(0) as total
					FROM vsites_relatorios r 
					INNER JOIN vsites_user_empresa e ON e.id_empresa=r.id_empresa
					".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$where.=" group by r.id_empresa ORDER BY e.fantasia DESC";
		$this->pagina = ($pagina==NULL)?1:$pagina;
		$this->sql = "SELECT r.*,e.fantasia as empresa, rr.valor_propaganda as fpp, rr.valor_royalties as roy, cf.id_conta_fatura, cf.valor, cf.valor_pago
					FROM vsites_relatorios r 
					INNER JOIN vsites_user_empresa e ON e.id_empresa=r.id_empresa 
					LEFT JOIN vsites_rel_royalties as rr on rr.id_empresa=e.id_empresa and date_format(rr.data,'%Y-%m')='".$ano."-".$mes."'
					LEFT JOIN vsites_conta_fatura as cf on cf.id_empresa_franquia=e.id_empresa and cf.id_relatorio=r.id_relatorio
					".$where." LIMIT ".$this->getInicio().", ".$this->maximo;
		global $controle_id_usuario;
		if($controle_id_usuario == 1){
			echo $this->sql;
			#print_r($this->values);
		}
		return $this->fetch();
	}
	public function selectPorId($id_relatorio){
		$this->sql = "SELECT * FROM vsites_relatorios as r WHERE id_relatorio=?";
		$this->values= array($id_relatorio);
		$ret = $this->fetch();
		return $ret[0];
	}

	/**
	 * busca dados para relat�rio de Royalties
	 * @param int $id_empresa
	 * @param Strnig $data
	 */
	public function dadosRoyalties($id_empresa,$data){
		$this->sql = 'SELECT pi.id_pedido, pi.ordem, pi.valor
					FROM vsites_pedido_item as pi
					WHERE pi.encerramento >= ? and pi.encerramento <= ? and pi.id_status!=14 and pi.id_empresa_atend=?';
		$this->values = array($data.' 00:00:00',$data.' 23:59:59',$id_empresa);
		return $this->fetch();
	}

	public function insereDadosRoyalties($dados){
		$this->table = 'vsites_rel_royalties';
		$this->fields = array('id_empresa','data','valor_royalties','valor_propaganda','faturamento','despesa','imposto','fixo','roy');
		$this->values = array('id_empresa'=>$dados->id_empresa,
							'data'=>$dados->data,
							'valor_royalties'=>$dados->valor_royalties,
							'valor_propaganda'=>$dados->valor_propaganda,
							'faturamento'=>$dados->faturamento,
							'despesa'=>$dados->despesa,
							'imposto'=>$dados->imposto,
							'fixo'=>$dados->fixo,
							'roy'=>$dados->roy);
		$this->insert();
	}
	
	public function insereDadosClientes($dados){
		$this->table = 'vsites_rel_clientes';
		$this->fields = array('id_empresa','data','cliente','cnpj','total','pedidos');
		$this->values = array('id_empresa'=>$dados->id_empresa,
							'data'=>$dados->data,
							'cliente'=>$dados->cliente,
							'cnpj'=>$dados->cnpj,
							'total'=>$dados->total,
							'pedidos'=>$dados->pedidos);
		$this->insert();
	}	
	
	public function despesasFranquia($id_empresa,$data_i,$data_f,$enviados){
		$onde = ($enviados<>'')
		?" u2.id_empresa != ? and u.id_empresa=? and pi.id_empresa_resp <> '' and pi.id_empresa_resp=ue.id_empresa and "
		:" u2.id_empresa = ? and pi.id_empresa_resp=? and u.id_empresa=ue.id_empresa and ";
		$this->sql = "SELECT sum(f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio) as total, date_format(f.financeiro_autorizacao_data, '%d/%m/%Y') as data, pi.valor, u.id_empresa, pi.id_pedido, pi.ordem, ue.fantasia from
            vsites_user_usuario as u, vsites_user_usuario as u2, vsites_pedido_item as pi, vsites_financeiro as f, vsites_user_empresa as ue where
            f.financeiro_tipo='Desembolso' and
            f.financeiro_autorizacao='Aprovado' and
            f.id_pedido_item=pi.id_pedido_item and			
			".$onde."
			pi.id_usuario=u.id_usuario and
			f.id_usuario=u2.id_usuario and			
            pi.data >= ? and
            pi.data <= ?
			group by f.id_pedido_item
            order by ue.id_empresa, pi.id_pedido, pi.ordem";
		$this->values = array($id_empresa,$id_empresa,$data_i,$data_f);
		return $this->fetch();
	}

	public function despesasServico($id_empresa, $mes,$ano){
		$this->sql = "SELECT pi.id_pedido_item,pi.id_pedido, pi.ordem, s.descricao, sv.variacao,
										replace(SUM(f.financeiro_valor),'.',',') as desembolso,
										replace(SUM(f.financeiro_sedex),'.',',') as sedex,
										replace(SUM(f.financeiro_rateio),'.',',') as rateio,
										replace(pi.valor,'.',',') as valor_cobrado, replace(sv.valor_1,'.',',') as tabela
								FROM vsites_pedido_item pi
									INNER JOIN  vsites_servico_var as sv ON pi.id_servico_var = sv.id_servico_var
									INNER JOIN  vsites_servico as s ON 	pi.id_servico=s.id_servico
									LEFT JOIN vsites_financeiro as f  ON pi.id_pedido_item = f.id_pedido_item and f.financeiro_tipo='Desembolso' AND f.financeiro_autorizacao='Aprovado'
								WHERE pi.encerramento>=?
									and pi.encerramento<=?
									and pi.id_status='10' 
									and pi.id_empresa_atend=? 
								GROUP BY pi.id_pedido_item";
		$this->values = array($ano."-".$mes."-01 00:00:00",$ano."-".$mes."-31 23:59:59",$id_empresa);
		return $this->fetch();
	}

	public function despesasServicoRoyalties($id_empresa, $ano_mes){
		$this->sql = "SELECT    (
									replace(SUM(f.financeiro_valor),'.',',')+
									replace(SUM(f.financeiro_sedex),'.',',')+
									replace(SUM(f.financeiro_rateio),'.',',')-
									replace(SUM(f.financeiro_troco),'.',',')
								) as total
								FROM vsites_pedido_item pi, vsites_financeiro as f
								WHERE pi.encerramento>=?
									and pi.encerramento<=?
									and pi.id_empresa_atend=?
									and pi.id_pedido_item = f.id_pedido_item 
									and f.financeiro_tipo='Desembolso' 
									and f.financeiro_autorizacao='Aprovado'
									and f.id_empresa_fin=?
										GROUP BY pi.id_empresa_atend";
		$this->values = array($ano_mes."-01 00:00:00",$ano_mes."-31 23:59:59",$id_empresa,$id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}

	public function despesasServicoHonorarios($id_empresa, $ano_mes){
		$this->sql = "SELECT    (
									replace(SUM(f.financeiro_valor),'.',',')+
									replace(SUM(f.financeiro_sedex),'.',',')+
									replace(SUM(f.financeiro_rateio),'.',',')-
									replace(SUM(f.financeiro_troco),'.',',')
								) as total
								FROM vsites_pedido_item pi
									INNER JOIN vsites_financeiro as f  ON pi.id_pedido_item = f.id_pedido_item and f.financeiro_tipo='Desembolso' AND f.financeiro_autorizacao='Aprovado' AND f.financeiro_classificacao='38' and f.financeiro_autorizacao_data>=? and f.financeiro_autorizacao_data<=?
									INNER JOIN vsites_user_usuario as uu2 ON f.id_usuario=uu2.id_usuario and uu2.id_empresa!=?
								WHERE pi.id_empresa_resp=?
										GROUP BY pi.id_empresa_resp";
		$this->values = array($ano_mes."-01 00:00:00",$ano_mes."-31 23:59:59",$id_empresa,$id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}

	#relatorio de royalties consolidado
	public function listaRoyalties($ano,$mes){
		$this->sql = "SELECT e.id_empresa,
			r.valor_royalties, r.valor_propaganda, r.despesa,
			replace(e.fantasia,'Cartório Postal - ','') as franquia,
			r.faturamento, r.fixo, r.imposto, r.roy as royalties, r.roy_rec, r.fpp_rec
		FROM vsites_user_empresa e
		LEFT JOIN vsites_rel_royalties r ON e.id_empresa = r.id_empresa and r.data>=? AND r.data<=?
		where e.id_empresa!=1 and e.status!='Cancelado'
		GROUP BY e.id_empresa order by e.fantasia";
		$this->values = array($ano.'-'.$mes.'-01',$ano.'-'.$mes.'-31');
		return $this->fetch();
	}
		
	#relatorio de royalties consolidado anual
	public function listaRoyaltiesAnual($ano, $teste = 1){
                global $_GET;
		$this->sql = "SELECT e.id_empresa, SUM(r.valor_royalties) as valor_royalties, sum( r.despesa ) AS despesa, 
			replace( e.fantasia, 'Cartório Postal - ', '' ) AS franquia, r.faturamento
			AS faturamento, r.fixo, r.imposto, r.roy AS royalties, sum(r.valor_propaganda) AS fpp, r.data, sum(r.roy_rec) as roy_rec, sum(r.fpp_rec) as fpp_rec
		FROM vsites_user_empresa e
			LEFT JOIN vsites_rel_royalties r ON e.id_empresa = r.id_empresa 
		WHERE  ";
                if(isset($_GET['data1'])){
                    $this->sql .= " r.data>=? AND r.data<=? and e.id_empresa = ? and ";
                    $this->values = array($_GET['data1'], $_GET['data2'], $_GET['uid']);
                } else {
                    $this->sql .= " r.data>=? AND r.data<=? and ";
                    $this->values = array($ano.'-01-01', $ano.'-12-31');
                }
                $this->sql .= " e.id_empresa !=1 ".($teste == 1 ? "and e.status!='Cancelado'" : "")." 
		GROUP BY e.id_empresa, date_format( r.data, '%Y-%m' ) ORDER BY e.fantasia, date_format( r.data, '%Y-%m' )";		
                #echo $this->sql;
		return $this->fetch();
	}
	
	#relatorio de royalties consolidado
	public function RelFixo($data,$valor_royalties,$id_empresa,$fixo){
		$this->sql = "update vsites_rel_royalties set valor_royalties=?, fixo=? where id_empresa=? and date_format(data,'%Y-%m')=?";
		$this->values = array($valor_royalties,$fixo,$id_empresa,$data);
		return $this->exec();
	}	

	#relatorio de royalties consolidado deletar depois
	public function insertRelFixo($id_empresa,$data,$valor_royalties,$valor_propaganda,$faturamento,$despesa,$imposto,$roy,$fixo){
		$this->sql = "insert into vsites_rel_royalties3(id_empresa,data,valor_royalties,valor_propaganda,faturamento,despesa,imposto,roy,fixo) values('".$id_empresa."','".$data."','".$valor_royalties."','".$valor_propaganda."','".$faturamento."','".$despesa."','".$imposto."','".$roy."','".$fixo."')";
		$this->values = array();
		return $this->exec();
	}	
	
	public function faturamentoPorCliente($busca,$id_empresa,$ano,$sem=null,$mes=null){
		if($busca=='semestre'){
			if($sem==1){
				$mes_i = '01';
				$mes_f = '06';
			}else{
				$mes_i = '07';
				$mes_f = '12';
			}
		}else if($busca=='mes'){
			$mes_i = $mes;
			$mes_f = $mes;
		}else{
			$mes_i = '01';
			$mes_f = '12';
		}
		
		$this->sql = 'SELECT c.id_empresa,
			cliente,cnpj,e.fantasia as franquia, month(c.data) as mes,
			sum(total) as total,
			sum(pedidos) as pedidos
		FROM vsites_rel_clientes c
		INNER JOIN vsites_user_empresa e ON e.id_empresa = c.id_empresa 
		WHERE c.data >= ? AND c.data<=? and c.id_empresa=?
		GROUP BY c.id_empresa,c.cliente,mes
		ORDER BY c.cnpj, mes';
		$this->values = array($ano.'-'.$mes_i.'-01',$ano.'-'.$mes_f.'-31',$id_empresa);
		$ret = $this->fetch();
		
		$clientes = array();
		$cnpj_aux=16;
		foreach($ret as $r){
			if($r->cnpj!=$cnpj_aux || $cnpj_aux===16){
				if($cnpj_aux===16)$cnpj_aux=$r->cnpj;
				$clientes[$cnpj_aux] = $c;

				$c  = new stdClass();
				$c->cliente = $r->cliente;
				$c->cnpj = $r->cnpj;
				$c->franquia = $r->franquia;
				$c->id_empresa = $r->id_empresa;
			}
			$c->valores[$r->mes]->total=$r->total;
			$c->valores[$r->mes]->pedidos=$r->pedidos;
			
			$cnpj_aux = $c->cnpj;
		}
		return $clientes;
	}
	
	public function FaturamentoClienteCorporativo($lista){
		$this->sql = "			
			SELECT sum( valor ) AS valor, count( 0 ) AS pedidos, p.nome, p.contato, p.cpf, 
			p.tel, DATE_FORMAT( pi.data, '%m' ) AS mes
			FROM vsites_pedido_item pi
			INNER JOIN vsites_pedido p ON pi.id_pedido = p.id_pedido
			INNER JOIN vsites_user_usuario uu ON pi.id_usuario = uu.id_usuario
			AND uu.id_empresa =?
			WHERE p.tipo = 'cnpj'
			AND pi.id_status <>14
			AND date_format( encerramento, '%Y-%m-d' ) != '0000-00-00'
			AND p.data >= ?
			AND p.data <= ?
			GROUP BY mes, cpf, contato
			ORDER BY nome, cpf, mes";
		$this->values = array($lista->id_empresa, $lista->data1, $lista->data2);
		return $this->fetch();
	}
	
	#relatorio de despesas de servico 
	#a principio esta consulta sera feita para o uso do 
	#Sr. Odair Pedreira
	#21/10/2011
	public function DespesaServico($mes, $ano, $id_empresa){
		$whr = "";
		if($mes > 0){ $whr .= ' AND MONTH(pi.data)='.$mes; }
		if($ano > 0){ $whr .= ' AND YEAR(pi.data)='.$ano; }
		$this->sql = "SELECT pi.certidao_cidade, pi.data, pi.certidao_estado, pi.valor, pi.certidao_resultado, s.descricao,
			pf.id_pedido_item, pf.id_pedido, pf.ordem, pf.custas, pf.rateio, pf.sedex
			FROM vsites_pedido_item pi
			INNER JOIN vsites_pedido AS p ON pi.id_pedido = p.id_pedido
			INNER JOIN vsites_pedido_fin AS pf ON pi.id_pedido_item = pf.id_pedido_item
			INNER JOIN vsites_servico AS s ON pi.id_servico = s.id_servico
			WHERE pi.id_empresa_atend='".$id_empresa."' and pi.id_status=10 ".$whr." ORDER BY pi.data";
		return $this->fetch();
	}
	
	public function relatorioOperacional($id_empresa,$ano,$mes){
		$this->values = array();
		$this->sql = "SELECT COUNT(pi.id_pedido_item) as soma, pi.id_servico_departamento, date_format(pi.inicio,'%d') as dia FROM vsites_pedido_item as pi
			where pi.id_empresa_atend='".$id_empresa."' and
			date_format(pi.inicio,'%Y-%m') = '".$ano."-".$mes."' and  
			pi.id_status!='16' and 
			pi.id_status!='1' and 
			pi.id_status!='14'
			group by pi.id_servico_departamento, date_format(pi.inicio,'%d') order by date_format(pi.inicio,'%d'),pi.id_servico_departamento";
		return $this->fetch();
	}

	public function relatorioVendasPorAtendente($id_empresa,$ano,$mes){
		$this->values = array();
		$this->sql = "select COUNT(0) as total, uu.nome, replace(format(SUM(pi.valor),2),',','') as valor, 
			replace(format(SUM(pi.valor_rec),2),',','') as valor_rec,
			p.origem, date_format(pi.data,'%d/%m/%Y') as data, pi.id_usuario, pi.id_status
			from vsites_pedido_item as pi ,
			vsites_user_usuario as uu,
			vsites_pedido as p where 
			pi.id_status!='14' and
			pi.id_empresa_atend='".$id_empresa."' and
			DATE_FORMAT(pi.data,'%Y-%m')='".$ano."-".$mes."' and
			pi.id_status<>'' and
			pi.id_usuario=uu.id_usuario and
			pi.id_pedido=p.id_pedido
			group by pi.id_usuario, pi.id_status, p.origem
			order by pi.id_usuario, p.origem";
		return $this->fetch();
	}

	public function relatorioPedidosFaturar($id_empresa,$datai,$dataf){
		$this->values = array($id_empresa,$datai.' 00:00:00',$dataf.' 23:59:59');
		$this->sql = "SELECT p.nome, pi.id_pedido, pi.ordem, date_format( pi.inicio, '%d/%m/%Y' ) as inicio , date_format( pi.data_prazo, '%d/%m/%Y' ) as prazo , pi.valor , pi.valor_rec , s.status
                FROM vsites_pedido_item AS pi, vsites_pedido AS p, vsites_status AS s
                WHERE pi.id_status !=10
                AND pi.id_status !=14
                AND pi.id_empresa_atend=?
                AND pi.inicio >= ?
                AND pi.inicio <= ?
                AND pi.id_pedido = p.id_pedido
                AND pi.id_status = s.id_status";
		return $this->fetch();
	}

	public function relatorioPedidosOperacional($id_empresa,$data){
		$this->values = array($id_empresa,$data);
		$this->sql = "SELECT pi.id_pedido, pi.ordem, p.nome, s.descricao, pi.certidao_cidade, pi.certidao_estado, pi.valor FROM 
                    vsites_pedido_item as pi, vsites_pedido as p, vsites_servico as s where 
                    pi.id_empresa_atend=? and 
                    date_format(pi.inicio,'%Y-%m-%d')=? and 
                    pi.id_status!=14 and 
                    pi.id_pedido=p.id_pedido and 
                    pi.id_servico=s.id_servico";
		return $this->fetch();
	}
	
	public function relatorioVendasPorAtendenteBuscaValor($id_empresa,$ano,$mes,$id_usuario){
		$this->values = array();
		$this->sql = "select COUNT(0) as total, replace(format(SUM(pi.valor),2),',','') as valor, 
			replace(format(SUM(pi.valor_rec),2),',','') as valor_rec,
			p.origem, date_format(pi.data,'%d/%m/%Y') as data, pi.id_usuario, pi.id_status
			from vsites_pedido_item as pi ,
			vsites_user_usuario as uu,
			vsites_pedido as p where 
			pi.id_status!='14' and
			pi.id_empresa_atend='".$id_empresa."' and
			DATE_FORMAT(pi.data,'%Y-%m')='".$ano."-".$mes."' and
			pi.id_status<>'' and
			pi.id_usuario = '".$id_usuario."' and
			pi.id_usuario=uu.id_usuario and
			pi.id_pedido=p.id_pedido
			group by pi.id_usuario, pi.id_status, p.origem
			order by pi.id_usuario, p.origem";
		return $this->fetch();
	}
    
    
    public function relatorioVendasPorAtendenteBuscaNome($id_empresa,$ano,$mes){
		$this->values = array();
		$this->sql = "SELECT uu.nome, pi.id_usuario
		FROM vsites_pedido_item AS pi, vsites_user_usuario AS uu, vsites_pedido AS p
		WHERE pi.id_status != '14'
		AND pi.id_empresa_atend='".$id_empresa."' 
		AND DATE_FORMAT(pi.data,'%Y-%m')='".$ano."-".$mes."'
		AND pi.id_status <> ''
		AND pi.id_usuario = uu.id_usuario
		AND pi.id_pedido = p.id_pedido
		GROUP BY uu.nome
		ORDER BY uu.nome";
		return $this->fetch();
	}
	
    public function relatorioGeraldoDia($id_empresa,$data_i,$data_f){
		$this->values = array();
		$this->sql = "select data, SUM(total) as total, 
SUM(concluido) as concluido, SUM(cancelado) as cancelado, SUM(fechado) as fechado, SUM(aberto) as aberto, SUM(execucao) as execucao,
SUM(concluido_valor) as concluido_valor,
SUM(cancelado_valor) as cancelado_valor,
SUM(fechado_valor) as fechado_valor,
SUM(aberto_valor) as aberto_valor,
SUM(execucao_valor) as execucao_valor
 from (
#aberto e cancelado
SELECT case when pi.data_atividade<= '$data_i' THEN '0000-00-00' ELSE date_format(pi.data_atividade,'%Y-%m-%d') END as data, COUNT(0) as total, 
SUM(s.conc) as concluido, SUM(s.canc) as cancelado, SUM(s.fech) as fechado, SUM(s.aber) as aberto, (0) as execucao,
(0) as concluido_valor,
CASE WHEN s.canc!=0 THEN SUM(pi.valor) else 0 END as cancelado_valor,
(0) as fechado_valor,
CASE WHEN s.aber!=0 THEN SUM(pi.valor) else 0 END as aberto_valor,
(0) as execucao_valor
		FROM vsites_pedido_item as pi INNER JOIN vsites_status as s ON pi.id_status=s.id_status where pi.id_empresa_atend='".$id_empresa."' and 
		(s.aber=1 and pi.data_atividade<='$data_f' or
		pi.data_atividade>='$data_i' and pi.data_atividade<='$data_f' and s.canc=1)		
		group by date_format(pi.data,'%Y-%m-%d'), pi.id_status 
UNION

#concluido no periodo		
SELECT date_format(pi.encerramento,'%Y-%m-%d') as data, COUNT(0) as total, 
SUM(s.conc) as concluido, (0) as cancelado, (0) as fechado, (0) as aberto, (0) as execucao,
SUM(pi.valor) as concluido_valor,
(0) as cancelado_valor,
(0) as fechado_valor,
(0) as aberto_valor,
(0) as execucao_valor
		FROM vsites_pedido_item as pi INNER JOIN vsites_status as s ON pi.id_status=s.id_status where pi.id_empresa_atend='".$id_empresa."' and 
		pi.encerramento>='$data_i' and pi.encerramento<='$data_f'
		group by date_format(pi.data,'%Y-%m-%d') 

UNION

#fechado no mes		
SELECT date_format(pi.inicio,'%Y-%m-%d') as data, SUM(0) as total, 
(0) as concluido, (0) as cancelado, SUM(s.fech) as fechado, (0) as aberto, (0) as execucao,
(0) as concluido_valor,
(0) as cancelado_valor,
SUM(pi.valor) as fechado_valor,
(0) as aberto_valor,
(0) as execucao_valor
		FROM vsites_pedido_item as pi INNER JOIN vsites_status as s ON pi.id_status=s.id_status where pi.id_empresa_atend='".$id_empresa."' and 
		pi.inicio>='$data_i' and pi.inicio<='$data_f'
		group by date_format(pi.data,'%Y-%m-%d') 

UNION

#em execu��o		
SELECT case when pi.data<= '$data_i' THEN '0000-00-00' ELSE date_format(pi.data,'%Y-%m-%d') END as data, COUNT(0) as total, 
(0) as concluido, (0) as cancelado, (0) as fechado, (0) as aberto, SUM(s.fech) as execucao,
(0) as concluido_valor,
(0) as cancelado_valor,
(0) as fechado_valor,
(0) as aberto_valor,
SUM(pi.valor) as execucao_valor
		FROM vsites_pedido_item as pi INNER JOIN vsites_status as s ON pi.id_status=s.id_status where pi.id_empresa_atend='".$id_empresa."' and 
		s.fech=1 and pi.data<='$data_f'
		group by date_format(pi.data,'%Y-%m-%d')
		
) as tabela group by date_format(data,'%Y-%m-%d') order by date_format(data,'%Y-%m-%d')
";
		return $this->fetch();
	}
	
}
?>
