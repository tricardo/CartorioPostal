<?php

class EmpresaDAO extends Database {

    public function __construct() {
        parent::__construct();
        $this->table = 'vsites_user_empresa';
        $this->maximo = 50;
    }

    public function listar($busca="", $pagina=1) {
        $this->sql = "SELECT count(0) as total
					FROM vsites_user_empresa emp
					WHERE (emp.cidade=? or emp.estado like ? or emp.nome like ? or emp.email like ? or emp.empresa like ? or fantasia like ?)";
        $this->values = array($busca, "%$busca%", "%$busca%", "%$busca%", "%$busca%", "%$busca%");
        $cont = $this->fetch();
        $this->total = $cont[0]->total;

        $this->link = 'busca=' . $busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        $this->sql = "SELECT id_empresa, nome, fantasia, franquia, status,email
					FROM vsites_user_empresa emp
					WHERE (emp.cidade=? or emp.nome like ? or emp.email like ? or emp.empresa like ? or emp.fantasia like ?)
					ORDER BY nome ASC LIMIT " . $this->getInicio() . ", " . $this->maximo;
        $this->values = array($busca, "%$busca%", "%$busca%", "%$busca%", "%$busca%");
        return $this->fetch();
    }

    public function listarTodas($ids=null) {
        $this->sql = "SELECT id_empresa, TRIM(REPLACE(fantasia,'Cartório Postal - ','')) as fantasia , imposto, royalties, empresa, cpf, tipo, cep, endereco, complemento, numero, inicio, sem1, sem2, sem3, roy_min, roy_min2, inauguracao_data,validade_contrato,email
						FROM vsites_user_empresa as ue WHERE status = 'Ativo' ";
        $this->values = array();
        if ($ids != null) {
            $this->sql .= ' AND ( ';
            foreach ($ids as $i => $id) {
                if ($i > 0)
                    $this->sql.= ' OR ';
                $this->sql .= ' id_empresa = ? ';
                $this->values[] = $id;
            }
            $this->sql .= ' ) ';
        }
        $this->sql .= " ORDER BY fantasia";
        return $this->fetch();
    }

    public function listarTodasStatus($ids=null) {
        $this->sql = "SELECT id_empresa, TRIM(REPLACE(fantasia,'Cartório Postal - ','')) as fantasia , imposto, royalties, empresa, cpf, tipo, cep, endereco, complemento, numero, inicio, sem1, sem2, sem3, roy_min, roy_min2, inauguracao_data,validade_contrato,email
						FROM vsites_user_empresa as ue WHERE status in ('Ativo','Inativo') ";
        $this->values = array();
        if ($ids != null) {
            $this->sql .= ' AND ( ';
            foreach ($ids as $i => $id) {
                if ($i > 0)
                    $this->sql.= ' OR ';
                $this->sql .= ' id_empresa = ? ';
                $this->values[] = $id;
            }
            $this->sql .= ' ) ';
        }
        $this->sql .= " ORDER BY fantasia";
        return $this->fetch();
    }
	
    public function listarTodasCronRoy() {
        $this->sql = "SELECT id_empresa, TRIM(REPLACE(fantasia,'Cartório Postal - ','')) as fantasia , imposto, royalties, empresa, cpf, tipo, cep, endereco, complemento, numero, inicio, sem1, sem2, sem3, roy_min, roy_min2, inauguracao_data,validade_contrato,email
						FROM vsites_user_empresa as ue WHERE status = 'Ativo' ";
        $this->values = array();
        $this->sql .= " ORDER BY id_empresa";
        return $this->fetch();
    }
	
    public function listarTodasFranquias() {
        $this->sql = "SELECT SQL_CACHE id_empresa, TRIM(REPLACE(fantasia,'Cartório Postal - ','')) as fantasia ,tel, fax, cep, endereco, complemento, numero, bairro, cidade, estado
						FROM vsites_user_empresa as ue ORDER BY id_empresa";
        $this->values = array();
        return $this->fetch();
    }

    public function validaDirecionamento($id_empresa, $id_empresa_resp) {
        $this->sql = "select fantasia from vsites_user_empresa as ue where ue.id_empresa='" . $id_empresa_resp . "' and
                ue.status='Ativo' and ue.id_empresa != '" . $id_empresa . "'";
        $this->values = array();
        $ret = $this->fetch();
        return $ret[0];
    }

    #lista de empresas com royalties atrasados utilizado pelo cron

    public function listarRoyAtrasado() {
        $this->sql = "SELECT ue.id_empresa, ue.email, TRIM(REPLACE(ue.fantasia,'Cartório Postal - ','')) as fantasia , cf.valor, cf.valor_pago
						FROM vsites_user_empresa as ue
						INNER JOIN vsites_conta_fatura as cf ON cf.id_empresa_franquia=ue.id_empresa
						WHERE ue.status = 'Ativo' and 
						ue.id_empresa!=1 and
						cf.valor>cf.valor_pago and
						date_format(cf.vencimento,'%Y-%m')='" . date('Y-m') . "'";
        $this->values = array();
        if ($ids != null) {
            $this->sql .= ' AND ( ';
            foreach ($ids as $i => $id) {
                if ($i > 0)
                    $this->sql.= ' OR ';
                $this->sql .= ' id_empresa = ? ';
                $this->values[] = $id;
            }
            $this->sql .= ' ) ';
        }
        $this->sql .= "ORDER BY fantasia";
        return $this->fetch();
    }

