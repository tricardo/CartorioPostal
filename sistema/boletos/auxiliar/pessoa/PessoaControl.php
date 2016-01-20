<?php

/**
 * controle das a��es relacionadas a pessoas no sistema
 */
class PessoaControl extends Control {

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
        $pessoa = $this->populaPessoa("post");
        $tipo = $_POST['tipo'];
        if($tipo=="F") $pessoaDAO = new PessoaFisicaDAO();
        elseif($tipo=="J") $pessoaDAO = new PessoaJuridicaDAO();
        try {
            //se usuário logado, cria senha aleatória
            if(login()) {
                $pessoa->senha = senhaAleatoria();
                $pessoa->confSenha = $pessoa->senha;
            }
            $pessoa->valida("insere");
            $senha = $pessoa->senha;
            $pessoa->codificaSenha();
            $pessoa->id = $pessoaDAO->inserir($pessoa);

            if($pessoa->email!="" && ($pessoa->cliente || $pessoa->funcionario || $pessoa->fornecedor)) {
                $email = new EmailControl("bemvindo",array("nome"=>$pessoa->nome,"usuario"=>$pessoa->usuario,"senha"=>$senha),"Cadastro No Sistema");
                $email->destinatario = $pessoa;
                $email->sendEmail();
            }

            if($pessoa->idPessoa!='') {
                $tipo = ($pessoa->contato)?'contato':'empresa';
                $pessoaDAO->atualizarRelacao($pessoa->idPessoa, $pessoa->id, $tipo);
            }

            include('../header/variaveis.php');

            if ($pessoa->contato || $pessoa->empresa)
                $this->redir('pessoa', 'detalhe', array('valor'=>$pessoa->idPessoa));
            else
               $this->redir('pessoa', 'detalhe', array('valor'=>$pessoa->id));

        }catch(FormException $erro) {
            $telefoneControl = new TelefoneDAO();
            $tiposTelefone = $telefoneControl->listarTipos();

            $profissaoControl = new ProfissaoDAO();
            $profissoes = $profissaoControl->listar();

            $erros = $erro->getErrors();

            if(!$pessoa->contato && !$pessoa->empresa) $include = new IncludeView('pessoa.form.php','insere','pessoa');
            elseif($pessoa->contato) $include = new IncludeView('contato.form.php','insere','pessoa');
            elseif($pessoa->empresa) $include = new IncludeView('empresa.form.php','insere','pessoa');

            $valor=$_POST["valor"];
            $includes = array($include);
            require_once("../paginas/content.php");
        }

    }

    /**
     * Exibe detalhes de uma pessoa
     *
     * @param String $usuario
     */
    public function detalhe($usuario=null, $erros=null) {
        $pessoaDAO = new PessoaDAO();
        if($usuario==null) {
            if($_GET["valor"]!="") {
                $usuario=$_GET["valor"];
            }elseif($_SESSION["usuario"]->usuario!="") {
                $usuario=$_SESSION["usuario"]->usuario;
            }
        }

        if($usuario=="") {
            $erros[]="Informe o usuário";
        }
        try {
            if(($usuario*2)>$usuario)
                $pessoa = $pessoaDAO->selectById($usuario);
            else
                $pessoa = $pessoaDAO->selectUser($usuario);
        }catch (FormException $erros ) {
            $pessoa = new PessoaFisica();
            $erros = $erros->getErrors();
        }

        $telefoneDAO = new TelefoneDAO();
        $tiposTelefone = $telefoneDAO->listarTipos();

        $profissaoControl = new ProfissaoDAO();
        $profissoes = $profissaoControl->listar();

        $veiculos = $pessoa->veiculos;

        if(!$pessoa->contato && !$pessoa->empresa) $include = new IncludeView('pessoa.form.php','atualizar','pessoa');
        elseif($pessoa->contato) $include = new IncludeView('contato.form.php','atualizar','pessoa');
        elseif($pessoa->empresa) $include = new IncludeView('empresa.form.php','atualizar','pessoa');

        $include2 = new IncludeView('veiculo.list.php','','veiculo');
        $includes = array($include, $include2);
        
        require_once("../paginas/content.php");
        
    }


    /**
     * Exibe detalhes de uma pessoa
     *
     * @param String $usuario
     */
    public function ver() {
        $pessoaDAO = new PessoaDAO();

        $usuario=$_GET["valor"];

        if($usuario=="") $erros[]="Informe o usuário";
        try {
            $pessoa = $pessoaDAO->selectById($usuario);
        }catch (FormException $erros ) {
            $pessoa = new PessoaFisica();
            $erros = $erros->getErrors();
        }

        $telefoneDAO = new TelefoneDAO();
        $tiposTelefone = $telefoneDAO->listarTipos();

        $profissaoControl = new ProfissaoDAO();
        $profissoes = $profissaoControl->listar();

        $include = new IncludeView('pessoa.ver.php','','pessoa');

        $includes = array($include);
        require_once("../paginas/content.php");
    }

    /**
     * atualiza os dados de uma pessoa no bd
     *
     */
    public function atualizar() {
        $pessoa = $this->populaPessoa("atualizar");
        $tipo = $_POST["tipo"];
        if($tipo=="F")
            $pessoaDAO = new PessoaFisicaDAO();
        elseif($tipo=="J")
            $pessoaDAO = new PessoaJuridicaDAO();
        try {
            $pessoa->valida("atualizar");
            $pessoaDAO->atualizar($pessoa);

        }catch(FormException $erro ) {
            $erros = $erro->getErrors();
            $telefoneControl = new TelefoneControl();

            if(!$pessoa->contato && !$pessoa->empresa) $include = new IncludeView('pessoa.form.php','atualizar','pessoa');
            elseif($pessoa->contato) $include = new IncludeView('contato.form.php','atualizar','pessoa');
            elseif($pessoa->empresa) $include = new IncludeView('empresa.form.php','atualizar','pessoa');

            $includes = array($include);

            $telefoneDAO = new TelefoneDAO();
            $tiposTelefone = $telefoneDAO->listarTipos();

            require_once("../paginas/content.php");
            return;
        }
        $this->redir('pessoa', 'detalhe', array('valor'=>$pessoa->id));
    }

    /**
     * prepara o formul�rio para cadastrar uma pessoa
     *
     */
    public function cadastrar() {
        $pessoa = new PessoaFisica();
        $pessoa->tipo ="F";
        $valor = $_GET['valor'];

        $pessoa->cliente = ($valor=='cliente')?1:0;
        $pessoa->fornecedor = ($valor=='fornecedor')?1:0;
        $pessoa->funcionario = ($valor=='funcionario')?1:0;
        $pessoa->outros = ($valor=='outros')?1:0;
        $pessoa->empresa = ($valor=='empresa')?1:0;
        $pessoa->contato = ($valor=='contato')?1:0;

        $pessoa->telefones=array(new Telefone());

        $pessoa->idPessoa = $_GET['idPessoa'];
        if ($pessoa->idPessoa!= "") {
            $pessoaDAO = new PessoaDAO();
            $cliente = $pessoaDAO->selectById($pessoa->idPessoa);
        }
       
        if($pessoa->contato) $include1 = new IncludeView('contato.form.php','insere','pessoa');
        elseif($pessoa->empresa) $include1 = new IncludeView('empresa.form.php','insere','pessoa');
        else $include1 = new IncludeView('pessoa.form.php','insere','pessoa');

        $includes = array($include1);
        require_once('../base/conteudo.php');
    }

    /**
     * lista todas as pessoas
     *
     */
    public function listar() {
        $pessoaDAO = new PessoaDAO();
        $pagina=($_GET['pagina']=='')?null:$_GET['pagina'];
        $pessoas = $pessoaDAO->listarPessoasOficina($_GET['valor'], $pagina);
        $include = new IncludeView('pessoa.pag.php','','pessoa');
        $includes = array($include);
        require_once('../paginas/content.php');
    }


    public function apagar() {
        //TODO implementar eclus�o de pessoas
    }


    /**
     * popula um objeto Pessoa com os dados do post, e retorna PFisica, ou PJuridica
     * @return Pessoa
     */
    private function populaPessoa($vars) {
        $vars = ($vars=='get')?$_GET:$_POST;
        $tipo = $vars['tipo'];

        if($tipo=="F") {
            $pessoa = new PessoaFisica();
            $pessoa->cpf =formatDBCPF($vars['cpf']);
            $pessoa->nascimento = $vars['nascimento'];
            $pessoa->sexo = $vars['sexo'];
            $pessoa->idProfissao =$vars['idProfissao'];
        }elseif($tipo=="J") {
            $pessoa = new PessoaJuridica();
            $pessoa->cnpj = $vars['cnpj'];
            $pessoa->inscEstadual = $vars['inscEstadual'];
            $pessoa->ccm = $vars['ccm'];
        }else $pessoa = new Pessoa();

        $pessoa->id = $vars['id'];
        $pessoa->senha = $vars['senha'];
        $pessoa->usuario = $vars['usuario'];
        $pessoa->confSenha = $vars['confSenha'];
        $pessoa->email=$vars['email'];
        $pessoa->tipo=$vars['tipo'];

        $pessoa->cliente=($vars['cliente'])?1:0;
        $pessoa->fornecedor=($vars['fornecedor'])?1:0;
        $pessoa->funcionario=($vars['funcionario'])?$vars['funcionario']:0;
        $pessoa->produtivo=($vars['produtivo'])? 1:0;

        $pessoa->idPessoa = $vars['idPessoa'];
        $pessoa->outros=($vars['outros'] || $vars['contato'] || $vars['empresa'])?1:0;
        $pessoa->contato=($vars['contato'])?1:0;
        $pessoa->empresa=($vars['empresa'])?1:0;

        $pessoa->idempresa = ($vars['idempresa']!='')?$vars['idempresa']:null;
        $pessoa->idcontato = ($vars['idcontato']!='')?$vars['idcontato']:null;

        $pessoa->nome = strtoupper($vars['nome']);
        $pessoa->idresiduo = strtoupper($vars['idresiduo']);
        $pessoa->limitecredito = $vars['limitecredito'];
        $pessoa->ativo = ($vars['ativo'])? 1:0;
        $pessoa->inadimplente = $vars['inadimplente'];

        $pessoa->idEmpresa = $vars['idEmpresa'];

        if(is_array($_POST['endereco']))
            foreach($_POST['endereco'] as $tipo=>$enderecoR) {
                $endereco = new Endereco();
                $endereco->tipo = $tipo;
                $endereco->endereco = strtoupper($enderecoR);
                $endereco->compl = strtoupper($vars['compl'][$tipo]);
                $endereco->numero = ($vars['numero']=="")?null:strtoupper($vars['numero'][$tipo]);
                $endereco->cep = $vars['cep'][$tipo];
                $endereco->bairro = strtoupper($vars['bairro'][$tipo]);
                $endereco->cidade = strtoupper($vars['cidade'][$tipo]);
                $endereco->uf = strtoupper($vars['uf'][$tipo]);

                $pessoa->addEndereco($tipo,$endereco);
            }

        if(isset($_POST['telNumero']))
            foreach($_POST['telNumero'] as $i=>$numero) {
                $telefone = new Telefone();
                $telefone->numero=eregi_replace('[^0-9]','',$numero);
                $telefone->ddd = trim($_POST['ddd'][$i]);
                $telefone->ramal = $_POST['ramal'][$i];
                $telefone->idTipoTelefone = trim($_POST['idTipoTelefone'][$i]);
                $telefone->id = $_POST['idTelefone'][$i];
                $telefone->obs = $_POST['obs'][$i];
                if($numero=="" && $this->ddd=="" && $this->idTipoTelefone=="") continue;
                $pessoa->addTelefone($telefone);
            }

        return $pessoa;
    }

    /**
     * carrega o formul�rio para buscar pessoas
     *
     */
    public function busca() {
        $pessoa = new Pessoa();
        $valor = $_GET['valor'];
        $include = new IncludeView('pessoa.busca.php','buscar/'.$valor,'pessoa');
        $includes = array($include);
        require_once('../paginas/content.php');
    }

    /**
     * Faz a pesquisa de pessoas
     */
    public function buscar() {
        $orcamento = ($_GET['valor']=='orcamento');
        if($orcamento) {
            $busca='orcamento';
            $vars='get';
        }else $vars='post';
        $pessoa = $this->populaPessoa($vars);

        $pessoaDAO = new PessoaDAO();
        $pessoas = $pessoaDAO->buscaPessoas($pessoa);

        $include1 = new IncludeView('pessoa.busca.php','buscar/'.$_GET['valor'],'pessoa');
        $include2 = new IncludeView('pessoa.list.php','','pessoa');
        $includes = array($include1,$include2);
        if(count($pessoas)<1)$alertas=array('nenhum registro encontrado');
        require_once('../paginas/content.php');

    }

    public function buscarEmpresa() {
        $_GET['nome'] = $_GET['valor'];
        $_GET['tipo']='J';
        $vars='get';
        $pessoa = $this->populaPessoa($vars);
        $pessoaDAO = new PessoaDAO();
        $pessoas = $pessoaDAO->buscaPessoas($pessoa);
        $busca = 'empresa';
        $include2 = new IncludeView('pessoa.list.php','','pessoa');
        $includes = array($include2);
        if(count($pessoas)<1)$alertas=array('nenhum registro encontrado');
        require_once('../paginas/content.php');
    }

    /**
     * envio de email para o usu�rio
     * @return unknown_type
     */
    public function email() {
        try {
            $pessoaDAO = new PessoaDAO();
            $pessoa = $pessoaDAO->selectUser($_GET['valor']);
            $submit = 'pessoa/enviarEmail';
            $include2 = new IncludeView('pessoa.email.php','enviarEmail','pessoa');
            $includes = array($include2);
        }catch (FormException $erros ) {
            $erros = $erros->getErrors();
            $includes = array();
        }
        require_once('../paginas/content.php');
    }

    public function enviarEmail() {
        $mailer = new phpmailer();
        $pessoa = $this->populaPessoa($_POST);
        $mailer->AddAddress($pessoa->email,$pessoa->nome);
        $mailer->Body = $_POST['mensagem'];
        $mailer->Send();
        $mensagens[]='Email enviado para '.$pessoa->email;
        $includes = array();
        require_once('../paginas/content.php');
    }

    public function novoTel() {
        $telefoneControl = new TelefoneDAO();
        $tiposTelefone = $telefoneControl->listarTipos();
        $telefone = new Telefone();
        $n=$_GET['valor'];
        include('telefone_unit.form.php');
    }

    public function verificaCPF() {
        $pessoaDAO = new PessoaDAO();
        $pessoa = new PessoaFisica();
        $pessoa->cpf=$_GET['valor'];
        $pessoas = $pessoaDAO->buscaPessoas($pessoa);

        echo json_encode($pessoas);
    }

    public function trocarSenha(){
        if($_POST['submit']){
            $p = $_SESSION['usuario'];
            $pessoaDAO = new PessoaDAO();
            try{
                echo $p->usuario." / ".$_POST['senhaAtual'];
                $p = $pessoaDAO->login($p->usuario, $_POST['senhaAtual']);
                if($_POST['novaSenha']==$_POST['confirmacao'] && $_POST['novaSenha']!=''){
                    $p->senha = $_POST['novaSenha'];
                    $pessoaDAO->atualizarSenha($p);
                }else throw new FormException('Confirme a senha');
            }catch (FormException $erro){
                $erros= $erro->getErrors();
            }
            $includes = array(new IncludeView('trocaSenha.form.php','trocarSenha','pessoa'));
            require_once('../paginas/content.php');
        }else{
            $includes = array(new IncludeView('trocaSenha.form.php','trocarSenha','pessoa'));
            require_once('../paginas/content.php');
        }
    }
}
?>
