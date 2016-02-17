<?php

class FinanceiroDAO extends Database
{

    public function __construct()
    {
        $this->table = 'vsites_financeiro';
        parent::__construct();
    }

    /**
     * retorna uma lista de forma de desembolso
     */
    public function listarForma()
    {
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'FinanceiroDAO-listarForma.csv';
        $verifica = $cachediaCLASS->VerificaCache($filename);

        if ($verifica == false) {
            $this->sql = "SELECT * from vsites_fin_forma as ff where status=1 order by forma";
            $this->values = array();
            $ret = $this->fetch();
            $campos = "id_fin_forma;forma;status;forma_2";
            $geracsv = $cachediaCLASS->ConvertArrayToCsv($filename, $ret, $campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;

    }

    /**
     * retorna uma lista de classificacao
     */
    public function listarClassificacao()
    {
        $this->sql = "SELECT * from vsites_classificacao as c where ordem='1' order by classificacao";
        return $this->fetch();
    }

    /**
     * retorna uma lista de classificacao
     */
    public function listarClassificacaoRec()
    {
        $this->sql = "SELECT * from vsites_classificacao as c where recebimento='1' order by classificacao";
        return $this->fetch();
    }

    /**
     * retorna uma lista de classificacao
     */
    public function listarPlanoConta()
    {
        $this->sql = "SELECT * from vsites_fin_planocontas as c where status=1 order by descricao";
        return $this->fetch();
    }

    /**
     * retorna uma lista de desembolso do pedido_item
     * @param int $id_pedido_item
     */
    public function listarPedidoItemDesembolso($id_pedido_item)
    {
        $this->sql = "SELECT (financeiro_valor+financeiro_sedex+financeiro_rateio) as financeiro_valor, financeiro_tipo, financeiro_data, financeiro_descricao, financeiro_autorizacao, id_financeiro from vsites_financeiro as f where id_pedido_item=? and financeiro_tipo='Desembolso' order by financeiro_data desc";
        $this->values = array($id_pedido_item);
        return $this->fetch();
    }

    /**
     * retorna uma lista de desembolso do pedido_item
     * @param int $id_pedido_item
     */
    public function somaPedidoItemDesembolso($id_pedido_item, $id_empresa)
    {
        $this->sql = "SELECT SUM(financeiro_valor+financeiro_sedex+financeiro_rateio) as total from vsites_financeiro as f, vsites_user_usuario as uu where f.id_pedido_item=? and f.financeiro_tipo='Desembolso' and f.financeiro_autorizacao='Aprovado' and f.id_usuario=uu.id_usuario and uu.id_empresa=? group by f.id_pedido_item";
        $this->values = array($id_pedido_item, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * retorna uma lista de recebimento do pedido_item
     * @param int $id_pedido_item
     * @param int $id_empresa
     */
    public function listarPedidoItemRecebimento($id_pedido_item, $id_empresa)
    {
        $this->sql = "SELECT (f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio) as financeiro_valor, f.financeiro_tipo, f.financeiro_data, f.financeiro_descricao, f.financeiro_autorizacao, f.id_financeiro from vsites_financeiro as f, vsites_user_usuario as u where f.id_pedido_item=? and f.financeiro_tipo='Recebimento' and f.id_usuario=u.id_usuario and u.id_empresa=? order by f.financeiro_data desc";
        $this->values = array($id_pedido_item, $id_empresa);
        return $this->fetch();
    }

    /**
     * retorna uma lista de formas de pagamento
     */
    public function listarFormaPagamento()
    {
        $this->sql = "SELECT sql_cache * from vsites_forma_pagamento as fp order by forma_pagamento";
        return $this->fetch();
    }

    /**
     * retorna uma lista de formas de pagamento
     */
    public function listarFormaPagamentoCAP()
    {
        $this->sql = "SELECT * from vsites_forma_pagamento as fp where cap=1 order by forma_pagamento";
        return $this->fetch();
    }

    /**
     * retorna uma lista de pacotes
     * n?o pode tirar o order by id_pacote por causa do java script na tela de cadastro
     */
    public function listarPacote()
    {
        $this->sql = "SELECT sql_cache * from vsites_pacotes as p where status='Ativo' order by id_pacote";
        return $this->fetch();
    }

    /**
     * retorna uma lista de pacotes
     * n?o pode tirar o order by id_pacote por causa do java script na tela de cadastro
     */
    public function listarConveniadoHSBC()
    {
        $this->sql = "SELECT sql_cache nome from vsites_user_conveniado as uc where uc.id_cliente='635' order by nome";
        return $this->fetch();
    }

    /**
     * adiciona solicita??o de desembolso
     */
    public function inserirDesembolso($id_pedido_item, $id_usuario, $f, $id_empresa)
    {
        if (!$f->financeiro_data) {
            $f->financeiro_data = date('Y-m-d H:i:s');
        }
        $this->fields = array('id_empresa_fin', 'financeiro_tipo', 'id_usuario', 'financeiro_autorizacao', 'id_pedido_item',
            'financeiro_forma', 'financeiro_classificacao', 'financeiro_banco', 'financeiro_agencia',
            'financeiro_conta', 'financeiro_identificacao', 'financeiro_favorecido', 'financeiro_cpf',
            'financeiro_descricao', 'financeiro_valor', 'financeiro_rateio', 'financeiro_sedex', 'financeiro_data');
        $this->values = array('id_empresa_fin' => $id_empresa, 'financeiro_tipo' => 'Desembolso', 'id_usuario' => $id_usuario, 'financeiro_autorizacao' => 'Pendente', 'id_pedido_item' => $id_pedido_item,
            'financeiro_forma' => $f->financeiro_forma, 'financeiro_classificacao' => $f->financeiro_classificacao, 'financeiro_banco' => $f->financeiro_banco, 'financeiro_agencia' => $f->financeiro_agencia,
            'financeiro_conta' => $f->financeiro_conta, 'financeiro_identificacao' => $f->financeiro_identificacao, 'financeiro_favorecido' => $f->financeiro_favorecido, 'financeiro_cpf' => $f->financeiro_cpf,
            'financeiro_descricao' => $f->financeiro_descricao, 'financeiro_valor' => $f->financeiro_valor, 'financeiro_rateio' => $f->financeiro_rateio, 'financeiro_sedex' => $f->financeiro_sedex, 'financeiro_data' => $f->financeiro_data);
        $this->insert();

        $s->status_obs = $f->financeiro_descricao;
        $s->status_hora = '';
        $atividadeDAO = new AtividadeDAO();
        $ativ = $atividadeDAO->inserirAtividade('115', $s, $id_usuario, $id_pedido_item);

        return 1;
    }

    /**
     * adiciona solicita??o de desembolso
     */
    public function inserirFatura($id_empresa, $id_usuario, $acao, $retem_imposto)
    {
        $this->table = 'vsites_fin_fatura';
        $this->fields = array('id_empresa', 'id_usuario', 'acao', 'retem_imposto');
        $this->values = array('id_empresa' => $id_empresa, 'id_usuario' => $id_usuario, 'acao' => $acao, 'retem_imposto' => $retem_imposto);
        return $this->insert();
    }


    /**
     * atualiza pedido item com os dados da fatura
     */
    public function atualizaFaturaPedidoItem($id_pedido_item, $id_fatura, $valor, $custas)
    {
        $this->sql = "update vsites_pedido_item set valor = ?, valor_custas=?, id_fatura=? where id_pedido_item=?";
        $this->values = array($valor, $custas, $id_fatura, $id_pedido_item);
        $this->update();
    }

    /**
     * adiciona recebimento
     */
    public function inserirRecebimento($id_pedido_item, $id_empresa, $id_usuario, $f)
    {
        $data = date('Y-m-d H:i:s');

        $this->fields = array('financeiro_autorizacao_data', 'financeiro_tipo', 'id_empresa_fin', 'id_usuario', 'financeiro_autorizacao', 'id_pedido_item',
            'financeiro_forma', 'financeiro_classificacao', 'financeiro_identificacao',
            'financeiro_descricao', 'financeiro_valor', 'financeiro_data_p', 'financeiro_nossa_conta');
        $this->values = array('financeiro_autorizacao_data' => $data, 'financeiro_tipo' => 'Recebimento', 'id_empresa_fin' => $id_empresa, 'id_usuario' => $id_usuario, 'financeiro_autorizacao' => 'Aprovado', 'id_pedido_item' => $id_pedido_item,
            'financeiro_forma' => $f->financeiro_forma, 'financeiro_classificacao' => $f->financeiro_classificacao, 'financeiro_identificacao' => $f->financeiro_identificacao,
            'financeiro_descricao' => $f->financeiro_descricao, 'financeiro_valor' => $f->financeiro_valor, 'financeiro_data_p' => $f->financeiro_data_p, 'financeiro_nossa_conta' => $f->financeiro_nossa_conta);
        $this->insert();

        $this->sql = "update vsites_pedido_item set valor_rec = ? where id_pedido_item=?";
        $this->values = array($f->financeiro_valor_rec, $id_pedido_item);
        $this->update();

        if ($f->id_status == '2' or $f->id_status == '11') {
            $s->status_obs = '';
            $s->status_dias = 0;
            $s->status_hora = '';
            $atividadeDAO = new AtividadeDAO();
            $done = $atividadeDAO->inserirAtividade('137', $s, $id_usuario, $id_pedido_item);
        }

        return 1;
    }

    /**
     * adiciona recebimento de royalties
     */
    public function inserirRecebimentoRoy($id_rel_royalties, $id_empresa, $id_usuario, $f)
    {
        $data = date('Y-m-d H:i:s');

        $this->fields = array('financeiro_autorizacao_data', 'financeiro_tipo', 'id_empresa_fin', 'id_usuario', 'id_empresa_f', 'financeiro_autorizacao', 'id_rel_royalties',
            'financeiro_forma', 'financeiro_classificacao', 'financeiro_identificacao',
            'financeiro_descricao', 'financeiro_valor', 'financeiro_data_p', 'financeiro_nossa_conta');
        $this->values = array('financeiro_autorizacao_data' => $data, 'financeiro_tipo' => 'Recebimento', 'id_empresa_fin' => $id_empresa, 'id_usuario' => $id_usuario, 'id_empresa_f' => $f->id_empresa_f, 'financeiro_autorizacao' => 'Aprovado', 'id_rel_royalties' => $id_rel_royalties,
            'financeiro_forma' => $f->financeiro_forma, 'financeiro_classificacao' => $f->financeiro_classificacao, 'financeiro_identificacao' => $f->financeiro_identificacao,
            'financeiro_descricao' => $f->financeiro_descricao, 'financeiro_valor' => $f->financeiro_valor, 'financeiro_data_p' => $f->financeiro_data_p, 'financeiro_nossa_conta' => $f->financeiro_nossa_conta);
        $this->insert();

        $this->sql = "update vsites_rel_royalties set fpp_rec = fpp_rec+?, roy_rec=roy_rec+? where id_rel_royalties=?";
        $this->values = array($f->fpp_rec, $f->roy_rec, $id_rel_royalties);
        $this->update();

        return 1;
    }

    public function listarRecebimentos($id_pedido)
    {
        $this->sql = 'SELECT f.* FROM vsites_financeiro f, vsites_pedido_item pi
		WHERE pi.id_pedido = ? and pi.id_pedido_item = f.id_pedido_item and f.financeiro_tipo="Recebimento"';
        $this->values = array($id_pedido);
        return $this->fetch();
    }

    /**
     * editar solicita??o de desembolso
     */
    public function editarDesembolso($id_pedido_item, $id_financeiro, $id_usuario, $f, $departamento_p)
    {
        if ($f->financeiro_old_autorizacao != 'Aprovado' and $f->financeiro_autorizacao == 'Aprovado' and $f->financeiro_desembolsado == '') {
            $f->financeiro_desembolsado = number_format((float)($f->financeiro_valor) + (float)($f->financeiro_sedex) + (float)($f->financeiro_rateio), 2, ".", "");
        }

        $where = "financeiro_autorizacao=?, financeiro_forma=?, financeiro_classificacao=?,
        financeiro_banco=?, financeiro_agencia=?, financeiro_conta=?,
        financeiro_identificacao=?, financeiro_favorecido=?, financeiro_cpf=?,
        financeiro_descricao=?, financeiro_forma=?, financeiro_conferido=?, financeiro_nossa_conta=?";
        $this->values[] = $f->financeiro_autorizacao;
        $this->values[] = $f->financeiro_forma;
        $this->values[] = $f->financeiro_classificacao;
        $this->values[] = $f->financeiro_banco;
        $this->values[] = $f->financeiro_agencia;
        $this->values[] = $f->financeiro_conta;
        $this->values[] = $f->financeiro_identificacao;
        $this->values[] = $f->financeiro_favorecido;
        $this->values[] = $f->financeiro_cpf;
        $this->values[] = $f->financeiro_descricao;
        $this->values[] = $f->financeiro_forma;
        $this->values[] = $f->financeiro_conferido;
        $this->values[] = $f->financeiro_nossa_conta;

        if ($f->financeiro_autorizacao != $f->financeiro_old_autorizacao and $f->financeiro_old_autorizacao != 'Aprovado' and $f->financeiro_autorizacao == 'Aprovado') {
            $where .= ",financeiro_autorizacao_data=NOW()";
        }

        if (in_array('2', $departamento_p) == 1) {
            $where .= ", financeiro_desembolsado=? ";
            $this->values[] = $f->financeiro_desembolsado;
        }

        if ($f->financeiro_old_autorizacao == 'Aprovado' and $f->financeiro_autorizacao == 'Reprovado') {
            $where .= ",financeiro_troco=financeiro_desembolsado";
        } else {
            $where .= ",financeiro_troco=?, financeiro_valor=?, financeiro_sedex=?, financeiro_rateio=?";
            $this->values[] = $f->financeiro_troco;
            $this->values[] = $f->financeiro_valor;
            $this->values[] = $f->financeiro_sedex;
            $this->values[] = $f->financeiro_rateio;
        }

        $this->sql = "update vsites_financeiro set " . $where . " where id_pedido_item=? and id_financeiro=?";
        $this->values[] = $id_pedido_item;
        $this->values[] = $id_financeiro;
        $this->exec();

        $id_atividade = '';
        $id_status = '';
        if ($f->financeiro_autorizacao == 'Aprovado' and $f->financeiro_old_autorizacao != 'Aprovado') {
            $id_atividade = '192';
            $id_status = '6';
        }

        if ($f->financeiro_autorizacao == 'Reprovado' and $f->financeiro_old_autorizacao != 'Reprovado') {
            $id_atividade = '159';
            $id_status = '7';
        }

        if ($id_status <> '' and $id_atividade <> '') {
            $atividadeDAO = new AtividadeDAO();
            $ativ = $atividadeDAO->inserir($id_atividade, '', $id_usuario, $id_pedido_item, '');

            $this->sql = "update vsites_pedido_item set data_atividade=NOW(), id_atividade=?, data_i='', id_status=? where id_pedido_item=?";
            $this->values = array($id_atividade, $id_status, $id_pedido_item);
            $this->exec();
        }

        return 1;
    }

    /**
     * Lista pedidos que est?o no cookie
     **/
    public function listaPedidoIn($im, $id_empresa)
    {
        $this->sql = "select pi.id_pedido_item, pi.id_pedido, pi.ordem, pi.id_status, pi.id_atividade, pi.custas, pi.valor, pi.valor_rec from vsites_pedido_item as pi where pi.id_pedido_item IN (" . $im . ") and pi.id_empresa_atend='" . $id_empresa . "'";
        return $this->fetch();
    }

    /**
     * Lista rel royalties que est?o no cookie
     **/
    public function listaRoyIn($im)
    {
        $this->sql = "select replace(ue.fantasia,'Cart?rio Postal - ','') as fantasia, rr.id_rel_royalties, rr.roy_rec, rr.fpp_rec, rr.valor_propaganda, rr.valor_royalties, rr.id_empresa
		from vsites_user_empresa as ue, vsites_rel_royalties as rr where rr.id_rel_royalties IN (" . $im . ") and ue.id_empresa=rr.id_empresa";
        return $this->fetch();
    }

    /**
     * Lista pedidos que est?o no cookie relacionando com a tabela pedido
     **/
    public function listaPedidoIn2($im, $id_empresa)
    {
        $this->sql = "select pi.id_pedido_item, pi.id_pedido, pi.ordem, pi.id_status, pi.id_atividade, pi.custas, pi.id_fatura, pi.valor, pi.valor_rec, p.* from vsites_pedido_item as pi, vsites_pedido as p where pi.id_pedido_item IN (" . $im . ") and pi.id_empresa_atend='" . $id_empresa . "' and pi.id_pedido=p.id_pedido";
        return $this->fetch();
    }

    public function contaDesembolsos($id_pedido_item)
    {
        $this->sql = "select COUNT(0) as total from vsites_financeiro as f where f.id_pedido_item='" . $id_pedido_item . "' and f.financeiro_tipo='Desembolso' and f.financeiro_autorizacao='Aprovado' and f.financeiro_classificacao='38'";
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * deleta recebimento
     * @param int $id_financeiro
     **/
    public function deletaRecebimento($id_financeiro, $id_pedido_item, $valor)
    {
        $this->sql = "delete from vsites_financeiro where id_financeiro=? and financeiro_tipo='recebimento'";
        $this->values = array($id_financeiro);
        $ret = $this->exec();

        $this->sql = "update vsites_pedido_item set valor_rec=valor_rec-" . $valor . " where id_pedido_item=?";
        $this->values = array($id_pedido_item);
        $this->update();

        return $ret;
    }

    /**
     * editar solicita??o de recebimento
     */
    public function editarRecebimento($id_financeiro, $id_pedido_item, $controle_id_empresa, $departamento_p, $departamento_s, $f)
    {
        $this->sql = "update vsites_financeiro set
        financeiro_forma=?, financeiro_classificacao=?, financeiro_identificacao=?, financeiro_descricao=?,
		financeiro_data_p=?, financeiro_nossa_conta=?, financeiro_valor=?
		where id_pedido_item=? and id_financeiro=?";
        $this->values[] = $f->financeiro_forma;
        $this->values[] = $f->financeiro_classificacao;
        $this->values[] = $f->financeiro_identificacao;
        $this->values[] = $f->financeiro_descricao;
        $this->values[] = $f->financeiro_data_p;
        $this->values[] = $f->financeiro_nossa_conta;
        $this->values[] = $f->financeiro_valor;
        $this->values[] = $id_pedido_item;
        $this->values[] = $id_financeiro;
        return $this->exec();
    }

    public function buscaRecebimento($busca, $id_empresa, $pagina)
    {
        $url_busca = $_SERVER['REQUEST_URI'];
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $url_busca), $url_busca_pos + 5);
        global $controle_id_usuario;

        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        if ($busca->busca_ord == 'Decr') $busca->busca_ordenar_por_o .= ' DESC ';
        $busca->busca_ordenar_por = ' pi.id_pedido ' . $busca->busca_ordenar_por_o . ', pi.ordem ' . $busca->busca_ordenar_por_o;
        if ($busca->busca_ordenar == 'Documento de') $busca->busca_ordenar_por = ' pi.certidao_nome ' . $busca->busca_ordenar_por_o; else
            if ($busca->busca_ordenar == 'Servi?o') $busca->busca_ordenar_por = ' pi.id_servico ' . $busca->busca_ordenar_por_o; else
                if ($busca->busca_ordenar == 'Ordem') $busca->busca_ordenar_por = ' pi.id_pedido, pi.ordem ' . $busca->busca_ordenar_por_o; else
                    if ($busca->busca_ordenar == 'Data') $busca->busca_ordenar_por = ' pi.data ' . $busca->busca_ordenar_por_o; else
                        if ($busca->busca_ordenar == 'Cidade') $busca->busca_ordenar_por = ' pi.certidao_estado ' . $busca->busca_ordenar_por_o . ', pi.certidao_cidade ' . $busca->busca_ordenar_por_o; else
                            if ($busca->busca_ordenar == 'Estado') $busca->busca_ordenar_por = ' pi.certidao_estado ' . $busca->busca_ordenar_por_o; else
                                if ($busca->busca_ordenar == 'Departamento') $busca->busca_ordenar_por = ' pi.id_servico_departamento ' . $busca->busca_ordenar_por_o; else
                                    if ($busca->busca_ordenar == 'Prazo') $busca->busca_ordenar_por = $busca->data_prazo_inc . $busca->busca_ordenar_por_o; else
                                        if ($busca->busca_ordenar == 'Data Status') $busca->busca_ordenar_por = ' pi.data_atividade ' . $busca->busca_ordenar_por_o; else
                                            if ($busca->busca_ordenar == 'Agenda') $busca->busca_ordenar_por = ' pi.data_i ' . $busca->busca_ordenar_por_o . ', pi.status_hora ' . $busca->busca_ordenar_por_o;
        if ($busca->busca_ordenar == 'Devedor') $busca->busca_ordenar_por = ' pi.certidao_devedor ' . $busca->busca_ordenar_por_o . ', pi.certidao_nome ' . $busca->busca_ordenar_por_o;

        $onde = '';

        if ($busca->busca_id_pedido <> '') $onde .= " and pi.id_pedido= '" . $busca->busca_id_pedido . "' ";

        if ($busca->busca_id_status == '') $busca->busca_id_status = '8';
        if ($busca->busca_id_status == 'Todos') $busca->busca_id_status = '';
        if ($busca->busca_id_status <> '') {
            $onde .= " and pi.id_status='" . $busca->busca_id_status . "'";
        }

        if ($busca->busca_id_usuario <> '') $onde .= " and pi.id_usuario = '" . $busca->busca_id_usuario . "' ";
        if ($busca->busca_id_fatura <> '') $onde .= " and pi.id_fatura = '" . $busca->busca_id_fatura . "' ";
        if ($busca->busca_id_departamento <> '') {
            $onde .= " and pi.id_servico_departamento='" . $busca->busca_id_departamento . "'";
        }
        if ($busca->busca_id_atividade <> '') {
            $onde .= " and pi.id_atividade='" . $busca->busca_id_atividade . "'";
        }
        if ($busca->busca_origem <> '') {
            $onde .= " and p.origem='" . $busca->busca_origem . "'";
        }
        if ($busca->busca_forma_pagamento <> '') $onde .= " and p.forma_pagamento= '" . $busca->busca_forma_pagamento . "' ";
        if ($busca->busca_contato <> '') $onde .= " and p.contato like '" . $busca->busca_contato . "%' ";
        if ($busca->busca_id_pacote == 1 and $busca->busca_id_status != 2)
            $onde .= " and p.id_pacote= '" . $busca->busca_id_pacote . "' and pi.pacote_lib='1' and (pi.id_servico='11' or pi.id_servico='16' or pi.id_servico='64' or pi.id_servico='169' or pi.id_servico='156' or pi.id_servico='117') ";
        else
            if ($busca->busca_id_pacote == '2' and $busca->busca_id_status != 2)
                $onde .= " and p.id_pacote= '" . $busca->busca_id_pacote . "' and pi.pacote_lib='1'";
            else
                if ($busca->busca_id_pacote == '3' and $busca->busca_id_status != 2)
                    $onde .= " and p.id_pacote= '" . $busca->busca_id_pacote . "'";
                else
                    if ($busca->busca_id_status != 2)
                        $onde .= " and (p.id_pacote = '1' and pi.id_servico!='11' and pi.id_servico!='16' and pi.id_servico!='64' and pi.id_servico='169' and pi.id_servico='156' and pi.id_servico!='117' or p.id_pacote='0') ";

        if ($busca->busca_data_i_f <> '') {
            $onde .= " and pi.inicio>='" . $busca->busca_data_i_f . " 00:00:00'";
        }
        if ($busca->busca_data_f_f <> '') {
            $onde .= " and pi.inicio<='" . $busca->busca_data_f_f . " 23:59:59'";
        }
        if ($busca->busca_data_i_a <> '') {
            $onde .= " and pi.data_atividade>='" . $busca->busca_data_i_a . " 00:00:00'";
        }
        if ($busca->busca_data_f_a <> '') {
            $onde .= " and pi.data_atividade<='" . $busca->busca_data_f_a . " 23:59:59'";
        }
        if ($busca->busca_data_i <> '') {
            $onde .= " and pi.data>='" . $busca->busca_data_i . " 00:00:00'";
        }
        if ($busca->busca_data_f <> '') {
            $onde .= " and pi.data<='" . $busca->busca_data_f . " 23:59:59'";
        }
        if ($busca->busca_data_ci <> '') {
            $onde .= " and pi.encerramento>='" . $busca->busca_data_ci . " 00:00:00'";
        }
        if ($busca->busca_data_cf <> '') {
            $onde .= " and pi.encerramento<='" . $busca->busca_data_cf . " 23:59:59'";
        }
        if ($busca->busca <> '') {
            $onde .= " and (p.nome like '" . $busca->busca . "%' or pi.certidao_devedor = '" . $busca->busca . "' or pi.certidao_nome like '" . $busca->busca . "%' or pi.certidao_pai like '" . $busca->busca . "%' or pi.certidao_mae like '" . $busca->busca . "%' or pi.certidao_esposa like '" . $busca->busca . "%' or pi.certidao_marido like '" . $busca->busca . "%' or replace(replace(replace(pi.certidao_cpf,'.',''),'-',''),'/','') = replace(replace(replace('" . $busca->busca . "','.',''),'-',''),'/','') or replace(replace(replace(pi.certidao_cnpj,'.',''),'-',''),'/','') = replace(replace(replace('" . $busca->busca . "','.',''),'-',''),'/','') or replace(replace(replace(p.cpf,'.',''),'-',''),'/','') = replace(replace(replace('" . $busca->busca . "','.',''),'-',''),'/','')) ";
        }

        if ($busca->busca_autorizacao == 'Recebido') $tipo_busca = "	pi.valor_rec >= pi.valor";
        else if ($busca->busca_autorizacao == '_') $tipo_busca = ' 1=1 ';
        else $tipo_busca = " (pi.valor_rec < pi.valor or pi.valor_rec IS NULL) ";

        $condicao = " from vsites_pedido_item as pi,
		vsites_pedido_fin as pif, 
		vsites_pedido as p, 
		vsites_atividades as a, 
		vsites_status as st, 
		vsites_servico as s
			where
			pi.id_empresa_atend = '" . $id_empresa . "' and
			pi.id_status != '14' and pi.id_status != '0'
                        " . $onde . " and
			pi.id_pedido = p.id_pedido  and
			pi.id_atividade 			= a.id_atividade and
                        pi.id_status 			= st.id_status and
			pi.id_servico 				= s.id_servico  and
			pi.id_pedido_item=pif.id_pedido_item and " . $tipo_busca;

        $condicaocount = " from vsites_pedido_item as pi,
		vsites_pedido as p
			where
			pi.id_empresa_atend = '" . $id_empresa . "' and
			pi.id_status != '14'
                        " . $onde . " and
			pi.id_pedido = p.id_pedido  and " . $tipo_busca;

        $campo = "st.status,pi.id_fatura, pi.valor_rec as total, pi.certidao_estado, pi.certidao_cidade, pi.certidao_devedor, pi.data_prazo, pi.status_hora,
		pi.inicio, pi.data_atividade, pi.id_pedido_item, pi.id_pedido, pi.data_i, pi.ordem, pi.id_usuario_op, pi.certidao_nome, pi.valor, pi.dias,
		pif.custas, pif.rateio, pif.sedex,
		p.nome, p.cpf, p.forma_pagamento, p.data, p.origem,pi.id_usuario,
		s.descricao as servico, a.atividade";

        $this->sql = 'SELECT count(0) as total,  SUM(pi.valor_rec) as valor_rec_t, SUM(pi.valor) as valor_t ' . $condicaocount;
        $cont = $this->fetch();
        $this->total = $cont[0]->total;
        $valor_t = $cont[0]->valor_t;
        $valor_rec_t = $cont[0]->valor_rec_t;

        $this->sql = "SELECT " . $campo . " " . $condicao . " order by " . $busca->busca_ordenar_por . " LIMIT " . $this->getInicio() . ", " . $this->maximo;
        $ret = $this->fetch();
        $ret[0]->valor_t = $valor_t;
        $ret[0]->valor_rec_t = $valor_rec_t;
        $_SESSION['pedido_campo'] = $campo;
        $_SESSION['pedido_condicao'] = $condicao;

        #if($controle_id_usuario==1){
        #print_r($this->sql);
        #echo '<br />';
        #print_r ($this->values);
        #exit;
        #}

        return $ret;
    }

    public function atualizaConta($ids, $conta, $id_empresa)
    {
        $this->sql = 'UPDATE vsites_financeiro SET financeiro_nossa_conta=? WHERE id_financeiro IN (';
        $this->values = array($conta);
        foreach ($ids as $i => $id) {
            $this->sql .= ($i == 0) ? '' : ',';
            $this->sql .= '?';
            $this->values[] = $id;
        }
        $this->sql .= ') and id_empresa_fin=?';
        $this->values[] = $id_empresa;
        return $this->exec();
    }

    #controle de recebimento de royalties
    public function buscaRecebimentoRoy($busca, $id_empresa, $pagina)
    {
        $url_busca = $_SERVER['REQUEST_URI'];
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $url_busca), $url_busca_pos + 5);

        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        if ($id_empresa != 1) return '';
        $where = "";
        if ((int)($busca->mes) < 9 and $busca->mes > '') $busca->mes = '0' . (int)($busca->mes);
        if ($busca->id_empresa <> '') $where .= " and rr.id_empresa= '" . $busca->id_empresa . "' ";
        if ($busca->ano <> '' and $busca->mes <> '') $where .= " and date_format(rr.data,'%Y-%m')='" . $busca->ano . "-" . $busca->mes . "'";
        if ($busca->ano <> '' and $busca->mes == '') $where .= " and date_format(rr.data,'%Y')='" . $busca->ano . "'";

        if ($busca->situacao == '1') $where .= " and rr.valor_royalties+rr.valor_propaganda<=rr.roy_rec+rr.fpp_rec and (rr.valor_propaganda>0 or rr.valor_royalties>0)";
        else if ($busca->situacao == '') $where .= " and rr.valor_royalties+rr.valor_propaganda>rr.roy_rec+rr.fpp_rec and (rr.valor_propaganda>0 or rr.valor_royalties>0)";

        $this->sql = "SELECT COUNT(0) as total,
		SUM(CASE WHEN rr.fpp_rec>rr.valor_propaganda THEN rr.fpp_rec-rr.valor_propaganda ELSE 0 END) as valor_juros_fpp_t,
		SUM(CASE WHEN rr.roy_rec>rr.valor_royalties THEN rr.roy_rec-rr.valor_royalties ELSE 0 END) as valor_juros_roy_t, 
		SUM(rr.valor_royalties) as valor_roy_t,SUM(rr.valor_propaganda) as valor_fpp_t, 
		SUM(rr.valor_royalties+rr.valor_propaganda) as valor_t, SUM(rr.roy_rec+rr.fpp_rec) as valor_rec_t  
					FROM vsites_user_empresa ue
					INNER JOIN vsites_rel_royalties as rr on rr.id_empresa=ue.id_empresa
					WHERE rr.id_empresa!=1 " . $where . " ";
        $cont = $this->fetch();
        $this->total = $cont[0]->total;
        $valor_t = $cont[0]->valor_t;
        $valor_rec_t = $cont[0]->valor_rec_t;
        $valor_roy_t = $cont[0]->valor_roy_t;
        $valor_fpp_t = $cont[0]->valor_fpp_t;
        $valor_juros_roy_t = $cont[0]->valor_juros_roy_t;
        $valor_juros_fpp_t = $cont[0]->valor_juros_fpp_t;


        $this->sql = "SELECT rr.id_rel_royalties, date_format(rr.data,'%m/%Y') as ref, ue.id_empresa, ue.fantasia as fantasia, rr.valor_propaganda as fpp, valor_royalties as roy, rr.roy_rec, rr.fpp_rec
					FROM vsites_user_empresa ue
					INNER JOIN vsites_rel_royalties as rr on rr.id_empresa=ue.id_empresa
					WHERE rr.id_empresa!=1
					" . $where . " ORDER BY ue.fantasia, date_format(rr.data,'%m/%Y') LIMIT " . $this->getInicio() . ", " . $this->maximo;

        global $controle_id_usuario;
        if ($controle_id_usuario == 1) {

            #echo $this->sql;
            #exit;
        }

        $ret = $this->fetch();

        $ret[0]->valor_t = $valor_t;
        $ret[0]->valor_roy_t = $valor_roy_t;
        $ret[0]->valor_fpp_t = $valor_fpp_t;
        $ret[0]->valor_rec_t = $valor_rec_t;
        $ret[0]->valor_juros_roy_t = $valor_juros_roy_t + $valor_juros_fpp_t;

        return $ret;
    }

    /**
     * Lista recebimentos de um mes especifico e de uma franquia especifica
     **/
    public function recebimentoRoy($ref, $id_empresa)
    {
        $this->sql = "select date_format(f.financeiro_data_p,'%d/%m/%Y') as financeiro_data_p, f.financeiro_forma, format(f.financeiro_valor,'.') as financeiro_valor, f.financeiro_descricao as financeiro_descricao from vsites_financeiro as f, vsites_rel_royalties as rr where date_format(rr.data,'%m/%Y')= ? and rr.id_empresa=? and rr.id_rel_royalties=f.id_rel_royalties";
        $this->values[] = $ref;
        $this->values[] = $id_empresa;
        return $this->fetch();
    }

    /**
     * Calcula Fluxo de Caixa
     **/
    public function listaFluxoCaixa($dia, $mes, $ano, $id_empresa, $banco, $atualiza)
    {
        if ($atualiza == 1) {
            $this->sql = "delete from vsites_rel_caixa where id_empresa=? and date_format(data,'%Y-%m')=?";
            $this->values = array($id_empresa, $ano . '-' . $mes);
            $this->delete();

            $this->sql = "insert into vsites_rel_caixa(
			select NULL, f.id_empresa, data, SUM(f.financeiro_desembolsado) as financeiro_desembolsado, SUM(f.financeiro_valor) as financeiro_valor, SUM(f.financeiro_sedex) as financeiro_sedex, SUM(f.financeiro_rateio) as financeiro_rateio, SUM(f.financeiro_troco) as financeiro_troco, SUM(recebimento) as recebimento, financeiro_nossa_conta from (
				SELECT f.id_empresa_fin as id_empresa, date_format(f.financeiro_autorizacao_data,'%Y-%m-%d') as data, SUM(f.financeiro_valor) as financeiro_valor, SUM(f.financeiro_sedex) as financeiro_sedex, SUM(f.financeiro_rateio) as financeiro_rateio, SUM(f.financeiro_troco) as financeiro_troco, SUM(f.financeiro_desembolsado) as financeiro_desembolsado, (0) as recebimento, f.financeiro_nossa_conta FROM vsites_financeiro as f where f.financeiro_tipo='Desembolso' and f.financeiro_autorizacao='Aprovado' and date_format(f.financeiro_autorizacao_data,'%Y-%m')=? and f.id_empresa_fin=? group by date_format(f.financeiro_autorizacao_data,'%d/%m/%Y'), f.financeiro_nossa_conta
				UNION
				SELECT f.id_empresa, date_format(f.dt_pagamento,'%Y-%m-%d') as data, SUM(0) as financeiro_valor, (0) as financeiro_sedex, SUM(f.valor_pg) as financeiro_rateio, (0) as financeiro_troco, SUM(f.valor_pg) as financeiro_desembolsado, (0) as recebimento, c.sigla as financeiro_nossa_conta FROM vsites_fin_pagamento as f, vsites_conta as c where date_format(f.dt_pagamento,'%Y-%m')=? and f.id_empresa=? and f.id_conta=c.id_conta group by date_format(f.dt_pagamento,'%d/%m/%Y'), f.id_conta
				UNION
				SELECT f.id_empresa_fin as id_empresa, date_format(f.financeiro_autorizacao_data,'%Y-%m-%d') as data, (0) as financeiro_valor, (0) as financeiro_sedex, (0) as financeiro_rateio, (0) as financeiro_troco, (0) as financeiro_desembolsado,SUM(f.financeiro_valor) as recebimento, f.financeiro_nossa_conta FROM vsites_financeiro as f where f.financeiro_tipo='Recebimento' and f.financeiro_autorizacao_data>='2011-09-01 00:00:00' and date_format(f.financeiro_autorizacao_data,'%Y-%m')=? and f.id_empresa_fin=? group by date_format(f.financeiro_autorizacao_data,'%d/%m/%Y'), f.financeiro_nossa_conta
			) as f group by data, financeiro_nossa_conta)";
            $this->values = array($ano . '-' . $mes, $id_empresa, $ano . '-' . $mes, $id_empresa, $ano . '-' . $mes, $id_empresa);
            $this->exec();
        }

        $this->values = array($id_empresa, $ano . '-' . $mes);

        if ($banco <> '') {
            $onde .= " and financeiro_nossa_conta=? ";
            $this->values[] = $banco;
        }

        $this->sql = "select * from vsites_rel_caixa where id_empresa=? and date_format(data,'%Y-%m')=? " . $onde . " order by data";

        return $this->fetch();
    }

