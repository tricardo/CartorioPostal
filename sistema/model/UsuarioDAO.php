<?php

class UsuarioDAO extends Database
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'vsites_user_usuario';
        $this->maximo = 50;
    }

    /**
     * retorna a lista de todos os usuários
     */
    public function listar()
    {
        $this->sql = "SELECT * FROM vsites_user_usuario ORDER BY nome";
        $this->values = array();
        return $this->fetch();
    }

    /**
     * retorna a lista de todos os usuários do atendimento exceto os cancelados
     */
    public function listarAtendentes($id_empresa)
    {
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'ServicoDAO-listarAtendentes' . $id_empresa . '.csv';
        $verifica = $cachediaCLASS->VerificaCache($filename);

        if ($verifica == false) {
            $this->sql = "SELECT id_usuario,nome from vsites_user_usuario as uu where id_empresa=? and status!='Cancelado' and 6 IN (departamento_p) order by nome";
            $this->values = array($id_empresa);
            $ret = $this->fetch();
            $campos = "id_usuario;nome";
            $geracsv = $cachediaCLASS->ConvertArrayToCsv($filename, $ret, $campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;
    }

    /**
     * retorna a lista de todos os usuários do operacional
     */
    public function listarOp($id_empresa)
    {
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'ServicoDAO-listarOp' . $id_empresa . '.csv';
        $verifica = $cachediaCLASS->VerificaCache($filename);

        if ($verifica == false) {
            $this->sql = "SELECT id_usuario, nome from vsites_user_usuario as uu where id_empresa=? and status!='Cancelado' order by nome";
            $this->values = array($id_empresa);
            $ret = $this->fetch();
            $campos = "id_usuario;nome";
            $geracsv = $cachediaCLASS->ConvertArrayToCsv($filename, $ret, $campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;
    }

    /**
     * retorna a lista de todos os usuários ativos
     */
    public function listarAtivos($id_empresa = null)
    {
        $this->sql = "SELECT * FROM vsites_user_usuario as uu WHERE status='Ativo' ";
        $this->values = array();
        if ($id_empresa != null) {
            $this->sql .= " AND id_empresa=? ";
            $this->values = array($id_empresa);
        }
        $this->sql .= " ORDER BY nome";
        return $this->fetch();
    }

    /**
     * retorna a lista de todos os usuários ativos
     */
    public function listarAtivosDpto($id_empresa = null, $dpto = null)
    {
        $this->sql = "SELECT * FROM vsites_user_usuario as uu WHERE status='Ativo'";
        $this->values = array();
        if ($id_empresa != null) {
            $this->sql .= " AND id_empresa=? ";
            $this->values = array($id_empresa);
        }
        if ($dpto != null) {
            $this->sql .= " AND departamento_p like ? ";
            $this->values[] = "%$dpto%";
        }
        $this->sql .= " ORDER BY nome";

        return $this->fetch();
    }

    public function busca($id_empresa = '', $busca = '', $pagina = 1, $id_departamento = '', $lista_monitoramento = false)
    {
        $this->values = array();

        $where = " WHERE ue.id_empresa=uu.id_empresa AND uu.id_usuario !='1' ";
        if ($id_empresa <> '') {
            $where .= " AND uu.id_empresa=? ";
            $this->values[] = $id_empresa;
        }

        if ($id_departamento <> '') {
            $where .= " AND ( uu.departamento_p LIKE ? OR uu.departamento_p LIKE ? ";
            $where .= " OR uu.departamento_s LIKE ? OR uu.departamento_s LIKE ? )";
            $this->values[] = '%,' . $id_departamento . ',%';
            $this->values[] = $id_departamento . ',%';
            $this->values[] = '%,' . $id_departamento . ',%';
            $this->values[] = $id_departamento . ',%';
        }
        if ($busca <> '') {
            $where .= " AND (uu.nome like ? or uu.email like ?) ";
            $this->values[] = $busca . '%';
            $this->values[] = $busca . '%';
        }
        if (!$lista_monitoramento) {
            $where .= " AND uu.nome <> 'Monitoramento'";
        }
        $this->sql = "SELECT count(0) as total FROM vsites_user_usuario as uu, vsites_user_empresa as ue " . $where;

        $where .= " ORDER BY uu.nome ASC";
        $cont = $this->fetch();
        $this->total = $cont[0]->total;

        $this->link = 'busca=' . $busca . '&id_empresa=' . $id_empresa;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        $this->sql = "SELECT uu.nome,uu.email, uu.id_usuario, ue.fantasia, uu.status
			 	FROM vsites_user_usuario as uu, vsites_user_empresa as ue 
				" . $where . " LIMIT " . $this->getInicio() . ", " . $this->maximo;
        return $this->fetch();
    }

    /**
     * insere um funcionário no BD
     * @param Usuario $u
     */
    public function inserir($u)
    {
        $this->fields = array('senha', 'nome', 'cel', 'tel', 'email',
            'endereco', 'bairro', 'cidade', 'estado',
            'cep', 'data', 'cpf', 'rg',
            'id_empresa', 'tipo', 'complemento', 'numero',
            'ramal', 'status');
        $this->values = array('senha' => $this->codificaSenha($u->email, $u->senha), 'nome' => $u->nome, 'cel' => $u->cel, 'tel' => $u->tel, 'email' => $u->email,
            'endereco' => $u->endereco, 'bairro' => $u->bairro, 'cidade' => $u->cidade, 'estado' => $u->estado,
            'cep' => $u->cep, 'data' => date("Y-m-d"), 'cpf' => $u->cpf, 'rg' => $u->rg,
            'id_empresa' => $u->id_empresa, 'tipo' => $u->tipo, 'complemento' => $u->complemento, 'numero' => $u->numero,
            'ramal' => $u->ramal, 'status' => $u->status);
        return $this->insert();
    }

    /**
     * atualizar um usuário no BD pelo email
     * @param Usuario $u
     */
    public function atualizar($u)
    {
        $this->sql = "update vsites_user_usuario set
					nome=?, cel=?, tel=?, 
					ramal=?, endereco=?, cidade=?, 
					estado=?, bairro=?, cep=?,
					rg=?,complemento=?, numero=?,
					status=?,cpf=? 
					where id_usuario=?";
        $this->values = array($u->nome, $u->cel, $u->tel,
            $u->ramal, $u->endereco, $u->cidade,
            $u->estado, $u->bairro, $u->cep,
            $u->rg, $u->complemento, $u->numero,
            $u->status, $u->cpf,
            $u->id_usuario);
        $this->exec();
    }

    /**
     * busca um usuário pelo email
     * @param String $email
     */
    public function selectPorEmail($email)
    {
        $this->sql = "SELECT vsites_user_usuario.*, vsites_user_empresa.empresa
						FROM vsites_user_usuario, vsites_user_empresa WHERE vsites_user_usuario.email=? and vsites_user_usuario.id_empresa = vsites_user_empresa.id_empresa";
        $this->values = array($email);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * busca um usuário pelo ir
     * @param int $id
     */
    public function selectPorId($id)
    {
        $this->sql = "SELECT u.*,e.fantasia, e.status as statusEmp FROM vsites_user_usuario u
			INNER JOIN vsites_user_empresa e ON e.id_empresa=u.id_empresa
			WHERE id_usuario=?";
        $this->values = array($id);
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * verifica a senha do usuário
     *
     * @param unknown_type $email
     * @param unknown_type $senha
     * @return boolean
     */
    public function verificaSenha($email, $senha)
    {
        $this->sql = "SELECT * from vsites_user_usuario where email=? and senha=?";
        $this->values = array($email, $this->codificaSenha($email, $senha));
        return (count($this->fetch()) > 0);
    }

    public function login_monitoramento($email, $id_usuario)
    {
        if ($id_usuario != 1) $where .= " and uu.id_empresa!=1 "; else $where = "";
        if ($id_usuario == 356 or $id_usuario == 35) $where .= " and uu.email='gua@cartoriopostal.com.br' ";
        $this->sql = "SELECT uu.id_usuario, uu.email, ue.franquia, uu.departamento_p, uu.senha FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE uu.email = ? " . $where . " and uu.status='Ativo' and uu.senha<>'' and uu.email<>'' and ue.id_empresa=uu.id_empresa limit 1";
        $this->values = array($email);
        $ret = $this->fetch();

        if (count($ret) > 0) {
            return $ret[0];
        } else {
            throw new Exception('Usuário não encontrado');
        }
    }

    public function verifica_logado($login, $senha)
    {
        $this->sql = "SELECT uu.*, ue.id_pais FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE uu.email = ? and uu.senha=? and uu.status='Ativo' and uu.id_empresa=ue.id_empresa limit 1";
        $this->values = array($login, $senha);
        $ret = $this->fetch();

        if (count($ret) > 0) {
            return $ret[0];
        } else {
            throw new Exception('Usuário não encontrado');
        }
    }

    public function login($email, $senha, $ip)
    {
        if (is_numeric($email) == 1 and $senha <> '') {
            $this->sql = "SELECT p.nome, p.id_pedido FROM vsites_pedido as p WHERE p.id_pedido = ? AND md5(concat(p.id_pedido,p.data)) like ? limit 1";
            $this->values = array($email, $senha . '%');
            $ret = $this->fetch();
            return $ret[0];
        } else {

            #$this->sql = "SELECT uu.*, ue.franquia, ue.status as statusEmp FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE uu.email = ? AND uu.senha = ? and uu.status='Ativo' and uu.senha<>'' and uu.email<>'' and ue.status='Ativo' and ue.id_empresa=uu.id_empresa and (ue.ip IS NULL or ue.ip like ?) limit 1";
            #$this->values = array($email,$senha,"%".$ip."%");
            #$ret = $this->fetch();

            $this->sql = "SELECT uu.*, ue.franquia, ue.status as statusEmp FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE uu.email = ? AND uu.senha = ? and uu.status='Ativo' and uu.senha<>'' and uu.email<>'' and ue.status='Ativo' and ue.id_empresa=uu.id_empresa  ";
            $this->values = array($email, $senha);
            if ($email != 'admin') {
                #$this->sql .= ' and (ue.ip IS NULL or ue.ip like ?) ';
                #$this->values[] = "%".$ip."%";
            }
            $this->sql .= " limit 1";
            $ret = $this->fetch();

            if (count($ret) > 0) {
                $this->sql = "insert into vsites_log_acesso set data_login=NOW(), id_usuario = ?, ip=?";
                $this->values = array($ret[0]->id_usuario, $ip);
                $this->exec();
                $ret[0]->controle_tabela = 'vsites_user_usuario';
                $ret[0]->controle_id = 'id_usuario';
                return $ret[0];
            } else {
                $this->sql = 'SELECT email FROM vsites_user_conveniado as uc WHERE email = ? AND senha = ? and status = "Ativo"';
                $this->values = array($email, $senha);
                $ret = $this->fetch();

                if (count($ret) > 0) {
                    $ret[0]->conveniado_tabela = 'vsites_user_conveniado';
                    $ret[0]->conveniado_id = 'id_conveniado';
                    return $ret[0];
                } else {
                    throw new Exception('Usuário não encontrado');
                }
            }
        }
    }

    public function loginExterno($email, $senha, $ip)
    {
        $this->sql = "SELECT uu.*, ue.id_empresa, ue.empresa, ue.franquia, ue.status as statusEmp FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE uu.email = ? AND uu.senha = ? and uu.status='Ativo' and uu.senha<>'' and uu.email<>'' and (ue.status='Ativo' or ue.status='Inativo') and ue.id_empresa=uu.id_empresa and (ue.ip IS NULL or ue.ip like ?) limit 1";
        $this->values = array($email, $senha, "%" . $ip . "%");
        $ret = $this->fetch();
        return $ret[0];
    }

    /**
     * atualiza a senha do usuário
     * @param unknown_type $email
     * @param unknown_type $senha
     */
    public function atualizaSenha($email, $senha)
    {
        $this->sql = "update vsites_user_usuario set senha=? where email=?";
        $this->values = array($this->codificaSenha($email, $senha), $email);
        $this->exec();
    }

    public function codificaSenha($email, $senha)
    {
        return md5($email . $senha);
    }

    /**
     * lista os usuários de um departamento e uma empresa
     * @param int $id_empresa
     * @param int $id_departamento
     */
    public function listarPorDepartamentoEmpresa($id_empresa, $departamento = null, $sup = false)
    {
        $this->sql = "SELECT id_usuario, nome ,email
					FROM vsites_user_usuario as uu 
					WHERE 
					(id_empresa = ? ) AND (";
        $this->values = array($id_empresa);

        $departamento = (is_array($departamento)) ? $departamento : array($departamento);

        foreach ($departamento as $i => $id_departamento) {
            if ($i > 0) $this->sql .= ' OR ';
            if ($sup) {
                $this->sql .= " ( uu.departamento_s LIKE ? OR uu.departamento_s LIKE ? )";
                $this->values[] = '%,' . $id_departamento . ',%';
                $this->values[] = $id_departamento . ',%';
            } else {
                $this->sql .= " ( uu.departamento_p LIKE ? OR uu.departamento_p LIKE ? )";
                $this->values[] = '%,' . $id_departamento . ',%';
                $this->values[] = $id_departamento . ',%';
            }
        }

        $this->sql .= ")";
        $this->sql .= " ORDER BY nome";
        return $this->fetch();
    }

    public function todos()
    {
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'UsuarioDAO-todosUsuarios' . date('Ymd') . '.csv';
        $verifica = $cachediaCLASS->VerificaCache($filename);

        if ($verifica == false) {
            $this->sql = "SELECT u.id_usuario, u.email FROM vsites_user_usuario AS u ORDER BY u.id_usuario";
            $ret = $this->fetch();
            $campos = "id_usuario;email";
            $geracsv = $cachediaCLASS->ConvertArrayToCsv($filename, $ret, $campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        $nomes = array();
        for ($i = 0; $i < count($ret); $i++) {
            if (strlen($ret[$i]->email) > 0) {
                $nomes[$ret[$i]->id_usuario] = $ret[$i]->email;
            }
        }
        return $nomes;
    }

    /*
     * Funçao que verifica o primeiro usuário logado e realiza uma atualização do status ativo para renovação dos usuários que não acessam mais que 60 dias.
     * */
    public function atualiza_status_para_renovacao()
    {
        $this->sql = "SELECT count(id_log) FROM vsites_log_acesso WHERE DATE_FORMAT(data_login,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')";
        $ret = $this->fetch();

        if($ret == 0){

        }
    }
}

?>
