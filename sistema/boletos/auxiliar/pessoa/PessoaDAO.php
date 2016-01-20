<?php

require_once('../pessoa/PessoaFisicaDAO.php');
require_once('../pessoa/PessoaJuridicaDAO.php');
require_once('../pessoa/Telefone.class.php');
require_once('../pessoa/TelefoneDAO.php');
require_once('../pessoa/Endereco.class.php');
require_once('../pessoa/EnderecoDAO.php');


class PessoaDAO extends Database {

/**
 * insere os dados na tabela pessoa
 *
 * @param Pessoa $pessoa
 * @return int pessoa id
 */
    public function inserirPessoa(Pessoa $pessoa) {
        try {
            $this->table="pessoa";

            $this->valida($pessoa, "inserir");
            $this->values = $pessoa->getPessoaValores();

            $this->fields = array_keys($pessoa->getPessoaValores());
            $pessoa->id = parent::insert();

            $telefoneDAO = new TelefoneDAO();
            $telefoneDAO->inserirTelefones($pessoa->id,$pessoa->telefones);

            $enderecoDAO = new EnderecoDAO();
            $enderecoDAO->inserirEnderecos($pessoa->id,$pessoa->enderecos);

            $oficinaDAO = new OficinaDAO();
            $oficinaDAO->insertRelacao($pessoa);
        }
        catch(FormException $erro ) {
            throw $erro;
        }
        return $pessoa->id;
    }

    /**
     * atualiza a senha do 
     * @param Pessoa $p 
     */
    public function atualizarSenha(Pessoa $p){
        $this->sql = 'UPDATE pessoa SET senha = ? WHERE id=?';
        $this->values=array(md5($p->senha),$p->id);
        $this->exec();
    }

    /**
     * atualiza os dados no BD
     *
     * @param Pessoa $pessoa
     * @return int pessoa id
     */
    public function atualizar(Pessoa $pessoa) {
        try {
            self::valida($pessoa, "atualizar");
            $this->values = $pessoa->getPessoaValores();
            $this->fields = array_keys($pessoa->getPessoaValores());

            $this->sql = "UPDATE pessoa SET
					  nome = ?
					, email=? 
					, endereco=?
					, complemento=?
					, numero=?
					, cep=?
					, UF = ?
					, cidade = ?
					, bairro =?
					, idresiduo =?
					, limitecredito =?
					, inadimplente =?
					, idempresa =?
                                        , idcontato = ?
					WHERE id=?";
            $this->values = array();

            $this->values = array(
                $pessoa->nome
                ,$pessoa->email
                ,$pessoa->endereco
                ,$pessoa->complemento
                ,$pessoa->numero
                ,$pessoa->cep
                ,$pessoa->UF
                ,$pessoa->cidade
                ,$pessoa->bairro
                ,$pessoa->idresiduo
                ,$pessoa->limitecredito
                ,$pessoa->inadimplente
                ,$pessoa->idempresa
                ,$pessoa->idcontato
                ,$pessoa->id
            );

            parent::exec();

            $telefoneDAO = new TelefoneDAO();
            $telefoneDAO->atualizarTelefones($pessoa->id,$pessoa->telefones);
            $telefoneDAO->apagarTelefones($pessoa->id, explode(",",$_POST['removerTels']));

            $enderecoDAO = new EnderecoDAO();
            $enderecoDAO->atualizarEnderecos($pessoa->id,$pessoa->enderecos);

        }
        catch(Exception $e ) {
            $erro = new FormException();
            $erro->addError($e->getMessage());

            throw $erro;
        }
        return $pessoa->id;

    }

    public function atualizarRelacao($id,$idPessoa,$tipo){
        $this->sql = 'UPDATE pessoa SET id'.$tipo.' = ? WHERE id=?';
        $this->values=array($idPessoa,$id);
        $this->exec();
    }

    /**
     * Seleciona uma pessoa pelo id
     *
     * @param int $id
     * @return Pessoa
     */
    public function selectById($id) {
        $this->values = array($id);
        $this->sql="SELECT id,usuario,tipo FROM pessoa WHERE id = ?";
        return $this->selectOne();
    }

