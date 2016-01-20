<?php
class PessoaFisicaDAO extends PessoaDAO {

    public function __construct() {
        $this->table = "pessoafisica";
        parent::__construct();
    }

    /**
     * insere os dados de pessoaFisica
     *
     * @param PessoaFisica $pessoa
     * @return int
     */
    public function inserir(PessoaFisica $pessoa) {
        $this->beginTrans();
        try {
            $pessoa->id = parent::inserirPessoa($pessoa);
            $this->table="pessoafisica";

            $this->values = array();
            $this->values = $pessoa->getValores();
            $this->fields = array_keys($this->values);

            parent::insert();
        }
        catch(FormException $erro ){
            $this->rollBack();
            throw $erro;
        }catch(Exception $erro ){
            $this->rollBack();
            throw new FormException($erro->getMessage());
        }

        $this->commit();
        return $pessoa->id;
    }

    public function atualizar(PessoaFisica $pessoa) {
        $this->beginTrans();
        try {
            parent::atualizar($pessoa);
            $this->sql = "UPDATE pessoafisica SET nascimento = ?,
							sexo = ?, cpf = ?,idProfissao=? WHERE idPessoa = ?";
            $this->values = array(formatDBDate($pessoa->nascimento),$pessoa->sexo,$pessoa->cpf,$pessoa->idProfissao,$pessoa->id);
            //			$this->values = $pessoa->getValores();
            $this->exec();
        }
        catch(Exception $e ){
            $erro = new FormException($e->getMessage());
            throw $erro;
        }
        $this->commit();
    }
    public function selectById($id) {
        $this->values = array($id);
        $this->sql="SELECT p.*, pf.*,p.idempresa as idempresa,r.*
			FROM pessoa p
			INNER JOIN pessoafisica pf ON pf.idPessoa=p.id
			INNER JOIN relacao r ON r.idPessoa = p.id
			LEFT JOIN pessoa pe ON p.idempresa = pe.id
			WHERE p.id = ?";
        $pessoa = $this->fetch("PessoaFisica");
        return $pessoa[0];
    }

    public function buscaCliente($id) {
        $this->values=array($id);
        $this->sql="SELECT c.idPessoa id, p.usuario, pf.cpf FROM pessoafisica pf
						INNER JOIN relacao c ON pf.idPessoa=c.idPessoa
						INNER JOIN pessoa p ON p.id=c.idPessoa
						WHERE c.idPessoa=?
						AND c.cliente = 1";
        return $this->fetch("PessoaFisica");
    }

    public function valida(PessoaFisica $pessoa, $acao) {
        try {
            parent::valida($pessoa,$acao);
            $erros = new FormException();
        }catch(FormException $erros ){ }
        if($pessoa->cpf=="" && count($erros->getErrors())==0)return;
        elseif($pessoa->cpf!="") {
            $this->sql = "SELECT count(0) as num FROM pessoafisica WHERE cpf = ? ";
            $this->values=array($pessoa->cpf);
            $result = $this->fetch();
            if($result[0]->num>1)
                $erros->addError("CPF já foi utilizado.");
        }
        if(count($erros->getErrors())>0) {
            throw $erros;
        }
    }
}
?>