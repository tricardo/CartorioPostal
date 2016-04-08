<?php
class ConveniadoDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_user_conveniado';
	}

	/**
	 * faz busca dos conveniados
	 * @param String $busca
	 * @param int $id_cliente
	 * @param int $id_empresa
	 * @param int $pagina
	 */
	public function busca($busca,$id_empresa,$id_cliente='',$pagina=1){
            global $id_conveniado;
		$this->values = array();
		$where = " FROM vsites_user_conveniado, vsites_user_cliente, vsites_user_usuario
					WHERE (vsites_user_conveniado.nome LIKE ?)";
		$this->values[] = "%$busca%";
		if($id_cliente <> ''){
			$where .= " and vsites_user_conveniado.id_cliente=?";
			$this->values[]=$id_cliente;
		}
                
		$where.=" AND vsites_user_conveniado.id_cliente = vsites_user_cliente.id_cliente AND
				vsites_user_usuario.id_usuario = vsites_user_cliente.id_usuario AND
				vsites_user_usuario.id_empresa=?";
		$this->values[] = $id_empresa;

		$this->sql = "SELECT count(0) as total ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$this->link = 'busca='.$busca.'&id_conveniado='.$id_conveniado;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT vsites_user_conveniado.*, vsites_user_cliente.nome as empresa ".$where
		."ORDER BY vsites_user_conveniado.nome ASC
						 LIMIT ".$this->getInicio().", ".$this->maximo;
		return $this->fetch();
	}

	public function inserir($c){
		$this->fields = array("contato","senha","nome",
								"tel","email","endereco",
								"bairro","cidade","estado",
								"cep","data","cpf",
								"rg","id_cliente","complemento",
								"numero","fax","telcel",
								"outros","tipo","status",
								"ramal","faturamento","id_usuario_com");
		$this->values = array("contato"=>$c->contato,"senha"=>$c->senha,"nome"=>$c->nome,
								"tel"=>$c->tel,"email"=>$c->email,"endereco"=>$c->endereco,
								"bairro"=>$c->bairo,"cidade"=>$c->cidade,"estado"=>$c->estado,
								"cep"=>$c->cep,"data"=>date("Y-m-d H:i:s"),"cpf"=>$c->cpf,
								"rg"=>$c->rg,"id_cliente"=>$c->id_cliente,"complemento"=>$c->complemento,
								"numero"=>$c->numero,"fax"=>$c->fax,"telcel"=>$c->telcel,
								"outros"=>$c->outros,"tipo"=>$c->tipo,"status"=>$c->status,
								"ramal"=>$c->ramal,"faturamento"=>$c->faturamento,"id_usuario_com"=>$c->id_usuario_com);
		return $this->insert();
	}

	public function selectPorId($id,$id_empresa=null){
		$this->sql = "SELECT uc.*, c.conveniado FROM vsites_user_conveniado as uc, vsites_user_usuario as uu, vsites_user_cliente as c
						WHERE uc.id_conveniado=? and uc.id_cliente=c.id_cliente and 
							c.id_usuario=uu.id_usuario";
		$this->values = array($id);
		if($id_empresa!=null){
			$this->sql .=" and uu.id_empresa=?";
			$this->values[]=$id_empresa;
		}
		$ret = $this->fetch();
		return $ret[0];
	}

	public function atualizar($c){
		$this->sql = "UPDATE vsites_user_conveniado SET faturamento=?, contato=?, nome=?,
								tel=?, email=?, id_cliente=?,
								cpf=?, rg=?, endereco=?,
								cidade=?, estado=?, bairro=?,
								cep=?, complemento=?, numero=?,
								tipo=?, fax=?, telcel=?,
								outros=?,  ramal=?, status=?,id_usuario_com=? 
					WHERE id_conveniado=?";

		$this->values=array($c->faturamento,$c->contato,$c->nome,
		$c->tel,$c->email,$c->id_cliente,
		$c->cpf,$c->rg,$c->endereco,
		$c->cidade,$c->estado,$c->bairro,
		$c->cep,$c->complemento,$c->numero,
		$c->tipo,$c->fax,$c->telcel,
		$c->outros,$c->ramal,$c->status,$c->id_usuario_com,$c->id_conveniado);
		$this->exec();
	}
	
	public function atualizaSenha($c){
		$this->sql = "update vsites_user_conveniado set senha = ? WHERE id_conveniado = ?";
		$this->values = array($c->senha_new, $c->id_conveniado);
		$this->exec();
	}
	
	#Atualizado 11/05/2011 - Rafael
	public function atualizarSenhaConveniado($senha, $id){
		$this->sql = "update vsites_user_conveniado set senha = ? WHERE id_conveniado = ?";
		$this->values = array($senha, $id);
		$this->exec();
	}
	
	public function BuscaConveniado($lista){
		$_SESSION['consulta_sql'] = '';
		$sql1 =  "SELECT pi.data_prazo, pi.id_servico, pi.ordem, pi.id_pedido_item, pi.data_atividade, ";
		$sql1 .= "a.atividade, s.status, pi.id_pedido, pi.certidao_devedor, pi.certidao_nome, pi.certidao_matricula, pi.certidao_cpf, ";
		$sql1 .= "pi.certidao_cnpj, pi.inicio, ss.descricao as servico, pi.certidao_devedor, pi.certidao_cidade, pi.certidao_estado, ";
		$sql1 .= "pi.certidao_resultado, pi.operacional ";
		$sql1 .= "FROM vsites_pedido AS p, vsites_pedido_item AS pi, vsites_status AS s, vsites_atividades AS a, vsites_servico AS ss ";
		$sql2 = "WHERE ";
		$sql2 .= "(p.id_conveniado='".$lista->conveniado_id_cliente."') ";
		$sql2 .= "AND (pi.encerramento='0000-00-00' OR pi.encerramento >= '".date('Y-m',strtotime("-6 month"))."') ";
		$sql2 .= "AND (p.id_pedido = pi.id_pedido) AND ((CASE pi.id_atividade WHEN 0 THEN 172 ELSE pi.id_atividade END)= a.id_atividade) "; 
		$sql2 .= "AND ((CASE pi.id_status WHEN 0 THEN 1 ELSE pi.id_status END) =s.id_status) AND (pi.id_servico = ss.id_servico) "; 
		$sql2 .= "AND (pi.inicio >= '".$lista->busca_data_i."' or pi.inicio='0000-00-00 00:00:00') AND (pi.inicio <= '".$lista->busca_data_f."') ";
		
		if(strlen($lista->busca_controle_cliente) > 0){ 
			$sql2  .= "AND ( replace(pi.controle_cliente,' ','') = replace('".$lista->busca_controle_cliente."',' ','') ) "; 
		}
		if($lista->busca_data_i_co != ''){ 
			$sql2  .= "AND (pi.operacional >= '".$lista->busca_data_i_co."') "; 
		}
		if($lista->busca_data_f_co != ''){ 
			$sql2  .= "AND (pi.operacional <= '".$lista->busca_data_f_co."') "; 
		}
		if($lista->busca_id_pacote != ''){ 
			$sql2  .= "AND (p.id_pacote = ".$lista->busca_id_pacote.") AND (pi.pacote_lib = 1) "; 
		}
		if($lista->busca_id_departamento != ''){ 
			$sql2  .= "AND (pi.id_servico_departamento = ".$lista->busca_id_departamento.") "; 
		}
		if($lista->busca_id_status == 'Todos'){
			$lista->busca_id_status = '';
			$sql2  .= "AND (pi.id_status != 14) ";
		}
		if($lista->busca_id_status == 'Cad/Sol/Des/Exe/Ret'){
			 $sql2  .= "AND ( pi.id_status IN ('3','4','5','6','7') ) ";
		} else {
			if($lista->busca_id_status <> ''){
				if($lista->busca_id_status == '14'){
					$sql2  .= "AND (pi.id_atividade = '200') ";
				} else {
					$sql2 .= "AND (pi.id_status = '".$lista->busca_id_status."') ";
				}
			} else {
				$sql2  .= "AND (pi.id_status != '14') ";
			}
		}
		if($lista->busca_id_servico != ''){ 
			$sql2 .= "AND (pi.id_servico = ".$lista->busca_id_servico.") "; 
		}
		if($lista->busca_id_pedido != ''){ 
			$sql2 .= "AND (pi.id_pedido = ".$lista->busca_id_pedido.") ";
		}
		if($lista->busca_ordem != ''){ 
			$sql2 .=  "AND (pi.ordem = ".$lista->busca_ordem.") "; 
		}
		
		if($lista->busca != 0 and $lista->campo<>''){
			$sql2 .= "AND (1 = 1 ";
			switch($lista->busca){
				case 1:
					$sql2 .= "AND (pi.certidao_nome LIKE '".$lista->campo."%' ) "; 
					break;
				case 2:
					$cnpj = $lista->campo;
					$cnpj = str_replace('.', '', $cnpj);
					$cnpj = str_replace('/', '', $cnpj);
					$cnpj = str_replace('-', '', $cnpj);
					if(strlen($cnpj)==10 or strlen($cnpj)==13)$cnpj='0'.$cnpj;
					$sql2 .=  "AND ( replace(replace(replace(pi.certidao_cpf,'.',''),'/',''),'-','') LIKE '".$cnpj."%' ) ";
					$sql2 .=  "OR ( replace(replace(replace(pi.certidao_cnpj,'.',''),'/',''),'-','') LIKE '".$cnpj."%' ) ";
				break;
				
				case 3:
					
					$cnpj = $lista->campo;
					$cnpj = str_replace('.', '', $cnpj);
					$cnpj = str_replace('/', '', $cnpj);
					$cnpj = str_replace('-', '', $cnpj);
					if(strlen($cnpj)==10 or strlen($cnpj)==13)$cnpj='0'.$cnpj;
					$sql2 .=  "AND ( replace(replace(replace(pi.certidao_devedor_cpf,'.',''),'/',''),'-','') LIKE '%".$cnpj."' ) ";
				#break;
				case 4:
					$sql2 .= "OR (pi.certidao_devedor LIKE '".$lista->campo."%' ) ";
				break;
				case 5:
					$sql2 .= "AND (pi.certidao_nome LIKE '".$lista->campo."%' ) "; 
				break;
				case 6:
					$sql2 .= "AND (pi.certidao_matricula LIKE '".$lista->campo."%') ";
				break;
			}
			$sql2 .= ") ";		
		}
		$sql2 .= "ORDER BY ";
		#echo $sql2;
		#exit();
		switch($lista->busca_ordenar){
			case 'Documento de': $sql2 .= " pi.certidao_nome "; break;
			case 'Ordem': $sql2 .= " pi.id_pedido, pi.ordem "; break;
			case 'Serviço': $sql2 .= " pi.id_servico "; break;
			case 'Data': $sql2 .= " pi.inicio "; break;
			case 'Cidade': $sql2 .= " pi.certidao_cidade "; break;
			case 'Estado': $sql2 .= " pi.certidao_estado "; break;
			default:
				$sql2 .= " pi.id_pedido, pi.ordem ";
			break;
		}
		$sql2 .= $lista->busca_ord;	
		
		#1ª consulta - pega a quantidade de registros		
		$sql3 = "SELECT COUNT( * ) AS 'total' ";
		$sql3 .= "FROM vsites_pedido AS p, vsites_pedido_item AS pi, vsites_status AS s, vsites_atividades AS a, vsites_servico AS ss ";
		$sql3 .= $sql2;
		$_SESSION['consulta_sql2'] = $sql3;
		$this->sql = $sql3;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
					
		#2ª consulta
		$sql = $sql1.$sql2;
		$_SESSION['consulta_sql'] = $sql;
		$sql .= " LIMIT " . $lista->ini .', '.$lista->fim;
		$this->sql = $sql;
		$ret = $this->fetch();		
			
		#retorna valores
		return $ret;
	}
	
	public function SessionBuscaConveniado($lista){
		$sql = $_SESSION['consulta_sql'];
		$sql .= " LIMIT " . $lista->ini .', '.$lista->fim;
		$this->sql = $sql;
		$ret = $this->fetch();	
		
		$this->sql = $_SESSION['consulta_sql2'];
		$cont = $this->fetch();
		$this->total = $cont[0]->total;	
		
		return $ret;
	}
	
	public function GeraExportaTodos(){
		$sql = $_SESSION['consulta_sql'];
		$this->sql = $sql;
		$ret = $this->fetch();	
		return $ret;
	}
	
	public function Download($lista){
		switch($lista->acao){
			case 1:
				$sql = "SELECT pa.anexo FROM vsites_pedido_anexo AS pa, vsites_pedido_item as pi, vsites_pedido AS p ";
				$sql.= "WHERE pa.id_pedido_item='".$lista->id."' AND (pa.anexo_nome='Certidão' OR ";
				$sql.= "pa.anexo_nome='Declaração de Busca' OR pa.anexo_nome='Declaração de Busca de Imóveis' OR ";
				$sql.= "pa.anexo_nome='Instrumento de Protesto' OR pa.anexo_nome='Documento do Cliente') ";
				$sql.= "AND pa.id_pedido_item = pi.id_pedido_item and pi.id_pedido=p.id_pedido AND p.id_conveniado='".$lista->conveniado_id_cliente."'";
			break;
			
			case 2:
				if($lista->id_ser != '11' and $lista->id_ser != '16' and $lista->id_ser != '64'){
					$sql =  "SELECT pa.anexo_nome FROM vsites_pedido_anexo AS pa, vsites_pedido_item AS pi, ";
					$sql .= "vsites_pedido AS p WHERE pa.id_pedido_item='".$lista->id."' AND (pa.anexo_nome='Certidão' OR ";
					$sql .= "pa.anexo_nome='Instrumento de Protesto' OR pa.anexo_nome='Documento do Cliente') ";
					$sql .= "AND pa.id_pedido_item = pi.id_pedido_item AND pi.id_pedido=p.id_pedido AND ";
					$sql .= "p.id_conveniado='".$lista->conveniado_id_cliente."'";
					
				} else {
					$anexo =  "SELECT pi.id_pedido_item, pi.certidao_cnpj, pi.certidao_cpf, pi.certidao_devedor ";
					$anexo .= "FROM vsites_pedido_item AS pi, vsites_pedido AS p WHERE ";
					$anexo .= "p.id_conveniado='".$lista->conveniado_id_cliente."' AND p.id_pedido=pi.id_pedido AND pi.id_status!='14' ";
					$anexo .= "AND (pi.id_servico='11' OR pi.id_servico='16' OR pi.id_servico='64')";
					$sql  = "SELECT pa.anexo, pi.certidao_cnpj, pi.certidao_cpf, pi.certidao_devedor FROM ";
					$sql .= "vsites_pedido_anexo AS pa, vsites_pedido_item as pi, (".$anexo.") AS pi2, vsites_pedido AS p ";
					$sql .= "WHERE pi.id_pedido_item='".$lista->id."' AND pi.id_pedido=p.id_pedido AND p.id_conveniado='".$lista->conveniado_id_cliente."' AND ";
					$sql .= "pi.certidao_devedor=pi2.certidao_devedor AND pi.certidao_devedor!='' AND ";
					$sql .= "pi2.id_pedido_item=pa.id_pedido_item AND (pa.anexo_nome='Certidão' OR ";
					$sql .= "pa.anexo_nome='Declaração de Busca de Imóveis' OR pa.anexo_nome='Declaração de Busca' OR ";
					$sql .= "pa.anexo_nome='Instrumento de Protesto' OR pa.anexo_nome='Documento do Cliente')";
					
				}
			break;
		}	
		$this->sql = $sql;
		$ret = $this->fetch();
		return $ret;
	}
}
?>