    /**
     * Seleciona uma pessoa pelo email
     *
     * @param String $email
     * @return Pessoa
     */
    public function selectPorEmail($email) {
        $this->values = array($email);
        $this->sql="SELECT id,usuario,tipo FROM pessoa WHERE email = ?";
        return $this->selectOne();
    }

    /**
     * Seleciona pessoa pelo usuario.
     *
     * @param String $usuario
     * @return Pessoa
     */
    public function selectUser($usuario) {
        $this->sql="SELECT id,tipo,email FROM pessoa WHERE usuario = ?";
        $this->values = array($usuario);
        return $this->selectOne();
    }

    private function selectOne(){
        $pessoaAux = $this->fetch();

        if(sizeof($pessoaAux) > 0) {
            $pessoaAux = $pessoaAux[0];
            $pessoa = $this->selectTipo($pessoaAux);

            $veiculoDAO = new VeiculoDAO();
            $veiculos = $veiculoDAO->listarProprieatario($pessoaAux->id);
            $pessoa->veiculos = $veiculos;

            $telefoneDAO = new TelefoneDAO();
            $telefones = $telefoneDAO->listaPorPessoa($pessoaAux->id);
            $pessoa->telefones = $telefones;

            $enderecoDAO = new EnderecoDAO();
            $pessoa->enderecos = $enderecoDAO->listaPorPessoa($pessoaAux->id);

            return $pessoa;
        }
        throw new FormException("Usuário não encontrado");
    }

    /**
     * seleciona os dados espec�ficos da pessoa (F ou J)
     *
     * @param Pessoa $pessoa
     * @return Pessoa
     */
    private function selectTipo($pessoa) {
        if($pessoa->tipo=="F")
            $pessoaDAO = new PessoaFisicaDAO();
        elseif($pessoa->tipo=="J")
            $pessoaDAO = new PessoaJuridicaDAO();
        return $pessoaDAO->selectById($pessoa->id);
    }

    /**
     * Valida os dados para inserir/atualizar uma pessoa.
     *(campo usuario)
     *
     * @param Pessoa $pessoa
     */
    public function valida(Pessoa $pessoa, $acao) {

        if($acao=="atualizar" || ($pessoa->usuario=='' && ($pessoa->contato || $pessoa->empresa))) return;

        $this->sql = "SELECT count(0) as num FROM pessoa WHERE usuario = ? ";
        $this->values=array($pessoa->usuario);
        $result = $this->fetch();

        if( $result[0]->num > 0 ) {
            throw new FormException("Escolha um nome de usuário diferente de ".$pessoa->usuario);
        }
    }


    /**
     * Busca o cadastro por usu�rio e senha.
     * seta tipo, se � cliente, fornecedor e funcion�rio
     *
     * @param String $usuario
     * @param String $senha
     * @return Pessoa
     */
    public function login($usuario, $senha) {
        $this->sql = "SELECT id, usuario, nome, tipo, cliente, fornecedor, funcionario, idOficina, oficina
						FROM pessoa
						INNER JOIN relacao r ON idPessoa = id
						INNER JOIN oficina o ON r.idOficina = o.idPessoa 
						WHERE usuario = ? AND senha = ?";
        $this->values=array($usuario, md5($senha));

//        if(trim($_GET["oficina"])!="") {
//            $this->sql.=" AND idOficina = ? ";
//            $this->values[]=$_SESSION["idOficina"];
//        }
        $pessoas = $this->fetch();

        if(sizeof($pessoas)==0)
            throw new FormException("Login incorreto!");

        $pessoa = $pessoas[0];
        if($pessoa->tipo=="F") $pessoa = new PessoaFisica();
        if($pessoa->tipo=="J") $pessoa = new PessoaJuridica();

        if($pessoas[0]->funcionario) $pessoa->tipoLogin = "funcionário";
        if($pessoas[0]->fornecedor) $pessoa->tipoLogin = "fornecedor";
        if($pessoas[0]->cliente) $pessoa->tipoLogin = "cliente";

        $pessoa->id = $pessoas[0]->id;
        $pessoa->usuario = $pessoas[0]->usuario;
        $pessoa->nome = $pessoas[0]->nome;
        $pessoa->tipo = $pessoas[0]->tipo;
        $pessoa->cliente = $pessoas[0]->cliente;
        $pessoa->fonecedor = $pessoas[0]->fornecedor;
        $pessoa->funcionario = $pessoas[0]->funcionario;
        $pessoa->oficina = $pessoas[0]->oficina;
        $pessoa->idOficina = $pessoas[0]->idOficina;

        return $pessoa;
    }