    /**
     * lista as empresas que assinaram o adendo
     */
    public function listaAdendo() {
        $this->sql = "SELECT e.*,b.banco, TRIM(REPLACE(fantasia,'Cartório Postal - ','')) as fantasia
					FROM vsites_user_empresa e
					LEFT JOIN vsites_banco b ON e.id_banco = b.id_banco and e.id_banco<>''
					WHERE adendo=true and e.status='Ativo'";
        $this->values = array();
        $empresas = $this->fetch();

        $this->sql = 'SELECT id_empresa,cidade,estado FROM vsites_franquia_regiao WHERE id_empresa=? GROUP BY id_empresa,estado,cidade order by estado, cidade';
        foreach ($empresas as $e) {
            $this->values = array($e->id_empresa);
            $e->regioes = $this->fetch();
        }
        return $empresas;
    }

    public function listarTodasN($id_empresa) {
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'EmpresaDAO-listarTodasN' . $id_empresa . '.csv';
        $verifica = $cachediaCLASS->VerificaCache($filename);

        if ($verifica == false) {
            $this->sql = "SELECT id_empresa, fantasia from vsites_user_empresa as uu where id_empresa!=? and status='Ativo' order by fantasia";
            $this->values = array($id_empresa);
            $ret = $this->fetch();
            $campos = "id_empresa;fantasia";
            $geracsv = $cachediaCLASS->ConvertArrayToCsv($filename, $ret, $campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;
    }

    public function listarTodasRoy() {
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'EmpresaDAO-listarTodasRoy.csv';
        $verifica = $cachediaCLASS->VerificaCache($filename);

        if ($verifica == false) {
            $this->sql = "SELECT id_empresa, fantasia from vsites_user_empresa as uu where id_empresa!=1 and (status='Ativo' or status='Cancelado') order by fantasia";
            $this->values = array();
            $ret = $this->fetch();
            $campos = "id_empresa;fantasia";
            $geracsv = $cachediaCLASS->ConvertArrayToCsv($filename, $ret, $campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;
    }

    /**
     * retorna as empresas, que não tenham o id_empresa = ao parametro passado
     *
     * @param int $id_empresa
     */
    public function listarDiff($id_empresa) {
        $this->sql = "SELECT id_empresa, TRIM(REPLACE(fantasia,'Cartório Postal - ','')) as fantasia , imposto,royalties
						FROM vsites_user_empresa as ue WHERE id_empresa!=? and status='Ativo' order by fantasia";
        $this->values = array($id_empresa);
        return $this->fetch();
    }

    /**
     * retorna a lista de todos os usuários do atendimento exceto os cancelados
     */
    public function listarAtendenteEmpresa($id_empresa) {
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'EmpresaDAO-listarAtendenteEmpresa' . $id_empresa . '.csv';
        $verifica = $cachediaCLASS->VerificaCache($filename);

        if ($verifica == false) {
            $this->sql = "SELECT uu.id_usuario, uu.nome, uu.departamento_p, ue.fantasia from vsites_user_usuario as uu, vsites_user_empresa as ue where uu.id_empresa!=? and ue.id_empresa=uu.id_empresa and uu.status='Ativo' and ue.status='Ativo' and uu.departamento_p like '%6%' group by ue.id_empresa order by ue.fantasia";
            $this->values = array($id_empresa);
            $ret = $this->fetch();
            $campos = "id_usuario;fantasia";
            $geracsv = $cachediaCLASS->ConvertArrayToCsv($filename, $ret, $campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;
    }

    /**
     * busca uma empresa pelo id
     * @param int $id_emrpesa
     */
    public function selectPorId($id_empresa) {

        $this->sql = "SELECT * FROM vsites_user_empresa as ue WHERE id_empresa = ?";
        $this->values = array($id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * conta a quantidade de usuários de uma empres
     * @param int $id_empresa
     * @return int
     */
    public function getQntUsuarios($id_empresa) {
        $this->sql = "SELECT count(0) as usuarios FROM vsites_user_usuario as uu where id_empresa=?";
        $this->values = array($id_empresa);
        $return = $this->fetch();
        return $return[0]->usuarios;
    }

    /**
     * insere uma empresa no BD
     * @param $empresa
     * @return int
     */
    public function insertRoyAtrasado($email, $html, $assunto) {
        $this->table = 'vsites_alerta_roy';
        $this->values = array('email' => $email, 'html' => $html, 'assunto' => $assunto);
        $this->fields = array('email', 'html', 'assunto');
        return $this->insert();
    }

    /**
     * insere uma empresa no BD
     * @param $empresa
     * @return int
     */
    public function inserir($empresa) {
        $this->values = array('fantasia' => $empresa->fantasia,
            'imposto' => $empresa->imposto, 'royalties' => $empresa->royalties,
            'nome' => $empresa->nome, 'cel' => $empresa->cel,
            'tel' => $empresa->tel, 'email' => $empresa->email,
            'endereco' => $empresa->endereco, 'bairro' => $empresa->bairro,
            'cidade' => $empresa->cidade, 'estado' => $empresa->estado,
            'cep' => $empresa->cep, 'data' => $empresa->data,
            'cpf' => $empresa->cpf, 'rg' => $empresa->rg,
            'empresa' => $empresa->empresa, 'tipo' => $empresa->tipo,
            'complemento' => $empresa->complemento, 'numero' => $empresa->numero,
            'ramal' => $empresa->ramal, 'status' => $empresa->status, 'franquia' => $empresa->franquia,
            'adendo' => $empresa->adendo,
            'id_banco' => $empresa->id_banco, 'agencia' => $empresa->agencia,
            'conta' => $empresa->conta, 'favorecido' => $empresa->favorecido,
            'adendo_data' => $empresa->adendo_data, 'inauguracao_data' => $empresa->inauguracao_data, 'validade_contrato' => $empresa->validade_contrato,
            'precontrato' => $empresa->precontrato, 'aditivo' => $empresa->aditivo, 
			'franquia_tipo' => $empresa->franquia_tipo, 'id_recursivo' => $empresa->id_recursivo,
			'inicio' => $empresa->inicio, 'sem1' => $empresa->sem1, 'sem2' => $empresa->sem2,
			'sem3' => $empresa->sem3, 'roy_min' => $empresa->roy_min, 'roy_min2' => $empresa->roy_min2);
        $this->fields = array('fantasia',
            'imposto', 'royalties',
            'nome', 'cel',
            'tel', 'email',
            'endereco', 'bairro',
            'cidade', 'estado',
            'cep', 'data',
            'cpf', 'rg',
            'empresa', 'tipo',
            'complemento', 'numero',
            'ramal', 'status', 'franquia',
            'adendo',
            'id_banco', 'agencia',
            'conta', 'favorecido',
            'adendo_data', 'inauguracao_data', 'validade_contrato',
            'precontrato', 'aditivo','franquia_tipo','id_recursivo','inicio','sem1',
			'sem2','sem3','roy_min','roy_min2');
        $this->insert();
    }

    /**
     * atualiza os dados de uma empresa
     * @param unknown_type $empresa
     */
    public function atualizar($empresa) {
        global $controle_id_usuario;
        $this->sql = "update vsites_user_empresa set
				nome=?,fantasia=?,
				imposto=?,royalties=?,
				cel=?,tel=?,
				email=?,endereco=?,
				bairro=?,cidade=?,
				estado=?,cep=?, 
				data=?,cpf=?,
				rg=?,empresa=?,
				tipo=?,complemento=?, 
				numero=?,ramal=?, 
				status=?,franquia=?, 
				id_banco=?,agencia=?,
				conta=?,favorecido=?,
				adendo=?,adendo_data=?,
				inauguracao_data=?,validade_contrato=?,
				data_cof=?, exclusividade=?,
				notificacao=?,precontrato=?,
				aditivo=?,franquia_tipo=?,id_recursivo=? ";

        $this->values = array(
            $empresa->nome, $empresa->fantasia,
            $empresa->imposto, $empresa->royalties,
            $empresa->cel, $empresa->tel,
            $empresa->email, $empresa->endereco,
            $empresa->bairro, $empresa->cidade,
            $empresa->estado, $empresa->cep,
            $empresa->data, $empresa->cpf,
            $empresa->rg, $empresa->empresa,
            $empresa->tipo, $empresa->complemento,
            $empresa->numero, $empresa->ramal,
            $empresa->status, $empresa->franquia,
            $empresa->id_banco, $empresa->agencia,
            $empresa->conta, $empresa->favorecido,
            $empresa->adendo, $empresa->adendo_data,
            $empresa->inauguracao_data, $empresa->validade_contrato,
            $empresa->data_cof, $empresa->exclusividade,
            $empresa->notificacao, $empresa->precontrato,
            $empresa->aditivo,$empresa->franquia_tipo,
			$empresa->id_recursivo);
        
        if($controle_id_usuario==1){
            $this->sql .= " ,inicio=?, sem1=?, sem2=?, sem3=?, roy_min=?, roy_min2=?";
            $this->values[] = $empresa->inicio;
            $this->values[] = $empresa->sem1;
            $this->values[] = $empresa->sem2;
            $this->values[] = $empresa->sem3;
            $this->values[] = $empresa->roy_min;
            $this->values[] = $empresa->roy_min2;            
        }
        $this->values[] = $empresa->id_empresa;
        $this->sql .= " where id_empresa=?";

        $this->exec();
    }

}

?>