    /**
     * Calcula Fluxo de Caixa
     **/
    public function listaFluxoCaixaItem($dia, $mes, $ano, $id_empresa, $banco, $atualiza)
    {
        $this->sql = "
		select f.id_empresa, data, f.financeiro_desembolsado as financeiro_desembolsado, f.financeiro_valor as financeiro_valor, f.financeiro_sedex as financeiro_sedex, f.financeiro_rateio as financeiro_rateio, f.financeiro_troco as financeiro_troco, recebimento as recebimento, financeiro_nossa_conta from (
			SELECT f.id_empresa_fin as id_empresa, date_format(f.financeiro_autorizacao_data,'%Y-%m-%d') as data, f.financeiro_valor as financeiro_valor, f.financeiro_sedex as financeiro_sedex, f.financeiro_rateio as financeiro_rateio, f.financeiro_troco as financeiro_troco, (f.financeiro_desembolsado) as financeiro_desembolsado, (0) as recebimento, f.financeiro_nossa_conta FROM vsites_financeiro as f where f.financeiro_tipo='Desembolso' and f.financeiro_autorizacao='Aprovado' and date_format(f.financeiro_autorizacao_data,'%Y-%m')=? and f.id_empresa_fin=?
			UNION
			SELECT f.id_empresa, date_format(f.dt_pagamento,'%Y-%m-%d') as data, (0) as financeiro_valor, (0) as financeiro_sedex, (f.valor_pg) as financeiro_rateio, (0) as financeiro_troco, (f.valor_pg) as financeiro_desembolsado, (0) as recebimento, c.sigla as financeiro_nossa_conta FROM vsites_fin_pagamento as f, vsites_conta as c where date_format(f.dt_pagamento,'%Y-%m')=? and f.id_empresa=? and f.id_conta=c.id_conta
			UNION
			SELECT f.id_empresa_fin as id_empresa, date_format(f.financeiro_autorizacao_data,'%Y-%m-%d') as data, (0) as financeiro_valor, (0) as financeiro_sedex, (0) as financeiro_rateio, (0) as financeiro_troco, (0) as financeiro_desembolsado,(f.financeiro_valor) as recebimento, f.financeiro_nossa_conta FROM vsites_financeiro as f where f.financeiro_tipo='Recebimento' and f.financeiro_autorizacao_data>='2011-09-01 00:00:00' and date_format(f.financeiro_autorizacao_data,'%Y-%m')=? and f.id_empresa_fin=?
		) as f order by data, financeiro_nossa_conta
		";
        $this->values = array($ano . '-' . $mes, $id_empresa, $ano . '-' . $mes, $id_empresa, $ano . '-' . $mes, $id_empresa);

        return $this->fetch();
    }

