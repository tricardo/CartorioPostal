<?php
class PessoaFisica extends Pessoa {
    public $cpf;
    protected $nascimento;
    protected $sexo;

    public function getCPF() {
        return $this->cpf;
    }

    public function getNascimento() {
        return $this->nascimento;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setCPF($cpf) {
        $this->cpf = $cpf;
    }

    public function setNascimento($nascimento) {
        $this->nascimento = $nascimento;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function getValores() {

        $valores = array();
        $valores["idPessoa"]= $this->id;
        $valores["cpf"]= $this->cpf;
        $valores["sexo"]= $this->sexo;
        $valores["nascimento"]=($this->nascimento!="")?formatDBDate($this->nascimento):"0000-00-00";
        $valores["idProfissao"]=$this->idProfissao;

        return $valores;
    }


    public function getFormatNascimento() {
        return formataData($this->nascimento);
    }

    public function getDBFormatNascimento() {
        return formatDBDate($this->nascimento);
    }

    public function valida($acao) {
        try {
            parent::valida($acao);
            $errors = new FormException();
        }catch(FormException $errors ){

        }

        if((!validaCPF($this->cpf) && $acao!="atualiza") || trim($this->cpf)=="") {
            $errors->addError("informe um CPF válido");
        }
        if(sizeof($errors->getErrors())>0)
            throw $errors;

    }
}
?>