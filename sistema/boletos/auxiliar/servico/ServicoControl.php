<?php
class ServicoControl extends Control{

	public function index(){
		$includes = array();
		$servicoDAO = new ServicoDAO();
		$servicos = $servicoDAO->listar();
		$includes = array(new IncludeView('servico.lista.php','',''));
		require_once('../base/conteudo.php');
	}

	public function cadastrar(){
		$servicoDAO = new ServicoDAO();
		
		$departamentos = $servicoDAO->listarDepartamentos();
		$campos = $servicoDAO->listarCampos();
		$servico = new Servico();
		
		$includes = array(new IncludeView('servico.form.php','servico','inserir'));
		require_once('../base/conteudo.php');
	}
	
	public function detalhe(){
		$servicoDAO = new ServicoDAO();
		$departamentos = $servicoDAO->listarDepartamentos();
		$campos = $servicoDAO->listarCampos();
		$servico = $servicoDAO->selectPorId($_GET['valor']);
		$includes = array(new IncludeView('servico.form.php','servico','atualizar'));
		require_once('../base/conteudo.php');
	}

	public function inserir(){
		$servico = $this->popula();
		$servicoDAO = new ServicoDAO();
		try{
			$servicoDAO->beginTrans();
			$servico->id_servico = $servicoDAO->inserir($servico);
			$servicoDAO->commit();
		}catch(Exception $erro){
			$erros[] = $erro->getMessage();
			$servicoDAO->rollBack();
			$includes = array(new IncludeView('servico.form.php','servico','inserir'));
			require_once('../base/conteudo.php');
		}
		$this->redir('servico','index');
	}
	
	public function atualizar(){
		$servico = $this->popula();
		$servicoDAO = new ServicoDAO();
		$servicoDAO->atualizar($servico);
		$this->redir('servico','index');
	}
	
	public function novoCampo(){
		$servicoDAO = new ServicoDAO();
		$campos = $servicoDAO->listarCampos();
		$n=$_GET['valor'];
		require_once('campo.form.php');
	}
	
	public function lista(){
		$servicoDAO = new ServicoDAO();
		$servicos = $servicoDAO->listar();
		echo '<pre>';
		foreach($servicos as $s){
			$s->campos = $servicoDAO->listarCamposUF($s->id_servico);
			if($s->campos[0]->ordenacao > $s->campos[1]->ordenacao){
				echo "\nO ESTADO ESTÁ DEPOIS\n";
				print_r($s->campos);
				$aux = $s->campos[0]->ordenacao;
				$s->campos[0]->ordenacao = $s->campos[1]->ordenacao;
				$s->campos[1]->ordenacao = $aux;
				foreach($s->campos as $c)
				$servicoDAO->atzOrdenacao($c);
			}
		}
//		print_r($servicos);
		echo '</pre>';		
	}
	
	private function popula(){
		
		$servico = new Servico();
		$servico->id_servico = $_POST['id_servico'];
		$servico->id_departamento = $_POST['id_departamento'];
		$servico->status = $_POST['status'];
		$servico->site = $_POST['site'];//?1:0;
		$servico->descricao = $_POST['descricao'];
		$servico->servico_desc = $_POST['servico_desc'];
		$servico->desc_site = $_POST['desc_site'];
		$servico->site_menu = $_POST['site_menu'];
		
		$servico->remCampos = explode(',',$_POST['remCampos']);
		$n=1;
		foreach($_POST['campo_campo'] as $i=>$campo){
			$c = new stdClass();
			$c->id_servico_campo = $_POST['id_servico_campo'][$i];
			$c->id_servico = $_POST['id_servico'];
			$c->campo=$campo;
			$c->nome=$_POST['campo_nome'][$i];
			$c->tipo='text';
			$c->largura=470;
			$c->site=($_POST['campo_site'][$i])?1:0;
			$c->obrigatorio=($_POST['campo_obrigatorio'][$i])?1:0;
			$c->ordenacao=$n;
			$servico->addCampo($c);
			$n++;
		}
		return $servico;
	}
	
	
}

?>