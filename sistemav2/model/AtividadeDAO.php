<?php
class AtividadeDAO extends Database {

    public function __construct() {
        parent::__construct();
        $this->table = 'vsites_pedido_status';
    }

    /**
     * insere atividade no pedido_item
     * @param int $id_atividade
     * @param string $status_obs
     * @param int $id_usuario
     * @param int $id_pedido_item
     */
    public function inserir($id_atividade = '172', $status_obs = '', $id_usuario, $id_pedido_item, $status_dias=null) {
        $data_i = date('Y-m-d H:i:s');
        $this->table = 'vsites_pedido_status';
        $this->fields = array('id_atividade', 'status_obs', 'data_i', 'id_usuario', 'id_pedido_item');
        $this->values = array('id_atividade' => $id_atividade, 'status_obs' => $status_obs,
            'data_i' => $data_i, 'id_usuario' => $id_usuario,
            'id_pedido_item' => $id_pedido_item);
        if ($status_dias != null) {
            $this->fields[] = 'status_dias';
            $this->values['status_dias'] = $status_dias;
        }
        $this->insert();
    }

    public function direcionaFranquia($id_empresa_resp, $id_usuario, $id_pedido_item, $id_usuario_op, $resp_nome) {
        $this->sql = "update vsites_pedido_item set data_i=NOW(), id_atividade='206', id_status='19', id_usuario_op='', 
           id_usuario_op2=?, id_empresa_resp=? where id_pedido_item=?";
        $this->values = array($id_usuario_op, $id_empresa_resp, $id_pedido_item);
        $this->exec();

        $this->inserir(191, "Atribuído para " . $resp_nome, $id_usuario, $id_pedido_item, '');
    }
	
	public function direcionaFranquia2($id_empresa_resp, $id_usuario, $id_pedido_item, $id_usuario_op, $resp_nome, $obs) {
        $this->sql = "update vsites_pedido_item set data_i=NOW(), id_atividade='206', id_status='19', id_usuario_op='', 
           id_usuario_op2=?, id_empresa_resp=? where id_pedido_item=?";
        $this->values = array($id_usuario_op, $id_empresa_resp, $id_pedido_item);
        $this->exec();

        $this->inserir(191, $obs."Atribuído para " . $resp_nome, $id_usuario, $id_pedido_item, '');
    }