    /**
     * Retorno de dep?sito
     **/
    public function retornoDeposito($id_pedido_item, $id_financeiro, $id_usuario)
    {
        $this->sql = "update vsites_financeiro as f set financeiro_conferido='on' where id_pedido_item=? and id_financeiro=?";
        $this->values = array($id_pedido_item, $id_financeiro);
        $this->exec();

        $atividadeDAO = new AtividadeDAO();

        $s->status_obs = '.';
        $s->status_dias = '';
        $s->status_hora = '';

        return $atividadeDAO->inserirAtividade('155', $s, $id_usuario, $id_pedido_item);
    }

    /**
     * Envia pedido para Expedi??o
     **/
    public function enviaExpedicao($id_pedido_item, $id_financeiro, $id_usuario)
    {

        $this->sql = "update vsites_financeiro as f set execucao='1' where id_pedido_item=? and id_financeiro=?";
        $this->values = array($id_pedido_item, $id_financeiro);
        $this->exec();

        $atividadeDAO = new AtividadeDAO();

        $s->status_obs = '.';
        $s->status_dias = '';
        $s->status_hora = '';

        return $atividadeDAO->inserirAtividade('213', $s, $id_usuario, $id_pedido_item);
    }

    /**
     * Troco Conferido
     **/
    public function trocoConferido($id_pedido_item, $id_financeiro, $id_empresa)
    {
        $this->sql = "update vsites_financeiro set financeiro_conferido='on' where id_pedido_item=? and id_financeiro=? and id_empresa_fin=?";
        $this->values = array($id_pedido_item, $id_financeiro, $id_empresa);
        $done = $this->exec();
        return $done;
    }

