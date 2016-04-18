<?php

class PedidoDAO extends Database {

    public function __construct() {
        parent::__construct();
        $this->table = 'vsites_pedido';
    }
    
    public function concluido_operacional($controle_id_departamento_p = '', $id_usuario = '', $id_conveniado = '', $data_prazo_inc = '', $busca_data_i_co = '', $busca_data_f_co = '', $controle_id_empresa = ''){
        $departamento_p = "'".str_replace(',' ,"','",$controle_id_departamento_p)."A'";

        $where_usuario = ($id_usuario!='')?' AND uu.id_usuario = '.$id_usuario:'';
        $where_conveniado = '';
        if($id_conveniado!=''){
                if($id_conveniado>0)
                $where_conveniado = ' AND p.id_conveniado = '.$id_conveniado ;
                else
                $where_conveniado = ' AND p.id_conveniado != '.($id_conveniado*-1);
        }

        $this->sql = "select ".$data_prazo_inc ." as prazo, uu.nome as responsavel, p.contato, pi.data_atividade, pi.id_pedido, pi.operacional, pi.ordem, pi.inicio, st.status, pi.certidao_cpf, pi.certidao_cnpj, pi.certidao_nome, pi.certidao_cidade, pi.certidao_estado, pi.certidao_resultado, pi.motivo_atraso, s.descricao as servico, a.atividade, uu.nome,p.id_conveniado
        from vsites_pedido as p, vsites_pedido_item as pi, vsites_status as st, vsites_servico as s, vsites_atividades as a, vsites_servico_departamento as sd, vsites_user_usuario as uu 
        where
        pi.operacional>='".$busca_data_i_co."' and pi.operacional<='".$busca_data_f_co."' and pi.id_servico_departamento=sd.id_servico_departamento and sd.id_departamento_resp IN (".$departamento_p.") and pi.id_usuario_op=uu.id_usuario and (uu.id_empresa='".$controle_id_empresa."' or pi.id_empresa_resp = '".$controle_id_empresa."') and
        pi.id_servico = s.id_servico and pi.id_status=st.id_status and pi.id_atividade=a.id_atividade and pi.id_status!='14' and p.id_pedido=pi.id_pedido ".
        $where_usuario." ". $where_conveniado;
        return $this->fetch();
    }

    /**
     *
     * @param unknown_type $id_emrpesa
     */
    public function listaAtrasados($data_i, $data_f) {
        if ($data_i == '')
            $data_i = date('Y-m-d');
        if ($data_f == '')
            $data_f = date('Y-m-d');
        $this->sql = "SELECT pi.id_pedido,pi.ordem,pi.id_usuario,pi.atraso,pi.motivo_atraso,uu.nome,uu.email
			 FROM vsites_pedido_item pi
			 INNER JOIN vsites_user_usuario uu ON uu.id_usuario = pi.id_usuario
			 WHERE uu.id_empresa=1 and pi.atraso>=? and pi.atraso<=?
			 ORDER BY uu.id_usuario";
        $this->values = array($data_i, $data_f);
        return $this->fetch();
    }

    /**
     * lista pedidos em aberto para gerar relatório
     * @param int $id_empresa
     */
    public function listarEmAberto($id_empresa) {
        $this->sql = 'SELECT pi.id_pedido,pi.id_usuario,pi.data,u.nome as atendente,pi.ordem
						FROM vsites_pedido_item pi 
						INNER JOIN vsites_pedido pe ON pe.id_pedido=pi.id_pedido
						INNER JOIN vsites_user_usuario u ON pi.id_usuario=u.id_usuario
						WHERE u.id_empresa=? and pi.id_status=1
						ORDER BY pi.data DESC';
        $this->values = array($id_empresa);
        return $this->fetch();
    }

    /**
     * lista pedidos em aberto para gerar relatório
     * @param int $id_empresa
     */
    public function pedidoExporta($id_empresa, $id_pedido_item, $exibicao) {

        $sql_usuario_resp = " CASE WHEN pi.id_usuario_op != 0 THEN (SELECT uu_resp.nome from vsites_user_usuario as uu_resp where  uu_resp.id_usuario=pi.id_usuario_op) ELSE ('') END";

        $this->sql = "SELECT 
                    (" . $sql_usuario_resp . ") as responsavel, 
                    pi.id_pedido, pi.ordem, pi.inicio, pi.operacional, pi.data_atividade,
                    pi.certidao_nome, pi.certidao_nome_proprietario,pi.id_servico,pi.certidao_requerente,pi.certidao_cpf,
                    pi.certidao_cnpj,pi.certidao_devedor,pi.certidao_estado, pi.certidao_cidade, certidao_resultado,
                    pi.id_empresa_atend, pi.id_empresa_resp, pi.operacional,  pi.valor, pi.data_i, pi.data_prazo,
                    p.nome, p.tipo, p.cpf, p.data, p.cpf, p.nome, p.cidade, p.estado, p.contato,
                    st.status, a.atividade, s.descricao as servico, sd.departamento,uu.nome as atendente
                from vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as uu, vsites_atividades as a, 
                vsites_servico as s, vsites_status as st, vsites_servico_departamento as sd where 
                    pi.id_pedido_item IN (" . $id_pedido_item . ") and
                    (pi.id_empresa_atend=? or pi.id_empresa_resp=?) and
                    pi.id_pedido = p.id_pedido and
                    pi.id_servico = s.id_servico and
                    pi.id_usuario = uu.id_usuario and		
                    pi.id_atividade = a.id_atividade and
                    pi.id_servico_departamento = sd.id_servico_departamento and
                    pi.id_status = st.id_status limit 3000";
        
        $this->values = array($id_empresa, $id_empresa);
        return $this->fetch();
    }

    /**
     * lista pedidos em conciliacao para gerar relatório
     * @param int $id_empresa
     */
    public function listarConciliacao($id_empresa) {
        $this->sql = 'SELECT pi.id_pedido,pi.id_usuario,pi.data,u.nome as atendente,pi.ordem
						FROM vsites_pedido_item pi 
						INNER JOIN vsites_pedido pe ON pe.id_pedido=pi.id_pedido
						INNER JOIN vsites_user_usuario u ON pi.id_usuario=u.id_usuario
						WHERE u.id_empresa=? AND pi.id_status=2
						ORDER BY pi.data DESC';
        $this->values = array($id_empresa);
        return $this->fetch();
    }

    /**
     * lista pedidos em conciliacao franquia para gerar relatório
     * @param int $id_empresa
     */
    public function listarConciliacaoFranquia($id_empresa) {
        $this->sql = 'SELECT pi.id_pedido,pi.id_usuario,pi.data_atividade,u.nome as atendente,pi.ordem
						FROM vsites_pedido_item pi 
						INNER JOIN vsites_pedido pe ON pe.id_pedido=pi.id_pedido
						INNER JOIN vsites_user_usuario u ON pi.id_usuario=u.id_usuario
						WHERE u.id_empresa=? AND pi.id_status=19
						ORDER BY pi.data DESC';
        $this->values = array($id_empresa);
        return $this->fetch();
    }

    /**
     * lista pedidos em conciliacao para gerar relatório
     * @param int $id_empresa
     */
    public function listarOrcamento($id_empresa) {
        $this->sql = 'SELECT pi.id_pedido,pi.id_usuario,pi.data,u.nome as atendente,pi.ordem
						FROM vsites_pedido_item pi 
						INNER JOIN vsites_pedido pe ON pe.id_pedido=pi.id_pedido
						INNER JOIN vsites_user_usuario u ON pi.id_usuario=u.id_usuario
						WHERE u.id_empresa=? AND pi.id_status=16
						ORDER BY pi.data DESC';
        $this->values = array($id_empresa);
        return $this->fetch();
    }

    /**
     * lista pedidos pendentes, para gerar relatório de pedidos
     * @param int $id_empresa
     */
    public function listarPendente($id_empresa) {
        $this->sql = 'SELECT pi.id_pedido,pi.id_usuario,pi.data,u.nome as atendente,pi.ordem,pi.inicio,pi.motivo_atraso
						FROM vsites_pedido_item pi 
						INNER JOIN vsites_pedido pe ON pe.id_pedido=pi.id_pedido
						INNER JOIN vsites_user_usuario u ON pi.id_usuario=u.id_usuario
						WHERE u.id_empresa=? AND pi.id_status=12
						ORDER BY pi.data DESC';
        $this->values = array($id_empresa);
        return $this->fetch();
    }