    /**
     * insere atividade no pedido_item
     * @param int $id_atividade
     * @param string $s
     * @param int $id_usuario
     * @param int $id_pedido_item
     */
    public function inserirAtividade($id_atividade = '172', $s, $id_usuario, $id_pedido_item) {
        global $controle_id_empresa, $controle_id_usuario;
        $where = '';
        #verifica se a forma de pagamento é deposito e se não é do correio para enviar ao operacional ou ao financeiro
        $this->sql = "SELECT (CASE WHEN(pi.valor_rec = 0) THEN ('0') ELSE ('1') END) as recebido,
							p.origem, p.forma_pagamento, 
							pi.data_prazo, pi.id_pedido, pi.certidao_nome, pi.certidao_devedor, pi.id_servico, p.cpf, p.id_pacote,pi.id_status, 
							pi.data_atividade, pi.dias, pi.id_usuario_op, pi.encerramento, pi.atendimento, pi.inicio, pi.operacional,
							pi.certidao_cidade, pi.certidao_estado, pi.id_empresa_atend
							from vsites_pedido_item as pi, vsites_pedido as p where pi.id_pedido_item=? and pi.id_pedido=p.id_pedido limit 1";

        $this->values = array($id_pedido_item);
        
        $res = $this->fetch();
		if($controle_id_usuario == 1 OR $controle_id_usuario == 3720){
				#print_r($res);	
				#echo $id_atividade;
				#exit;
		}
        if (($res[0]->recebido == '0' or $res[0]->recebido == '') and ($id_atividade == '137' or $id_atividade == '198') and $res[0]->origem != 'Correios' and $res[0]->forma_pagamento == 'Depósito') {
            $id_atividade = '153';
        }

        #verifica se vai criar data da agenda
        $data_agenda = date('Y-m-d');
        if (($s->status_dias <> '' and $s->status_dias != '0' or $s->status_hora <> '') and ($id_atividade != "110" && $id_atividade != "217")) {
            if ($s->status_dias == '')
                $s->status_dias = '0';
            $data_agenda = somar_dias_uteis($data_agenda, $s->status_dias);
            $where .= ",data_i='" . $data_agenda . "' ,status_hora='" . $s->status_hora . ":00'";
        } else {
            if ($s->status_dias == '0' and $id_atividade != "110" and $id_atividade != "217") {
                $where .= ",data_i=NOW(), status_hora='" . $s->status_hora . ":00'";
            } else {
                if ($id_atividade != "110" && $id_atividade != "217") {
                    $where .= ",data_i='', status_hora='" . $s->status_hora . ":00'";
                }
            }
        }

        #seleciona o status da nova atividade e verifica se tem que voltar para o status anterior
        $ativ = $this->selecionaPorID($id_atividade);
        if ($ativ->id_status == 99) {
            $this->sql = "SELECT a.id_status from vsites_pedido_status as s, vsites_atividades as a where s.id_pedido_item=? and a.id_atividade=s.id_atividade and a.id_status!='0' and a.id_status!='99' and a.id_status!='15' and a.id_status!='12' and a.id_status!='18' and a.id_status!='17' order by s.id_pedido_status DESC LIMIT 1";
            $this->values = array($id_pedido_item);
            $res_ant = $this->fetch();
            $id_status = $res_ant[0]->id_status;
        } else {
            $id_status = $ativ->id_status;
        }

        #se estiver no pendente precisa somar os dias que ficaram parado
        if (($res[0]->id_status == '12' or $res[0]->id_status == '15') and $res[0]->inicio != '0000-00-00 00:00:00') {
            $dias_add = dias_uteis(invert($res[0]->data_atividade, '/', 'PHP'), date('d/m/Y'));
            $prazo_dias = $res[0]->dias + $dias_add;
            $data_prazo = somar_dias_uteis($res[0]->inicio, $prazo_dias);
            $where .= ", dias='" . $prazo_dias . "', data_prazo='" . $data_prazo . "'";
        }

        #se for liberado para a franquia marca o dia da liberação para franquia

        if ($id_atividade == '205') {
                $where .= ", data_status=NOW()";
        }
        
        #se for para cadastrado começa a contar o prazo
        if (($id_atividade == '137' or $id_atividade == '198' or $id_atividade == '180') and ($res[0]->inicio == '0000-00-00 00:00:00')) {
            #verifica CDT
            $pedidoDAO = new PedidoDAO();
            $id_empresa_dir = $pedidoDAO->listaCDT($res[0]->certidao_cidade, $res[0]->certidao_estado, $res[0]->id_pedido, $controle_id_empresa);
            if ($id_empresa_dir <> '') {
                $where .= ", id_empresa_dir='" . $id_empresa_dir . "'";
            }

            $where .= ", inicio=NOW()";
            #se for atividade Conferido aguardar 24 horas soma 1 dia no prazo
            if ($id_atividade == '198' and $res[0]->inicio == '0000-00-00 00:00:00') {
                $res[0]->dias++;
                $data_prazo = somar_dias_uteis(date('Y-m-d'), $res[0]->dias);
                $where .= ", dias='" . $res[0]->dias . "', data_prazo='" . $data_prazo . "'";
            } else {
                $data_prazo = somar_dias_uteis(date('Y-m-d'), $res[0]->dias);
                $where .= ", data_prazo='" . $data_prazo . "'";
            }
        }

        #se atividade = conciliação ou cadastrado, inicia o atendimento
        if (($ativ->id_status == '2' or $ativ->id_status == '3' or $id_atividade == '153') and $res[0]->atendimento == '0000-00-00 00:00:00') {
            $where .= ", atendimento=NOW()";
        }

        #verifica se foi concluído operacional
        if (($id_atividade == '203') and ($res[0]->operacional == '0000-00-00' or $res[0]->operacional == '')) {
            $where .= ", operacional=NOW()";
        }

        #verifica se foi concluído
        if ($id_atividade == '119' and ($res[0]->encerramento == '0000-00-00 00:00:00' or $res[0]->encerramento == '')) {
            $where .= ", encerramento=NOW()";
        }

        #verifica se o pedido já foi direcionado caso não tenha sido direciona para o proprio usuário
        if ($id_atividade == '145' and $res[0]->id_usuario_op == '0') {
            $where .= ", id_usuario_op=" . $id_usuario;
        }

        #se o pedido de imóveis e detran estiverem liberados libera para faturamento
        if (($ativ->id_status == '8' or $ativ->id_status == '10') and ($res[0]->id_servico == '170' or $res[0]->id_servico == '11' or $res[0]->id_servico == '16' or $res[0]->id_servico == '64' or $res[0]->id_servico == '169' or $res[0]->id_servico == '156' or $res[0]->id_servico == '117') and $res[0]->id_pacote == '1') {
            if ($res[0]->id_servico == '169' or $res[0]->id_servico == '156' or $res[0]->id_servico == '117') {
                #se o pedido de imóveis e detran estiverem liberados libera para faturamento
                $this->sql = "update vsites_pedido_item as pi set pi.pacote_lib = '1' where pi.id_pedido_item=?";
                $this->values = array($id_pedido_item);
                $this->exec();
            } else {
                //verifica se todos os pedidos foram liberados para faturamento
                $this->sql = "SELECT COUNT(0) as total from vsites_pedido_item as pi, vsites_pedido as p where 
                    pi.id_empresa_atend=? and
                    pi.id_status!='14' and pi.id_status!='8' and pi.id_status!='10' and 
                    (pi.id_servico='170' or pi.id_servico='11' or pi.id_servico='16' or pi.id_servico='64') and 
                    (pi.certidao_devedor = ? and pi.certidao_devedor <> '' or 
                    pi.certidao_nome = ? and pi.certidao_nome <> '' and pi.certidao_devedor='') and 
                    pi.id_pedido_item!=? and
                    pi.id_pedido=p.id_pedido and 
                    p.id_pacote='1' and p.cpf=?";
                $this->values = array($res[0]->id_empresa_atend, $res[0]->certidao_devedor, $res[0]->certidao_nome, $id_pedido_item, $res[0]->cpf);
                $num_pacote = $this->fetch();
                if ($num_pacote[0]->total == 0) {
                    //seleciona todos os pedidos que foram liberados para faturamento dentro do pacote
                    $this->sql = "SELECT pi.id_pedido_item, pi.id_pedido, pi.ordem from vsites_pedido_item as pi, vsites_pedido as p where 
                        pi.id_empresa_atend=? and
                        (pi.id_servico='170' or pi.id_servico='11' or pi.id_servico='16' or pi.id_servico='64') and 
                        pi.id_status!='14' and
                        (pi.certidao_devedor =? and pi.certidao_devedor <> '' or 
                        pi.certidao_nome = ? and pi.certidao_nome <> '' and pi.certidao_devedor='') and 
                        pi.id_pedido=p.id_pedido and
                        p.id_pacote='1' and p.cpf=?";
                    $this->values = array($res[0]->id_empresa_atend, $res[0]->certidao_devedor, $res[0]->certidao_nome, $res[0]->cpf);
                    $num_pacote = $this->fetch();
                    foreach ($num_pacote as $l) {
                        $this->sql = "update vsites_pedido_item as pi set pi.pacote_lib = '1' where pi.id_pedido_item=?";
                        $this->values = array($l->id_pedido_item);
                        $this->exec();
                    }
                }
            }
        }


        if (($id_status == '8' or $id_status == '10') and $res[0]->id_pacote == '2') {
            #se o pacote empresarial estao liberados entao libera para faturamento
            $this->sql = "SELECT COUNT(0)as total from vsites_pedido_item as pi where pi.id_pedido=? and pi.id_status!='14' and pi.id_status!='8' and pi.id_status!='10' and pi.id_pedido_item!=?";
            $this->values = array($res[0]->id_pedido, $id_pedido_item);
            $num_pacote = $this->fetch();
            if ($num_pacote[0]->total == 0) {
                $this->sql = "update vsites_pedido_item  set pacote_lib = '1' where id_pedido=? and id_status!='14'";
                $this->values = array($res[0]->id_pedido);
                $this->exec();
            }
        }


        if ($id_atividade != 110 && $id_atividade != 217) {
            #se status = 0 nao muda o status, nem data da atividade
            if($controle_id_usuario == 1 OR $controle_id_usuario == 3720){
				#print_r($this);	
				#echo $id_atividade;
				#exit;
			}
            if ($id_status == '' or $id_status == '0') {
                if ($id_atividade == 212) {
                    $where .= ", atraso=NOW() ";
                }
                $this->sql = "update vsites_pedido_item set id_atividade='" . $id_atividade . "' " . $where . " where id_pedido_item=?";
                $this->values = array($id_pedido_item);
                $this->exec();
            } else {
                if ($id_atividade == 155 and $res[0]->id_status == 6 or $id_atividade != 155) {
                    if ($id_atividade == 115) {
                        $where .= ", des=1 ";
                    }
                    $this->sql = "update vsites_pedido_item set data_atividade=NOW(), id_status=?, id_atividade=?,status_hora=? " . $where . " where id_pedido_item=?";
                    $this->values = array($id_status, $id_atividade, $s->status_hora . ':00', $id_pedido_item);
                    $this->exec();
                }
            }
        }

        $data_i = date('Y-m-d H:i:s');
        $this->fields = array('id_atividade', 'status_obs', 'data_i', 'id_usuario',
            'id_pedido_item', 'status_dias', 'status_hora');
        $this->values = array('id_atividade' => $id_atividade, 'status_obs' => $s->status_obs, 'data_i' => $data_i, 'id_usuario' => $id_usuario,
            'id_pedido_item' => $id_pedido_item, 'status_dias' => $s->status_dias, 'status_hora' => $s->status_hora);
        $this->insert();
        return 1;
    }

