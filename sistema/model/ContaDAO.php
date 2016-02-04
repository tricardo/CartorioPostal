<?php

class ContaDAO extends Database
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'vsites_conta';
        $this->maximo = 50;
    }

    public function listar($id_empresa, $busca = "", $pagina = "")
    {
        $this->sql = "SELECT count(0) as total FROM vsites_conta co WHERE id_empresa=? AND co.status='Ativo'";
        $this->values = array($id_empresa);
        $cont = $this->fetch();
        $this->total = $cont[0]->total;

        $this->link = 'busca=' . $busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        $this->sql = "SELECT c.*, b.banco FROM vsites_conta c
					INNER JOIN vsites_banco b ON b.id_banco = c.id_banco 
					WHERE id_empresa=? AND c.status='Ativo'
					LIMIT " . $this->getInicio() . ", " . $this->maximo;
        $this->values = array($id_empresa);
        return $this->fetch();
    }

    public function verificaFatura($id_empresa, $id_fatura)
    {
        $this->sql = "SELECT count(0) as total FROM vsites_fin_fatura ff where id_fatura=? and id_empresa=? limit 1";
        $this->values = array($id_fatura, $id_empresa);
        $cont = $this->fetch();
        return $cont[0]->total;
    }

    public function verificaRetornoBrad($id_empresa, $banco, $retorno)
    {
        $this->sql = "SELECT count(0) as total FROM vsites_arquivo_brad_ret as br where id_empresa=? and banco=? and retorno=? limit 1";
        $this->values = array($id_empresa, $banco, $retorno);
        $cont = $this->fetch();
        return $cont[0];
    }

    public function listaBoletos($busca, $id_empresa, $pagina)
    {
        $url_busca = $_SERVER['REQUEST_URI'];
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $url_busca), $url_busca_pos + 5);
        $this->values = array();
        $this->link = $url_busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        if ($busca->busca_id_empresa <> '') {
            if ($busca->busca_id_empresa == '_')
                $onde .= " and cf.id_empresa_franquia!= 0 ";
            else
                if ($busca->busca_id_empresa == 'P')
                    $onde .= " and cf.id_empresa_franquia IS NULL ";
                else
                    $onde .= " and cf.id_empresa_franquia= '" . $busca->busca_id_empresa . "' ";
        }
        if ($busca->busca_id_fatura <> '') $onde .= " and cf.id_fatura= '" . $busca->busca_id_fatura . "' ";
        if ($busca->busca_id_conta_fatura <> '') $onde .= " and cf.id_conta_fatura= '" . $busca->busca_id_conta_fatura . "' ";
        if ($busca->busca <> '') $onde .= " and cf.sacado like '%" . $busca->busca . "%'";
        if ($busca->busca_vencimento_i <> '') $onde .= " and cf.vencimento >= '" . $busca->busca_vencimento_i . "'";
        if ($busca->busca_vencimento_f <> '') $onde .= " and cf.vencimento <= '" . $busca->busca_vencimento_f . "'";

        if ($busca->busca_id_ocorrencia <> '') {
            if ($busca->busca_id_ocorrencia == 1)
                $onde .= " and (cf.valor_pago>=cf.valor) and cf.id_ocorrencia NOT IN ('9','10')";
            if ($busca->busca_id_ocorrencia == 2)
                $onde .= " and (cf.valor_pago<cf.valor) and cf.id_ocorrencia NOT IN ('9','10')";
            if ($busca->busca_id_ocorrencia == 3)
                $onde .= " and (cf.id_ocorrencia IN ('3','24','27','30','32','35') and cf.valor>cf.valor_pago)";
            if ($busca->busca_id_ocorrencia == 4)
                $onde .= " and (cf.id_ocorrencia IN ('9','10'))";
        }

        $this->sql = "SELECT count(0) as total, SUM(valor) as valor_t, SUM(valor_pago) as valor_rec_t  FROM vsites_conta_fatura as cf WHERE cf.id_empresa=? " . $onde;
        $this->values = array($id_empresa);
        $cont = $this->fetch();
        $this->total = $cont[0]->total;

        $this->sql = "SELECT cf.*, replace(ue.fantasia,'Cartório Postal - ','') as fantasia FROM vsites_conta_fatura cf LEFT JOIN vsites_user_empresa as ue ON ue.id_empresa=cf.id_empresa_franquia
					WHERE cf.id_empresa=? " . $onde;
        $_SESSION['btto_sql'] = $this->sql;
        $_SESSION['btto_values'] = $this->values;

        $this->sql .= " LIMIT " . $this->getInicio() . ", " . $this->maximo;

        $ret = $this->fetch();
        $ret[0]->valor_t = $cont[0]->valor_t;
        $ret[0]->valor_rec_t = $cont[0]->valor_rec_t;

        return $ret;
    }

    public function listarConta($id_empresa)
    {
        $this->sql = "SELECT c.*, b.banco FROM vsites_conta c
					INNER JOIN vsites_banco b ON b.id_banco = c.id_banco 
					WHERE c.id_empresa=? AND c.status='Ativo'";
        $this->values = array($id_empresa);
        return $this->fetch();
    }

    public function listarContaBoleto($id_empresa)
    {
        $this->sql = "SELECT c.*, b.banco FROM vsites_conta c
					INNER JOIN vsites_banco b ON b.id_banco = c.id_banco 
					WHERE c.id_empresa=? AND c.status='Ativo' and c.carteira<>0";
        $this->values = array($id_empresa);
        return $this->fetch();
    }

    public function listaOcorrenciaBrad()
    {
        $this->sql = "SELECT * FROM vsites_conta_oco_brad c order by ocorrencia";
        $this->values = array();
        return $this->fetch();
    }

    public function selectPorId($id_conta, $id_empresa)
    {
        $this->sql = "SELECT c.*, b.banco, date_format(c.ultima,'%d-%m-%y') ultima FROM vsites_conta c
					INNER JOIN vsites_banco b ON b.id_banco = c.id_banco 
					WHERE id_conta=? and id_empresa=? 
					LIMIT 1";
        $this->values = array($id_conta, $id_empresa);
        echo $this->sql;
        $ret = $this->fetch();
        return $ret[0];
    }

    public function selectArquivoPorId($id_bradesco_rem, $id_empresa)
    {
        $this->sql = "SELECT * FROM vsites_arquivo_brad_rem ab
					WHERE id_bradesco_rem=? and id_empresa=? 
					LIMIT 1";
        $this->values = array($id_bradesco_rem, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    public function selectArquivoRetPorId($id_bradesco_ret, $id_empresa)
    {
        $this->sql = "SELECT * FROM vsites_arquivo_brad_ret ab
					WHERE id_bradesco_ret=? and id_empresa=? 
					LIMIT 1";
        $this->values = array($id_bradesco_ret, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    public function selectBoletosBrad($id_empresa, $id_conta)
    {
        $this->sql = "SELECT cf.*, date_format(cf.vencimento,'%d%m%y') vencimento, date_format(cf.emissao,'%d%m%y') emissao,  date_format(cf.data_desc,'%d%m%y') data_desc FROM vsites_conta_fatura cf
					WHERE status=0 and id_empresa=? and id_conta = ? ";
        $this->values = array($id_empresa, $id_conta);
        return $this->fetch();
    }

    /*
 * ADICIONADO POR THAUAN FRUCTUOZO RICARDO
 * DATA: 10/12/2015
 * DESCRIÇÃO: SELECIONA OS BOLETOS DO BANCO DO BRASIL
 * */
    public function selectBoletosBrasil($id_empresa, $id_conta)
    {
        $this->sql = "SELECT cf.*, date_format(cf.vencimento,'%d%m%y') vencimento, date_format(cf.emissao,'%d%m%y') emissao,  date_format(cf.data_desc,'%d%m%y') data_desc FROM vsites_conta_fatura cf
					WHERE status=0 and id_empresa=? and id_conta = ? ";
        $this->values = array($id_empresa, $id_conta);
        return $this->fetch();
    }

    public function selectBoletosBradOco($id_empresa, $id_conta)
    {
        $this->sql = "SELECT cf.*, cfo.id_conta_fatura_oco, (CASE WHEN cfo.vencimento!='0000-00-00' THEN date_format(cfo.vencimento,'%d%m%y') ELSE date_format(cf.vencimento,'%d%m%y') END) as vencimento, date_format(cf.emissao,'%d%m%y') emissao,  date_format(cf.data_desc,'%d%m%y') data_desc,
				cfo.ocorrencia, cfo.valor as valor_o, cfo.juros_mora as juros_mora_o, cfo.instrucao1 as instrucao1_o, cfo.instrucao2 as instrucao2_o, cfo.cpf as cpf_o, cfo.sacado as sacado_o, cfo.endereco as endereco_o, cfo.mensagem1 as mensagem1_o, cfo.cep as cep_o, cfo.mensagem2 as mensagem2_o, cfo.tipo as tipo_o 
				FROM vsites_conta_fatura_oco cfo, vsites_conta_fatura as cf 
					WHERE cfo.status=0 and cfo.id_empresa=? and cf.id_conta = ? and cfo.id_conta_fatura=cf.id_conta_fatura";
        $this->values = array($id_empresa, $id_conta);
        return $this->fetch();
    }

    public function selectBoletosBradPorId($id_conta_fatura, $id_empresa)
    {
        $this->sql = "SELECT
cf.*,
ce.sigla,
ci.conta_instru,
c.favorecido,
c.agencia,
c.conta,
c.carteira
FROM vsites_conta_fatura cf
LEFT JOIN vsites_conta_instru ci
ON cf.instrucao1=ci.id_conta_instru
LEFT JOIN vsites_conta_especie ce
on ce.id_conta_especie=cf.especie, vsites_conta as c
WHERE cf.id_conta_fatura=? and cf.id_empresa=? and cf.id_conta=c.id_conta";
        $this->values = array($id_conta_fatura, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    public function selectBoletosBrasilPorId($id_conta_fatura, $id_empresa)
    {
        $this->sql = "SELECT
cf.*,
ce.sigla,
ci.conta_instru,
c.favorecido,
c.agencia,
c.conta,
c.carteira,
cfbb.*
FROM vsites_conta_fatura cf
INNER JOIN vsites_conta_fatura_bco_brasil cfbb
ON cf.id_conta_fatura = cfbb.id_conta_fatura
LEFT JOIN vsites_conta_instru ci
ON cf.instrucao1=ci.id_conta_instru
LEFT JOIN vsites_conta_especie ce
on ce.id_conta_especie=cf.especie, vsites_conta as c
WHERE cf.id_conta_fatura=? and cf.id_empresa=? and cf.id_conta=c.id_conta";
        $this->values = array($id_conta_fatura, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    public function selectBoletosBradRoy($id_relatorio, $id_empresa_franquia)
    {
        $this->values = array($id_relatorio);
        if ($id_empresa_franquia != 1) {
            $this->values[] = $id_empresa_franquia;
            $where = ' and cf.id_empresa_franquia=?';
        }
        $this->sql = "SELECT cf.id_conta_fatura FROM vsites_conta_fatura cf LEFT JOIN vsites_conta_instru ci ON cf.instrucao1=ci.id_conta_instru LEFT JOIN vsites_conta_especie ce on ce.id_conta_especie=cf.especie, vsites_conta as c
					WHERE cf.id_relatorio=? " . $where . " and cf.id_conta=c.id_conta limit 1";
        $ret = $this->fetch();
        return $ret[0];
    }

    public function selectBoletosBradFat($id_fatura, $id_empresa)
    {
        $this->values = array($id_empresa);
        $this->values[] = $id_fatura;

        $this->sql = "SELECT cf.id_conta_fatura FROM vsites_conta_fatura cf LEFT JOIN vsites_conta_instru ci ON cf.instrucao1=ci.id_conta_instru LEFT JOIN vsites_conta_especie ce on ce.id_conta_especie=cf.especie, vsites_conta as c
					WHERE cf.id_empresa=?  and cf.id_fatura=? and cf.id_conta=c.id_conta";
        return $this->fetch();
    }

    public function selectContaPorId($id_banco, $id_empresa)
    {
        $this->sql = "SELECT c.* FROM vsites_conta c
					WHERE id_banco=? and id_empresa=? ";
        $this->values = array($id_banco, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    public function inserir($conta)
    {
        $this->fields = array("agencia", "conta", "status", "id_empresa", "id_banco", "sigla");
        $this->values = array("agencia" => $conta->agencia, "conta" => $conta->conta, "status" => $conta->status, "id_empresa" => $conta->id_empresa, "id_banco" => $conta->id_banco, "sigla" => $conta->sigla);
        return $this->insert();
    }

    public function atualizar($conta)
    {
        $this->sql = "UPDATE vsites_conta SET agencia=?, conta=?, status=?, id_banco=?, sigla=? WHERE id_conta = ? ";
        $this->values = array($conta->agencia, $conta->conta, $conta->status, $conta->id_banco, $conta->sigla, $conta->id_conta);
        return $this->exec();
    }

    public function atualizaBoletosBrad($id_empresa, $id_conta_fatura)
    {
        $this->sql = "UPDATE vsites_conta_fatura SET status=1 WHERE id_conta_fatura = ? and id_empresa=? and status=0";
        $this->values = array($id_conta_fatura, $id_empresa);
        return $this->update();
    }

    public function atualizaBoletosBradOco($id_empresa, $id_conta_fatura_oco)
    {
        $this->sql = "UPDATE vsites_conta_fatura_oco SET status=1 WHERE id_conta_fatura_oco = ? and id_empresa=? and status=0";
        $this->values = array($id_conta_fatura_oco, $id_empresa);
        return $this->update();
    }

    public function atualizarBradesco($id_conta, $id_empresa, $versao, $remessa, $arquivo)
    {
        $this->sql = "update vsites_conta set versao=?, remessa=?, ultima=NOW() where id_conta=? and id_empresa=?";
        $this->values = array($versao, $remessa, $id_conta, $id_empresa);
        $this->update();

        $this->table = 'vsites_arquivo_brad_rem';
        $this->fields = array("id_empresa", "arquivo");
        $this->values = array("id_empresa" => $id_empresa, "arquivo" => $arquivo);
        return $this->insert();
    }

    public function inserirBradescoRet($id_empresa, $arquivo, $banco, $retorno)
    {
        $this->table = 'vsites_arquivo_brad_ret';
        $this->fields = array("id_empresa", "arquivo", "banco", "retorno");
        $this->values = array("id_empresa" => $id_empresa, "arquivo" => $arquivo, "banco" => $banco, "retorno" => $retorno);
        return $this->insert();
    }

    public function inserirBoletoBrad($p, $id_empresa, $id_usuario)
    {
        $this->table = 'vsites_conta_fatura';
        $this->fields = array('id_nota', 'id_relatorio', 'id_empresa_franquia', 'id_fatura', 'id_conta', 'ocorrencia', 'tipo', 'cpf', 'sacado', 'endereco', 'bairro', 'cidade', 'estado', 'cep', 'vencimento', 'valor', 'juros_mora', 'instrucao1', 'instrucao2', 'mensagem1', 'mensagem2', 'emissao_papeleta', 'especie', 'aceite', 'id_empresa', 'id_usuario', 'id_rel_royalties');
        $this->values = array("id_nota" => $p->id_nota, "id_relatorio" => $p->id_relatorio, "id_empresa_franquia" => $p->id_empresa_franquia, "id_fatura" => $p->id_fatura, "id_conta" => $p->id_conta, "ocorrencia" => $p->ocorrencia, "tipo" => $p->tipo, "cpf" => $p->cpf, "sacado" => $p->sacado, "endereco" => $p->endereco, "bairro" => $p->bairro, "cidade" => $p->cidade, "estado" => $p->estado, "cep" => $p->cep, "vencimento" => $p->vencimento, "valor" => $p->valor, "juros_mora" => $p->juros_mora, "instrucao1" => $p->instrucao1, "instrucao2" => $p->instrucao2, "mensagem1" => $p->mensagem1, "mensagem2" => $p->mensagem2, "emissao_papeleta" => $p->emissao_papeleta, "especie" => $p->especie, "aceite" => $p->aceite, "id_empresa" => $id_empresa, "id_usuario" => $id_usuario, "id_rel_royalties" => $p->id_rel_royalties);
        return $this->insert();
    }

    public function atualizaBoletoBrad($p, $id_conta_fatura, $id_empresa)
    {
        $this->sql = "update vsites_conta_fatura set id_nota=?, tipo=?, cpf=?, sacado=?, endereco=?,bairro=?,cidade=?,estado=?, cep=?, vencimento=?, valor=?, juros_mora=?, instrucao1=?, instrucao2=?, mensagem1=?, mensagem2=?, emissao_papeleta=?, especie=?, aceite=? where id_conta_fatura=? and id_empresa=?";
        $this->values = array($p->id_nota, $p->tipo, $p->cpf, $p->sacado, $p->endereco, $p->bairro, $p->cidade, $p->estado, $p->cep, $p->vencimento, $p->valor, $p->juros_mora, $p->instrucao1, $p->instrucao2, $p->mensagem1, $p->mensagem2, $p->emissao_papeleta, $p->especie, $p->aceite, $id_conta_fatura, $id_empresa);
        return $this->update();
    }

    public function deletaBoletoBrad($id_conta_fatura, $id_empresa)
    {
        $this->sql = "delete from vsites_conta_fatura where id_conta_fatura=? and id_empresa=? and status='0'";
        $this->values = array($id_conta_fatura, $id_empresa);
        return $this->delete();
    }

    public function inserirBoletoBradOco6($p, $id_conta_fatura, $id_empresa, $id_usuario)
    {
        $this->sql = 'UPDATE vsites_conta_fatura SET vencimento=? WHERE id_conta_fatura=?';
        $this->values = array($p->vencimento, $id_conta_fatura);
        $this->exec();
        $this->table = 'vsites_conta_fatura_oco';
        $this->fields = array('ocorrencia', 'vencimento', 'id_conta_fatura', 'id_empresa', 'id_usuario');
        $this->values = array("ocorrencia" => $p->ocorrencia, "vencimento" => $p->vencimento, "id_conta_fatura" => $id_conta_fatura, "id_empresa" => $id_empresa, "id_usuario" => $id_usuario);
        return $this->insert();
    }

    public function inserirBoletoBradOco31($p, $id_conta_fatura, $id_empresa, $id_usuario)
    {
        $this->sql = 'UPDATE vsites_conta_fatura SET cpf=?,sacado=?,endereco=?,bairro=?,cidade=?,estado=?,cep=?,valor=?,juros_mora=?,instrucao1=?,instrucao2=?,mensagem1=?,mensagem2=?
		 WHERE id_conta_fatura=?';
        $this->values = array($p->cpf, $p->sacado, $p->endereco, $p->bairro, $p->cidade, $p->estado, $p->cep, $p->valor, $p->juros_mora, $p->instrucao1, $p->instrucao2, $p->mensagem1, $p->mensagem2, $id_conta_fatura);
        $this->exec();
        $this->table = 'vsites_conta_fatura_oco';
        $this->fields = array('ocorrencia', 'tipo', 'cpf', 'sacado', 'endereco', 'bairro', 'cidade', 'estado', 'cep', 'valor', 'juros_mora', 'instrucao1', 'instrucao2', 'mensagem1', 'mensagem2', 'id_empresa', 'id_usuario', 'id_conta_fatura');
        $this->values = array("ocorrencia" => $p->ocorrencia, "tipo" => $p->tipo, "cpf" => $p->cpf, "sacado" => $p->sacado, "endereco" => $p->endereco, "bairro" => $p->bairro, "cidade" => $p->cidade, "estado" => $p->estado, "cep" => $p->cep, "valor" => $p->valor, "juros_mora" => $p->juros_mora, "instrucao1" => $p->instrucao1, "instrucao2" => $p->instrucao2, "mensagem1" => $p->mensagem1, "mensagem2" => $p->mensagem2, "id_empresa" => $id_empresa, "id_usuario" => $id_usuario, "id_conta_fatura" => $id_conta_fatura);
        return $this->insert();
    }

    public function inserirBoletoBradOco100($ocorrencia, $id_conta_fatura, $id_empresa, $id_usuario)
    {
        if (($ocorrencia) == 100) {
            $this->sql = "UPDATE vsites_conta_fatura SET id_ocorrencia=100, valor_pago=valor WHERE id_conta_fatura = ? and id_empresa=? ";
        } else {
            $this->sql = "UPDATE vsites_conta_fatura SET id_ocorrencia=101, valor_pago='' WHERE id_conta_fatura = ? and id_empresa=? ";
        }
        $this->values = array($id_conta_fatura, $id_empresa);
        $this->exec();

        $this->table = 'vsites_conta_fatura_oco';
        $this->fields = array('ocorrencia', 'id_conta_fatura', 'id_empresa', 'id_usuario', 'status');
        $this->values = array("ocorrencia" => $ocorrencia, "id_conta_fatura" => $id_conta_fatura, "id_empresa" => $id_empresa, "id_usuario" => $id_usuario, "status" => 1);
        return $this->insert();
    }

    public function inserirBoletoBradOco($ocorrencia, $id_conta_fatura, $id_empresa, $id_usuario)
    {
        $this->table = 'vsites_conta_fatura_oco';
        $this->fields = array('ocorrencia', 'id_empresa', 'id_usuario', 'id_conta_fatura');
        $this->values = array("ocorrencia" => $ocorrencia, "id_empresa" => $id_empresa, "id_usuario" => $id_usuario, "id_conta_fatura" => $id_conta_fatura);
        return $this->insert();
    }

    public function listaBoletoBrad($id, $id_empresa)
    {
        $this->sql = "SELECT
f.*,
fb.id_conta_fatura_bco_brasil,
fb.tipo_multa,
fb.valor_multa,
fb.data_multa,
fb.tipo_juros,
fb.pgto_parcial,
fb.dias_protesto,
fb.campo_livre,
fb.cpnj_sacador,
fb.nome_sacador,
fb.mensagem3,
fb.numero_beneficiario,
DATE_FORMAT(f.vencimento,'%d/%m/%Y') AS vencimento
FROM vsites_conta_fatura AS f
LEFT JOIN vsites_conta_fatura_bco_brasil fb
ON f.id_conta_fatura = fb.id_conta_fatura where f.id_conta_fatura=? and f.id_empresa=? limit 1";
        $this->values = array($id, $id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }

    public function listaBoletoBradOco($id, $id_empresa)
    {
        $this->sql = "SELECT f.*, date_format(f.vencimento,'%d/%m/%Y') as vencimento, date_format(f.data_oco,'%d/%m/%Y') as data_oco, co.ocorrencia as conta_oco from vsites_conta_fatura_oco as f, vsites_conta_oco_brad as co where f.id_conta_fatura=? and f.id_empresa=? and f.ocorrencia=co.id_ocorrencia";
        $this->values = array($id, $id_empresa);
        return $this->fetch();
    }

    public function listaBoletoBradOcoRet($id, $id_empresa)
    {
        $this->sql = "SELECT fr.*, date_format(fr.vencimento,'%d/%m/%Y') as vencimento, date_format(fr.data_ocorrencia,'%d/%m/%Y') as data_oco, co.conta_oco from vsites_conta_fatura_ret as fr, vsites_conta_oco as co where fr.id_conta_fatura=? and fr.id_empresa=? and fr.ocorrencia=co.id_conta_oco order by fr.id_conta_fatura_ret desc";
        $this->values = array($id, $id_empresa);
        return $this->fetch();
    }

    public function inserirOcorrenciaBrad($r, $id_empresa, $id_usuario)
    {
        $res = $this->listaBoletoBrad($r->id_conta_fatura, $id_empresa);
        echo $r->ocorrencia . '-' . $r->id_conta_fatura . '-aaa<br>';

        if ($res->valor_pago == 0) {
            if ($res->id_ocorrencia != '6' and $res->id_ocorrencia != '9' and $res->id_ocorrencia != '10' and $res->id_ocorrencia != '100') {
                $this->sql = "UPDATE vsites_conta_fatura SET id_ocorrencia=?, valor_pago=valor_pago+'" . $r->valor_pago . "', cron=0 WHERE id_conta_fatura = ? and id_empresa=? ";
                $this->values = array($r->ocorrencia, $r->id_conta_fatura, $id_empresa);
                $this->exec();
            }
        } else {
            $this->sql = "UPDATE vsites_conta_fatura SET id_ocorrencia=? WHERE id_conta_fatura = ? and id_empresa=? ";
            $this->values = array($r->ocorrencia, $r->id_conta_fatura, $id_empresa);
            $this->exec();
        }

        $this->table = 'vsites_conta_fatura_ret';
        $this->fields = array("id_conta_fatura", "id_empresa", "id_usuario", "tipo",
            "inscricao_emp", "ocorrencia", "data_ocorrencia", "vencimento",
            "valor", "banco_cobrador", "agencia_cobradora", "especie",
            "despesa_cobranca", "outras_despesas", "juros_atraso", "iof",
            "valor_pago", "juros_mora", "motivo_protesto", "motivo_ocorrencia1",
            "motivo_ocorrencia2", "motivo_ocorrencia3", "motivo_ocorrencia5", "sequencia");
        $this->values = array("id_conta_fatura" => $r->id_conta_fatura, "id_empresa" => $id_empresa, "id_usuario" => $id_usuario, "tipo" => $r->tipo,
            "inscricao_emp" => $r->inscricao_emp, "ocorrencia" => $r->ocorrencia, "data_ocorrencia" => $r->data_ocorrencia, "vencimento" => $r->vencimento,
            "valor" => $r->valor, "banco_cobrador" => $r->banco_cobrador, "agencia_cobradora" => $r->agencia_cobradora, "especie" => $r->especie,
            "despesa_cobranca" => $r->despesa_cobranca, "outras_despesas" => $r->outras_despesas, "juros_atraso" => $r->juros_atraso, "iof" => $r->iof,
            "valor_pago" => $r->valor_pago, "juros_mora" => $r->juros_mora, "motivo_protesto" => $r->motivo_protesto, "motivo_ocorrencia1" => $r->motivo_ocorrencia1,
            "motivo_ocorrencia2" => $r->motivo_ocorrencia2, "motivo_ocorrencia3" => $r->motivo_ocorrencia3, "motivo_ocorrencia5" => $r->motivo_ocorrencia5, "sequencia" => $r->sequencia);

        return $this->insert();
    }

    public function execSession($sessao)
    {
        $this->sql = $_SESSION[$sessao . '_sql'] . ' limit 3000';
        $this->values = $_SESSION[$sessao . '_values'];
        return $this->fetch();
    }

    public function inserirBoletoBrasil($p, $id_empresa, $id_usuario)
    {
        $this->table = 'vsites_conta_fatura';
        $this->fields = array('id_nota', 'id_relatorio', 'id_empresa_franquia', 'id_fatura', 'id_conta', 'ocorrencia', 'tipo', 'cpf', 'sacado', 'endereco', 'bairro', 'cidade', 'estado', 'cep', 'vencimento', 'valor', 'juros_mora', 'instrucao1', 'instrucao2', 'mensagem1', 'mensagem2', 'emissao_papeleta', 'especie', 'aceite', 'id_empresa', 'id_usuario', 'id_rel_royalties');
        $this->values = array("id_nota" => $p->id_nota, "id_relatorio" => $p->id_relatorio, "id_empresa_franquia" => $p->id_empresa_franquia, "id_fatura" => $p->id_fatura, "id_conta" => $p->id_conta, "ocorrencia" => $p->ocorrencia, "tipo" => $p->tipo, "cpf" => $p->cpf, "sacado" => $p->sacado, "endereco" => $p->endereco, "bairro" => $p->bairro, "cidade" => $p->cidade, "estado" => $p->estado, "cep" => $p->cep, "vencimento" => $p->vencimento, "valor" => $p->valor, "juros_mora" => $p->juros_mora, "instrucao1" => $p->instrucao1, "instrucao2" => $p->instrucao2, "mensagem1" => $p->mensagem1, "mensagem2" => $p->mensagem2, "emissao_papeleta" => $p->emissao_papeleta, "especie" => $p->especie, "aceite" => $p->aceite, "id_empresa" => $id_empresa, "id_usuario" => $id_usuario, "id_rel_royalties" => $p->id_rel_royalties);
        $idRetorno = $this->insert();

        $this->table = 'vsites_conta_fatura_bco_brasil';
        $this->fields = array('id_conta_fatura', 'tipo_multa', 'valor_multa', 'data_multa', 'tipo_juros', 'pgto_parcial', 'dias_protesto', 'campo_livre', 'cpnj_sacador', 'nome_sacador', 'mensagem3', 'numero_beneficiario');
        $this->values = array("id_conta_fatura" => $idRetorno, "tipo_multa" => $p->tipo_multa, "valor_multa" => $p->valor_multa, "data_multa" => $p->data_multa, "tipo_juros" => $p->tipo_juros, "pgto_parcial" => $p->pgto_parcial, "dias_protesto" => $p->dias_protesto, "campo_livre" => $p->campo_livre, "cpnj_sacador" => $p->cpnj_sacador, "nome_sacador" => $p->nome_sacador, "mensagem3" => $p->mensagem3, "numero_beneficiario" => $p->txtNumeroBeneficiario);
        return $this->insert();
    }

    public function atualizaBoletoBrasil($p, $id_conta_fatura, $id_empresa)
    {
        $this->sql = "update vsites_conta_fatura set id_nota=?, tipo=?, cpf=?, sacado=?, endereco=?,bairro=?,cidade=?,estado=?, cep=?, vencimento=?, valor=?, juros_mora=?, instrucao1=?, instrucao2=?, mensagem1=?, mensagem2=?, emissao_papeleta=?, especie=?, aceite=? where id_conta_fatura=? and id_empresa=?";
        $this->values = array($p->id_nota, $p->tipo, $p->cpf, $p->sacado, $p->endereco, $p->bairro, $p->cidade, $p->estado, $p->cep, $p->vencimento, $p->valor, $p->juros_mora, $p->instrucao1, $p->instrucao2, $p->mensagem1, $p->mensagem2, $p->emissao_papeleta, $p->especie, $p->aceite, $id_conta_fatura, $id_empresa);
        $this->update();

        $this->sql = "update vsites_conta_fatura_bco_brasil set tipo_multa=?, valor_multa=?, data_multa=?, tipo_juros=?, pgto_parcial=?,dias_protesto=?,campo_livre=?,cpnj_sacador=?, nome_sacador=?, mensagem3=?, numero_beneficiario=? where id_conta_fatura=?";
        $this->values = array($p->tipo_multa, $p->valor_multa, $p->data_multa, $p->tipo_juros, $p->pgto_parcial, $p->dias_protesto, $p->campo_livre, $p->cpnj_sacador, $p->nome_sacador, $p->mensagem3, $p->txtNumeroBeneficiario, $id_conta_fatura);
        return $this->update();
    }

}

?>