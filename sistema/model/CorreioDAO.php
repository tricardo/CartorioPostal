<?php

class CorreioDAO extends Database {

    public function __construct() {
        parent::__construct();
        $this->table = 'vsites_agcorreios';
        $this->maximo = 50;
    }

    public function selectPorId($id, $id_empresa) {
        $this->sql = "SELECT * FROM vsites_agcorreios ac WHERE id_agcorreios=? ";
        $this->values[] = $id;
        if($id_empresa!=1){
            $this->sql .= " and id_empresa=?";
            $this->values[] = $id_empresa;
        }
        $this->sql .= " limit 1";
        $ret=$this->fetch();
        return $ret[0];
    }

    public function listarTipoFicha() {
        $this->sql = "SELECT * FROM vsites_fichas_correios order by fichacorreio";
        return $this->fetch();
    }

    public function listarFicha($id_empresa) {
        $this->sql = "SELECT ec.*, fc.fichacorreio FROM vsites_emp_correios as ec, vsites_fichas_correios as fc where ec.id_empresa=? and ec.id_fichacorreio=fc.id_fichacorreio order by data DESC";
        $this->values[] = $id_empresa;
        return $this->fetch();
    }
    
    public function listar($id_empresa, $busca, $pagina="") {
        $this->sql = "SELECT count(0) as total FROM vsites_agcorreios ac WHERE 1=1 ";
        if ($id_empresa <> '') {
            $where .= " and ac.id_empresa=? ";
            $this->values[] = $id_empresa;
        }
        if ($busca <> '') {
            $where .= " and (ac.agencia=? or ac.nome like ?)";
            $this->values[] = '%' . $busca . '%';
            $this->values[] = '%' . $busca . '%';
        }
        $this->sql .= $where;
        $cont = $this->fetch();
        $this->total = $cont[0]->total;


        $this->link = 'busca=' . $busca;
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        $this->sql = "SELECT ac.*, replace(ue.fantasia,'Cartório Postal - ','') as fantasia FROM vsites_agcorreios ac, vsites_user_empresa as ue
					WHERE 1=1 " . $where . " and ac.id_empresa=ue.id_empresa
					LIMIT " . $this->getInicio() . ", " . $this->maximo;

        return $this->fetch();
    }

    public function inserir($con) {
        $this->fields = array("nome", "status", "id_empresa", "data_cartaz","endereco","bairro","cidade","estado","cep","tel","fax");
        $this->values = array("nome" => $con->nome, "status" => $con->status, "id_empresa" => $con->id_empresa, "data_cartaz" => $con->data_cartaz, "endereco" => $con->endereco, "bairro" => $con->bairro, "cidade" => $con->cidade, "estado" => $con->estado, "cep" => $con->cep, "tel" => $con->tel, "fax" => $con->fax);
        return $this->insert();
    }

    public function inserirFichaCorreio($id_empresa,$id_usuario,$id_fichacorreio,$quantidade) {
        $data = DATE('Y-m-d');
        $this->table = 'vsites_emp_correios';
        $this->fields = array("id_empresa", "id_usuario", "id_fichacorreio", "quantidade","data");
        $this->values = array("id_empresa" => $id_empresa, "id_usuario" => $id_usuario, "id_fichacorreio" => $id_fichacorreio, "quantidade" => $quantidade, "data" => $data);
        return $this->insert();
    }
    
    public function atualizar($con,$id) {
        $this->sql = "UPDATE vsites_agcorreios SET nome=?, status=?, data_cartaz=?, id_empresa=?, endereco=?, bairro=?, cidade=?, estado=?, cep=?, tel=?, fax=? WHERE id_agcorreios = ? ";
        $this->values = array($con->nome, $con->status, $con->data_cartaz, $con->id_empresa, $con->endereco, $con->bairro, $con->cidade, $con->estado, $con->cep, $con->tel, $con->fax, $id);
        return $this->exec();
    }

}

?>