    /**
     * lista atividades do departamento BD
     * @param string $atividade com where da session
     */
    public function listaAtividades($atividade='1=1') {
        $this->sql = "SELECT * from vsites_atividades as a where status='Ativo' and atisis=0 and (" . $atividade . ") order by atividade";
        $this->values = array();
        return $this->fetch();
    }

    /**
     * lista atividades do departamento BD
     * @param string $atividade com where da session
     */
    public function listaAtividadesTodas() {
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'AtividadeDAO-listaAtividadesTodas.csv';
        $verifica = $cachediaCLASS->VerificaCache($filename);

        if ($verifica == false) {
            $this->sql = "SELECT id_atividade,id_status,atividade from vsites_atividades as a where status!='Cancelado' order by atividade";
            $this->values = array();
            $ret = $this->fetch();
            $campos = "id_atividade;id_status;atividade";
            $geracsv = $cachediaCLASS->ConvertArrayToCsv($filename, $ret, $campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;
    }

    /**
     * lista atividades do pedido_item BD
     * @param Int $id_pedido_item
     */
    public function listaAtividadesPedido($id_pedido_item) {
        $this->sql = "SELECT DATE_ADD( ps.data_i , INTERVAL CASE WHEN ps.status_dias=0 THEN 0 ELSE
   CASE WHEN DAYOFWEEK( DATE_ADD( ps.data_i , INTERVAL ( CEILING((ps.status_dias-(6-DAYOFWEEK(ps.data_i)))/7)*2+ps.status_dias ) DAY ))=7 or DAYOFWEEK( DATE_ADD( ps.data_i , INTERVAL ( CEILING((ps.status_dias-(6-DAYOFWEEK(ps.data_i)))/7)*2+ps.status_dias ) DAY ))=1 THEN
    (( CEILING((ps.status_dias-(6-DAYOFWEEK(ps.data_i)))/7)*2+ps.status_dias+2 )) ELSE (( CEILING((ps.status_dias-(6-DAYOFWEEK(ps.data_i)))/7)*2+ps.status_dias )) END
END DAY ) as data_agenda,
      ps.*, a.atividade, u.nome  from vsites_pedido_status as ps, vsites_user_usuario as u, vsites_atividades as a where
			ps.id_pedido_item=? and 
			ps.id_atividade=a.id_atividade and
			u.id_usuario =  ps.id_usuario
			order by ps.id_pedido_status desc";
        $this->values = array($id_pedido_item);
        return $this->fetch();
    }

    /**
     * lista atividades do pedido_item BD
     * @param Int $id_pedido_item
     */
    public function listaAtividadesPedidoLog($id_pedido_item) {
        $this->sql = "SELECT DATE_ADD( ps.data_i , INTERVAL CASE WHEN ps.status_dias=0 THEN 0 ELSE
   CASE WHEN DAYOFWEEK( DATE_ADD( ps.data_i , INTERVAL ( CEILING((ps.status_dias-(6-DAYOFWEEK(ps.data_i)))/7)*2+ps.status_dias ) DAY ))=7 or DAYOFWEEK( DATE_ADD( ps.data_i , INTERVAL ( CEILING((ps.status_dias-(6-DAYOFWEEK(ps.data_i)))/7)*2+ps.status_dias ) DAY ))=1 THEN
    (( CEILING((ps.status_dias-(6-DAYOFWEEK(ps.data_i)))/7)*2+ps.status_dias+2 )) ELSE (( CEILING((ps.status_dias-(6-DAYOFWEEK(ps.data_i)))/7)*2+ps.status_dias )) END
END DAY ) as data_agenda,
      ps.*, a.atividade, u.nome  from vsites_pedido_status_bkp as ps, vsites_user_usuario as u, vsites_atividades as a where
			ps.id_pedido_item=? and 
			ps.id_atividade=a.id_atividade and
			u.id_usuario =  ps.id_usuario
			order by ps.id_pedido_status desc";
        $this->values = array($id_pedido_item);
        return $this->fetch();
    }

    /**
     * lista atividade no BD
     * @param Int $id_atividade
     */
    public function selecionaPorID($id_atividade) {
        $this->sql = "SELECT * from vsites_atividades as a where id_atividade=?";
        $this->values = array($id_atividade);
        $ret = $this->fetch();
        return $ret[0];
    }

}

?>