    /**
     * lista pedidos que foram alterados para 'CONFIRMAÇÃO' no dia
     * @param int $id_empresa
     */
    public function listarConfirmacao($id_empresa) {
        $this->sql = 'SELECT pi.id_pedido,pi.id_usuario,pi.data,pi.ordem,pi.id_status,pe.id_pedido,pi.ordem,pe.email,u.email
						FROM vsites_pedido_item pi
						INNER JOIN vsites_pedido pe ON pe.id_pedido=pi.id_pedido
						INNER JOIN vsites_user_usuario u ON pi.id_usuario=u.id_usuario
						WHERE u.id_empresa=? AND pi.data_atividade > ? AND pi.data_atividade < ? AND pi.id_status=? AND pi.email<>\'\'
						ORDER BY u.id_usuario DESC';
        $this->values = array($id_empresa, date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'), 11);
        return $this->fetch();
    }

    /**
     * lista pedidos que estão em 'CONFIRMAÇÃO' há 7 dias
     * @param int $id_empresa
     */
    public function listarConfirmacaoPendente($id_empresa) {
        $this->sql = 'SELECT pi.id_pedido_item, pi.id_pedido,pi.id_usuario,pi.data,pi.ordem,pi.id_status,pe.id_pedido,pi.ordem
						FROM vsites_pedido_item pi 
						INNER JOIN vsites_pedido pe ON pe.id_pedido=pi.id_pedido
						INNER JOIN vsites_user_usuario u ON pi.id_usuario=u.id_usuario
						WHERE u.id_empresa=? AND pi.data_atividade > ? AND pi.data_atividade < ? AND pi.id_status=?
						ORDER BY pi.data DESC';
        $this->values = array($id_empresa, date('Y-m-d 00:00:00', time() - (10 * 24 * 60 * 60)), date('Y-m-d 23:59:59', time() - (10 * 24 * 60 * 60)), 11);
        return $this->fetch();
    }

    /**
     * cancela o pedido
     * @param Int $id_pedido
     * @param Int $id_usuario
     */
    public function direcionaUserCobranca($id_pedido, $id_usuario) {
        $this->sql = 'UPDATE vsites_pedido SET id_usuario_cb = ? WHERE id_pedido = ?';
        $this->values = array($id_usuario, $id_pedido);
        $this->exec();
    }

    /**
     * cancela o pedido
     * @param Pedido $p
     */
    public function cancelaAutomaticamente($p) {
        $this->sql = 'UPDATE vsites_pedido_item SET id_status = 14, data_atividade=? WHERE id_pedido_item = ?';
        $this->values = array(date('Y-m-d H:i:s'), $p->id_pedido_item);
        $this->exec();

        $this->sql = 'INSERT INTO vsites_pedido_status (id_pedido_item, id_atividade, id_usuario,data_i,status_obs) VALUES (?,?,?,?,?)';
        $this->values = array($p->id_pedido_item, 124, 1, date('Y-m-d H:i:s'), 'pedido cancelado automaticamente [em CONFIRMAÇÃO HÁ 7 DIAS]');
        $this->exec();
    }

    /**
     * busca um pedido item pelo id
     * @param int $id_pedido_item
     * @param int $id_empresa
     */
    public function buscaPorId($id_pedido_item, $id_empresa) {
        if($id_empresa!=0){
            $onde = " (pi.id_empresa_atend='".$id_empresa."' or pi.id_empresa_resp='".$id_empresa."') and ";
        } else {
            $onde = '';
        }
        
        $this->sql = "SELECT pi.*, s.descricao as servico, pi.id_empresa_atend as id_empresa from vsites_pedido_item as pi, vsites_servico as s where
		pi.id_pedido_item=? and
		".$onde."
		pi.id_servico=s.id_servico";
        $this->values = array($id_pedido_item);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * busca um pedido item pelo id
     * @param int $id_pedido_item
     * @param int $id_empresa
     */
    public function buscaPorIdOficio($id_pedido, $ordem, $id_empresa) {
        $this->sql = "SELECT pi.id_pedido_item,pi.id_empresa_atend, pi.id_status, pi.id_pedido, pi.certidao_cidade, pi.certidao_estado, pi.id_servico, pi.ordem, pi.certidao_nome, pi.certidao_cnpj, 
					pi.certidao_cpf, s.descricao as servico, uu.nome as responsavel, uu.email as responsavel_email, 
					e.empresa, e.fantasia, e.endereco, e.numero, e.email, e.complemento, e.cidade, e.estado, e.tel, e.cep, e.fax 
					from vsites_pedido_item as pi, vsites_user_usuario as uu, vsites_servico as s, vsites_user_empresa e  
					where 
					pi.id_pedido=? and
					pi.ordem=? and
					(pi.id_empresa_atend=? or pi.id_empresa_resp=?) and
					pi.id_servico=s.id_servico and
					pi.id_usuario=uu.id_usuario and 
					uu.id_empresa=e.id_empresa";
        $this->values = array($id_pedido, $ordem, $id_empresa, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * busca um pedido, com seus itens pelo id
     * @param int $id_pedido
     * @param int $id_empresa
     */
    public function buscaPedidoComItens($id_pedido, $id_empresa) {
        $this->sql = "SELECT p.* from vsites_pedido as p WHERE p.id_pedido=?";
        $this->values = array($id_pedido);
        $ret = $this->fetch();

        $this->sql = "SELECT pi.*,s.descricao as servico,d.departamento
		FROM vsites_pedido_item as pi,
		vsites_servico as s,
		vsites_servico_departamento as d
		WHERE
		pi.id_pedido=? and
		pi.id_empresa_atend = ? and 
		pi.id_status!=14 and
		pi.id_servico = s.id_servico and 
		pi.id_servico_departamento = d.id_servico_departamento 
		ORDER BY ordem";
        $this->values = array($id_pedido, $id_empresa);
        $itens = $this->fetch();
        $ret[0]->itens = $itens;
        return $ret[0];
    }

    public function buscaPedidoPorId($id_pedido) {
        $this->sql = "SELECT p.* from vsites_pedido as p WHERE p.id_pedido=?";
        $this->values = array($id_pedido);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * verifica cadastro do cliente e da insert caso negativo
     * @param array $p
     */
    public function verificaCliente($p) {

        $this->sql = "SELECT count(0) as total from vsites_user_cliente as uc where cpf=?";
        $this->values = array($p->cpf);

        $cont = $this->fetch();
        $total = $cont[0]->total;

        if ($total == '0' and $p->id_cliente == '') {
            $clienteDAO = new ClienteDAO();
            $p->status = 'Ativo';
            $p->conveniado = 'Não';
            $p->site = '';
            $p->im = '';
            $p->id_usuario_com = '';
            $clienteDAO->inserir($p);
            return '<br><br>Usuário Adicionado como cliente<br><br>';
        }

        return '';
    }

    /**
     * verifica duplicidade
     * @param array $p
     */
    public function verificaDuplicidade($p) {

        $this->sql = "SELECT count(0) as total from
			vsites_pedido_item as pi, vsites_pedido as p where 
				pi.id_servico_var=? and 
				pi.id_servico=? and
				pi.id_status!='10' and pi.id_status!='14' and	
				pi.id_pedido=p.id_pedido and 
				p.cpf=? and
				(pi.certidao_nome=? and pi.certidao_nome!='' or 
				 pi.certidao_cnpj=? and pi.certidao_cnpj!='' or 
				 pi.certidao_cpf=? and pi.certidao_cpf!='' or 
				 pi.certidao_mae=? and pi.certidao_mae!='' or 
				 pi.certidao_pai=? and pi.certidao_pai!='' or 
				 pi.certidao_matricula=? and pi.certidao_matricula!='' or 
				 pi.certidao_livro=? and pi.certidao_livro!='' or 
				 pi.certidao_folha=? and pi.certidao_folha!='' or 
				 pi.certidao_esposa=? and pi.certidao_esposa!='' or 
				 pi.certidao_devedor=? and pi.certidao_devedor!='')";

        $this->values = array($p->id_servico_var,
            $p->id_servico,
            $p->cpf,
            $p->certidao_nome,
            $p->certidao_cnpj,
            $p->certidao_cpf,
            $p->certidao_mae,
            $p->certidao_pai,
            $p->certidao_matricula,
            $p->certidao_livro,
            $p->certidao_folha,
            $p->certidao_esposa,
            $p->certidao_devedor);

        $cont = $this->fetch();
        $total = $cont[0]->total;
        return $total;
    }

    /**
     * verifica regiao ao adicionar um pedido
     * @param array $p
     */
    public function verificaRegiao($p) {
        $this->sql = "SELECT fr.loja, fr.id_empresa, ue.fantasia, ue.id_pais
			from vsites_franquia_regiao as fr, vsites_user_empresa as ue where 
				replace(fr.cep_i,'-','')<=replace(?,'-','') and 
				replace(fr.cep_f,'-','')>=replace(?,'-','') and 
				fr.id_empresa=ue.id_empresa and ue.status='Ativo' order by Field(fr.id_empresa,?) desc";
        $this->values = array($p->cep, $p->cep, $p->id_empresa_atend);
		$ret = $this->fetch();	
        return $ret[0];
    }

    public function inserirPedido($p) {
        $this->table = 'vsites_pedido';
        $this->fields = array('id_pacote', 'nome', 'id_conveniado',
            'id_ponto', 'email', 'cpf', 'rg',
            'tipo', 'cidade', 'data', 'pagamento',
            'id_usuario', 'origem', 'endereco',
            'numero', 'complemento', 'bairro', 'cep',
            'estado', 'tel', 'tel2', 'ramal',
            'ramal2', 'fax', 'outros', 'retem_iss',
            'restricao', 'forma_pagamento', 'dados_bancarios', 'contato', 'contato_rg',
            'omesmo', 'endereco_f', 'numero_f', 'complemento_f',
            'bairro_f', 'cep_f', 'estado_f', 'cidade_f',
            'cabecalho', 'rodape', 'retirada');
        $this->values = array('id_pacote' => $p->id_pacote, 'nome' => $p->nome, 'id_conveniado' => $p->id_conveniado
            , 'id_ponto' => $p->id_ponto, 'email' => $p->email, 'cpf' => $p->cpf, 'rg' => $p->rg
            , 'tipo' => $p->tipo, 'cidade' => $p->cidade, 'data' => date('Y-m-d H:i:s'), 'pagamento' => $p->pagamento
            , 'id_usuario' => $p->id_usuario, 'origem' => $p->origem, 'endereco' => $p->endereco
            , 'numero' => $p->numero, 'complemento' => $p->complemento, 'bairro' => $p->bairro, 'cep' => $p->cep
            , 'estado' => $p->estado, 'tel' => $p->tel, 'tel2' => $p->tel2, 'ramal' => $p->ramal
            , 'ramal2' => $p->ramal2, 'fax' => $p->fax, 'outros' => $p->outros, 'retem_iss' => $p->retem_iss
            , 'restricao' => $p->restricao, 'forma_pagamento' => $p->forma_pagamento, 'dados_bancarios' => $p->dados_bancarios, 'contato' => $p->contato, 'contato_rg' => $p->contato_rg
            , 'omesmo' => $p->omesmo, 'endereco_f' => $p->endereco_f, 'numero_f' => $p->numero_f, 'complemento_f' => $p->complemento_f
            , 'bairro_f' => $p->bairro_f, 'cep_f' => $p->cep_f, 'estado_f' => $p->estado_f, 'cidade_f' => $p->cidade_f
            , 'cabecalho' => $p->cabecalho, 'rodape' => $p->rodape, 'retirada' => $p->retirada);
        $id_pedido = $this->insert();
        return $id_pedido;
    }

    /**
     * insere um pedido e pedido no BD
     * @param unknown_type $p
     */
    public function inserir($p) {
        $p->data = date('Y-m-d G:m:s');
        $id_pedido = $this->inserirPedido($p);
        $ordem = $this->inserir_item($p, $id_pedido);
        return '#' . $id_pedido . '/' . $ordem;
    }

    /**
     * atualiza um pedido_item no BD
     * @param unknown_type $p
     * @param int $id_pedido_item
     * @param int $id_usuario
     */
    public function atualizaPedidoItem($p, $id_pedido_item, $id_usuario) {
        $servicosDAO = new ServicoDAO();
        $servicocampos = $servicosDAO->listaCampos($p->id_servico);

        $this->sql = "update vsites_pedido_item set urgente=?, obs=?, valor=?, controle_cliente=?, dias=?, data_prazo=?, id_servico_var=?, motivo_atraso=?, certidao_resultado=?, custas=?";
        $this->values = array($p->urgente, $p->obs, $p->valor, $p->controle_cliente, $p->dias, $p->data_prazo, $p->id_servico_var, $p->motivo_atraso, $p->certidao_resultado, $p->custas);

        if ($p->ocor == "0" and $p->certidao_ocorrencia <> "") {
            $this->sql .= ", ocor=1";
        }

        if ($p->regi == "0" and $p->certidao_registro <> "") {
            $this->sql .= ", regi='1'";
        }

        foreach ($servicocampos as $servicocampo) {
            $this->sql .= ", " . $servicocampo->campo . "=?";
            $this->values[] = $p->{$servicocampo->campo};
        }
        $this->sql .= " where id_pedido_item=?";
        $this->values[] = $id_pedido_item;
        $this->exec();
    }

    /**
     * atualiza o status de um pedido item
     * data_i, id_atividade, id_status, id_usuario_op, id_usuario_op2
     * id_empresa_resp
     *
     * @param pedidoItem $pItem
     */
    public function atualizaPedidoItemStatus($pItem, $direcionaFran=false) {
        $this->values = array($pItem->id_atividade);
        $where = '';
        if ($pItem->id_status <> '') {
            $where .= ', id_status=?';
            $this->values[] = $pItem->id_status;
        }
        if ($pItem->id_atividade == 215) {
            $where .= ', notificada=1';
        }

        if (isset($pItem->id_usuario_op) AND $pItem->id_usuario_op <> '' || $direcionaFran) {
            $where .= ', id_usuario_op=?';
            $this->values[] = $pItem->id_usuario_op;
        }

        if (isset($pItem->id_usuario_op2) AND $pItem->id_usuario_op2 <> '') {
            $where .= ', id_usuario_op2=?';
            $this->values[] = $pItem->id_usuario_op2;
        }

        if (isset($pItem->id_empresa_resp) AND $pItem->id_empresa_resp <> '') {
            $where .= ', id_empresa_resp=?';
            $this->values[] = $pItem->id_empresa_resp;
        }

        if ($pItem->id_atividade <> '') {
            $where .= ', id_atividade = ?';
            $this->values[] = $pItem->id_atividade;
        }

        if ($pItem->data_atividade <> '') {
            $where .= ', data_atividade = ?';
            $this->values[] = $pItem->data_atividade;
        }

        if ($pItem->dias <> '') {
            $where .= ', dias = ?';
            $this->values[] = $pItem->dias;
        }

        if (isset($pItem->encerramento) AND $pItem->encerramento <> '') {
            $where .= ', encerramento = ?';
            $this->values[] = $pItem->encerramento;
        }

        $this->sql = "update vsites_pedido_item set data_i=NOW(), id_atividade=? " . $where . " where id_pedido_item=?";
        $this->values[] = $pItem->id_pedido_item;
        $this->exec();
    }

    /**
     * atualiza um pedido no BD
     * @param unknown_type $p
     * @param int $id_pedido
     * @param int $id_usuario
     */
    public function atualizaPedido($p, $id_pedido, $id_usuario) {
        $this->sql = "update vsites_pedido set id_pacote=?, comissionado=?, id_ponto=?, retirada=?,
										origem=?, tipo=?, contato=?, contato_rg=?, 
										nome=?, forma_pagamento=?, tel2=?, tel=?, 
										ramal=?, ramal2=?, fax=?, outros=?, 
										email=?, cpf=?, rg=?, tipo=?, 
										omesmo=?, numero_f=?, endereco_f=?, cidade_f=?, 
										estado_f=?, bairro_f=?, cep_f=?, complemento_f=?, 
										endereco=?, cidade=?, estado=?, bairro=?, 
										cep=?, complemento=?, restricao=?, retem_iss=?, 
										numero=?, dados_bancarios=? where id_pedido=?";
        $this->values = array($p->id_pacote, $p->comissionado, $p->id_ponto, $p->retirada,
            $p->origem, $p->tipo, $p->contato, $p->contato_rg,
            $p->nome, $p->forma_pagamento, $p->tel2, $p->tel,
            $p->ramal, $p->ramal2, $p->fax, $p->outros,
            $p->email, $p->cpf, $p->rg, $p->tipo,
            $p->omesmo, $p->numero_f, $p->endereco_f, $p->cidade_f,
            $p->estado_f, $p->bairro_f, $p->cep_f, $p->complemento_f,
            $p->endereco, $p->cidade, $p->estado, $p->bairro,
            $p->cep, $p->complemento, $p->restricao, $p->retem_iss,
            $p->numero, $p->dados_bancarios, $id_pedido);
        $this->exec();
    }

    /**
     * insere um pedido, pedido_item e pedido_status no BD
     * @param unknown_type $p
     * @param int $id_pedido
     */
    public function inserir_item($p, $id_pedido) {
		global $controle_id_empresa;
        unset($this->fields);
        unset($this->values);
        $this->table = 'vsites_pedido_item';

        $data = date('Y-m-d H:i:s');
        $servicosDAO = new ServicoDAO();
        $servicocampos = $servicosDAO->listaCampos($p->id_servico);

        #gera o numero da ordem
        $contaordem = $this->contaOrdens($id_pedido);
        $ordem = (int) ($contaordem->total) + 1;
		
		#pega o id empresa cdt
		$id_empresa_dir = $this->listaCDT($p->certidao_cidade, $p->certidao_estado, $id_pedido, $controle_id_empresa);

        $this->fields = array();
        $this->values = array();
        $this->fields[] = 'controle_cliente';
        $this->fields[] = 'data_atividade';
        $this->fields[] = 'id_atividade';
        $this->fields[] = 'id_status';
        $this->fields[] = 'urgente';
        $this->fields[] = 'ordem';
        $this->fields[] = 'id_pedido';
        $this->fields[] = 'data';
        $this->fields[] = 'id_usuario';
        $this->fields[] = 'id_empresa_atend';
        $this->fields[] = 'id_empresa_dir';		
        $this->fields[] = 'id_servico';
        $this->fields[] = 'valor';
        $this->fields[] = 'dias';
        $this->fields[] = 'obs';
        $this->fields[] = 'id_servico_var';
        $this->fields[] = 'id_servico_departamento';
        $this->fields[] = 'duplicidade';

        $this->values['controle_cliente'] = $p->controle_cliente;
        $this->values['data_atividade'] = $data;
        if($p->direcionamento==''){
            $this->values['id_atividade'] = '172';
            $this->values['id_status'] = '1';
        }else{
            $this->values['id_atividade'] = '0';
            $this->values['id_status'] = '0';            
        }
        $this->values['urgente'] = $p->urgente;
        $this->values['ordem'] = $ordem;
        $this->values['id_pedido'] = $id_pedido;
        $this->values['data'] = $data;
        $this->values['id_usuario'] = $p->id_usuario;
        $this->values['id_empresa_atend'] = $p->id_empresa_atend;
		$this->values['id_empresa_dir'] = $id_empresa_dir;
        $this->values['id_servico'] = $p->id_servico;
        $this->values['valor'] = $p->valor;
        $this->values['dias'] = $p->dias;
        $this->values['obs'] = $p->obs;
        $this->values['id_servico_var'] = $p->id_servico_var;
        $this->values['id_servico_departamento'] = $p->id_servico_departamento;
        $this->values['duplicidade'] = $p->duplicidade;


        foreach ($servicocampos as $servicocampo) {
            $this->fields[] = $servicocampo->campo;
            $this->values[$servicocampo->campo] = $p->{$servicocampo->campo};
        }
		
        $id_pedido_item = $this->insert();

        unset($this->fields);
        unset($this->values);
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
        $atividade = $atividadeDAO->inserir('172', '', $p->id_usuario, $id_pedido_item);
	
		
		
        return $ordem;
    }

    /**
     * contabiliza a quantidade de servicos excluindo os cancelados
     * @param int $id_pedido
     */
    public function contaOrdemFechado($id_pedido) {
        $this->sql = "SELECT 
		(SELECT COUNT(0) as total from vsites_pedido_item as pi where id_pedido=? and id_status!=14) as fechado, 
		(SELECT COUNT(0) as total from vsites_pedido_item as pi where id_pedido=? and id_status=10) as concluido";
        $this->values = array($id_pedido, $id_pedido);
        $cont = $this->fetch();
        return $cont[0];
    }

    public function contaOrdens($id_pedido) {
        $this->sql = "SELECT valor, id_status, ordem from vsites_pedido_item as pi where id_pedido=?";
        $this->values = array($id_pedido);
        $ret = $this->fetch();
        $total = 0;
        foreach ($ret as $c) {
            if ($c->id_status != 14)
                $valor = (float) ($valor) + (float) ($c->valor);
            if ($c->ordem > $total)
                $total = $c->ordem;
        }
        $ret[0]->total = $total;
        $ret[0]->valor = $valor;
        return $ret[0];
    }

    /**
     * lista origem
     */
    public function listarOrigem() {
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'PedidoDAO-listarOrigem.csv';
        $verifica = $cachediaCLASS->VerificaCache($filename);

        if ($verifica == false) {
            $this->sql = "SELECT * from vsites_origem as o where status='Ativo' order by origem";
            $this->values = array();
            $ret = $this->fetch();
            $campos = "id_origem;origem;status";
            $geracsv = $cachediaCLASS->ConvertArrayToCsv($filename, $ret, $campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;
    }

    /**
     * Seleciona os dados do servico anterior ao adicionar um novo servico
     * @param int $id_pedido
     * @param int $ordem
     * @param int $id_empresa
     */
    public function selectPorId($id_pedido, $ordem, $id_empresa) {
        $this->sql = "SELECT sd.departamento, p.cpf, pi.* from vsites_pedido as p, vsites_pedido_item as pi, vsites_servico_departamento as sd
				where pi.id_pedido=? and pi.ordem=? and pi.id_empresa_atend=? and pi.id_servico_departamento=sd.id_servico_departamento and pi.id_pedido=p.id_pedido limit 1";
        $this->values = array($id_pedido, $ordem, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * seleciona os dados de um pedido
     * @param int $id_pedido
     * @param int $ordem
     * @param int $id_empresa
     */
    public function selectPedidoPorId($id_pedido, $ordem, $id_empresa=null) {
        $this->sql = "SELECT pi.id_status, p.*,pi.id_empresa_resp,pi.id_empresa_atend, pi.id_pedido_item from 
			vsites_pedido_item as pi, vsites_pedido as p
		where pi.id_pedido=? and pi.ordem=? and pi.id_pedido=p.id_pedido ";
        $this->values = array($id_pedido, $ordem);
        if ($id_empresa != null) {
            $this->sql.=" and pi.id_empresa_atend=? ";
            $this->values[] = $id_empresa;
        }
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * busca um pedido item pelo id_pedido_item
     * @param int $id_pedido_item
     */
    public function selectPedidoItemPorId($id_pedido_item, $id_empresa=null) {
        if ($id_empresa == null) {
            $this->sql = "SELECT * FROM vsites_pedido_item as pi WHERE id_pedido_item=?";
            $this->values = array($id_pedido_item);
        } else {
            $this->sql = "SELECT pi.*, s.descricao as servico, uu.nome as responsavel, uu.email as responsavel_email,
							p.id_pedido,p.data, p.nome, p.endereco, p.numero, p.complemento, p.bairro, p.cidade, p.estado, p.cep,p.contato,p.id_conveniado,
							e.empresa, e.fantasia, e.endereco, e.numero, e.email, e.complemento, e.cidade, e.estado, e.tel, e.cep, e.fax, e.cpf as cnpj 
						from 
						vsites_pedido_item as pi, vsites_user_usuario as uu, vsites_servico as s, vsites_pedido as p, vsites_user_empresa e  
						where pi.id_pedido_item=? and 
						(pi.id_empresa_atend=? or pi.id_empresa_resp=?) and
						pi.id_servico=s.id_servico and 
						pi.id_usuario_op=uu.id_usuario and 
						pi.id_pedido=p.id_pedido and 
						uu.id_empresa=e.id_empresa";
            $this->values = array($id_pedido_item, $id_empresa, $id_empresa);
        }
        $ret = $this->fetch();
        return $ret[0];
    }

    public function selecPedidoPorIdOficio($id_pedido_item, $id_empresa, $cartorios=false) {
        $this->sql = "SELECT p.nome,p.id_afiliado,uu_resp.nome as responsavel,uu_resp.email as responsavel_email,
				pi.*, date_format(pi.data_prazo,'%d/%m/%Y') as data_prazo, 
				st.status, u.id_empresa, sd.departamento, s.descricao as servico, sv.variacao,
				p.id_pedido, p.nome, p.endereco, p.numero, p.complemento, p.bairro, p.cidade, p.estado, p.cep,p.contato,p.id_conveniado,
				e.empresa, e.fantasia, e.endereco, e.numero, e.email, e.complemento, e.cidade, e.estado, e.tel, e.cep, e.fax, e.cpf as cnpj
				
		from vsites_status as st, vsites_servico as s, vsites_servico_var as sv, vsites_servico_departamento as sd, vsites_pedido as p, vsites_pedido_item as pi, vsites_user_usuario as u,vsites_user_empresa e,vsites_user_usuario as uu_resp 
		where
		pi.id_pedido_item=? and
		pi.id_pedido=p.id_pedido and
		pi.id_usuario=u.id_usuario and
		e.id_empresa = u.id_empresa and
		(u.id_empresa=? or pi.id_empresa_resp=?) and
		st.id_status=pi.id_status and
		pi.id_servico_departamento=sd.id_servico_departamento and
		pi.id_servico=s.id_servico and
		uu_resp.id_usuario=pi.id_usuario_op and
		pi.id_servico_var=sv.id_servico_var limit 1";
        $this->values = array($id_pedido_item, $id_empresa, $id_empresa);
        $ret = $this->fetch();

        if ($cartorios) {
            $this->sql = "SELECT pc.*, ca.atribuicao, c.nome,c.endereco,c.numero,c.complemento,c.bairro,c.cep,c.cidade,c.estado,c.tel,c.tel2,c.ramal,c.ramal2
			 from
			vsites_pedido_cartorio as pc, vsites_cartorio_atribuicoes as ca, vsites_cartorio as c where 
			pc.id_pedido_item=? and			
			pc.cartorio_atribuicao = ca.id_atribuicao and
			pc.cartorio_cartorio = c.id_cartorio
			order by id_pedido_cartorio desc";
            $this->values = array($id_pedido_item);
            $ret[0]->cartorios = $this->fetch();
        }
        return $ret[0];
    }

    /**
     * seleciona os dados de um pedido para editar
     * @param int $id_pedido
     * @param int $ordem
     * @param int $id_empresa
     */
    public function selectPedidoEditPorId($id_pedido, $ordem, $id_empresa) {
        $this->sql = "SELECT pi.*, date_format(pi.data_prazo,'%d/%m/%Y') as data_prazo, 
				pi.id_empresa_atend as id_empresa, st.status, sd.departamento, s.descricao as servico, sv.variacao,
				p.nome, p.endereco, p.numero, p.complemento, p.bairro, p.cidade, p.estado, p.cep, p.contato, p.id_conveniado
		from vsites_pedido_item as pi, vsites_pedido as p, vsites_status as st, vsites_servico as s, vsites_servico_var as sv, vsites_servico_departamento as sd
		where
		pi.id_pedido=? and
		pi.ordem=? and
		(pi.id_empresa_atend=? or pi.id_empresa_resp=?) and
		pi.id_pedido=p.id_pedido and
		pi.id_status=st.id_status and
		pi.id_servico_departamento=sd.id_servico_departamento and
		pi.id_servico=s.id_servico and
		pi.id_servico_var=sv.id_servico_var limit 1";
        $this->values = array($id_pedido, $ordem, $id_empresa, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * seleciona os dados de um pedido para editar
     * @param int $id_pedido
     * @param int $ordem
     * @param int $id_empresa
     */
    public function selectPedidoEditPorIdNovo($id_pedido, $ordem, $id_empresa, $campos) {
        if($id_empresa!=0){
            $onde = " (pi.id_empresa_atend='".$id_empresa."' or pi.id_empresa_resp='".$id_empresa."') and ";
        } else {
            $onde = '';
        }
        $this->sql = "SELECT
            pi.id_pedido_item, pi.id_pedido, pi.ordem, pi.id_servico, pi.id_servico_var, pi.id_status, pi.dias,pi.valor,pi.id_fatura,pi.urgente,
            pi.controle_cliente,pi.custas,pi.certidao_resultado,pi.id_servico_departamento, pi.motivo_atraso,pi.certidao_sequencia,pi.obs,
            pi.ocor, pi.regi " . $campos . ",
            date_format(pi.data_prazo,'%d/%m/%Y') as data_prazo, 
            pi.id_empresa_atend as id_empresa, pi.id_empresa_resp, 
            st.status, sd.departamento, s.descricao as servico, sv.variacao,
            p.nome, p.endereco, p.numero, p.complemento, p.bairro, p.cidade, p.estado, p.cep, p.contato, p.id_conveniado, p.id_afiliado
		from vsites_pedido_item as pi, vsites_pedido as p, vsites_status as st, vsites_servico as s, vsites_servico_var as sv, vsites_servico_departamento as sd
		where
		pi.id_pedido=? and
		pi.ordem=? and
		".$onde."
		pi.id_pedido=p.id_pedido and
		pi.id_status=st.id_status and
		pi.id_servico_departamento=sd.id_servico_departamento and
		pi.id_servico=s.id_servico and
		pi.id_servico_var=sv.id_servico_var limit 1";
        $this->values = array($id_pedido, $ordem);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * seleciona um pedido para gerar ofício
     * 
     * @param int $id_pedido_item
     * @param int $id_empresa
     */
    public function selectPorIdOficio($id_pedido_item, $id_empresa) {
        $this->sql = "SELECT pi.*, u.nome as responsavel, u.email as responsavel_email 
			from vsites_pedido_item as pi, vsites_user_usuario as u 
			where pi.id_pedido_item=? and u.id_usuario=pi.id_usuario_op and (u.id_empresa=? or pi.id_empresa_resp=?)";
        $this->values = array($id_pedido_item, $id_empresa, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * insere um cartorio no pedido item
     * @param int $id_pedido_item
     * @param int $id_usuario
     * @param unknown_type $c
     */
    public function inserirCartorio($id_pedido_item, $id_usuario, $c) {

        unset($this->fields);
        unset($this->values);
        $this->table = 'vsites_pedido_cartorio';

        $data = date('Y-m-d G:m:s');

        $this->fields = array();
        $this->values = array();
        $this->fields[] = 'id_pedido_item';
        $this->fields[] = 'id_usuario';
        $this->fields[] = 'data';
        $this->fields[] = 'cartorio_estado';
        $this->fields[] = 'cartorio_cidade';
        $this->fields[] = 'cartorio_atribuicao';
        $this->fields[] = 'cartorio_cartorio';

        $this->values['id_pedido_item'] = $id_pedido_item;
        $this->values['id_usuario'] = $id_usuario;
        $this->values['data'] = $data;
        $this->values['cartorio_estado'] = $c->cartorio_estado;
        $this->values['cartorio_cidade'] = $c->cartorio_cidade;
        $this->values['cartorio_atribuicao'] = $c->cartorio_atribuicao;
        $this->values['cartorio_cartorio'] = $c->cartorio_cartorio;

        return $this->insert();
    }

    /**
     * desconsidera um cartorio do pedido item
     * @param int $id_usuario
     * @param int $id_pedido_cartorio
     * @param int $id_pedido_item
     */
    public function desconsideraCartorio($id_usuario, $id_pedido_cartorio, $id_pedido_item) {
        $this->sql = "update vsites_pedido_cartorio set desconsiderar='Sim', id_usuario_d=?, data_d=NOW() where id_pedido_cartorio=? and id_pedido_item=? and desconsiderar!='Sim'";
        $this->values = array($id_usuario, $id_pedido_cartorio, $id_pedido_item);
        $this->exec();
    }

    /**
     * insere um anexo no pedido item
     * @param unknown_type $ane
     */
    public function inserirAnexo($ane) {

        unset($this->fields);
        unset($this->values);
        $this->table = 'vsites_pedido_anexo';

        $this->fields = array();
        $this->values = array();

        $this->fields[] = 'anexo';
        $this->fields[] = 'anexo_nome';
        $this->fields[] = 'id_pedido_item';
        $this->fields[] = 'id_usuario';

        $this->values['anexo'] = $ane->anexo;
        $this->values['anexo_nome'] = $ane->anexo_nome;
        $this->values['id_pedido_item'] = $ane->id_pedido_item;
        $this->values['id_usuario'] = $ane->id_usuario;

        $this->insert();

        $atividadeDAO = new AtividadeDAO();
        $ativ = $atividadeDAO->inserir('209', '', $ane->id_usuario, $ane->id_pedido_item);

        return 1;
    }

    /**
     * deleta anexo do pedido
     * @param int $id_pedido_item
     * @param int $id_pedido_anexo
     * @param int $id_usuario
     */
    public function deletaAnexoPedido($id_pedido_item, $id_pedido_anexo, $id_usuario) {
        $this->sql = "delete from vsites_pedido_anexo where id_pedido_item=? and id_pedido_anexo=?";
        $this->values = array($id_pedido_item, $id_pedido_anexo);
        $this->exec();
        $atividadeDAO = new AtividadeDAO();
        $ativ = $atividadeDAO->inserir('210', '', $id_usuario, $id_pedido_item);
        return 1;
    }

    /**
     *
     * @param $data
     * @param $id_empresa
     * @param $id_usuario
     * @param $origem
     */
    public function contaItensOrcamento($data, $id_empresa, $id_usuario='', $origem='') {
        $this->sql = "SELECT count(0) as num_orcamento
						FROM vsites_pedido_item as pi, vsites_pedido as p
						WHERE pi.id_status='16' and pi.data >= ? and  pi.data <= ? and pi.id_empresa_atend=? and pi.id_pedido=p.id_pedido";
        $this->values = array($data . ' 00:00:00', $data . ' 23:59:59', $id_empresa);
        if ($id_usuario <> '') {
            $this->sql .= " and pi.id_usuario=?";
            $this->values[] = $id_usuario;
        }
        if ($origem <> '') {
            $this->values[] = $origem;
            $this->sql .= " and p.origem=? ";
        }
        $res = $this->fetch();
        return $res[0]->num_orcamento;
    }

    public function contaItensDuplicidade($data, $id_empresa, $id_usuario='', $origem='') {
        $this->sql = "SELECT count(0) as num_duplicidade
						FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u 
						WHERE pi.id_atividade='200' and pi.data >= ? and  pi.data <= ? and pi.id_usuario=u.id_usuario and u.id_empresa=? and pi.id_pedido=p.id_pedido ";
        $this->values = array($data . ' 00:00:00', $data . ' 23:59:59', $id_empresa);
        if ($id_usuario <> '') {
            $this->sql .= " and pi.id_usuario=?";
            $this->values[] = $id_usuario;
        }
        if ($origem <> '') {
            $this->values[] = $origem;
            $this->sql .= " and p.origem=? ";
        }
        $res = $this->fetch();
        return $res[0]->num_duplicidade;
    }

    public function contaItensFaltaDados($data, $id_empresa, $id_usuario='', $origem='') {
        $this->sql = "SELECT count(pi.id_pedido_item) as num_faltadedados
						FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u
						WHERE pi.id_atividade='204' and pi.data >= ? and  pi.data <= ? and pi.id_usuario=u.id_usuario and u.id_empresa=? and pi.id_pedido=p.id_pedido ";
        $this->values = array($data . ' 00:00:00', $data . ' 23:59:59', $id_empresa);
        if ($id_usuario <> '') {
            $this->sql .= " and pi.id_usuario=?";
            $this->values[] = $id_usuario;
        }
        if ($origem <> '') {
            $this->values[] = $origem;
            $this->sql .= " and p.origem=? ";
        }
        $res = $this->fetch();
        return $res[0]->num_faltadedados;
    }

    public function contaItensCancelados($data, $id_empresa, $id_usuario='', $origem='') {
        $this->sql = "SELECT count(0) as num_cancelados
						FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u 
						WHERE pi.id_status='14' and pi.id_atividade!='200' and pi.id_atividade!='204' and (pi.atendimento >= ? and  pi.atendimento <= ? or pi.data >= ? and  pi.data <= ? and  pi.atendimento = '0000-00-00 00:00:00') and pi.id_usuario=u.id_usuario and u.id_empresa=? and pi.id_pedido=p.id_pedido ";
        $this->values = array($data . ' 00:00:00', $data . ' 23:59:59', $data . ' 00:00:00', $data . ' 23:59:59', $id_empresa);
        if ($id_usuario <> '') {
            $this->sql .= " and pi.id_usuario=?";
            $this->values[] = $id_usuario;
        }
        if ($origem <> '') {
            $this->values[] = $origem;
            $this->sql .= " and p.origem=? ";
        }
        $res = $this->fetch();
        return $res[0]->num_cancelados;
    }

    public function contaItensRecebidos($data, $id_empresa, $id_usuario='', $origem='') {
        $this->sql = "SELECT count(0) as num_recebidos
						FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u 
						WHERE pi.data >= ? and  pi.data <= ? and pi.id_usuario=u.id_usuario and u.id_empresa=? and pi.id_pedido=p.id_pedido ";
        $this->values = array($data . ' 00:00:00', $data . ' 23:59:59', $id_empresa);
        if ($id_usuario <> '') {
            $this->sql .= " and pi.id_usuario=?";
            $this->values[] = $id_usuario;
        }
        if ($origem <> '') {
            $this->values[] = $origem;
            $this->sql .= " and p.origem=? ";
        }
        $res = $this->fetch();
        return $res[0]->num_recebidos;
    }

    public function contaItensAbertos($data, $id_empresa, $id_usuario='', $origem='') {
        $this->sql = "SELECT count(0) as num_abertos
						FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u 
						WHERE pi.id_status='1' and pi.data >= ? and  pi.data <= ? and pi.id_usuario=u.id_usuario and u.id_empresa=? and pi.id_pedido=p.id_pedido ";
        $this->values = array($data . ' 00:00:00', $data . ' 23:59:59', $id_empresa);
        if ($id_usuario <> '') {
            $this->sql .= " and pi.id_usuario=?";
            $this->values[] = $id_usuario;
        }
        if ($origem <> '') {
            $this->values[] = $origem;
            $this->sql .= " and p.origem=? ";
        }
        $res = $this->fetch();
        return $res[0]->num_abertos;
    }

    public function contaItensPendente($data, $id_empresa, $id_usuario='', $origem='') {
        $this->sql = "SELECT count(0) as num_pendente
					FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u 
					WHERE pi.id_status='12' and pi.data >= ? and  pi.data <= ? and pi.id_usuario=u.id_usuario and u.id_empresa=? and pi.id_pedido=p.id_pedido ";
        $this->values = array($data . ' 00:00:00', $data . ' 23:59:59', $id_empresa);
        if ($id_usuario <> '') {
            $this->sql .= " and pi.id_usuario=?";
            $this->values[] = $id_usuario;
        }
        if ($origem <> '') {
            $this->values[] = $origem;
            $this->sql .= " and p.origem=? ";
        }
        $res = $this->fetch();
        return $res[0]->num_pendente;
    }

    public function relDesempenhoPorAtendente($data, $id_empresa, $id_usuario='', $origem='') {
        $this->sql = "SELECT pi.data, pi.inicio, pi.dias, pi.id_status, pi.encerramento
					FROM vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u 
					WHERE pi.id_status!='14' and pi.atendimento >= ? and  pi.atendimento <= ? and pi.id_usuario=u.id_usuario and u.id_empresa=? and pi.id_pedido=p.id_pedido ";
        $this->values = array($data . ' 00:00:00', $data . ' 23:59:59', $id_empresa);
        if ($id_usuario <> '') {
            $this->sql .= " and pi.id_usuario=?";
            $this->values[] = $id_usuario;
        }
        if ($origem <> '') {
            $this->values[] = $origem;
            $this->sql .= " and p.origem=? ";
        }
        return $this->fetch();
    }

    public function buscaDirecionamento($busca, $pagina=1) {
        $url_busca = $_SERVER['REQUEST_URI'];
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $url_busca), $url_busca_pos + 5);
        $onde = '';
        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        $busca_ordenar_por_ord = 'ASC';
        if ($busca->busca_ord == 'Decr'){
            $busca_ordenar_por_ord = ' DESC ';
        }
        $busca_ordenar_por = ' p.data ' . $busca_ordenar_por_ord . ', pi.id_pedido, pi.ordem ' . $busca_ordenar_por_ord;
        if ($busca->busca_ordenar == 'Ordem')
            $busca_ordenar_por = ' pi.id_pedido ' . $busca_ordenar_por_ord; else
        if ($busca->busca_ordenar == 'Documento de')
            $busca_ordenar_por = ' pi.certidao_nome ' . $busca_ordenar_por_ord; else
        if ($busca->busca_ordenar == 'Serviço')
            $busca_ordenar_por = ' pi.id_servico ' . $busca_ordenar_por_ord; else
        if ($busca->busca_ordenar == 'Data')
            $busca_ordenar_por = ' pi.data ' . $busca_ordenar_por_ord; else
        if ($busca->busca_ordenar == 'Cidade')
            $busca_ordenar_por = ' pi.certidao_estado ' . $busca_ordenar_por_ord . ', pi.certidao_cidade ' . $busca_ordenar_por_ord; else
        if ($busca->busca_ordenar == 'Estado')
            $busca_ordenar_por = ' pi.certidao_estado ' . $busca_ordenar_por_ord; else
        if ($busca->busca_ordenar == 'Departamento')
            $busca_ordenar_por = ' pi.id_servico_departamento ' . $busca_ordenar_por_ord; else
        if ($busca->busca_ordenar == 'Prazo')
            $busca_ordenar_por = $data_prazo_inc . $busca_ordenar_por_ord; else
        if ($busca->busca_ordenar == 'Data Atividade')
            $busca_ordenar_por = ' pi.data_atividade ' . $busca_ordenar_por_ord; else
        if ($busca->busca_ordenar == 'Agenda')
            $busca_ordenar_por = ' pi.data_i' . $busca_ordenar_por_ord . ', pi.status_hora ' . $busca_ordenar_por_ord;

        if (count($busca->estado_dir) > 0) {
            $est = array();
            for($i = 0; $i < count($busca->estado_dir); $i++){
                $est[] = "'".$busca->estado_dir[$i]."'";
            }
            $onde .= " and pi.certidao_estado IN (" . implode(',',$est) . ") ";
        }
        $busca->busca_data_i = invert($busca->busca_data_i,'-','SQL');
        $busca->busca_data_f = invert($busca->busca_data_f,'-','SQL');
        if ($busca->busca_data_i <> '') {
            $onde .= " and pi.data>='" . $busca->busca_data_i . " 00:00:00'";
        }
        if ($busca->busca_data_f <> '') {
            $onde .= " and pi.data<='" . $busca->busca_data_f . " 23:59:59'";
        }
        if ($busca->busca_id_usuario_op == 'Todos') {
            $busca->busca_id_usuario_op = '';
        }
        if ($busca->busca_id_usuario_op <> '') {
            $onde .= " and pi.id_usuario_op='" . $busca->busca_id_usuario_op . "'";
        }
        if ($busca->busca_jadirecionados != 'on') {
            $onde .= " and pi.id_usuario_op='' and pi.inicio!='0000-00-00 00:00:00'";
        } else {
            #$onde .= " and pi.id_status IN ('3','4','6','7','12','13','15') ";
        }
        if ($busca->busca_id_status == "")
            $busca->busca_id_status = '3';
        if ($busca->busca_id_status == "Todos") {
            $busca->busca_id_status = "";
        }

        if ($busca->busca_id_status <> "") {
            if ($busca->busca_id_status == '3')
                $onde .= " and pi.id_status='" . $busca->busca_id_status . "' and (pi.id_atividade!='198' and pi.id_atividade!='110' and pi.id_atividade!='140'  or (pi.id_atividade='198' or pi.id_atividade='110' or pi.id_atividade='140') and DATE_ADD( pi.inicio , INTERVAL 1 DAY) < NOW())";
            else
                $onde .= " and pi.id_status='" . $busca->busca_id_status . "'";
        }

        if ($busca->busca_id_servico <> "") {
            $onde .= " and pi.id_servico='" . $busca->busca_id_servico . "'";
        }

        if ($busca->busca_ordem <> '') {
            $onde .= " and pi.id_pedido='" . $busca->busca_ordem . "'";
        }

        global $controle_id_empresa;
        $busca->id_empresa = isset($busca->id_empresa) ? $busca->id_empresa: $controle_id_empresa;
        
        $onde_empresa = "(u.id_empresa               = '" . $busca->id_empresa . "' and pi.id_empresa_resp='0' or
		pi.id_empresa_resp          = '" . $busca->id_empresa . "') and ";
        $dep = '';
        foreach ($busca->busca_departamentos as $i => $id_dep) {
            if ($id_dep != '')
                $dep.=($i > 0) ? ',' . $id_dep : $id_dep;
        }
        $dep.=',""';
        $sql_empresa_resp = " CASE WHEN pi.id_empresa_resp != 0 THEN (SELECT fantasia from vsites_user_empresa as ue_resp where  ue_resp.id_empresa=u.id_empresa) ELSE ('') END";
        $sql_usuario_resp = " CASE WHEN pi.id_usuario_op != 0 THEN (SELECT uu_resp.nome from vsites_user_usuario as uu_resp where  uu_resp.id_usuario=pi.id_usuario_op) ELSE ('') END";

        $campo = "pi.certidao_devedor,pi.data_prazo, pi.inicio, pi.data, pi.data_atividade, pi.id_atividade, st.status, a.atividade, u.nome as atendente, p.*, pi.ordem, pi.id_usuario_op, pi.certidao_cidade,pi.certidao_estado,pi.certidao_nome, pi.dias, s.descricao as desc_servico, pi.id_pedido_item, sd.id_departamento_resp, pi.valor,(" . $sql_empresa_resp . ") as empresa_resp,(" . $sql_usuario_resp . ") as responsavel, pi.id_empresa_resp, pi.certidao_nome_proprietario";
        $condicao = "from vsites_status as st, vsites_atividades as a, vsites_pedido as p, vsites_pedido_item as pi, vsites_servico_departamento as sd, vsites_user_usuario as u, vsites_servico as s where
		    " . $onde_empresa . "
			pi.id_status				!= '1' and
			pi.id_status  				!= '2' and
			pi.id_status				!= '8' and
			pi.id_status				!= '10' and
			pi.id_status				!= '12' and
			pi.id_status				!= '14' and
			pi.id_status				!= '15' and
			pi.id_status				!= '16'	and
			sd.id_departamento_resp     IN (" . $dep . ") and 
		    pi.id_usuario  				= u.id_usuario and
			pi.id_atividade 			= a.id_atividade and
		    pi.id_pedido  				= p.id_pedido and
		    pi.id_servico  				= s.id_servico and
			pi.id_status  				= st.id_status and
			pi.id_servico_departamento 	= sd.id_servico_departamento
			" . $onde . "
			order by " . $busca_ordenar_por;
        $this->sql = 'SELECT count(0) as total ' . $condicao;
        $cont = $this->fetch();
        $this->total = $cont[0]->total;
        $this->sql = "SELECT " . $campo . " " . $condicao . " LIMIT " . $this->getInicio() . ", " . $this->maximo;
        #echo $this->sql;
        $_SESSION['pedido_campo'] = $campo;
        $_SESSION['pedido_condicao'] = $condicao;
       
        return $this->fetch();
    }

    public function buscaDirecionamentoSite($busca, $pagina) {
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $_SERVER['REQUEST_URI']), $url_busca_pos + 5);

        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        $onde = '';
        #$busca_ordenar_por = ' p.email, p.cpf, pi.id_pedido ';
		$busca_ordenar_por = 'p.id_pedido desc, p.data desc, p.email, p.cpf, pi.id_pedido ';

              
        if(strlen($busca->busca_id_pedido) > 0){     
            #print_r($busca);
            #exit; 
            if (isset($busca->id_pedido) AND strlen(($busca->id_pedido)) > 0) {
                $onde .= " and pi.id_pedido = :busca_id_pedido ";
                $this->values['busca_id_pedido'] = $busca->id_pedido;
            } 
            if (isset($busca->ordem) AND strlen(($busca->ordem)) > 0 AND $busca->ordem > 0) {
                $onde .= " and pi.ordem = :busca_ordem";
                $this->values['busca_ordem'] = $busca->ordem;
            }
        } else {
            $onde .= " and (pi.id_status = '0' or pi.id_atividade = '0')";
        }
        
        if(strlen($busca->estado) > 0){
            $onde .= " and (pi.certidao_estado = '".$busca->estado."')";
        }

        $condicao = " from vsites_pedido as p, vsites_pedido_item as pi, vsites_user_usuario as u, vsites_servico as s where
	    u.id_empresa              = :id_empresa and
	    pi.id_usuario  				= u.id_usuario and
	    pi.id_pedido  				= p.id_pedido and
	    pi.id_servico  				= s.id_servico
		" . $onde . "
		order by pi.id_pedido DESC, pi.ordem";
        $this->values['id_empresa'] = $busca->id_empresa;

        $this->sql = 'SELECT count(0) as total ' . $condicao;

        $cont = $this->fetch();
        $this->total = $cont[0]->total;
        $campo = "p.nome, p.cidade, p.estado, p.cpf, p.email, pi.data, pi.id_pedido, p.id_afiliado,pi.certidao_nome, pi.certidao_cpf, pi.data_atividade, pi.id_atividade, u.nome as atendente, pi.ordem, pi.certidao_cidade,pi.certidao_estado, s.descricao as desc_servico, pi.certidao_nome, pi.id_pedido_item, pi.valor";

        $this->sql = "SELECT " . $campo . " " . $condicao . " LIMIT " . $this->getInicio() . ", " . $this->maximo;
        $_SESSION['pedido_campo'] = $campo;
        $_SESSION['pedido_condicao'] = $condicao;
        global $controle_id_usuario;
        if($controle_id_usuario == 1){
            #echo $this->sql;
        }
        return $this->fetch();
    }

    public function buscaEmpResponsavel($id_pedido,$ordem) {

        $condicao = " from vsites_pedido_item as pi, vsites_user_empresa as ue where
            pi.id_pedido = '".$id_pedido."' and
            pi.ordem = '".$ordem."' and
            pi.id_empresa_atend = ue.id_empresa limit 1";

        $this->sql = "SELECT ue.fantasia " . $condicao;
        $ret = $this->fetch();
        
        return $ret[0];
    }
    
    /**
     * atualiza o pedito item, e insere a atividade 
     * @param int $id_pedido_item
     * @param int $id_usuario
     * @param int $id_usuario_logado
     */
    public function direcionaSite($id_pedido_item, $id_usuario, $id_usuario_logado, $franquia=false) {
        global $inc_status_obs;
        $inc_status_obs = isset($inc_status_obs) ? $inc_status_obs : '';
        if (!$franquia) {
            $this->sql = "update vsites_pedido_item set data_i=NOW(), id_atividade='172', id_status='1', id_usuario=? where id_pedido_item=?";
            $this->values = array($id_usuario, $id_pedido_item);
            $this->exec();

            $this->sql = "insert into vsites_pedido_status (id_atividade,status_obs,data_i,id_usuario,id_pedido_item,status_dias,status_hora) values ('172',?,NOW(),?,?,'','00:00:00')";
            $this->values = array($inc_status_obs,$id_usuario_logado, $id_pedido_item);
            $this->exec();
        } else {
            $this->sql = "select id_empresa from vsites_user_usuario as uu where id_usuario=? limit 1";
            $this->values = array($id_usuario);
            $ret = $this->fetch();
            $id_empresa = $ret[0]->id_empresa;

            $this->sql = "update vsites_pedido_item as pi, vsites_pedido as p set pi.id_empresa_atend=?, p.id_usuario=?, pi.id_usuario=?, pi.id_status='0', pi.id_atividade='0' where pi.id_pedido_item=? and pi.id_pedido=p.id_pedido";
            $this->values = array($id_empresa, $id_usuario, $id_usuario, $id_pedido_item);
            $this->exec();

            $this->sql = "delete from vsites_pedido_status where id_pedido_item=?";
            $this->values = array($id_pedido_item);
            $this->exec();
        }
    }

    /**
     * duplicidade de pedidos, atualiza o status e insere a atividade no pedido
     * @param int $id_usuario
     * @param int $id_pedido_item
     */
    public function duplicidadeSite($id_usuario, $id_pedido_item) {
        global $inc_status_obs;
        $inc_status_obs = isset($inc_status_obs) ? $inc_status_obs : '';
        
        
        $this->sql = "update vsites_pedido_item set data_i=NOW(), id_atividade='200', id_status='14', id_usuario=? where id_pedido_item=?";
        $this->values = array($id_usuario, $id_pedido_item);
        $this->exec();
        $this->sql = "insert into vsites_pedido_status (id_atividade,status_obs,data_i,id_usuario,id_pedido_item,status_dias,status_hora) values ('200',?,NOW(),?,?,'','00:00:00')";
        $this->values = array($inc_status_obs,$id_usuario, $id_pedido_item);
        $this->exec();
    }

    /**
     * verificações para direcionar um pedido do site
     * lança Exception com mensagens de erro
     * 
     * @param int $id_empresa
     * @param int $id_pedido_item
     */
    public function verificaDirecionaSiteFranquia($id_empresa, $id_pedido_item) {
        $this->values = array($id_pedido_item);
        $error = '';
        global $controle_id_usuario;
        $this->sql = "SELECT COUNT(id_pedido_item) as num_financeiro FROM vsites_financeiro as fo WHERE id_pedido_item = ?";
        $fin = $this->fetch();

        $this->sql = "SELECT pi.id_pedido, pi.id_status, pi.ordem, p.id_conveniado, p.comissionado, p.id_ponto, pi.id_usuario_op, pi.inicio 
    			FROM vsites_pedido_item as pi, vsites_pedido as p
				WHERE pi.id_pedido_item	= ? and pi.id_empresa_atend=? and pi.id_pedido=p.id_pedido";
        $this->values[] = $id_empresa;
        $ped = $this->fetch();
        $ped = $ped[0];
        $id_pedido = $ped->id_pedido;

        if ($controle_id_usuario != 1) {
            $this->sql = "SELECT COUNT(pi.id_pedido_item) as num_ordens FROM vsites_pedido_item pi WHERE pi.id_pedido = ?";
            $this->values = array($id_pedido);
            $ordens = $this->fetch();

            if ($ordens[0]->num_ordens > 1) {
                $error.= '<br>Esse pedido possui mais de um serviço';
            }
        }
        if ($fin[0]->num_financeiro > 0) {
            $error.= '<br>Já foram lançados valores do Financeiro';
        } if ($ped->inicio != '0000-00-00 00:00:00') {
            $error.= '<br>Esse pedido já foi iniciado';
        }

        if ($ped->id_conveniado <> '' and $ped->id_conveniado <> 0) {
            $error.= '<br>Esse pedido pertence a um conveniado';
        }
        if ($ped->id_ponto <> 0) {
            $error.= '<br>Esse pedido pertence a um ponto de venda';
        }
        if ($ped->comissionado <> 0) {
            $error.= '<br>Esse pedido pertence a um Multi-Vendas';
        }

        if ($error != '') {
            throw new Exception($error);
        }
    }

    public function listaPedidosClientePJ($id_empresa, $data_i=null, $data_f=null, $cliente_cnpj=null) {
        if ($cliente_cnpj == null) {
            if ($data_i == null)
                $data_i = date("Y-m-01 00:00:00");
            if ($data_f == null)
                $data_f = date("Y-m-d 23:59:59");
            $this->sql = 'SELECT sum(pi.valor) as total, p.nome, p.cpf, count(pi.id_pedido_item) as pedidos
				FROM vsites_pedido_item pi
				INNER JOIN vsites_pedido p ON p.id_pedido = pi.id_pedido
				INNER JOIN vsites_user_usuario u ON pi.id_usuario = u.id_usuario
				WHERE p.tipo="cnpj" and u.id_empresa=? AND
				pi.inicio <= ? and pi.inicio >= ? AND
				pi.id_status!=14
				GROUP BY p.cpf
				ORDER BY 1 DESC 
				';
            $this->values = array($id_empresa, $data_f, $data_i);
        }else {
            if ($data_i == null)
                $data_i = date("Y-m-01 00:00:00");
            if ($data_f == null)
                $data_f = date("Y-m-d 23:59:59");
            $this->sql = 'SELECT p.nome, p.cpf, p.tel,p.ramal,p.tel2,p.ramal2,p.contato, pi.valor as valor, pi.id_pedido, pi.ordem
				FROM vsites_pedido_item pi
				INNER JOIN vsites_pedido p ON p.id_pedido = pi.id_pedido
				INNER JOIN vsites_user_usuario u ON pi.id_usuario = u.id_usuario
				WHERE p.tipo="cnpj" and u.id_empresa=? AND
				pi.inicio <= ? and pi.inicio >= ? AND p.cpf=? AND
				pi.id_status!=14
				
				ORDER BY pi.inicio
				';
            $this->values = array($id_empresa, $data_f, $data_i, $cliente_cnpj);
        }
        return $this->fetch();
    }

    public function listaComissaoAfiliado($id_afiliado, $data_i=null, $data_f=null) {
        if ($data_i == null)
            $data_i = date("Y-m-01 00:00:00");
        if ($data_f == null)
            $data_f = date("Y-m-d 23:59:59");
        $this->sql = 'SELECT pi.valor, pi.id_pedido, pi.ordem
		FROM vsites_pedido_item pi
			INNER JOIN vsites_pedido p ON p.id_pedido = pi.id_pedido

			INNER JOIN vsites_user_usuario u ON pi.id_usuario = u.id_usuario
			WHERE p.id_afiliado=? AND
			pi.encerramento <=? and pi.encerramento >= ?
AND pi.valor <= pi.valor_rec

			ORDER BY 2 DESC ';
        $this->values = array($id_afiliado, $data_f, $data_i);
        return $this->fetch();
    }

    public function listaDespesaOrdem($id_pedido, $id_pedido_item) {
        $this->sql = "SELECT (pf.custas+pf.rateio+pf.sedex) as valor, pi.id_pedido_item from 
		vsites_pedido_item as pi, vsites_pedido_fin as pf where pi.id_pedido=? and pi.id_pedido_item=pf.id_pedido_item";
        $this->values = array($id_pedido);
        $ret = $this->fetch();
        foreach ($ret as $l) {
            $valor = (float) $valor + (float) $l->valor;
            if ($l->id_pedido_item == $id_pedido_item)
                $ret[0]->valor_item = $l->valor;
        }
        $ret[0]->valor = $valor;
        return $ret[0];
    }

    public function listaDespesaOrdem2($id_pedido, $id_empresa) {
        $this->sql = "SELECT sum(f.financeiro_valor+f.financeiro_rateio+f.financeiro_sedex) as valor from vsites_financeiro as f, vsites_pedido_item as pi where pi.id_pedido=? and f.id_pedido_item=pi.id_pedido_item and f.financeiro_autorizacao='Aprovado' and f.financeiro_tipo='Desembolso' and f.id_empresa_fin=?";
        $this->values = array($id_pedido, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    public function listaDespesaItem($id_pedido_item, $id_empresa) {
        $this->sql = "SELECT sum(f.financeiro_valor+f.financeiro_rateio+f.financeiro_sedex) as valor from vsites_financeiro as f where f.id_pedido_item=? and f.financeiro_autorizacao='Aprovado' and f.financeiro_tipo='Desembolso' and f.id_empresa_fin=?";
        $this->values = array($id_pedido_item, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    public function listarPorArquivo($id_arquivo) {
        $this->sql = 'select * from vsites_arquivo_item as ai where id_arquivo = ? and erro=\'\' and dup=\'0\'';
        $this->values = array($id_arquivo);
        return $this->fetch();
    }

    public function buscaPedido($busca, $id_empresa, $id_departamento_p, $id_departamento_s, $pagina=1) {

        $departamento_s = explode(',', $id_departamento_s);
        $departamento_p = explode(',', $id_departamento_p);

        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $_SERVER['REQUEST_URI']), $url_busca_pos + 5);
        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;


        if ($busca->busca_ord == 'Decr')
            $busca->busca_ordenar_por_o.= ' DESC ';

        $busca->busca_ordenar_por = ' pi.id_pedido ' . $busca->busca_ordenar_por_o . ', pi.ordem ' . $busca->busca_ordenar_por_o;

        if ($busca->busca_ordenar == 'Documento de')
            $busca->busca_ordenar_por = ' pi.certidao_nome ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Ordem')
            $busca->busca_ordenar_por = ' pi.id_pedido ' . $busca->busca_ordenar_por_o . ', pi.ordem ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Serviço')
            $busca->busca_ordenar_por = ' pi.id_servico ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Data')
            $busca->busca_ordenar_por = ' pi.data ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Cidade')
            $busca->busca_ordenar_por = ' pi.certidao_estado ' . $busca->busca_ordenar_por_o . ', pi.certidao_cidade ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Estado')
            $busca->busca_ordenar_por = ' pi.certidao_estado ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Departamento')
            $busca->busca_ordenar_por = ' pi.id_servico_departamento ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Prazo')
            $busca->busca_ordenar_por = ' pi.data_prazo ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Data Status')
            $busca->busca_ordenar_por = ' pi.data_atividade ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Agenda')
            $busca->busca_ordenar_por = ' pi.data_i, pi.status_hora ' . $busca->busca_ordenar_por_o;

        $onde = '';

        if ($busca->busca_id_pedido <> '') {
            $onde .= " and pi.id_pedido='" . $busca->busca_id_pedido . "'";
        }

        if ($busca->busca_id_empresa != '') {
            if ($busca->busca_id_empresa == 'minha') {
                $onde .= " and pi.id_empresa_resp != '" . $id_empresa . "' and pi.id_empresa_atend='" . $id_empresa . "'";
            } else {
                if ($busca->busca_id_empresa == 'naominha') {
                    $onde .= " and pi.id_empresa_resp != '0' and pi.id_empresa_resp != '" . $id_empresa . "' ";
                } else {
                    if ($busca->busca_id_empresa == 'naominha_r') {
                        $onde .= " and pi.id_empresa_resp != '0' and pi.id_empresa_resp = '" . $id_empresa . "' ";
                    } else {
                        $onde .= " and pi.id_empresa_resp = '" . $busca->busca_id_empresa . "' ";
                    }
                }
            }
        } else {
            $onde .= " and (pi.id_empresa_resp = '" . $id_empresa . "' and pi.data_status='0000-00-00 00:00:00'
			or pi.id_empresa_atend = '" . $id_empresa . "')";
        }

        if ($busca->busca_id_servico <> '') {
            $onde .= " and pi.id_servico='" . $busca->busca_id_servico . "'";
        }
        if ($busca->busca_id_departamento <> '') {
            $onde .= " and pi.id_servico_departamento='" . $busca->busca_id_departamento . "'";
        }
        if ($busca->busca_id_atividade <> '') {
            $onde .= " and pi.id_atividade='" . $busca->busca_id_atividade . "'";
        }
        if ($busca->busca_data_i <> '') {
            $onde .= " and pi.data>='" . $busca->busca_data_i . " 00:00:00'";
        }
        if ($busca->busca_data_f <> '') {
            $onde .= " and pi.data<='" . $busca->busca_data_f . " 23:59:59'";
        }
        if ($busca->busca_data_i_co <> '') {
            $onde .= " and pi.operacional>='" . $busca->busca_data_i_co . "'";
        }
        if ($busca->busca_data_f_co <> '') {
            $onde .= " and pi.operacional<='" . $busca->busca_data_f_co . "'";
        }
        if ($busca->busca_data_i_a <> '') {
            $onde .= " and pi.data_atividade>='" . $busca->busca_data_i_a . " 00:00:00'";
        }
        if ($busca->busca_data_f_a <> '') {
            $onde .= " and pi.data_atividade<='" . $busca->busca_data_f_a . " 23:59:59'";
        }
        if ($busca->busca_origem <> '') {
            $onde .= " and p.origem='" . $busca->busca_origem . "'";
        }
        if ($busca->estado_dir <> '') {
            $onde .= " and pi.certidao_estado IN (" . $busca->estado_dir . "'SS') ";
        }
        if ($busca->busca_id_status == '')
            $busca->busca_id_status = '3';
        if ($busca->busca_id_status == 'Todos')
            $busca->busca_id_status = '';
        if ($busca->busca_id_status == 'Cad/Sol/Des/Exe/Par/Ret') {
            $onde .= " and pi.id_status IN ('3','4','5','6','7','15')";
        } else {
            if ($busca->busca_id_status == 'Cad/Sol/Des/Exe/Ret') {
                $onde .= " and pi.id_status IN ('3','4','5','6','7')";
            } else {
                if ($busca->busca_id_status <> '') {
                    $onde .= " and pi.id_status='" . $busca->busca_id_status . "'";
                } else {
                    if ($busca->busca_id_pedido <> '' or $busca->busca <> '' or $busca->busca_data_i_co <> '')
                        $onde .= " and pi.id_status!='14' ";
                    else
                        $onde .= " and pi.id_status!='14' and pi.id_status!='10' ";
                }
            }
        }

        #trava a exibição os pedidos que estão sendo executados por outra empresa
        if (($busca->busca_id_status == '3' or $busca->busca_id_status == '4' or $busca->busca_id_status == '5' or $busca->busca_id_status == '6' or $busca->busca_id_status == '7' or $busca->busca_id_status == '15' or $busca->busca_id_status == 'Cad/Sol/Des/Exe/Ret' or $busca->busca_id_status == 'Cad/Sol/Des/Exe/Par/Ret') and $busca->busca_id_empresa == '') {
            $onde .= " and (pi.id_empresa_resp=0 or pi.id_empresa_resp='" . $id_empresa . "' and pi.operacional='0000-00-00' or pi.id_empresa_resp<>'' and pi.id_empresa_resp!='" . $id_empresa . "' and pi.operacional!='0000-00-00')";
        }

        if ($busca->busca_id_usuario <> '' and $busca->busca_id_usuario != 'ex') {
            $onde .= " and pi.id_usuario='" . $busca->busca_id_usuario . "'";
        } else if ($busca->busca_id_usuario == 'ex') {
            $onde .= " and u.status='Ativo'";
        }
        if ($busca->busca_id_usuario_op <> '') {
            $onde .= " and (pi.id_usuario_op='" . $busca->busca_id_usuario_op . "' or pi.id_usuario_op2='" . $busca->busca_id_usuario_op . "' and pi.id_empresa_resp<>'' and pi.id_empresa_resp!='" . $id_empresa . "')";
        }
        if ($busca->busca <> '') {
            $onde .= " and (pi.certidao_matricula = '" . $busca->busca . "' or pi.certidao_numero_not = '" . $busca->busca . "' or pi.certidao_cidade like '" . $busca->busca . "%' or p.nome like '" . $busca->busca . "%' or pi.certidao_devedor like '" . $busca->busca . "%' or pi.certidao_pai like '" . $busca->busca . "%' or pi.certidao_mae like '" . $busca->busca . "%' or pi.certidao_esposa like '" . $busca->busca . "%' or pi.certidao_marido like '" . $busca->busca . "%' or pi.certidao_nome like '" . $busca->busca . "%' or replace(replace(replace(pi.certidao_cnpj,'.',''),'-',''),'/','') = '" . $busca->busca . "' or replace(replace(replace(pi.certidao_cpf,'.',''),'-',''),'/','') = '" . $busca->busca . "' or p.email = '" . $busca->busca . "') ";
        }

        if ($id_departamento_p == '6,')
            $onde_resp = " pi.id_empresa_atend = '" . $id_empresa . "' and ";
        else
            $onde_resp = "(
			pi.id_empresa_atend             = '" . $id_empresa . "' or
			pi.id_empresa_resp              = '" . $id_empresa . "'
			) and ";


        if (in_array('6', $departamento_p) != 1) {
            $onde .= " and (pi.id_usuario_op!='' or pi.id_usuario_op='' and  pi.id_empresa_resp!='') ";
        }

        if ($busca->busca_exibicao == 'Atraso')
            $onde .= " and (pi.id_status!='10' and DATE(NOW()) > pi.data_prazo or pi.id_status='10' and pi.encerramento > pi.data_prazo) ";
        if ($busca->busca_exibicao == 'Atraso Operacional')
            $onde .= " and (pi.operacional='0000-00-00' and DATE(NOW()) > pi.data_prazo or pi.id_status='10' and pi.operacional > pi.data_prazo) ";

        switch ($busca->busca_sit) {
            case 1:
                $onde .= " and pi.operacional!='0000-00-00' and DATE(NOW()) > pi.operacional and pi.id_empresa_resp='" . $id_empresa . "'";
                break;
            case 2:
                $onde .= " and pi.operacional!='0000-00-00' and DATE(NOW()) > pi.operacional and pi.id_empresa_resp!='" . $id_empresa . "'";
                break;
            case 3:
                $onde .= " and pi.operacional='0000-00-00'";
                break;
            default:
                $onde .='';
        }
        $condicao1 = "from  
		vsites_pedido_item as pi,
		vsites_user_usuario as u,";

        $condicao2 = " vsites_atividades as a, vsites_status as st, vsites_pedido as p,
		vsites_servico as s, vsites_servico_departamento as sd 
		where
		" . $onde_resp . " 1=1 " . $onde . " and
		pi.id_pedido = p.id_pedido and 
		pi.id_status = st.id_status and
		pi.id_usuario = u.id_usuario and
		pi.id_servico_departamento 	= sd.id_servico_departamento and
		pi.id_atividade	= a.id_atividade and
		pi.id_servico 	= s.id_servico " . $agrupa . " order by " . $busca->busca_ordenar_por;

        $campo = " pi.certidao_requerente, pi.certidao_numero_not, pi.data_prazo, pi.operacional, pi.inicio, pi.encerramento, pi.data_atividade, pi.data_i,
		pi.certidao_matricula, pi.certidao_n_matricula, pi.certidao_devedor, pi.certidao_estado, pi.certidao_cidade, pi.certidao_nome_proprietario, 
		pi.certidao_nome, pi.id_pedido_item, pi.id_pedido, pi.ordem, pi.id_usuario_op, pi.id_empresa_resp, pi.id_empresa_atend, pi.id_status,
		pi.valor, pi.dias, pi.status_hora,pi.id_empresa_dir,
		p.restricao, p.data, p.nome, 
		st.status, s.descricao as servico, a.atividade, u.nome as atendente, sd.departamento";

        $this->sql = 'SELECT count(0) as total ' . $condicao1 . $condicao2;
        $cont = $this->fetch();
        $this->total = $cont[0]->total;
		//Antigo
        //$this->sql = "select CASE WHEN pi.id_usuario_op != 0 THEN (uu_resp.nome) ELSE ('') END as responsavel, pi.* from (SELECT " . $campo . " " . $condicao1 . $condicao2 . " LIMIT " . $this->getInicio() . ", " . $this->maximo . ') as pi LEFT JOIN vsites_user_usuario as uu_resp ON uu_resp.id_usuario=pi.id_usuario_op';
		$this->sql = "SELECT '' as responsavel, " . $campo . " " . $condicao1 . $condicao2 . " LIMIT " . $this->getInicio() . ", " . $this->maximo;

        $_SESSION['pedido_campo'] = $campo;
        $_SESSION['pedido_condicao'] = $condicao1 . $condicao2;
		global $controle_id_usuario;
		if($controle_id_usuario == 1){
			#echo $this->sql;
			#exit;
		}
			global $controle_id_empresa;
			global $controle_id_usuario;
			#if($controle_id_empresa==44){
			if($controle_id_usuario==1){
				#print_r($this->sql);
				#echo '<br />';
				#print_r ($this->values);
				#exit;
			#}
		}
        return $this->fetch();
		
    }

    public function buscaPedidoFranquia($busca, $id_empresa, $pagina=1) {

        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $_SERVER['REQUEST_URI']), $url_busca_pos + 5);
        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;