    /**
     * aprova desembolso
     **/
    public function aprovaDesembolso($id_pedido_item, $id_financeiro, $id_usuario, $id_empresa)
    {
        $this->sql = "update vsites_financeiro set financeiro_autorizacao='Aprovado', financeiro_autorizacao_data=NOW(),
		financeiro_desembolsado=financeiro_valor+financeiro_sedex+financeiro_rateio where 
			id_pedido_item=? and id_financeiro=? and id_empresa_fin=?";
        $this->values = array($id_pedido_item, $id_financeiro, $id_empresa);
        $done = $this->exec();
        if ($done <> 0) {
            $atividadeDAO = new AtividadeDAO();
            $atividadeDAO->inserir('192', '', $id_usuario, $id_pedido_item, 0);

            $this->sql = "update vsites_pedido_item set data_atividade=NOW(), id_atividade='192', data_i='', id_status='6' where id_pedido_item=? and (id_empresa_atend=? or id_empresa_resp=? and operacional='0000-00-00')";
            $this->values = array($id_pedido_item, $id_empresa, $id_empresa);
            $this->update();
        }

        return $done;
    }

    /**
     * reprova desembolso
     **/
    public function reprovaDesembolso($id_pedido_item, $id_financeiro, $id_usuario, $id_empresa)
    {
        $this->sql = "update vsites_financeiro set financeiro_autorizacao='Reprovado',
              financeiro_autorizacao_data=NOW() where id_pedido_item=? and id_financeiro=? and id_empresa_fin=?";
        $this->values = array($id_pedido_item, $id_financeiro, $id_empresa);
        $done = $this->exec();

        if ($done <> 0) {
            $atividadeDAO = new AtividadeDAO();
            $atividadeDAO->inserir('159', '', $id_usuario, $id_pedido_item, 0);

            $this->sql = "update vsites_pedido_item set  data_atividade=NOW(), id_atividade='159',data_i='',id_status='7' where id_pedido_item=? and (id_empresa_atend=? or id_empresa_resp=? and operacional='0000-00-00')";
            $this->values = array($id_pedido_item, $id_empresa, $id_empresa);
            $this->update();
        }
        return $done;
    }