    /**
     * lista as pessoas que tem rela��o com a oficina
     *
     * @return Pessoa[]
     */
    public function listarPessoasOficina($tipo=null, $pagina = 0) {
        $pagina=($pagina==null)?0:$pagina;
        $this->sql = "SELECT
						nome, usuario, cliente, fornecedor, funcionario, email,id
						FROM pessoa p
						INNER JOIN relacao r ON r.idPessoa = p.id 
						LEFT JOIN pessoafisica pf ON pf.idPessoa = id
						LEFT JOIN pessoajuridica pj ON pj.idPessoa = id
						WHERE idOficina = ?" ;
        if($tipo!=null) {
            if($tipo=="funcionario")
                $this->sql.= " AND funcionario > 0";
            if($tipo=="cliente")
                $this->sql.= " AND cliente = 1";
            if($tipo=="fornecedor")
                $this->sql.= " AND fornecedor = 1";
        }
        $this->sql .= " ORDER BY nome ";
        $this->sql .=" LIMIT ".($pagina*10).", 10";

        $this->values=array($_SESSION["idOficina"]);
        return $this->fetch("Pessoa");
    }

    /**
     * pesquisa de pessoa, pelos atributos setados faz a busca e retorna um array
     *
     * @param Pessoa $pessoa
     * @return Pessoa[]
     */
    public function buscaPessoas(Pessoa $pessoa) {
        
        $this->sql =
            "SELECT * FROM pessoa p
			INNER JOIN relacao r ON r.idPessoa = p.id";
        if($pessoa->tipo=="J" || $pessoa instanceof PessoaJuridica) {
            $this->sql.=" INNER JOIN pessoajuridica pj ON pj.idPessoa = id ";
        }elseif($pessoa->tipo=="F" || $pessoa instanceof PessoaFisica) {
            $this->sql.=" INNER JOIN pessoafisica pf ON pf.idPessoa = id ";
        }
        $this->sql.=" WHERE r.idOficina = ? AND r.ativo=1";
        $this->values = array($_SESSION["idOficina"]);

        if($pessoa->email!="") {
            $this->sql.=" AND p.email LIKE ?";
            $this->values[]='%'.$pessoa->email.'%';
        }
        if($pessoa->nome!="") {
            $this->sql.=" AND p.nome LIKE ?";
            $this->values[]='%'.$pessoa->nome.'%';
        }if($pessoa->usuario!="") {
            $this->sql.=" AND p.usuario LIKE ?";
            $this->values[]='%'.$pessoa->usuario.'%';
        }if($pessoa->tipo!="") {
            $this->sql.=" AND p.tipo = ?";
            $this->values[]=$pessoa->tipo;
        }if($pessoa->cpf!=""){
            $this->sql.=" AND pf.cpf = ?";
            $this->values[]=$pessoa->cpf;
        }

        if($pessoa->cliente) {
            $this->sql.=" AND r.cliente = ? ";
            $this->values[]=1;
        }if($pessoa->funcionario) {
            $this->sql.=" AND r.funcionario = ? ";
            $this->values[]=1;
        }
        $this->sql.=" ORDER BY nome";
        return $this->fetch("Pessoa");
    }

    public function listarFornecedores($idOficina, $nome=''){
        $this->sql = 'SELECT p.* FROM pessoa p INNER JOIN relacao r ON r.idPessoa = p.id
        WHERE r.idOficina = ? and r.fornecedor=1';
        $this->values =array($idOficina);
        if($nome!=''){
            $this->sql.=' AND nome LIKE ?';
            $this->values[]='%'.$nome.'%';
        }

        return $this->fetch('Pessoa');
    }

}
?>