        if ($busca->busca_ord == 'Decr')
            $busca->busca_ordenar_por_o.= ' DESC ';

        $busca->busca_ordenar_por = ' pi.id_pedido ' . $busca->busca_ordenar_por_o . ', pi.ordem ' . $busca->busca_ordenar_por_o;
        if ($busca->busca_ordenar == 'Documento de')
            $busca->busca_ordenar_por = ' pi.certidao_nome ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Ordem')
            $busca->busca_ordenar_por = ' pi.id_pedido ' . $busca->busca_ordenar_por_o . ', pi.ordem ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Serviço')
            $busca->busca_ordenar_por = ' pi.id_servico ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Data')
            $busca->busca_ordenar_por = ' pi.data ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Cidade')
            $busca->busca_ordenar_por = ' pi.certidao_estado ' . $busca->busca_ordenar_por_o . ', pi.certidao_cidade ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Estado')
            $busca->busca_ordenar_por = ' pi.certidao_estado ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Departamento')
            $busca->busca_ordenar_por = ' pi.id_servico_departamento ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Prazo')
            $busca->busca_ordenar_por = ' pi.data_prazo ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Data Status')
            $busca->busca_ordenar_por = ' pi.data_atividade ' . $busca->busca_ordenar_por_o; else
        if ($busca->busca_ordenar == 'Agenda')
            $busca->busca_ordenar_por = ' pi.data_i, pi.status_hora ' . $busca->busca_ordenar_por_o;

        $onde = '';

        if ($busca->busca_id_pedido <> '') {
            $onde .= " and pi.id_pedido='" . $busca->busca_id_pedido . "'";
        }
        if ($busca->busca_id_servico <> '') {
            $onde .= " and pi.id_servico='" . $busca->busca_id_servico . "'";
        }
        if ($busca->busca_id_departamento <> '') {
            $onde .= " and pi.id_servico_departamento='" . $busca->busca_id_departamento . "'";
        }
        if ($busca->busca_id_atividade <> '') {
            $onde .= " and pi.id_atividade='" . $busca->busca_id_atividade . "'";
        }
        if ($busca->busca_data_i <> '') {
            $onde .= " and pi.data>='" . $busca->busca_data_i . " 00:00:00'";
        }
        if ($busca->busca_data_f <> '') {
            $onde .= " and pi.data<='" . $busca->busca_data_f . " 23:59:59'";
        }
        if ($busca->busca_data_i_co <> '') {
            $onde .= " and pi.operacional>='" . $busca->busca_data_i_co . "'";
        }
        if ($busca->busca_data_f_co <> '') {
            $onde .= " and pi.operacional<='" . $busca->busca_data_f_co . "'";
        }
        if ($busca->busca_data_i_a <> '') {
            $onde .= " and pi.data_atividade>='" . $busca->busca_data_i_a . " 00:00:00'";
        }
        if ($busca->busca_data_f_a <> '') {
            $onde .= " and pi.data_atividade<='" . $busca->busca_data_f_a . " 23:59:59'";
        }
        if ($busca->busca_data_i_conc <> '') {
            $onde .= " and pi.encerramento>='" . $busca->busca_data_i_conc . " 00:00:00'";
        }
        if ($busca->busca_data_f_conc <> '') {
            $onde .= " and pi.encerramento<='" . $busca->busca_data_f_conc . " 23:59:59'";
        }
        if ($busca->busca_origem <> '') {
            $onde .= " and p.origem='" . $busca->busca_origem . "'";
        }
        if ($busca->estado_dir2 <> '') {
            $onde .= " and pi.certidao_estado IN (" . $busca->estado_dir2 . "'SS') ";
        }
        if ($busca->busca_id_status == '')
            $busca->busca_id_status = '3';
        if ($busca->busca_id_status == 'Todos')
            $busca->busca_id_status = '';
        if ($busca->busca_id_status == 'Cad/Sol/Des/Exe/Par/Ret') {
            $onde .= " and pi.id_status IN ('3','4','5','6','7','15')";
        } else {
            if ($busca->busca_id_status == 'Cad/Sol/Des/Exe/Ret') {
                $onde .= " and pi.id_status IN ('3','4','5','6','7')";
            } else {
                if ($busca->busca_id_status <> '') {
                    $onde .= " and pi.id_status='" . $busca->busca_id_status . "'";
                } else {
                    if ($busca->busca <> '' or $busca->busca_data_i_co <> '')
                        $onde .= " and pi.id_status!='14' ";
                    else
                        $onde .= " and pi.id_status!='14' and pi.id_status!='10' ";
                }
            }
        }

        if ($busca->busca <> '') {
            $onde .= " and (pi.certidao_numero_not = '" . $busca->busca . "' or pi.certidao_cidade like '" . $busca->busca . "%' or p.nome like '%" . $busca->busca . "%' or pi.certidao_devedor like '" . $busca->busca . "%' or pi.certidao_pai like '" . $busca->busca . "%' or pi.certidao_mae like '" . $busca->busca . "%' or pi.certidao_esposa like '" . $busca->busca . "%' or pi.certidao_marido like '" . $busca->busca . "%' or pi.certidao_nome like '" . $busca->busca . "%' or replace(replace(replace(pi.certidao_cnpj,'.',''),'-',''),'/','') = '" . $busca->busca . "' or replace(replace(replace(pi.certidao_cpf,'.',''),'-',''),'/','') = '" . $busca->busca . "' or p.email = '" . $busca->busca . "') ";
        }

        $onde_resp = "(
			pi.id_empresa_atend              = '" . $busca->busca_id_empresa . "'
			) and";


        if ($busca->busca_exibicao == 'Ordem') {
            $agrupa = ' group by pi.id_pedido';
        } else {
            $agrupa = '';
            if ($busca->busca_exibicao == 'Atraso')
                $onde .= " and (pi.id_status!='10' and DATE(NOW()) > pi.data_prazo or pi.id_status='10' and pi.encerramento > pi.data_prazo) ";
            if ($busca->busca_exibicao == 'Atraso Operacional')
                $onde .= " and (pi.operacional='0000-00-00' and DATE(NOW()) > pi.data_prazo or pi.id_status='10' and pi.operacional > pi.data_prazo) ";
        }

        $condicao1 = "from  
		vsites_pedido_item as pi,
		vsites_user_usuario as u,";

        $condicao2 = " vsites_atividades as a, vsites_status as st, vsites_pedido as p,
		vsites_servico as s, vsites_servico_departamento as sd 
		where
		" . $onde_resp . " 1=1 " . $onde . " and
		p.id_pedido  = pi.id_pedido and
		pi.id_status = st.id_status and
		pi.id_usuario = u.id_usuario and
		pi.id_servico_departamento 	= sd.id_servico_departamento and
		pi.id_atividade	= a.id_atividade and
		pi.id_servico 	= s.id_servico " . $agrupa . " order by " . $busca->busca_ordenar_por;

        $campo = " pi.data_prazo, pi.operacional, pi.inicio, pi.encerramento, pi.data_atividade, pi.data_i,
		pi.certidao_matricula, pi.certidao_n_matricula, pi.certidao_devedor, pi.certidao_estado, pi.certidao_cidade, pi.certidao_nome_proprietario, pi.certidao_nome,
		pi.id_pedido_item, pi.id_pedido, pi.ordem, pi.id_usuario_op, pi.id_empresa_resp, pi.id_status,
		pi.valor, pi.dias, pi.status_hora,
		p.restricao, p.data, p.nome, 
		st.status, s.descricao as servico, a.atividade, u.nome as atendente, sd.departamento, 
		ue_resp.fantasia as empresa_resp, 
		CASE WHEN pi.id_usuario_op != 0 THEN (uu_resp.nome) ELSE ('') END as responsavel";

        $this->sql = 'SELECT count(0) as total ' . $condicao1 . $condicao2;
        $cont = $this->fetch();
        $this->total = $cont[0]->total;

        $condicao1 = "from  
		vsites_pedido_item as pi 
			LEFT JOIN vsites_user_usuario as uu_resp ON uu_resp.id_usuario=pi.id_usuario_op,
		vsites_user_usuario as u
			INNER JOIN vsites_user_empresa as ue_resp ON ue_resp.id_empresa=u.id_empresa,";

        $this->sql = "SELECT " . $campo . " " . $condicao1 . $condicao2 . " LIMIT " . $this->getInicio() . ", " . $this->maximo;

        $_SESSION['pedido_campo'] = $campo;
        $_SESSION['pedido_condicao'] = $condicao1 . $condicao2;

        return $this->fetch();
    }

    public function listaPedidosCadastrados($id_empresa, $data_i, $data_f, $tipo, $id_atendente=null,$p) {
        $this->sql = 'SELECT p.id_pedido,p.origem, p.forma_pagamento, p.nome as cliente,pi.valor,pi.id_usuario, pi.id_status,pi.valor_rec,pi.data,pi.certidao_cidade, pi.certidao_estado,pi.ordem, pi.data_i as programado,pi.data_prazo,pi.encerramento, SUM(pf.custas) as financeiro_valor, SUM(pf.sedex) as financeiro_sedex,SUM(pf.rateio) as financeiro_rateio,
						s.descricao as servico, sd.departamento,u.nome as atendente,st.status
						FROM vsites_pedido_item pi
						INNER JOIN vsites_pedido p ON p.id_pedido=pi.id_pedido
						INNER JOIN vsites_user_usuario u ON pi.id_usuario = u.id_usuario
						INNER JOIN vsites_status st ON pi.id_status = st.id_status
						INNER JOIN vsites_servico s ON pi.id_servico = s.id_servico
						INNER JOIN vsites_servico_departamento sd ON sd.id_servico_departamento = pi.id_servico_departamento
						INNER JOIN vsites_pedido_fin pf ON pf.id_pedido_item=pi.id_pedido_item
							WHERE pi.id_empresa_atend=? and
							pi.data >= ? and
							pi.data <= ?
							';

        $this->values = array($id_empresa, $data_i, $data_f);
        if ($tipo <> '') {
            $this->sql.=' and p.tipo=?';
            $this->values[] = $tipo;
        }

        if ($id_atendente != null) {
            $this->sql.=' and pi.id_usuario=?';
            $this->values[] = $id_atendente;
        }
        if ($p->origem <> '') {
            $this->sql.=' and p.origem=?';
            $this->values[] = $p->origem;
        }
        
        if ($p->departamento <> '') {
            $this->sql.=' and pi.id_servico_departamento=?';
            $this->values[] = $p->departamento;
        }        
        $this->sql.=' group by pi.id_pedido_item ORDER BY pi.data, atendente';

        return $this->fetch();
    }

    public function listaPedidosRecFranquia($id_empresa, $data_i, $data_f) {
        $this->sql = "SELECT
			pi.data,p.id_pedido,pi.ordem,st.status,s.descricao as servico,pi.data_prazo, pi.certidao_cidade, pi.certidao_estado, e.fantasia, f.financeiro_valor, f.financeiro_rateio, f.financeiro_sedex
						FROM vsites_pedido_item pi
						INNER JOIN vsites_pedido p ON p.id_pedido=pi.id_pedido
						INNER JOIN vsites_user_usuario u ON pi.id_usuario = u.id_usuario
						INNER JOIN vsites_user_empresa e ON u.id_empresa = e.id_empresa
						INNER JOIN vsites_status st ON pi.id_status = st.id_status
						INNER JOIN vsites_servico s ON pi.id_servico = s.id_servico
						INNER JOIN vsites_financeiro f ON pi.id_pedido_item = f.id_pedido_item
							WHERE pi.id_empresa_resp=? and
							pi.data >= ? and
							pi.data <= ? and
							f.financeiro_classificacao=38 and
							f.id_empresa_fin!=? and
							f.financeiro_tipo='Desembolso' and
							f.financeiro_autorizacao='Aprovado'
							group by pi.id_pedido_item";
        $this->values = array($id_empresa, $data_i, $data_f, $id_empresa);
        $this->sql.=' ORDER BY pi.data, e.fantasia';
        return $this->fetch();
    }

    public function PegaUltimoPedido($cnpj) {
        $this->sql = 'SELECT data FROM vsites_pedido WHERE cpf=? ORDER BY data DESC LIMIT 1';
        $this->values = array($cnpj);
        $ret = $this->fetch();
        return count($ret) > 0 ? $ret[0] : array();
    }

    public function BalancoFianceiro($c) {
        $this->sql = 'SELECT p.id_pedido, p.nome, p.id_conveniado, p.data, pi.valor
			FROM vsites_pedido AS p, vsites_pedido_item pi
			WHERE p.cpf = ? and pi.id_pedido = p.id_pedido and pi.id_empresa_atend=? ORDER BY pi.data DESC limit 100';
        $this->values = array($c->cpf, $c->id_empresa);
        return $this->fetch();
    }

    /**
     * log de acesso ao pedido
     * @param Pedido $p
     */
    public function logPedidoItem($id_pedido_item, $id_usuario) {
        #$this->sql = 'INSERT INTO vsites_pedido_item_log (id_pedido_item, id_usuario, data) VALUES (?,?,?)';
        #$this->values = array($id_pedido_item,$id_usuario,date('Y-m-d H:i:s'));
        #$this->exec();
    }

    /**
     * verifica vez do CDT
     * @param int $id_empresa
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

    public function execSession($string = '') {
        $campo = 'pi.certidao_resultado, pi.certidao_cpf, pi.certidao_cnpj, ' . $_SESSION['pedido_campo'];
        $campo = str_replace('p.*,','',$campo);
        $campo = explode(',',$campo);
        $campo = implode(',',$campo).',p.id_pedido,pi.operacional,pi.id_empresa_atend';
        $this->sql = "select CASE WHEN pi.id_usuario_op != 0 THEN (uu_resp.nome) ELSE ('') END as responsavel, pi.* from (SELECT " . $campo . " " . $_SESSION['pedido_condicao'] . " LIMIT 3000) as pi LEFT JOIN vsites_user_usuario as uu_resp ON uu_resp.id_usuario=pi.id_usuario_op";
        #echo $this->sql;
        return $this->fetch();
    }
    
    public function retorno_cliente($id_cliente,$controle_id_empresa,$onde){
        $this->sql = "SELECT pi.id_pedido, pi.ordem, pi.certidao_numero_not, pi.certidao_protocolo, pi.certidao_data_protocolo, pi.certidao_ocorrencia, pi.certidao_data_ocorrencia, pi.certidao_registro, pi.certidao_data_registro, pi.certidao_numero_ar  from
            vsites_user_usuario as u, vsites_pedido_item as pi, vsites_pedido as p where
			p.id_conveniado='".$id_cliente."' and
			p.id_pedido = pi.id_pedido and
			pi.id_usuario=u.id_usuario and
			pi.id_status!='14' and
			u.id_empresa='".$controle_id_empresa."'
			".$onde."
            order by pi.id_pedido_item";
    }
    
    
    public function ProxDir($cidade, $estado){
        $this->sql = "SELECT e.id_empresa, e.fantasia, p.data, p.id_pedido
            FROM vsites_pedido AS p, vsites_pedido_item AS pi, vsites_status AS s, vsites_user_empresa AS e
            WHERE pi.id_pedido = p.id_pedido AND p.data > '2014-04-30 23:59:59' AND p.site = 1 AND s.id_status = pi.id_status
            AND p.cidade LIKE '%".$cidade."%' AND p.estado LIKE '%".$estado."%' AND e.id_empresa = pi.id_empresa_atend AND e.id_empresa != 1
            AND pi.ordem = 1 GROUP BY pi.id_pedido ORDER BY p.data DESC LIMIT 30";
        return $this->fetch();
    }
    
    public function cobranca_listar($c){
        global $controle_id_empresa;
        
        $c->busca_ordenar_por_o = '';
        $c->busca_ordenar_por = '';
        
        if ($c->busca_ord == 'Decr')
            $c->busca_ordenar_por_o.= ' DESC ';
        $c->busca_ordenar_por = ' pi.id_pedido ' . $c->busca_ordenar_por_o . ', pi.ordem ' . $c->busca_ordenar_por_o;
        if ($c->busca_ordenar == 'Documento de')
            $c->busca_ordenar_por = ' pi.certidao_nome ' . $c->busca_ordenar_por_o; else
        if ($c->busca_ordenar == 'Serviço')
            $c->busca_ordenar_por = ' pi.id_servico ' . $c->busca_ordenar_por_o; else
        if ($c->busca_ordenar == 'Ordem')
            $c->busca_ordenar_por = ' pi.id_pedido, pi.ordem ' . $c->busca_ordenar_por_o; else
        if ($c->busca_ordenar == 'Data')
            $c->busca_ordenar_por = ' pi.data ' . $c->busca_ordenar_por_o; else
        if ($c->busca_ordenar == 'Cidade')
            $c->busca_ordenar_por = ' pi.certidao_estado ' . $c->busca_ordenar_por_o . ', pi.certidao_cidade ' . $c->busca_ordenar_por_o; else
        if ($c->busca_ordenar == 'Estado')
            $c->busca_ordenar_por = ' pi.certidao_estado ' . $c->busca_ordenar_por_o; else
        if ($c->busca_ordenar == 'Departamento')
            $c->busca_ordenar_por = ' pi.id_servico_departamento ' . $c->busca_ordenar_por_o; else
        if ($c->busca_ordenar == 'Fatura')
            $c->busca_ordenar_por = ' pi.id_fatura ' . $c->busca_ordenar_por_o; else
        if ($c->busca_ordenar == 'Prazo')
            $c->busca_ordenar_por = $data_prazo_inc . $c->busca_ordenar_por_o; else
        if ($c->busca_ordenar == 'Data Status')
            $c->busca_ordenar_por = ' pi.data_atividade ' . $c->busca_ordenar_por_o; else
        if ($c->busca_ordenar == 'Agenda')
            $c->busca_ordenar_por = ' pi.data_i ' . $c->busca_ordenar_por_o . ', pi.status_hora ' . $c->busca_ordenar_por_o;
        if ($c->busca_ordenar == 'Devedor')
            $c->busca_ordenar_por = ' pi.certidao_devedor ' . $c->busca_ordenar_por_o . ', pi.certidao_nome ' . $c->busca_ordenar_por_o;

        $onde = '';
        if ($c->busca_autorizacao == '')
            $c->busca_autorizacao = 'À Receber';
        if ($c->busca_id_status != '20' and $c->busca_id_status != '11')
            $c->busca_id_status = '20';
        #if($c->busca_id_status=='Todos') $c->busca_id_status='';
        if ($c->busca_id_status <> '') {
            $onde .= " and pi.id_status='" . $c->busca_id_status . "'";
        }
        if ($c->busca <> '') {
            $onde .= " and (p.nome like '%" . $c->busca . "%' or pi.certidao_devedor = '" . $c->busca . "' or pi.certidao_nome like '" . $c->busca . "%' or pi.certidao_pai like '" . $c->busca . "%' or pi.certidao_mae like '" . $c->busca . "%' or pi.certidao_esposa like '" . $c->busca . "%' or pi.certidao_marido like '" . $c->busca . "%' or replace(replace(replace(pi.certidao_cpf,'.',''),'-',''),'/','') = replace(replace(replace('" . $c->busca . "','.',''),'-',''),'/','') or replace(replace(replace(pi.certidao_cnpj,'.',''),'-',''),'/','') = replace(replace(replace('" . $c->busca . "','.',''),'-',''),'/','') or replace(replace(replace(p.cpf,'.',''),'-',''),'/','') = replace(replace(replace('" . $c->busca . "','.',''),'-',''),'/','')) ";
        }
        if ($c->busca_id_pedido <> '')
            $onde .= " and pi.id_pedido= '" . $c->busca_id_pedido . "' ";
        if ($c->busca_id_fatura <> '')
            $onde .= " and pi.id_fatura= '" . $c->busca_id_fatura . "' ";
        if ($c->busca_id_usuario_cb <> '' and $c->busca_id_usuario_cb != '_')
            $onde .= " and p.id_usuario_cb= '" . $c->busca_id_usuario_cb . "' ";
        if ($c->busca_id_usuario_cb == '_')
            $onde .= " and p.id_usuario_cb is NULL ";
        
        $tipo_busca = '';
        $onde_status = " pi.id_atividade != 120 and pi.id_atividade != 214 and pi.id_atividade != '215' and pi.id_atividade != '216'";
        if ($c->busca_autorizacao == 'À Receber')
            $tipo_busca = " (pi.valor_rec < pi.valor or pi.valor_rec IS NULL) ";
        else if ($c->busca_autorizacao == 'Recebido') {
            $tipo_busca = "	pi.valor_rec >= pi.valor";
            $onde_status = " 1=1 ";
        } else if ($c->busca_autorizacao == 'Em Acompanhamento') {
            $tipo_busca = " (pi.valor_rec < pi.valor or pi.valor_rec IS NULL) ";
            $onde_status = " pi.id_atividade = '120'";
        } else if ($c->busca_autorizacao == 'Notificar') {
            $tipo_busca = " (pi.valor_rec < pi.valor or pi.valor_rec IS NULL) ";
            $onde_status = " pi.id_atividade = '214' ";
        } else if ($c->busca_autorizacao == 'Notificado') {
            $tipo_busca = " (pi.valor_rec < pi.valor or pi.valor_rec IS NULL) ";
            $onde_status = " pi.id_atividade = '215' ";
        } 
        
        if ($c->busca_mes!= '' || $c->busca_ano != '') {
            if ($c->busca_mes== '') {
                $busca_mes_ini = '01';
                $busca_mes_fim = '12';
            } else {
                $busca_mes_ini = $c->busca_mes;
                $busca_mes_fim = $c->busca_mes;
            }
            if ($c->busca_ano == ''){
                $c->busca_ano = date('Y');
            }
            $onde_status .= " and ( pi.data >= '$c->busca_ano-$busca_mes_ini-01 00:00:00' and pi.data <= '$c->busca_ano-$busca_mes_fim-31 23:59:59' ) ";
        }
        
        $onde_status .= " and pi.id_status != '14' ";
        $condicao = " FROM vsites_pedido as p, vsites_pedido_item as pi
		 WHERE
						pi.id_empresa_atend = '" . $controle_id_empresa . "' and
						pi.id_pedido=p.id_pedido and
						" . $onde_status . "
						 " . $onde . " and " . $tipo_busca . " 
						order by " . $c->busca_ordenar_por;
        $campo = "pi.id_fatura, pi.valor_rec as total, pi.certidao_estado, pi.certidao_cidade, pi.certidao_devedor, "
                . "pi.data_prazo, pi.inicio, p.nome, p.cpf, pi.data_atividade, p.data, pi.id_pedido_item, "
                . "pi.id_pedido, pi.data_i, pi.ordem, pi.id_usuario_op, pi.certidao_nome, pi.valor, pi.dias, "
                . "pi.status_hora, pi.id_atividade, pi.notificada ";
        
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $c->pagina . '&', '', $_SERVER['REQUEST_URI']), $url_busca_pos + 5);

        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($c->pagina == NULL) ? 1 : $c->pagina;
        
        $this->sql = 'SELECT count(0) as total ' . $condicao;
        $cont = $this->fetch();
        $this->total = $cont[0]->total;
        
        
        $this->sql = "SELECT " . $campo . " " . $condicao . " LIMIT " . $this->getInicio() . ", " . $this->maximo;
        #echo $this->sql;
        return $this->fetch();
        
    }
    
    public function graficos($id_empresa = 0, $acao = 1){
        switch($acao){
            case 1:
                
                $cachediaCLASS = new CacheDiaCLASS();
		$filename = 'PedidoDAO-graficos-total'.$id_empresa.'.csv';
		$verifica = $cachediaCLASS->VerificaCache($filename);
		if($verifica==false) {
                    $empresaDAO = new EmpresaDAO();
                    $dt = $empresaDAO->selectPorId($id_empresa);
                    $data_i = ($dt->inicio == '0000-00-00') ? '2008-01-01 00:00:00' : $dt->inicio .' 00:00:00';
                    $data_f = date('Y-m-d 23:59:59', strtotime('- 1 days', strtotime(date('Y-m-d'))));    
                    $this->sql = "SELECT COUNT(*) AS total, DATE_FORMAT(pi.data, '%Y-%m-%d') AS data
                        FROM vsites_pedido AS p, vsites_pedido_item AS pi
                        WHERE pi.id_pedido = p.id_pedido AND (p.data >= ? AND p.data <= ?) 
                        AND (pi.id_empresa_atend IN (?))
                        GROUP BY DATE_FORMAT(pi.data, '%Y-%m')
                        ORDER BY p.data";
                    $this->values = array($data_i, $data_f, $id_empresa);
                    $ret = $this->fetch();
                    $campos = "total;data";
                    $geracsv = $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);		
		} else {
                    $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
		}
                return $ret;
                break;
            
            case 2:
                
                break;
        }
    }

    public function ultimos_pedidos($id_empresa = 0){
        $this->sql = "SELECT p.nome, p.cidade, p.estado, p.cpf, p.email, pi.data, pi.id_pedido, 
                    p.id_afiliado,pi.certidao_nome, pi.certidao_cpf, pi.data_atividade, pi.id_atividade, 
                    u.nome as atendente, pi.ordem, pi.certidao_cidade,pi.certidao_estado, s.descricao as 
                    desc_servico, pi.certidao_nome, pi.id_pedido_item, pi.valor from vsites_pedido as p, 
                    vsites_pedido_item as pi, vsites_user_usuario as u, vsites_servico as s 
                    where u.id_empresa = ? and pi.id_usuario = u.id_usuario and 
                    pi.id_pedido = p.id_pedido and pi.id_servico = s.id_servico and 
                    (pi.id_status = '0' or pi.id_atividade = '0') order by pi.id_pedido DESC, 
                    pi.ordem LIMIT 0, 20";
        $this->values = array($id_empresa);
        return $this->fetch();
    }
    
}

?>