    public function buscaDesembolso($busca, $id_empresa, $pagina)
    {
        $url_busca = $_SERVER['REQUEST_URI'];
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $url_busca), $url_busca_pos + 5);

        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        $onde = '';

        if ($busca->busca_id_pedido <> '') {
            $onde .= " and pi.id_pedido='" . $busca->busca_id_pedido . "'";
        }
        if ($busca->busca_ordem <> '') {
            $onde .= " and pi.ordem='" . $busca->busca_ordem . "'";
        }

        if ($busca->busca_id_departamento <> '') {
            $onde .= " and pi.id_servico_departamento='" . $busca->busca_id_departamento . "' ";
        }

        if ($busca->busca_nossa_conta <> '') {
            $onde .= " and trim(f.financeiro_nossa_conta)=trim('" . $busca->busca_nossa_conta . "')";
        }

        if ($busca->busca_data_i <> '')
            $busca->busca_data_i = invert($busca->busca_data_i, '-', 'SQL') . ' ' . substr($busca->busca_data_i, 11, 8);
        else
            $busca->busca_data_i = date('Y-m-d') . ' 00:00:00';

        if ($busca_data_f <> '')
            $busca->busca_data_f = invert($busca->busca_data_f, '-', 'SQL') . ' ' . substr($busca->busca_data_f, 11, 8);
        else
            $busca->busca_data_f = date('Y-m-d') . ' 23:59:59';

        if ($busca->busca_data_i <> '' and $busca->busca_autorizacao != 0) {
            $onde .= " and f.financeiro_autorizacao_data>='" . $busca->busca_data_i . "'";
        }
        if ($busca->busca_data_i <> '' and $busca->busca_autorizacao == 0) {
            $onde .= " and f.financeiro_data>='" . $busca->busca_data_i . "'";
        }

        if ($busca->busca_data_f <> '' and $busca->busca_autorizacao != 0) {
            $onde .= " and f.financeiro_autorizacao_data<='" . $busca->busca_data_f . "'";
        }
        if ($busca->busca_data_f <> '' and $busca->busca_autorizacao == 0) {
            $onde .= " and f.financeiro_data<='" . $busca->busca_data_f . "'";
        }

        switch ($busca->busca_autorizacao) {
            case 0:
                $onde .= " and f.financeiro_autorizacao='Pendente'";
                break;
            case 1:
                $onde .= " and f.financeiro_autorizacao='Aprovado' and f.financeiro_conferido='on'";
                break;
            case 2:
                $onde .= " and f.financeiro_autorizacao='Reprovado'";
                break;
            case 3:
                $onde .= " and f.financeiro_autorizacao='Aprovado' and f.execucao='0' and f.financeiro_conferido=''";
                break;
            case 4:
                $onde .= " and f.financeiro_autorizacao='Aprovado' and f.execucao='1' and f.financeiro_conferido=''";
                break;
        }

        if ($busca->busca_forma == '_') {
            $onde .= " and f.financeiro_forma!='Dep?sito' and f.financeiro_forma!='Boleto'";
        }

        if ($busca->busca_forma <> '' and $busca->busca_forma != '_') {
            $onde .= " and f.financeiro_forma='" . $busca->busca_forma . "'";
        }

        $condicao = "from vsites_pedido_item as pi, vsites_financeiro f
						WHERE f.id_empresa_fin='" . $id_empresa . "' and f.financeiro_tipo='Desembolso' " . $onde . " and f.id_pedido_item=pi.id_pedido_item";

        $campo = "pi.data_prazo, pi.inicio, pi.data_i, pi.certidao_estado, pi.certidao_cidade, pi.id_pedido, pi.ordem, pi.id_pedido_item, pi.certidao_nome, pi.valor,
		f.des2, f.financeiro_troco, f.financeiro_desembolsado, f.id_financeiro, f.rel, f.financeiro_forma, (f.financeiro_valor + f.financeiro_rateio+f.financeiro_sedex) as financeiro_valor";

        $this->sql = 'select COUNT(0) as total, SUM(f.financeiro_valor+f.financeiro_rateio+f.financeiro_sedex) as financeiro_valor2, SUM(f.financeiro_troco) as financeiro_troco2, SUM(f.financeiro_desembolsado) as financeiro_desembolsado2 ' . $condicao;
        $cont = $this->fetch();
        $this->total = $cont[0]->total;
        $financeiro_valor = $cont[0]->financeiro_valor2;
        $financeiro_troco = $cont[0]->financeiro_troco2;
        $financeiro_desembolsado = $cont[0]->financeiro_desembolsado2;

        $this->sql = "SELECT " . $campo . " " . $condicao . " LIMIT " . $this->getInicio() . ", " . $this->maximo;
        $ret = $this->fetch();
        $ret[0]->financeiro_valor_t = $financeiro_valor;
        $ret[0]->financeiro_troco_t = $financeiro_troco;
        $ret[0]->financeiro_desembolsado_t = $financeiro_desembolsado;

        return $ret;
    }

    /**
     * reprova desembolso
     **/
    public function aprovaRecebimentoF($id_pedido_item, $id_financeiro, $id_usuario, $id_empresa, $f, $ret, $tipo)
    {
        $data = DATE('Y-m-d H:i:s');
        $this->table = 'vsites_financeiro_f';
        if ($tipo == '') {
            if ($ret->id_status == 19) {//se estiver em concilia??o franquia, muda o status
                if ($ret->data_prazo == '0000-00-00') {
                    $ret->data_prazo = somar_dias_uteis(date('Y-m-d'), $ret->dias);
                }
                $this->sql = "update vsites_pedido_item set data_i=NOW(), id_atividade='137', id_status='3', data_prazo='" . $ret->data_prazo . "'
				where id_pedido_item=? and id_status=19 and id_empresa_resp=?";
                $this->values = array($id_pedido_item, $id_empresa);
                $this->exec();
            }

            $f->financeiro_descricao = strlen($f->financeiro_descricao) == 0 ? '' : $f->financeiro_descricao;
            $this->fields = array('financeiro_autorizacao', 'financeiro_autorizacao_data', 'id_usuario', 'financeiro_descricao', 'financeiro_forma',
                'financeiro_classificacao', 'financeiro_valor_f', 'financeiro_identificacao', 'financeiro_nossa_conta',
                'financeiro_tipo', 'id_financeiro', 'financeiro_data_p');
            $this->values = array('financeiro_autorizacao' => 'Aprovado', 'financeiro_autorizacao_data' => $data, 'id_usuario' => $id_usuario,
                'financeiro_descricao' => $f->financeiro_descricao, 'financeiro_forma' => $f->financeiro_forma,
                'financeiro_classificacao' => $f->financeiro_classificacao, 'financeiro_valor_f' => $f->financeiro_valor_f,
                'financeiro_identificacao' => $f->financeiro_identificacao, 'financeiro_nossa_conta' => $f->financeiro_nossa_conta,
                'financeiro_tipo' => 'Recebimento', 'id_financeiro' => $id_financeiro, 'financeiro_data_p' => $f->financeiro_data_p);
            $done = $this->insert();

            $atividadeDAO = new AtividadeDAO();
            $atividadeDAO->inserir(137, 'Confirma??o de Recebimento da Franquia', $id_usuario, $id_pedido_item, '');
        } else {
            $this->fields = array('financeiro_autorizacao', 'financeiro_autorizacao_data', 'id_usuario', 'financeiro_descricao', 'financeiro_forma',
                'financeiro_classificacao', 'financeiro_valor_f', 'financeiro_identificacao', 'financeiro_nossa_conta',
                'financeiro_tipo', 'id_financeiro', 'financeiro_data_p');
            $this->values = array('financeiro_autorizacao' => 'Aprovado', 'financeiro_autorizacao_data' => $data, 'id_usuario' => $id_usuario,
                'financeiro_descricao' => $f->financeiro_descricao, 'financeiro_forma' => $f->financeiro_forma,
                'financeiro_classificacao' => $f->financeiro_classificacao, 'financeiro_valor_f' => $f->financeiro_valor_f,
                'financeiro_identificacao' => $f->financeiro_identificacao, 'financeiro_nossa_conta' => $f->financeiro_nossa_conta,
                'financeiro_tipo' => 'Recebimento', 'id_financeiro' => $id_financeiro, 'financeiro_data_p' => $f->financeiro_data_p);
            $done = $this->insert();
        }
        return $done;
    }

    /**
     * reprova desembolso
     **/
    public function reprovaRecebimentoF($id_pedido_item)
    {
        $this->sql = "select f.id_financeiro from
		vsites_financeiro as f where
		f.id_pedido_item = ? and
		f.financeiro_classificacao = '38' and
		f.financeiro_tipo = 'Desembolso' and
		f.financeiro_autorizacao = 'Aprovado'";
        $this->values = array($id_pedido_item);
        $res = $this->fetch();
        foreach ($res as $r) {
            $this->sql = "update vsites_financeiro_f set financeiro_autorizacao='Reprovado'
			where id_financeiro=?";
            $this->values = array($r->id_financeiro);
            $this->exec();
        }
        return;
    }


    public function buscaRecebimentoF($busca, $id_empresa, $pagina)
    {

        $url_busca = $_SERVER['REQUEST_URI'];
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $url_busca), $url_busca_pos + 5);

        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;


        $busca->busca_ordenar_por = ' id_pedido, ordem ';
        if ($busca->busca_ordenar == 'Documento de') $busca->busca_ordenar_por = ' certidao_nome '; else
            if ($busca->busca_ordenar == 'Servi?o') $busca->busca_ordenar_por = ' servico '; else
                if ($busca->busca_ordenar == 'Ordem') $busca->busca_ordenar_por = ' id_pedido, ordem '; else
                    if ($busca->busca_ordenar == 'Data') $busca->busca_ordenar_por = ' data '; else
                        if ($busca->busca_ordenar == 'Cidade') $busca->busca_ordenar_por = ' certidao_cidade '; else
                            if ($busca->busca_ordenar == 'Estado') $busca->busca_ordenar_por = ' certidao_estado '; else
                                if ($busca->busca_ordenar == 'Departamento') $busca->busca_ordenar_por = ' departamento '; else
                                    if ($busca->busca_ordenar == 'Prazo') $busca->busca_ordenar_por = $busca->data_prazo_inc; else
                                        if ($busca->busca_ordenar == 'Data Status') $busca->busca_ordenar_por = ' financeiro_autorizacao_data '; else
                                            if ($busca->busca_ordenar == 'Agenda') $busca->busca_ordenar_por = ' data_i, status_hora ';
        if ($busca->busca_ord == 'Decr') $busca->busca_ordenar_por .= ' DESC ';

        $onde = '';

        if ($busca->busca_data_i <> '') {
            $onde .= " and f.financeiro_data>='" . $busca->busca_data_i . " 00:00:00'";
        }
        if ($busca->busca_data_f <> '') {
            $onde .= " and f.financeiro_data<='" . $busca->busca_data_f . " 23:59:59'";
        }

        if ($busca->busca_id_pedido <> '') $onde .= " and pi.id_pedido= '" . $busca->busca_id_pedido . "' ";
        if ($busca->busca_id_empresa <> '') {
            $onde .= " and pi.id_empresa_atend='" . $busca->busca_id_empresa . "'";
        }

        if ($busca->busca_id_status == 'Todos') $busca->busca_id_status = '';
        if ($busca->busca_id_status <> '') {
            $onde .= " and pi.id_status='" . $busca->busca_id_status . "'";
        } else $onde .= " and pi.id_status!='14' and pi.id_status!='10'";
        if ($busca->busca_id_status == 8) {
            $onde .= " and pi.data_status='0000-00-00 00:00:00'";
        }
        if ($busca->busca_id_departamento <> '') {
            $onde .= " and pi.id_servico_departamento='" . $busca->busca_id_departamento . "'";
        }

        if ($busca->busca_autorizacao == '') $busca->busca_autorizacao = '? Receber';
        if ($busca->busca_autorizacao == 'Recebido') {
            $tipo_busca = "	and ROUND(ff.financeiro_valor_f,2) >= ROUND((f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio),2)";
        } else
            if ($busca->busca_autorizacao != 'Recebido')
                $tipo_busca = " and (ROUND(ff.financeiro_valor_f,2) < ROUND((f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio),2) or ff.financeiro_valor_f IS NULL) ";


        $condicao1 = " from
		(select f.financeiro_valor, f.financeiro_autorizacao_data, f.id_financeiro, f.financeiro_sedex,f.financeiro_rateio, pi.id_pedido, pi.id_pedido_item,pi.data,pi.data_i, pi.valor,pi.status_hora, pi.ordem
		from
		vsites_pedido_item as pi,
		vsites_financeiro as f where
			f.id_empresa_fin != ?
			" . $onde . " and
			f.financeiro_classificacao 	= '38' and
			f.financeiro_tipo = 'Desembolso' and
			f.financeiro_autorizacao = 'Aprovado' and
			pi.id_pedido_item = f.id_pedido_item and
			pi.id_empresa_resp = ?) as f LEFT JOIN 
			(SELECT SUM(ff.financeiro_valor_f) as financeiro_valor_f, ff.id_financeiro 
				from vsites_financeiro_f as ff group by ff.id_financeiro) as ff 
					ON f.id_financeiro = ff.id_financeiro 
					where 1=1 " . $tipo_busca . "
					order by " . $busca->busca_ordenar_por;

        $condicao = " from
		(select f.financeiro_valor, f.financeiro_autorizacao_data, ue.fantasia, s.descricao as servico, f.id_financeiro, f.financeiro_sedex,f.financeiro_rateio, pi.id_pedido, pi.id_pedido_item,pi.certidao_nome,pi.data,pi.certidao_cidade,pi.data_i, pi.valor,pi.status_hora, pi.ordem
		from
		vsites_pedido_item as pi,
		vsites_financeiro as f, 
		vsites_servico as s, 
		vsites_user_empresa as ue where
			f.id_empresa_fin != ?
			" . $onde . " and
			f.financeiro_classificacao 	= '38' and
			f.financeiro_tipo = 'Desembolso' and
			f.financeiro_autorizacao = 'Aprovado' and
			pi.id_pedido_item = f.id_pedido_item and
			pi.id_empresa_resp = ? and
			pi.id_servico = s.id_servico  and
			pi.id_empresa_atend	= ue.id_empresa) as f LEFT JOIN 
			(SELECT SUM(ff.financeiro_valor_f) as financeiro_valor_f, ff.id_financeiro 
				from vsites_financeiro_f as ff group by ff.id_financeiro) as ff 
					ON f.id_financeiro = ff.id_financeiro 
					where 1=1 " . $tipo_busca . "
					order by " . $busca->busca_ordenar_por;
        $this->values = array($id_empresa, $id_empresa);

        $campo = " f.financeiro_valor as financeiro_custas, f.financeiro_sedex, f.financeiro_rateio, ROUND((f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio),2) as financeiro_valor,
					financeiro_valor_f, f.fantasia, f.servico, f.financeiro_autorizacao_data, f.id_financeiro, f.id_pedido, f.id_pedido_item, f.valor, f.ordem ";

        $this->sql = 'SELECT count(0) as total ' . $condicao1;
        $cont = $this->fetch();
        $this->total = $cont[0]->total;
        #$valor_t = $cont[0]->valor_t;
        #$valor_rec_t = $cont[0]->valor_rec_t;

        $this->sql = "SELECT " . $campo . " " . $condicao . " LIMIT " . $this->getInicio() . ", " . $this->maximo;
        $ret = $this->fetch();


        #$ret[0]->valor_t = $valor_t;
        #$ret[0]->valor_rec_t = $valor_rec_t;
        $_SESSION['pedido_campo'] = $campo;
        $_SESSION['pedido_condicao'] = $condicao;
        return $ret;
    }

    /**
     * rel desembolso
     **/
    public function relDesembolsoSint($id_empresa, $datai, $dataf)
    {
        $this->sql = "SELECT sum(f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio) as total,
                f.financeiro_agencia, f.financeiro_conta,f.financeiro_favorecido,f.financeiro_identificacao, 
                b.banco, u.nome, pi.id_pedido from
            vsites_financeiro as f, vsites_user_usuario as u, vsites_pedido_item as pi, vsites_banco as b where
            f.id_empresa_fin = '" . $id_empresa . "' and
            f.financeiro_autorizacao_data >= '" . $datai . "' and
            f.financeiro_autorizacao_data <= '" . $dataf . "' and                
            f.financeiro_tipo='Desembolso' and
            f.financeiro_autorizacao='Aprovado' and
            f.financeiro_forma='Dep?sito' and
            f.financeiro_conferido!='on' and            
            f.execucao=0 and
            f.financeiro_banco=b.id_banco and
            f.id_pedido_item=pi.id_pedido_item and
            f.id_usuario=u.id_usuario
            group by b.id_banco, f.financeiro_forma, f.financeiro_banco,  f.financeiro_favorecido, f.financeiro_conta, f.financeiro_data
            order by b.banco, f.financeiro_data, pi.id_pedido, pi.ordem";

        return $this->fetch();
    }

    /**
     * rel cadastro franquia
     **/
    public function relCadastroFranquia($c)
    {
        $this->values = array();

        if ($c->ddlStatus != "Todos") {
            $where = " WHERE usem.status = '$c->ddlStatus'";
        }

        $this->sql = "SELECT
usem.status,
CASE
	WHEN franquia_tipo = 1 THEN 'Master'
    WHEN franquia_tipo = 2 THEN 'Unitária'
    WHEN franquia_tipo = 3 THEN 'Subfranquia'
    WHEN franquia_tipo = 4 THEN 'Internacional'
    END as franquia_tipo,
fantasia,
empresa,
nome,
cpf,
tel,
cel,
email,
cep,
endereco,
bairro,
complemento,
cidade,
estado,
banc.banco,
agencia,
conta,
favorecido,
inauguracao_data,
validade_contrato,
inicio,
rofr.valor,
rofr.observacao
FROM
vsites_user_empresa usem
LEFT JOIN vsites_banco banc
ON usem.id_banco = banc.id_banco
LEFT JOIN vsites_royaltie_fixo_franquiado rofr
on usem.id_empresa = rofr.id_empresa" . $where . " ORDER BY fantasia, validade_contrato";

        //$this->values = array();
        return $this->fetch();
        // return $this->sql;

    }

    /**
     * rel royalties em aberto
     **/
    public function relRoyaltiesEmAberto($c)
    {
        $this->values = array();

        $where = " WHERE rofr.roy_rec = 0.0 AND rofr.valor_royalties > 0.0";
        if ($c->ddlStatus != "Todos") {
            $where .= " AND usem.status = '$c->ddlStatus'";
        }

        $this->sql = "SELECT
usem.id_empresa,
usem.status,
CASE
	WHEN franquia_tipo = 1 THEN 'Master'
    WHEN franquia_tipo = 2 THEN 'Unitária'
    WHEN franquia_tipo = 3 THEN 'Subfranquia'
    WHEN franquia_tipo = 4 THEN 'Internacional'
    END as franquia_tipo,
fantasia,
empresa,
nome,
cpf,
tel,
cel,
email,
cep,
endereco,
bairro,
complemento,
cidade,
estado,
validade_contrato,
rofr.valor_royalties,
rofr.data,
(SELECT observacao FROM vsites_royaltie_fixo_franquiado WHERE id_empresa = usem.id_empresa) as observacao
FROM
vsites_user_empresa usem
INNER JOIN vsites_rel_royalties rofr
on usem.id_empresa = rofr.id_empresa" . $where . "ORDER BY fantasia, YEAR(rofr.data), MONTH(rofr.data)";

        //$this->values = array();
        return $this->fetch();


    }

    /**
     * rel desembolso analitico
     **/
    public function relDesembolsoAnalitico($id_empresa, $datai, $dataf)
    {
        $this->sql = "SELECT (f.financeiro_valor+f.financeiro_sedex+f.financeiro_rateio) as total,
            f.financeiro_data, f.financeiro_descricao, f.financeiro_agencia, f.financeiro_conta,
            f.financeiro_favorecido, f.financeiro_identificacao, b.banco, u.nome, pi.id_pedido, pi.ordem from
            vsites_user_usuario as u, vsites_pedido_item as pi, vsites_financeiro as f, vsites_banco as b where
            f.id_empresa_fin = '" . $id_empresa . "' and
            f.financeiro_autorizacao_data >= '" . $datai . "' and
            f.financeiro_autorizacao_data <= '" . $dataf . "' and
            f.execucao=0 and
            f.financeiro_conferido!='on' and
            f.financeiro_tipo='Desembolso' and
            f.financeiro_autorizacao='Aprovado' and
            f.financeiro_forma='Dep?sito' and
            f.financeiro_banco=b.id_banco and
            f.id_pedido_item=pi.id_pedido_item and
            f.id_usuario=u.id_usuario
            order by b.banco, f.financeiro_data, pi.id_pedido, pi.ordem";
        return $this->fetch();

    }

    /**
     * rel desembolso
     **/
    public function relDesembolsoSintUpdate($id_empresa, $datai, $dataf)
    {
        $this->sql = "update vsites_financeiro as f
            set f.rel='1'	where
            f.id_empresa_fin = '" . $id_empresa . "' and
            f.financeiro_autorizacao_data >= '" . $datai . "' and
            f.financeiro_autorizacao_data <= '" . $dataf . "' and
            f.financeiro_tipo='Desembolso' and
            f.financeiro_autorizacao='Aprovado' and
            f.financeiro_forma='Dep?sito' and
            f.id_pedido_item=pi.id_pedido_item";

        return $this->exec();
    }

    /**
     * Atualiza Desembolso financeiro
     **/
    public function replaceFinanceiroFin()
    {
        $this->sql = "replace into vsites_pedido_fin(
	SELECT pi.id_pedido_item, pi.id_pedido, pi.ordem, (0) as financeiro_valor,(0) as financeiro_rateio,(0) as financeiro_sedex
	FROM vsites_pedido_item pi)";
        $this->values = array();
        $this->exec();

        $this->sql = "replace into vsites_pedido_fin(
	SELECT pi.id_pedido_item, pi.id_pedido, pi.ordem, SUM(f.financeiro_valor) as financeiro_valor,SUM(f.financeiro_rateio) as financeiro_rateio,SUM(f.financeiro_sedex) as financeiro_sedex
	FROM vsites_pedido_item pi
	INNER JOIN vsites_user_usuario u ON pi.id_usuario = u.id_usuario
	INNER JOIN vsites_financeiro as f ON f.id_pedido_item=pi.id_pedido_item 
	where
		f.id_empresa_fin=u.id_empresa and
		f.financeiro_autorizacao='Aprovado' and
		f.financeiro_tipo='Desembolso'
			group by pi.id_pedido_item)";
        $this->values = array();
        $this->exec();

        return true;
    }

    public function lista_royalties_aberto_emissao_boleto($busca, $id_empresa, $pagina)
    {
        $url_busca = $_SERVER['REQUEST_URI'];
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $url_busca), $url_busca_pos + 5);

        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        if ($id_empresa != 1) return '';
        $where = "";
        if ((int)($busca->mes) < 9 and $busca->mes > '') $busca->mes = '0' . (int)($busca->mes);
        if ($busca->ano <> '' and $busca->mes <> '') $where .= " and date_format(rr.data,'%Y-%m')='" . $busca->ano . "-" . $busca->mes . "'";
        if ($busca->ano <> '' and $busca->mes == '') $where .= " and date_format(rr.data,'%Y')='" . $busca->ano . "'";

        if ($busca->situacao == '') $where .= " AND rr.roy_rec = 0.0 AND rr.valor_royalties > 0.0";

        $this->sql = "SELECT COUNT(0) as total
					FROM vsites_user_empresa ue
					INNER JOIN vsites_rel_royalties as rr
					on rr.id_empresa=ue.id_empresa
					LEFT JOIN vsites_conta_fatura cofa
                    ON rr.id_rel_royalties = cofa.id_rel_royalties
					WHERE rr.id_empresa!=1 AND cofa.id_rel_royalties IS NULL " . $where . " ";
        $cont = $this->fetch();
        $this->total = $cont[0]->total;


        $this->sql = "SELECT rr.id_rel_royalties, date_format(rr.data,'%m/%Y') as ref, ue.id_empresa, ue.fantasia as fantasia, rr.valor_propaganda as fpp, valor_royalties as roy, rr.roy_rec, rr.fpp_rec
					FROM vsites_user_empresa ue
					INNER JOIN vsites_rel_royalties as rr
					on rr.id_empresa=ue.id_empresa
					LEFT JOIN vsites_conta_fatura cofa
                    ON rr.id_rel_royalties = cofa.id_rel_royalties
					WHERE rr.id_empresa!=1 AND cofa.id_rel_royalties IS NULL
					" . $where . " ORDER BY ue.fantasia, date_format(rr.data,'%m/%Y') LIMIT " . $this->getInicio() . ", " . $this->maximo;
        $ret = $this->fetch();

        return $ret;
    }

    /**
     * Lista os royalties gerados para a emissão do boleto que estão no cookie
     **/
    public function lista_royalties_emissao_boleto($im)
    {
        $this->sql = "SELECT * FROM vsites_rel_royalties RERO INNER JOIN vsites_user_empresa USEM ON RERO.id_empresa = USEM.id_empresa WHERE USEM.id_empresa != 1 AND RERO.id_rel_royalties IN (" . $im . ")";
        return $this->fetch();
    }

    public function exclui_royaltie_id($id)
    {
        $this->sql = "DELETE FROM vsites_rel_royalties WHERE id_rel_royalties = ?";
        $this->values = array($id);
        return $this->exec();
    }

    public function exclui_boleto_brasil($id)
    {
        $this->sql = "DELETE FROM vsites_conta_fatura_bco_brasil WHERE id_conta_fatura = (SELECT id_conta_fatura FROM vsites_conta_fatura WHERE id_rel_royalties = ?)";
        $this->values = array($id);
        $this->exec();

        $this->sql = "DELETE FROM vsites_conta_fatura WHERE id_rel_royalties = ?";
        $this->values = array($id);
        return $this->exec();
    }
}

?>
