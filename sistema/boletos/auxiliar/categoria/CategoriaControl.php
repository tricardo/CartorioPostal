<?php
class CategoriaControl extends Control{
	
	
	public function __construct(){ }

	public function index(){
		$this->listar();
	}
	
	/**
	 * lista de todos as categorias
	 * @return 
	 */
	public function listar($mensagens=array()){
		$categorias = array();	
		$categoriaDAO = new CategoriaDAO();
		$categorias = $categoriaDAO->listar();
		$includes[] = new IncludeView('categoria.lista.php','','');
		if($msg!="") $mensagens[]=$msg;
		include_once("../base/conteudo.php");
	}
	
	/**
	 * lista de todos as sub-categorias da cat passada como parâmetro
	 * @return 
	 */
	public function listarSubsJSON(){
		$categorias = array();	
		$categoriaDAO = new CategoriaDAO();

		$categorias = $categoriaDAO->listarSubCategorias($_GET["valor"]);
		echo json_encode($categorias);
	}
	
	/**
	 * lista todas as categorias superiores
	 * @return 
	 */
	public function listarSupsJSON(){
		$categorias = array();	
		$categoriaDAO = new CategoriaDAO();
		$categorias = $categoriaDAO->listaSupCategorias();
		echo json_encode($categorias);
	}
	
	/**
	 * carrega o formulário para cadastrar
	 * @return 
	 */
	public function cadastrar(){
		$categoria = $this->popula();
		if($_GET['valor']=="tipo" && $categoria->idSupCategoria==null) $categoria->idSupCategoria='0';
		$categoriaDAO = new CategoriaDAO();
		$categorias = $categoriaDAO->listaSupCategorias();
		$includes[] = new IncludeView('categoria.form.php','categoria','inserir');
		include_once('../base/conteudo.php');
	}
	
	public function inserir(){ 
		$categoria = $this->popula();
		try{
			$categoriaDAO = new CategoriaDAO();
			$categoria->valida("inserir");
			$categoria->id = $categoriaDAO->inserir($categoria);
			$includes=array();
			global $ajax;
			if(!$ajax) $this->listar(array('Cadastro realizado!'));
			else{
				$_GET['valor']=$categoria->id;
				$this->detalhe(array('Cadastro realizado!'));
			}
		}catch(ExceptionList $erros){
			$erros = $erros->getErros();
			$categorias = $categoriaDAO->listaSupCategorias();
			$includes[] = new IncludeView('categoria.form.php','categoria','inserir');
			include_once('../base/conteudo.php');
		}
	}
	
	public function detalhe($mensagens=array()){ 
		$id = $_GET['valor'];
		$categoriaDAO = new CategoriaDAO();
		$categoria = $categoriaDAO->selectById($id);
		
		$categorias = $categoriaDAO->listaSupCategorias();
		
		$includes[] = new IncludeView('categoria.form.php','categoria','atualizar');
		include_once('../base/conteudo.php');
	}
	
	public function atualizar(){ 
		$categoria = $this->popula();
		try{
			$categoria->valida("atualizar");
			$categoriaDAO = new CategoriaDAO();
			$categoriaDAO->atualizar($categoria);
			$includes=array();
		}catch(ExceptionList $erros){
			$erros = $erros->getErros();
			$includes[] = new IncludeView('categoria.form.php','categoria','atualizar');
			include_once('../base/conteudo.php');
		}
		$this->listar(array('cadastro atualizado!'));
	}
	
	public function excluir(){ 
		$categoria = new Categoria();
		$categoria->id = $_GET['valor'];
		$categoriaDAO = new CategoriaDAO();
		$categoriaDAO->desativar($categoria);
		
		$this->listar(array('registro excluído'));
	}
	
	private function popula(){
		$categoria = new Categoria();
		$categoria->nome = $_POST['nome'];
		$categoria->id = $_POST["id"];
		$categoria->idSupCategoria =$_POST['idSupCategoria'];		
		return $categoria;
	}
}
?>