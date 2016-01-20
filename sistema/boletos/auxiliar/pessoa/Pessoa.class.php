<?php
class Pessoa extends Entity {

    public $id;
    public $nome;
    public $tipo;//tipo: f�sica || juridica

//    protected $cliente;
//    protected $fornecedor;//fornecedor ?
//    protected $funcionario;//funcionario ?
    protected $email;
//    protected $usuario;
//    protected $senha;

    protected $site;
    protected $obs;
    protected $status;
    protected $ramo;
    
    protected $banco;
    protected $agencia;
    protected $conta;
    
    protected $descProduto;
    protected $creditoCompra;
    
    protected $idresiduo;
    protected $limitecredito;
    protected $ativo;
    protected $inadimplente;

    protected $telefones;
    protected $veiculos;
    protected $enderecos;

    public function __construct() {
        $this->telefones = array();
        $this->veiculos = array();
        $this->enderecos = array();
    }

    /**
     * get padr?o
     *
     * @param string $attribute
     * @return unknown
     */

    public function __get($atributo) {
        return $this->$atributo;
    }

    /**
     * set padr�o
     *
     * @param string $attribute
     * @param unknown_type $value
     */

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function addTelefone(Telefone $telefone) {
        $this->telefones[] = $telefone;
    }

    public function addEndereco($tipo, Endereco $endereco) {
        $this->enderecos[$tipo] = $endereco;
    }

    public function getEndereco($tipo) {
        return $this->enderecos[$tipo];
    }

    /**
     * retorna um array associativo com todos os dados
     *
     * @return Array
     */

    public function getPessoaValores($acao="inserir") {
        $valores = array();
        $valores["nome"]=$this->nome;

        if($acao=="inserir") {
            $valores["tipo"]=$this->tipo;
            $valores["usuario"]=$this->usuario;
            $valores["senha"]=$this->senha;
        }
        $valores["email"]=$this->email;
        $valores["telefone1"]=$this->telefone1;
        $valores["celular1"]=$this->celular1;
        $valores["idresiduo"] = $this->idresiduo;
        $valores["limitecredito"] = $this->limitecredito;

        $valores["inadimplente"] = $this->inadimplente;
        $valores["idEmpresa"] = $this->idEmpresa;

        if($acao=="atualizar") {
            $valores["id"]=$this->id;
        //$valores["ativo"] = $this->ativo;
        }
        return $valores;
    }

    public function codificaSenha() {
        $this->senha = md5($this->senha);
    }

    /**
     * valida��o para envio de dados, dos campos obrigat�rios
     * e valida��es como de tipo de dados (num�rico, data)
     * devem ser feitas aqui
     *
     * @param String $acao
     */

    public function valida($acao) {

        $errors = new FormException();
        if($this->nome=="") $errors->addError("O nome é obrigatório");
        if($this->tipo=="") $errors->addError("O tipo é obrigatório");
        if($acao=="insere") {
            if($this->senha=="") $errors->addError("Informe uma senha");
            if($this->senha!=$this->confSenha) $errors->addError("Confirme a senha");
        }

        //if($this->email=="") $errors->addError("O email ? obrigat?rio");
        if($acao == "insere")

            if($this->usuario=="" && (!$this->contato && !$this->empresa))
                $errors->addError("O usuário é obrigatório");
        if(!$this->cliente && !$this->fornecedor && !$this->funcionario && !$this->outros)
            $errors->addError("Informe se é cliente e/ou fornecedor");
        if(sizeof($this->telefones)>0)
            foreach($this->telefones as $i=>$telefone) {
                try {
                    $telefone->valida($i+1);
                }catch(FormException $telerrors ){
                    $errors->addError($telerrors->getErrors());
                }
            }

        if(sizeof($errors->getErrors())>0) throw $errors;
    }

    public function getRelacionamentos() {
        if($this->cliente) $str.=" CLI ";
        if($this->fornecedor) $str.=" FOR ";
        if($this->funcionario) $str.=" FUN ";
        if($this->outros) $str.=" OUT ";
        return trim($str);
    }



    public function getTipoLogin() {
        return $this->tipoLogin;
    }

    public function funcionarioAdm() {
        return ($this->funcionario==2);
    }

    public function getUsuario() {
        return ($this->usuario!="")?$this->usuario:$this->id;
    }

    /**

     * representa??o para string
     *
     * @return String
     */

    public function __toString() {
        return $this->nome."";
    }
}

?>