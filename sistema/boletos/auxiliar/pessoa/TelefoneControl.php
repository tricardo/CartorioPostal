<?php

class TelefoneControl extends Control {

    /**
     * construtor
     *
     */
    public function __construct() {
        parent::__construct();
    } 

    /**
     * Insere no banco de dados os dados enviados
     */
    public function insere() {
        $telefones = $this->popula();
        $controlDAO = new $controlDAO();
        try {
            $control->valida("insere");
            $control->id = $controlDAO->inserir($control);
            $this->detalhe($control->campoChave);
        }catch(FormException $erro ) {
            $erros = $erro->getErrors();
            $include = new IncludeView("$control.form.php","insere","$control");
            $valor=$_POST["valor"];
            $includes = array($include);
            require_once("../paginas/content.php");
        }
    }

    private function popula() {
        $telefones = array();
        foreach($_POST["telefones"] as $telefone) {
            $telefones[]=eregi_replace('[^0-9]','',$telefone);
        }
        $ddds = $_POST["ddds"];
        $obss = $_POST["obs"];
        $ramais = $_POST["ramais"];
    }

    /**
     * lista todas as pessoas
     *
     */
    public function listar($idPessoa=null) {
        $idPessoa=($idPessoa==null)?$_GET["valor"]:$idPessoa;
        $telefoneDAO = new TelefoneDAO();

        if($idPessoa=="") $telefones = array(new Telefone());
        else {
            $telefones = $telefoneDAO->listaPorPessoa($idPessoa);
        }
        $tiposTelefone = $telefoneDAO->listarTipos();
        $include = new IncludeView("telefone.form.php","","");
        $includes = array($include);

        require("../paginas/conteudoDiv.php");

    }

    /**
     * carrega o formul�rio para buscar
     *
     */
    public function busca() {    }

    public function mostraForm() {
        $include = new IncludeView("telefone_unit.form.php","","");
        $includes = array($include);
        require_once("../paginas/content.php");
    }


    /**
     * Faz a pesquisa no BD
     */
    public function buscar() {
        $include = new IncludeView(".list.php","","");
        $includes = array($include);
        if(count($pessoas)<1)$alertas=array("nenhum registro encontrado");
        require_once("../paginas/content.php");
    }

    public function listarTiposJSON() {
        $telefoneDAO = new TelefoneDAO();
        $tipos = $telefoneDAO->listarTipos();
        echo json_encode($tipos);
    }
}
?>
